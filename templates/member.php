<div class="carousel">
  <div class="carousel__wrapper">
    <?php if(have_rows('membership')): ?>
      <?php while(have_rows('membership')):
        the_row();
        $membership_title = get_sub_field('membership_title');
        $membership_richtext = get_sub_field('membership_richtext');
        $membership_cta_text = get_sub_field('membership_cta_text');
        $membership_cta_url = get_sub_field('membership_cta_url');
      ?>
        <div class="carousel__slide col-span-2">
          <div class="carousel__slide__container">
            <h4 class="carousel__title">
              <span class="body body-xl"><?= esc_html($membership_title); ?></span>
            </h4>
            <div class="carousel__field">
              <p class="body body-md"><?= wp_kses_post($membership_richtext); ?></p>
            </div>
            <div class="carousel__cta">
              <a class="btn btn-out btn-up" href="<?= esc_url($membership_cta_url); ?>" target="_blank">
                <span class="body body-md"><?= esc_html($membership_cta_text); ?></span>
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
        <div class="carousel__slide col-span-2">
          <div class="carousel__slide__container">
            <h4 class="carousel__title">
              <span class="body body-xl"><?= esc_html($newsletter_title); ?></span>
            </h4>
            <div class="carousel__field">
              <p class="body body-md"><?= wp_kses_post($newsletter_richtext); ?></p>
            </div>
            <div class="carousel__form">
              <form action="" method="post" id="form">
                <label for="email"></label>
                <input id="post_id" type="hidden" name="post_id" value="<?= esc_attr(get_the_ID()); ?>">
                <input id="email" type="email" name="email" required="required" class="body body-md" placeholder="<?= esc_attr($newsletter_placeholder); ?>">
                <button class="btn btn-out">
                  <span class="body-alt body-alt-xl">↣</span>
                </button>
              </form>
              <div class="form-message"></div>
            </div>
          </div>
        </div>
      <?php endwhile ?>
    <?php endif ?>
  </div>
</div>