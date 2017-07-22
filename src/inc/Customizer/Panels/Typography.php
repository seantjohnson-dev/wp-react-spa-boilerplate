<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
  use Kirki as Kirki;
  use Kirki_Fonts as Kirki_Fonts;

  class Typography extends BaseCustomizer
  {
      public function set_panels()
      {
          Kirki::add_panel('typography', array(
            'priority' => 40,
            'title' => __('Typography', TEXT_DOMAIN),
            'description' => __('Configure the font options for your theme.', TEXT_DOMAIN),
          ));

          return $this;
      }

      public function set_sections()
      {
          Kirki::add_section('font_families', array(
            'title' => __('Font Families', TEXT_DOMAIN),
            // 'description' => __('Define the base font.', TEXT_DOMAIN),
            'panel' => 'typography',
            'priority' => 10
          ));

          Kirki::add_section('font_sizes', array(
            'title' => __('Font Sizes', TEXT_DOMAIN),
            // 'description' => __('Define the base font.', TEXT_DOMAIN),
            'panel' => 'typography',
            'priority' => 20
          ));

          Kirki::add_section('line_heights', array(
            'title' => __('Line Height', TEXT_DOMAIN),
            // 'description' => __('CSS responsive grid values.', TEXT_DOMAIN),
            'panel' => 'typography',
            'priority' => 30
          ));

          Kirki::add_section('typekit_api', array(
            'title' => __('Typekit API', TEXT_DOMAIN),
            // 'description' => __('CSS responsive grid values.', TEXT_DOMAIN),
            'panel' => 'typography',
            'priority' => 40
          ));

          return $this;
      }

      public function set_controls()
      {
          $this->set_font_families()->set_font_sizes()->set_line_height_controls();
          // $this->set_typekit_api_controls();

          return $this;
      }

      public function set_font_families()
      {


          Kirki::add_field( 'font_separator', array(
            'type'        => 'custom',
            'settings'    => 'font_separator',
            // 'label'       => __( 'This is the label', 'my_textdomain' ),
            'section'     => 'font_families',
            'default'     => '<hr/>',
            'priority'    => 15,
          ));

          Kirki::add_field('font_family_sans_serif', array(
            'type' => 'typography',
            'settings' => 'font_family_sans_serif',
            'label' => __('Sans-Serif Font Family', TEXT_DOMAIN),
            'section' => 'font_families',
            'default'     => array(
              'font-family'    => 'Roboto',
              'variant'        => 'regular',
              'subsets'        => array( 'latin-ext' )
            ),
            'priority' => 20,
            'variables' => [
              [
                'name' => 'font-family-sans-serif',
                'callback' => function($value) {
                    return $value['font-family'] . ', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
                }
              ]
            ]
          ));

          Kirki::add_field('font_family_serif', array(
            'type' => 'typography',
            'settings' => 'font_family_serif',
            'label' => __('Serif Font Family', TEXT_DOMAIN),
            'section' => 'font_families',
            'default'     => array(
              'font-family'    => 'Roboto Slab',
              'variant'        => 'regular',
              'subsets'        => array( 'latin-ext' )
            ),
            'priority' => 30,
            'variables' => [
              [
                'name' => 'font-family-serif',
                'callback' => function($value) {
                    return $value['font-family'] . ', Georgia, "Times New Roman", Times, serif';
                }
              ]
            ]
          ));

          Kirki::add_field('font_family_monospace', array(
            'type' => 'typography',
            'settings' => 'font_family_monospace',
            'label' => __('Monospace Font Family', TEXT_DOMAIN),
            'section' => 'font_families',
            'default'     => array(
              'font-family'    => 'Roboto Mono',
              'variant'        => 'regular',
              'subsets'        => array('latin-ext')
            ),
            'priority' => 40,
            'variables' => [
              [
                'name' => 'font-family-monospace',
                'callback' => function($value) {
                    return $value['font-family'] . ', Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace';
                }
              ]
            ]
          ));

          Kirki::add_field('font_family_base', array(
            'type' => 'radio',
            'settings' => 'font_family_base',
            'label' => __('Base Font Family', TEXT_DOMAIN),
            'section' => 'font_families',
            'default' => 'sans_serif',
            'priority' => 10,
            'choices' => array(
              'sans_serif' => esc_attr__('Sans-Serif', TEXT_DOMAIN),
              'serif' => esc_attr__('Serif', TEXT_DOMAIN),
              'monospace' => esc_attr__('Monospace', TEXT_DOMAIN),
            ),
            'variables' => [
              [
                'name' => 'font-family-base',
                'callback' => [$this, 'set_base_font_family']
              ]
            ]
          ));

          return $this;
      }

      public function set_font_sizes() {

        Kirki::add_field( 'global_sizes', array(
          'type'        => 'custom',
          'settings'    => 'global_sizes',
          // 'label'       => __( 'This is the label', 'my_textdomain' ),
          'section'     => 'font_sizes',
          'default'     => '<h2 class="section-break">Global Font Sizes</h2><hr/>',
          'priority'    => 5,
        ));


        Kirki::add_field('font_size_root', array(
          'type' => 'number',
          'settings' => 'font_size_root',
          'label' => __('Base Font Size', TEXT_DOMAIN),
          'section' => 'font_sizes',
          'default' => 16,
          'priority' => 10,
          'choices'     => array(
            'min'  => 0,
            'max'  => 24,
            'step' => 1
          ),
          'variables' => [
            [
              'name' => 'font-size-root',
              'callback' => function($value) {
                return intval($value) . 'px';
              }
            ]
          ]
        ));

        Kirki::add_field('font_size_sm', array(
          'type' => 'number',
          'settings' => 'font_size_sm',
          'label' => __('Small (Mobile) Font Size', TEXT_DOMAIN),
          'section' => 'font_sizes',
          'default' => 0.875,
          'priority' => 20,
          'choices' => array(
            'min'  => 0.2,
            'max'  => 1,
            'step' => 0.001
          ),
          'variables' => [
            [
              'name' => 'font-size-sm',
              'callback' => function($value) {
                return floatval($value) . 'rem';
              }
            ]
          ]
        ));

        Kirki::add_field('font_size_lg', array(
          'type' => 'number',
          'settings' => 'font_size_lg',
          'label' => __('Large (Desktop) Font Size', TEXT_DOMAIN),
          'section' => 'font_sizes',
          'default' => 1.25,
          'priority' => 30,
          'choices' => array(
            'min'  => 1,
            'max'  => 5,
            'step' => 0.01
          ),
          'variables' => [
            [
              'name' => 'font-size-lg',
              'callback' => function($value) {
                return floatval($value) . 'rem';
              }
            ]
          ]
        ));

        Kirki::add_field( 'heading_sizes', array(
          'type'        => 'custom',
          'settings'    => 'heading_sizes',
          // 'label'       => __( 'This is the label', 'my_textdomain' ),
          'section'     => 'font_sizes',
          'default'     => '<br/><h2 class="section-break">Heading Font Sizes</h2><hr/>',
          'priority'    => 35,
        ));

        Kirki::add_field('font_size_h1', array(
          'type' => 'number',
          'settings' => 'font_size_h1',
          'label' => __('H1 Font Size', TEXT_DOMAIN),
          'section' => 'font_sizes',
          'default' => 2.5,
          'priority' => 40,
          'choices' => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 0.01
          ),
          'variables' => [
            [
              'name' => 'font-size-h1',
              'callback' => function($value) {
                return floatval($value) . 'rem';
              }
            ]
          ]
        ));

        Kirki::add_field('font_size_h2', array(
          'type' => 'number',
          'settings' => 'font_size_h2',
          'label' => __('H2 Font Size', TEXT_DOMAIN),
          'section' => 'font_sizes',
          'default' => 2.0,
          'priority' => 50,
          'choices' => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 0.01
          ),
          'variables' => [
            [
              'name' => 'font-size-h2',
              'callback' => function($value) {
                return floatval($value) . 'rem';
              }
            ]
          ]
        ));

        Kirki::add_field('font_size_h3', array(
          'type' => 'number',
          'settings' => 'font_size_h3',
          'label' => __('H3 Font Size', TEXT_DOMAIN),
          'section' => 'font_sizes',
          'default' => 1.75,
          'priority' => 60,
          'choices' => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 0.01
          ),
          'variables' => [
            [
              'name' => 'font-size-h3',
              'callback' => function($value) {
                return floatval($value) . 'rem';
              }
            ]
          ]
        ));

        Kirki::add_field('font_size_h4', array(
          'type' => 'number',
          'settings' => 'font_size_h4',
          'label' => __('H4 Font Size', TEXT_DOMAIN),
          'section' => 'font_sizes',
          'default' => 1.5,
          'priority' => 70,
          'choices' => array(
            'min'  => 1,
            'max'  => 5,
            'step' => 0.01
          ),
          'variables' => [
            [
              'name' => 'font-size-h4',
              'callback' => function($value) {
                return floatval($value) . 'rem';
              }
            ]
          ]
        ));

        Kirki::add_field('font_size_h5', array(
          'type' => 'number',
          'settings' => 'font_size_h5',
          'label' => __('H5 Font Size', TEXT_DOMAIN),
          'section' => 'font_sizes',
          'default' => 1.25,
          'priority' => 80,
          'choices' => array(
            'min'  => 1,
            'max'  => 3,
            'step' => 0.01
          ),
          'variables' => [
            [
              'name' => 'font-size-h5',
              'callback' => function($value) {
                return floatval($value) . 'rem';
              }
            ]
          ]
        ));

        Kirki::add_field('font_size_h6', array(
          'type' => 'number',
          'settings' => 'font_size_h6',
          'label' => __('H6 Font Size', TEXT_DOMAIN),
          'section' => 'font_sizes',
          'default' => 1,
          'priority' => 90,
          'choices' => array(
            'min'  => 1,
            'max'  => 2,
            'step' => 0.01
          ),
          'variables' => [
            [
              'name' => 'font-size-h6',
              'callback' => function($value) {
                return floatval($value) . 'rem';
              }
            ]
          ]
        ));

        return $this;
      }

      public function set_line_height_controls() {

        Kirki::add_field('base_line_height', array(
          'type' => 'number',
          'settings' => 'base_line_height',
          'label' => __('Base Line Height', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'line_heights',
          'priority' => 10,
          'default' => 1.5,
          'choices' => [
            'min' => 0,
            'max' => 5,
            'step' => 0.1
          ],
          'variables' => [
            [
              'name' => 'line-height-base'
            ]
          ]
        ));

        Kirki::add_field('line_height_sm', array(
          'type' => 'number',
          'settings' => 'line_height_sm',
          'label' => __('Small (Mobile) Line Height', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'line_heights',
          'priority' => 20,
          'default' => 1.5,
          'choices' => [
            'min' => 0,
            'max' => 5,
            'step' => 0.1
          ],
          'variables' => [
            [
              'name' => 'line-height-sm'
            ]
          ]
        ));

        Kirki::add_field('line_height_lg', array(
          'type' => 'number',
          'settings' => 'line_height_lg',
          'label' => __('Large (Desktop) Line Height', TEXT_DOMAIN),
          // 'description' => __('You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', TEXT_DOMAIN),
          'section' => 'line_heights',
          'priority' => 30,
          'default' => 1.3,
          'choices' => [
            'min' => 0,
            'max' => 5,
            'step' => 0.1
          ],
          'variables' => [
            [
              'name' => 'line-height-lg'
            ]
          ]
        ));

        return $this;
      }

      public function set_base_font_family($value) {
        switch($value) {
          case 'serif':
            return '$font-family-serif';
          break;
          case 'monospace':
            return '$font-family-monospace';
          break;
          case 'sans_serif':
          default:
            return '$font-family-sans-serif';
          break;
        }
      }

      public function set_typekit_api_controls() {

        Kirki::add_field( 'enable_typekit_fonts',[ 
          'type'        => 'toggle',
          'settings'    => 'enable_typekit_fonts',
          'label'       => __( 'Enable Typekit Fonts', TEXT_DOMAIN ),
          'section'     => 'typekit_api',
          'default'     => '0',
          'priority'    => 10
        ]);

        Kirki::add_field('typekit_api_base_url', [
          'type' => 'custom',
          'settings' => 'typekit_api_base_url',
          'label' => __('Typekit API Base Url', TEXT_DOMAIN),
          'section' => 'typekit_api',
          'priority' => 20,
          'default' => '<input value="https://typekit.com/api/v1/json/" data-customize-setting-link="typekit_api_base_url" element="input" type="text" readonly="readonly" disabled="disabled" />',
          'active_callback' => [
            [
              'setting'  => 'enable_typekit_fonts',
              'operator' => '==',
              'value'    => '1'
            ]
          ]
        ]);

        Kirki::add_field('typekit_api_key', [
          'type' => 'text',
          'settings' => 'typekit_api_key',
          'label' => __('Typekit API Key', TEXT_DOMAIN),
          'description' => 'Head over to the <a href="https://www.adobe.io/console/integrations/new" target="_blank">Typekit Platform</a> to create your API Keys.',
          'section' => 'typekit_api',
          'priority' => 30,
          'default' => '',
          'active_callback' => [
            [
              'setting'  => 'enable_typekit_fonts',
              'operator' => '==',
              'value'    => '1'
            ]
          ]
        ]);


        Kirki::add_field('typekit_client_secret', [
          'type' => 'text',
          'settings' => 'typekit_client_secret',
          'label' => __('Typekit Client Secret', TEXT_DOMAIN),
          'description' => 'Head over to the <a href="https://www.adobe.io/console/integrations/new" target="_blank">Typekit Platform</a> to create your API Keys.',
          'section' => 'typekit_api',
          'priority' => 40,
          'default' => '',
          'active_callback' => [
            [
              'setting'  => 'enable_typekit_fonts',
              'operator' => '==',
              'value'    => '1'
            ]
          ]
        ]);

        Kirki::add_field('typekit_api_token', [
          'type' => 'text',
          'settings' => 'typekit_api_token',
          'label' => __('Typekit API Token', TEXT_DOMAIN),
          'description' => 'Click <a href="https://typekit.com/account/tokens" target="_blank">here</a> to create an API Token.',
          'section' => 'typekit_api',
          'priority' => 50,
          'default' => '',
          'active_callback' => [
            [
              'setting'  => 'enable_typekit_fonts',
              'operator' => '==',
              'value'    => '1'
            ],
            [
              'setting'  => 'typekit_api_key',
              'operator' => '!==',
              'value'    => ''
            ],
            [
              'setting'  => 'typekit_client_secret',
              'operator' => '!==',
              'value'    => ''
            ]
          ]
        ]);
      }

  }
