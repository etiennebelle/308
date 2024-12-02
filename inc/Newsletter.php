<?php
  namespace Inc;

  use \Mailjet\Resources;
  use \Mailjet\Client;

  class Newsletter {
    private Client $mjClient;

    public function __construct() {
      $this->mjClient = new Client(
        $_ENV['MJ_APIKEY_PUBLIC'],
        $_ENV['MJ_APIKEY_PRIVATE'],
        true,
        ['version' => 'v3']
      );
    }

    public function subscribe(string $email): bool|array
    {
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
      }

      $body = [
        'IsExcludedFromCampaigns' => "true",
        'Name' => "New Contact",
        'Email' => $email
      ];

      $response = $this->mjClient->post(Resources::$Contact, ['body' => $body]);
      if($response->success()){
        return true;
      } else {
        return $response->getData();
      }
    }
  }