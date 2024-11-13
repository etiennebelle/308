<?php
  use Layout\Layout;
  use Cpt\Actions;

  $actions = Actions::get_actions();
  $rows_count = Layout::get_adjusted_rows_count();
?>

<?php if (!empty($actions)) : ?>
  <div class="grid">
    <div class="col-1/4">
      <ul class="actions__nav">
        <?php foreach ($actions as $i => $action) : ?>
          <li
            class="actions__item row row--<?= esc_attr($rows_count); ?>"
            data-id="<?= esc_attr($action["name"]); ?>"
            data-index="<?= esc_attr($i + 1); ?>"
            style="background: <?= esc_attr($action["background"]); ?>;"
          >
            <h3 class="headline headline-xl" style="color: <?= esc_attr($action['color']); ?>">
              <?= esc_html(ucfirst($action['title'])); ?>
            </h3>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="col-3/4">
      <div class="actions__list">
        <div class="actions__list__container">
          <?php foreach ($actions as $i => $action) : ?>
            <div
              class="actions__list__slide"
              data-id="<?= esc_attr($action["name"]); ?>"
              style="background: <?= esc_attr($action["background"]); ?>;"
            >
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>
