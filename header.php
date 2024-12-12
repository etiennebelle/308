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
    <?php for($i = 0; $i < 2; $i++) : ?>
      <div class="header__col col-<?= ($i + 1) * 2 - 1 ?>-start<?= $i % 2 === 1 ? ' only:lg' : ''; ?>">
        <h1 class="header__title headline headline-xl headline-lt headline-up"><?= esc_html($header_title); ?></h1>
      </div>
    <?php endfor ?>
  </div>
</header>

<?php
  /**
   * @param string $field_name
   * @param int $rows_count
   */

  function render_menu(string $field_name, int $rows_count): void{
    if(have_rows($field_name)) {
      while(have_rows($field_name)) {
        the_row();
        $sub_field = rtrim($field_name, 's');
        if (get_sub_field("{$sub_field}_display")){
          $title = get_sub_field("{$sub_field}_name");
          $url = get_sub_field("{$sub_field}_url");
          ?>
          <li class="header__menu__title row row--<?= esc_attr($rows_count) ?>">
            <div class="header__menu__icon">
              <?php include 'components/svg/arrow-next.svg'; ?>
            </div>
            <a class="header__menu__link col-full" href="<?= esc_url($url) ?>" target="_blank">
              <span class="headline headline-xl headline-lt headline-up"><?= esc_html($title) ?></span>
            </a>
          </li>
          <?php
        }
      }
    }
  }
?>
