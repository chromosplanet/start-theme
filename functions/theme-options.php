<?php
$themename = "";
$shortname = "p2h";
$version = "1.1";

$option_group = $shortname.'_theme_option_group';
$option_name = $shortname.'_theme_options';


// Load stylesheet and jscript
add_action('admin_init', 'p2h_add_init');

function p2h_add_init() {
	$file_dir = get_template_directory_uri();
	wp_enqueue_style("p2hCss", $file_dir."/functions/theme-options.css", false, "1.0", "all");
	wp_enqueue_script("p2hScript", $file_dir."/functions/theme-options.js", false, "1.0");
}

// Create custom settings menu
add_action('admin_menu', 'p2h_create_menu');

function p2h_create_menu() {
	global $themename;
	//create new top-level menu
	add_theme_page( __( $themename.' Theme Options' ), __( 'Theme Options' ), 'edit_theme_options', basename(__FILE__), 'p2h_settings_page' );
}

// Register settings
add_action( 'admin_init', 'register_settings' );

function register_settings() {
   global $themename, $shortname, $version, $p2h_options, $option_group, $option_name;
  	//register our settings
	register_setting( $option_group, $option_name);
}

//Automatically List StyleSheets in Folder
/////////////////////////////////////////////

$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if((stristr($alt_stylesheet_file, ".css") !== false) && (stristr($alt_stylesheet_file, "default") == false)){
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}
array_unshift($alt_stylesheets, "default.css"); 

// Create theme options
global $p2h_options;

$functions_path = STYLESHEETPATH . '/functions/';

require_once($functions_path . 'theme-fild.php');



function p2h_settings_page() {
   global $themename, $shortname, $version, $p2h_options, $option_group, $option_name;
?>

<div class="wrap">
<div class="options_wrap">
<?php screen_icon(); ?><h2><?php echo $themename; ?> Op&ccedil;&otilde;es do tema</h2>
<p class="top-notice">Op&ccedil;&otilde;es para configura&ccedil;&atilde;o do site</p>
<?php if ( isset ( $_POST['reset'] ) ): ?>
<?php // Delete Settings
global $wpdb, $themename, $shortname, $version, $p2h_options, $option_group, $option_name;
delete_option('p2h_theme_options');
wp_cache_flush(); ?>
<div class="updated fade"><p><strong><?php _e( $themename. ' options reset.' ); ?></strong></p></div>

<?php elseif ( isset ( $_REQUEST['updated'] ) ): ?>
<div class="updated fade"><p><strong><?php _e( $themename. ' options saved.' ); ?></strong></p></div>
<?php endif; ?>

<form method="post" action="options.php">

<?php settings_fields( $option_group ); ?>

<?php $options = get_option( $option_name ); ?>        

<?php foreach ($p2h_options as $value) {
if ( isset($value['id']) ) { $valueid = $value['id'];}
switch ( $value['type'] ) {
case "section":
?>
	<div class="section_wrap">
	<h3 class="section_title"><?php echo $value['name']; ?> 

<?php break; 
case "section-desc":
?>
	<span><?php echo $value['name']; ?></span></h3>
	<div class="section_body">

<?php 
break;
case 'text':
?>

	<div class="options_input options_text">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		<input name="<?php echo $option_name.'['.$valueid.']'; ?>" id="<?php echo $option_name.'['.$valueid.']'; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( isset( $options[$valueid]) ){ esc_attr_e($options[$valueid]); } else { esc_attr_e($value['std']); } ?>" />
	</div>

<?php
break;
case 'textarea':
?>
	<div class="options_input options_textarea">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		<textarea name="<?php echo $option_name.'['.$valueid.']'; ?>" type="<?php echo $option_name.'['.$valueid.']'; ?>" cols="" rows=""><?php if ( isset( $options[$valueid]) ){ esc_attr_e($options[$valueid]); } else { esc_attr_e($value['std']); } ?></textarea>
	</div>

<?php 
break;
case 'select':
?>
	<div class="options_input options_select">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		<select name="<?php echo $option_name.'['.$valueid.']'; ?>" id="<?php echo $option_name.'['.$valueid.']'; ?>">
		<?php foreach ($value['options'] as $option) { ?>
				<option <?php if ($options[$valueid] == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
		</select>
	</div>

<?php 
break;
case 'category':
$categories = get_categories();
var_dump($categories);
?>
	<div class="options_input options_select">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		<select name="<?php echo $option_name.'['.$valueid.']'; ?>" id="<?php echo $option_name.'['.$valueid.']'; ?>">
		<?php foreach ($value['options'] as $option) { ?>
				<option <?php if ($options[$valueid] == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
		</select>
	</div>    

<?php
break;
case "radio":
?>
	<div class="options_input options_select">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		  <?php foreach ($value['options'] as $key=>$option) { 
			$radio_setting = $options[$valueid];
			if($radio_setting != ''){
				if ($key == $options[$valueid] ) {
					$checked = "checked=\"checked\"";
					} else {
						$checked = "";
					}
			}else{
				if($key == $value['std']){
					$checked = "checked=\"checked\"";
				}else{
					$checked = "";
				}
			}?>
			<input type="radio" id="<?php echo $option_name.'['.$valueid.']'; ?>" name="<?php echo $option_name.'['.$valueid.']'; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
			<?php } ?>
	</div>

<?php
break;
case "checkbox":
?>
    <div class="options_input options_checkbox">
        <div class="options_desc"><?php echo $value['desc']; ?></div>
        <?php if( isset( $options[$valueid] ) ){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
        <input type="checkbox" name="<?php echo $option_name.'['.$valueid.']'; ?>" id="<?php echo $option_name.'['.$valueid.']'; ?>" value="true" <?php echo $checked; ?> />
        <label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label>
    </div>
<?php
break;
case "upload":
?>
    <div class="options_input options_text">
        <div class="options_desc"><?php echo $value['desc']; ?></div>
        <span class="labels"><label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
        <input class="<?php echo $option_name.'_'.$valueid; ?>" name="<?php echo $option_name.'['.$valueid.']'; ?>" id="<?php echo $option_name.'['.$valueid.']'; ?>" type="text" value="<?php if ( isset( $options[$valueid]) ){ esc_attr_e($options[$valueid]); } else { esc_attr_e($value['std']); } ?>" />
        <input id="<?php echo $option_name.'_'.$valueid; ?>_button" type="button" value="Arquivo" />
    </div> 
    <script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#<?php echo $option_name.'_'.$valueid; ?>_button').click(function() {
		 formfield = jQuery('.<?php echo $option_name.'_'.$valueid; ?>').attr('name');
		 post_id = jQuery('#post_ID').val();
		 tb_show('', 'media-upload.php?post_id='+post_id+'&amp;type=image&amp;TB_iframe=true');
		 return false;
		});

		window.send_to_editor = function(html) {
		 imgurl = jQuery('img',html).attr('src');
		 jQuery('.<?php echo $option_name.'_'.$valueid; ?>').val(imgurl);
		 tb_remove();
		}
	});
	</script>
<?php
break;
case "close":
?>
</div><!--#section_body-->
</div><!--#section_wrap-->

<?php 
break;
}
}
?>

<script type="text/javascript">

function confirmation(){

	if(confirm("<?php echo utf8_encode("Atenção"); ?>:Deseja realmente deletar todos os valores dos campos?")) {
	  	return true;
	} else {
		return false
	}
	return false;
}

</script>

<span class="submit">
<input class="button button-primary" type="submit" name="save" value="Salvar todas mudan&ccedil;as" />
</span>
</form>

<form method="post" action="">
<span class="button-right" class="submit">
<input class="button button-secondary" type="submit" name="reset" onclick="return confirmation()" value="Resetar/Deletar configura&ccedil;&otilde;es" />
<input type="hidden" name="action" value="reset" />
<span>Aten&ccedil;&atilde;o: Todas as configura&ccedil;&otilde;es ser&atilde;o exclu&iacute;das do banco de dados. Clique somente ao iniciar ou remover completamente o tema</span>
</span>
</form>
</div><!--#options-wrap-->

</div>
<?php } ?>