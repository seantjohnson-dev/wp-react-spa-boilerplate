<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
use SeanJohn\Utils\TemplateLoader as Loader;
use Kirki as Kirki;

class SiteIdentity extends BaseCustomizer
{

  public function on_customize_register($wp_cust) {
      parent::on_customize_register($wp_cust);
      $this->edit_existing($wp_cust);
  }

  public function set_panels()
  {
    Kirki::add_panel('site_identity', array(
      'priority' => 20,
      'title' => __('Branding', TEXT_DOMAIN),
      'description' => __('Configure you website Identity and branding here.', TEXT_DOMAIN),
    ));

    return $this;
  }

  public function set_sections()
  {
    Kirki::add_section('title_tagline', array(
      'title' => __('Titles and Descriptions', TEXT_DOMAIN),
      'panel' => 'site_identity',
      'priority' => 10
    ));

    Kirki::add_section('logos', array(
      'title' => __('Logos', TEXT_DOMAIN),
      'panel' => 'site_identity',
      'priority' => 20
    ));

    Kirki::add_section('brand_colors', array(
      'title' => __('Brand Colors', TEXT_DOMAIN),
      'panel' => 'site_identity',
      'priority' => 30
    ));

    Kirki::add_section('contact_info', array(
      'title' => __('Contact', TEXT_DOMAIN),
      'panel' => 'site_identity',
      'priority' => 40
    ));

    return $this;
  }

  public function set_controls()
  {
    $this
    ->setLogosControls()
    ->setFooterControls()
    ->setBrandColors()
    ->setContactControls();

    return $this;
  }

  public function setLogosControls() {

    Kirki::add_field('header_logo', array(
      'settings' => 'header_logo',
      'label' => __('Header Logo', TEXT_DOMAIN),
      'description' => __('This image is the small logo that shows up in the header of your theme.', TEXT_DOMAIN),
      'section' => 'logos',
      'type' => 'image',
      'flex_width' => false,
      'flex_height' => false,
      'width' => 64,
      'height' => 64,
      'priority' => 10,
      'default' => null
    ));

    Kirki::add_field('footer_logo', array(
      'settings' => 'footer_logo',
      'label' => __('Footer Logo', TEXT_DOMAIN),
      'description' => __('This is the image that displays inside the footer before the footer menu.', TEXT_DOMAIN),
      'section' => 'logos',
      'type' => 'image',
      'priority' => 20,
      'default' => null
    ));

    Kirki::add_field('favicon', array(
      'settings' => 'favicon',
      'label' => __('Favicon Image', TEXT_DOMAIN),
      'description' => __('This is the image that displays inside the browser.', TEXT_DOMAIN),
      'section' => 'logos',
      'type' => 'image',
      'priority' => 30,
      'default' => 'http://s1.wp.com/i/favicons/favicon-64x64.png'
    ));

    return $this;
  }

  public function setBrandColors()
  {

    Kirki::add_field('brand_primary', array(
      'type' => 'color',
      'settings' => 'brand_primary',
      'label' => esc_attr__('Brand Primary', TEXT_DOMAIN),
      'section' => 'brand_colors',
      'default' => '#002f6d',
      'variables' => [
        [
          'name' => 'brand-primary'
        ]
      ],
      'priority' => 10,
    ));

    Kirki::add_field('brand_inverse', array(
      'type' => 'color',
      'settings' => 'brand_inverse',
      'label' => esc_attr__('Brand Inverse', TEXT_DOMAIN),
      'section' => 'brand_colors',
      'default' => '#373a3c',
      'variables' => [
        [
          'name' => 'brand-inverse'
        ]
      ],
      'priority' => 20,
    ));

    Kirki::add_field('brand_success', array(
      'type' => 'color',
      'settings' => 'brand_success',
      'label' => esc_attr__('Brand Success', TEXT_DOMAIN),
      'section' => 'brand_colors',
      'default' => '#00833f',
      'variables' => [
        [
          'name' => 'brand-success'
        ]
      ],
      'priority' => 30,
    ));

    Kirki::add_field('brand_info', array(
      'type' => 'color',
      'settings' => 'brand_info',
      'label' => esc_attr__('Brand Info', TEXT_DOMAIN),
      'section' => 'brand_colors',
      'default' => '#8d7332',
      'variables' => [
          [
            'name' => 'brand-info'
          ]
        ],
      'priority' => 40,
    ));

    Kirki::add_field('brand_warning', array(
      'type' => 'color',
      'settings' => 'brand_warning',
      'label' => esc_attr__('Brand Warning', TEXT_DOMAIN),
      'section' => 'brand_colors',
      'default' => '#ea7200',
      'variables' => [
          [
            'name' => 'brand-warning'
          ]
        ],
      'priority' => 50,
    ));

    Kirki::add_field('brand_danger', array(
      'type' => 'color',
      'settings' => 'brand_danger',
      'label' => esc_attr__('Brand Danger', TEXT_DOMAIN),
      'section' => 'brand_colors',
      'default' => '#ac1f2d',
      'variables' => [
        [
          'name' => 'brand-danger'
        ]
      ],
      'priority' => 60,
    ));

    return $this;
  }

  public function setFooterControls() {

    Kirki::add_field('footer_copyright', array(
      'settings' => 'footer_copyright',
      'label' => __('Copyright Text', TEXT_DOMAIN),
      'description' => __('Your company\'s copyright text that shows up in the footer.', TEXT_DOMAIN),
      'section' => 'title_tagline',
      'type' => 'textarea',
      'priority' => 30,
      'default' => ''
    ));

    return $this;
  }

  public function setContactControls() {

    // Kirki::add_field('contact_phone_numbers', array(
    //   'type' => 'repeater',
    //   'label' => esc_attr__('Phone Numbers', TEXT_DOMAIN),
    //   'description' => esc_attr__('Add your phone numbers here along with a label to distinguish each phone number.', TEXT_DOMAIN),
    //   'section' => 'contact_info',
    //   'priority' => 10,
    //   'settings' => 'contact_phone_numbers',
    //   'row_label' => array(
    //     'type' => 'text',
    //     'value' => esc_attr__('Phone Number', TEXT_DOMAIN ),
    //   ),
    //   'default' => [
    //     [
    //       'label' => '',
    //       'number' => ''
    //     ]
    //   ],
    //   'fields' => array(
    //     'label' => array(
    //       'type' => 'text',
    //       'label' => esc_attr__('Phone Number Label', TEXT_DOMAIN),
    //       'description' => esc_attr__('Give this phone number a name. (i.e. Support, Admissions, Enrollment)', TEXT_DOMAIN),
    //     ),
    //     'number' => array(
    //       'type' => 'text',
    //       'label' => esc_attr__('Phone Number', TEXT_DOMAIN),
    //       'description' => esc_attr__('Provide the phone number for the label provided above.', TEXT_DOMAIN)
    //     )
    //   )
    // ));

    // Kirki::add_field('contact_emails', array(
    //   'type' => 'repeater',
    //   'label' => esc_attr__('Contact Emails', TEXT_DOMAIN),
    //   'description' => esc_attr__('Add your contact emails here along with a label to distinguish each email.', TEXT_DOMAIN),
    //   'section' => 'contact_info',
    //   'priority' => 20,
    //   'row_label' => array(
    //     'type' => 'text',
    //     'value' => esc_attr__('Email', TEXT_DOMAIN ),
    //   ),
    //   'settings' => 'contact_emails',
    //   'default' => array(
    //     [
    //       'label' => '',
    //       'email' => ''
    //     ]
    //   ),
    //   'fields' => array(
    //     'label' => array(
    //       'type' => 'text',
    //       'label' => esc_attr__('Email Label', TEXT_DOMAIN),
    //       'description' => esc_attr__('Give this email a name. (i.e. Support, Billing, IT)', TEXT_DOMAIN)
    //     ),
    //     'email' => array(
    //       'type' => 'text',
    //       'label' => esc_attr__('Email Address', TEXT_DOMAIN)
    //     )
    //   )
    // ));

    // Kirki::add_field('contact_addresses', array(
    //   'type' => 'repeater',
    //   'label' => esc_attr__('Company Locations', TEXT_DOMAIN),
    //   'description' => esc_attr__('Add your company street address locations here along with a label to distinguish each location.', TEXT_DOMAIN),
    //   'section' => 'contact_info',
    //   'priority' => 30,
    //   'row_label' => array(
    //     'type' => 'text',
    //     'value' => esc_attr__('Address', TEXT_DOMAIN ),
    //   ),
    //   'settings' => 'contact_addresses',
    //   'default' => array(
    //     [
    //       'label' => '',
    //       'street' => '',
    //       'city' => '',
    //       'state' => '',
    //       'zip' => ''
    //     ]
    //   ),
    //   'fields' => array(
    //     'label' => array(
    //       'type' => 'text',
    //       'label' => esc_attr__('Address Label', TEXT_DOMAIN),
    //       'description' => esc_attr__('Give this address a name. (i.e. Support, Admissions, Enrollment)', TEXT_DOMAIN)
    //     ),
    //     'street' => array(
    //       'type' => 'text',
    //       'label' => esc_attr__('Street', TEXT_DOMAIN)
    //     ),
    //     'city' => array(
    //       'type' => 'text',
    //       'label' => esc_attr__('City', TEXT_DOMAIN)
    //     ),
    //     'state' => array(
    //       'type' => 'text',
    //       'label' => esc_attr__('State', TEXT_DOMAIN)
    //     ),
    //     'zip' => array(
    //       'type' => 'text',
    //       'label' => esc_attr__('Zip', TEXT_DOMAIN)
    //     )
    //   )
    // ));

    return $this;
  }

  public function edit_existing($wp_cust)
  {
    $wp_cust->remove_control('site_icon');
    $site_title = $wp_cust->get_section('title_tagline');
    $site_title->title = 'Titles and Descriptions';
    $site_title->panel = 'site_identity';

    return $this;
  }

  public function getNetworkUserInfoHtml() {
      $user = get_option('instagram_user', array("0" => false))[0];
      $html = '';
      if (is_object($user)) {
          $html = Loader::getTemplateBuffer('/templates/admin/network-user-display.php', array('user' => $user, 'network' => 'instagram'));
      }
      return $html;
  }

  public function getInstagramAuthButtonHtml() {
      $data = array('href' => InstagramConfig::getLoginUrl(get_option('instagram_client_id')), 'network' => 'instagram');
      $html = Loader::getTemplateBuffer('/templates/admin/network-auth-button.php', $data);
      return $html;
  }

  public function getFacebookAuthButtonHtml() {
      $data = array('href' => Facebook::getLoginUrl(), 'network' => 'facebook');
      $html = Loader::getTemplateBuffer('admin', 'network-auth-button.php', $data);
      return $html;
  }

  public function isFacebookAuthNeeded() {
      $app_id = get_option('facebook_app_id');
      $app_secret = get_option('facebook_app_secret');
      $access_token = get_option('facebook_access_token');
      if (!isset($app_id) || empty($app_id) || !isset($app_secret) || empty($app_secret) || !isset($access_token) || empty($access_token)) {
          return true;
      }
      return false;
  }
}
