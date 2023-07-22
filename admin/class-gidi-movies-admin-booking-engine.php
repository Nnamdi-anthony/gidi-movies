<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/peterson-umoke
 * @since      1.0.0
 *
 * @package    Gidi_movies_Wp
 * @subpackage Gidi_movies_Wp/admin
 */

class Gidi_movies_admin_booking_engine
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
     * Change messages when a post type is updated.
     *
     * @param  array $messages Array of messages.
     * @return array
     */
    public function post_updated_messages($messages)
    {
        global $post;

        $messages['gidi_movies_bookings'] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => __('Movie Bookings updated.', 'gidi-movies'),
            2 => __('Custom field updated.', 'gidi-movies'),
            3 => __('Custom field deleted.', 'gidi-movies'),
            4 => __('Movie Bookings updated.', 'gidi-movies'),
            5 => __('Revision restored.', 'gidi-movies'),
            6 => __('Movie Bookings updated.', 'gidi-movies'),
            7 => __('Movie Bookings saved.', 'gidi-movies'),
            8 => __('Movie Bookings submitted.', 'gidi-movies'),
            9 => sprintf(
				/* translators: %s: date */
                __('Movie Bookings scheduled for: %s.', 'gidi-movies'),
                '<strong>' . date_i18n(__('M j, Y @ G:i', 'gidi-movies'), strtotime($post->post_date)) . '</strong>'
            ),
            10 => __('Movie Bookings draft updated.', 'gidi-movies'),
        );

        return $messages;
    }

    /**
     * Specify custom bulk actions messages for different post types.
     *
     * @param  array $bulk_messages Array of messages.
     * @param  array $bulk_counts Array of how many objects were updated.
     * @return array
     */
    public function bulk_post_updated_messages($bulk_messages, $bulk_counts)
    {
        $bulk_messages['gidi_movies_bookings'] = array(
			/* translators: %s: coupon count */
            'updated' => _n('%s movie booking updated.', '%s movie bookings updated.', $bulk_counts['updated'], 'gidi-movies'),
			/* translators: %s: movie booking count */
            'locked' => _n('%s movie booking not updated, somebody is editing it.', '%s movie bookings not updated, somebody is editing them.', $bulk_counts['locked'], 'gidi-movies'),
			/* translators: %s: movie booking count */
            'deleted' => _n('%s movie booking permanently deleted.', '%s movie bookings permanently deleted.', $bulk_counts['deleted'], 'gidi-movies'),
			/* translators: %s: movie booking count */
            'trashed' => _n('%s movie booking moved to the Trash.', '%s movie bookings moved to the Trash.', $bulk_counts['trashed'], 'gidi-movies'),
			/* translators: %s: movie booking count */
            'untrashed' => _n('%s movie booking restored from the Trash.', '%s movie bookings restored from the Trash.', $bulk_counts['untrashed'], 'gidi-movies'),
        );

        return $bulk_messages;
    }

    /**
     * Print coupon description textarea field.
     *
     * @param WP_Post $post Current post object.
     */
    public function edit_form_after_title($post)
    {
        if ('gidi_movies_bookings' === $post->post_type) {

            if (!is_admin())
                return;

            $style = '';
            $style .= '<style type="text/css">';
            $style .= '#edit-slug-box, #minor-publishing-actions, #visibility, .num-revisions, .curtime';
            $style .= '{display: none; }';
            $style .= "#publish{width:100% !important;height:40px;line-height:40px;}";
            $style .= "#publishing-action{float:none !important;width:100%;}";
            $style .= '</style>';

            echo $style;

            ?>
                <script>
                
                var currentPTxt = document.querySelector('#submitdiv > h2 > span');
                currentPTxt.innerText = "Movie Booking Actions";
                
                </script>
            <?php

            $p_url = (!empty(get_option('gm_api_options')['gidi_movies_view_booking_ticket_url'])) ? get_option('gm_api_options')['gidi_movies_view_booking_ticket_url'] . $post->ID : "#";
            ?>
			<div class="">
            <a href="<?php echo $p_url; ?>" class="button button-primary" style="width:100%;text-align:center;height:40px;line-height: 40px;font-size:15px;">View Booking Invoice</a>
            </div>
            <?php

        }
    }

    public function remove_row_actions($actions)
    {
        if (get_post_type() === 'gidi_movies_bookings') {
            unset($actions['view']);
            // $actions['view_ticket'] = "<a href='#'>View Ticket</a>";
            unset($actions['inline hide-if-no-js']);
        }
        return $actions;
    }

    /**
     * Change title boxes in admin.
     *
     * @param string  $text Text to shown.
     * @param WP_Post $post Current post object.
     * @return string
     */
    public function enter_title_here($text, $post)
    {
        switch ($post->post_type) {
            case 'gidi_movies_bookings':
                $text = esc_html__('Movie Booking ID', 'gidi-movies');
                break;
        }
        return $text;
    }

    /**
     * re-order the columns on the booking page
     *
     * @param [type] $columns
     * @return void
     */
    function my_cpt_columns($columns)
    {
        unset($columns['date']);
        $columns['title'] = __("Booking ID");
        $columns['date'] = __("Booked On");

        return $columns;
    }

    public function metaboxes()
    {
        $this->attached_post_type = "gidi_movies_bookings";
        $this->prefix = $this->plugin_name . "_bookings_";

        $cmb = new_cmb2_box(array(
            'id' => $this->prefix . 'booking_information',
            'title' => esc_html__('Booking Information', $this->locale),
            'object_types' => $this->attached_post_type, // Post type
            'priority' => 'high',
            'context' => 'normal',
            'show_names' => true, // Show field names on the left
            'classes' => 'gidi-movies-booking-information', // Extra cmb2-wrap classes
            'remove_box_wrap' => true,
            'show_in_rest' => WP_REST_Server::ALLMETHODS // allows this metabox to be visible in the rest api
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'booking_user',
            'name' => 'Name of User',
            'type' => 'text',
            "desc" => "What is the general/average price for this movie?",
        ));

        $cmb->add_field(array(
            'column' => true, // Display field value in the admin columns
            'id' => $this->prefix . 'movie_id',
            'name' => 'Movie ID',
            'type' => 'text',
            "desc" => "What is the ID for this movie?",
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'showing_date_time',
            'name' => 'Showing Date and Time',
            'type' => 'text_datetime_timestamp',
            "desc" => "What is the date and time for this movie ticket?",
        ));

        $cmb->add_field(array(
            'column' => true, // Display field value in the admin columns
            'id' => $this->prefix . 'cinema_id',
            'name' => 'Cinema ID',
            'type' => 'text',
            "desc" => "What is the ID for this cinema?",
        ));

        $cmb->add_field(array(
            'column' => true, // Display field value in the admin columns
            'id' => $this->prefix . 'booking_user_id',
            'name' => 'User ID',
            'type' => 'hidden',
            "desc" => "What is the general/average price for this movie?",
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'adult_seat_number',
            'name' => 'Number of Adult Seats',
            'type' => 'text',
            "desc" => "What is the number of adult seats sold for this movie ticket?",
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'children_seat_number',
            'name' => 'Number of children Seats',
            'type' => 'text',
            "desc" => "What is the number of children seats sold for this movie ticket?",
        ));

        $cmb->add_field(array(
            'id' => $this->prefix . 'student_seat_number',
            'name' => 'Number of student Seats',
            'type' => 'text',
            "desc" => "What is the number of student seats sold for this movie ticket?",
        ));
    }

    public function metabox_2()
    {
        $this->attached_post_type = "gidi_movies_bookings";
        $this->prefix = $this->plugin_name . "_bookings_";

        $cmb = new_cmb2_box(array(
            'id' => $this->prefix . 'booking_information2',
            'title' => esc_html__('Booking Status and Price', $this->locale),
            'object_types' => $this->attached_post_type, // Post type
            'priority' => 'low',
            'context' => 'side',
            'show_names' => true, // Show field names on the left
            'classes' => 'gidi-movies-booking-information', // Extra cmb2-wrap classes
            'remove_box_wrap' => true,
            'show_in_rest' => WP_REST_Server::ALLMETHODS // allows this metabox to be visible in the rest api
        ));

        $cmb->add_field(array(
            'column' => true, // Display field value in the admin columns
            'id' => $this->prefix . 'booking_status',
            'name' => 'Booking Status',
            'desc' => 'Choose if the Movie is Booked on Not',
            'type' => 'select',
            'show_option_none' => 'Not Booked',
            'options' => array(
                '1' => __('Booked!', 'gidi-movies'),
            ),
        ));

        $cmb->add_field(array(
            'column' => true, // Display field value in the admin columns
            'id' => $this->prefix . 'booking_amount',
            'name' => 'Amount Sold',
            'before_field' => "&#x20a6;", // Replaces default '$'
            'desc' => 'Indicate how much was sold',
            'type' => 'text_money',
        ));
    }

}