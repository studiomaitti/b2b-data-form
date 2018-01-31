<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    B2b_price_conf
 * @subpackage B2b_price_conf/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    B2b_price_conf
 * @subpackage B2b_price_conf/includes
 * @author     Giorgio Maitti <gmaitti@iltrovatore>
 */
class B2b_price_conf_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        //todo gio non funziona anche se suggerito
        flush_rewrite_rules();
	}

}
