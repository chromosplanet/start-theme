<?php 
//Lightbox nas galerias sem plugin
add_filter('wp_get_attachment_link', 'add_gallery_id_rel');
function add_gallery_id_rel($link) {
    global $post;
    return str_replace('<a href', '<a data-lightbox="gallery-'. $post->ID .'" href', $link);
}