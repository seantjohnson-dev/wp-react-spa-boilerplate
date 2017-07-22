<?php

namespace SeanJohn\Customizer\Lib;

require_once(get_template_directory() . '/vendor/leafo/scssphp/scss.inc.php');
use Leafo\ScssPhp\Compiler;

class SassCompiler
{
    private $compiler;
    protected $minimize_css;
    protected $sass_path;
    protected $uname;

    public function __construct($args = array())
    {

        $defaults = array(
          'minimize_css'  => true,
          'uname'         => 'compiled',
          'sass_path' => wp_upload_dir()['basedir'],
          'importPaths' => []
        );
        $args = wp_parse_args($args, $defaults);
        extract($args);

        $this->sass_path = $sass_path;
        $this->minimize_css  = $minimize_css;
        $this->uname = $uname;
        $this->importPaths = $importPaths;

          // Instantianate the compiler and pass the shell's properties to it
        add_filter($this->uname . '/stylesheet/url', array( $this, 'stylesheet_url' ));
        add_filter($this->uname . '/stylesheet/ver', array( $this, 'stylesheet_ver' ));

        $this->compiler = new Compiler();

        $this->compiler->setImportPaths($this->importPaths);

        // add_action('customize_register', array($this, 'makecss'),999);

        // Trigger the compiler the first time the theme is enabled
        add_action('after_switch_theme', array($this, 'makecss'));

        // Trigger the compiler when the customizer options are saved.
        add_action('customize_save_after', array($this, 'makecss'), 999);

        // If the CSS file does not exist, attempt creating it.
        if (!file_exists($this->file('path'))) {
            add_action('wp', array($this, 'makecss'));
        }
    }

    public function write_sass_to_file()
    {
        $vars_file = realpath(get_template_directory().'/assets/styles/variables/_admin_variables.scss');

        $cur_contents = file_get_contents($vars_file);
        $var_contents = $this->get_variables();

        if (!empty($var_contents) && ($var_contents !== $cur_contents)) {
          $cur_contents = file_put_contents($vars_file, $var_contents);
        }
        return $cur_contents;
    }

    public function get_variables()
    {
        global $wp_customize;

        $variables = \Kirki::get_variables();

        // define the $content to avoid PHP notices
        $content = '';

        foreach ($variables as $variable => $value) {
            if (!empty($value)) {
              $content .= '$'.$variable.': '.$value.';'."\n";
            }
        }

        $sass_vars = get_theme_mod('sass_vars', []);
        $sass_vars = set_theme_mod('sass_vars', array_merge($sass_vars, $variables));
        $custom_sass = get_theme_mod('custom_sass', '');
        $content .= (!empty($custom_sass)) ? $custom_sass : '';

        return $content;
    }

    public function css_contents() {
        $this->write_sass_to_file();
        $contents = file_get_contents(get_template_directory() . '/assets/styles/main.scss');
        $css = $this->compiler->compile($contents);
        return $css;
    }



    public function makecss() {
      global $wp_filesystem;

      $file = $this->file();

      // Initialize the Wordpress filesystem.
      if ( empty( $wp_filesystem ) ) {
        require_once( ABSPATH . '/wp-admin/includes/file.php' );
        WP_Filesystem();
      }

      $content = '/********* Compiled - Do not edit *********/

      ';

      $content = $this->css_contents();

      // Take care of domain mapping
      if ( defined( 'DOMAIN_MAPPING' ) && 1 == DOMAIN_MAPPING ) {
        if ( function_exists( 'domain_mapping_siteurl' ) && function_exists( 'get_original_url' ) ) {

          $mapped = domain_mapping_siteurl( false );
          $mapped = str_replace( 'https://', '//', $mapped );
          $mapped = str_replace( 'http://', '//', $mapped );

          $original = get_original_url( 'siteurl' );
          $original = str_replace( 'https://', '//', $original );
          $original = str_replace( 'http://', '//', $original );

          $content = str_replace( $original, $mapped, $content );

        }
      }

      // Strip protocols
      $content = str_replace( 'https://', '//', $content );
      $content = str_replace( 'http://', '//', $content );

      if (is_writeable( $file ) || (!file_exists( $file ) && is_writeable(dirname($file)))) {
        if (!$wp_filesystem->put_contents($file, $content, FS_CHMOD_FILE)) {
          return apply_filters($this->uname . '/compiler/output', $content);
        }
      }

      // Force re-building the stylesheet version transient
      delete_transient( $this->uname . '_stylesheet_time' );
      delete_transient( $this->uname . '_stylesheet_path' );
      delete_transient( $this->uname . '_stylesheet_uri' );
    }

    /*
    * Gets the css path or url to the stylesheet
    * If $target = 'path', return the path
    * If $target = 'url', return the url
    *
    * If echo = true then print the path or url.
    */
    public function file( $target = 'path' ) {
      global $blog_id;

      // No need to process this on each page load... Use transients to improve performance.
      // Transients are valid for 24 hours, so these calculations only run once a day.
      if ( ! get_transient( $this->uname . '_stylesheet_path' ) || ! get_transient( $this->uname . '_stylesheet_uri' ) ) {

        // Get the upload directory for this site.
        $upload_dir = wp_upload_dir();

        // If this is a multisite installation, append the blogid to the filename
        $cssid = ( is_multisite() && $blog_id > 1 ) ? '_id-' . $blog_id : null;

        $file_name = '/' . $this->uname . $cssid . '.css';

        // Define a default folder for the stylesheets.
        $def_folder_path = $this->sass_path;
        $folder_path     = $def_folder_path;

        //Default output path is not writable
        //Going to try the uploads directory
        if (!is_writeable(dirname($folder_path . $file_name)) && !is_writeable($folder_path . $file_name)) {
            $folder_path = $upload_dir['basedir'];
        }
        if (!is_writeable(dirname($folder_path . $file_name)) && !is_writeable($folder_path . $file_name)) {
          $folder_path = ABSPATH . '/styles';
        }
        if (!is_writeable(dirname($folder_path . $file_name)) && !is_writeable($folder_path . $file_name)) {
          return;
        }

        // The complete path to the file.
        $file_path = $folder_path . $file_name;

        if ($folder_path == $def_folder_path) {

          $css_uri_folder = $def_folder_path;
        } elseif ( $folder_path == $upload_dir['basedir'] ) {
          // Path is set to WordPress uploads dir
          $css_uri_folder = $upload_dir['baseurl'];
        } elseif ( $folder_path == ABSPATH . '/styles' ) {
          // Path is set to WordPress root /styles
          // On multisites use network_site_url() instead of site_url()
          $css_uri_folder = ( is_multisite() ) ? network_site_url() . '/styles' : site_url() . '/styles';
        }

        $css_uri = $css_uri_folder . $file_name;
        $css_path = $file_path;

        // Take care of domain mapping
        if ( defined( 'DOMAIN_MAPPING' ) && 1 == DOMAIN_MAPPING ) {
          if ( function_exists( 'domain_mapping_siteurl' ) && function_exists( 'get_original_url' ) ) {

            $mapped   = domain_mapping_siteurl( false );
            $original = get_original_url( 'siteurl' );
            $css_uri  = str_replace( $original, $mapped, $css_uri );

          }
        }

        // Strip protocols
        $css_uri = str_replace( 'https://', '//', $css_uri );
        $css_uri = str_replace( 'http://', '//', $css_uri );

        // Set a transient for the stylesheet path and url.
        if ( !get_transient( $this->uname . '_stylesheet_path' ) || ! get_transient( $this->uname . '_stylesheet_uri' ) ) {
          set_transient( $this->uname . '_stylesheet_path', $css_path, 24 * 60 *60 );
          set_transient( $this->uname . '_stylesheet_uri', $css_uri, 24 * 60 *60 );
        }
      }

      $css_path = get_transient( $this->uname . '_stylesheet_path' );
      $css_uri  = get_transient( $this->uname . '_stylesheet_uri' );

      $value = ( $target == 'url' ) ? $css_uri : $css_path;

      // Get the file version based on its filemtime
      if ( $target == 'ver' ) {
        if ( ! get_transient( $this->uname . '_stylesheet_time' ) ) {
          set_transient( $this->uname . '_stylesheet_time', filemtime( $css_path ), 24 * 60 * 60 );
        }

        $value = get_transient( $this->uname . '_stylesheet_time' );
      }

      return $value;

    }

    /**
    * Get the URL of the stylesheet
    */
    function stylesheet_url() {
      return $this->file( 'url' );
    }

    /**
    * Get the version of the stylesheet
    */
    function stylesheet_ver() {
      return $this->file( 'ver' );
    }

}

