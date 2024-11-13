<?php
  namespace Inc\Agenda;

  use Inc\Agenda\Event;

  class Agenda
  {
    private string $apiUrl;
    private string $apiKey;
    private string $agendaUid;
    private array $agendaColors;

    /**
     * Agenda constructor.
     *
     * @param string $agendaUid The unique identifier for the agenda.
     * @param string $apiKey The API key for accessing the OpenAgenda API.
     * @param array $agendaColors An array of colors used for different agenda categories.
     */
    public function __construct(string $agendaUid, string $apiKey, array $agendaColors)
    {
      $this->apiUrl = "https://api.openagenda.com/v2/agendas";
      $this->agendaUid = $agendaUid;
      $this->apiKey = $apiKey;
      $this->agendaColors = $agendaColors;
    }

    /**
     * Retrieves events from the OpenAgenda API.
     *
     * @return array|null An array of Event objects, or null if there was an error.
     */
    public function getEvents(): ?array
    {
      $url = "{$this->apiUrl}/{$this->agendaUid}/events?detailed=1&relative[]=upcoming&key={$this->apiKey}";
      $res = wp_remote_get($url);

      if (is_wp_error($res)) {
        error_log('Erreur lors de la récupération des événements : ' . $res->get_error_message());
        return null;
      }

      $eventsData = json_decode(wp_remote_retrieve_body($res), true);
      return array_map(fn($event) => new Event($event, $this->agendaColors), $eventsData['events']);
    }
  }

