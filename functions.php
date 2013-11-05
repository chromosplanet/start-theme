<?php
// Carregando os arquivos necessários para ativar as opções do tema
global $options;
$options = get_option('p2h_theme_options'); 
$functions_path = TEMPLATEPATH . '/functions/';
require_once ($functions_path . 'theme-options.php');
require_once ($functions_path . 'shortcodes.php');
require_once ($functions_path . 'custom-post-types.php');
require_once ($functions_path . 'custom-metaboxes.php');
require_once ($functions_path . 'bootstrap_walker.php');

add_filter( 'cmb_meta_boxes', 'metaboxes_clientes' );
add_action( 'init', 'inicializa_metabox', 9999 );
function inicializa_metabox() {
    if ( ! class_exists( 'cmb_Meta_Box' ) )
        require_once 'metaboxes/init.php';
}

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
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', 'http://code.jquery.com/jquery-latest.min.js');
        wp_enqueue_script( 'jquery' );
    }
}    
 
add_action('init', 'my_init_method');

// Configurando a largura de segurança do site
if ( ! isset( $content_width ) ) $content_width = 610;

// Habilitando o uso de sub-templates para o template single.php com por exemplo single-nomedacategoria.php
add_filter('single_template', create_function('$t', 'foreach( (array) get_the_category() as $cat ) { if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") ) return TEMPLATEPATH . "/single-{$cat->slug}.php"; } return $t;' ));

// Habilitando os arquivos de tradução do site
// Os arquivos de tradução podem ser encontrados na pasta /languages/ do seu tema
load_theme_textdomain( 'lang', TEMPLATEPATH . '/languages' );	

// Habilitando fundo personalizado para o site   
if (function_exists('add_custom_background')) add_custom_background();

// Habilitando o uso do gerenciador de menus
if (function_exists('add_theme_support')) add_theme_support('menus');

// Habilitando o uso da imagem destacada
if ( function_exists( 'add_theme_support' ) ) add_theme_support( 'post-thumbnails' );
//set_post_thumbnail_size(200, 120, true);
//add_image_size('thumb-custom-1', 640, 326, true);
//add_image_size('thumb-custom-2', 66, 66, true);

//Desativar cores Wordpress
function admin_color_scheme() {
   global $_wp_admin_css_colors;
   $_wp_admin_css_colors = 0;
}
add_action('admin_head', 'admin_color_scheme');

function disable_browser_upgrade_warning() {
    remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'disable_browser_upgrade_warning' );


// Registro de Sidebars
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Lateral',
'before_widget' => '<div class="widget">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));

// Função para customizar o tamanho limite do numero de palavras do resumo do post
function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		return $excerpt;
}

// Função para customizar o tamanho limite do numero de caracteres do resumo do post
function text_limit($text,$limit) {
	$excerpt = explode(' ', $text, $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		return $excerpt;
}

// Dando permissão para usuarios do tipo Editor gerenciarem os Widgets
if(is_admin()){
	$role =& get_role('editor');
	$role->add_cap('edit_theme_options');
	$role->add_cap('manage_options');
	$role->add_cap('manage_polls');
	$role->remove_cap('switch_themes');
}

// Removendo alguns itens do menu para usuarios do tipo Editor
if( !current_user_can('switch_themes') ) {
		function remove_menus () {
		global $menu;
		$restricted = array(__('Tools'), __('Settings'), __('Plugins'));
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
	}
	add_action('admin_menu', 'remove_menus');
}

// Função para exibir os últimos tweets de um usuario do Twitter
function twitter_list($usernames, $limit, $show) {
 
    $prefix = "<ul class='twitter_list'>"; // This comes before the entire block of tweets.
	$prefix_sub = "<li>"; // This comes before each tweet on the feed.
	$wedge = "<br />"; // This comes after the username but before the tweet content.
	$suffix_sub = "</li>"; // This comes after each tweet on the feed.
	$suffix = "</ul>"; // This comes after the entire block of tweets.
	$usernames = str_replace(" ", "+OR+from%3A", $usernames);
    $feed = "http://search.twitter.com/search.atom?q=from%3A" . $usernames . "&rpp=" . $limit;
    $feed = wp_remote_fopen($feed);
    $feed = str_replace("&", "&", $feed);
    $feed = str_replace("<", "<", $feed);
    $feed = str_replace(">", ">", $feed);
    $clean = explode("<entry>", $feed);
    $amount = count($clean) - 1;
 
 	echo $prefix;
    for ($i = 1; $i <= $amount; $i++) {
 
    	$entry_close = explode("</entry>", $clean[$i]);
    	$clean_content_1 = explode("<content type=\"html\">", $entry_close[0]);
    	$clean_content = explode("</content>", $clean_content_1[1]);
    	$clean_name_2 = explode("<name>", $entry_close[0]);
    	$clean_name_1 = explode("(", $clean_name_2[1]);
    	$clean_name = explode(")</name>", $clean_name_1[1]);
    	$clean_uri_1 = explode("<uri>", $entry_close[0]);
    	$clean_uri = explode("</uri>", $clean_uri_1[1]);
 
    	// Make the links clickable and take care quote & apostrophe
 
    	$clean_content[0] = str_replace("&lt;", "<", $clean_content[0]); 
    	$clean_content[0] = str_replace("&gt;", ">", $clean_content[0]); 
    	$clean_content[0] = str_replace("&amp;", "&", $clean_content[0]); 
    	$clean_content[0] = str_replace("&quot;", "\"", $clean_content[0]);
    	$clean_content[0] = str_replace("&apos;", "'", $clean_content[0]);
 
    	echo $prefix_sub;
 
    	if ($show == 1) { 
    		echo  "<a href=\"" . $clean_uri[0] . "\" class=\"twitterlink\">" . $clean_name[0] . "</a>" . $wedge; 
    	}
    	echo $clean_content[0];
    	echo $suffix_sub;
    }
	echo $suffix;
}

// Função para gerar paginação númerica
function wp_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='posts_pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}


// Imagem de Cabeçalho personalizada
/*
define( 'HEADER_TEXTCOLOR', '' );
define( 'HEADER_IMAGE_WIDTH', apply_filters( '', 930 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( '', 270 ) );
set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );
define( 'NO_HEADER_TEXT', true );
add_custom_image_header( '', '' );
*/

/*
<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
*/
?>
