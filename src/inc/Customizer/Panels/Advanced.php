<?php

  namespace SeanJohn\Customizer\Panels;

  use SeanJohn\Customizer\Lib\BaseCustomizer;
  use Kirki as Kirki;

  class Advanced extends BaseCustomizer
  {
      public function set_panels()
      {
          Kirki::add_panel('advanced', array(
            'priority' => 200,
            'title' => __('Advanced', TEXT_DOMAIN),
            'description' => __('Configure advanced settings here.', TEXT_DOMAIN),
         ));

          return $this;
      }

      public function set_sections()
      {

          Kirki::add_section('custom_css', array(
            'title' => __('Custom CSS', TEXT_DOMAIN),
            // 'description' => __('Put some custom css in this section.', TEXT_DOMAIN),
            'panel' => 'advanced',
            'priority' => 20,
          ));

          Kirki::add_section('custom_sass', array(
            'title' => __('Custom SASS', TEXT_DOMAIN),
            // 'description' => __('Put some custom sass in this section.', TEXT_DOMAIN),
            'panel' => 'advanced',
            'priority' => 30,
          ));

          Kirki::add_section('custom_javascript', array(
            'title' => __('Custom Javascript', TEXT_DOMAIN),
            // 'description' => __('Put some custom javascript in this section.', TEXT_DOMAIN),
            'panel' => 'advanced',
            'priority' => 40,
          ));

          return $this;
      }

      public function set_controls()
      {
          Kirki::add_field('custom_css', array(
            'type' => 'code',
            'settings' => 'custom_css',
            'label' => __('Custom CSS', TEXT_DOMAIN),
            'subtitle' => __('You can write your custom CSS here.', TEXT_DOMAIN),
            'section' => 'custom_css',
            'priority' => 10,
            'default' => '',
            'capability' => 'develop',
            'choices' => array(
              'language' => 'css',
              'theme' => 'monokai',
              'height' => 250,
            ),
          ));

          Kirki::add_field('custom_sass', array(
            'type' => 'code',
            'settings' => 'custom_sass',
            'label' => __('Custom SASS', TEXT_DOMAIN),
            'subtitle' => __('You can write your custom SASS here.', TEXT_DOMAIN),
            'section' => 'custom_sass',
            'priority' => 10,
            'default' => '',
            'capability' => 'develop',
            'choices' => array(
              'language' => 'sass',
              'theme' => 'monokai',
              'height' => 250,
            ),
          ));

          Kirki::add_field('custom_javascript', array(
            'type' => 'code',
            'settings' => 'custom_javascript',
            'label' => __('Custom Javascript', TEXT_DOMAIN),
            'subtitle' => __('You can write your custom javascript here.', TEXT_DOMAIN),
            'section' => 'custom_javascript',
            'priority' => 10,
            'default' => '',
            'capability' => 'develop',
            'choices' => array(
              'language' => 'javascript',
              'theme' => 'monokai',
              'height' => 250,
            ),
          ));

          return $this;
      }
  }
