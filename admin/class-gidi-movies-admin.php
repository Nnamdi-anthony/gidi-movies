<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/peterson-umoke
 * @since      1.0.0
 *
 * @package    Gidi_movies
 * @subpackage Gidi_movies/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gidi_movies
 * @subpackage Gidi_movies/admin
 * @author     Peterson Umoke <umoke10@hotmail.com>
 */
class Gidi_movies_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Gidi_movies_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Gidi_movies_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name . "font-awesome", "https://use.fontawesome.com/releases/v5.1.0/css/all.css", array(), "5.1.0", "all");
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/build/css/gidi-movies-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Gidi_movies_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Gidi_movies_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_register_script($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/build/js/gidi-movies-admin.js', array('jquery'), $this->version, true);
 
        // Localize the script with new data
        $translation_array = array(
            "api_key" => get_option('gm_api_options')['gidi_movies_api_key'],
            'root' => esc_url_raw(rest_url()),
            'gm_nounce' => wp_create_nonce('wp_gm_ajax'),
            'nonce' => wp_create_nonce('wp_rest'),
            'gidi_movies_url' => GIDI_MOVIES_ROOT,
            'admin_ajax_url' => esc_url_raw(admin_url('admin-ajax.php'))
        );
        wp_localize_script($this->plugin_name, 'gidi_movies', $translation_array);
 
        // Enqueued script with localized data.
        wp_enqueue_script($this->plugin_name);
    }
}
