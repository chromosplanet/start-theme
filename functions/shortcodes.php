<?php
function hello_world( $atts ){
	return "Hello World!!";
}
add_shortcode( 'foobar', 'hello_world' );
?>