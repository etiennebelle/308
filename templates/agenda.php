<?php
  use Inc\Agenda\Agenda;

  global $colors;
  $agenda = new Agenda($_ENV['AGENDA_UID'], $_ENV['AGENDA_API_KEY'], $colors);
  $events = $agenda->getEvents();
?>

<?php if(!empty($events)): ?>
  <div class="agenda">
    <div class="agenda__container">
      <?php foreach($events as $event) {
        render_event($event);
      } ?>
    </div>
  </div>
<?php else: ?>
  <div class="agenda--void"></div>
<?php endif ?>

<?php
  function render_event($event): void
  {
    $singularKeyword = rtrim($event->keyword, "s");
    ?>
    <div
        class="agenda__item"
        data-id="<?= esc_attr($event->id); ?>"
        data-key="<?= esc_attr($singularKeyword); ?>"
        style="background: <?= $event->backgroundColor ?>"
    >
      <div class="agenda__item__infos">
        <button
            class="mobile-expand"
            aria-expanded="false"
            aria-controls="agenda__item__details"
            type="button"
        >
          <span class="body body-xl">+</span>
        </button>
        <div class="agenda__item__container">

          <div class="agenda__item__header">
            <div class="agenda__item__key">
              <span class="body body-xl body-ul body-up only:lg"><?= ucfirst($singularKeyword); ?></span>
              <span class="body body-md body-ul body-up only:sm"><?= ucfirst($singularKeyword); ?></span>
            </div>

            <div class="agenda__item__date">
              <span class="body body-xl"><?= $event->dateDisplay; ?></span>
            </div>

            <h4 class="agenda__item__title"><span class="body body-xl"><?= $event->title; ?></span></h4>

            <div class="agenda__item__location">
              <?php foreach($event->location as $location_part): ?>
                <p class="body body-md"><?= $location_part; ?></p>
              <?php endforeach ?>
            </div>

            <?php if($singularKeyword === 'cycle'): ?>
            <div class="agenda__item__related">
              <?php if(!empty($event->getRelatedEvents())): ?>
                <ul>
                  <?php foreach($event->getRelatedEvents() as $related_event): ?>
                    <li
                        class="cycle__related__event"
                        data-id="<?= esc_attr($related_event['cycle_event_id']) ?? ''; ?>"
                    >
                      <span class="body body-md"><?= $related_event['cycle_event_name'] ?? '' ?></span>
                    </li>
                  <?php endforeach ?>
                </ul>
              <?php endif ?>
            </div>
            <?php endif ?>
          </div>

          <div class="agenda__item__details" aria-hidden="true">
            <div class="agenda__item__catchphrase">
              <p class="body body-md"><?= nl2br($event->shortText); ?></p>
            </div>
            <div class="agenda__item__richtext">
              <p class="body body-md"><?= nl2br($event->richText); ?></p>
            </div>
          </div>
        </div>
      </div>

      <div class="agenda__item__media">
        <img class="agenda__item__media__image" src="<?= esc_url($event->imageUrl) ?>" alt="<?= $event->title ?>" loading="lazy" />
      </div>
    </div>
    <?php
  }
?>
