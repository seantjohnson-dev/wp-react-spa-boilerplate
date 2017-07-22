<?php

namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
use Kirki as Kirki;

class FrontPage extends BaseCustomizer
{

    public function on_customize_register($wp_cust) {
        parent::on_customize_register($wp_cust);
        $this->edit_existing($wp_cust);
    }

    public function set_panels()
    {
        Kirki::add_panel('blog_home_settings', array(
            'priority' => 10,
            'title' => __('Front Page', TEXT_DOMAIN),
            'description' => __('Configure the front page settings here.', TEXT_DOMAIN),
        ));

        return $this;
    }

    public function set_sections()
    {
        Kirki::add_section('blog_front_settings', array(
            'priority' => 10,
            'title' => __('Front Page', TEXT_DOMAIN),
            'description' => __('Configure the blog and front page settings here.', TEXT_DOMAIN),
            // 'panel' => 'blog_home_settings'
        ));

        return $this;
    }

    public function add_controls()
    {
        Kirki::add_field('show_on_front', array(
            'type' => 'select',
            'settings' => 'show_on_front',
            'section' => 'blog_front_settings',
            'priority' => 10,
        ));

        return $this;
    }

    public function edit_existing($wp_cust)
    {
        $show_on_front = $wp_cust->get_control('show_on_front');
        $show_on_front->section = 'blog_front_settings';
        $show_on_front->priority = 10;

        $page_on_front = $wp_cust->get_control('page_on_front');
        $page_on_front->section = 'blog_front_settings';
        $page_on_front->priority = 20;

        $page_for_posts = $wp_cust->get_control('page_for_posts');
        $page_for_posts->section = 'blog_front_settings';
        $page_for_posts->priority = 30;

        return $this;
    }
}
