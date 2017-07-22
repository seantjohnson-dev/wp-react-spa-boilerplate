<?php

namespace SeanJohn\Lib;

use TimberSite as TimberSite;
use TimberMenu as TimberMenu;
use TimberHelper as TimberHelper;
use Timber as Timber;
use Twig_Extension_StringLoader as Twig_Extension_StringLoader;
use Twig_Filter_Function as Twig_Filter_Function;
use SeanJohn\Sidebars\Sidebars;
use SeanJohn\Menus\Walkers\PrimaryNavWalker;

class StarterSite extends TimberSite {

	function __construct(){

    if ( ! class_exists( 'Timber' ) ) {
        add_action('admin_notices', function() {
            echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
        });
        return;
    }

		add_theme_support('menus');
		add_filter('timber_context', [$this, 'add_to_context']);
		add_filter('get_twig', [$this, 'add_to_twig']);
		parent::__construct();
	}

	function add_to_context($context){
		$context['wp_link_pages'] = TimberHelper::function_wrapper('wp_link_pages', [
		  'before' => '<nav class="page-nav"><p>' . __('Pages:', TEXT_DOMAIN),
		  'after' => '</p></nav>'
		]);

	    if (has_nav_menu('primary_nav')) {
	      $context['primary_nav'] = new TimberMenu('primary_nav');
	      $context['primary_nav_html'] = wp_nav_menu([
	        'container_class' => 'level-container level-1-container',
	        'menu_class' => 'level-list level-1-list',
	        'theme_location' => 'primary_nav',
	        'walker' => new PrimaryNavWalker(),
	        'depth' => 4,
	        'echo' => false
	      ]);
	    }

		$context['social_menu'] = new TimberMenu('social_menu');
		$context['site'] = $this;

		$context['display_sidebar'] = Sidebars::display_sidebar();
        $context['sidebar_primary'] = Timber::get_widgets('primary-sidebar');

		return $context;
	}

	function add_to_twig($twig){
		/* this is where you can add your own fuctions to twig */
		$twig->addExtension(new Twig_Extension_StringLoader());
		$twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
		return $twig;
	}

}
