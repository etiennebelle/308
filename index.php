<?php
  use Inc\Sections;

  get_header();

  global $rows_count;
  $open_default = get_field('index_active_section');
  $sections = Sections::getSections();

  global $colors;
  $stickers_types = ['radio_player', 'member'];
  $stickers = [];

  foreach ($stickers_types as $type) {
    if (have_rows("sticker_{$type}")) {
      while (have_rows("sticker_{$type}")) {
        the_row();

        $icon_path = get_template_directory() . '/' . ($type === 'radio_player' ? 'components/svg/note.svg' : 'components/svg/heart-out.svg');

        $stickers[$type] = [
          'display' => get_sub_field("sticker_{$type}_display"),
          'url' => get_sub_field("sticker_{$type}_url"),
          'type' => $type === 'radio_player' ? 'audio' : 'link',
          'icon' => file_exists($icon_path) ? $icon_path : null,
          'background' => get_sub_field("sticker_{$type}_color"),
        ];
      }
    }
  }
?>

<main id="main" class="main main--<?= esc_attr($rows_count) ?>">
  <?php if ($sections->have_posts()): ?>
    <?php while ($sections->have_posts()): ?>
      <?php
      $sections->the_post();
      $key = get_post()->post_name;
      $title = get_the_title();
      $is_active = ($key === $open_default ? 'section--active' : '');
      ?>
      <section
          id="<?= esc_attr($key) ?>"
          class="section section--<?= esc_attr($rows_count); ?> <?= esc_attr($is_active); ?>"
          data-key="<?= esc_attr($key); ?>"
          data-index="<?= esc_attr($sections->current_post + 1); ?>"
      >
        <div
            id="<?= esc_attr($key) ?>__heading"
            class="section__heading row row--<?= esc_attr($rows_count); ?>"
        >
          <?php for ($i = 0; $i < 2; $i++): ?>
            <h2 class="section__heading__title col-<?= ($i + 1) * 2 - 1 ?>-start<?= $i % 2 === 1 ? ' only:lg' : ''; ?>">
              <span class="headline headline-xl"><?= esc_html($title); ?></span>
            </h2>
          <?php endfor ?>
          <div class="section__heading__control col-2-start ctrl--prev<?= $key != 'agenda' ? ' only:md' : ''; ?>">
            <?php
              $arrow_prev = get_template_directory() . '/components/svg/arrow-prev.svg';
              if (file_exists($arrow_prev)) {
                include $arrow_prev;
              }
            ?>
          </div>
          <div class="section__heading__control col-4-start ctrl--next<?= $key != 'agenda' ? ' only:md' : ''; ?>">
            <?php
              $arrow_next = get_template_directory() . '/components/svg/arrow-next.svg';
              if (file_exists($arrow_next)) {
                include $arrow_next;
              }
            ?>
          </div>
        </div>

        <div
            id="<?= esc_attr($key) ?>__content"
            class="section__content container container--<?= esc_attr($rows_count); ?>"
        >
          <?php
            $template_path = locate_template('templates/' . $key . '.php');
            if ($template_path && file_exists($template_path)) {
              include $template_path;
            }
          ?>
        </div>
      </section>
    <?php endwhile ?>
    <?php wp_reset_postdata(); ?>
  <?php endif ?>
</main>

<?php foreach ($stickers as $key => $sticker): ?>
  <?php if ($sticker['display'] && isset($sticker['url'])): ?>
    <div
        id="<?= esc_attr($key)?>_sticker"
        class="sticker sticker--rounded"
        style="background: <?= esc_attr($sticker['background'])?>"
    >
      <?php if ($sticker['type'] === "audio"): ?>
        <div class="sticker__icon">
          <?php if ($sticker['icon'] && file_exists($sticker['icon'])): ?>
            <?php include $sticker['icon']; ?>
          <?php endif; ?>
        </div>
        <audio
          id="<?= esc_attr($key); ?>_player"
          src="<?= esc_url($sticker['url']); ?>"
          preload="none"
          style="display: none"
        ></audio>
      <?php else: ?>
        <a href="<?= esc_url($sticker['url']); ?>" target="_blank">
          <div class="sticker__icon">
            <?php if ($sticker['icon'] && file_exists($sticker['icon'])): ?>
              <?php include $sticker['icon']; ?>
            <?php endif; ?>
          </div>
        </a>
      <?php endif ?>
    </div>
  <?php endif ?>
<?php endforeach ?>

<?php get_footer(); ?>
