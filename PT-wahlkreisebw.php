<?php
/*
Plugin Name: Piraten-Tools / WahlkreiseBW
Plugin URI: https://github.com/PiratenGP/PT-wahlkreisebw
Description: -
Version: 0.0.1
Author: @stoppegp
Author URI: http://stoppe-gp.de
License: CC-BY-SA 3.0
*/

global $PT_infos;
$PT_infos[] = array(
	'name'		=>		'WahlkreiseBW',
	'desc'		=>		'Infos tbd',
);

require('mainmenu.php');

if (!function_exists("piratentools_main_menu")) {
	add_action( 'admin_menu', 'piratentools_main_menu');
	function piratentools_main_menu() {
		add_menu_page( "Piraten-Tools", "Piraten-Tools", 0, "piratentools" , "PT_main_menu");
	}
}



require('wahlkreisebw/wahlkreisebw.php');
?>
