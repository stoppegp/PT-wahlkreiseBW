<?php


class PT_wahlkreiseltw {


	
	static public function shortcode() {
		

		ob_start();
		include("form.php");
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
			
	}
	


	static public function adminmenu() {
		include(plugin_dir_path(__FILE__).'admin.php');
	}

	
}

add_shortcode( "pt-wahlkreiseltw", array("PT_wahlkreiseltw", "shortcode"));
?>
