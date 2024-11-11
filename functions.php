<?php
  foreach (glob(__DIR__ . "/inc/*") as $filename) {
    if (!is_dir($filename)) {
      require_once($filename);
    }
  }

  function vite_url($path): string {
    return Vite\Vite::get_instance()->asset_url($path);
  }

