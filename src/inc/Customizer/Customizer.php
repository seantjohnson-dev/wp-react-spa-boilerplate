<?php

namespace SeanJohn\Customizer;

use Kirki;
use SeanJohn\SeanJohn;
use SeanJohn\Customizer\Panels;
use SeanJohn\Lib\BaseClass;
use SeanJohn\Customizer\Lib\SassCompiler;
use SeanJohn\Utils\Utils;

class Customizer extends BaseClass
{
    public $panels = [];
    public $compiler;
    protected $wp_cust;

    public function __construct($options = [])
    {
        parent::__construct($options);
        if (class_exists('Kirki')) {

          // Kirki::add_config( TEXT_DOMAIN, array(
          //   'capability'    => 'edit_theme_options',
          //   'option_type'   => 'theme_mod',
          //   'transport' => 'postMessage',
          //   'logo_image' => 'http://lorempixel.com/50/50/city',
          //   'description' => __('CARNM Theme<br/><br/>Below you will find all of the options to customize your theme.', TEXT_DOMAIN)
          // ));
          add_filter('kirki/config', [$this, 'register_kirki_config']);
          add_action('customize_preview_init', [$this, 'enqueue_customizer_preview_js']);
          add_action('customize_controls_enqueue_scripts', [$this, 'enqueue_customizer_panel_js']);
          add_action('customize_register', [$this, 'build_customizer'], 999);
          add_action('customize_controls_print_styles', [$this, 'enqueue_admin_customizer_css'], 999);
          add_action('customize_save_after', [$this, 'clear_rebuild_all_customizer_options'], 999);
          // $this->compiler = new SassCompiler([
          //   'sass_path' => get_template_directory() . '/dist/styles/',
          //   'uname' => 'compiled',
          //   'minimize_css' => true,
          //   'importPaths' => [
          //     get_template_directory() . '/assets/styles/',
          //     get_template_directory() . '/node_modules/bootstrap/scss/',
          //     get_template_directory() . '/node_modules/font-awesome/scss/'
          //   ]
          // ]);
          $this->init_panels();
        }
    }

    public function register_kirki_config($config)
    {
        $config['capability'] = 'edit_theme_options';
        $config['option_type'] = 'theme_mod';
        $config['option_name'] = 'boyerbohn_theme';
        $config['transport'] = 'postMessage';
        // $config['logo_image'] = '/wp-content/themes/carnm/boyerbohn/images/header-logo.png';
        $config['description'] = __('Boyer Bohn Theme<br/><br/>Below you will find all of the options to customize your theme.', TEXT_DOMAIN);

        return $config;
    }

    public function move_default_cust_settings($wp_cust)
    {
        $wp_cust->remove_section('colors');
        $wp_cust->remove_section('header_image');
        $wp_cust->remove_section('background_image');
        $wp_cust->remove_section('custom_css');
        $wp_cust->get_setting('blogname')->transport = 'postMessage';
        $wp_cust->get_setting('blogdescription')->transport = 'postMessage';
        $wp_cust->get_setting('header_textcolor')->transport = 'postMessage';
    }

    public function build_customizer($wp_cust)
    {
        $this->wp_cust = $wp_cust;
        $this->move_default_cust_settings($wp_cust);

        // add_filter('kirki/control_types', [$this, 'register_control_types']);
    }

    public function register_control_types($controls)
    {
        $controls['cropped-image'] = 'WP_Customize_Cropped_Image_Control';
        return $controls;
    }

    public function enqueue_customizer_panel_js()
    {
        // wp_enqueue_script('seanjohn_customizer_js', get_template_directory_uri() . '/admin.js', ['jquery'], null, true);
    }

    public function enqueue_customizer_preview_js()
    {
        wp_enqueue_script('seanjohn_customizer_preview_js', get_template_directory_uri() . '/customizer.js', ['jquery'], null, true);
    }

    public function enqueue_admin_customizer_css()
    {
        wp_register_style('seanjohn_customizer_css', get_template_directory_uri() . '/customizer.global.css', null, null, 'all');
        wp_enqueue_style('seanjohn_customizer_css');
    }

    public function init_panels()
    {
        $this->panels['FrontPage'] = new Panels\FrontPage();
        $this->panels['Blog'] = new Panels\Blog();
        $this->panels['SiteIdentity'] = new Panels\SiteIdentity();
        $this->panels['Scaffolding'] = new Panels\Scaffolding();
        // $this->panels['Typography'] = new Panels\Typography();
        // $this->panels['Buttons'] = new Panels\Buttons();
        // $this->panels['Forms'] = new Panels\Forms();
        // $this->panels['Advanced'] = new Panels\Advanced();
        // $this->panels['Menu'] = new Panels\Menu();
        // $this->panels['Social'] = new Panels\Social();

        return $this;
    }

    public static function get_all_customizer_options() {
      // delete_transient('all_customizer_options');
      $all_mods = get_transient('all_customizer_options');
      if (false === $all_mods) {
          $all_mods = [
            'home_url' => site_url('/'),
            'theme_mods' => get_theme_mods(),
            'options' => wp_load_alloptions()
          ];
      }
      // set_transient('all_customizer_options', $all_mods, 60*60*24);
      return $all_mods;
    }

    public function clear_rebuild_all_customizer_options() {
      delete_transient('all_customizer_options');
      $all_mods = self::get_all_customizer_options();
      // cache for 24 hours
      set_transient('all_customizer_options', $all_mods, 60*60*24);
    }
}
