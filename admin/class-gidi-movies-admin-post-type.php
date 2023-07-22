<?php

/**
 * Registers a Movies Post Type
 *
 * @link       https://github.com/peterson-umoke/
 * @since      1.0.0
 *
 * @package    Gidi_movies
 * @subpackage Gidi_movies/admin
 */

/**
 * Fired during plugin activation.
 *
 * This class registers a Movies Post Type
 *
 * @since      1.0.5
 * @package    Gidi_movies
 * @subpackage Gidi_movies/admin
 * @author     Peterson Nwachukwu Umoke <umoke10@hotmail.com>
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Gidi_movies_admin_post_type
{

    /**
     * The Page that holds the search and listings function
     *
     * @var string
     * @access protected
     */
    protected $single_page_name = "";

    /**
     * Post Type Supports - What does the post type support
     *
     * @var array
     */
    protected $post_type_supports = array();

    /**
     * Supported Taxonomies - State what kind of related taxonomy is tied to this post type
     *
     * @var array
     */
    protected $supported_taxonomies = array();

    /**
     * Post Type ID - The Post type id that is unique to this post type
     *
     * @var string
     */
    protected $post_type_id = "";

    /**
     * Plugin name
     */
    protected $plugin_name;
    protected $version;

    /**
     * Language ID
     */
    protected $locale;

    public function __construct($plugin_name, $locale, $page_name = "gidi_movies")
    {
        $this->single_page_name = $page_name;
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->parent_settings_name = $this->plugin_name . "-menu";

        $this->post_type_supports_now = array(
            "title",
            "thumbnail",
            "custom_fields",
            "editor",
            "comments",
            "revisions",
            "page-attributes",
        );

        // $this->supported_taxonomies = array(
        // 	"gidi_hotel_services",
        // 	"gidi_hotel_locations",
        // 	"gidi_hotel_facilities",
        // );

        $this->post_type_id = str_replace("-", "_", $plugin_name);
    }

    /**
     * This is used to register a custom post type
     *
     * @author Peterson Nwachukwu Umoke <umoke10@hotmail.com>
     * @access public
     */
    public function register_movies_type()
    {
        $this->supported_taxonomies = array(
            "gidi_movies_types",
            "gidi_movies_genres",
            "gidi_movies_years",
        );

        $this->single_page_name = "view-movie";

        $labels = array(
            'name' => _x('Movies', 'Post Type General Name', 'gidi-movies'),
            'singular_name' => _x('Movie', 'Post Type Singular Name', 'gidi-movies'),
            'menu_name' => __('Movies', 'gidi-movies'),
            'name_admin_bar' => __('Movies', 'gidi-movies'),
            'archives' => __('Movies Archives', 'gidi-movies'),
            'attributes' => __('Movies Attributes', 'gidi-movies'),
            'parent_item_colon' => __('Movies Item:', 'gidi-movies'),
            'all_items' => __('All Movies', 'gidi-movies'),
            'add_new_item' => __('Add New Movie Item', 'gidi-movies'),
            'add_new' => __('Add New Movie', 'gidi-movies'),
            'new_item' => __('New Movies', 'gidi-movies'),
            'edit_item' => __('Edit Movies', 'gidi-movies'),
            'update_item' => __('Update Movies', 'gidi-movies'),
            'view_item' => __('View Movie', 'gidi-movies'),
            'view_items' => __('View Movies', 'gidi-movies'),
            'search_items' => __('Search Movies', 'gidi-movies'),
            'not_found' => __('No Movies found', 'gidi-movies'),
            'not_found_in_trash' => __('No Movies found in Trash', 'gidi-movies'),
            'featured_image' => __('Movies Featured Image', 'gidi-movies'),
            'set_featured_image' => __('Set featured image', 'gidi-movies'),
            'remove_featured_image' => __('Remove featured image', 'gidi-movies'),
            'use_featured_image' => __('Use as Movies featured image', 'gidi-movies'),
            'insert_into_item' => __('Insert into Movies item', 'gidi-movies'),
            'uploaded_to_this_item' => __('Uploaded to this Movies item', 'gidi-movies'),
            'items_list' => __('Movies Items list', 'gidi-movies'),
            'items_list_navigation' => __('Movies Items list navigation', 'gidi-movies'),
            'filter_items_list' => __('Filter Movies items list', 'gidi-movies'),
        );
        $rewrite = array(
            "slug" => $this->single_page_name,
            'with_front' => true,
            'pages' => true,
            'feeds' => true,
        );
        $args = array(
            'label' => __('Movie', 'gidi-movies'),
            'labels' => $labels,
            'supports' => $this->post_type_supports_now,
            'taxonomies' => $this->supported_taxonomies,
            'public' => true,
            'hierarchical' => false,
            'show_ui' => true,
            'show_in_menu' => false, // show in the menu bar
            'menu_position' => 5,
            'menu_icon' => '', // icon of the menu
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'rewrite' => $rewrite,
            'capability_type' => 'post',
            'show_in_rest' => true,
            "query_var" => true,
        );
        register_post_type($this->post_type_id, $args);		//flush_rewrite_rules();
    }

    /**
     * This is used to register a custom post type
     *
     * @author Peterson Nwachukwu Umoke <umoke10@hotmail.com>
     * @access public
     */
    public function register_cinemas_type()
    {
        $this->post_type_id = "cinema";
        $this->single_page_name = "view-cinema"; // rename the rewrites
        $this->supported_taxonomies = array(
            "cinema_locations",
            "cinema_cat",
        );

        $labels = array(
            'name' => _x('Cinemas', 'Post Type General Name', 'gidi-movies'),
            'singular_name' => _x('Cinema', 'Post Type Singular Name', 'gidi-movies'),
            'menu_name' => __('Cinemas', 'gidi-movies'),
            'name_admin_bar' => __('Cinemas', 'gidi-movies'),
            'archives' => __('Cinemas Archives', 'gidi-movies'),
            'attributes' => __('Cinemas Attributes', 'gidi-movies'),
            'parent_item_colon' => __('Cinemas Item:', 'gidi-movies'),
            'all_items' => __('All Cinemas', 'gidi-movies'),
            'add_new_item' => __('Add New Cinema Item', 'gidi-movies'),
            'add_new' => __('Add New Cinema', 'gidi-movies'),
            'new_item' => __('New Cinemas', 'gidi-movies'),
            'edit_item' => __('Edit Cinemas', 'gidi-movies'),
            'update_item' => __('Update Cinemas', 'gidi-movies'),
            'view_item' => __('View Cinema', 'gidi-movies'),
            'view_items' => __('View Cinemas', 'gidi-movies'),
            'search_items' => __('Search Cinemas', 'gidi-movies'),
            'not_found' => __('No Cinemas found', 'gidi-movies'),
            'not_found_in_trash' => __('No Cinemas found in Trash', 'gidi-movies'),
            'featured_image' => __('Cinemas Featured Image', 'gidi-movies'),
            'set_featured_image' => __('Set featured image', 'gidi-movies'),
            'remove_featured_image' => __('Remove featured image', 'gidi-movies'),
            'use_featured_image' => __('Use as Cinemas featured image', 'gidi-movies'),
            'insert_into_item' => __('Insert into Cinemas item', 'gidi-movies'),
            'uploaded_to_this_item' => __('Uploaded to this Cinemas item', 'gidi-movies'),
            'items_list' => __('Cinemas Items list', 'gidi-movies'),
            'items_list_navigation' => __('Cinemas Items list navigation', 'gidi-movies'),
            'filter_items_list' => __('Filter Cinemas items list', 'gidi-movies'),
        );
        $rewrite = array(
            "slug" => $this->single_page_name,
            'with_front' => true,
            'pages' => true,
            'feeds' => true,
        );
        $args = array(
            'label' => __('Cinema', 'gidi-movies'),
            'labels' => $labels,
            'supports' => $this->post_type_supports_now,
            'taxonomies' => $this->supported_taxonomies,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => false, // show in the menu bar
            'menu_position' => 5,
            'menu_icon' => '', // icon of the menu
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'rewrite' => $rewrite,
            'capability_type' => 'page',
            'show_in_rest' => true,
            "query_var" => true,
        );
        register_post_type($this->post_type_id, $args);		//flush_rewrite_rules();
    }

    /**
     * This is used to register a custom post type
     *
     * @author Peterson Nwachukwu Umoke <umoke10@hotmail.com>
     * @access public
     */
    public function register_gidi_movies_bookings()
    {
        $this->post_type_id = "gidi_movies_bookings";
        $this->single_page_name = "gidi_movies_booking"; // rename the rewrites
        $this->supported_taxonomies = array();
        $this->post_type_supports_now = array('title');

        $labels = array(
            'name' => _x('Movies Bookings', 'Post Type General Name', 'gidi-movies'),
            'singular_name' => _x('Movies Booking', 'Post Type Singular Name', 'gidi-movies'),
            'menu_name' => __('Movies Bookings', 'gidi-movies'),
            'name_admin_bar' => __('Movies Bookings', 'gidi-movies'),
            'archives' => __('Movies Bookings Archives', 'gidi-movies'),
            'attributes' => __('Movies Bookings Attributes', 'gidi-movies'),
            'parent_item_colon' => __('Movies Bookings Item:', 'gidi-movies'),
            'all_items' => __('All Movies Bookings', 'gidi-movies'),
            'add_new_item' => __('Add A Movie Booking Item', 'gidi-movies'),
            'add_new' => __('Add New Movie Booking', 'gidi-movies'),
            'new_item' => __('New Movies Bookings', 'gidi-movies'),
            'edit_item' => __('Edit This Bookings For This Movie', 'gidi-movies'),
            'update_item' => __('Update Movies Bookings', 'gidi-movies'),
            'view_item' => __('View Movie Booking', 'gidi-movies'),
            'view_items' => __('View Movies Bookings', 'gidi-movies'),
            'search_items' => __('Search Movies Bookings', 'gidi-movies'),
            'not_found' => __('No Movies Bookings found', 'gidi-movies'),
            'not_found_in_trash' => __('No Movies Bookings found in Trash', 'gidi-movies'),
            'featured_image' => __('Movies Bookings Featured Image', 'gidi-movies'),
            'set_featured_image' => __('Set featured image', 'gidi-movies'),
            'remove_featured_image' => __('Remove featured image', 'gidi-movies'),
            'use_featured_image' => __('Use as Movies Bookings featured image', 'gidi-movies'),
            'insert_into_item' => __('Insert into Movies Bookings item', 'gidi-movies'),
            'uploaded_to_this_item' => __('Uploaded to this Movies Bookings item', 'gidi-movies'),
            'items_list' => __('Movies Bookings Items list', 'gidi-movies'),
            'items_list_navigation' => __('Movies Bookings Items list navigation', 'gidi-movies'),
            'filter_items_list' => __('Filter Movies Bookings items list', 'gidi-movies'),
        );
        $rewrite = array(
            "slug" => $this->single_page_name,
            'with_front' => true,
            'pages' => true,
            'feeds' => true,
        );
        $args = array(
            'label' => __('Movies Bookings', 'gidi-movies'),
            'labels' => $labels,
            'supports' => $this->post_type_supports_now,
            'taxonomies' => $this->supported_taxonomies,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false, // show in the menu bar
            'menu_position' => 5,
            'map_meta_cap' => true,
            'menu_icon' => '', // icon of the menu
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'rewrite' => $rewrite,
            'capability_type' => 'page',
            'hierarchical' => false,
            'show_in_rest' => true,
            "query_var" => false,
        );
        register_post_type($this->post_type_id, $args);		//flush_rewrite_rules();
    }

    /**
     * Set active menu for post type color
     *
     * @hook parent_file
     * @access public
     * @return string
     */
    public function menu()
    {
        global $parent_file, $submenu_file, $post_type;

        switch ($post_type) {
            case 'gidi_movies':
            case 'gidi_movies_bookings':
            case 'cinema':
                $parent_file = $this->parent_settings_name; // WPCS: override ok.
                break;
        }
    }

    public function add_display_post_states($post_states, $post)
    {
        $page_slugs = [
            [
                "slug" => 'show-movies',
                "title" => 'Movies Landing Page'
            ], [
                "slug" => 'search-movies',
                "title" => 'Movies Search and Listing Page'
            ], [
                "slug" => 'book-a-movie',
                "title" => 'Movies Booking Page'
            ], [
                "slug" => 'invoice-this-movie',
                "title" => 'Movies Invoice Page'
            ]
        ];

        for ($i = 0; $i < count($page_slugs); $i++) :

            $page = get_page_by_path($page_slugs[$i]['slug']);
        $page_id = $page->ID;

        if ($page_id === $post->ID) {
            $post_states[$page_slugs[$i]['slug']] = __($page_slugs[$i]['title'], 'woocommerce');
        }


        endfor; return $post_states;
    }
}