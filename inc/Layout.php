<?php
  namespace Inc;

  class Layout {
    public static function getPostCount($post_type): int{
      $count = wp_count_posts($post_type);
      return isset($count->publish) ? (int)$count->publish : 0;
    }

    public static function getSectionsCount(): int{
      return self::getPostCount('sections');
    }

    public static function getActionsCount(): int{
      return self::getPostCount('actions');
    }

    public static function getRowsCount(): int{
      $total = self::getSectionsCount() + self::getActionsCount();
      return $total > 0 ? $total : 1;
    }

    public static function getAdjustedRowsCount(): int {
      return self::getRowsCount() + 1;
    }
  }
