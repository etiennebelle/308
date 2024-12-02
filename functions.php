<?php
  use Inc\Newsletter;
  use JetBrains\PhpStorm\NoReturn;

  foreach (glob(__DIR__ . "/inc/*") as $filename) {
    if (!is_dir($filename)) {
      require_once($filename);
    }
  }

  add_action('wp_ajax_subscribe_to_newsletter', 'handle_newsletter_subscription');
  add_action('wp_ajax_nopriv_subscribe_to_newsletter', 'handle_newsletter_subscription');

  #[NoReturn] function handle_newsletter_subscription(): void
  {
    $email = sanitize_email($_POST['email']);
    if(!is_email($email)) {
      wp_send_json_error(['message' => 'Invalid email']);
    }

    $newsletter = new Newsletter();
    $result = $newsletter->subscribe($email);

    if($result) {
      wp_send_json_success(['message' => 'Success']);
    } else {
      wp_send_json_error(['message' => 'Error']);
    }

    wp_die();
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