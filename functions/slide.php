<?php 
function cp_slide( $post_type = "post", $limite = 4, $caption = false, $indicator = true, $resposive = true){

	//Configurando as principais variáveis
	$resposive = ( is_bool($resposive) && $resposive == true )? 'img-responsive' : $resposive;

	//Configurando os argumentos para pegar o slide.
	if( $post_type == 'post' ):
		$args = array(
	  	'post_type' => $post_type,
		  'posts_per_page' => $limite,
		  'category_name' => 'slide'
		);
	else:
		$args = array(
	  	'post_type' => $post_type,
		  'posts_per_page' => $limite,
		);
	endif;

	//Buscando os slides com os argumentos configurado acima.
	$slides = get_posts( $args );

	//Zerando a variável $output
	$output = "";

	//Verifica se tem slide.
	if( !empty($slides) ):

		$output .= "<div id='carousel-".$post_type."' class='carousel slide' data-ride='carousel'>";

		if( $indicator == true ):
			//Indicators
		  $output .= "<ol class='carousel-indicators'>";
			for ($s=0; $s < count($slides); $s++) : 
				$active = ( $s == 0 )?"active":"";
			  $output .= "<li data-target='#carousel-".$post_type."' data-slide-to='".$s."' class='".$active."'></li>";
			endfor;
		  $output .= "</ol>";
		endif;

	  // Loop dos slides
	  $output .= "<div class='carousel-inner'>";

	  $i = 0;
		foreach ( $slides as $slide ) :
			$active = ( $i == 0 )?" active":"";
			
			$output .= "<div class='item".$active."'>";
			$output .= get_the_post_thumbnail( $slide->ID, 'full', array( 'class' => $resposive, 'alt' => $slide->post_title ) );
			
			if( $caption == true ):
				$output .= "<div class='carousel-caption'>";
				$output .= esc_html( $slide->post_title );
				$output .= "</div>";
			endif;
			$output .= "</div>";

			$i++;
		endforeach;

	  $output .= "</div>";
		$output .= "</div>";
	
	  // Controles
	  $output .= "<a class='left carousel-control' href='#carousel-".$post_type."' data-slide='Anterior'>";
	  $output .= "<span class='glyphicon glyphicon-chevron-left'></span>";
	  $output .= "</a>";
	  $output .= "<a class='right carousel-control' href='#carousel-".$post_type."' data-slide='Próximo'>";
	  $output .= "<span class='glyphicon glyphicon-chevron-right'></span>";
	  $output .= "</a>";

	else:
		$output .= "Nenhum slide encontrado";
	endif;


	$output .= "</div>";

	echo $output;

}