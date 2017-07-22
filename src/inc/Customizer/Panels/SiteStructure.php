<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
  use Kirki as Kirki;

  class SiteStructure extends BaseCustomizer
  {
      public function set_panels()
      {
          Kirki::add_panel('site_structure', array(
            'priority' => 30,
            'title' => __('Site Structure', TEXT_DOMAIN),
            'description' => __('Configure the site structure for your theme.', TEXT_DOMAIN),
         ));

          return $this;
      }

      public function set_sections()
      {
          Kirki::add_section('site_structure_general', array(
        'title' => __('General Settings', TEXT_DOMAIN),
        // 'description' => __('General site structure settings.', TEXT_DOMAIN),
        'panel' => 'site_structure',
        'priority' => 10,
      ));

          Kirki::add_section('site_structure_layouts', array(
        'title' => __('Site Layouts', TEXT_DOMAIN),
        // 'description' => __('Site layout settings.', TEXT_DOMAIN),
        'panel' => 'site_structure',
        'priority' => 20,
      ));

          Kirki::add_section('site_structure_grid', array(
        'title' => __('Grid Settings', TEXT_DOMAIN),
        // 'description' => __('CSS responsive grid values.', TEXT_DOMAIN),
        'panel' => 'site_structure',
        'priority' => 30,
      ));

          return $this;
      }

      public function set_controls()
      {
          $this->set_general_controls();
          $this->set_layout_controls();
          $this->set_responsive_controls();

          return $this;
      }

      public function set_general_controls()
      {
          Kirki::add_field('border_radius', array(
        'type' => 'slider',
        'settings' => 'border_radius',
        'label' => __('Border-Radius', TEXT_DOMAIN),
        'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
        'section' => 'site_structure_general',
        'priority' => 10,
        'default' => 4,
        'choices' => array(
          'min' => 0,
          'max' => 20,
          'step' => 1,
        ),
      ));

          Kirki::add_field('padding_base', array(
        'type' => 'slider',
        'settings' => 'padding_base',
        'label' => __('Padding Base', TEXT_DOMAIN),
        'description' => __('You can adjust the padding base. This affects buttons size and lots of other cool stuff too! Default: 6', TEXT_DOMAIN),
        'section' => 'site_structure_general',
        'priority' => 20,
        'default' => 6,
        'choices' => array(
          'min' => 0,
          'max' => 22,
          'step' => 1,
        ),
      ));

          return $this;
      }

      public function set_layout_controls()
      {
          Kirki::add_field('site_style', array(
        'type' => 'radio',
        'mode' => 'buttonset',
        'settings' => 'site_style',
        'label' => __('Site Style', TEXT_DOMAIN),
        'subtitle' => __('Wide and boxed Layouts are responsive while fluid layouts are full-width.', TEXT_DOMAIN),
        'section' => 'site_structure_layouts',
        'priority' => 10,
        'default' => 'wide',
        'choices' => array(
          'wide' => __('Wide', TEXT_DOMAIN),
          'boxed' => __('Boxed', TEXT_DOMAIN),
          'fluid' => __('Fluid', TEXT_DOMAIN),
        ),
      ));

          Kirki::add_field('site_structure_base_layout', array(
        'type' => 'radio',
        'mode' => 'image',
        'settings' => 'site_structure_base_layout',
        'label' => __('Base Layout', TEXT_DOMAIN),
        'subtitle' => __('Select your base layout.', TEXT_DOMAIN),
        'section' => 'site_structure_layouts',
        'priority' => 20,
        'default' => 1,
        'choices' => $this->get_layout_options(),
      ));

          Kirki::add_field('site_structure_page_layout', array(
        'type' => 'radio',
        'mode' => 'image',
        'settings' => 'site_structure_page_layout',
        'label' => __('Page Layout', TEXT_DOMAIN),
        'subtitle' => __('Select your page layout.', TEXT_DOMAIN),
        'section' => 'site_structure_layouts',
        'priority' => 30,
        'default' => 1,
        'choices' => $this->get_layout_options(),
      ));

          Kirki::add_field('site_structure_post_layout', array(
        'type' => 'radio',
        'mode' => 'image',
        'settings' => 'site_structure_post_layout',
        'label' => __('Post Layout', TEXT_DOMAIN),
        'subtitle' => __('Select your post layout.', TEXT_DOMAIN),
        'section' => 'site_structure_layouts',
        'priority' => 40,
        'default' => 1,
        'choices' => $this->get_layout_options(),
      ));

          return $this;
      }

      public function set_responsive_controls()
      {
          Kirki::add_field('site_structure_grid_xsmall', array(
        'type' => 'slider',
        'settings' => 'site_structure_grid_xsmall',
        'label' => __('Extra Small Screen / Phone view', TEXT_DOMAIN),
        'subtitle' => __('The width of phones screens. Default: 480px', TEXT_DOMAIN),
        'section' => 'site_structure_grid',
        'priority' => 10,
        'default' => 480,
        'choices' => array(
          'min' => 320,
          'max' => 1200,
          'step' => 1,
        ),
      ));

          Kirki::add_field('site_structure_grid_small', array(
        'type' => 'slider',
        'settings' => 'site_structure_grid_small',
        'label' => __('Small Screen / Tablet view', TEXT_DOMAIN),
        'subtitle' => __('The width of small tablet screens. Default: 768px', TEXT_DOMAIN),
        'section' => 'site_structure_grid',
        'priority' => 20,
        'default' => 768,
        'choices' => array(
          'min' => 620,
          'max' => 2100,
          'step' => 1,
        ),
      ));

          Kirki::add_field('site_structure_grid_med', array(
        'type' => 'slider',
        'settings' => 'site_structure_grid_med',
        'label' => __('Medium Screen / Tablet view', TEXT_DOMAIN),
        'subtitle' => __('The width of large tablet screens and small laptop screens. Default: 1200px', TEXT_DOMAIN),
        'section' => 'site_structure_grid',
        'priority' => 30,
        'default' => 992,
        'choices' => array(
          'min' => 620,
          'max' => 2100,
          'step' => 1,
        ),
      ));

          Kirki::add_field('site_structure_grid_large', array(
        'type' => 'slider',
        'settings' => 'site_structure_grid_large',
        'label' => __('Large Screen / Tablet view', TEXT_DOMAIN),
        'subtitle' => __('The width of large laptop screens and desktop screens. Default: 1200px', TEXT_DOMAIN),
        'section' => 'site_structure_grid',
        'priority' => 40,
        'default' => 1200,
        'choices' => array(
          'min' => 620,
          'max' => 2100,
          'step' => 1,
        ),
      ));

          Kirki::add_field('site_structure_grid_gutter', array(
        'type' => 'slider',
        'settings' => 'site_structure_grid_gutter',
        'label' => __('Gutter', TEXT_DOMAIN),
        'subtitle' => __('The spacing between grid columns. Default: 30px', TEXT_DOMAIN),
        'section' => 'site_structure_grid',
        'priority' => 50,
        'default' => 30,
        'choices' => array(
          'min' => 0,
          'max' => 80,
          'step' => 1,
        ),
      ));

          return $this;
      }

      protected function get_layout_options()
      {
          $layouts = array(
        get_template_directory_uri().'/dist/images/admin/1c.png',
        get_template_directory_uri().'/dist/images/admin/2cr.png',
        get_template_directory_uri().'/dist/images/admin/2cl.png',
        get_template_directory_uri().'/dist/images/admin/3cl.png',
        get_template_directory_uri().'/dist/images/admin/3cr.png',
        get_template_directory_uri().'/dist/images/admin/3cm.png',
      );

          return $layouts;
      }
  }
