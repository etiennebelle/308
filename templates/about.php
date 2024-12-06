<div class="carousel">
  <div class="carousel__wrapper">
    <?php if (have_rows('about_infos')): ?>
      <div class="carousel__slide col-span-1">
        <div class="carousel__slide__container">
            <ul class="carousel__list">
              <?php while (have_rows('about_infos')): the_row();
                $about_infos_header = get_sub_field('about_infos_logo') ?? null;
                $about_infos = [
                  'logo' => ($about_infos_header === 'logo') && file_exists(get_template_directory() . '/components/svg/logo.svg')
                    ? get_template_directory() . '/components/svg/logo.svg'
                    : null,
                  'name' => $about_infos_header === 'name' ? get_sub_field('about_infos_name') : "",
                  'address' => get_sub_field('about_infos_address'),
                  'phone' => get_sub_field('about_infos_phone'),
                  'mail' => get_sub_field('about_infos_mail'),
                  'visit' => get_sub_field('about_infos_visit'),
                  'entrance' => get_sub_field('about_infos_entrance'),
                  'opening_days' => get_sub_field('about_infos_opening_days'),
                  'opening_hours' => get_sub_field('about_infos_opening_hours'),
                ];
                ?>
                <?php foreach ($about_infos as $key => $value):
                  $class = in_array($key, ['logo', 'name', 'address', 'mail', 'visit']) ? 'carousel__item carousel__item--mb' : 'carousel__item';
                  ?>
                  <?php if ($key === 'logo' && isset($value) && file_exists($value)): ?>
                    <li class="<?= $class ?>">
                      <div class="carousel__logo">
                        <?php include $value; ?>
                      </div>
                    </li>
                  <?php elseif (!empty($value)): ?>
                    <?php if (is_string($value)): ?>
                      <li class="<?= $class ?>">
                        <p class="body body-xl <?= $key == "mail" ? "body-link" : "" ?>">
                          <?php if ($key == "mail"): ?>
                            <a href="mailto: <?= esc_url($value); ?>" class="carousel__link">
                              <span><?= esc_html($value); ?></span>
                            </a>
                          <?php else: ?>
                            <?= wp_kses_post($value); ?>
                          <?php endif ?>
                        </p>
                      </li>
                    <?php elseif (is_array($value)): ?>
                      <li class="<?= $class ?>">
                        <ul class="carousel__list">
                          <?php foreach ($value as $repeater_field): ?>
                            <?php if (!empty($repeater_field['about_infos_visit_transport'])): ?>
                              <li class="carousel__item">
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
        </div>
      </div>
    <?php endif ?>

    <?php if(!empty(get_field('about_richtext'))): ?>
      <?php $about_richtext = parseRichText(get_field('about_richtext')); ?>
      <div class="carousel__slide col-span-1">
        <div class="carousel__slide__container">
          <div class="carousel__field">
            <div class="body body-md"><?= wp_kses_post($about_richtext) ?></div>
          </div>
        </div>
      </div>
    <?php endif ?>

    <div class="carousel__slide col-span-1">
      <div class="carousel__slide__container">
        <?php if(have_rows('about_office')):
            $about_office_label = get_field_object('about_office')['label'];
          ?>
          <h4 class="carousel__title">
            <span class="body body-md body-up"><?= esc_html($about_office_label); ?></span>
          </h4>
          <ul class="carousel__list">
            <?php while (have_rows('about_office')):
              the_row();
              $about_office_name = get_sub_field('about_office_name');
              $about_office_job = get_sub_field('about_office_job');
            ?>
              <li class="carousel__item">
                <p class="body body-md"><?= esc_html($about_office_name); ?>,</p>
                <p class="body body-md"><?= esc_html($about_office_job); ?></p>
              </li>
            <?php endwhile ?>
          </ul>
        <?php endif ?>
        <?php if(have_rows('about_partners')):
            $about_partners_label = get_field_object('about_partners')['label'];
          ?>
          <h4 class="carousel__title">
            <span class="body body-md body-up"><?= esc_html($about_partners_label); ?></span>
          </h4>
          <ul class="carousel__list">
            <?php while (have_rows('about_partners')):
              the_row();
              $about_partners_name = get_sub_field('about_partners_name');
              $about_partners_url = get_sub_field('about_partners_url');
            ?>
              <li class="carousel__item">
                <a class="carousel__link" href="<?= esc_url($about_partners_url); ?>" target="_blank">
                  <p class="body body-md body-link"><?= esc_html($about_partners_name); ?></p>
                </a>
              </li>
            <?php endwhile ?>
          </ul>
        <?php endif ?>
      </div>
    </div>

    <?php if(have_rows('about_files')):
      $about_files_label = get_field_object('about_files')['label'];
    ?>
    <div class="carousel__slide col-span-1">
      <div class="carousel__slide__container">
        <h4 class="carousel__title">
          <span class="body body-md body-up"><?= esc_html($about_files_label); ?></span>
        </h4>
        <ul class="carousel__list">
          <?php while (have_rows('about_files')):
            the_row();
            $about_files_title = get_sub_field('about_file_title');
            $about_files_url = get_sub_field('about_file_url');
          ?>
            <li class="carousel__item">
              <a class="carousel__link" href="<?= esc_url($about_files_url); ?>" target="_blank">
                <span class="body body-md body-link"><?= esc_html($about_files_title); ?></span>
              </a>
            </li>
          <?php endwhile ?>
        </ul>
      </div>
    </div>
    <?php endif ?>
  </div>
</div>