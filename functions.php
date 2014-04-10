<?php
// Carregando os arquivos necessários para ativar as opções do tema
global $options;
$options = get_option('p2h_theme_options'); 
$functions_path = TEMPLATEPATH . '/functions/';

require_once ($functions_path . 'excerpt.php');
require_once ($functions_path . 'paginacao.php');
require_once ($functions_path . 'permissoes.php');
require_once ($functions_path . 'sidebar.php');
require_once ($functions_path . 'menus.php');
require_once ($functions_path . 'validaemail.php');
require_once ($functions_path . 'pegadata.php');
require_once ($functions_path . 'lightbox.php');
require_once ($functions_path . 'slide.php');

require_once ($functions_path . 'scripts.php');
require_once ($functions_path . 'theme-options.php');
require_once ($functions_path . 'custom-post-types.php');
require_once ($functions_path . 'custom-metaboxes.php');
require_once ($functions_path . 'bootstrap_walker.php');

// require_once ($functions_path . 'shortcodes.php');
// require_once ($functions_path . 'twitter.php');
//require_once ($functions_path . 'flickr.php');


add_filter( 'cmb_meta_boxes', 'metaboxes_clientes' );
add_action( 'init', 'inicializa_metabox', 9999 );
function inicializa_metabox() {
    if ( ! class_exists( 'cmb_Meta_Box' ) )
        require_once 'metaboxes/init.php';
}

//SUBSTITUIR LINHA ABAIXO QUANDO SITE FOR LANÇADO
//if (!current_user_can('manage_options')) {
if (!current_user_can('manage_options')) {

    add_filter('show_admin_bar', '__return_false');
}

// Habilitando o uso de sub-templates para o template single.php com por exemplo single-nomedacategoria.php
add_filter('single_template', create_function('$t', 'foreach( (array) get_the_category() as $cat ) { if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") ) return TEMPLATEPATH . "/single-{$cat->slug}.php"; } return $t;' ));

// Habilitando o uso da imagem destacada
if ( function_exists( 'add_theme_support' ) ) add_theme_support( 'post-thumbnails' );
add_image_size('blog', 320, 205, true);