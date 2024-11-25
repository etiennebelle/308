<?php
  foreach (glob(__DIR__ . "/inc/*") as $filename) {
    if (!is_dir($filename)) {
      require_once($filename);
    }
  }

  function parseRichText($text): array|string|null
  {
    $LINK_CLASS = "body-ul";
    return preg_replace(
      '#<a\b(?![^>]*class=)#',
      '<a class="' . $LINK_CLASS . '" target="_blank"',
      apply_filters('the_content', $text)
    );
  }