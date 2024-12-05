<?php

  function parseRichText($text, $args = []): string {
    $defaults = [
      'link_class' => 'body body-alt body-md body-up body-link',
      'external_only' => false,
      'add_blank' => true
    ];
    $settings = wp_parse_args($args, $defaults);

    $text = apply_filters('the_content', $text);

    return preg_replace_callback(
      '/<a\b([^>]*)>/',
      function($matches) use ($settings) {
        $link = $matches[0];
        $is_external = !str_contains($link, home_url());

        if (
          (!$settings['external_only'] || $is_external) &&
          !strpos($link, 'class=')
        ) {
          $link = str_replace(
            '<a ',
            sprintf('<a class="%s" %s ',
              $settings['link_class'],
              $settings['add_blank'] && $is_external ? 'target="_blank"' : ''
            ),
            $link
          );
        }
        return $link;
      },
      $text
    );
  }