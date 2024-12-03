<?php
  $partners_lists = [
    'club' => get_field('club'),
    'network' => get_field('network'),
    'friends' => get_field('friends')
  ];
?>

<div class="carousel">
  <div class="carousel__wrapper">
    <?php
      foreach($partners_lists as $key => $list){
        render_list($key);
      }
    ?>

    <?php if(have_rows('partnership')): ?>
    <div class="carousel__slide col-span-1">
      <div class="carousel__slide__container">
        <?php while(have_rows('partnership')):
          the_row();
          $title = get_sub_field('partnership_title');
          $mail_url = get_sub_field('partnership_mail');
        ?>
          <h4 class="carousel__cta">
            <a class="btn btn-out btn-up" href="mailto:<?= esc_url($mail_url); ?>" >
              <span class="body body-md body-up"><?= esc_html($title); ?></span>
            </a>
          </h4>
        <?php endwhile ?>
      </div>
    </div>
    <?php endif ?>
  </div>
</div>

<?php
  function render_list($key): void
  {
    if(have_rows($key)): ?>
      <div class="carousel__slide col-span-1">
        <div class="carousel__slide__container">
          <?php while(have_rows($key)):
            the_row();
            $title = get_sub_field("{$key}_title");
          ?>
            <h4 class="carousel__title">
              <span class="body body-md body-up"><?= esc_html($title); ?></span>
            </h4>
            <?php if(have_rows("{$key}_list")): ?>
              <ul class="carousel__list">
                <?php while(have_rows("{$key}_list")):
                  the_row();
                  $item_name = get_sub_field("{$key}_list_item_name");
                  $item_url = get_sub_field("{$key}_list_item_url");
                ?>
                  <li class="carousel__item">
                    <a class="carousel__link" href="<?= esc_url($item_url); ?>" target="_blank">
                      <p class="body body-md"><?= esc_html($item_name); ?></p>
                    </a>
                  </li>
                <?php endwhile ?>
              </ul>
            <?php endif ?>
          <?php endwhile ?>
        </div>
      </div>
    <?php endif;
  } ?>