<?php
  use Layout\Layout;
  use Cpt\Sections;

  get_header();
  $open_default = get_field('index_active_section');
  $rows_count = Layout::get_adjusted_rows_count();
  $sections = Sections::get_sections();
?>

<main id="main" class="main main--<?= esc_attr($rows_count) ?>">
  <?php if($sections->have_posts()): ?>
    <?php while($sections->have_posts()): ?>
      <?php
        $sections->the_post();
        $name = get_post()->post_name;
        $title = get_the_title();
        $is_active = ($name === $open_default ? 'section--active' : '');
      ?>
      <section
          id="<?= esc_attr($name) ?>"
          class="section section--<?= esc_attr($rows_count); ?> <?= esc_attr($is_active); ?>"
          data-name="<?= esc_attr($name); ?>"
          data-index="<?= esc_attr($sections->current_post + 1); ?>"
      >
        <div
            id="<?= esc_attr($name) ?>__heading"
            class="section__heading row row--<?= esc_attr($rows_count); ?>"
        >
          <?php for($j = 0; $j < 2; $j++) : ?>
            <h2 class="section__heading__title col-<?= ($j + 1) * 2 - 1 ?>-start<?= $j % 2 === 1 ? ' only:lg' : ''; ?>">
              <span class="headline headline-xl"><?= esc_html($title); ?></span>
            </h2>
          <?php endfor ?>
          <div class="section__heading__control col-2-start ctrl:prev<?= $name != 'agenda' ? ' only:md' : ''; ?>">
            <?php include 'components/svg/arrow-prev.svg'; ?>
          </div>
          <div class="section__heading__control col-4-start ctrl:next<?= $name != 'agenda' ? ' only:md' : ''; ?>">
            <?php include 'components/svg/arrow-next.svg'; ?>
          </div>
        </div>

        <div
            id="<?= esc_attr($name) ?>__content"
            class="section__content container container--<?= esc_attr($rows_count); ?>"
        >
          <?php include locate_template('templates/' . $name . '.php'); ?>
        </div>
      </section>
    <?php endwhile ?>
    <?php wp_reset_postdata(); ?>
  <?php endif ?>
</main>

<?php get_footer(); ?>
