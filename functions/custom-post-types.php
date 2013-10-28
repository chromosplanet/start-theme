<?php
/* Post types */

/* Post Type produto */
add_action('init', 'produto_register');
function produto_register() {
	 $labels = array(
			'name' => _x('Produtos', 'post type general name'),
			'singular_name' => _x('Cursos e Palestras', 'post type singular name'),
			'all_items' => __('Todos produtos'),
			'add_new' => _x('Adicionar novo', 'Produto'),
			'add_new_item' => __('Adicionar novo produto'),
			'edit_item' => __('Editar produto'),
			'new_item' => __('Novo produto'),
			'view_item' => __('Ver produto'),
			'search_items' => __('Procurar produto'),
			'not_found' =>  __('Nada encontrado'),
			'not_found_in_trash' => __('Nada encontrado no lixo'),
			'parent_item_colon' => ''
	);
	$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'has_archive' => true,
			'menu_position' => 6,
			'supports' => array('title','editor','thumbnail'),
			'taxonomies' => array('category_produto'),
			'rewrite' => array('slug' => 'tipo-produtos')
	  );
	register_post_type('produto',$args);
}

register_taxonomy("category_produto", array("produto"), array("hierarchical" => true, "label" => "Categorias", "singular_label" => "Categoria",'rewrite' => array( 'slug' => 'categoria-produto' )));
?>