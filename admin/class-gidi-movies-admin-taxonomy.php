<?php

/**
 * Fired during plugin activation
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
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Gidi_movies
 * @subpackage Gidi_movies/admin
 * @author     Peterson Nwachukwu Umoke <umoke10@hotmail.com>
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * @property string parent_settings_name
 * @property mixed type_id
 */
class Gidi_movies_admin_taxonomy
{

    /**
     * Plugin name
     */
    protected $plugin_name;

    /**
     * Language ID
     */
    protected $locale;

    protected $parent_settings_name;
    protected $language;

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     * @param $plugin_name
     * @param $locale
     */
    public function __construct($plugin_name, $locale)
    {
        $this->language = $locale;
        $this->plugin_name = $plugin_name;
        $this->type_id = str_replace("-", "_", $plugin_name);
        $this->parent_settings_name = $this->plugin_name . "-menu";
    }

    /**
     * @todo Enables this when it is due, for now it is not due
     */
    public function movie_types()
    {
        $common_name = "types";

        $labels = array(
            'name' => _x('Movie Types', 'Taxonomy General Name', $this->language),
            'singular_name' => _x('Movie Types', 'Taxonomy Singular Name', $this->language),
            'menu_name' => __('Movie Types', $this->language),
            'all_items' => __('All Movie Types', $this->language),
            'parent_item' => __('Parent Item', $this->language),
            'parent_item_colon' => __('Parent Item:', $this->language),
            'new_item_name' => __('New Movie Type', $this->language),
            'add_new_item' => __('Add New Movie Type', $this->language),
            'edit_item' => __('Edit Movie Type', $this->language),
            'update_item' => __('Update Movie Type', $this->language),
            'view_item' => __('View Movie Type', $this->language),
            'separate_items_with_commas' => __('Separate Movie Types with commas', $this->language),
            'add_or_remove_items' => __('Add or remove Movie Types', $this->language),
            'choose_from_most_used' => __('Choose from the most used', $this->language),
            'popular_items' => __('Popular Movie Types', $this->language),
            'search_items' => __('Search Movie Types', $this->language),
            'not_found' => __('Movie Types Not Found', $this->language),
            'no_terms' => __('No Movie Types', $this->language),
            'items_list' => __('Movie Types list', $this->language),
            'items_list_navigation' => __('Movie Types list navigation', $this->language),
        );
        $rewrite = array(
            'slug' => substr($this->plugin_name, 5) . "-" . $common_name,
            'with_front' => true,
            'hierarchical' => true,
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => false,
            'rewrite' => $rewrite,
            'show_in_rest' => true,
            "query_var"
        );
        register_taxonomy($this->type_id . "_" . $common_name, array($this->type_id), $args);
    }

    /**
     * @todo Enables this when it is due, for now it is not due
     */
    public function movie_genre()
    {
        $common_name = "genres";

        $labels = array(
            'name' => _x('Movie Genres', 'Taxonomy General Name', $this->language),
            'singular_name' => _x('Movie Genres', 'Taxonomy Singular Name', $this->language),
            'menu_name' => __('Movie Genres', $this->language),
            'all_items' => __('All Movie Genres', $this->language),
            'parent_item' => __('Parent Item', $this->language),
            'parent_item_colon' => __('Parent Item:', $this->language),
            'new_item_name' => __('New Movie Genre', $this->language),
            'add_new_item' => __('Add New Movie Genre', $this->language),
            'edit_item' => __('Edit Movie Genre', $this->language),
            'update_item' => __('Update Movie Genre', $this->language),
            'view_item' => __('View Movie Genre', $this->language),
            'separate_items_with_commas' => __('Separate Movie Genres with commas', $this->language),
            'add_or_remove_items' => __('Add or remove Movie Genres', $this->language),
            'choose_from_most_used' => __('Choose from the most used', $this->language),
            'popular_items' => __('Popular Movie Genres', $this->language),
            'search_items' => __('Search Movie Genres', $this->language),
            'not_found' => __('Movie Genres Not Found', $this->language),
            'no_terms' => __('No Movie Genres', $this->language),
            'items_list' => __('Movie Genres list', $this->language),
            'items_list_navigation' => __('Movie Genres list navigation', $this->language),
        );
        $rewrite = array(
            'slug' => substr($this->plugin_name, 5) . "-" . $common_name,
            'with_front' => true,
            'hierarchical' => true,
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'rewrite' => $rewrite,
            'show_in_rest' => true,
            "query_var"
        );
        register_taxonomy($this->type_id . "_" . $common_name, array($this->type_id), $args);
    }

    /**
     * @todo Enables this when it is due, for now it is not due
     */
    public function cinema_locations()
    {
        $common_name = "cinema_locations";

        $labels = array(
            'name' => _x('Cinema Locations', 'Taxonomy General Name', $this->language),
            'singular_name' => _x('Cinema Locations', 'Taxonomy Singular Name', $this->language),
            'menu_name' => __('Cinema Locations', $this->language),
            'all_items' => __('All Cinema Locations', $this->language),
            'parent_item' => __('Parent Item', $this->language),
            'parent_item_colon' => __('Parent Item:', $this->language),
            'new_item_name' => __('New Cinema Location', $this->language),
            'add_new_item' => __('Add New Cinema Location', $this->language),
            'edit_item' => __('Edit Cinema Location', $this->language),
            'update_item' => __('Update Cinema Location', $this->language),
            'view_item' => __('View Cinema Location', $this->language),
            'separate_items_with_commas' => __('Separate Cinema Locations with commas', $this->language),
            'add_or_remove_items' => __('Add or remove Cinema Locations', $this->language),
            'choose_from_most_used' => __('Choose from the most used', $this->language),
            'popular_items' => __('Popular Cinema Locations', $this->language),
            'search_items' => __('Search Cinema Locations', $this->language),
            'not_found' => __('Cinema Locations Not Found', $this->language),
            'no_terms' => __('No Cinema Locations', $this->language),
            'items_list' => __('Cinema Locations list', $this->language),
            'items_list_navigation' => __('Cinema Locations list navigation', $this->language),
        );
        $rewrite = array(
            'slug' => $common_name,
            'with_front' => true,
            'hierarchical' => true,
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'rewrite' => $rewrite,
            'show_in_rest' => true,
            "query_var"
        );
        register_taxonomy(str_replace("-", "_", $common_name), array("cinema"), $args);
    }

    /**
     * @todo Enables this when it is due, for now it is not due
     */
    public function cinema_categories()
    {
        $common_name = "cinema-cat";

        $labels = array(
            'name' => _x('Cinema Categories', 'Taxonomy General Name', $this->language),
            'singular_name' => _x('Cinema Categories', 'Taxonomy Singular Name', $this->language),
            'menu_name' => __('Cinema Categories', $this->language),
            'all_items' => __('All Cinema Categories', $this->language),
            'parent_item' => __('Parent Item', $this->language),
            'parent_item_colon' => __('Parent Item:', $this->language),
            'new_item_name' => __('New Cinema Categorie', $this->language),
            'add_new_item' => __('Add New Cinema Categorie', $this->language),
            'edit_item' => __('Edit Cinema Categorie', $this->language),
            'update_item' => __('Update Cinema Categorie', $this->language),
            'view_item' => __('View Cinema Categorie', $this->language),
            'separate_items_with_commas' => __('Separate Cinema Categories with commas', $this->language),
            'add_or_remove_items' => __('Add or remove Cinema Categories', $this->language),
            'choose_from_most_used' => __('Choose from the most used', $this->language),
            'popular_items' => __('Popular Cinema Categories', $this->language),
            'search_items' => __('Search Cinema Categories', $this->language),
            'not_found' => __('Cinema Categories Not Found', $this->language),
            'no_terms' => __('No Cinema Categories', $this->language),
            'items_list' => __('Cinema Categories list', $this->language),
            'items_list_navigation' => __('Cinema Categories list navigation', $this->language),
        );
        $rewrite = array(
            'slug' => $common_name,
            'with_front' => true,
            'hierarchical' => true,
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'rewrite' => $rewrite,
            'show_in_rest' => true,
            "query_var"
        );
        register_taxonomy(str_replace("-", "_", $common_name), array("cinema"), $args);
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
        global $parent_file, $submenu_file, $taxonomy;

        switch ($taxonomy) {
            case 'cinema_cat':
            case 'cinema_locations':
            case 'gidi_movies_types':
            case 'gidi_movies_genres':
                $parent_file = $this->parent_settings_name; // WPCS: override ok.
                break;
        }
    }
}