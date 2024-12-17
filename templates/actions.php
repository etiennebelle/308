<?php
  use Inc\Actions;

  global $rows_count;
  $actions = Actions::getActions();
?>

<?php if(!empty($actions)) : ?>
  <div class="u-carousel">
    <div class="u-carousel__wrapper">
      <?php foreach ($actions as $i => $action)
        render_action($action, true);
      ?>
    </div>
  </div>

  <div class="grid grid-cols-4">
    <div class="a-nav col-span-1">
      <ul class="a-list">
        <?php foreach ($actions as $i => $action) : ?>
          <li
            class="a-item row row--<?= esc_attr($rows_count); ?>"
            data-key="<?= esc_attr(rtrim($action["name"], 's')); ?>"
            data-index="<?= esc_attr($i + 1); ?>"
            style="background: <?= esc_attr($action["background"]); ?>;"
          >
            <h3 class="headline headline-xl">
              <?= esc_html(ucfirst($action['title'])); ?>
            </h3>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="a-carousel col-span-3 only:lg">
      <div class="a-carousel__wrapper a-carousel__wrapper--<?= esc_attr($rows_count); ?>">
        <?php foreach ($actions as $i => $action)
          render_action($action, false);
        ?>
      </div>
    </div>
  </div>
<?php endif ?>

<?php
  function render_action($action, $is_mobile = false): void
  {
    [
      'title' => $title,
      'richtext' => $richtext,
      'background' => $background,
      'image' => [
        'action_image_url' => $image_url,
        'action_image_credits' => $image_credits,
        'action_image_credits_display' => $image_credits_display,
      ],
      'file' => [
        'action_file_title' => $file_title,
        'action_file_url' => $file_url,
      ],
    ] = $action;

    global $rows_count;

    $base_class = $is_mobile ? 'u-carousel' : 'a-carousel';
    $slide_class = $is_mobile ? "{$base_class}__slide" : "{$base_class}__slide {$base_class}__slide--" . esc_attr($rows_count);
    ?>

    <div
      class="<?= esc_attr($slide_class); ?>"
      data-key="<?= esc_attr(rtrim($action["name"], 's')); ?>"
      style="background: <?= esc_attr($background); ?>;"
    >
      <div class="<?= esc_attr($base_class); ?>__infos">
        <?php if ($is_mobile): ?>
          <button
            class="btn-expand"
            role="button"
            aria-expanded="false"
            aria-controls="<?= esc_attr($base_class); ?>__details"
            type="button"
          >
            <span class="body body-xl">+</span>
          </button>
        <?php endif; ?>

        <?php if ($is_mobile): ?>
        <div class="<?= esc_attr($base_class); ?>__container">
          <div class="<?= esc_attr($base_class); ?>__header">
            <h4 class="<?= esc_attr($base_class); ?>__title">
              <span class="body body-xl"><?= esc_html($title); ?></span>
            </h4>
          </div>
          <?php endif; ?>

          <div class="<?= esc_attr($base_class); ?>__details" aria-hidden="true">
            <div class="<?= esc_attr($base_class); ?>__richtext">
              <div class="body body-md"><?= wp_kses_post($richtext); ?></div>
            </div>
            <?php if (!empty($file_url)): ?>
              <div class="<?= esc_attr($base_class); ?>__file">
                <a href="<?= esc_url($file_url); ?>" target="_blank">
                  <span class="body body-md body-link"><?= esc_html($file_title); ?></span>
                </a>
              </div>
            <?php endif; ?>
          </div>

          <?php if ($is_mobile): ?>
        </div>
      <?php endif; ?>
      </div>

      <div class="<?= esc_attr($base_class); ?>__media">
        <img
          class="<?= esc_attr($base_class); ?>__image"
          src="<?= esc_url($image_url) ?>"
          alt="<?= esc_attr($title) ?>"
          loading="lazy"
        >
        <?php if (!$is_mobile && $image_credits_display): ?>
          <div
            class="<?= esc_attr($base_class); ?>__credits"
            style="background: <?= esc_attr($background); ?>;"
          >
            <span class="body body-sm"><?= esc_html($image_credits); ?></span>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php
  }
?>

