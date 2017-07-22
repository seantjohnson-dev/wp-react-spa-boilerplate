<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
  use Kirki as Kirki;

  class Forms extends BaseCustomizer
  {
      public function set_panels()
      {
          Kirki::add_panel('forms', array(
            'priority' => 60,
            'title' => __('Forms', TEXT_DOMAIN),
            'description' => __('Configure settings for your site\'s forms here.', TEXT_DOMAIN),
         ));

          return $this;
      }

      public function set_sections()
      {


          Kirki::add_section('input_padding', array(
            'title' => __('Padding', TEXT_DOMAIN),
            // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
            'panel' => 'forms',
            'priority' => 10,
          ));

          Kirki::add_section('input_border', array(
            'title' => __('Border', TEXT_DOMAIN),
            // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
            'panel' => 'forms',
            'priority' => 20,
          ));

          Kirki::add_section('input_shadow', array(
            'title' => __('Shadow', TEXT_DOMAIN),
            // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
            'panel' => 'forms',
            'priority' => 30,
          ));

          Kirki::add_section('input_colors', array(
            'title' => __('Colors', TEXT_DOMAIN),
            // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
            'panel' => 'forms',
            'priority' => 40,
          ));



        return $this;
      }

      public function set_controls()
      {
          $this->set_input_padding();
          $this->set_input_border();
          $this->set_input_shadow();
          $this->set_input_colors();

          return $this;
      }

      public function set_input_padding() {

        Kirki::add_field( 'input_padding', array(
          'type'        => 'spacing',
          'settings'    => 'input_padding',
          'label'       => __( 'Input Padding', TEXT_DOMAIN),
          'section'     => 'input_padding',
          'default'     => array(
            'top' => '0.5rem',
            'left'    => '.75rem'
          ),
          'variables' => [
            [
              'name' => 'input-padding-x',
              'callback' => function ($value) {
                return $value['left'];
              }
            ],
            [
              'name' => 'input-padding-y',
              'callback' => function ($value) {
                return $value['top'];
              }
            ]
          ],
          'priority' => 10
        ));

        Kirki::add_field( 'input_padding_sm', array(
          'type'        => 'spacing',
          'settings'    => 'input_padding_sm',
          'label'       => __( 'Small Input Padding', TEXT_DOMAIN),
          'section'     => 'input_padding',
          'default'     => array(
            'top' => '0.25rem',
            'left'    => '0.5rem'
          ),
          'variables' => [
            [
              'name' => 'input-padding-x-sm',
              'callback' => function ($value) {
                return $value['left'];
              }
            ],
            [
              'name' => 'input-padding-y-sm',
              'callback' => function ($value) {
                return $value['left'];
              }
            ]
          ],
          'priority' => 20
        ));

        Kirki::add_field( 'input_padding_lg', array(
          'type'        => 'spacing',
          'settings'    => 'input_padding_lg',
          'label'       => __( 'Large Input Padding', TEXT_DOMAIN),
          'section'     => 'input_padding',
          'default'     => array(
            'top' => '0.75rem',
            'left'    => '1.5rem'
          ),
          'variables' => [
            [
              'name' => 'input-padding-x-lg',
              'callback' => function ($value) {
                return $value['left'];
              }
            ],
            [
              'name' => 'input-padding-y-lg',
              'callback' => function ($value) {
                return $value['top'];
              }
            ]
          ],
          'priority' => 30
        ));

        return $this;
      }

      public function set_input_border() {


        Kirki::add_field('input_border_radius', array(
          'type' => 'dimension',
          'settings' => 'input_border_radius',
          'label' => __('Input Border Radius', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'input_border',
          'priority' => 10,
          'default' => $this->check_global_border_radius('border_radius', 1, get_theme_mod('input_border_radius', '0.25rem')),
          'variables' => [
            [
              'name' => 'input-border-radius'
            ]
          ]
        ));

        Kirki::add_field('input_border_radius_sm', array(
          'type' => 'dimension',
          'settings' => 'input_border_radius_sm',
          'label' => __('Button Small Border Radius', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'input_border',
          'priority' => 20,
          'default' => $this->check_global_border_radius('input_border_radius', 0.8, get_theme_mod('input_border_radius_sm', '0.2rem')),
          'variables' => [
            [
              'name' => 'input-border-radius-sm'
            ]
          ]
        ));

        Kirki::add_field('input_border_radius_lg', array(
          'type' => 'dimension',
          'settings' => 'input_border_radius_lg',
          'label' => __('Button Large Border Radius', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'input_border',
          'priority' => 30,
          'default' => $this->check_global_border_radius('input_border_radius', 1.2, get_theme_mod('input_border_radius_lg', '0.3rem')),
          'variables' => [
            [
              'name' => 'input-border-radius-lg'
            ]
          ]
        ));

        Kirki::add_field('input_btn_border_width', array(
          'type' => 'dimension',
          'settings' => 'input_btn_border_width',
          'label' => __('Input Button Border Width', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'input_border',
          'priority' => 40,
          'default' => $this->check_global_border_radius('border_width', 1.2, get_theme_mod('input_btn_border_width', '1px')),
          'variables' => [
            [
              'name' => 'input-btn-border-width'
            ]
          ]
        ));

        return $this;
      }

      public function set_input_shadow() {

        // Kirki::add_field( 'input_box_shadow', array(
        //   'type'        => 'repeater',
        //   'label'       => esc_attr__( 'Input Box Shadow', TEXT_DOMAIN ),
        //   'section'     => 'input_shadow',
        //   'priority'    => 20,
        //   'row_label' => array(
        //     'type' => 'text',
        //     'value' => esc_attr__('Box Shadow', TEXT_DOMAIN ),
        //   ),
        //   'settings'    => 'input_box_shadow',
        //   'default'     => array(
        //     array(
        //       'inset' => '1',
        //       'x_offset' => 0,
        //       'y_offset' => 1,
        //       'blur' => 1,
        //       'spread' => 0,
        //       'color' => 'rgba(0,0,0,.075)'
        //     )
        //   ),
        //   'fields' => array(
        //     'inset' => array(
        //       'type'        => 'checkbox',
        //       'label'       => esc_attr__( 'Inset Shadow', TEXT_DOMAIN ),
        //       'default'     => '0'
        //     ),
        //     'x_offset' => array(
        //       'type'        => 'number',
        //       'label'       => esc_attr__( 'X Offset', TEXT_DOMAIN ),
        //       'description' => esc_attr__( 'The horizontal shadow offset', TEXT_DOMAIN ),
        //       'default'     => 0,
        //       'choices' => [
        //         'step' =>  1
        //       ]
        //     ),
        //     'y_offset' => array(
        //       'type'        => 'number',
        //       'label'       => esc_attr__( 'Y Offset', TEXT_DOMAIN ),
        //       'description' => esc_attr__( 'The vertical shadow offset', TEXT_DOMAIN ),
        //       'default'     => 0,
        //       'choices' => [
        //         'step' =>  1
        //       ]
        //     ),
        //     'blur' => array(
        //       'type'        => 'number',
        //       'label'       => esc_attr__( 'Blur Radius', TEXT_DOMAIN ),
        //       'description' => esc_attr__( 'The shadow blur radius', TEXT_DOMAIN ),
        //       'default'     => 0,
        //       'choices' => [
        //         'min' => 0,
        //         'step' =>  1
        //       ]
        //     ),
        //     'spread' => array(
        //       'type'        => 'number',
        //       'label'       => esc_attr__( 'Spread', TEXT_DOMAIN ),
        //       'description' => esc_attr__( 'The shadow spread', TEXT_DOMAIN ),
        //       'default'     => 0,
        //       'choices' => [
        //         'min' => 0,
        //         'step' =>  1
        //       ]
        //     ),
        //     'color' => array(
        //       'type'        => 'color',
        //       'label'       => esc_attr__( 'Color', TEXT_DOMAIN ),
        //       'description' => esc_attr__( 'The shadow color', TEXT_DOMAIN ),
        //       'default'     => 'rgba(0,0,0,0)',
        //       'choices' => [
        //         'alpha' => true
        //       ]
        //     )
        //   ),
        //   'variables' => [
        //     [
        //       'name' => 'input-box-shadow',
        //       'callback' => function ($value) {
        //         return $this->get_box_shadow_string($value);
        //       }
        //     ]
        //   ]
        // ));

        // Kirki::add_field( 'input_box_shadow_focus', array(
        //   'type'        => 'repeater',
        //   'label'       => esc_attr__( 'Input Box Shadow Focus', TEXT_DOMAIN ),
        //   'section'     => 'input_shadow',
        //   'priority'    => 30,
        //   'row_label' => array(
        //     'type' => 'text',
        //     'value' => esc_attr__('Box Shadow', TEXT_DOMAIN ),
        //   ),
        //   'settings'    => 'input_box_shadow_focus',
        //   'default'     => array(
        //     array(
        //       'inset' => get_theme_mod('input_box_shadow', '1'),
        //       'x_offset' => get_theme_mod('input_box_shadow', '0'),
        //       'y_offset' => get_theme_mod('input_box_shadow', '1'),
        //       'blur' => get_theme_mod('input_box_shadow', '1'),
        //       'spread' => get_theme_mod('input_box_shadow', '0'),
        //       'color' => get_theme_mod('input_box_shadow', 'rgba(0,0,0,.075)')
        //     ),
        //     array(
        //       'inset' => '0',
        //       'x_offset' => 0,
        //       'y_offset' => 0,
        //       'blur' => 8,
        //       'spread' => 0,
        //       'color' => 'rgba(102,175,233,.6)'
        //     )
        //   ),
        //   'fields' => array(
        //     'inset' => array(
        //       'type'        => 'checkbox',
        //       'label'       => esc_attr__( 'Inset Shadow', TEXT_DOMAIN ),
        //       'default'     => '0'
        //     ),
        //     'x_offset' => array(
        //       'type'        => 'number',
        //       'label'       => esc_attr__( 'X Offset', TEXT_DOMAIN ),
        //       'description' => esc_attr__( 'The horizontal shadow offset', TEXT_DOMAIN ),
        //       'default'     => 0,
        //       'choices' => [
        //         'step' =>  1
        //       ]
        //     ),
        //     'y_offset' => array(
        //       'type'        => 'number',
        //       'label'       => esc_attr__( 'Y Offset', TEXT_DOMAIN ),
        //       'description' => esc_attr__( 'The vertical shadow offset', TEXT_DOMAIN ),
        //       'default'     => 0,
        //       'choices' => [
        //         'step' =>  1
        //       ]
        //     ),
        //     'blur' => array(
        //       'type'        => 'number',
        //       'label'       => esc_attr__( 'Blur Radius', TEXT_DOMAIN ),
        //       'description' => esc_attr__( 'The shadow blur radius', TEXT_DOMAIN ),
        //       'default'     => 0,
        //       'choices' => [
        //         'min' => 0,
        //         'step' =>  1
        //       ]
        //     ),
        //     'spread' => array(
        //       'type'        => 'number',
        //       'label'       => esc_attr__( 'Spread', TEXT_DOMAIN ),
        //       'description' => esc_attr__( 'The shadow spread', TEXT_DOMAIN ),
        //       'default'     => 0,
        //       'choices' => [
        //         'min' => 0,
        //         'step' =>  1
        //       ]
        //     ),
        //     'color' => array(
        //       'type'        => 'color',
        //       'label'       => esc_attr__( 'Color', TEXT_DOMAIN ),
        //       'description' => esc_attr__( 'The shadow color', TEXT_DOMAIN ),
        //       'default'     => 'rgba(0,0,0,0)',
        //       'choices' => [
        //         'alpha' => true
        //       ]
        //     )
        //   ),
        //   'variables' => [
        //     [
        //       'name' => 'input-active-box-shadow',
        //       'callback' => function ($value) {
        //         return $this->get_box_shadow_string($value);
        //       }
        //     ]
        //   ]
        // ));

        return $this;
      }

      public function set_input_colors() {

        // Kirki::add_field('input_colors', array(
        //   'type' => 'multicolor',
        //   'settings' => 'input_colors',
        //   'label' => esc_attr__('Input Colors', TEXT_DOMAIN),
        //   'section' => 'input_colors',
        //   'choices'     => array(
        //       'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
        //       'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
        //       'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
        //       'placeholder' => esc_attr__( 'Placeholder', TEXT_DOMAIN )
        //   ),
        //   'default'     => array(
        //       'bg'    => '#fff',
        //       'text'   => $this->check_theme_color('gray', get_theme_mod('input_colors', [
        //         'bg'    => '#fff',
        //         'text' => get_theme_mod('gray', '#55595c'),
        //         'border' => 'rgba(0,0,0,.15)',
        //         'placeholder' => '#999'
        //       ]), 'text'),
        //       'border' => 'rgba(0,0,0,.15)',
        //       'placeholder' => '#999'
        //   ),
        //   'variables' => [
        //     [
        //       'name' => 'input-color',
        //       'callback' => function($value) {
        //         return $value['text'];
        //       }
        //     ],
        //     [
        //       'name' => 'input-bg',
        //       'callback' => function($value) {
        //         return $value['bg'];
        //       }
        //     ],
        //     [
        //       'name' => 'input-border-color',
        //       'callback' => function($value) {
        //         return $value['border'];
        //       }
        //     ],
        //     [
        //       'name' => 'input-color-placeholder',
        //       'callback' => function($value) {
        //         return $value['placeholder'];
        //       }
        //     ]
        //   ],
        //   'priority' => 10
        // ));

        // Kirki::add_field('input_focus_colors', array(
        //   'type' => 'multicolor',
        //   'settings' => 'input_focus_colors',
        //   'label' => esc_attr__('Input Focus Colors', TEXT_DOMAIN),
        //   'section' => 'input_colors',
        //   'choices'     => array(
        //       'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
        //       'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
        //       'border' => esc_attr__( 'Border', TEXT_DOMAIN )
        //   ),
        //   'default'     => array(
        //       'bg'    => get_theme_mod('input_colors', ['bg' => '#fff'])['bg'],
        //       'text'   => get_theme_mod('input_colors', ['color' => '#55595c'])['color'],
        //       'border' => '#66afe9'
        //   ),
        //   'variables' => [
        //     [
        //       'name' => 'input-color-focus',
        //       'callback' => function($value) {
        //         return $value['text'];
        //       }
        //     ],
        //     [
        //       'name' => 'input-bg-focus',
        //       'callback' => function($value) {
        //         return $value['bg'];
        //       }
        //     ],
        //     [
        //       'name' => 'input-border-focus',
        //       'callback' => function($value) {
        //         return $value['border'];
        //       }
        //     ]
        //   ],
        //   'priority' => 20
        // ));

        return $this;
      }

      public function check_theme_color($name, $cur_val, $key) {
        $color = get_theme_mod($name, '');
        if(isset($cur_val[$key]) && !empty($cur_val[$key])) {
          return $cur_val[$key];
        }
        return $color;
      }

      public function get_box_shadow_string($value) {
        $final = '';
        foreach($value as $s=>$shadow) {
          if ($shadow['inset']) {
            $final .= 'inset ';
          }
          $final .= $shadow['x_offset'] . 'px ';
          $final .= $shadow['y_offset'] . 'px ';
          $final .= $shadow['blur'] . 'px ';
          $final .= $shadow['spread'] . 'px ';
          $final .= $shadow['color'];
          if ($s < count($value) - 1) {
            $final .= ', ';
          }
        }
        return $final;
      }

      public function check_global_border_radius($theme_mod = 'border_radius', $multiplier = 1, $cur_val) {
        if (!empty($cur_val)) {
          return $cur_val;
        }
        $radius = get_theme_mod($theme_mod, '0.25rem');
        return str_replace(floatval($radius), (floatval($radius) * $multiplier), $radius);
      }
  }
