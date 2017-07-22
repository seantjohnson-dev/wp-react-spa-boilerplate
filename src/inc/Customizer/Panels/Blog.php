<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
  use Kirki as Kirki;

  class Blog extends BaseCustomizer
  {
      public function set_panels()
      {
          Kirki::add_panel('blog', array(
            'priority' => 30,
            'title' => __('Blog', TEXT_DOMAIN),
            'description' => __('Configure your blog settings here.', TEXT_DOMAIN),
         ));

          return $this;
      }

      public function set_sections()
      {
          Kirki::add_section('blog', array(
        'title' => __('Blog', TEXT_DOMAIN),
        // 'panel' => 'blog',
        'priority' => 15,
      ));

          return $this;
      }

      public function set_controls()
      {
          Kirki::add_field('blog_post_mode', array(
            'type' => 'radio-buttonset',
            'settings' => 'blog_post_mode',
            'label' => __('Archives Display Mode', TEXT_DOMAIN),
            'description' => __('Display the excerpt or the full post on post archives.', TEXT_DOMAIN),
            'section' => 'blog',
            'priority' => 10,
            'default' => 'excerpt',
            'choices' => array(
              'excerpt' => __('Excerpt', TEXT_DOMAIN),
              'full' => __('Full Post', TEXT_DOMAIN),
            ),
          ));

          Kirki::add_field('entry_meta_config', array(
            'type' => 'text',
            'settings' => 'entry_meta_config',
            'label' => __('Post Meta elements', TEXT_DOMAIN),
            'subtitle' => __('You can define a comma-separated list of meta elements you want on your posts, in the order that you want them. Accepted values: <code>author, sticky, date, category, tags, comments</code>', TEXT_DOMAIN),
            'section' => 'blog',
            'priority' => 20,
            'default' => 'date, author, comments',
          ));

          Kirki::add_field('post_excerpt_length', array(
            'type' => 'slider',
            'settings' => 'post_excerpt_length',
            'label' => __('Post excerpt length', TEXT_DOMAIN),
            'description' => __('Choose how many words should be used for post excerpt. Default: 55', TEXT_DOMAIN),
            'section' => 'blog',
            'priority' => 30,
            'default' => 55,
            'choices' => array(
              'min' => 10,
              'max' => 150,
              'step' => 1,
            ),
          ));

          Kirki::add_field('post_excerpt_link_text', array(
            'type' => 'text',
            'settings' => 'post_excerpt_link_text',
            'label' => __('Post excerpt "more" text', TEXT_DOMAIN),
            'subtitle' => __('Text to display in case of excerpt too long. Default: Continued', TEXT_DOMAIN),
            'section' => 'blog',
            'priority' => 42,
            'default' => __('Continued', TEXT_DOMAIN),
          ));

          return $this;
      }
  }
