<div class="carousel">
  <div class="carousel__wrapper">
    <?php if(have_rows('membership')): ?>
      <?php while(have_rows('membership')):
        the_row();
        $membership_title = get_sub_field('membership_title');
        $membership_richtext = get_sub_field('membership_richtext');
        $membership_cta_text = get_sub_field('membership_cta_text');
        $membership_cta_url = get_sub_field('membership_cta_url');
        $membership_cta_type = get_sub_field('membership_cta_type');

        $cta_class = $membership_cta_type == 'red'
          ? 'btn btn-mt btn-red btn-up'
          : 'btn btn-mt btn-out btn-up';
      ?>
        <div class="carousel__slide col-span-2">
          <div class="carousel__slide__container">
            <h3 class="carousel__title">
              <span class="body body-xl"><?= esc_html($membership_title); ?></span>
            </h3>
            <div class="carousel__field">
              <p class="body body-md"><?= wp_kses_post($membership_richtext); ?></p>
            </div>
            <div class="carousel__cta">
              <a class="<?= esc_attr($cta_class); ?>" href="<?= esc_url($membership_cta_url); ?>" target="_blank">
                <span class="body body-md"><?= esc_html($membership_cta_text); ?></span>
                <?php
                  $heart_full = get_template_directory() . '/components/svg/heart-full.svg';
                  if (file_exists($heart_full)) {
                    include $heart_full;
                  }
                ?>
              </a>
            </div>
          </div>
        </div>
      <?php endwhile ?>
    <?php endif ?>

    <?php if(have_rows('newsletter')): ?>
      <?php while(have_rows('newsletter')):
        the_row();
        $newsletter_title = get_sub_field('newsletter_title');
        $newsletter_richtext = get_sub_field('newsletter_richtext');
        $newsletter_placeholder = get_sub_field('newsletter_input_placeholder');
      ?>
        <div class="carousel__slide col-span-1">
          <div class="carousel__slide__container">
            <h3 class="carousel__title">
              <span class="body body-xl"><?= esc_html($newsletter_title); ?></span>
            </h3>
            <div class="carousel__field">
              <p class="body body-md"><?= wp_kses_post($newsletter_richtext); ?></p>
            </div>
            <div class="carousel__form">
              <form action="" method="post" id="form">
                <label for="email"></label>
                <input id="post_id" type="hidden" name="post_id" value="<?= esc_attr(get_the_ID()); ?>">
                <input id="email" type="email" name="email" required="required" class="body body-md" placeholder="<?= esc_attr($newsletter_placeholder); ?>" autocomplete="email">
                <button type="submit" class="btn btn-out">
                  <?php
                    $arrow_next = get_template_directory() . '/components/svg/arrow-next.svg';
                    if (file_exists($arrow_next)) {
                      include $arrow_next;
                    }
                  ?>
                </button>
              </form>
              <div class="form-message"></div>
            </div>
          </div>
        </div>
      <?php endwhile ?>
    <?php endif ?>

    <?php if(have_rows('links')): ?>
      <?php while(have_rows('links')):
        the_row();
        $links_title = get_sub_field('links_title');
        $links_richtext = get_sub_field('links_richtext');
        $links = [];
        if(have_rows('links_list')){
          while(have_rows('links_list')){
            the_row();
            $links[] = [
              'title' => get_sub_field('links_list_item_title'),
              'url' => get_sub_field('links_list_item_url'),
            ];
          }
        }
      ?>
        <div class="carousel__slide col-span-1">
          <div class="carousel__slide__container">
            <h3 class="carousel__title">
              <span class="body body-xl"><?= esc_html($links_title); ?></span>
            </h3>
            <?php if(!empty($links_richtext)): ?>
              <div class="carousel__field">
                <p class="body body-md"><?= esc_html($links_richtext); ?></p>
              </div>
            <?php endif ?>
            <?php if(!empty($links)): ?>
              <ul class="carousel__list">
                <?php foreach($links as $link): ?>
                  <li class="carousel__item">
                    <a class="carousel__link" href="<?= esc_url($link['url']); ?>" target="_blank">
                      <span class="body body-md body-link"><?= esc_html($link['title']); ?></span>
                    </a>
                  </li>
                <?php endforeach ?>
              </ul>
            <?php endif ?>
          </div>
        </div>
      <?php endwhile ?>
    <?php endif ?>
  </div>
</div>