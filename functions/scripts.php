<?php 
	function my_admin_scripts() {
	  wp_enqueue_script('media-upload');
	  wp_enqueue_script('thickbox');
	  wp_register_script('my-upload', WP_PLUGIN_URL.'/my-script.js', array('jquery','media-upload','thickbox'));
	  wp_enqueue_script('my-upload');
	}

	function my_admin_styles() {
	  wp_enqueue_style('thickbox');
	}

	add_action('admin_print_scripts', 'my_admin_scripts');
	add_action('admin_print_styles', 'my_admin_styles');

	// Carregando a biblioteca jQuery automaticamente no cabeçalho do site
	function my_init_method() {
    if (!is_admin()) {
      //  wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', 'http://code.jquery.com/jquery-latest.min.js');
        wp_enqueue_script( 'jquery' );
    }
	}    
	 
	add_action('init', 'my_init_method');
?>