<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/Nnamdi-anthony/
 * @since      1.0.0
 *
 * @package    Gidi_movies
 * @subpackage Gidi_movies/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gidi_movies
 * @subpackage Gidi_movies/public
 * @author     Emeodi Nnamdi <emeodi_nnamdi@yahoo.com>
 */
class Gidi_movies_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        if (is_singular('gidi_movies') || is_singular('cinema')) :
            wp_enqueue_style($this->plugin_name . "-modal", plugin_dir_url(__FILE__) . '/assets/appleple-modal-video-ad15fb8/css/modal-video.min.css', array(), $this->version, 'all');
        endif;
        wp_enqueue_style($this->plugin_name . "-fontawesome", 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . "-owl-carousel", 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array('owl-carousel', 'owl-carousel-default'), $this->version, 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/build/css/gidi-movies-public.css', array(), $this->version, 'all');
    }

    
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts(){

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

        // Localize the script with new data
        wp_enqueue_script($this->plugin_name . "-owl-carousel", 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery', 'owl-carousel'), $this->version, false);
        if (is_singular('gidi_movies') || is_singular('cinema')) :
            wp_enqueue_script($this->plugin_name . "-modal", plugin_dir_url(__FILE__) . 'assets/appleple-modal-video-ad15fb8/js/jquery-modal-video.min.js', array('jquery'), $this->version, false);
        endif; 
        wp_register_script($this->plugin_name, plugin_dir_url(__FILE__) . 'assets/build/js/gidi-movies-public.js', array('jquery'), $this->version, true);
        $translation_array = array(
        'site_url' => site_url(),
        'gm_nounce' => wp_create_nonce('wp_gm_ajax'),
        'admin_ajax_url' => esc_url_raw(admin_url('admin-ajax.php'))
        );   
        wp_localize_script($this->plugin_name, 'gidi_movies', $translation_array);
        wp_enqueue_script($this->plugin_name);
    }
}