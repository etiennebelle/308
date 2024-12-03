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
    $success = 'Merci!';
    $error = 'Une erreur est survenue, veuillez réessayer.';
    $invalid_mail = 'Adresse e-mail invalide.';

    $email = sanitize_email($_POST['email']);
    $post_id = $_POST['post_id'] ?? '';

    if(have_rows('newsletter', $post_id)) {
      while(have_rows('newsletter', $post_id)) {
        the_row();
        $success = get_sub_field('newsletter_message_success', $post_id) ?? $success;
        $error = get_sub_field('newsletter_message_error', $post_id) ?? $error;
        $invalid_mail = get_sub_field('newsletter_message_invalid', $post_id) ?? $invalid_mail;
      }
    }

    if(!is_email($email)) {
      wp_send_json_error(['message' => $invalid_mail]);
    }

    $newsletter = new Newsletter();
    $result = $newsletter->subscribe($email);

    if($result) {
      wp_send_json_success(['message' => $success]);
    } else {
      wp_send_json_error(['message' => $error]);
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