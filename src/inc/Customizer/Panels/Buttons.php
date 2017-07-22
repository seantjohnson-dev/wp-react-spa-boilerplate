<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
  use Kirki as Kirki;

  class Buttons extends BaseCustomizer
  {
      public function set_panels()
      {
          Kirki::add_panel('buttons', array(
            'priority' => 50,
            'title' => __('Buttons', TEXT_DOMAIN),
            'description' => __('Configure settings for your site\'s buttons here.', TEXT_DOMAIN),
         ));

          return $this;
      }

      public function set_sections()
      {


          Kirki::add_section('btn_padding', array(
            'title' => __('Padding', TEXT_DOMAIN),
            // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
            'panel' => 'buttons',
            'priority' => 10,
          ));

          Kirki::add_section('btn_border', array(
            'title' => __('Border', TEXT_DOMAIN),
            // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
            'panel' => 'buttons',
            'priority' => 20,
          ));

          Kirki::add_section('btn_shadow', array(
            'title' => __('Shadow', TEXT_DOMAIN),
            // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
            'panel' => 'buttons',
            'priority' => 30,
          ));

          Kirki::add_section('btn_colors', array(
            'title' => __('Colors', TEXT_DOMAIN),
            // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
            'panel' => 'buttons',
            'priority' => 40,
          ));



        return $this;
      }

      public function set_controls()
      {
          $this->set_btn_padding();
          $this->set_btn_border();
          $this->set_btn_shadow();
          $this->set_btn_colors();

          return $this;
      }

      public function set_btn_padding() {

        Kirki::add_field( TEXT_DOMAIN, array(
          'type'        => 'spacing',
          'settings'    => 'btn_padding',
          'label'       => __( 'Button Padding', TEXT_DOMAIN),
          'section'     => 'btn_padding',
          'default'     => array(
            'top' => '0.5rem',
            'left'    => '1rem'
          ),
          'variables' => [
            [
              'name' => 'btn-padding-x',
              'callback' => function ($value) {
                return $value['left'];
              }
            ],
            [
              'name' => 'btn-padding-y',
              'callback' => function ($value) {
                return $value['top'];
              }
            ],
            [
              'name' => 'btn-block-spacing-y',
              'callback' => function ($value) {
                return $value['top'];
              }
            ],
            [
              'name' => 'btn-toolbar-margin',
              'callback' => function ($value) {
                return $value['top'];
              }
            ]
          ],
          'priority' => 10
        ));

        Kirki::add_field( 'btn_padding_sm', array(
          'type'        => 'spacing',
          'settings'    => 'btn_padding_sm',
          'label'       => __( 'Small Button Padding', TEXT_DOMAIN),
          'section'     => 'btn_padding',
          'default'     => array(
            'top' => '0.25rem',
            'left'    => '0.5rem'
          ),
          'variables' => [
            [
              'name' => 'btn-padding-x-sm',
              'callback' => function ($value) {
                return $value['left'];
              }
            ],
            [
              'name' => 'btn-padding-y-sm',
              'callback' => function ($value) {
                return $value['left'];
              }
            ]
          ],
          'priority' => 20
        ));

        Kirki::add_field( 'btn_padding_lg', array(
          'type'        => 'spacing',
          'settings'    => 'btn_padding_lg',
          'label'       => __( 'Large Button Padding', TEXT_DOMAIN),
          'section'     => 'btn_padding',
          'default'     => array(
            'top' => '0.75rem',
            'left'    => '1.5rem'
          ),
          'variables' => [
            [
              'name' => 'btn-padding-x-lg',
              'callback' => function ($value) {
                return $value['left'];
              }
            ],
            [
              'name' => 'btn-padding-y-lg',
              'callback' => function ($value) {
                return $value['top'];
              }
            ]
          ],
          'priority' => 30
        ));

        return $this;
      }

      public function set_btn_border() {


        Kirki::add_field('btn_border_radius', array(
          'type' => 'dimension',
          'settings' => 'btn_border_radius',
          'label' => __('Button Border Radius', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'btn_border',
          'priority' => 10,
          'default' => $this->check_global_border_radius('border_radius', 1, get_theme_mod('btn_border_radius', '0.25rem')),
          'variables' => [
            [
              'name' => 'btn-border-radius'
            ]
          ]
        ));

        Kirki::add_field('btn_border_radius_sm', array(
          'type' => 'dimension',
          'settings' => 'btn_border_radius_sm',
          'label' => __('Button Small Border Radius', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'btn_border',
          'priority' => 20,
          'default' => $this->check_global_border_radius('btn_border_radius', 0.8, get_theme_mod('btn_border_radius_sm', '0.2rem')),
          'variables' => [
            [
              'name' => 'btn-border-radius-sm'
            ]
          ]
        ));

        Kirki::add_field('btn_border_radius_lg', array(
          'type' => 'dimension',
          'settings' => 'btn_border_radius_lg',
          'label' => __('Button Large Border Radius', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'btn_border',
          'priority' => 30,
          'default' => $this->check_global_border_radius('btn_border_radius', 1.2, get_theme_mod('btn_border_radius_lg', '0.3rem')),
          'variables' => [
            [
              'name' => 'btn-border-radius-lg'
            ]
          ]
        ));

        return $this;
      }

      public function set_btn_shadow() {

        // Kirki::add_field( 'btn_box_shadow', array(
        //   'type'        => 'repeater',
        //   'label'       => esc_attr__( 'Button Box Shadow', TEXT_DOMAIN ),
        //   'section'     => 'btn_shadow',
        //   'priority'    => 20,
        //   'row_label' => array(
        //     'type' => 'text',
        //     'value' => esc_attr__('Box Shadow', TEXT_DOMAIN ),
        //   ),
        //   'settings'    => 'btn_box_shadow',
        //   'default'     => array(
        //     array(
        //       'inset' => '1',
        //       'x_offset' => 0,
        //       'y_offset' => 1,
        //       'blur' => 0,
        //       'spread' => 0,
        //       'color' => 'rgba(255,255,255,.15)'
        //     ),
        //     array(
        //       'inset' => '0',
        //       'x_offset' => 0,
        //       'y_offset' => 1,
        //       'blur' => 1,
        //       'spread' => 0,
        //       'color' => 'rgba(0,0,0,.075)'
        //     ),
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
        //       'name' => 'btn-box-shadow',
        //       'callback' => function ($value) {
        //         return $this->get_box_shadow_string($value);
        //       }
        //     ]
        //   ]
        // ));

        // Kirki::add_field( 'btn_active_box_shadow', array(
        //   'type'        => 'repeater',
        //   'label'       => esc_attr__( 'Button Active Box Shadow', TEXT_DOMAIN ),
        //   'section'     => 'btn_shadow',
        //   'priority'    => 30,
        //   'row_label' => array(
        //     'type' => 'text',
        //     'value' => esc_attr__('Box Shadow', TEXT_DOMAIN ),
        //   ),
        //   'settings'    => 'btn_active_box_shadow',
        //   'default'     => array(
        //     array(
        //       'inset' => '1',
        //       'x_offset' => 0,
        //       'y_offset' => 3,
        //       'blur' => 5,
        //       'spread' => 0,
        //       'color' => 'rgba(0,0,0,.125)'
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
        //       'name' => 'btn-active-box-shadow',
        //       'callback' => function ($value) {
        //         return $this->get_box_shadow_string($value);
        //       }
        //     ]
        //   ]
        // ));

        return $this;
      }

      public function set_btn_colors() {

        $primary_defs = [
          'bg' => '#002F6D',
          'text' => '#fff',
          'border' => '#002F6D'
        ];

        Kirki::add_field('btn_primary_colors', array(
          'type' => 'multicolor',
          'settings' => 'btn_primary_colors',
          'label' => esc_attr__('Primary Button Colors', TEXT_DOMAIN),
          'section' => 'btn_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
              'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
          ),
          'default'     => array(
              'bg'    => $this->check_theme_color('brand_primary', get_theme_mod('btn_primary_colors', $primary_defs), 'bg'),
              'text'   => '#fff',
              'border' => $this->check_theme_color('brand_primary', get_theme_mod('btn_primary_colors', $primary_defs), 'border'),
          ),
          'variables' => [
            [
              'name' => 'btn-primary-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'btn-primary-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ],
            [
              'name' => 'btn-primary-border',
              'callback' => function($value) {
                return $value['border'];
              }
            ]
          ],
          'priority' => 10
        ));

        $inverse_defs = [
          'bg' => '#373a3c',
          'text' => '#fff',
          'border' => '#ccc'
        ];

        Kirki::add_field('btn_inverse_colors', array(
          'type' => 'multicolor',
          'settings' => 'btn_inverse_colors',
          'label' => esc_attr__('Secondary Button Colors', TEXT_DOMAIN),
          'section' => 'btn_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
              'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
          ),
          'default'     => array(
              'bg' => $this->check_theme_color('gray_dark', get_theme_mod('btn_inverse_colors', $inverse_defs), 'bg'),
              'text'   => '#fff',
              'border' => '#ccc'
          ),
          'variables' => [
            [
              'name' => 'btn-secondary-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'btn-secondary-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ],
            [
              'name' => 'btn-secondary-border',
              'callback' => function($value) {
                return $value['border'];
              }
            ]
          ],
          'priority' => 20
        ));

        $info_def = [
          'bg' => '#8d7332',
          'text' => '#fff',
          'border' => '#8d7332'
        ];

        Kirki::add_field('btn_info_colors', array(
          'type' => 'multicolor',
          'settings' => 'btn_info_colors',
          'label' => esc_attr__('Info Button Colors', TEXT_DOMAIN),
          'section' => 'btn_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
              'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
          ),
          'default'     => array(
              'bg'    => $this->check_theme_color('brand_info', get_theme_mod('btn_info_colors', $info_def), 'bg'),
              'text'   => '#fff',
              'border' => $this->check_theme_color('brand_info', get_theme_mod('btn_info_colors', $info_def), 'border')
          ),
          'variables' => [
            [
              'name' => 'btn-info-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'btn-info-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ],
            [
              'name' => 'btn-info-border',
              'callback' => function($value) {
                return $value['border'];
              }
            ]
          ],
          'priority' => 30
        ));

        $success_def = [
          'bg' => '#00833f',
          'text' => '#fff',
          'border' => '#00833f'
        ];

        Kirki::add_field('btn_success_colors', array(
          'type' => 'multicolor',
          'settings' => 'btn_success_colors',
          'label' => esc_attr__('Success Button Colors', TEXT_DOMAIN),
          'section' => 'btn_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
              'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
          ),
          'default'     => array(
              'bg'    => $this->check_theme_color('brand_success', get_theme_mod('btn_success_colors', $success_def), 'bg'),
              'text'   => '#fff',
              'border' => $this->check_theme_color('brand_success', get_theme_mod('btn_success_colors', $success_def), 'border')
          ),
          'variables' => [
            [
              'name' => 'btn-success-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'btn-success-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ],
            [
              'name' => 'btn-success-border',
              'callback' => function($value) {
                return $value['border'];
              }
            ]
          ],
          'priority' => 40
        ));

        $warning_def = [
          'bg' => '#ea7200',
          'text' => '#fff',
          'border' => '#ea7200'
        ];

        Kirki::add_field('btn_warning_colors', array(
          'type' => 'multicolor',
          'settings' => 'btn_warning_colors',
          'label' => esc_attr__('Warning Button Colors', TEXT_DOMAIN),
          'section' => 'btn_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
              'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
          ),
          'default'     => array(
              'bg'    => $this->check_theme_color('brand_warning', get_theme_mod('btn_warning_colors', $warning_def), 'bg'),
              'text'   => '#fff',
              'border' => $this->check_theme_color('brand_warning', get_theme_mod('btn_warning_colors', $warning_def), 'border')
          ),
          'variables' => [
            [
              'name' => 'btn-warning-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'btn-warning-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ],
            [
              'name' => 'btn-warning-border',
              'callback' => function($value) {
                return $value['border'];
              }
            ]
          ],
          'priority' => 50
        ));

        $danger_def = [
          'bg' => '#ac1f2d',
          'text' => '#fff',
          'border' => '#ac1f2d'
        ];

        Kirki::add_field('btn_danger_colors', array(
          'type' => 'multicolor',
          'settings' => 'btn_danger_colors',
          'label' => esc_attr__('Danger Button Colors', TEXT_DOMAIN),
          'section' => 'btn_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
              'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
          ),
          'default'     => array(
              'bg'    => $this->check_theme_color('brand_danger', get_theme_mod('btn_danger_colors', $danger_def), 'bg'),
              'text'   => '#fff',
              'border' => $this->check_theme_color('brand_danger', get_theme_mod('btn_danger_colors', $danger_def), 'border')
          ),
          'variables' => [
            [
              'name' => 'btn-danger-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'btn-danger-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ],
            [
              'name' => 'btn-danger-border',
              'callback' => function($value) {
                return $value['border'];
              }
            ]
          ],
          'priority' => 60
        ));

        Kirki::add_field('btn_pagination_colors', array(
          'type' => 'multicolor',
          'settings' => 'btn_pagination_colors',
          'label' => esc_attr__('Pagination Link Colors', TEXT_DOMAIN),
          'section' => 'btn_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
              'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
          ),
          'default'     => array(
              'bg'    => '#fff',
              'text'   => $this->check_theme_color('brand_primary', get_theme_mod('btn_primary_colors', $primary_defs), 'text'),
              'border' => "rgba(171,30,35,0.2)",
          ),
          'variables' => [
            [
              'name' => 'pagination-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'pagination-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ],
            [
              'name' => 'pagination-border-color',
              'callback' => function($value) {
                return $value['border'];
              }
            ]
          ],
          'priority' => 70
        ));

        Kirki::add_field('btn_pagination_hover_colors', array(
          'type' => 'multicolor',
          'settings' => 'btn_pagination_hover_colors',
          'label' => esc_attr__('Hover Pagination Link Colors', TEXT_DOMAIN),
          'section' => 'btn_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
              'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
          ),
          'default'     => array(
              'bg'    => $this->check_theme_color('brand_primary', get_theme_mod('btn_primary_colors', $primary_defs), 'bg'),
              'text'   => '#fff',
              'border' => "#fff",
          ),
          'variables' => [
            [
              'name' => 'pagination-hover-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'pagination-hover-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ],
            [
              'name' => 'pagination-hover-border',
              'callback' => function($value) {
                return $value['border'];
              }
            ]
          ],
          'priority' => 80
        ));

        Kirki::add_field('btn_pagination_active_colors', array(
          'type' => 'multicolor',
          'settings' => 'btn_pagination_active_colors',
          'label' => esc_attr__('Active Pagination Link Colors', TEXT_DOMAIN),
          'section' => 'btn_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
              'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
          ),
          'default'     => array(
              'bg'    => $this->check_theme_color('brand_primary', get_theme_mod('btn_primary_colors', $primary_defs), 'bg'),
              'text'   => '#fff',
              'border' => "#fff",
          ),
          'variables' => [
            [
              'name' => 'pagination-active-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'pagination-active-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ],
            [
              'name' => 'pagination-active-border',
              'callback' => function($value) {
                return $value['border'];
              }
            ]
          ],
          'priority' => 90
        ));

        Kirki::add_field('btn_pagination_disabled_colors', array(
          'type' => 'multicolor',
          'settings' => 'btn_pagination_disabled_colors',
          'label' => esc_attr__('Disabled Pagination Link Colors', TEXT_DOMAIN),
          'section' => 'btn_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN ),
              'border' => esc_attr__( 'Border', TEXT_DOMAIN ),
          ),
          'default'     => array(
              'bg'    => '#b78d8e',
              'text'   => '#fff',
              'border' => "#fff",
          ),
          'variables' => [
            [
              'name' => 'pagination-disabled-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'pagination-disabled-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ],
            [
              'name' => 'pagination-disabled-border',
              'callback' => function($value) {
                return $value['border'];
              }
            ]
          ],
          'priority' => 100
        ));

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
