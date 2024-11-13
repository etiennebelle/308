<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
  $rows_count = Inc\Layout\Layout::getAdjustedRowsCount();
  $header_title = get_field('header_title');
  $header_title_min = get_field('header_title_minified');
?>

<header class="header">
  <div class="header__wrapper row row--<?= esc_attr($rows_count) ?>">
    <div class="header__col col-3/4">
      <div class="header__title only:xl">
        <h1 class="headline headline-xl headline-lt headline-up">
          <?= esc_html($header_title); ?>
        </h1>
      </div>
      <div class="header__title only:md">
        <h1 class="headline headline-xl headline-lt headline-up">
          <?= esc_html($header_title_min); ?>
        </h1>
      </div>
    </div>
    <div class="header__col col-1/4">
      <button
          class="header-btn"
          aria-expanded="false"
          aria-controls="header-menu"
          type="button"
      >
        <span class="header-btn__icon">
            <span class="icon:open">
                <?php include 'components/svg/open.svg' ?>
            </span>
            <span class="icon:close">
                <?php include 'components/svg/close.svg' ?>
            </span>
        </span>
      </button>
    </div>
  </div>

  <div id="header-menu" class="header__menu header__menu--<?= esc_attr($rows_count) ?>" aria-hidden="true">
    <nav class="header__menu__nav">
      <ul class="header__menu__nav__list">
        <?php render_menu('header_links', $rows_count); ?>
      </ul>
    </nav>
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
