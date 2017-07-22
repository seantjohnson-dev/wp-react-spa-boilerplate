<?php

namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
  use Kirki as Kirki;
  use Kirki_Toolkit as Kirki_Toolkit;

  class Backgrounds extends BaseCustomizer
  {
      public function set_panels()
      {
          Kirki::add_panel('backgrounds', array(
            'priority' => 40,
            'title' => __('Backgrounds', TEXT_DOMAIN),
            'description' => __('Configure your blog settings here.', TEXT_DOMAIN),
          ));

          return $this;
      }

      public function set_sections()
      {

      // Kirki::add_section('html_bg', array(
    //     'title' => __('Html', TEXT_DOMAIN),
    //     'description' => __('Set the background for the html document.', TEXT_DOMAIN),
    //     'panel' => 'backgrounds',
    //     'priority' => 10
      //));

      Kirki::add_section('body_bg', array(
        'title' => __('Body', TEXT_DOMAIN),
        // 'description' => __('Set the background for the body tag.', TEXT_DOMAIN),
        'panel' => 'backgrounds',
        'priority' => 20,
      ));

          Kirki::add_section('header_bg', array(
        'title' => __('Header', TEXT_DOMAIN),
        // 'description' => __('Set the background for the header.', TEXT_DOMAIN),
        'panel' => 'backgrounds',
        'priority' => 30,
      ));

          Kirki::add_section('footer_bg', array(
        'title' => __('Footer', TEXT_DOMAIN),
        // 'description' => __('Set the background for the footer.', TEXT_DOMAIN),
        'panel' => 'backgrounds',
        'priority' => 40,
      ));

          Kirki::add_section('nav_bg', array(
        'title' => __('Navigation Menu', TEXT_DOMAIN),
        // 'description' => __('Set the background for the navigation menu.', TEXT_DOMAIN),
        'panel' => 'backgrounds',
        'priority' => 50,
      ));

          return $this;
      }

      public function set_controls()
      {

      // Kirki::add_field('html_bg', array(
      //    'type'        => 'background',
      //    'settings'     => 'html_bg',
      //    'label'       => esc_attr__('Html Background', TEXT_DOMAIN),
      //    'description' => esc_attr__('Set the background for the html document.', TEXT_DOMAIN),
      //    'section'     => 'html_bg',
      //    'default'     => 'primary',
      //    'priority'    => 10,
      //    'default'     => array(
      //      'image'     => '',
      //      'color'     => '#fff',
      //      'attach'    => 'scroll',
      //      'size'      => 'cover',
      //      'repeat'    => 'no-repeat',
      //      'position'  => 'center-center'
      //    ),
      //    'choices'     => array(
      //      'repeat'        => array(
      //        'no-repeat' => Kirki_Toolkit::i18n()['no-repeat'],
      //        'repeat'    => Kirki_Toolkit::i18n()['repeat-all'],
      //        'repeat-x'  => Kirki_Toolkit::i18n()['repeat-x'],
      //        'repeat-y'  => Kirki_Toolkit::i18n()['repeat-y'],
      //        'inherit'   => Kirki_Toolkit::i18n()['inherit']
      //      ),
      //      'size'        => array(
      //        'inherit' => Kirki_Toolkit::i18n()['inherit'],
      //        'cover'   => Kirki_Toolkit::i18n()['cover'],
      //        'contain' => Kirki_Toolkit::i18n()['contain']
      //      ),
      //      'attach'      => array(
      //        'inherit' => Kirki_Toolkit::i18n()['inherit'],
      //        'fixed'   => Kirki_Toolkit::i18n()['fixed'],
      //        'scroll'  => Kirki_Toolkit::i18n()['scroll']
      //      ),
      //      'position'          => array(
      //        'left-top'      => Kirki_Toolkit::i18n()['left-top'],
      //        'left-center'   => Kirki_Toolkit::i18n()['left-center'],
      //        'left-bottom'   => Kirki_Toolkit::i18n()['left-bottom'],
      //        'right-top'     => Kirki_Toolkit::i18n()['right-top'],
      //        'right-center'  => Kirki_Toolkit::i18n()['right-center'],
      //        'right-bottom'  => Kirki_Toolkit::i18n()['right-bottom'],
      //        'center-top'    => Kirki_Toolkit::i18n()['center-top'],
      //        'center-center' => Kirki_Toolkit::i18n()['center-center'],
      //        'center-bottom' => Kirki_Toolkit::i18n()['center-bottom']
      //      )
      //    ),
      //    'output' => array(
      //      'element' => 'html'
      //    )
      //));

      Kirki::add_field('body_bg', array(
          'type' => 'background',
          'settings' => 'body_bg',
          'label' => esc_attr__('Body Background', TEXT_DOMAIN),
          'description' => esc_attr__('Set the body background.', TEXT_DOMAIN),
          'section' => 'body_bg',
          'default' => 'primary',
          'priority' => 10,
          'default' => array(
            'image' => '',
            'color' => '#ffffff',
            'attach' => 'scroll',
            'size' => 'cover',
            'repeat' => 'no-repeat',
            'position' => 'center center',
          ),
          'choices' => array(
            'repeat' => array(
              'no-repeat' => Kirki_Toolkit::i18n()['no-repeat'],
              'repeat' => Kirki_Toolkit::i18n()['repeat-all'],
              'repeat-x' => Kirki_Toolkit::i18n()['repeat-x'],
              'repeat-y' => Kirki_Toolkit::i18n()['repeat-y'],
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
            ),
            'size' => array(
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
              'cover' => Kirki_Toolkit::i18n()['cover'],
              'contain' => Kirki_Toolkit::i18n()['contain'],
            ),
            'attach' => array(
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
              'fixed' => Kirki_Toolkit::i18n()['fixed'],
              'scroll' => Kirki_Toolkit::i18n()['scroll'],
            ),
            'position' => array(
              'left-top' => Kirki_Toolkit::i18n()['left-top'],
              'left-center' => Kirki_Toolkit::i18n()['left-center'],
              'left-bottom' => Kirki_Toolkit::i18n()['left-bottom'],
              'right-top' => Kirki_Toolkit::i18n()['right-top'],
              'right-center' => Kirki_Toolkit::i18n()['right-center'],
              'right-bottom' => Kirki_Toolkit::i18n()['right-bottom'],
              'center-top' => Kirki_Toolkit::i18n()['center-top'],
              'center-center' => Kirki_Toolkit::i18n()['center-center'],
              'center-bottom' => Kirki_Toolkit::i18n()['center-bottom'],
            ),
          ),
          'output' => array(
            'element' => 'body'
          ),
      ));

          Kirki::add_field('header_bg', array(
          'type' => 'background',
          'settings' => 'header_bg',
          'label' => esc_attr__('Header Background', TEXT_DOMAIN),
          'description' => esc_attr__('Set the header background.', TEXT_DOMAIN),
          'section' => 'header_bg',
          'default' => 'primary',
          'priority' => 10,
          'default' => array(
            'image' => '',
            'color' => 'rgba(255,255,255,0.85)',
            'attach' => 'scroll',
            'size' => 'cover',
            'repeat' => 'no-repeat',
            'position' => 'center center',
          ),
          'choices' => array(
            'repeat' => array(
              'no-repeat' => Kirki_Toolkit::i18n()['no-repeat'],
              'repeat' => Kirki_Toolkit::i18n()['repeat-all'],
              'repeat-x' => Kirki_Toolkit::i18n()['repeat-x'],
              'repeat-y' => Kirki_Toolkit::i18n()['repeat-y'],
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
            ),
            'size' => array(
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
              'cover' => Kirki_Toolkit::i18n()['cover'],
              'contain' => Kirki_Toolkit::i18n()['contain'],
            ),
            'attach' => array(
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
              'fixed' => Kirki_Toolkit::i18n()['fixed'],
              'scroll' => Kirki_Toolkit::i18n()['scroll'],
            ),
            'position' => array(
              'left-top' => Kirki_Toolkit::i18n()['left-top'],
              'left-center' => Kirki_Toolkit::i18n()['left-center'],
              'left-bottom' => Kirki_Toolkit::i18n()['left-bottom'],
              'right-top' => Kirki_Toolkit::i18n()['right-top'],
              'right-center' => Kirki_Toolkit::i18n()['right-center'],
              'right-bottom' => Kirki_Toolkit::i18n()['right-bottom'],
              'center-top' => Kirki_Toolkit::i18n()['center-top'],
              'center-center' => Kirki_Toolkit::i18n()['center-center'],
              'center-bottom' => Kirki_Toolkit::i18n()['center-bottom'],
            ),
          ),
          'output' => array(
            'element' => '#site-header',
          ),
      ));

          Kirki::add_field('footer_bg', array(
          'type' => 'background',
          'settings' => 'footer_bg',
          'label' => esc_attr__('Footer Background', TEXT_DOMAIN),
          'description' => esc_attr__('Set the footer background.', TEXT_DOMAIN),
          'section' => 'footer_bg',
          'default' => 'primary',
          'priority' => 10,
          'default' => array(
            'image' => '',
            'color' => '#002f6d',
            'attach' => 'scroll',
            'size' => 'cover',
            'repeat' => 'no-repeat',
            'position' => 'center center',
          ),
          'choices' => array(
            'repeat' => array(
              'no-repeat' => Kirki_Toolkit::i18n()['no-repeat'],
              'repeat' => Kirki_Toolkit::i18n()['repeat-all'],
              'repeat-x' => Kirki_Toolkit::i18n()['repeat-x'],
              'repeat-y' => Kirki_Toolkit::i18n()['repeat-y'],
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
            ),
            'size' => array(
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
              'cover' => Kirki_Toolkit::i18n()['cover'],
              'contain' => Kirki_Toolkit::i18n()['contain'],
            ),
            'attach' => array(
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
              'fixed' => Kirki_Toolkit::i18n()['fixed'],
              'scroll' => Kirki_Toolkit::i18n()['scroll'],
            ),
            'position' => array(
              'left-top' => Kirki_Toolkit::i18n()['left-top'],
              'left-center' => Kirki_Toolkit::i18n()['left-center'],
              'left-bottom' => Kirki_Toolkit::i18n()['left-bottom'],
              'right-top' => Kirki_Toolkit::i18n()['right-top'],
              'right-center' => Kirki_Toolkit::i18n()['right-center'],
              'right-bottom' => Kirki_Toolkit::i18n()['right-bottom'],
              'center-top' => Kirki_Toolkit::i18n()['center-top'],
              'center-center' => Kirki_Toolkit::i18n()['center-center'],
              'center-bottom' => Kirki_Toolkit::i18n()['center-bottom'],
            ),
          ),
          'output' => array(
            'element' => '#site-footer',
          ),
      ));

          Kirki::add_field('nav_bg', array(
          'type' => 'background',
          'settings' => 'nav_bg',
          'label' => esc_attr__('Navigation Menu (Mobile Only)', TEXT_DOMAIN),
          'description' => esc_attr__('Set the main navigation background.', TEXT_DOMAIN),
          'section' => 'nav_bg',
          'default' => 'primary',
          'priority' => 10,
          'default' => array(
            'image' => '',
            'color' => '#333333',
            'attach' => 'scroll',
            'size' => 'cover',
            'repeat' => 'no-repeat',
            'position' => 'center center',
          ),
          'choices' => array(
            'repeat' => array(
              'no-repeat' => Kirki_Toolkit::i18n()['no-repeat'],
              'repeat' => Kirki_Toolkit::i18n()['repeat-all'],
              'repeat-x' => Kirki_Toolkit::i18n()['repeat-x'],
              'repeat-y' => Kirki_Toolkit::i18n()['repeat-y'],
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
            ),
            'size' => array(
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
              'cover' => Kirki_Toolkit::i18n()['cover'],
              'contain' => Kirki_Toolkit::i18n()['contain'],
            ),
            'attach' => array(
              'inherit' => Kirki_Toolkit::i18n()['inherit'],
              'fixed' => Kirki_Toolkit::i18n()['fixed'],
              'scroll' => Kirki_Toolkit::i18n()['scroll'],
            ),
            'position' => array(
              'left-top' => Kirki_Toolkit::i18n()['left-top'],
              'left-center' => Kirki_Toolkit::i18n()['left-center'],
              'left-bottom' => Kirki_Toolkit::i18n()['left-bottom'],
              'right-top' => Kirki_Toolkit::i18n()['right-top'],
              'right-center' => Kirki_Toolkit::i18n()['right-center'],
              'right-bottom' => Kirki_Toolkit::i18n()['right-bottom'],
              'center-top' => Kirki_Toolkit::i18n()['center-top'],
              'center-center' => Kirki_Toolkit::i18n()['center-center'],
              'center-bottom' => Kirki_Toolkit::i18n()['center-bottom'],
            ),
            'output' => array(
              'element' => '#primary-navigation',
            ),
          ),
      ));

          return $this;
      }
  }
