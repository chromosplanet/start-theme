<?php


function metaboxes_clientes( array $meta_boxes ) {
    // Start with an underscore to hide fields from custom fields list
    $prefix = 'cp_';

    $meta_boxes[] = array(
        'id'         => 'Slide',
        'title'      => 'URL Externo',
        'pages'      => array('slide'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Escolha a Url',
                'id'   => $prefix . 'slide',
                'type' => 'text',
            ),
        ),
    );
    return $meta_boxes;
}





?>