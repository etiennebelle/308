<?php
  use Inc\Agenda\Agenda;

  global $colors;
  $agenda = new Agenda($_ENV['AGENDA_UID'], $_ENV['AGENDA_API_KEY'], $colors);
  $events = $agenda->getEvents();

  $void_message = get_field('agenda_void_text');
  ['name' => $void_img_alt, 'value' => $void_img_url] = get_field_object("agenda_void_img");
  $void_img_credits = get_field("agenda_void_img_credits");
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
    <div class="agenda__container">
      <div class="agenda__slide">
        <div class="agenda__slide__infos">
          <div class="agenda__slide__container">
            <p class="body body-md body-lt"><?= esc_html($void_message); ?></p>
          </div>
        </div>
        <div class="agenda__slide__media">
          <img class="agenda__slide__media__image" src="<?= esc_url($void_img_url); ?>" alt="<?= esc_attr($void_img_alt); ?>"/>
          <div class="agenda__slide__media__credits">
            <span class="body body-sm body-lt"><?= esc_html($void_img_credits); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>

<?php
  function render_event($event): void
  {
    $singularKeyword = rtrim($event->keyword, "s");
    ?>
    <div
        class="agenda__slide"
        data-id="<?= esc_attr($event->id); ?>"
        data-key="<?= esc_attr($singularKeyword); ?>"
        style="background: <?= esc_attr($event->backgroundColor); ?>"
    >
      <div class="agenda__slide__infos">
        <button
            class="mobile-expand"
            aria-expanded="false"
            aria-controls="agenda__slide__details"
            type="button"
        >
          <span class="body body-xl">+</span>
        </button>
        <div class="agenda__slide__container">

          <div class="agenda__slide__header">
            <div class="agenda__slide__key">
              <span class="body body-xl body-ul body-up only:lg"><?= ucfirst($singularKeyword); ?></span>
              <span class="body body-md body-ul body-up only:sm"><?= ucfirst($singularKeyword); ?></span>
            </div>

            <div class="agenda__slide__date">
              <span class="body body-xl"><?= $event->dateDisplay; ?></span>
            </div>

            <h4 class="agenda__slide__title"><span class="body body-xl"><?= $event->title; ?></span></h4>

            <div class="agenda__slide__location">
              <?php foreach($event->location as $location_key): ?>
                <p class="body body-md"><?= $location_key; ?></p>
              <?php endforeach ?>
            </div>
          </div>

          <div class="agenda__slide__details" aria-hidden="true">
            <div class="agenda__slide__catchphrase">
              <p class="body body-md"><?= nl2br($event->shortText); ?></p>
            </div>
            <div class="agenda__slide__richtext">
              <p class="body body-md"><?= nl2br($event->richText); ?></p>
            </div>
          </div>
        </div>
      </div>

      <div class="agenda__slide__media">
        <img class="agenda__slide__media__image" src="<?= esc_url($event->imageUrl) ?>" alt="<?= $event->title ?>" loading="lazy" />
        <div class="agenda__slide__media__credits" style="background: <?= esc_attr($event->backgroundColor); ?>">
          <span class="body body-sm"><?= $event->imageCredits ?></span>
        </div>
      </div>
    </div>
    <?php
  }
?>
