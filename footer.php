<?php
//Capturando a URL completa até a pasta do Tema
global $theme_path;

//Capturando os dados das Opções do Tema 
global $options;
$options = get_option('p2h_theme_options');

$footer_text = $options['footer_text'];
$twitter_url =  $options['twitter_url'];
$facebook_url =  $options['facebook_url'];
$youtube_url =  $options['youtube_url'];
$telefone =  $options['telefone'];
$email =  $options['email'];
$endereco =  $options['endereco'];
$google_code =  $options['google_code'];
?>

<!-- start -->


<!-- end -->

<?php wp_footer(); ?>

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

<!-- Google Analytics -->
<?php echo $google_code; ?>

</body>
</html>