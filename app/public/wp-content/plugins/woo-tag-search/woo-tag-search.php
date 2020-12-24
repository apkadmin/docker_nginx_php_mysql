<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/apkadmin
 * @since             1.0.0
 * @package           Woo_Tag_Search
 *
 * @wordpress-plugin
 * Plugin Name:       woo-tag-search
 * Plugin URI:        https://github.com/apkadmin
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Nguyễn Văn AN
 * Author URI:        https://github.com/apkadmin
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-tag-search
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOO_TAG_SEARCH_VERSION', '1.0.0' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-tag-search-activator.php
 */
function activate_woo_tag_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-tag-search-activator.php';
	Woo_Tag_Search_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-tag-search-deactivator.php
 */
function deactivate_woo_tag_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-tag-search-deactivator.php';
	Woo_Tag_Search_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_tag_search' );
register_deactivation_hook( __FILE__, 'deactivate_woo_tag_search' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-tag-search.php';

function wc_add_classes_img () {
    if ( is_shop() ) {

        ?>
          <div class="woof_products_tag_top_panel">
			<div class="target-tag-custom" id="container">
			<ul>
				<li class="active">CodeHim</li>
				<li>HTML</li>
				<li>CSS</li>
				<li>JavaScript</li>
				<li>jQuery</li>
				<li>Bootstrap</li>
			</ul>
			</div>
		</div>
        <?php
    }
}
add_action( 'woocommerce_before_shop_loop', 'wc_add_classes_img');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_tag_search() {

	$plugin = new Woo_Tag_Search();
	$plugin->run();

}
run_woo_tag_search();
