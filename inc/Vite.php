<?php
  namespace Vite;

  class Vite {
    private static ?Vite $instance = null;
    private bool $isDev;

    private function __construct() {
      $this->isDev = wp_get_environment_type() === 'local' &&
        is_array(wp_remote_get('http://localhost:5173/'));

      add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
      add_filter('script_loader_tag', [$this, 'add_module_type'], 10, 3);
    }

    public static function get_instance(): ?Vite {
      if (self::$instance === null) {
        self::$instance = new self();
      }
      return self::$instance;
    }

    public function enqueue_scripts(): void {
      $manifestPath = get_theme_file_path('dist/.vite/manifest.json');

      if ($this->isDev) {
        wp_enqueue_script('vite', 'http://localhost:5173/@vite/client', [], null, true);
        wp_enqueue_script('main', 'http://localhost:5173/assets/js/main.js', [], null, true);
        wp_enqueue_style('main', 'http://localhost:5173/assets/sass/main.scss');
      } elseif (file_exists($manifestPath)) {
        $manifest = json_decode(file_get_contents($manifestPath), true);
        wp_enqueue_script('main', get_theme_file_uri('dist/' . $manifest['assets/js/main.js']['file']), [], null, true);
        wp_enqueue_style('main', get_theme_file_uri('dist/' . $manifest['assets/sass/main.scss']['file']));
      }
    }

    public function asset_url($path): string {
      if ($this->isDev) {
        return "http://localhost:5173/" . $path;
      }

      return get_theme_file_uri('dist/' . $path);
    }

    public function vite_url($path): string
    {
      return self::asset_url($path);
    }

    public function add_module_type($tag, $handle, $src) {
      if (in_array($handle, ['vite', 'main'])) {
        return '<script type="module" src="' . esc_url($src) . '" defer></script>';
      }
      return $tag;
    }
  }

  Vite::get_instance();