<?php
  namespace Inc\Agenda;
  class Event
  {
    private const LANG_FR = 'fr';
    private const LINK_CLASS = 'body-ul';

    public int $id;
    public string $title;
    public string $keyword;
    public array $links;
    public string $shortText;
    public string $richText;
    public array $location;
    public string $imageUrl;
    public string $imageCredits;

    public string $startDate;
    public string $startTime;
    public string $endDate;
    public int $durationDays;
    public string $dateDisplay;

    public string $contentColor;
    public string $backgroundColor;

    private array $relatedEvents = [];

    /**
    * Event constructor.
    *
    * @param array $event The event data from the API.
    * @param array $agendaColors The colors associated with different agenda categories.
    */
    public function __construct(array $event, array $agendaColors)
    {
      $this->id = $event['uid'];
      $this->title = ucwords($event['title'][self::LANG_FR]);
      $this->keyword = $event['keywords'][self::LANG_FR][0];
      $this->links = $event['links'];
      $this->shortText = $event['description'][self::LANG_FR];
      $this->richText = $this->formatRichText($event['longDescription'][self::LANG_FR], $this->links);
      $this->location = [
        'name' => $event['location']['name'] ?? '',
        'address' => $event['location']['address'] ?? '',
      ];
      $this->imageUrl = $this->buildImageUrl($event['image']);
      $this->imageCredits = $event['imageCredits'];
      $this->startDate = $this->formatDate($event['firstTiming']['begin']);
      $this->startTime = $this->formatTime($event['firstTiming']['begin']);
      $this->endDate = $this->formatDate($event['lastTiming']['end']);
      $this->durationDays = $this->calculateDuration($event['firstTiming']['begin'], $event['lastTiming']['end']);
      $this->setDateDisplay($this->startDate, $this->startTime, $this->endDate, $this->durationDays, $this->keyword);
      $this->setColors($agendaColors);
      $this->setRelatedEventsFromACF($this->id);
    }

    /**
     * A bit of a hacky technique for retrieving events linked to a cycle,
     * as OpenAgenda doesn't allow them to be grouped under a single event.
     * We retrieve the ID returned by the api. On the WP side, add the IDs of the parent cycle
     * and those of the child events to the repeater. Default relatedEvents is an empty array
     *
     * @param int $id
     * @return void
     *
     */
    private function setRelatedEventsFromACF(int $id): void {
      if (have_rows('agenda_cycles')) {
        while (have_rows('agenda_cycles')) {
          the_row();
          $acf_id = (int) get_sub_field('cycle_id');
          $related = get_sub_field('cycle_events');

          if (!empty($related) && $acf_id == $id) {
            $this->relatedEvents = array_merge($this->relatedEvents, $related);
          }
        }
      }
    }

    /**
     * Getter to retrieve related Events
     *
     * @return array
     */
    public function getRelatedEvents(): array
    {
      return $this->relatedEvents;
    }

    /**
    * Formats the rich text description, replacing links with anchor tags.
    *
    * The method takes the raw rich text description and the array of links,
    * and returns the formatted rich text with the links embedded as HTML anchor tags.
    *
    * @param string $richText The raw rich text description.
    * @param array $links An array of links to include in the rich text.
    *
    * @return string The formatted rich text with links.
    */
    private function formatRichText(string $richText, array $links): string
    {
      $text = str_replace('*', '', $richText);

      if (!empty($links)) {
        $pattern = '/\[(.*?)]\((http[^)]+)\)/';
        $i = 0;

        $text = preg_replace_callback($pattern, function($matches) use ($links, &$i) {
          if (isset($links[$i])) {
            $url = $links[$i]['link'];
            $i++;
            return '<a class="' . self::LINK_CLASS . '" href="' . $url . '" target="_blank">' . $matches[1] . '</a>';
          }
          return $matches[1];
        }, $text);
      } else {
        $text = preg_replace('/\[([^]]+)]/', '$1', $text);
      }

      return $text;
    }

    /**
    * Builds the image URL for the event.
    *
    * @param array $image The image data.
    *
    * @return string The full URL of the event's image.
    */
    private function buildImageUrl(array $image): string
    {
      return isset($image['base'], $image['filename']) ? $image['base'] . $image['filename'] : '';
    }

    /**
    * Formats a date string into the specified format.
    *
    * @param string $dateString The raw date string.
    *
    * @return string The formatted date.
    */

    private function formatDate(string $dateString): string
    {
      return $this->formatDateTime($dateString, 'd-m-Y', '.');
    }

    /**
    * Formats a time string into the specified format.
    *
    * @param string $dateString The raw date string.
    *
    * @return string The formatted time.
    */
    private function formatTime(string $dateString): string
    {
      return $this->formatDateTime($dateString, 'H:i', 'h');
    }

    /**
    * Helper function to format both dates and times.
    *
    * @param string $dateString The raw date string.
    * @param string $format The format for the output string.
    * @param string $replace Optional character to replace certain symbols.
    *
    * @return string The formatted date/time.
    */
    private function formatDateTime(string $dateString, string $format, string $replace = ''): string
    {
      $date = new \DateTime($dateString);
      return str_replace([':', '-'], $replace, $date->format($format));
    }

    /**
    * Calculates the duration of the event in days.
    *
    * @param string $startDateString The start date of the event.
    * @param string $endDateString The end date of the event.
    *
    * @return int The duration of the event in days.
    */
    private function calculateDuration(string $startDateString, string $endDateString): int
    {
      $startDate = new \DateTime($startDateString);
      $endDate = new \DateTime($endDateString);
      $interval = $startDate->diff($endDate);
      return intval($interval->format('%a'));
    }

    /**
    * Sets the display format for the event's date based on its duration and keyword.
    *
    * @param string $startDate The event's start date.
    * @param string $startTime The event's start time.
    * @param string $endDate The event's end date.
    * @param int $durationDays The duration of the event in days.
    * @param string $keyword The keyword associated with the event.
    */

    private function setDateDisplay(string $startDate, string $startTime, string $endDate, int $durationDays, string $keyword): void
    {
      if (in_array(strtolower($keyword), ['radio', 'conferences'])) {
        $this->dateDisplay = "{$startDate} → {$startTime}";
      } elseif ($durationDays > 0) {
        $this->dateDisplay = "{$startDate} → {$endDate}";
      } else {
        $this->dateDisplay = $startDate;
      }
    }

    /**
    * Sets the event's colors based on its keyword.
    * Keyword has to match post type action's name
    *
    * @param array $agendaColors The colors for different categories of events.
    */
    private function setColors(array $agendaColors): void
    {
      $color = $agendaColors[strtolower($this->keyword)] ?? null;
      $this->contentColor = $color['color'] ?? '#000000';
      $this->backgroundColor = $color['background'] ?? '#FFFFFF';
    }
  }