<?php if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'THEME_URL', get_bloginfo('template_directory') );
function theme_load_scripts() {
	$theme_version = esc_attr(wp_get_theme()->get('Version'));
	wp_register_style( 'linecons',          THEME_URL.'/css/fonts/linecons/css/linecons.css', array(),   $theme_version , 'all'  );
    wp_register_style( 'font-awesome',      THEME_URL.'/css/font-awesome.min.css', array(), $theme_version, 'all'  );
	wp_register_style( 'bootstrap',         THEME_URL.'/css/bootstrap.css', array(), $theme_version, 'all'  );
	wp_register_style( 'xenon-core',        THEME_URL.'/css/xenon-core.css', array(), $theme_version, 'all'  );
	wp_register_style( 'xenon-components',  THEME_URL.'/css/xenon-components.css', array(), $theme_version );
	wp_register_style( 'xenon-skins',       THEME_URL.'/css/xenon-skins.css', array(), $theme_version );
	wp_register_style( 'nav',               THEME_URL.'/css/nav.css', array(), $theme_version );

	wp_register_script( 'bootstrap',        THEME_URL.'/js/bootstrap.min.js', array('jquery'), $theme_version, true );
	wp_register_script( 'TweenMax',         THEME_URL.'/js/TweenMax.min.js', array('jquery'), $theme_version, true );
	wp_register_script( 'resizeable',       THEME_URL.'/js/resizeable.js', array('jquery'), $theme_version, true );
	wp_register_script( 'joinable',         THEME_URL.'/js/joinable.js', array('jquery'), $theme_version, true );
	wp_register_script( 'xenon-api',        THEME_URL.'/js/xenon-api.js', array('jquery'), $theme_version, true );
	wp_register_script( 'xenon-toggles',    THEME_URL.'/js/xenon-toggles.js', array('jquery'), $theme_version, true );
	wp_register_script( 'xenon-custom',     THEME_URL.'/js/xenon-custom.js', array('jquery'), $theme_version, true );


	if( !is_admin() )
    {
		wp_enqueue_style('linecons');
		wp_enqueue_style('font-awesome');
		wp_enqueue_style('bootstrap');
		wp_enqueue_style('xenon-core');
		wp_enqueue_style('xenon-components');
		wp_enqueue_style('xenon-skins'); 
		wp_enqueue_style('nav'); 
 
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//cdn.staticfile.org/jquery/2.0.0/jquery.min.js', array(), $theme_version ,false);
		wp_enqueue_script('jquery');
 
		wp_enqueue_script('bootstrap');
		wp_enqueue_script('TweenMax');
		wp_enqueue_script('resizeable'); 
		wp_enqueue_script('joinable'); 
		wp_enqueue_script('xenon-api'); 
		wp_enqueue_script('xenon-toggles'); 
		wp_enqueue_script('xenon-custom'); 
 

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	wp_localize_script('app', 'Theme' , array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	)); 
}
add_action('wp_enqueue_scripts', 'theme_load_scripts');
 