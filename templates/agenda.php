<?php
  use Inc\Agenda\Agenda;
  use Inc\Cpt\Actions;

  $agendaColors = Actions::getActionsColors();
  $agenda = new Agenda($_ENV['AGENDA_UID'], $_ENV['AGENDA_API_KEY'], $agendaColors);
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
  <div class="agenda--void">
    <?php
      $agenda_void_message = get_field('agenda_void_text');
      $agenda_void_img = get_field('agenda_void_img');
    ?>
  </div>
<?php endif ?>

<?php
  function render_event($event): void
  {
    ?>
    <div
        class="agenda__item"
        data-key="<?= $event->keyword ?>"
        style="background: <?= $event->backgroundColor ?>"
    >
      <div class="agenda__item__infos">

        <div class="agenda__item__header">
          <div class="agenda__item__key">
            <span class="body body-xl body-ul body-up only:lg"><?= ucfirst(rtrim($event->keyword, "s")); ?></span>
            <span class="body body-md body-ul body-up only:sm"><?= ucfirst(rtrim($event->keyword, "s")); ?></span>
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
        </div>

        <div class="agenda__item__details">
          <div class="agenda__item__catchphrase">
            <p class="body body-md"><?= nl2br($event->shortText); ?></p>
          </div>
          <div class="agenda__item__richtext">
            <p class="body body-md"><?= nl2br($event->richText); ?></p>
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
