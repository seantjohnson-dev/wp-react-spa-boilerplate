<?php

namespace SeanJohn\Admin;
use SeanJohn\Lib\BaseClass;
use SeanJohn\Utils\Utils;
use SeanJohn\Walkers\CustomNavMenuEditWalker;

class Admin extends BaseClass
{
    public function __construct($options = [])
    {
        parent::__construct($options);
        // add_filter('show_admin_bar', '__return_false');
        add_action('admin_menu', [$this, 'remove_menu_elements'], 10, 2);
        add_filter('upload_mimes', [$this, 'add_upload_mime_types']);

        add_filter('pre_option_permalink_structure', [$this, 'auto_set_post_permalink_structure']);

        add_action('after_setup_theme', [$this, 'auto_set_permalink_structure']);

        add_filter('body_class', [$this, 'format_body_class']);

        add_filter('wp_title', ['SeanJohn\Admin\Admin', 'page_title'], 10, 3);

        add_filter('the_content', [$this, 'filter_post_content_for_iframes']);

        // add_filter('post_type_link', [$this, 'format_post_type_permalinks'],10,4);

        add_filter('rest_post_collection_params', [$this, 'add_rest_orderby_params'], 10, 1 );

        register_nav_menus([
            'primary_navigation' => __('Primary Navigation', TEXT_DOMAIN)
        ]);

        add_filter('wp_setup_nav_menu_item', [$this, 'add_custom_page_section_menu_field']);
        add_action('wp_update_nav_menu_item', [$this, 'update_custom_page_section_menu_field'], 10, 3 );
        add_filter('wp_edit_nav_menu_walker', [$this, 'edit_menu_walker'], 10, 2 );

    }

    function filter_post_content_for_iframes($content)
    {
        return preg_replace('/<p>(\s*)(<iframe.*>.*<\/iframe .*>)(\s*)<\/p>/iU', '<div class=\"video-wrap\">\2<\/div>', $content);
    }

    public function edit_menu_walker($walker,$menu_id) {
      return 'SeanJohn\\Walkers\\CustomNavMenuEditWalker';
    }

    public function add_custom_page_section_menu_field($menu_item) {
      if ($menu_item->object == 'page' && intval($menu_item->object_id) !== $menu_item->ID) {
        $menu_item->page_section = get_post_meta($menu_item->ID, '_menu_item_page_section', true );
      }
      return $menu_item;
    }

    function update_custom_page_section_menu_field( $menu_id, $menu_item_db_id, $args ) {

        // Check if element is properly sent
        if (isset($_REQUEST['menu-item-page-section']) && is_array($_REQUEST['menu-item-page-section']) && isset($_REQUEST['menu-item-page-section'][$menu_item_db_id])) {
            $section_value = $_REQUEST['menu-item-page-section'][$menu_item_db_id];
            if ($section_value) {
              update_post_meta( $menu_item_db_id, '_menu_item_page_section', $section_value );
            }
        }

    }

    public function remove_menu_elements()
    {
        remove_submenu_page('themes.php', 'theme-editor.php');
        remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category'); // Categories Page
        remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag'); // Tags Page
        remove_menu_page('edit.php'); // Posts Page
        remove_menu_page('edit-comments.php'); // Comments Page
    }

    public function add_upload_mime_types($mimes)
    {
        $mimes = array_merge($mimes, [
            'xml' => 'application/xml',
            'svg' => 'image/svg+xml',
            'zip' => 'application/zip'
        ]);

        return $mimes;
    }

    public function add_rest_orderby_params( $params ) {
        // Add the orderby=rand filter back to the WP Rest API
        $params['orderby']['enum'][] = 'rand';
        return $params;
    }


    public function auto_set_post_permalink_structure() {
        return '/posts/%postname%';
    }

    public function auto_set_permalink_structure() {
        global $wp_rewrite;
        $wp_rewrite->permalink_structure = $wp_rewrite->root . 'posts/%postname%';
        $wp_rewrite->page_structure      = $wp_rewrite->root . '%pagename%';
        $wp_rewrite->front               = $wp_rewrite->root;
    }


    public function format_body_class($classes) {
        if ( is_page() ) {
            $classes[] = sanitize_title_with_dashes( get_the_title() );
        }
        return $classes;
    }

    public static function page_title() {
      if (is_home()) {
        if (get_option('page_for_posts', true)) {
          return get_the_title(get_option('page_for_posts', true));
        } else {
          return __('Latest Posts', TEXT_DOMAIN);
        }
      } elseif (is_archive()) {
        return get_the_archive_title();
      } elseif (is_search()) {
        return sprintf(__('Search Results for %s', TEXT_DOMAIN), get_search_query());
      } elseif (is_404()) {
        return __('Not Found', TEXT_DOMAIN);
      } else {
        return get_the_title();
      }
    }

    public function format_post_type_permalinks($post_link, $post, $leavename, $sample) {
        if ($sample) {
            return str_replace("%{$post->post_type}_id%", 'NNN', $post_link);
        }
        return str_replace("%{$post->post_type}_id%", $post->ID, $post_link);
    }
}
