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
      <?php foreach($events as $event): ?>
        <div
            class="agenda__item"
            data-key="<?= $event->keyword ?>"
        >
          <?php echo $event->title ?>
        </div>
      <?php endforeach ?>
    </div>
  </div>
<?php else: ?>
<?php endif ?>
