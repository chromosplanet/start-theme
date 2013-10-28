<?php get_header(); ?>

<!-- start -->
<?php 
get_template_part('includes/loop');

//Loop utilizando a funçao get_posts() para recuperar dados de um Custom Post Type
/*
$args = array('post_type'=>'portifolio');
$my_posts = get_posts($args);

foreach( $my_posts as $post ):

	echo $post->post_title;
	echo '<br /><br />';
	echo get_the_post_thumbnail($post->ID,'thumbnail');
	echo '<br /><br />';
	
	$terms = wp_get_post_terms($post->ID,'servico');
	foreach( $terms as $term ):
		echo '<a href="'.get_term_link($term->slug,'servico').'">'.$term->name.'</a>';
	endforeach;
	
endforeach;
*/
?>
<!-- end -->

<?php get_footer(); ?>