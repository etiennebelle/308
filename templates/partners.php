<?php
  $ordered_keys = ['club', 'partnership', 'network', 'friends'];
?>

<div class="g-carousel">
  <div class="g-carousel__wrapper">
    <?php foreach($ordered_keys as $key): ?>
        <?php if($key != 'partnership'): ?>
          <?php render_list($key); ?>
        <?php else: ?>
          <?php if(have_rows('partnership')): ?>
            <div class="g-carousel__slide col-span-1">
              <div class="g-carousel__container">
                <?php while(have_rows('partnership')):
                  the_row();
                  $title = get_sub_field('partnership_title');
                  $richtext = get_sub_field('partnership_richtext');
                  $cta = get_sub_field('partnership_cta');
                  $mail_url = get_sub_field('partnership_mail');
                  ?>
                  <?php if(!empty($title)): ?>
                    <h4 class="g-carousel__field">
                      <span class="body body-md body-up"><?= esc_html($title); ?></span>
                    </h4>
                  <?php endif ?>
                  <?php if(!empty($richtext)): ?>
                    <div class="g-carousel__field">
                      <p class="body body-md"><?= esc_html($richtext); ?></p>
                    </div>
                  <?php endif ?>
                  <div class="g-carousel__cta">
                    <a class="btn btn-out btn-up btn-mt" href="mailto:<?= esc_url($mail_url); ?>" >
                      <span class="body body-md body-up"><?= esc_html($cta); ?></span>
                    </a>
                  </div>
                <?php endwhile ?>
              </div>
            </div>
          <?php endif ?>
        <?php endif ?>
      <?php endforeach ?>
  </div>
</div>

<?php
  function render_list($key): void
  {
    if(have_rows($key)): ?>
      <div class="g-carousel__slide col-span-1">
        <div class="g-carousel__container">
          <?php while(have_rows($key)):
            the_row();
            $title = get_sub_field("{$key}_title");
          ?>
            <h4 class="g-carousel__title">
              <span class="body body-md body-up"><?= esc_html($title); ?></span>
            </h4>
            <?php if(have_rows("{$key}_list")): ?>
              <ul class="g-carousel__list">
                <?php while(have_rows("{$key}_list")):
                  the_row();
                  $item_name = get_sub_field("{$key}_list_item_name");
                  $item_url = get_sub_field("{$key}_list_item_url");
                ?>
                  <li class="g-carousel__item">
                    <a class="g-carousel__link" href="<?= esc_url($item_url); ?>" target="_blank">
                      <p class="body body-md body-link"><?= esc_html($item_name); ?></p>
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