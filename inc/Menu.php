<?php

  // Remove admin menu items.
  add_action('admin_init', function () {
    remove_menu_page('edit-comments.php'); // Comments
    remove_menu_page('edit.php'); // Posts
    // remove_menu_page('edit.php?post_type=page'); // Pages
    // remove_menu_page('index.php'); // Dashboard
    // remove_menu_page('upload.php'); // Media
  });

  // Remove admin toolbar menu items.
  add_action('admin_bar_menu', function (WP_Admin_Bar $menu) {
    $menu->remove_node('archive'); // Archive
    $menu->remove_node('comments'); // Comments
    // $menu->remove_node('customize'); // Customize
    // $menu->remove_node('dashboard'); // Dashboard
    // $menu->remove_node('edit'); // Edit
    // $menu->remove_node('menus'); // Menus
    $menu->remove_node('new-content'); // New Content
    // $menu->remove_node('search'); // Search
    // $menu->remove_node('site-name'); // Site Name
    // $menu->remove_node('themes'); // Themes
    // $menu->remove_node('updates'); // Updates
    // $menu->remove_node('view-site'); // Visit Site
    // $menu->remove_node('view'); // View
    $menu->remove_node('widgets'); // Widgets
    $menu->remove_node('wp-logo'); // WordPress Logo
  }, 999);

  // Remove admin dashboard widgets.
  add_action('wp_dashboard_setup', function () {
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Activity
    // remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // At a Glance
    // remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); // Site Health Status
    remove_meta_box('dashboard_primary', 'dashboard', 'side'); // WordPress Events and News
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Draft
  });

  // Remove admin dashboard widgets.
  add_action('wp_dashboard_setup', function () {
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Activity
    // remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // At a Glance
    // remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); // Site Health Status
    remove_meta_box('dashboard_primary', 'dashboard', 'side'); // WordPress Events and News
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Draft
  });

  add_action('init', function (){
    remove_post_type_support( 'page', 'editor' );
  });

  /* Register custom post types */

  /* Register custom post types */