<?php
  namespace Cpt;

  abstract class Cpt {
    protected static string $postType = '';

    public static function get_posts(): \WP_Query {
      return new \WP_Query([
        'post_type' => static::$postType,
        'posts_per_page' => -1,
      ]);
    }

    abstract protected static function format_post_data(\WP_Post $post): array;
  }

  abstract class Sections extends Cpt {
    protected static string $postType = 'sections';

    public static function get_sections_query(): \WP_Query {
      return static::get_posts();
    }
  }

  class Actions extends Cpt {
    protected static string $postType = 'actions';

    protected static function format_post_data(\WP_Post $post): array {
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

    public static function get_actions(): array {
      $query = static::get_posts();
      $actions = [];

      if ($query->have_posts()) {
        while ($query->have_posts()) {
          $query->the_post();
          global $post;
          $actions[] = static::format_post_data($post);
        }
        wp_reset_postdata();
      }

      return $actions;
    }

    public static function get_actions_colors(): array {
      $actions = static::get_actions();
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