<?php

  namespace SeanJohn\Customizer\Panels;

  use SeanJohn\Customizer\Lib\BaseCustomizer;
  use Kirki as Kirki;

  class Twilio extends BaseCustomizer
  {
      public function set_panels()
      {
          Kirki::add_panel('twilio', array(
            'priority' => 200,
            'title' => __('Twilio', TEXT_DOMAIN),
            'description' => __('Configure Twilio API settings here.', TEXT_DOMAIN),
          ));

          return $this;
      }

      public function set_sections()
      {

          // Twilio SID Key for SeanJohnDev
          // SKacd14ce102ebbfe00e1dd3160a8c140c
          //
          // Twillio SID Secret for SeanJohnDev
          // oS08Yu2YQrFDLY7sjxlTMsgAMMMGdLtk


          Kirki::add_section('api_keys', array(
            'title' => __('API Keys', TEXT_DOMAIN),
            'description' => __('Twilio API keys.', TEXT_DOMAIN),
            'panel' => 'twilio',
            'priority' => 10
          ));

          return $this;
      }

      public function set_controls()
      {
          Kirki::add_field('twilio_sid_key', array(
              'type' => 'text',
              'settings' => 'twilio_sid_key',
              'label' => __('Twilio Account SID', TEXT_DOMAIN),
              'description' => __('Please provide your Twilio Account SID here.', TEXT_DOMAIN),
              'section' => 'api_keys',
                      'default' => '',
              'priority' => 10
          ));

          Kirki::add_field('twilio_sid_secret', array(
              'type' => 'text',
              'settings' => 'twilio_sid_secret',
              'label' => __('Twilio Auth Token', TEXT_DOMAIN),
              'description' => __('Please provide your Twilio Auth Token here.', TEXT_DOMAIN),
              'section' => 'api_keys',
                      'default' => '',
              'priority' => 20
          ));

          return $this;
      }
  }
