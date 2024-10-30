<?php
/*
    Plugin Name: InstantTranslate Widget
    Plugin URI: http://michaelcamden.me
    Description: Plugin for displaying text in different languages, using Google Translate.
    Author: Michael Camden
    Version: 1.2
    Author URI: http://michaelcamden.me
*/

if(!class_exists("InstantTranslate")) {
    class InstantTranslate {
	/**
	 * Default data array
	 * @var array
	 */
	public static $data = array(
	    "title" => "Translate To",
	    "translatableClass" => ".entry-title,.entry-content",
	    "languageCookie" => true,
	    "animation" => "none"
	);
	/**
	 * Admin controller, displays and handles form
	 */
	public function control() {
	    // Get values from db
	    $data = get_option('InstantTranslate');

	    $checked = "";

	    if($data === false) {
		$data = InstantTranslate::$data;
	    }

	    if($data['languageCookie'] === true) {
		$checked = "checked='checked'";
	    }

	    $animations = array(
		"none" => "No Animation",
		"fade" => "Fade"
	    );

	    // Add animation opt if it doesn't exist
	    // ver 1.2 upgrade path from 1.1
	    if(!isset($data['animation'])) {
		$data['animation'] = "none";
		add_option("InstantTranslate", array("animation" => "none"));
	    }

	    // Build control form
	    echo "<form method='post'>";
	    echo "<label for='widget-InstantTranslate-title'>Title</label>";
	    echo "<input class='widefat' style='margin-bottom: 10px' type='text' name='widget-InstantTranslate-title' id='widget-InstantTranslate-title' value='{$data['title']}' />";
	    echo "<label for='translatableClass'>Translatable Classes: </label>";
	    echo "<input class='widefat' style='margin-bottom: 10px' type='text' name='widget-InstantTranslate-translatableClass' value='{$data['translatableClass']}' id='translatableClass'/><br />";
	    echo "<label for='widget-InstantTranslate-animation'>Animation</label>";
	    echo "<select class='widefat' name='widget-InstantTranslate-animation' id='widget-InstantTranslate-animation' style='margin-bottom: 10px'>";

	    foreach($animations as $opt => $display) {
		$selected = "";
		if($opt == $data['animation']) {
		    $selected = "selected='selected'";
		}
		echo "<option value='$opt' $selected>$display</option>";
	    }

	    echo "</select>";
	    echo "<label for='languageCookie' >Language Cookie: </label>";
	    echo "<input type='checkbox' id='languageCookie' name='widget-InstantTranslate-languageCookie' $checked/>";
	    echo "</form>";

	    // Update options on post
	    if(!empty($_POST)) {
		$data = InstantTranslate::$data;
		if(!isset($_POST["widget-InstantTranslate-languageCookie"])) {
		    $data['languageCookie'] = false;
		}
		else {
		    $data['languageCookie'] = true;
		}

		if(isset($_POST['widget-InstantTranslate-translatableClass'])) {
		    $data['translatableClass'] = $_POST['widget-InstantTranslate-translatableClass'];
		}

		if(isset($_POST['widget-InstantTranslate-title'])) {
		    $data['title'] = $_POST['widget-InstantTranslate-title'];
		}

		if(isset($_POST['widget-InstantTranslate-animation'])) {
		    $data['animation'] = $_POST['widget-InstantTranslate-animation'];
		}

		update_option("InstantTranslate", $data);
	    }
	}
	/**
	 * Displays the Widget
	 *
	 * @param array $args
	 */
	public function widget(array $args = null) {
	    $data = get_option("InstantTranslate");

	    echo $args['before_widget'];
	    echo $args['before_title'] . $data['title'] . $args['after_title'];

	    echo "<script type='text/javascript'>var translateData = ".json_encode($data).";</script>";

	    // Languages are filled from Google Translate API
	    echo "<select id='language'>";
	    echo "</select>";

	    echo $args['after_widget'];
	}
	/**
	 * Called when the widget is registered
	 */
	public function register() {
	    $path = WP_PLUGIN_URL . "/" . dirname(plugin_basename(__FILE__)) . "/";

	    register_sidebar_widget('InstantTranslate', array('InstantTranslate', 'widget'));
	    register_widget_control('InstantTranslate', array('InstantTranslate', 'control'));

	    wp_enqueue_script('google', 'http://www.google.com/jsapi');
            wp_deregister_script('jquery');
            wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js');
            wp_enqueue_script('jquery');

	    wp_enqueue_script('translate', $path . "/js/translate.js");
	}
	/**
	 * Activation hook. At plugin activation, setup default values for the plugin
	 */
	public static function activate() {
	    if(!get_option('InstantTranslate')) {
		add_option("InstantTranslate", InstantTranslate::$data);
	    }
	    else {
		update_option("InstantTranslate", InstantTranslate::$data);
	    }
	}
	/**
	 * Deactivation hook. At plugin deactivation, drop default values for plugin
	 */
	public static function deactivate() {
	    delete_option("InstantTranslate");
	}
    }
}

add_action("widgets_init", array("InstantTranslate", "register"));
register_activation_hook( __FILE__, "InstantTranslate::activate");
register_deactivation_hook( __FILE__, "InstantTranslate::deactivate");

// Check for data req
if(!empty($_GET) && isset($_GET['translationData'])) {
    $opts = get_option("InstantTranslate");
    echo json_encode($opts);
}

?>
