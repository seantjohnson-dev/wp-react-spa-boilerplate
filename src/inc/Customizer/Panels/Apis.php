<?php

  namespace SeanJohn\Customizer\Panels;

  use SeanJohn\Customizer\Lib\BaseCustomizer;
  use SeanJohn\Utils\Requester;
  use WordPress\Discovery;
  use SeanJohn\Apis\Lib\WP_OAuthClient as OAuthClient;
  use SeanJohn\Apis\Helpers\OAuthHelper as Helper;
  use Kirki as Kirki;
  use Timber as Timber;

  class Apis extends BaseCustomizer
  {

    public function __construct() {
        parent::__construct();
        // add_action('customize_controls_init', [$this, 'check_api_url']);
        // add_action('customize_save_after', [$this, 'after_customize_save']);
        // add_action('customize_save', [$this, 'before_customize_save']);
        // add_action('wp_ajax_authorize_rest_api', [$this, 'authorize_api_ajax']);
        // add_action('customize_register', [$this, 'authorize_api']);
        // add_action('wp_ajax_authorize_rest_api', [$this, 'authorize_api_ajax']);
        // session_start();
    }

    public function set_panels()
    {
        Kirki::add_panel('apis', array(
          'priority' => 200,
          'title' => __('Apis', TEXT_DOMAIN),
          'description' => __('Configure your API keys and token settings here.', TEXT_DOMAIN),
          'capability' => 'edit_theme_options'
        ));

        return $this;
    }

    public function set_sections()
    {

        Kirki::add_section('sudo_events_api_keys', array(
          'title' => __('Sudo Events API', TEXT_DOMAIN),
          'description' => __('Configure the Sudo Events Api below.', TEXT_DOMAIN),
          'panel' => 'apis',
          'capability' => 'edit_theme_options',
          'priority' => 10
        ));

        return $this;
    }

    public function set_controls()
    {

        include_once(dirname(__DIR__) . '/Controls/sudo_events_api_reset.php');


        Kirki::add_field('sudo_events_api_discovered_status', array(
            'type' => 'custom',
            'settings' => 'sudo_events_api_discovered_status',
            'label' => __('API Discovered', TEXT_DOMAIN),
            // 'description' => __('Please provide the Sudo Events WP-API Url here.', TEXT_DOMAIN),
            'section' => 'sudo_events_api_keys',
                  'capability' => 'edit_theme_options',
            'default' => $this->getCustomizerTemplateHtml([
                'bool_val' => get_option('sudo_events_api_discovered', false),
                'status' => 'Api Discovered',
                'template' => 'admin/customizer_bool_status_icon.twig'
            ]),
            'priority' => 20,
            'active_callback' => function () {
              return false;
            }
        ));

        Kirki::add_field('sudo_events_api_discovered', array(
            'type' => 'toggle',
            'settings' => 'sudo_events_api_discovered',
            'label' => __('API Discovered', TEXT_DOMAIN),
            // 'description' => __('Please provide the Sudo Events WP-API Url here.', TEXT_DOMAIN),
            'section' => 'sudo_events_api_keys',
                  'capability' => 'edit_theme_options',
            'default' => false,
            'priority' => 30,
            'active_callback' => function () {
              return false;
            }
        ));


        Kirki::add_field('sudo_events_api_authorized_status', array(
            'type' => 'custom',
            'settings' => 'sudo_events_api_authorized_status',
            'label' => __('API Authorized', TEXT_DOMAIN),
            // 'description' => __('Please provide the Sudo Events WP-API Url here.', TEXT_DOMAIN),
            'section' => 'sudo_events_api_keys',
                  'capability' => 'edit_theme_options',
            'default' => $this->getCustomizerTemplateHtml([
                'bool_val' => get_option('sudo_events_api_authorized', false),
                'status' => 'Api Authorized',
                'template' => 'admin/customizer_bool_status_icon.twig'
            ]),
            'priority' => 40,
            'active_callback' => function () {
              return false;
            }
        ));

        Kirki::add_field('sudo_events_api_authorized', array(
            'type' => 'toggle',
            'settings' => 'sudo_events_api_authorized',
            'label' => __('API Authorized', TEXT_DOMAIN),
            // 'description' => __('Please provide the Sudo Events WP-API Url here.', TEXT_DOMAIN),
            'section' => 'sudo_events_api_keys',
                  'capability' => 'edit_theme_options',
            'default' => false,
            'priority' => 50,
            'active_callback' => function () {
              return false;
            }
        ));

        // Input fields start here.

        include_once(dirname(__DIR__) . '/Controls/sudo_events_api_url.php');

        Kirki::add_field('sudo_events_api_auth_urls', array(
            'type' => 'repeater',
            'settings' => 'sudo_events_api_auth_urls',
            'label' => __('Sudo Events API Auth Urls', TEXT_DOMAIN),
            'description' => __('Below are the API Auth urls discovered.', TEXT_DOMAIN),
            'section' => 'sudo_events_api_keys',
                  'capability' => 'edit_theme_options',
            'default' => [
              [
                'url_base' => '',
                'request'  => '',
                'authorize' => '',
                'access' => ''
              ]
            ],
            'fields' => [
              'url_base' => [
                'type'        => 'text',
                'label'       => esc_attr__( 'Api Base Endpoint', TEXT_DOMAIN ),
                'description' => esc_attr__( 'This is the base api endpoint discovered.', TEXT_DOMAIN ),
                'default'     => '',
                'choices' => [
                  'readonly' => 'readonly'
                ]
              ],
              'request' => [
                'type'        => 'text',
                'label'       => esc_attr__( 'Api Request Token Endpoint', TEXT_DOMAIN ),
                'description' => esc_attr__( 'This is the api request token endpoint discovered.', TEXT_DOMAIN ),
                'default'     => '',
                'choices' => [
                  'readonly' => 'readonly'
                ]
              ],
              'authorize' => [
                'type'        => 'text',
                'label'       => esc_attr__( 'Api Authorization Endpoint', TEXT_DOMAIN ),
                'description' => esc_attr__( 'This is the api authorization endpoint discovered.', TEXT_DOMAIN ),
                'default'     => '',
                'choices' => [
                  'readonly' => 'readonly'
                ]
              ],
              'access' => [
                'type'        => 'text',
                'label'       => esc_attr__( 'Api Access Token Endpoint', TEXT_DOMAIN ),
                'description' => esc_attr__( 'This is the api access token endpoint discovered.', TEXT_DOMAIN ),
                'default'     => '',
                'choices' => [
                  'readonly' => 'readonly'
                ]
              ]
            ],
            'priority' => 65
        ));

        include_once(dirname(__DIR__) . '/Controls/sudo_events_api_key.php');
        include_once(dirname(__DIR__) . '/Controls/sudo_events_api_secret.php');


        Kirki::add_field('sudo_events_api_callback_url', array(
            'type' => 'text',
            'settings' => 'sudo_events_api_callback_url',
            'label' => __('Sudoapp Callback Url', TEXT_DOMAIN),
            'description' => __('Please provide the Sudoapp WP-API callback url here.', TEXT_DOMAIN),
            'section' => 'sudo_events_api_keys',
                  'capability' => 'edit_theme_options',
            'default' => '',
            'priority' => 90,
            // 'active_callback' => [
            //   [
            //     'settings' => 'sudo_events_api_discovered',
            //     'operator' => '==',
            //     'value' => true
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_url',
            //     'operator' => '!==',
            //     'value' => ''
            //   ]
            // ]
        ));


        Kirki::add_field('sudo_events_api_auth_button', array(
            'type' => 'custom',
            'settings' => 'sudo_events_api_auth_button',
            'label' => __('Authorize API', TEXT_DOMAIN),
            // 'description' => __('Please provide the Sudo Events WP-API Url here.', TEXT_DOMAIN),
            'section' => 'sudo_events_api_keys',
                  'capability' => 'edit_theme_options',
            'default' => $this->getCustomizerTemplateHtml([
                'option_name' => 'sudo_events_api_auth_button',
                'button_text' => 'Authorize API',
                'href' => $this->getApiAuthUrl(),
                // 'classes' => 'sudo-events-auth-button',
                // 'ajax_action' => 'authorize_rest_api',
                'template' => 'admin/customizer_api_auth_button.twig'
            ]),
            'priority' => 130,
            'active_callback' => function () {
              return false;
            }
            // 'active_callback' => [
            //   [
            //     'settings' => 'sudo_events_api_discovered',
            //     'operator' => '==',
            //     'value' => true
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_authorized',
            //     'operator' => '!==',
            //     'value' => true
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_url',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_key',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_secret',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_callback_url',
            //     'operator' => '!==',
            //     'value' => ''
            //   ]
            // ]
        ));

        Kirki::add_field('sudo_events_api_token_creds', array(
            'type' => 'text',
            'settings' => 'sudo_events_api_token_creds',
            'label' => __('Sudo Events API Token Credentials', TEXT_DOMAIN),
            // 'description' => __('Below are the oAuth token credentials currently being used to authenticate sudoapp.com with events.sudoapp.com', TEXT_DOMAIN),
            'section' => 'sudo_events_api_keys',
                  'capability' => 'edit_theme_options',
            'default' => '',
            'priority' => 140,
            'choices' => [
              // 'readonly' => 'readonly'
            ],
            'active_callback' => function () {
              return false;
            }
            // 'active_callback' => [
            //   [
            //     'settings' => 'sudo_events_api_discovered',
            //     'operator' => '==',
            //     'value' => true
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_authorized',
            //     'operator' => '==',
            //     'value' => true
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_url',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_key',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_secret',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_callback_url',
            //     'operator' => '!==',
            //     'value' => ''
            //   ]
            // ]
        ));

        Kirki::add_field('sudo_events_api_oauth_token', array(
            'type' => 'text',
            'settings' => 'sudo_events_api_oauth_token',
            'label' => __('Sudo Events API oAuth Token', TEXT_DOMAIN),
            // 'description' => __('Below are the oAuth token credentials currently being used to authenticate sudoapp.com with events.sudoapp.com', TEXT_DOMAIN),
            'section' => 'sudo_events_api_keys',
                  'capability' => 'edit_theme_options',
            'default' => '',
            'priority' => 150,
            'choices' => [
              // 'readonly' => 'readonly'
            ],
            // 'active_callback' => [
            //   [
            //     'settings' => 'sudo_events_api_discovered',
            //     'operator' => '==',
            //     'value' => true
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_authorized',
            //     'operator' => '==',
            //     'value' => true
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_url',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_key',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_secret',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_callback_url',
            //     'operator' => '!==',
            //     'value' => ''
            //   ]
            // ]
        ));

        Kirki::add_field('sudo_events_api_oauth_verifier', array(
            'type' => 'text',
            'settings' => 'sudo_events_api_oauth_verifier',
            'label' => __('Sudo Events API oAuth Verifier', TEXT_DOMAIN),
            // 'description' => __('Below are the oAuth token credentials currently being used to authenticate sudoapp.com with events.sudoapp.com', TEXT_DOMAIN),
            'section' => 'sudo_events_api_keys',
                  'capability' => 'edit_theme_options',
            'default' => '',
            'priority' => 160,
            'choices' => [
              // 'readonly' => 'readonly'
            ],
            // 'active_callback' => [
            //   [
            //     'settings' => 'sudo_events_api_discovered',
            //     'operator' => '==',
            //     'value' => true
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_authorized',
            //     'operator' => '==',
            //     'value' => true
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_url',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_key',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_secret',
            //     'operator' => '!==',
            //     'value' => ''
            //   ],
            //   [
            //     'settings' => 'sudo_events_api_callback_url',
            //     'operator' => '!==',
            //     'value' => ''
            //   ]
            // ]
        ));

        return $this;
    }

    protected function getCustomizerTemplateHtml($options = []) {
      $context = Timber::get_context();
      foreach ($options as $o=>$opt) {
        $context[$o] = $opt;
      }
      return Timber::compile([$options['template']], $context);
    }


    protected function delete_opts() {
      $discovered = get_option('sudo_events_api_discovered', false);
      if (!$discovered) {
        delete_option('sudo_events_api_url');
        delete_option('sudo_events_api_discovered');
        delete_option('sudo_events_api_key');
        delete_option('sudo_events_api_secret');
        delete_option('sudo_events_api_callback_url');
      }

      delete_option('sudo_events_api_reset');
      delete_option('sudo_events_api_auth_url');
      delete_option('sudo_events_api_temp_creds');
      delete_option('sudo_events_api_token_creds');
      delete_option('sudo_events_api_oauth_token');
      delete_option('sudo_events_api_oauth_verifier');
      delete_option('sudo_events_api_authorized');
      // session_destroy();
    }

    public function check_api_url() {

      $url = get_option('sudo_events_api_url', '');
      $authorized = get_option('sudo_events_api_authorized', false);

      if (!empty($url) || !$authorized) {
        $discovered = get_option('sudo_events_api_discovered', false);
        if (!$discovered) {
          $this->discover_api($url);
        } else {
          $key = get_option('sudo_events_api_key', '');
          $secret = get_option('sudo_events_api_secret', '');
          $callback_url = get_option('sudo_events_api_callback_url', '');
          if (!empty($key) && !empty($secret) && !empty($callback_url)) {
            // $_SESSION['client_key'] = $key;
            // $_SESSION['client_secret'] = $secret;
            $this->obtain_temp_creds();
            // session_write_close();
          }
        }
      }
      return;
    }

    public function before_customize_save() {
      $url = get_option('sudo_events_api_url');
    }

    public function after_customize_save() {
      $reset = get_option('sudo_events_api_reset');
      if ($reset) {
        $this->delete_opts();
      }
    }

    public function discover_api_ajax() {
      echo json_encode($_POST); wp_die();
      if (isset($_POST['api_base'])) {
        echo json_encode($this->discover_api($_POST['api_base']));
      } else {
        $error = [
          'data' => [],
          'status' => 'error',
          'message' => 'API url not sent.!'
        ];
        echo json_encode($error);
      }
      wp_die();
    }

    public function discover_api($url = '') {

      $resp = [
        'status' => 'error',
        'message' => [
          'class' => 'error-message',
          'value' => 'An unknown error occurred. Please try again later.'
        ],
        'data' => []
      ];


      try {
        $site = Discovery\discover($url);
      }
      catch (Exception $e) {
        $resp['message']['value'] = sprintf("Error while discovering: %s.", htmlspecialchars($e->getMessage()));
      }
      if (empty($site) || !$site->supportsAuthentication('oauth1')) {
        $resp['message']['value'] = sprintf("Couldn't find the API at <code>%s</code>.", htmlspecialchars($url));
      }

      update_option('sudo_events_api_base', $site->getIndexURL());
      update_option('sudo_events_api_auth_urls', $site->getAuthenticationData('oauth1'));

      //   $_SESSION['sudo_events_api_base'] = $site->getIndexURL();
      // $_SESSION['sudo_events_api_auth_urls'] = $site->getAuthenticationData( 'oauth1' );
      update_option('sudo_events_api_discovered', true);

      $resp['status'] = 'success';
      $resp['message'] = [
        'class' => 'success-message',
        'value' => 'WP Api successfully discovered!'
      ];

      $resp['data'] = [
        'api_base' => $site->getIndexURL(),
        'auth_urls' => $site->getAuthenticationData('oauth1')
      ];

      return $resp;
    }


    public function obtain_temp_creds() {

      $resp = [
        'status' => 'error',
        'message' => [
          'class' => 'error-message',
          'value' => 'An unknown error occurred. Please try again later.'
        ],
        'data' => []
      ];

      try {
        // First part of OAuth 1.0 authentication is retrieving temporary credentials.
        // These identify you as a client to the server.
        $server = Helper::get_server();
        $tempCreds = $server->getTemporaryCredentials();
        $authUrl = $server->getAuthorizationUrl($tempCreds);
        $serialized = serialize($tempCreds);

        // $_SESSION['temporary_credentials'] = $serialized;

        $resp['status'] = 'success';
        $resp['message']['class'] = 'success-message';
        $resp['message']['value'] = 'Successfully obtained temporary credentials!';

      } catch ( Exception $e ) {
        $resp['message']['value'] = $e->getMessage();
      }

      return $resp;
    }

    public function authorize_api() {
      $authWPApi = (isset($_GET['sudo_events_api']) ? $_GET['sudo_events_api'] : false);
      $aToken = (isset($_GET['oauth_token']) ? $_GET['oauth_token'] : false);
      $aVerify = (isset($_GET['oauth_verifier']) ? $_GET['oauth_verifier'] : false);
      $authorized = get_option('sudo_events_api_authorized', false);

      if (!empty($authWPApi) && !empty($aToken) && !empty($aVerify) && !$authorized) {
        $this->save_token_creds($aToken, $aVerify);
      }

      // session_write_close();
      return $this;
    }

    public function authorize_api_ajax() {

      // $resp = $this->save_token_creds();
      wp_die();
    }

    public function save_token_creds($aToken = '', $aVerify = '') {

      $resp = [
        'status' => 'error',
        'message' => [
          'class' => 'error-message',
          'value' => 'An unknown error occurred. Please try again later.'
        ],
        'data' => []
      ];

      try {

        $server = Helper::get_server();

        $tempCreds = unserialize(get_option('sudo_events_api_temp_creds', ''));
        $tokenCreds = $server->getTokenCredentials($tempCreds, $aToken, $aVerify);

        update_option('sudo_events_api_token_creds', serialize($tokenCreds));
        update_option('sudo_events_api_oauth_token', $tokenCreds->getSecret());
        update_option('sudo_events_api_oauth_verifier', $tokenCreds->getIdentifier());
        update_option('sudo_events_api_authorized', true);

        $resp['data']['temp_creds'] = serialize($tokenCreds);
        $resp['status'] = 'success';
        $resp['message'] = [
          'class' => 'success-message',
          'value' => 'WP Api successfully authorized!'
        ];

      } catch ( Exception $e ) {
        $resp['message']['value'] = $e->getMessage();
      }

      return $resp;
    }

    public function getApiAuthUrl() {
        $url = '';
        $server = Helper::get_server();
        $url = $server->getAuthorizationUrl($tempCreds);
        return $url;
    }

  }
