<?php
//Capturando os dados das Opções do Tema 
global $options;
$options = get_option('p2h_theme_options');

$footer_text = $options['footer_text'];
$twitter_url =  $options['twitter_url'];
$facebook_url =  $options['facebook_url'];
$youtube_url =  $options['youtube_url'];
$google_code =  $options['google_code'];
$telefone =  $options['telefone'];
$email =  $options['email'];
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<meta name="description" content="<?php the_excerpt_rss(); ?>" />
<?php endwhile; endif; elseif(is_home()) : ?>
<meta name="description" content="<?php bloginfo('description'); ?>" />
<?php endif; ?>

<?php
if(is_single() || is_page() || is_category() || is_home()) {
	echo '<meta name="robots" content="all,noodp" />';
}
else if(is_archive()) {
	echo '<meta name="robots" content="noarchive,noodp" />';
}
else if(is_search() || is_404()) {
	echo '<meta name="robots" content="noindex,noarchive" />';
}

global $theme_path;
$theme_path = get_template_directory_uri();

?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link rel="shortcut icon" href="<?php echo $theme_path; ?>/dist/img/favicon.png" type="image/x-icon" />

<?php wp_get_archives('type=monthly&format=link'); ?>

<title><?php
 
    // Page or Single Post
    if ( is_page() or is_single() ) {
        the_title();
 
    // Category Archive
    } elseif ( is_category() ) {
        printf( 'Arquivo de &lsquo;%s&rsquo;', single_cat_title('', false) );
 
    // Tag Archive
    } elseif ( function_exists('is_tag') and function_exists('single_tag_title') and is_tag() ) {
        printf( 'Arquivo de Tag de &lsquo;%s&rsquo;', single_tag_title('', false) );
 
    // General Archive
    } elseif ( is_archive() ) {
        printf( __('%s Arquivo'), wp_title('', false) );
 
    // Search Results
    } elseif ( is_search() ) {
        printf( 'Resultados da busca por &lsquo;%s&rsquo;', get_query_var('s') );
    }
 
    // Insert separator for the titles above
    if ( !is_home() and !is_404() ) {
        echo ' - ';
    }
 
    // Finally the blog name
    bloginfo('name');
 
    ?></title>
    
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
    
    <?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?>>

<!-- start -->

<!-- end -->