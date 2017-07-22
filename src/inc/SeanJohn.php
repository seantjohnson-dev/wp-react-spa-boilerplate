<?php

namespace SeanJohn;

use SeanJohn\Lib\ManagerClass;
use SeanJohn\Lib\Wrapper;
use SeanJohn\Lib\StarterSite;
use SeanJohn\Sidebars\Sidebars;
use SeanJohn\Utils\Utils;
use SeanJohn\Utils\Formatter;
use SeanJohn\Customizer\Customizer;
use SeanJohn\Lib\JsonManifest;
use \Kint as Kint;
use \acf_field_google_map_extended_plugin as acf_field_google_map_extended_plugin;


define('THEME_LIB_DIR', trailingslashit(get_template_directory()) . 'inc');


class SeanJohn extends ManagerClass {

    public static $manifest;
    public static $theme_version;
    public $timber;

    protected $defaults = [
      'classes' => [
        'SeanJohn\Acf\Acf' => [],
        'SeanJohn\Admin\Admin' => [],
        'SeanJohn\Customizer\Customizer' => [],
        'SeanJohn\Menus\Menus' => [],
        'SeanJohn\PostTypes\PostTypes' => [],
        'SeanJohn\RestAPI\RestAPI' => [],
        'SeanJohn\Roles\Roles' => [],
        'SeanJohn\Sidebars\Sidebars' => [],
        'SeanJohn\Taxonomies\Taxonomies' => [],
        'SeanJohn\Widgets\Widgets' => [],
        'SeanJohn\Utils\Utils' => []
      ]
    ];

    public function __construct($options = [])
    {
        parent::__construct($options);
        self::$theme_version = '1.0.0';
        add_action('after_setup_theme', [$this, 'setup']);
    }

    public function setup() {

      $this->theme_supports()->filters()->actions();

      load_theme_textdomain(TEXT_DOMAIN, trailingslashit(get_template_directory()) . 'lang');

      add_editor_style(self::asset_path('/main.global.css'));


      $this->add_image_sizes();

      return $this;
    }

    ////////////////////////
    // SETUP FUNCTIONS BELOW
    // /////////////////////

    protected function filters() {
      add_filter('wp_trim_excerpt', ['SeanJohn\Utils\Formatter', 'trim_excerpt']);
      add_filter('excerpt_more', ['SeanJohn\Utils\Formatter', 'excerpt_more']);
      // add_filter('rest_post_dispatch', [$this, 'localize_menus']);
      // add_filter('template_include', ['SeanJohn\Lib\Wrapper', 'wrap'], 109);
      return $this;
    }

    protected function actions() {
      // $this->setup();

      // remove junk from head

      add_action('wp_enqueue_scripts', [$this, 'assets'], 100);
      add_action('admin_enqueue_scripts', [$this, 'admin_assets'], 100);
      add_action('after_setup_theme', array($this, 'content_width'), 0);
      add_filter('rest_menus_format_menu_item', [$this, 'add_menu_item_page_section_field_to_items']);
      add_filter('rest_menus_format_menu', [$this, 'add_menu_item_page_section_field_to_menus']);

      return $this;
    }

    public function add_menu_item_page_section_field_to_menus($menu) {
      foreach($menu['items'] as $i=>$item) {
        $id = (isset($item['ID']) ? $item['ID'] : $item['id']);
        $page_section = get_post_meta($id, '_menu_item_page_section', true);
        // Utils::data2file(get_template_directory() . '/dump.php', ['item' => $item, 'page_section' => $page_section], 'php');
        $menu['items'][$i]['page_section'] = $page_section;
      }
      return $menu;
    }

    public function add_menu_item_page_section_field_to_items($item) {
      $id = (isset($item['ID']) ? $item['ID'] : $item['id']);
      $item['page_section'] = get_post_meta($id, '_menu_item_page_section', true);
      return $item;
    }

    public function theme_supports() {
      // Add default posts and comments RSS feed links to head
      add_theme_support('automatic-feed-links');
      add_theme_support('post-thumbnails');
      add_theme_support('menus');
      add_theme_support('title-tag');
      add_theme_support('html5', ['caption', 'gallery', 'search-form']);

      remove_post_type_support('page', 'thumbnail');
      // add_post_type_support( 'revision', 'modular-page-builder' );
      return $this;
    }

    public function content_width() {
      $GLOBALS['content_width'] = 1140;
    }

    public static function body_class($classes = []) {
      // Add page slug if it doesn't exist
      if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
          $classes[] = basename(get_permalink());
        }
      }

      return $classes;
    }

    public function assets()
    {
        wp_enqueue_style('main-lib', self::asset_path('/main.global.css'), '', self::$theme_version);
        // wp_enqueue_style('main', self::asset_path('/main.css'), '', self::$theme_version);

        if (is_single() && comments_open() && get_option('thread_comments')) {
          wp_enqueue_script('comment-reply');
        }
        $this->mainJsEnqueue();
    }

    public function get_full_menu_object($id) {
      $url = rest_url("/wp-api-menus/v2/menus/" . $id . '?_embed');
      $value = json_decode(file_get_contents($url), true);
      return $value;
    }

    public function get_full_menu_object_by_location($location) {
      $url = rest_url("/wp-api-menus/v2/menu-locations/" . $location . '?_embed');
      $value = json_decode(file_get_contents($url), true);
      return $value;
    }

    public function mainJsEnqueue() {
      if (defined('GOOGLE_MAPS_API_KEY')) {
        wp_deregister_script("googlemaps-api");
        wp_register_script('googlemaps-api', 'https://maps.googleapis.com/maps/api/js?key=' . GOOGLE_MAPS_API_KEY, [], '3.exp', true);
        wp_enqueue_script('googlemaps-api');
      }

      wp_register_script('seanjohn-scripts', self::asset_path('/main.js'), [], self::$theme_version, true);


        $footerOpts = get_fields('footer');
        $headerOpts = get_fields('header');
        $headerOpts['menu'] = $this->get_full_menu_object($headerOpts['menu']);
        $main_menu = $this->get_full_menu_object_by_location('primary_navigation');

        // delete_transient('seanjohn-scripts-localized-data');
        // $localized = get_transient('seanjohn-scripts-localized-data');
        // if ($localized === false) {
          $localized = [
            'SITE_TITLE' => get_bloginfo('name'),
            'SITE_DESCRIPTION' => get_bloginfo('description'),
            'SITE_URL' => get_site_url(),
            'API' => get_site_url() . '/wp-json/',
            'POSTS_PER_PAGE' => get_option('posts_per_page'),
            'PAGE_FOR_POSTS' => get_option('page_for_posts'),
            'PAGE_ON_FRONT' => get_option('page_on_front'),
            'GMAPS_API_KEY' => GOOGLE_MAPS_API_KEY,
            'API_URL' => untrailingslashit(rest_url()),
            'NONCE'   => wp_create_nonce('wp_rest'),
            'BASE'    => parse_url(home_url(), PHP_URL_PATH),
            'AJAX_URL' => admin_url('admin-ajax.php'),
            'BREAKPOINTS' => [
              'xs' => 0,
              'sm' => intval(get_theme_mod('grid_bp_sm', 576)),
              'md' => intval(get_theme_mod('grid_bp_sm', 768)),
              'lg' => intval(get_theme_mod('grid_bp_sm', 992)),
              'xl' => intval(get_theme_mod('grid_bp_sm', 1200))
            ],
            'MAX_WIDTHS' => [
              'xs' => 0,
              'sm' => intval(get_theme_mod('grid_container_sm', 540)),
              'md' => intval(get_theme_mod('grid_container_md', 720)),
              'lg' => intval(get_theme_mod('grid_container_lg', 960)),
              'xl' => intval(get_theme_mod('grid_container_xl', 1140))
            ],
            'MAIN_MENU' => $main_menu,
            'FOOTER' => $footerOpts,
            'HEADER' => $headerOpts
          ];
        //   set_transient('seanjohn-scripts-localized-data', $localized);
        // }

        wp_localize_script('seanjohn-scripts', 'WP_PARAMETERS', array_merge([], $localized));
        wp_enqueue_script('seanjohn-scripts');
    }

    public function admin_assets()
    {
        wp_deregister_script("googlemaps-api");
        wp_deregister_script("acf-input-google-map-extended");
        wp_register_script("googlemaps-api", "//maps.googleapis.com/maps/api/js?v=3&libraries=places&key=" . GOOGLE_MAPS_API_KEY ,[],'3',true);
        if (class_exists('acf_field_google_map_extended_plugin')) {
          wp_register_script("acf-input-google-map-extended", WP_PLUGIN_URL . '/acf-gme/js/input.js',['acf-input','jquery','googlemaps-api'],acf_field_google_map_extended_plugin::version,true);
        }
        wp_enqueue_style('seanjohn-admin-styles', self::asset_path('/admin.global.css'), false, null);
        wp_enqueue_style('seanjohn-customizer-styles', self::asset_path('/customizer.global.css'), false, null);

        wp_enqueue_script('googlemaps-api');
        wp_enqueue_script('acf-input-google-map-extended');
        wp_enqueue_script('seanjohn-admin-scripts', self::asset_path('/admin.js'), ['jquery'], null, true);
    }

    public static function asset_path($filename) {
      $dist_path = get_template_directory_uri() . '/';
      $directory = dirname($filename);
      $file = basename($filename);
      return $dist_path . $directory . $file;
    }

    public function add_image_sizes() {
        add_image_size( 'medium_large', '768', '0', false );
        // add_image_size( 'mobile-home-hero', '576', '690', array( "1", "") );
        // add_image_size( 'tablet-home-hero', '1024', '768', array( "1", "") );
        // add_image_size( 'desktop-home-hero', '1440', '800', array( "1", "") );
        // add_image_size( 'xl-desktop-home-hero', '1920', '960', array( "1", "") );
        // add_image_size( 'xl-desktop-post-hero', '1920', '680', array( "1", "") );
        // add_image_size( 'desktop-post-hero', '1440', '576', array( "1", "") );
        // add_image_size( 'tablet-post-hero', '1024', '640', array( "1", "") );
        // add_image_size( 'mobile-post-hero', '576', '576', array( "1", "") );
        add_image_size( 'large-landscape', '1536', '960', array( "1", "") );
        add_image_size( 'thumbnail-landscape', '320', '200', array( "1", "") );
        add_image_size( 'thumbnail-portrait', '200', '320', array( "1", "") );
        add_image_size( 'large-portrait', '960', '1536', array( "1", "") );
        add_image_size( 'medium-landscape', '576', '360', array( "1", "") );
        add_image_size( 'medium-portrait', '360', '576', array( "1", "") );
        add_image_size( 'medium-thumb', '384', '384', array( "1", "") );
        add_image_size( 'large-thumb', '825', '825', array( "1", "") );
        return $this;
    }

}
