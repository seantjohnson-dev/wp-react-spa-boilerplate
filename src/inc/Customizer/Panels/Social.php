<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
use \Kirki as Kirki;

class Social extends BaseCustomizer {

    public function set_panels() {
        Kirki::add_panel('social', array(
            'priority' => 40,
            'title' => __('Social', TEXT_DOMAIN),
            'description' => __('Configure you social networks here.', TEXT_DOMAIN)
         ));
        return $this;
    }

    public function set_sections() {

      Kirki::add_section('facebook', array(
        'title' => __('Facebook', TEXT_DOMAIN),
        'panel' => 'social',
        'priority' => 50
      ));

      Kirki::add_section('twitter', array(
        'title' => __('Twitter', TEXT_DOMAIN),
        'panel' => 'social',
        'priority' => 60
      ));

      Kirki::add_section('instagram', array(
        'title' => __('Instagram', TEXT_DOMAIN),
        'panel' => 'social',
        'priority' => 70
      ));

      Kirki::add_section('youtube', array(
        'title' => __('Youtube', TEXT_DOMAIN),
        'panel' => 'social',
        'priority' => 80
      ));

      Kirki::add_section('vimeo', array(
        'title' => __('Vimeo', TEXT_DOMAIN),
        'panel' => 'social',
        'priority' => 90
      ));

      Kirki::add_section('google_plus', array(
        'title' => __('Google+', TEXT_DOMAIN),
        'panel' => 'social',
        'priority' => 100
      ));

      Kirki::add_section('linked_in', array(
        'title' => __('LinkedIn', TEXT_DOMAIN),
        'panel' => 'social',
        'priority' => 110
      ));

      return $this;

    }

    public function set_controls() {
      $this->setFacebookControls()
      ->setTwitterControls()
      ->setInstagramControls()
      ->setYoutubeControls()
      ->setVimeoControls()
      ->setGooglePlusControls()
      ->setLinkedInControls();
      return $this;
    }

    public function setFacebookControls() {

    // Kirki::add_field('facebook_user_display', array(
    //     'type' => 'custom',
    //     'settings' => 'facebook_user_display',
    //     'section' => 'facebook',
    //     'option_type' => 'option',
    //     'default' => $this->getNetworkUserInfoHtml(),
    //     'priority' => 10,
    //     'required' => array(
    //         array(
    //             'settings' => 'facebook_app_id',
    //             'operator' => '!==',
    //             'value' => ''
    //         ),
    //         array(
    //             'settings' => 'facebook_app_secret',
    //             'operator' => '!==',
    //             'value' => ''
    //         )
    //     )
    // ));

    // Kirki::add_field('facebook_authorize_button', array(
    //     'type' => 'custom',
    //     'settings' => 'facebook_authorize_button',
    //     'section' => 'facebook',
    //     'option_type' => 'option',
    //     'default' => $this->getFacebookAuthButtonHtml(),
    //     'priority' => 15,
    //     'option_type' => 'option',
    //     'active_callback' => array($this, 'isFacebookAuthNeeded')
    // ));

    Kirki::add_field('facebook_url', array(
        'type' => 'text',
        'settings' => 'facebook_url',
        'label' => __('Facebook Url', TEXT_DOMAIN),
        'description' => __('Please provide your Facebook Profile Url here.', TEXT_DOMAIN),
        'section' => 'facebook',
          'default' => '',
        'priority' => 30
    ));

    Kirki::add_field('facebook_app_id', array(
        'type' => 'text',
        'settings' => 'facebook_app_id',
        'label' => __('Facebook App ID', TEXT_DOMAIN),
        'section' => 'facebook',
          'default' => '',
        'priority' => 40
    ));

    Kirki::add_field('facebook_app_secret', array(
        'type' => 'text',
        'settings' => 'facebook_app_secret',
        'label' => __('Facebook App Secret', TEXT_DOMAIN),
        'section' => 'facebook',
          'default' => '',
        'priority' => 50
    ));

    Kirki::add_field('facebook_graph_version', array(
        'type' => 'select',
        'settings' => 'facebook_graph_version',
        'label' => __('Facebook Open Graph Version', TEXT_DOMAIN),
        'section' => 'facebook',
          'choices' => array(
            'v2.0' => "2.0",
            'v2.1' => "2.1",
            'v2.2' => "2.2",
            'v2.3' => "2.3",
            'v2.4' => "2.4",
            'v2.5' => "2.5"
        ),
        'default' => '2.5',
        'priority' => 60
    ));

    return $this;
  }

  public function setTwitterControls() {

    Kirki::add_field('twitter_url', array(
        'type' => 'text',
        'settings' => 'twitter_url',
        'label' => __('Twitter Url', TEXT_DOMAIN),
        'description' => __('Please provide your Twitter Profile Url here.', TEXT_DOMAIN),
        'section' => 'twitter',
          'default' => '',
        'priority' => 20
    ));

    Kirki::add_field('twitter_handle', array(
        'type' => 'text',
        'settings' => 'twitter_handle',
        'label' => __('Twitter Handle', TEXT_DOMAIN),
        'section' => 'twitter',
          'default' => '',
        'priority' => 30
    ));

    Kirki::add_field('twitter_consumer_key', array(
        'type' => 'text',
        'settings' => 'twitter_consumer_key',
        'label' => __('Twitter Consumer Key', TEXT_DOMAIN),
        'section' => 'twitter',
          'default' => '',
        'priority' => 40
    ));

    Kirki::add_field('twitter_consumer_secret', array(
        'type' => 'text',
        'settings' => 'twitter_consumer_secret',
        'label' => __('Twitter Consumer Secret', TEXT_DOMAIN),
        'section' => 'twitter',
          'default' => '',
        'priority' => 50
    ));

    Kirki::add_field('twitter_access_token', array(
        'type' => 'text',
        'settings' => 'twitter_access_token',
        'label' => __('Twitter Access Token', TEXT_DOMAIN),
        'section' => 'twitter',
          'default' => '',
        'priority' => 60
    ));

    Kirki::add_field('twitter_access_token_secret', array(
        'type' => 'text',
        'settings' => 'twitter_access_token_secret',
        'label' => __('Twitter Access Token Secret', TEXT_DOMAIN),
        'section' => 'twitter',
          'default' => '',
        'priority' => 70
    ));

    return $this;
  }

  public function setInstagramControls() {
    Kirki::add_field('instagram_user_display', array(
        'type' => 'custom',
        'settings' => 'instagram_user_display',
        'section' => 'instagram',
        'option_type' => 'option',
        'default' => $this->getNetworkUserInfoHtml(),
        'priority' => 10,
        'required' => array(
            array(
                'settings' => 'instagram_client_id',
                'operator' => '!==',
                'value' => ''
            ),
            array(
                'settings' => 'instagram_access_token',
                'operator' => '!==',
                'value' => ''
            )
        )
    ));

    Kirki::add_field('instagram_authorize_button', array(
        'type' => 'custom',
        'settings' => 'instagram_authorize_button',
        'section' => 'instagram',
        'option_type' => 'option',
        'default' => $this->getInstagramAuthButtonHtml(),
        'priority' => 20,
        'option_type' => 'option',
        'required' => array(
            array(
                'settings' => 'instagram_client_id',
                'operator' => '!==',
                'value' => ''
            ),
            array(
                'settings' => 'instagram_client_secret',
                'operator' => '!==',
                'value' => ''
            ),
            array(
                'settings' => 'instagram_access_token',
                'operator' => '==',
                'value' => ''
            )
        )
    ));

    Kirki::add_field('instagram_profile_url', array(
        'type' => 'text',
        'settings' => 'instagram_profile_url',
        'label' => __('Instagram Profile Url', TEXT_DOMAIN),
        'description' => __('Please provide your Instagram Profile Url here.', TEXT_DOMAIN),
          'section' => 'instagram',
        'default' => '',
        'priority' => 30
    ));

    Kirki::add_field('instagram_client_id', array(
        'type' => 'text',
        'settings' => 'instagram_client_id',
        'label' => __('Instagram Client ID', TEXT_DOMAIN),
          'section' => 'instagram',
        'default' => '',
        'priority' => 40
    ));

    Kirki::add_field('instagram_client_secret', array(
        'type' => 'text',
        'settings' => 'instagram_client_secret',
        'label' => __('Instagram Client Secret', TEXT_DOMAIN),
          'section' => 'instagram',
        'default' => '',
        'priority' => 50
    ));

    Kirki::add_field('instagram_access_token', array(
        'type' => 'text',
        'settings' => 'instagram_access_token',
        'label' => __('Instagram Access Token', TEXT_DOMAIN),
        'description' => __('This input below will populate itself when Instagram has been successfully authorized.', TEXT_DOMAIN),
        'option_type' => 'option',
        'section' => 'instagram',
        'default' => '',
        'input_attrs' => array(
            'readonly' => 'readonly',
            'placeholder' => ''
        ),
        'priority' => 60,
        'capability' => 'develop',
        'required' => array(
            array(
                'settings' => 'instagram_client_id',
                'operator' => '!==',
                'value' => ''
            ),
            array(
                'settings' => 'instagram_client_secret',
                'operator' => '!==',
                'value' => ''
            )
        )
    ));
    return $this;
  }

  public function setYoutubeControls() {
    Kirki::add_field('youtube_profile_url', array(
        'type' => 'text',
        'settings' => 'youtube_profile_url',
        'label' => __('Youtube Profile Url', TEXT_DOMAIN),
        'description' => __('Please provide your Youtube Profile Url here.', TEXT_DOMAIN),
        'section' => 'youtube',
          'default' => '',
        'priority' => 20
    ));

    // Kirki::add_field('youtube_videos', array(
    //     'type'        => 'repeater',
    //     'label'       => esc_attr__('Featured Youtube Videos', TEXT_DOMAIN),
    //     'description' => esc_attr__('Add your featured youtube videos here.', TEXT_DOMAIN),
    //     'settings'    => 'youtube_videos',
    //     'section'     => 'youtube',
    //     'option_type' => 'option',
    //     'priority'    => 30,
    //     'button_label' => 'Add Youtube Video',
    //     'default' => array(),
    //     'fields' => array(
    //         'video_src' => array(
    //             'type'        => 'text',
    //             'label'       => esc_attr__('Youtube Video', TEXT_DOMAIN),
    //             'description' => esc_attr__('Paste a Youtube embed url or video-id here.', TEXT_DOMAIN),
    //             'default' => ''
    //         ),
    //         'video_thumb' => array(
    //             'type'        => 'image',
    //             'label'       => esc_attr__('Youtube Video', TEXT_DOMAIN),
    //             'description' => esc_attr__('Paste a Youtube embed url or video-id here.', TEXT_DOMAIN),
    //             'default' => null
    //         )
    //     )
    // ));

    return $this;
  }

  public function setVimeoControls() {

    Kirki::add_field('vimeo_profile_url', array(
        'type' => 'text',
        'settings' => 'vimeo_profile_url',
        'label' => __('Vimeo Profile Url', TEXT_DOMAIN),
        'description' => __('Please provide your Vimeo Profile Url here.', TEXT_DOMAIN),
        'section' => 'vimeo',
          'default' => '',
        'priority' => 20
    ));

    return $this;
  }

  public function setGooglePlusControls() {

    Kirki::add_field('google_plus_profile_url', array(
        'type' => 'text',
        'settings' => 'google_plus_profile_url',
        'label' => __('Google+ Profile Url', TEXT_DOMAIN),
        'description' => __('Please provide your Google+ Profile Url here.', TEXT_DOMAIN),
        'section' => 'google_plus',
          'default' => '',
        'priority' => 20
    ));

    return $this;
  }

  public function setLinkedInControls() {

    Kirki::add_field('linkedin_profile_url', array(
        'type' => 'text',
        'settings' => 'linkedin_profile url',
        'label' => __('LinkedIn Profile Url', TEXT_DOMAIN),
        'description' => __('Please provide your LinkedIn Profile Url here.', TEXT_DOMAIN),
        'section' => 'linked_in',
          'default' => '',
        'priority' => 20
    ));

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
