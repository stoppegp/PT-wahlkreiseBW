<?php


class PT_wahlkreiseltw {

	public static $wkf_id = 0;
	public static $incJS = false;
	
	static public function shortcode() {
		ob_start();

		PT_wahlkreiseltw::$wkf_id++;
		
		include("form.php");
		
		$content = ob_get_contents();
		ob_end_clean();
		PT_wahlkreiseltw::$incJS = true;
		return $content;
			
	}
	
	static public function incJS() {
		if (PT_wahlkreiseltw::$incJS) {	
			include("js.php");
		}
	}

	static public function adminmenu() {
		include(plugin_dir_path(__FILE__).'admin.php');
	}

	
}

add_shortcode( "pt-wahlkreiseltw", array("PT_wahlkreiseltw", "shortcode"));
add_action( 'wp_footer', array("PT_wahlkreiseltw", "incJS") );
?>
