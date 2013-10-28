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
            // array(
            //     'name' => 'Escolha a Imagem',
            //     'id'   => $prefix . 'slide',
            //     'type' => 'file',
            // ),
            array(
                'name' => 'Escolha a Imagem',
                'id'   => $prefix . 'slide',
                'type' => 'text',
            ),
            // array(
            //     'name' => 'Taxonomy',
            //     'id'   => $prefix . '_tax',
            //     'type' => 'taxonomy_select',
            //     'taxonomy' => 'category_colaborador'
            // ),
        ),
    );
    $meta_boxes[] = array(
        'id'         => 'info-album',
        'title'      => 'Mais',
        'pages'      => array('album'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Link Likestore',
                'id'   => $prefix . 'likestore',
                'type' => 'text',
                'std'  => '#',
            ),
            array(
                'name' => 'ID do Álbum',
                'desc' => 'ID da categoria do álbum',
                'id'   => $prefix . 'album',
                'type' => 'text',
            ),
            array(
                'name' => 'Arquivo Upload',
                'id'   => $prefix . 'upload',
                'type' => 'file',
            ),
        ),
    );

    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
    $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);

    if ($template_file == 'page-fotos.php') {

        $meta_boxes[] = array(
            'id'         => 'flickr-album',
            'title'      => 'Álbuns',
            'pages'      => array('page'), // Post type
            'context'    => 'normal',
            'priority'   => 'high',
            'show_names' => true, // Show field names on the left
            'fields'     => array(
                array(
                    'name' => 'ID Flickr 1',
                    'id'   => $prefix . 'flickr_1',
                    'type' => 'text_medium',
                //    'std'  => '#',
                ),
                array(
                    'name' => 'ID Flickr 2',
                    'id'   => $prefix . 'flickr_2',
                    'type' => 'text_medium',
                //    'std'  => '#',
                ),
                array(
                    'name' => 'ID Flickr 3',
                    'id'   => $prefix . 'flickr_3',
                    'type' => 'text_medium',
                //    'std'  => '#',
                ),
                array(
                    'name' => 'ID Flickr 4',
                    'id'   => $prefix . 'flickr_4',
                    'type' => 'text_medium',
                //    'std'  => '#',
                ),
            ),
        );
    
    }

    $meta_boxes[] = array(
        'id'         => 'Url Vídeo',
        'title'      => 'URL Vídeo',
        'pages'      => array('video'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Escolha a ID Youtube',
                'id'   => $prefix . 'video',
                'type' => 'text',
            ),
            array(
                'name' => 'Descrição',
                'id'   => $prefix . 'descricao',
                'type' => 'wysiwyg',
                'options' => array( 'textarea_rows' => 25 ),
            ),
        ),
    );
    $meta_boxes[] = array(
        'id'         => 'url-colaborador',
        'title'      => 'URL Colaborador',
        'pages'      => array('colaborador'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Escolha a Url',
                'id'   => $prefix . 'url',
                'type' => 'text',
                'std'  => '#'
            ),
        ),
    );
    $meta_boxes[] = array(
        'id'         => 'letra',
        'title'      => 'Música',
        'pages'      => array('musica'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Letra',
                'id'   => $prefix . 'letra',
                'type'    => 'wysiwyg',
                'options' => array( 'textarea_rows' => 30 ),
            ),
            array(
                'name' => 'MP3',
                'id'   => $prefix . 'mp3',
                'type' => 'file',
            ),
            array(
                'name' => 'Vídeo Youtube',
                'id'   => $prefix . 'url_video',
                'type' => 'text',
                'std'  => '#'
            ),
            array(
                'name' => 'Likestore',
                'id'   => $prefix . 'likestore',
                'type' => 'text',
                'std'  => '#'
            ),
        ),
    );
    $meta_boxes[] = array(
        'id'         => 'info',
        'title'      => 'Informações da Música',
        'pages'      => array('musica'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Compositores',
                'id'   => $prefix . 'compositores',
                'type' => 'text',
            ),
            array(
                'name' => 'Créditos',
                'id'   => $prefix . 'creditos',
                'type'    => 'wysiwyg',
                'options' => array( 'textarea_rows' => 15 ),
            ),
        ),
    );
    $meta_boxes[] = array(
        'id'         => 'info',
        'title'      => 'Informações do Evento',
        'pages'      => array('agenda'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name'    => 'Tipo Evento',
                'id'      => $prefix . 'tipo',
                'type'    => 'select',
                'options' => array(
                    array( 'name' => 'Show', 'value' => 'show', ),
                    array( 'name' => 'Entrevista', 'value' => 'entrevista', ),
                    array( 'name' => 'Ensaio', 'value' => 'ensaio', ),
                ),
            ),
            array(
                'name' => 'Data',
                'id'   => $prefix . 'data',
                'type' => 'text_date',
            ),
            array(
                'name' => 'Horário',
                'id'   => $prefix . 'horario',
                'type' => 'text_time',
            ),
            array(
                'name' => 'Local',
                'desc' => 'Nome do Local',
                'id'   => $prefix . 'local',
                'type' => 'text',
            ),
            array(
                'name' => 'Endereço',
                'desc' => 'Logradouro, número, etc...',
                'id'   => $prefix . 'endereco',
                'type' => 'text',
            ),
        ),
    );
    return $meta_boxes;
}





?>