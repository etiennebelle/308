<?php
  require 'vendor/autoload.php';

  use Mailjet\Client;
  use \Mailjet\Resources;

  $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'],true,['version' => 'v3']);
  $email = $_POST['email'] ?? NULL;
  $body = [
    'IsExcludedFromCampaigns' => "true",
    'Name' => "New Contact",
    'Email' => $email
  ];
  $response = $mj->post(Resources::$Contact, ['body' => $body]);
  /*$response->success();*/