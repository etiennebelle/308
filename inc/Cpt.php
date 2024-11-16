<?php
  namespace Inc\Cpt;

  abstract class Cpt {
    protected static string $postType = '';

    public static function getPosts(): \WP_Query {
      return new \WP_Query(array(
        'post_type' => static::$postType,
        'posts_per_page' => -1,
        'post_status' => 'publish',
      ));
    }
  }

  class Sections extends Cpt {
    protected static string $postType = 'sections';

    public static function getSections(): \WP_Query {
      return static::getPosts();
    }
  }

  class Actions extends Cpt {
    protected static string $postType = 'actions';

    protected static function formatPost(\WP_Post $post): array {
      return [
        'name' => $post->post_name,
        'title' => get_the_title($post),
        'richtext' => get_field('action_richtext', $post->ID),
        'background' => get_field('action_background', $post->ID),
        'color' => get_field('action_color', $post->ID),
        'image' => get_field('action_image', $post->ID),
        'credits' => get_field('action_credits', $post->ID),
      ];
    }

    public static function getActions(): array {
      $query = static::getPosts();
      $actions = [];

      if ($query->have_posts()) {
        while ($query->have_posts()) {
          $query->the_post();
          $actions[] = static::formatPost($query->post);
        }
        wp_reset_postdata();
      }

      return $actions;
    }

    public static function getActionsColors(): array {
      $actions = static::getActions();
      $colors = [];

      foreach ($actions as $action) {
        $colors[$action['name']] = [
          'background' => $action['background'],
          'color' => $action['color'],
        ];
      }

      return $colors;
    }
  }