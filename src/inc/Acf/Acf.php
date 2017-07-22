<?php

namespace SeanJohn\Acf;
use SeanJohn\Lib\BaseClass;
use SeanJohn\Utils\Utils;
use SeanJohn\Utils\Requester;
use \WP_REST_Server;

// use GFFormsModel as GFFormsModel;

class Acf extends BaseClass
{
    public function __construct($options = [])
    {
        parent::__construct($options);
        $this->options_pages();
        $this->server = new WP_REST_SERVER();
        // add_filter('acf/settings/show_admin', [$this, 'acf_show_admin']);
        add_filter('acf/fields/google_map/api', [$this, 'set_acf_google_map_api_key']);
        add_action('acf/init', [$this, 'update_acf_google_map_api_key']);
        add_filter('acf/rest_api/page/get_fields', [$this, 'populate_flex_content_fields'], 10, 4);
        add_filter('acf/update_value/type=google_map', [$this, 'get_full_google_address_data'], 10, 3);
        add_filter('acf/load_value/type=google_map', [$this, 'remove_full_google_address_data'], 10, 3);
        add_filter('rest_menus_format_menu', [$this, 'add_menu_item_children_to_menu_items']);
        add_action('save_post', function($id) {
            if (wp_is_post_revision($id)) return;
            $this->delete_page_transients($id, get_post($id));
        });
        add_action('publish_page', function($id, $post) {
            $this->delete_page_transients($id, $post);
        }, 10, 2);
        add_action('edit_post', function($id) {
            if ( wp_is_post_revision( $id ) )
            return;
            $this->delete_page_transients($id, get_post($id));
        });
        add_action('wp_insert_post', function($id, $post, $update) {
            $this->delete_page_transients($id, $post);
        }, 10, 3);
        add_filter('query_vars', [$this, 'slug_allow_meta']);
        // add_action('acf/input/admin_head', [$this, 'move_content_editors_into_message_fields']);
        // add_filter('acf/load_field/type=select', [$this, 'load_all_forms_into_form_select']);

    }

    public function delete_page_transients($id, $post) {
        if ($post->post_type == 'page') {
            delete_transient('api_page_' . $id . '_fields');
        }
        delete_transient('seanjohn-scripts-localized-data');
    }


    public function acf_show_admin($show)
    {
        return current_user_can('develop');
    }

    public function remove_full_google_address_data($value, $post_id, $field) {
      if (is_admin() && isset($value['verbose'])) {
        unset($value['verbose']);
      }
      return $value;
    }

    public function fetch_address_data($value) {
      $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($value['address']) . '&key=' . GOOGLE_MAPS_API_KEY;
      $response = Requester::get($url);

      if ($response->status == "OK" && !empty($response->results)) {
        $verbose = json_decode(json_encode($response->results[0]), true);

        foreach($response->results[0]->address_components as $c=>$comp) {
          if (in_array('street_number', $comp->types)) {
            $verbose['street_number'] = $comp->long_name;
          } else if (in_array('route', $comp->types)) {
            $verbose['route'] = $comp->long_name;
            $verbose['route_abbr'] = $comp->short_name;
          } else if (in_array('locality', $comp->types)) {
            $verbose['city'] = $comp->long_name;
          } else if (in_array('administrative_area_level_2', $comp->types)) {
            $verbose['county'] = $comp->long_name;
          } else if (in_array('administrative_area_level_1', $comp->types)) {
            $verbose['state_abbr'] = $comp->short_name;
            $verbose['state'] = $comp->long_name;
          } else if (in_array('country', $comp->types)) {
            $verbose['country'] = $comp->long_name;
            $verbose['country_abbr'] = $comp->short_name;
          } else if (in_array('postal_code', $comp->types)) {
            $verbose['zip'] = $comp->long_name;
          }
        }
        $value['verbose'] = $verbose;
      }
      return $value;
    }

    public function get_full_google_address_data($value, $post_id, $field) {
      $messages = [];
      if (!empty($value) && isset($value['address']) && (!isset($value['verbose']) || empty($value['verbose']))) {
        array_push($messages, 'verbose not set. go and fetch data.');
        $value = $this->fetch_address_data($value);
      } else {
        array_push($messages, 'field is empty or invalid so nothing to fetch');
      }

      // Utils::data2file(get_template_directory() . '/dump.php', [$messages, $value], 'php');
      return $value;
    }

    public function slug_allow_meta( $valid_vars ) {
        // Utils::data2file(get_template_directory() . '/dump.php', $valid_vars, 'php');
        $valid_vars = array_merge($valid_vars, ['meta_key', 'meta_value', 'meta_query', 'meta_compare', 'post__in']);
        return $valid_vars;
    }

    public function move_content_editors_into_message_fields()
    {
        $field_keys = [

        ];
        $selectors = [];

        foreach ($field_keys as $f => $key) {
            $sel = '.acf-field-'.str_replace('field_', '', $key).' .acf-input';
            $selectors[] = $sel;
        }
        ?>
        <script>
            (function($) {
                $(function(){
                    var mSelectors = <?php echo json_encode($selectors, JSON_PRETTY_PRINT);
        ?>;
                    var $editor = $("#postdivrich");

                    mSelectors.forEach(function (mSelector) {
                        $mElem = $(mSelector);

                        if ($mElem.length === 1 && $editor.length === 1) {
                            $mElem.append($editor);
                        }
                    });
                });
            })(jQuery);
        </script>
        <style>
            .acf-field #wp-content-editor-tools {
                background: transparent;
                padding-top: 0;
            }
        </style>
        <?php

    }

    public function load_all_forms_into_form_select($field)
    {
        $forms = GFFormsModel::get_forms(null, 'title');
        $field['choices'] = [];
        foreach ($forms as $form) {
            $field['choices'][$form->id] = $form->title;
        }

        return $field;
    }

    public function options_pages() {
        // Options Page
        if( function_exists('acf_add_options_page') && function_exists('acf_add_options_sub_page') )
        {

            $options = acf_add_options_page([
              'page_title' => 'Theme Options',
              'redirect' => true,
              'menu_slug' => 'theme_options',
              'position' => 91,
              'autoload' => true
            ]);
            $header = acf_add_options_sub_page(array(
              'page_title'  => 'Header Settings',
              'menu_title'  => 'Header',
              'post_id' => 'header',
              'parent_slug'   => $options['menu_slug']
            ));

            $footer = acf_add_options_sub_page(array(
              'page_title'  => 'Footer Settings',
              'menu_title'  => 'Footer',
              'post_id' => 'footer',
              'parent_slug'   => $options['menu_slug']
            ));

        }
    }

    public function update_acf_google_map_api_key() {
      if (defined('GOOGLE_MAPS_API_KEY')) {
        acf_update_setting('google_api_key', GOOGLE_MAPS_API_KEY);
      }
    }

    public function set_acf_google_map_api_key( $api ){
      if (defined('GOOGLE_MAPS_API_KEY')) {
        $api['key'] = GOOGLE_MAPS_API_KEY;
      }
      return $api;

    }

    public function add_menu_item_children_to_menu_items($menu) {
      $id = (isset($menu['ID']) ? $menu['ID'] : $menu['id']);
      $menu_obj = (array) wp_get_nav_menu_object( $id );
      $menu_items = wp_get_nav_menu_items( $id );
      if (!empty($menu_items)) {
        $rev_items = array_reverse ( $menu_items );
        $rev_menu = [];
        $cache = [];

        foreach ( $rev_items as $item ) :

          $formatted = array(
            'ID'          => abs( $item->ID ),
            'order'       => (int) $item->menu_order,
            'parent'      => abs( $item->menu_item_parent ),
            'title'       => $item->title,
            'url'         => $item->url,
            'attr'        => $item->attr_title,
            'target'      => $item->target,
            'classes'     => implode( ' ', $item->classes ),
            'xfn'         => $item->xfn,
            'description' => $item->description,
            'object_id'   => abs( $item->object_id ),
            'object'      => $item->object,
            'type'        => $item->type,
            'type_label'  => $item->type_label,
            'children'    => array(),
          );

          if ( array_key_exists( $item->ID , $cache ) ) {
            $formatted['children'] = array_reverse( $cache[ $item->ID ] );
          }

          $formatted = apply_filters( 'rest_menus_format_menu_item', $formatted );

          if ( $item->menu_item_parent != 0 ) {

            if ( array_key_exists( $item->menu_item_parent , $cache ) ) {
              array_push( $cache[ $item->menu_item_parent ], $formatted );
            } else {
              $cache[ $item->menu_item_parent ] = array( $formatted, );
            }

          } else {

            array_push( $rev_menu, $formatted );
          }

        endforeach;
      }
      $menu_obj['items'] = array_reverse( $rev_menu );
      return $menu_obj;
    }

    public function get_nav_menu_item_children( $parent_id, $nav_menu_items, $depth = true ) {

        $nav_menu_item_list = array();

        foreach ( (array) $nav_menu_items as $nav_menu_item ) :

            if ( $nav_menu_item->menu_item_parent == $parent_id ) :

                $nav_menu_item_list[] = $this->format_menu_item( $nav_menu_item, true, $nav_menu_items );

                if ( $depth ) {
                    if ( $children = $this->get_nav_menu_item_children( $nav_menu_item->ID, $nav_menu_items ) ) {
                        $nav_menu_item_list = array_merge( $nav_menu_item_list, $children );
                    }
                }

            endif;

        endforeach;

        return $nav_menu_item_list;
    }

    public function get_full_post_object($obj) {
        $typeObj = get_post_type_object($obj['post_type']);
        $plural = strtolower(str_replace(' ', '-', $typeObj->label));
        $ID = $obj['ID'];
        // $dump = ['url' => rest_url("/wp/v2/$plural/$ID?_embed=true"), 'typeObj' => json_decode(file_get_contents(rest_url("/wp/v2/$plural/$ID?_embed=true&_envelope=true")), true)];
        // Utils::data2file(get_template_directory() . '/dump.php', $dump, 'php');
        $response = json_decode(file_get_contents(rest_url("/wp/v2/$plural/$ID?_embed=true")), true);
        $fullPost = $response;
        return $fullPost;
    }

    public function get_full_post_objects($type, $ids) {
        $url = rest_url("/wp/v2/$type/?_embed=true&orderby=include&include=" . implode($ids, ','));
        $response = json_decode(file_get_contents($url), true);
        // Utils::data2file(get_template_directory() . '/dump.php', [$url, $response], 'php');
        return $response;
    }

    public function get_cached_page_data_by_id($id) {
      if (is_numeric($id) && intval($id) !== 0) {
        // Uncomment if you need to debug caching
        delete_transient('api_page_' . $id . '_fields');
        $cached = get_transient('api_page_' . $id . '_fields');
        return $cached;
      }
      return false;
    }

    public function cache_page_fields_data($id, $data, $expire = 86400) {
      if (is_numeric($id) && intval($id) !== 0) {
        set_transient('api_page_' . $id . '_fields', $data, $expire);
      }
      return $data;
    }

    public function populate_flex_content_fields( $data, $request, $response, $object ) {
        $swap  = $response instanceof \WP_REST_Response;
        if ( $swap ) {
            $data = $response->get_data();
        }
        $id = $data['id'];
        // $cached = $this->get_cached_page_data_by_id($id);
        // if ($cached === false) {

            $data = $this->get_fully_populated_flex_contents($data, $request, $response, $object);
        // }
        if ( $swap ) {
            $response->data = $data;
            $data = $response;
        }
        // $data = $this->cache_page_fields_data($id, $data, 7200);

        return $data;
    }

    public function get_fully_populated_flex_contents($data, $request, $response, $object) {

        if(isset($data['acf']) && isset($data['acf']['sections']) && !empty($data['acf']['sections'])) {
          foreach($data['acf']['sections'] as $s=>$sec) {
            // switch ($sec['acf_fc_layout']) {
            //   case 'upcoming_events':
            //   if (isset($sec['events']) && !empty($sec['events'])) {
            //     $ids = [];
            //     foreach($sec['events'] as $p=>$prop) {
            //         $obj = (array)$prop;
            //         $ids[] = $obj['ID'];
            //     }
            //     $posts = $this->get_full_post_objects('events', $ids);
            //     $sec['events'] = $posts;
            //   }
            //   break;
            // }
            // $data['acf']['sections'][$s] = $sec;
          }
        }

        return $data;
    }


}
