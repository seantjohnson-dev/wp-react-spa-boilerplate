<?php

namespace SeanJohn\Roles;
use SeanJohn\Lib\BaseClass;

class Roles extends BaseClass
{
    public function __construct($options = [])
    {
        parent::__construct($options);
        add_action('admin_init', [$this, 'add_developer_role_and_caps']);
        add_action('admin_init', [$this, 'add_priv_editor_role_and_caps']);
    }

    public function add_priv_editor_role_and_caps()
    {
        if (!is_a(get_role('privileged_editor'), 'WP_Role')) {
            $editor = get_role('editor');

            $e_caps = $editor->capabilities;

            $priv_caps = [
                'active_plugins' => true,
                'add_users' => true,
                'create_users' => true,
                'edit_theme_options' => true,
                'edit_users' => true,
                'export' => true,
                'install_plugins' => true,
                'list_users' => true,
                'manage_options' => true,
                'update_core' => true,
                'update_plugins' => true,
            ];

            $final_caps = array_merge($e_caps, $priv_caps);

            $role = add_role('privileged_editor', __('Privileged Editor'), $final_caps);
        }
    }

    public function add_developer_role_and_caps()
    {
        // if developer role doesn't exist, create it.
        if (!is_a(get_role('developer'), 'WP_Role')) {
            global $wp_roles;

            $all_roles = $wp_roles->roles;

            $all_caps = [];

            foreach ($all_roles as $r => $role) {
                $all_caps = array_merge($all_caps, $role['capabilities']);
            }

            // Loop through all capabilities available and enable them for the developer role.
            foreach ($all_caps as $c => &$cap) {
                $cap = 1;
            }

            $all_caps['develop'] = 1;
            $role = add_role('developer', __('Developer'), $all_caps);
        }
        // if developer role does exist, leave everything as is in the case that another admin or dev role revoked capabilities from another developer. - i.e. for not making standup meetings on time :)
    }

}
