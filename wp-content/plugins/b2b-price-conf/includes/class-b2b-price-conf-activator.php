<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    B2b_price_conf
 * @subpackage B2b_price_conf/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    B2b_price_conf
 * @subpackage B2b_price_conf/includes
 * @author     Giorgio Maitti <gmaitti@iltrovatore>
 */
class B2b_price_conf_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        if ( defined( 'B2B_PRICE_CONF_VERSION' ) ) {
            $version = B2B_PRICE_CONF_VERSION;
        } else {
            $version = '1.0.0';
        }
        $plugin_name = 'b2b-price-conf';  //Non strettamente necessaria

        $plugin_admin = new B2b_price_conf_Admin( $plugin_name, $version );
        $plugin_admin->setup_post_types();

        // ATTENTION: This is *only* done during plugin activation hook in this example!
        // You should *NEVER EVER* do this on every page load!!
        flush_rewrite_rules();
	}

}
