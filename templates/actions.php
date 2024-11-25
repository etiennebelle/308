<?php
  use Inc\Cpt\Actions;

  global $rows_count;
  $actions = Actions::getActions();
?>

<?php if (!empty($actions)) : ?>
  <div class="grid grid-cols-4">
    <div class="actions__nav col-span-1">
      <ul class="actions__list">
        <?php foreach ($actions as $i => $action) : ?>
          <li
            class="actions__item row row--<?= esc_attr($rows_count); ?>"
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

    <div class="actions__carousel col-span-3 only:lg">
      <div class="actions__wrapper actions__wrapper--<?= esc_attr($rows_count); ?>">
        <?php foreach ($actions as $i => $action)
          render_action($action);
        ?>
      </div>
    </div>
  </div>
<?php endif ?>

<?php
  function render_action($action): void
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
    ] = $action;
    global $rows_count;
  ?>
    <div
      class="actions__slide actions__slide--<?= esc_attr($rows_count); ?>"
      data-key="<?= esc_attr(rtrim($action["name"], 's')); ?>"
      style="background: <?= esc_attr($background); ?>;"
    >
      <div class="actions__slide__infos">
        <div class="actions__slide__richtext">
          <div class="body body-md">
           <?= $richtext ?>
          </div>
        </div>
      </div>
      <div class="actions__slide__media">
        <img class="actions__slide__image" src="<?= esc_url($image_url) ?>" alt="<?= esc_attr($title) ?>" loading="lazy">
        <?php if($image_credits_display): ?>
          <div class="actions__slide__credits" style="background: <?= esc_attr($background); ?>">
            <span class="body body-sm"><?= esc_html($image_credits); ?></span>
          </div>
        <?php endif ?>
      </div>
    </div>
    <?php
  }
?>