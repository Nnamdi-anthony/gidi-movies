<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/peterson-umoke
 * @since      1.0.0
 *
 * @package    Gidi_movies
 * @subpackage Gidi_movies/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Gidi_movies
 * @subpackage Gidi_movies/includes
 * @author     Peterson Umoke <umoke10@hotmail.com>
 */
class Gidi_movies
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Gidi_movies_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('GIDI_MOVIES_VERSION')) {
            $this->version = GIDI_MOVIES_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'gidi-movies';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_included_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Gidi_movies_Loader. Orchestrates the hooks of the plugin.
     * - Gidi_movies_i18n. Defines internationalization functionality.
     * - Gidi_movies_Admin. Defines all hooks for the admin area.
     * - Gidi_movies_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        $this->loader = new Gidi_movies_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Gidi_movies_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Gidi_movies_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Gidi_movies_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        // custom settings menu
        $gidiMoviesSettings = new Gidi_movies_admin_settings($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action("admin_init", $gidiMoviesSettings, "init_settings");

        // customer admin menu
        $gidiMoviesMenu = new Gidi_movies_admin_menu($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action("admin_menu", $gidiMoviesMenu, "add_options_page");

        /**
         * ===========================================
         * Post type Registration and other things
         * 
         * ===========================================
         */
        $postType = new Gidi_movies_admin_post_type($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action("init", $postType, "register_movies_type");
        $this->loader->add_action("init", $postType, "register_cinemas_type");
        $this->loader->add_action("init", $postType, "register_gidi_movies_bookings");
        $this->loader->add_action('admin_head', $postType, 'menu');
        $this->loader->add_filter('display_post_states', $postType, 'add_display_post_states', 10, 2);

        /**
         * ===========================================
         * Taxonomy Registration
         * ===========================================
         */
        $taxonomyType = new Gidi_movies_admin_taxonomy($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action("init", $taxonomyType, "movie_types");
        $this->loader->add_action("init", $taxonomyType, "movie_genre");
        $this->loader->add_action("init", $taxonomyType, "cinema_locations");
        $this->loader->add_action("init", $taxonomyType, "cinema_categories");
        $this->loader->add_action('admin_head', $taxonomyType, 'menu');

        /**
         * ===========================================
         * Movie Meta Boxes
         * ===========================================
         */
        $movieMetaBox = new Gidi_movies_admin_metaboxes($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('cmb2_init', $movieMetaBox, 'booking_metabox');
        $this->loader->add_action('cmb2_init', $movieMetaBox, 'price_metabox');
        $this->loader->add_action('cmb2_init', $movieMetaBox, 'extra_information');
        $this->loader->add_action('cmb2_init', $movieMetaBox, 'cinema_metabox');

        /**
         * ===========================================
         * Booking Engine
         * ===========================================
         */
        // Admin notices.
        // $bookingEngine = new Gidi_movies_admin_booking_engine($this->get_plugin_name(), $this->get_version());
        // $this->loader->add_filter('post_updated_messages', $bookingEngine, 'post_updated_messages');
        // $this->loader->add_filter('bulk_post_updated_messages', $bookingEngine, 'bulk_post_updated_messages', 10, 2);
        // $this->loader->add_filter('enter_title_here', $bookingEngine, 'enter_title_here', 1, 2);
        // $this->loader->add_action('cmb2_init', $bookingEngine, 'metaboxes');
        // $this->loader->add_action('cmb2_init', $bookingEngine, 'metabox_2');
        // $this->loader->add_action('post_submitbox_start', $bookingEngine, 'edit_form_after_title');
        // $this->loader->add_filter('manage_edit-gidi_movies_bookings_columns', $bookingEngine, 'my_cpt_columns');
        // $this->loader->add_filter('post_row_actions', $bookingEngine, 'remove_row_actions', 10, 1);
    }

    private function define_included_hooks()
    {
        
        // init the page templates
        // if (get_option('gm_api_options')['gidi_movies_show_page_templates']) {
        $pg_template_loader = new Gidi_movies_page_templates_loader();
        $this->loader->add_action('plugins_loaded', $pg_template_loader, 'get_instance');
        // }

        // post type loader
        $post_type_loader = new Gidi_movies_post_type_loader();
        $this->loader->add_filter('template_include', $post_type_loader, 'templates');

        /**
         * ===========================================
         * Ajax Actions
         * ===========================================
         */
        $ajax_actions = new Gidi_movies_ajax_actions($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('wp_ajax_create_movies', $ajax_actions, 'create_movies');
        $this->loader->add_action('wp_ajax_create_movies_genres', $ajax_actions, 'create_movies_genres');
        $this->loader->add_action('wp_ajax_create_movies_types', $ajax_actions, 'create_movies_types');
        $this->loader->add_action('wp_ajax_create_cinema_locations', $ajax_actions, 'create_cinema_locations');
        $this->loader->add_action('wp_ajax_import_movies', $ajax_actions, 'import_export_product_type_to_post_type');

        // only the movie types and namexs
        $this->loader->add_action('wp_ajax_get_movie_types', $ajax_actions, 'getMovieTypes');
        $this->loader->add_action('wp_ajax_nopriv_get_movie_types', $ajax_actions, 'getMovieTypes');
        $this->loader->add_action('wp_ajax_get_movie_genres', $ajax_actions, 'getMovieGenres');
        $this->loader->add_action('wp_ajax_nopriv_get_movie_genres', $ajax_actions, 'getMovieGenres');
        $this->loader->add_action('wp_ajax_get_movie_names', $ajax_actions, 'getMovieNames');
        $this->loader->add_action('wp_ajax_nopriv_get_movie_names', $ajax_actions, 'getMovieNames');
        $this->loader->add_action('wp_ajax_get_showing_times', $ajax_actions, 'get_now_showing_times');
        $this->loader->add_action('wp_ajax_nopriv_get_showing_times', $ajax_actions, 'get_now_showing_times');


        /**
         * shortcodes for the site
         *
         * @return void
         */
        $shortcodes = new Gidi_Movies_Shortcodes();
        $this->loader->add_shortcode('show_movie_listings', $shortcodes, 'show_movie_listing');
        $this->loader->add_shortcode('slider-search-filter-movie', $shortcodes, 'search_bar');
        $this->loader->add_shortcode('show_all_movies', $shortcodes, 'show_all_movies');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Gidi_movies_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Gidi_movies_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}