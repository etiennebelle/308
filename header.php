<?php
  use Inc\Layout;
  use Inc\Actions;

  global $rows_count;
  $rows_count = Layout::getAdjustedRowsCount();

  global $colors;
  $colors = Actions::getActionsColors();

  $header_title = get_field('header_title');
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <?php wp_head(); ?>
  <style>
    :root{
        --sections: <?= Layout::getSectionsCount(); ?>;
        --actions: <?= Layout::getActionsCount(); ?>;
    }
  </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
  <div class="header__wrapper row row--<?= esc_attr($rows_count) ?>">
    <div class="header__col col-1-start">
      <h1 class="header__title headline headline-xl headline-lt headline-up"><?= esc_html($header_title); ?></h1>
    </div>
    <div class="header__col col-3-start only:lg">
      <h2 class="header__title headline headline-xl headline-lt headline-up"><?= esc_html($header_title); ?></h2>
    </div>
  </div>
</header>
