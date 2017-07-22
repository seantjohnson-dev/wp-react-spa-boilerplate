<?php
$theme = wp_get_theme();
$theme_version = $theme['Version'];

if (!defined('GOOGLE_MAPS_API_KEY')) {
  define('GOOGLE_MAPS_API_KEY', 'AIzaSyAf3ppm3uDbipnH12QLsBzrkJWTLLN37T0');
}

$aloader = require_once(realpath(get_template_directory() . '/vendor/autoload.php'));

use SeanJohn\SeanJohn;
global $SeanJohn;

if (!defined('TEXT_DOMAIN')) {
  define('TEXT_DOMAIN', $theme);
}

if (empty($SeanJohn)) {
  $options = [
    'classes' => [
      'SeanJohn\Acf\Acf' => [],
      'SeanJohn\Admin\Admin' => [],
      'SeanJohn\Customizer\Customizer' => [],
      'SeanJohn\Roles\Roles' => []
    ]
  ];
  $SeanJohn = new SeanJohn($options);
}
