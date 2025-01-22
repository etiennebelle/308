<div class="g-carousel">
  <div class="g-carousel__wrapper">
    <?php if(have_rows('mentions')): ?>
      <?php while(have_rows('mentions')):
        the_row();

        $roles = [];
        if(have_rows('mentions_roles')){
          while(have_rows('mentions_roles')){
            the_row();
            $roles[] = [
                'name' => get_sub_field('mentions_roles_item_name'),
                'job' => get_sub_field('mentions_roles_item_job'),
            ];
          }
        }

        $mention_column_primary = [
          [
            'title' => get_sub_field_object('mentions_editor')['label'],
            'content' => parseRichText(get_sub_field('mentions_editor')),
            'roles' => $roles,
          ],
          [
            'title' => get_sub_field_object('mentions_web_hosting')['label'],
            'content' => parseRichText(get_sub_field('mentions_web_hosting'))
          ],
          [
            'title' => get_sub_field_object('mentions_radio_hosting')['label'],
            'content' => parseRichText(get_sub_field('mentions_radio_hosting'))
          ]
        ];

        $mention_column_secondary = [
          [
            'title' => get_sub_field_object('mentions_design')['label'],
            'content' => parseRichText(get_sub_field('mentions_design'))
          ],
          [
            'title' => get_sub_field_object('mentions_dev')['label'],
            'content' => parseRichText(get_sub_field('mentions_dev'))
          ]
        ];

        render_carousel_column($mention_column_primary);
        render_carousel_column($mention_column_secondary);
      ?>
      <?php endwhile ?>
    <?php endif ?>

    <?php if(have_rows('legals')): ?>
      <?php while(have_rows('legals')):
        the_row();

        $legals_column_primary = [
          [
            'title' => get_sub_field_object('legals_gdpr')['label'],
            'content' => parseRichText(get_sub_field('legals_gdpr'))
          ]
        ];

        $legals_column_secondary = [
          [
            'title' => get_sub_field_object('legals_copyright')['label'],
            'content' => parseRichText(get_sub_field('legals_copyright'))
          ]
        ];

        render_carousel_column($legals_column_primary);
        render_carousel_column($legals_column_secondary);
      ?>
      <?php endwhile ?>
    <?php endif ?>
  </div>
</div>

<?php
function render_carousel_column(array $fields): void
{ ?>
  <div class="g-carousel__slide col-span-1">
    <div class="g-carousel__container">
      <?php foreach ($fields as $field): ?>
        <?php if(isset($field['title'])): ?>
          <h4 class="g-carousel__title">
            <span class="body body-md body-up"><?= esc_html($field['title']); ?></span>
          </h4>
        <?php endif ?>
        <?php if(isset($field['content'])): ?>
          <div class="g-carousel__field">
            <div class="body body-md"><?= wp_kses_post($field['content']); ?></div>
          </div>
        <?php endif ?>

        <?php if(!empty($field['roles'])): ?>
          <ul class="g-carousel__list">
            <?php foreach ($field['roles'] as $role): ?>
              <li class="g-carousel__item">
                <p class="body body-md"><?= esc_html($role['job']) . ': ' . esc_html($role['name']); ?></p>
              </li>
            <?php endforeach ?>
          </ul>
        <?php endif ?>
      <?php endforeach ?>
    </div>
  </div>
<?php } ?>