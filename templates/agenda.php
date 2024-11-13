<?php
  use Inc\Agenda\Agenda;
  use Inc\Cpt\Actions;

  $agendaColors = Actions::getActionsColors();
  $agenda = new Agenda($_ENV['AGENDA_UID'], $_ENV['AGENDA_API_KEY'], $agendaColors);
  $events = $agenda->getEvents();

  foreach ($events as $event) {
    echo '<pre>';
    var_dump($event);
    echo '<br/>';
    echo '</pre>';
  }
?>

<div class="carousel">

</div>