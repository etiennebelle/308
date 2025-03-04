<?php
  use Inc\Agenda;

  global $colors;
  $agenda = new Agenda($_ENV['AGENDA_UID'], $_ENV['AGENDA_API_KEY'], $colors);
  $events = $agenda->getEvents();

  $void_message = get_field('agenda_void_text');
  ['name' => $void_img_alt, 'value' => $void_img_url] = get_field_object("agenda_void_img");
  $void_img_credits = get_field("agenda_void_img_credits");
?>

<?php if(!empty($events)): ?>
  <div class="u-carousel">
    <div class="u-carousel__wrapper">
      <?php foreach($events as $event) {
        if (!empty($event->keyword) && isset($event->id)):
          render_event($event);
        endif;
      } ?>
    </div>
  </div>
<?php else: ?>
  <div class="u-carousel">
    <div class="u-carousel__wrapper">
      <div class="u-carousel__slide">
        <div class="u-carousel__infos">
          <div class="u-carousel__container">
            <?php if(isset($void_message)): ?>
            <p class="body body-md body-lt"><?= esc_html($void_message); ?></p>
            <?php endif ?>
          </div>
        </div>
        <div class="u-carousel__media">
          <?php if(isset($void_img_url)): ?>
          <img class="u-carousel__image" src="<?= esc_url($void_img_url); ?>" alt="<?= esc_attr($void_img_alt); ?>"/>
            <?php if(!empty($void_img_credits)): ?>
            <div class="u-carousel__credits">
              <span class="body body-sm body-lt"><?= esc_html($void_img_credits); ?></span>
            </div>
            <?php endif ?>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>

<?php
  function render_event($event): void
  {
    ?>
    <article
        class="u-carousel__slide"
        data-id="<?= esc_attr($event->id); ?>"
        data-key="<?= esc_attr($event->keyword); ?>"
        style="background: <?= esc_attr($event->backgroundColor); ?>"
    >
      <div class="u-carousel__infos">
        <button
            class="btn-expand"
            aria-expanded="false"
            aria-controls="u-carousel__details"
            type="button"
        >
          <span class="body body-xl">+</span>
        </button>
        <div class="u-carousel__container">
          <div class="u-carousel__header">
            <div class="u-carousel__key">
              <span class="body body-xl body-ul body-up only:lg"><?= esc_html(ucfirst($event->keyword)); ?></span>
              <span class="body body-md body-ul body-up only:sm"><?= esc_html(ucfirst($event->keyword)); ?></span>
            </div>
            <?php if(!empty($event->dateDisplay)): ?>
              <div class="u-carousel__date">
                <span class="body body-xl"><?= esc_html($event->dateDisplay); ?></span>
              </div>
            <?php endif ?>

            <?php if(!empty($event->title)): ?>
            <h3 class="u-carousel__title"><span class="body body-xl"><?= esc_html($event->title); ?></span></h3>
            <?php endif ?>

            <?php if(!empty($event->cycle)): ?>
              <div class="u-carousel__cycle">
                <span class="body body-md"><?= esc_html($event->cycle); ?></span>
              </div>
            <?php endif ?>

            <div class="u-carousel__location">
              <?php if(!empty($event->location)): ?>
                <?php foreach($event->location as $location_key): ?>
                  <p class="body body-md"><?= esc_html($location_key); ?></p>
                <?php endforeach ?>
              <?php endif ?>
            </div>
          </div>

          <div class="u-carousel__details" aria-hidden="true">
            <?php if(!empty($event->shortText)): ?>
              <div class="u-carousel__catchphrase">
                <p class="body body-md"><?= wp_kses_post(nl2br($event->shortText)); ?></p>
              </div>
            <?php endif ?>
            <?php if(!empty($event->richText)): ?>
              <div class="u-carousel__richtext">
                <p class="body body-md"><?= wp_kses_post(nl2br($event->richText)); ?></p>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>

      <div class="u-carousel__media">
        <?php if(isset($event->imageUrl)): ?>
        <img class="u-carousel__image" src="<?= esc_url($event->imageUrl) ?>" alt="<?= $event->title ?>" loading="lazy" />
          <?php if(!empty($event->imageCredits)): ?>
          <div class="u-carousel__credits only:lg" style="background: <?= esc_attr($event->backgroundColor); ?>">
            <span class="body body-sm"><?= $event->imageCredits ?></span>
          </div>
          <?php endif ?>
        <?php endif ?>
      </div>
    </article>
    <?php
  }
?>
