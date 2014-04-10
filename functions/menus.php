<?php 
// Habilitando o uso do gerenciador de menus
if (function_exists('add_theme_support')) add_theme_support('menus');

//Registrando Menus
register_nav_menu( "principal", "Menu Principal" );
// register_nav_menu( "principal_ingles", "Menu Principal Inglês" ); 