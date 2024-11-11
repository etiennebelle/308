<?php
  use Layout\Layout;
  use Cpt\Sections;

  get_header();

  $rows_count = Layout::get_adjusted_rows_count();
  $sections = Sections::get_sections_query();
?>

<main id="main">
  <h1 class="headline headline-xl only:xl">Vite</h1>
  <h1 class="headline headline-xl only:md">Vite</h1>
</main>

<?php get_footer(); ?>
