<?php


class PT_wahlkreisebw {

	public static $wkf_id = 0;
	public static $incJS = false;
	
	static public function shortcodeLTW() {
		ob_start();

		PT_wahlkreisebw::$wkf_id++;
		
		include("formLTW.php");
		
		$content = ob_get_contents();
		ob_end_clean();
		PT_wahlkreisebw::$incJS = true;
		return $content;
			
	}

	static public function shortcodeBTW() {
		ob_start();

		PT_wahlkreisebw::$wkf_id++;
		
		include("formBTW.php");
		
		$content = ob_get_contents();
		ob_end_clean();
		PT_wahlkreisebw::$incJS = true;
		return $content;
			
	}
	
	static public function incJS() {
		if (PT_wahlkreisebw::$incJS) {	
			include("js.php");
		}
	}

	static public function adminmenu() {
		include(plugin_dir_path(__FILE__).'admin.php');
	}

	
}

add_shortcode( "pt-wahlkreisebw-ltw", array("PT_wahlkreisebw", "shortcodeLTW"));
add_shortcode( "pt-wahlkreisebw-btw", array("PT_wahlkreisebw", "shortcodeBTW"));
add_action( 'wp_footer', array("PT_wahlkreisebw", "incJS") );
?>
