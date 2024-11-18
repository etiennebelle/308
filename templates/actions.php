<?php
  use Inc\Layout\Layout;
  use Inc\Cpt\Actions;

  $actions = Actions::getActions();
  $rows_count = Layout::getAdjustedRowsCount();
?>

<?php if (!empty($actions)) : ?>
  <div class="grid grid--4">
    <div class="col-span-1">
      <ul class="actions__nav">
        <?php foreach ($actions as $i => $action) : ?>
          <li
            class="actions__nav__item row row--<?= esc_attr($rows_count); ?>"
            data-key="<?= esc_attr($action["name"]); ?>"
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
    <div class="col-span-3">
      <div class="actions">
        <div class="actions__container actions__container--<?= esc_attr($rows_count); ?>">
          <?php foreach ($actions as $i => $action) : ?>
            <div
              class="actions__slide"
              data-key="<?= esc_attr($action["name"]); ?>"
              style="background: <?= esc_attr($action["background"]); ?>;"
            >
              <div class="grid grid--3">
                <div class="col-span-1">1</div>
                <div class="col-span-2">2</div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>
