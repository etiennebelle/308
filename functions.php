<?php

  use Inc\Cpt\Actions;

  foreach (glob(__DIR__ . "/inc/*") as $filename) {
    if (!is_dir($filename)) {
      require_once($filename);
    }
  }