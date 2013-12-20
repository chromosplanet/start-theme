<?php 
	
// Dando permissão para usuarios do tipo Editor gerenciarem os Widgets
if(is_admin()){
	$role =& get_role('editor');
	$role->add_cap('edit_theme_options');
	$role->add_cap('manage_options');
	$role->add_cap('manage_polls');
	$role->remove_cap('switch_themes');
}

// Removendo alguns itens do menu para usuarios do tipo Editor
if( !current_user_can('switch_themes') ) {
		function remove_menus () {
		global $menu;
		$restricted = array(__('Tools'), __('Settings'), __('Plugins'));
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
	}
	add_action('admin_menu', 'remove_menus');
}

?>