<?php
  namespace Layout;

  class Layout {
    public static function get_post_count($post_type): int{
      $count = wp_count_posts($post_type);
      return isset($count->publish) ? (int)$count->publish : 0;
    }

    public static function get_sections_count(): int{
      return self::get_post_count('sections');
    }

    public static function get_actions_count(): int{
      return self::get_post_count('actions');
    }

    public static function get_rows_count(): int{
      $total = self::get_sections_count() + self::get_actions_count();
      return $total > 0 ? $total : 1;
    }

    public static function get_adjusted_rows_count(): int {
      return self::get_rows_count() + 1;
    }
  }
