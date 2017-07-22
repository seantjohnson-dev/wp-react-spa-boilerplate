<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
  use Kirki as Kirki;

  class Scaffolding extends BaseCustomizer
  {
      public function set_panels()
      {
          Kirki::add_panel('scaffolding', array(
            'priority' => 30,
            'title' => __('Scaffolding', TEXT_DOMAIN),
            'description' => __('Configure the scaffolding of your theme elements here.', TEXT_DOMAIN),
         ));

          return $this;
      }

      public function set_sections()
      {

          Kirki::add_section('design_features', array(
            'title' => __('Design Features', TEXT_DOMAIN),
            // 'description' => __('General site structure settings.', TEXT_DOMAIN),
            'panel' => 'scaffolding',
            'priority' => 5,
          ));

          // Kirki::add_section('scaffolding_margin', array(
          //   'title' => __('Margin', TEXT_DOMAIN),
          //   // 'description' => __('General site structure settings.', TEXT_DOMAIN),
          //   'panel' => 'scaffolding',
          //   'priority' => 10,
          // ));

          // Kirki::add_section('scaffolding_padding', array(
          //   'title' => __('Padding', TEXT_DOMAIN),
          //   // 'description' => __('Site layout settings.', TEXT_DOMAIN),
          //   'panel' => 'scaffolding',
          //   'priority' => 20,
          // ));

          // Kirki::add_section('scaffolding_border', array(
          //   'title' => __('Border', TEXT_DOMAIN),
          //   // 'description' => __('CSS responsive grid values.', TEXT_DOMAIN),
          //   'panel' => 'scaffolding',
          //   'priority' => 30,
          // ));

          // Kirki::add_section('shade_colors', array(
          //   'title' => __('Shade Colors', TEXT_DOMAIN),
          //   // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
          //   'panel' => 'scaffolding',
          //   'priority' => 40,
          // ));

          // Kirki::add_section('global_colors', array(
          //   'title' => __('Global Colors', TEXT_DOMAIN),
          //   // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
          //   'panel' => 'scaffolding',
          //   'priority' => 50,
          // ));

          // Kirki::add_section('global_grid', array(
          //   'title' => __('Responsive Grid', TEXT_DOMAIN),
          //   // 'description' => __('Configure the primary colors for your theme.', TEXT_DOMAIN),
          //   'panel' => 'scaffolding',
          //   'priority' => 60,
          // ));

          return $this;
      }

      public function set_controls()
      {
          $this->set_design_features();
          $this->set_margin_controls();
          $this->set_border_controls();
          $this->set_shade_colors();
          $this->set_global_colors();
          $this->set_breakpoint_controls();
          $this->set_container_controls();
          $this->set_column_controls();

          return $this;
      }

      public function set_design_features() {

        Kirki::add_field( 'enable_rounded', array(
          'type'        => 'toggle',
          'settings'    => 'enable_rounded',
          'label'       => __( 'Enable Rounded Corners', TEXT_DOMAIN ),
          'section'     => 'design_features',
          'default'     => '0',
          'priority'    => 10,
          'choices'     => array(
            'on'  => esc_attr__( 'Enable', TEXT_DOMAIN ),
            'off' => esc_attr__( 'Disable', TEXT_DOMAIN )
          ),
          'variables' => [
            [
              'name' => 'enable-rounded',
              'callback' => function ($value) {
                if ($value) {
                  return 'true';
                }
                return 'false';
              }
            ]
          ]
        ));


        Kirki::add_field( 'enable_shadows', array(
          'type'        => 'toggle',
          'settings'    => 'enable_shadows',
          'label'       => __( 'Enable Drop Shadows', TEXT_DOMAIN ),
          'section'     => 'design_features',
          'default'     => '0',
          'priority'    => 20,
          'choices'     => array(
            'on'  => esc_attr__( 'Enable', TEXT_DOMAIN ),
            'off' => esc_attr__( 'Disable', TEXT_DOMAIN )
          ),
          'variables' => [
            [
              'name' => 'enable-shadows',
              'callback' => function ($value) {
                if ($value) {
                  return 'true';
                }
                return 'false';
              }
            ]
          ]
        ));

        Kirki::add_field( 'enable_transitions', array(
          'type'        => 'toggle',
          'settings'    => 'enable_transitions',
          'label'       => __( 'Enable Transitions', TEXT_DOMAIN ),
          'section'     => 'design_features',
          'default'     => '0',
          'priority'    => 30,
          'choices'     => array(
            'on'  => esc_attr__( 'Enable', TEXT_DOMAIN ),
            'off' => esc_attr__( 'Disable', TEXT_DOMAIN )
          ),
          'variables' => [
            [
              'name' => 'enable-transitions',
              'callback' => function ($value) {
                if ($value) {
                  return 'true';
                }
                return 'false';
              }
            ]
          ]
        ));

        Kirki::add_field( 'enable_gradients', array(
          'type'        => 'toggle',
          'settings'    => 'enable_gradients',
          'label'       => __( 'Enable Background Gradients', TEXT_DOMAIN ),
          'section'     => 'design_features',
          'default'     => '0',
          'priority'    => 40,
          'choices'     => array(
            'on'  => esc_attr__( 'Enable', TEXT_DOMAIN ),
            'off' => esc_attr__( 'Disable', TEXT_DOMAIN )
          ),
          'variables' => [
            [
              'name' => 'enable-gradients',
              'callback' => function ($value) {
                if ($value) {
                  return 'true';
                }
                return 'false';
              }
            ]
          ]
        ));

        return $this;
      }

      public function set_margin_controls()
      {

          Kirki::add_field( 'margins', array(
            'type'        => 'spacing',
            'settings'    => 'margins',
            'label'       => __( 'Margins', TEXT_DOMAIN),
            'section'     => 'scaffolding_margin',
            'default'     => array(
              'top' => '1rem',
              'left' => '1rem'
            ),
            'variables' => [
              [
                'name' => 'spacer-x',
                'callback' => function($value) {
                  return $value['left'];
                }
              ],
              [
                'name' => 'spacer-y',
                'callback' => function($value) {
                  return $value['top'];
                }
              ]
            ],
            'priority' => 10
          ));

          return $this;
      }

      public function set_padding_controls() {


        Kirki::add_field('input_padding', array(
          'type' => 'spacing',
          'settings' => 'input_padding',
          'label' => __('Input Padding', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'scaffolding_padding',
          'priority' => 20,
          'default'     => array(
            'left'    => '0.75rem',
            'top' => '0.5rem'
          ),
          'variables' => [
            [
              'name' => 'input-padding-x',
              'callback' => function ($value) {
                return $value['left'];
              }
            ],
            [
              'name' => 'input-padding-x-sm',
              'callback' => function ($value) {
                return str_replace(floatval($value['left']), (2 * floatval($value['left'])/3), $value['left']);
              }
            ],
            [
              'name' => 'input-padding-x-lg',
              'callback' => function ($value) {
                return str_replace(floatval($value['left']), (floatval($value['left']) * 2), $value['left']);
              }
            ],
            [
              'name' => 'input-padding-y',
              'callback' => function ($value) {
                return $value['top'];
              }
            ],
            [
              'name' => 'input-padding-y-sm',
              'callback' => function ($value) {
                return str_replace(floatval($value['top']), (floatval($value['top']) /2), $value['top']);
              }
            ],
            [
              'name' => 'input-padding-y-lg',
              'callback' => function ($value) {
                return str_replace(floatval($value['top']), (floatval($value['top']) * 1.5), $value['top']);
              }
            ]
          ]
        ));

        Kirki::add_field('table_cell_padding', array(
          'type' => 'dimension',
          'settings' => 'table_cell_padding',
          'label' => __('Table Cell Padding', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'scaffolding_padding',
          'priority' => 50,
          'default' => '.75rem',
          'variables' => [
            [
              'name' => 'table-cell-padding'
            ],
            [
              'name' => 'table-sm-cell-padding',
              'callback' => function ($value) {
                return str_replace(floatval($value), (floatval($value) * 0.4), $value);
              }
            ]
          ]
        ));

        return $this;
      }

      public function set_border_controls() {

        Kirki::add_field('border_width', array(
          'type' => 'dimension',
          'settings' => 'border_width',
          'label' => __('Border Width', TEXT_DOMAIN),
          'section' => 'scaffolding_border',
          'priority' => 10,
          'default' => '1px',
          'variables' => [
            [
              'name' => 'border-width'
            ],
            [
              'name' => 'table-border-width'
            ]
          ]
        ));

        Kirki::add_field('border_radius', array(
          'type' => 'dimension',
          'settings' => 'border_radius',
          'label' => __('Border Radius', TEXT_DOMAIN),
          'section' => 'scaffolding_border',
          'priority' => 20,
          'default' => '.25rem',
          'active_callback' => array(
            array(
              'setting'  => 'enable_rounded',
              'operator' => '==',
              'value'    => 1
            )
          ),
          'variables' => [
            [
              'name' => 'border-radius'
            ],
            [
              'name' => 'border-radius-sm',
              'callback' => function ($value) {
                return str_replace(floatval($value), (floatval($value) * 0.8), $value);
              }
            ],
            [
              'name' => 'border-radius-lg',
              'callback' => function ($value) {
                return str_replace(floatval($value), (floatval($value) * 1.2), $value);
              }
            ],
            [
              'name' => 'input-border-radius'
            ],
            [
              'name' => 'input-border-radius-sm',
              'callback' => function ($value) {
                return str_replace(floatval($value), (floatval($value) * 0.8), $value);
              }
            ],
            [
              'name' => 'input-border-radius-lg',
              'callback' => function ($value) {
                return str_replace(floatval($value), (floatval($value) * 1.2), $value);
              }
            ]
          ]
        ));
        return $this;
      }



      public function set_shade_colors() {


        Kirki::add_field('gray_dark', array(
          'type' => 'color',
          'settings' => 'gray_dark',
          'label' => esc_attr__('Gray Dark', TEXT_DOMAIN),
          'section' => 'shade_colors',
          'default' => '#373a3c',
          'variables' => [
            [
              'name' => 'gray-dark'
            ]
          ],
          'priority' => 10,
        ));

        Kirki::add_field('gray', array(
          'type' => 'color',
          'settings' => 'gray',
          'label' => esc_attr__('Gray', TEXT_DOMAIN),
          'section' => 'shade_colors',
          'default' => '#55595c',
          'variables' => [
            [
              'name' => 'gray'
            ]
          ],
          'priority' => 20,
        ));

        Kirki::add_field('gray_light', array(
          'type' => 'color',
          'settings' => 'gray_light',
          'label' => esc_attr__('Gray Light', TEXT_DOMAIN),
          'section' => 'shade_colors',
          'default' => '#818a91',
          'variables' => [
            [
              'name' => 'gray-light'
            ]
          ],
          'priority' => 30,
        ));

        Kirki::add_field('gray_lighter', array(
          'type' => 'color',
          'settings' => 'gray_lighter',
          'label' => esc_attr__('Gray Lighter', TEXT_DOMAIN),
          'section' => 'shade_colors',
          'default' => '#eceeef',
          'variables' => [
            [
              'name' => 'gray-lighter'
            ]
          ],
          'priority' => 40,
        ));

        Kirki::add_field('gray_lightest', array(
          'type' => 'color',
          'settings' => 'gray_lightest',
          'label' => esc_attr__('Gray Lightest', TEXT_DOMAIN),
          'section' => 'shade_colors',
          'default' => '#f7f7f9',
          'variables' => [
            [
              'name' => 'gray-lightest'
            ]
          ],
          'priority' => 50,
        ));

        return $this;
      }

      public function set_global_colors() {

        Kirki::add_field('body_colors', array(
          'type' => 'multicolor',
          'settings' => 'body_colors',
          'label' => esc_attr__('Body Colors', TEXT_DOMAIN),
          'section' => 'global_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN )
          ),
          'default'     => array(
              'bg'    => '#fff',
              'text'   => get_theme_mod('gray_dark', '#373a3c')
          ),
          'variables' => [
            [
              'name' => 'body-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'body-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ]
          ],
          'priority' => 10
        ));

        Kirki::add_field('header_colors', array(
          'type' => 'multicolor',
          'settings' => 'header_colors',
          'label' => esc_attr__('Header Colors', TEXT_DOMAIN),
          'section' => 'global_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN )
          ),
          'default'     => array(
              'bg'    => '#fff',
              'text'   => get_theme_mod('gray_dark', '#373a3c')
          ),
          'variables' => [
            [
              'name' => 'header-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'header-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ]
          ],
          'priority' => 20
        ));

        Kirki::add_field('footer_colors', array(
          'type' => 'multicolor',
          'settings' => 'footer_colors',
          'label' => esc_attr__('Footer Colors', TEXT_DOMAIN),
          'section' => 'global_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN )
          ),
          'default'     => array(
              'bg'    => get_theme_mod('brand_primary', ''),
              'text'   => '#fff'
          ),
          'variables' => [
            [
              'name' => 'footer-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'footer-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ]
          ],
          'priority' => 30,
          'output' => array(
            array(
              'element'  => '.page-footer',
              'property' => 'color'
            ),
            array(
              'element'  => '.page-footer',
              'property' => 'background-color'
            )
          ),
        ));

        Kirki::add_field('active_colors', array(
          'type' => 'multicolor',
          'settings' => 'active_colors',
          'label' => esc_attr__('Active Colors', TEXT_DOMAIN),
          'section' => 'global_colors',
          'choices'     => array(
              'bg'    => esc_attr__( 'Background', TEXT_DOMAIN),
              'text'   => esc_attr__( 'Text', TEXT_DOMAIN )
          ),
          'default'     => array(
              'bg'    => $this->get_default_active_bg(),
              'text'   => '#fff'
          ),
          'variables' => [
            [
              'name' => 'component-active-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'component-active-bg',
              'callback' => function($value) {
                return $value['bg'];
              }
            ]
          ],
          'priority' => 40
        ));

        Kirki::add_field('link_colors', array(
          'type' => 'multicolor',
          'settings' => 'link_colors',
          'label' => esc_attr__('Link Colors', TEXT_DOMAIN),
          'section' => 'global_colors',
          'choices'     => array(
              'text'   => esc_attr__('Text', TEXT_DOMAIN ),
              'hover' => esc_attr__('Hover', TEXT_DOMAIN )
          ),
          'default'     => array(
              'text'   => get_theme_mod('brand_primary', ''),
              'hover' => get_theme_mod('brand_primary', '')
          ),
          'variables' => [
            [
              'name' => 'link-color',
              'callback' => function($value) {
                return $value['text'];
              }
            ],
            [
              'name' => 'link-hover-color',
              'callback' => function($value) {
                return $value['hover'];
              }
            ]
          ],
          'priority' => 50
        ));

        return $this;
      }

      public function set_breakpoint_controls() {

        Kirki::add_field( 'breakpoint_heading', array(
          'type'        => 'custom',
          'settings'    => 'breakpoint_heading',
          // 'label'       => __( 'This is the label', 'my_textdomain' ),
          'section'     => 'global_grid',
          'default'     => '<h2>Breakpoint Settings</h2><hr/>',
          'priority'    => 5,
        ));


        Kirki::add_field( 'grid_bp_sm', array(
          'type'        => 'slider',
          'settings'    => 'grid_bp_sm',
          'label'       => esc_attr__( 'Mobile Breakpoint', TEXT_DOMAIN ),
          'section'     => 'global_grid',
          'default'     => 576,
          'priority' => 10,
          'choices'     => array(
            'min'  => '384',
            'max'  => '639',
            'step' => '1',
          ),
        ));

        Kirki::add_field( 'grid_bp_md', array(
          'type'        => 'slider',
          'settings'    => 'grid_bp_md',
          'label'       => esc_attr__( 'Tablet Breakpoint', TEXT_DOMAIN ),
          'section'     => 'global_grid',
          'default'     => 768,
          'priority' => 20,
          'choices'     => array(
            'min'  => '640',
            'max'  => '859',
            'step' => '1',
          ),
        ));

        Kirki::add_field( 'grid_bp_lg', array(
          'type'        => 'slider',
          'settings'    => 'grid_bp_lg',
          'label'       => esc_attr__( 'Desktop Breakpoint', TEXT_DOMAIN ),
          'section'     => 'global_grid',
          'default'     => 992,
          'priority' => 30,
          'choices'     => array(
            'min'  => '860',
            'max'  => '1199',
            'step' => '1',
          ),
        ));

        Kirki::add_field( 'grid_bp_xl', array(
          'type'        => 'slider',
          'settings'    => 'grid_bp_xl',
          'label'       => esc_attr__( 'XL Desktop Breakpoint', TEXT_DOMAIN ),
          'section'     => 'global_grid',
          'default'     => 1200,
          'priority' => 40,
          'choices'     => array(
            'min'  => '1200',
            'max'  => '1400',
            'step' => '1',
          ),
        ));
        return $this;
      }

      public function set_container_controls() {

        Kirki::add_field( 'container_heading', array(
          'type'        => 'custom',
          'settings'    => 'container_heading',
          // 'label'       => __( 'This is the label', 'my_textdomain' ),
          'section'     => 'global_grid',
          'default'     => '<br/><h2>Container Settings</h2><hr/>',
          'priority'    => 50,
        ));


        Kirki::add_field( 'grid_container_sm', array(
          'type'        => 'slider',
          'settings'    => 'grid_container_sm',
          'label'       => esc_attr__( 'Mobile Container Max Width', TEXT_DOMAIN ),
          'section'     => 'global_grid',
          'default'     => 540,
          'priority' => 60,
          'choices'     => array(
            'min'  => '360',
            'max'  => '619',
            'step' => '1',
          ),
        ));

        Kirki::add_field( 'grid_container_md', array(
          'type'        => 'slider',
          'settings'    => 'grid_container_md',
          'label'       => esc_attr__( 'Tablet Container Max Width', TEXT_DOMAIN ),
          'section'     => 'global_grid',
          'default'     => 720,
          'priority' => 70,
          'choices'     => array(
            'min'  => '620',
            'max'  => '839',
            'step' => '1',
          ),
        ));

        Kirki::add_field( 'grid_container_lg', array(
          'type'        => 'slider',
          'settings'    => 'grid_container_lg',
          'label'       => esc_attr__( 'Desktop Container Max Width', TEXT_DOMAIN ),
          'section'     => 'global_grid',
          'default'     => 960,
          'priority' => 80,
          'choices'     => array(
            'min'  => '840',
            'max'  => '1049',
            'step' => '1',
          ),
        ));

        Kirki::add_field( 'grid_container_xl', array(
          'type'        => 'slider',
          'settings'    => 'grid_container_xl',
          'label'       => esc_attr__( 'XL Desktop Container Max Width', TEXT_DOMAIN ),
          'section'     => 'global_grid',
          'default'     => 1140,
          'priority' => 90,
          'choices'     => array(
            'min'  => '1050',
            'max'  => '1280',
            'step' => '1',
          ),
        ));
        return $this;
      }

      public function set_column_controls() {

        Kirki::add_field( 'gutter_heading', array(
          'type'        => 'custom',
          'settings'    => 'gutter_heading',
          // 'label'       => __( 'This is the label', 'my_textdomain' ),
          'section'     => 'global_grid',
          'default'     => '<br/><h2>Column Settings</h2><hr/>',
          'priority'    => 100,
        ));

        Kirki::add_field('grid_columns', array(
          'type' => 'radio-buttonset',
          'settings' => 'grid_columns',
          'label' => __('Grid Columns', TEXT_DOMAIN),
          'section' => 'global_grid',
          'default' => '12',
          'priority' => 110,
          'choices'     => array(
            '6'  => esc_attr__( '6', TEXT_DOMAIN ),
            '12'  => esc_attr__( '12', TEXT_DOMAIN ),
            '24' => esc_attr__( '24', TEXT_DOMAIN )
          ),
          'variables' => [
            [
              'name' => 'grid-columns'
            ]
          ]
        ));

        Kirki::add_field('grid_gutter_width', array(
          'type' => 'number',
          'settings' => 'grid_gutter_width',
          'label' => __('Grid Gutter Width (px)', TEXT_DOMAIN),
          'section' => 'global_grid',
          'default' => 30,
          'priority' => 120,
          'choices'     => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 1
          ),
          'variables' => [
            [
              'name' => 'grid-gutter-width-base',
              'callback' => function($value) {
                return intval($value) . 'px';
              }
            ]
          ]
        ));
      }

      public function get_default_link_color() {
        if (empty(get_theme_mod('link_color', ''))) {
          return get_theme_mod('brand_primary', '');
        }
        return get_theme_mod('link_color', '#F05338');
      }

      public function get_default_active_bg() {
        $active_colors = get_theme_mod('active_colors', []);
        if (empty($active_colors) || empty($active_colors['bg']) || !isset($active_colors['bg'])) {
          return get_theme_mod('brand_primary', '');
        }
        return get_theme_mod('active_colors', [
          'bg' => get_theme_mod('brand_primary', ''),
          'text' => '#fff'
        ])['bg'];
      }


  }
