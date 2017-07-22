<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
  use Kirki as Kirki;

  class Colors extends BaseCustomizer
  {
      public function set_panels()
      {
          Kirki::add_panel('colors', array(
            'priority' => 70,
            'title' => __('Colors', TEXT_DOMAIN),
            'description' => __('Configure the color schemes for your theme here.', TEXT_DOMAIN),
         ));

          return $this;
      }

      public function set_sections()
      {


          Kirki::add_section('base_colors', array(
            'title' => __('Base Colors', TEXT_DOMAIN),
            // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
            'panel' => 'colors',
            'priority' => 10,
          ));



        return $this;
      }

      public function set_controls()
      {
          // $this->set_general_colors();
          // $this->set_palette_creator();

          return $this;
      }

      public function set_palette_creator()
      {
          Kirki::add_field('palette_creator', array(
            'type' => 'repeater',
            'label' => esc_attr__('Palette Creator', TEXT_DOMAIN),
            'description' => esc_attr__('Use this Palette Creator repeater to create palettes that will be used throughout the theme.', TEXT_DOMAIN),
            'section' => 'palette_creator',
            'priority' => 10,
            'settings' => 'palette_creator',
            'capability' => 'develop',
            'default' => array(),
            'fields' => array(
              'palette_label' => array(
                'type' => 'text',
                'label' => esc_attr__('Palette Label', TEXT_DOMAIN),
                'description' => esc_attr__('Give this palette a name. i.e. (light, dark, normal)', TEXT_DOMAIN),
                'default' => 'Default',
                'palette' => true,
              ),
              'brand_primary' => array(
                'type' => 'color-alpha',
                'label' => esc_attr__('Brand Primary', TEXT_DOMAIN),
                'description' => esc_attr__('The $brand-primary bootstrap variable.', TEXT_DOMAIN),
                'default' => '#337ab7',
                'palette' => false,
              ),
              'brand_success' => array(
                'type' => 'color-alpha',
                'label' => esc_attr__('Brand Success', TEXT_DOMAIN),
                'description' => esc_attr__('The $brand-success bootstrap variable.', TEXT_DOMAIN),
                'default' => '#00833f',
                'palette' => false,
              ),
              'brand_info' => array(
                'type' => 'color-alpha',
                'label' => esc_attr__('Brand Info', TEXT_DOMAIN),
                'description' => esc_attr__('The $brand-info bootstrap variable.', TEXT_DOMAIN),
                'default' => '#8d7332',
                'palette' => false,
              ),
              'brand_warning' => array(
                'type' => 'color-alpha',
                'label' => esc_attr__('Brand Warning', TEXT_DOMAIN),
                'description' => esc_attr__('The $brand-warning bootstrap variable.', TEXT_DOMAIN),
                'default' => '#ea7200',
                'palette' => false,
              ),
              'brand_danger' => array(
                'type' => 'color-alpha',
                'label' => esc_attr__('Brand Danger', TEXT_DOMAIN),
                'description' => esc_attr__('The $brand-danger bootstrap variable.', TEXT_DOMAIN),
                'default' => '#ac1f2d',
                'palette' => false,
              ),
            ),
          ));

          return $this;
      }
  }
