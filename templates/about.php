<div class="carousel">
  <div class="carousel__wrapper">
    <div class="carousel__slide col-span-1">
      <div class="carousel__slide__container">
        <?php if (have_rows('about_infos')): ?>
          <ul class="carousel__list">
            <?php while (have_rows('about_infos')): the_row();
              $infos = [
                'name' => get_sub_field('about_infos_name'),
                'address' => get_sub_field('about_infos_address'),
                'phone' => get_sub_field('about_infos_phone'),
                'mail' => get_sub_field('about_infos_mail'),
                'visit' => get_sub_field('about_infos_visit'),
                'entrance' => get_sub_field('about_infos_entrance'),
                'opening_days' => get_sub_field('about_infos_opening_days'),
                'opening_hours' => get_sub_field('about_infos_opening_hours'),
              ];
              ?>
              <?php foreach ($infos as $key => $value):
                $class = in_array($key, ['name', 'address', 'mail', 'visit']) ? ' carousel__item--mb' : null;
                ?>
                <?php if (!empty($value)): ?>
                  <?php if (is_string($value)): ?>
                    <li class="carousel__item<?= $class ?>">
                      <p class="body body-xl">
                        <?php if ($key == "mail"): ?>
                          <a href="mailto: <?= esc_attr($value); ?>" class="carousel__link">
                            <span><?= esc_html($value); ?></span>
                          </a>
                        <?php else: ?>
                          <?= wp_kses_post($value); ?>
                        <?php endif ?>
                      </p>
                    </li>
                  <?php elseif (is_array($value)): ?>
                    <li class="carousel__item<?= $class ?>">
                      <ul class="carousel__list">
                        <?php foreach ($value as $repeater_field): ?>
                          <?php if (!empty($repeater_field['about_infos_visit_transport'])): ?>
                            <li class="carousel__list__item">
                              <p class="body body-xl"><?= wp_kses_post($repeater_field['about_infos_visit_transport']) ?></p>
                            </li>
                          <?php endif ?>
                        <?php endforeach; ?>
                      </ul>
                    </li>
                  <?php endif ?>
                <?php endif ?>
              <?php endforeach ?>
            <?php endwhile ?>
          </ul>
        <?php endif ?>
      </div>
    </div>
    <div class="carousel__slide col-span-1">
      <div class="carousel__slide__container">
        <div class="carousel__field">
          <div class="carousel__field__title"></div>
          <div class="carousel__field__content">
            <div class="body body-md"><?= parseRichText(get_field('about_richtext')); ?></div>
          </div>
        </div>
      </div>
    </div>
    <div class="carousel__slide col-span-1">
      <div class="carousel__slide__container"></div>
    </div>
    <div class="carousel__slide col-span-1">
      <div class="carousel__slide__container"></div>
    </div>
  </div>
</div>