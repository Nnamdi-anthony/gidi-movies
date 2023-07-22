<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/Nnamdi-anthony/
 * @since             1.0.0
 * @package           Gidi_movies
 *
 * @wordpress-plugin
 * Plugin Name:       Gidi Movies
 * Plugin URI:        https://github.com/Nnamdi-anthony/
 * Description:       This is the movies functionality plugin... this adds movies functionality to the gidievents website
 * Version:           5.2.1
 * Author:            Emeodi Anthony
 * Author URI:        https://github.com/Nnamdi-anthony/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gidi-movies
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Define the root of the project
 */
if (!defined("GIDI_MOVIES_ROOT")) {
    define("GIDI_MOVIES_ROOT", plugin_dir_path(__FILE__));
}
/**
 * Define the url of the project
 */
if (!defined("GIDI_MOVIES_URL")) {
    define("GIDI_MOVIES_URL", plugin_dir_url(__FILE__));
}
/**
 * Define the directory separator of the project
 */
if (!defined("GIDI_MOVIES_DS")) {
    define("GIDI_MOVIES_DS", DIRECTORY_SEPARATOR);
}

/**
 * require the autoloader
 */
if (file_exists(GIDI_MOVIES_ROOT . "vendor/autoload.php")) {
    require_once GIDI_MOVIES_ROOT . "vendor/autoload.php";
} else {
    throw new Exception("The Autoloader file doesn't exist", 1);
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('GIDI_MOVIES_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gidi-movies-activator.php
 */
function activate_Gidi_movies()
{
    Gidi_movies_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gidi-movies-deactivator.php
 */
function deactivate_Gidi_movies()
{
    Gidi_movies_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_Gidi_movies');
register_deactivation_hook(__FILE__, 'deactivate_Gidi_movies');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Gidi_movies()
{
    $plugin = new Gidi_movies();
    $plugin->run();
}
run_Gidi_movies();



/**
 * ===========================================
 * Checks to see if cmb2 is active or not
 * ===========================================
 */
if (!defined('CMB2_LOADED')) {
    // code that requires CMB2
    function cmb2_installation_notice()
    {
        ?>
        <div class="notice notice-error">
            <p>
                <?php _e('Please Activate CMB2 to fully Use this plugin!', 'gidi-movies'); ?>
            </p>
        </div>
    <?php
    }
    add_action('admin_notices', 'cmb2_installation_notice');
}
