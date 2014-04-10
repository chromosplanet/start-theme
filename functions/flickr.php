<?php

function api_setflickr(){

  $params = array(
    'api_key' => 'c0aa8c6bf498e60719f0fb8d6315e556', // Número da api
    'method'  => 'flickr.photosets.getList', // Metodo
    'user_id' => '106191136@N06', // Usuário ID
    'format'  => 'php_serial'
  );

  $encoded_params = array();
  foreach ($params as $k => $v):
    $encoded_params[] = urlencode($k).'='.urlencode($v);
  endforeach;

  $ch = curl_init();
  $timeout = 5; // set to zero for no timeout
  curl_setopt ($ch, CURLOPT_URL, 'http://api.flickr.com/services/rest/?'.implode('&', $encoded_params));
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $file_contents = curl_exec($ch);
  curl_close($ch);

  $rsp_obj = unserialize($file_contents);

  foreach ( $rsp_obj["photosets"]["photoset"] as $album ) :
    api_flickr($album["id"]);
  endforeach;
}


function api_flickr($photoset_id){

  $params = array(
    'api_key' => 'c0aa8c6bf498e60719f0fb8d6315e556',
    'method'  => 'flickr.photosets.getPhotos',
    'photoset_id' => $photoset_id,
    'extras'  => 'date_upload',
    'format'  => 'php_serial'
  );

  $encoded_params = array();
  foreach ($params as $k => $v):
    $encoded_params[] = urlencode($k).'='.urlencode($v);
  endforeach;

  $ch = curl_init();
  $timeout = 5; // set to zero for no timeout
  curl_setopt ($ch, CURLOPT_URL, 'http://api.flickr.com/services/rest/?'.implode('&', $encoded_params));
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $file_contents = curl_exec($ch);
  curl_close($ch);

  $rsp_obj = unserialize($file_contents);

  
 $output .= '<div class="flickr">';

  $i = 0;
  foreach ( $rsp_obj["photoset"]["photo"] as $afoto ) :
    if( $i == 0 ):
      $output .= '<a data-lightbox="roadtrip'.$photoset_id.'" href="http://farm'.$afoto['farm'].'.static.flickr.com/'.$afoto['server'].'/'.$afoto['id'].'_'.$afoto['secret'].'_b.jpg" alt="'.$afoto['title'].'" class="thumbnail" title="'.$rsp_obj["photoset"]['title'].'">';
        $output .= '<img src="http://farm'.$afoto['farm'].'.static.flickr.com/'.$afoto['server'].'/'.$afoto['id'].'_'.$afoto['secret'].'_m.jpg" alt="'.$rsp_obj["photoset"]['title'].'" />';
        $output .= "<h4>".$rsp_obj["photoset"]['title']."</h4>";
        $output .= "<p>".$rsp_obj["photoset"]['total']." fotos</p>";
      $output .= '</a>';
    else:

      $output .= '<a data-lightbox="roadtrip'.$photoset_id.'" href="http://farm'.$afoto['farm'].'.static.flickr.com/'.$afoto['server'].'/'.$afoto['id'].'_'.$afoto['secret'].'_b.jpg" alt="'.$afoto['title'].'" class="thumbnail" title="'.$rsp_obj["photoset"]['title'].'" style="display:none;">';
        $output .= '<img src="http://farm'.$afoto['farm'].'.static.flickr.com/'.$afoto['server'].'/'.$afoto['id'].'_'.$afoto['secret'].'_m.jpg" alt="'.$rsp_obj["photoset"]['title'].'" />';
      $output .= '</a>';
    endif;
    
    $i++;
  endforeach;

 $output .= '</div>';

  echo $output;
}