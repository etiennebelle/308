<?php
  use Inc\Cpt\Sections;

  get_header();

  global $rows_count;
  $open_default = get_field('index_active_section');
  $sections = Sections::getSections();
?>
<main id="main" class="main main--<?= esc_attr($rows_count) ?>">
  <?php if($sections->have_posts()): ?>
    <?php while($sections->have_posts()): ?>
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
          <?php for($i = 0; $i < 2; $i++) : ?>
            <h2 class="section__heading__title col-<?= ($i + 1) * 2 - 1 ?>-start<?= $i % 2 === 1 ? ' only:lg' : ''; ?>">
              <span class="headline headline-xl"><?= esc_html($title); ?></span>
            </h2>
          <?php endfor ?>
          <div class="section__heading__control col-2-start ctrl--prev<?= $key != 'agenda' ? ' only:md' : ''; ?>">
            <?php include 'components/svg/arrow-prev.svg'; ?>
          </div>
          <div class="section__heading__control col-4-start ctrl--next<?= $key != 'agenda' ? ' only:md' : ''; ?>">
            <?php include 'components/svg/arrow-next.svg'; ?>
          </div>
        </div>

        <div
            id="<?= esc_attr($key) ?>__content"
            class="section__content container container--<?= esc_attr($rows_count); ?>"
        >
          <?php include locate_template('templates/' . $key . '.php'); ?>
        </div>
      </section>
    <?php endwhile ?>
    <?php wp_reset_postdata(); ?>
  <?php endif ?>
</main>

<?php get_footer(); ?>
