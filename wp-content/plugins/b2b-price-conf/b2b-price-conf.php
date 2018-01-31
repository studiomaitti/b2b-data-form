<?php
/**
 * b2b-price-conf
 *
 * @since             1.0.0
 * @package           B2b_price_conf
 *
 * @wordpress-plugin
 * Plugin Name:       Corriere Eventi Integration
 * Plugin URI:
 * Description:
 * Version:           1.0.0
 * Author:            Studio Maitti
 * Author URI:
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       b2b-price-conf
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
define('B2B_PRICE_CONF_VERSION', '1.0.0');

//B2b_price_conf
//b2b_price_conf
//b2b-price-conf
//https://github.com/DevinVinson/WordPress-Plugin-Boilerplate

function activate_b2b_price_conf()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-b2b-price-conf-activator.php';
    B2b_price_conf_Activator::activate();
}

function deactivate_b2b_price_conf()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-b2b-price-conf-deactivator.php';
    B2b_price_conf_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_b2b_price_conf');
register_deactivation_hook(__FILE__, 'deactivate_b2b_price_conf');
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-b2b-price-conf.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_b2b_price_conf()
{
    $plugin = new B2b_price_conf();
    $plugin->run();
}

run_b2b_price_conf();

