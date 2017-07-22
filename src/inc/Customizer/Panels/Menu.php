<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
use SeanJohn\Utils\Utils;
use Kirki as Kirki;

  class Menu extends BaseCustomizer
  {

      public function __construct()
      {
          add_action('customize_register', [$this, 'on_customize_register'], 12);
      }

      public function set_panels()
      {
        // !Kint::dump($this->wp_cust->get_panel('nav_menus'));
        // exit;
         //  Kirki::add_panel('menus', array(
         //    'priority' => 200,
         //    'title' => __('Menu Style', TEXT_DOMAIN),
         //    'description' => __('Configure your menu style settings here.', TEXT_DOMAIN),
         // ));

          return $this;
      }

      public function set_sections()
      {
          Kirki::add_section('menu_styles', array(
            'title' => __('Primary Menu Styles', TEXT_DOMAIN),
            'panel' => 'nav_menus',
            'priority' => 100,
          ));

          return $this;
      }

      public function set_controls()
      {
          Kirki::add_field('primary_menu_style', array(
            'type' => 'radio-buttonset',
            'settings' => 'primary_menu_style',
            'label' => __('Primary Menu Style', TEXT_DOMAIN),
            'description' => __('Choose the type of menu to display in your theme\'s header.', TEXT_DOMAIN),
            'section' => 'menu_styles',
            'priority' => 10,
            'default' => 'flyout',
            'choices' => array(
              'flyout' => esc_attr__( 'Flyout', TEXT_DOMAIN ),
              'tabs' => esc_attr__( 'Tabs', TEXT_DOMAIN ),
              'columns' => esc_attr__( 'Columns', TEXT_DOMAIN )
            )
          ));

          Kirki::add_field('primary_menu_style_columns', array(
            'type' => 'slider',
            'settings' => 'primary_menu_style_columns',
            'label' => __('Primary Menu Columns', TEXT_DOMAIN),
            'description' => __('Choose the number of columns this nav should display on desktop browsers.', TEXT_DOMAIN),
            'section' => 'menu_styles',
            'priority' => 20,
            'default' => 4,
            'active_callback' => [
              [
                'setting'  => 'primary_menu_style',
                'operator' => '==',
                'value'    => 'columns'
              ]
            ],
            'choices'     => [
              'min'  => 1,
              'max'  => 6,
              'step' => 1
            ]
          ));

          return $this;
      }
  }
