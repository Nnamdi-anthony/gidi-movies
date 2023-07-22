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
 * This part of the plugin depends soleoly on cmb2 to be activated
 *
 * Defines the metaboxes needed to make the movies and cinemas post type work well
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gidi_movies
 * @subpackage Gidi_movies/admin
 * @author     Peterson Umoke <umoke10@hotmail.com>
 */
class Gidi_movies_admin_metaboxes
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
        $this->prefix = str_replace("-", "_", $plugin_name) . "_";
        $this->locale = "gidi-movies";
        $this->attached_post_type = array("gidi_movies");
    }

    public function price_metabox()
    {
        $cmb = new_cmb2_box(array(
            'id' => $this->prefix . 'pricebox',
            'title' => esc_html__('Price Per Ticket', $this->locale),
            'object_types' => $this->attached_post_type, // Post type
            'priority' => 'high',
            'context' => 'side',
            'show_names' => true, // Show field names on the left
            'classes' => 'gidi-movies-pricebox', // Extra cmb2-wrap classes
            'show_in_rest' => WP_REST_Server::ALLMETHODS // allows this metabox to be visible in the rest api
        ));

        $cmb->add_field(array(
            'column' => true, // Display field value in the admin columns
            'id' => $this->prefix . 'general_movie_price_meta',
            'name' => 'General Movie Price/Ticket',
            'type' => 'text_money',
            'before_field' => "&#x20a6;", // Replaces default '$'
            "desc" => "What is the general/average price for this movie?",
        ));
    }

    public function extra_information()
    {
        $cmb = new_cmb2_box(array(
            'id' => $this->prefix . 'extra_information',
            'title' => esc_html__('Movie Information', $this->locale),
            'object_types' => $this->attached_post_type, // Post type
            'priority' => 'low',
            'context' => 'advanced',
            'show_names' => true, // Show field names on the left
            'classes' => 'gidi-movies-extra-information', // Extra cmb2-wrap classes
            'show_in_rest' => WP_REST_Server::ALLMETHODS // allows this metabox to be visible in the rest api
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'duration',
            'name' => 'Movie Duration',
            'type' => 'text',
            "desc" => "What is the duration for this movie ?",
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'tagline',
            'name' => 'Movie Tagline',
            'type' => 'text',
            "desc" => "What is the tagline for this movie ?",
        ));

        $cmb->add_field(array(
            'column' => true, // Display field value in the admin columns
            'id' => $this->prefix . 'release_date',
            'name' => 'Movie Release Date',
            'type' => 'text_date',
            "desc" => "What is the Release date for this movie ?",
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'language',
            'name' => 'Movie Language',
            'type' => 'text',
            "desc" => "What is the Language for this movie ?",
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'rating',
            'name' => 'Movie rating',
            'type' => 'text',
            "desc" => "What is the rating for this movie ?",
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'youtubeID',
            'name' => 'Movie Youtube URL',
            'type' => 'text',
            "desc" => "What is the Youtube URL for this movie ?",
        ));
    }

    public function cinema_metabox()
    {
        $this->attached_post_type = "cinema";
        $this->prefix = "cinema_listing_";

        $cmb = new_cmb2_box(array(
            'id' => $this->prefix . 'general',
            'title' => esc_html__('Cinema Information', $this->locale),
            'object_types' => $this->attached_post_type, // Post type
            'priority' => 'high',
            'context' => 'normal',
            'show_names' => true, // Show field names on the left
            'classes' => 'gidi-cinemas-information', // Extra cmb2-wrap classes
            'show_in_rest' => WP_REST_Server::ALLMETHODS // allows this metabox to be visible in the rest api
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'email',
            'name' => 'E-mail',
            'type' => 'text_email',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'web',
            'name' => 'Website',
            'type' => 'text',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'phone',
            'name' => 'Phone Number',
            'type' => 'text',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'address',
            'name' => 'Address',
            'type' => 'text',
            'column' => true,
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'state',
            'name' => 'State',
            'type' => 'text',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'city',
            'name' => 'Nearest City With State',
            'type' => 'text',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'longitude',
            'name' => 'Longitude',
            'type' => 'text',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'latitude',
            'name' => 'Latitude',
            'type' => 'text',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'social_facebook',
            'name' => 'Facebook',
            'type' => 'text',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'social_twitter',
            'name' => 'Twitter',
            'type' => 'text',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'social_linkedin',
            'name' => 'LinkedIn',
            'type' => 'text',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'social_google',
            'name' => 'Google',
            'type' => 'text',
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'ratings',
            'name' => 'Ratings',
            'type' => 'text',
        ));
    }

    public function booking_metabox()
    {
        $cmb = new_cmb2_box(array(
            'id' => $this->prefix . 'bookingbox',
            'title' => esc_html__('Movie Booking Configurations', $this->locale),
            'object_types' => $this->attached_post_type, // Post type
            'priority' => 'high',
            'context' => 'normal',
            'show_names' => true, // Show field names on the left
            'classes' => 'gidi-movies-bookingbox', // Extra cmb2-wrap classes
            'show_in_rest' => WP_REST_Server::ALLMETHODS // allows this metabox to be visible in the rest api
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'no_booking',
            'name' => 'Booking Not Allowed',
            'type' => 'checkbox',
            "desc" => "Check this If you do want this movie to be booked anymore ?",
            'column' => true,
        ));

        $bc_movie_id = $cmb->add_field(array(
            'id' => $this->prefix . 'booking_configuration',
            "description" => "<h1 style='text-align:center; font-weight: bold;'>Configure the Booking Date, Cinema and Time for this movie</h1>",
            'type' => 'group',
            'repeatable' => true,
            'options' => array(
                'group_title' => 'Booking Configuration {#}',
                'add_button' => 'Add Another Booking Configuration',
                'remove_button' => 'Remove This Booking Configuration',
                'closed' => true,  // Repeater fields closed by default - neat & compact.
                'sortable' => true,  // Allow changing the order of repeated groups.
            ),
        ));

        $cmb->add_group_field($bc_movie_id, array(
            'name' => 'Choose Cinema',
            'desc' => 'Select the cinema that this movie is currently showing in',
            'id' => $this->prefix . 'cinema_id',
            'type' => 'select',
            'show_option_none' => true,
            'default' => 'custom',
            'options' => $this->get_cinemas(),
        ));

        $cmb->add_group_field($bc_movie_id, array(
            'name' => 'Now Showing Date and Time',
            'id' => $this->prefix . 'cinema_showing_datetime',
            'type' => 'text_datetime_timestamp',
            "repeatable" => true,
            'time_format' => 'h:i:s A',
        ));

        $cmb->add_group_field($bc_movie_id, array(
            'id' => $this->prefix . 'adult_movie_price_meta',
            'name' => 'Adult Movie Price/Ticket',
            'type' => 'text_money',
            'before_field' => "&#x20a6;", // Replaces default '$'
            "desc" => "What is the price for this movie for adults?",
        ));

        $cmb->add_group_field($bc_movie_id, array(
            'id' => $this->prefix . 'children_movie_price_meta',
            'name' => 'Children Movie Price/Ticket',
            'type' => 'text_money',
            'before_field' => "&#x20a6;", // Replaces default '$'
            "desc" => "What is the price for this movie for children?",
        ));

        $cmb->add_group_field($bc_movie_id, array(
            'id' => $this->prefix . 'student_movie_price_meta',
            'name' => 'Student Movie Price/Ticket',
            'type' => 'text_money',
            'before_field' => "&#x20a6;", // Replaces default '$'
            "desc" => "What is the price for this movie for students?",
        ));

    }

    /**
     * use this to get all the cinemas in the site
     *
     * @return array
     */
    public function get_cinemas()
    {
        $args = array(
            'post_type' => 'cinema',
            "posts_per_page" => -1
        );
        $cinemas = new WP_Query($args);

        $cinema_name = array();
        while ($cinemas->have_posts()) : $cinemas->the_post();
        $cinema_name[get_the_ID()] = ucwords(get_the_title());
        endwhile;
        wp_reset_postdata();

        return $cinema_name;
    }
}