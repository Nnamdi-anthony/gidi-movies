<?php

class Gidi_movies_admin_settings
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
     * The currently active tab
     * 
     * @access private
     * @var string
     */
    private $active_tab;

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

        if (isset($_GET['tab'])) {
            $this->active_tab = $_GET['tab'];
        }
    }

    /**
     * register settings sections, fields and others
     *
     * @return void
     */
    public function init_settings()
    {
        /**
         * ===========================================
         * API KEy settings
         * ===========================================
         */
        register_setting("gidi_movies_settings_group", "gm_api_options");
        register_setting("gidi_movies_settings_group_page_templates", "gm_page_options");

        // tmdb settings
        add_settings_section(
            'gidi_movies_api_section',
            __("Setup the General Behvaiour, API Key For the Movie Scrapping Bot, Menu Management e.t.c", 'gidi-movies'),
            array($this, 'gidi_movies_settings_section_cb'),
            "gidi_movies_settings_group"
        );

        add_settings_section(
            'gidi_movies_page_templates_section',
            __("Setup the Pages Needed for the Movies and Cinema Templates e.t.c", 'gidi-movies'),
            array($this, 'gidi_movies_page_settings_section_cb'),
            "gidi_movies_settings_group_page_templates"
        );

        add_settings_field(
            'gidi_movies_api_key',
            __("TMDB API Key", "gidi-movies"),
            array($this, 'gidi_movies_api_key_cb'),
            "gidi_movies_settings_group",
            "gidi_movies_api_section",
            [
                'label_for' => 'gidi_movies_api_key',
                'class' => 'gidi_movies_api_key_row',
            ]
        );

        // confirm if users can register before making movie bookings or not
        add_settings_field(
            'gidi_movies_user_must_register',
            __("Users Must Register", "gidi-movies"),
            array($this, 'gidi_movies_user_must_register_cb'),
            "gidi_movies_settings_group",
            "gidi_movies_api_section",
            [
                'label_for' => 'gidi_movies_user_must_register',
                'class' => 'gidi_movies_user_must_register_row',
            ]
        );

        add_settings_field(
            'gidi_movies_show_scrapping_menu',
            __("Show Discover Menu", "gidi-movies"),
            array($this, 'gidi_movies_show_scrapping_menu_cb'),
            "gidi_movies_settings_group",
            "gidi_movies_api_section",
            [
                'label_for' => 'gidi_movies_show_scrapping_menu',
                'class' => 'gidi_movies_show_scrapping_menu_row',
            ]
        );

        add_settings_field(
            'gidi_movies_show_movie_bookings_menu',
            __("Show Booking Menu", "gidi-movies"),
            array($this, 'gidi_movies_show_movie_bookings_menu_cb'),
            "gidi_movies_settings_group",
            "gidi_movies_api_section",
            [
                'label_for' => 'gidi_movies_show_movie_bookings_menu',
                'class' => 'gidi_movies_show_movie_bookings_menu_row',
            ]
        );

        add_settings_field(
            'gidi_movies_show_page_templates',
            __("Show Page Templates", "gidi-movies"),
            array($this, 'gidi_movies_show_page_templates_cb'),
            "gidi_movies_settings_group",
            "gidi_movies_api_section",
            [
                'label_for' => 'gidi_movies_show_page_templates',
                'class' => 'gidi_movies_show_page_templates_row',
            ]
        );

        add_settings_field(
            'gidi_movies_pick_movies_landing_page_templates',
            __("Select Landing Page For Movies", "gidi-movies"),
            array($this, 'gidi_movies_pick_movies_landing_page_templates_cb'),
            "gidi_movies_settings_group_page_templates",
            "gidi_movies_page_templates_section",
            [
                'label_for' => 'gidi_movies_landing_page_templates',
                'class' => 'gidi_movies_landing_page_templates_row',
            ]
        );

        add_settings_field(
            'gidi_movies_pick_movies_listing_page_templates',
            __("Select Listing Page For Movies", "gidi-movies"),
            array($this, 'gidi_movies_pick_movies_listing_page_templates_cb'),
            "gidi_movies_settings_group_page_templates",
            "gidi_movies_page_templates_section",
            [
                'label_for' => 'gidi_movies_listing_page_templates',
                'class' => 'gidi_movies_listing_page_templates_row',
            ]
        );

        add_settings_field(
            'gidi_movies_pick_movies_booking_page_templates',
            __("Select Booking Page For Movies", "gidi-movies"),
            array($this, 'gidi_movies_pick_movies_booking_page_templates_cb'),
            "gidi_movies_settings_group_page_templates",
            "gidi_movies_page_templates_section",
            [
                'label_for' => 'gidi_movies_booking_page_templates',
                'class' => 'gidi_movies_booking_page_templates_row',
            ]
        );

        add_settings_field(
            'gidi_movies_pick_movies_ticket_page_templates',
            __("Select Ticket Viewing Page For Movies", "gidi-movies"),
            array($this, 'gidi_movies_pick_movies_ticket_page_templates_cb'),
            "gidi_movies_settings_group_page_templates",
            "gidi_movies_page_templates_section",
            [
                'label_for' => 'gidi_movies_ticket_page_templates',
                'class' => 'gidi_movies_ticket_page_templates_row',
            ]
        );

        add_settings_field(
            'gidi_movies_pick_cinema_landing_page_templates',
            __("Select Landing Page For Cinemas", "gidi-movies"),
            array($this, 'gidi_movies_pick_cinema_landing_page_templates_cb'),
            "gidi_movies_settings_group_page_templates",
            "gidi_movies_page_templates_section",
            [
                'label_for' => 'gidi_cinema_landing_page_templates',
                'class' => 'gidi_cinema_landing_page_templates_row',
            ]
        );

        add_settings_field(
            'gidi_movies_pick_cinema_listing_page_templates',
            __("Select Listing Page For Cinemas", "gidi-movies"),
            array($this, 'gidi_movies_pick_cinema_listing_page_templates_cb'),
            "gidi_movies_settings_group_page_templates",
            "gidi_movies_page_templates_section",
            [
                'label_for' => 'gidi_cinema_listing_page_templates',
                'class' => 'gidi_cinema_listing_page_templates_row',
            ]
        );
    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_pick_cinema_listing_page_templates_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_page_options');
        // output the field
        $pages = get_pages();
        ?>
            <select name="gm_page_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo $options[$args['label_for']]; ?>">
            <option value="">None</option>
                <?php foreach ($pages as $key => $page) : ?>
                    <option value="<?php echo $page->ID; ?>" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], $page->ID, false)) : (''); ?>>
                        <?php esc_html_e($page->post_title, 'gidi-movies'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <p class="description">
                Choose the Cinemas Listing Page
            </p>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_pick_cinema_landing_page_templates_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_page_options');
        // output the field
        $pages = get_pages();
        ?>
            <select name="gm_page_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo $options[$args['label_for']]; ?>">
            <option value="">None</option>
                <?php foreach ($pages as $key => $page) : ?>
                    <option value="<?php echo $page->ID; ?>" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], $page->ID, false)) : (''); ?>>
                        <?php esc_html_e($page->post_title, 'gidi-movies'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <p class="description">
                Choose the Cinemas Landing Page
            </p>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_pick_movies_ticket_page_templates_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_page_options');
        // output the field
        $pages = get_pages();
        ?>
            <select name="gm_page_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo $options[$args['label_for']]; ?>">
            <option value="">None</option>
                <?php foreach ($pages as $key => $page) : ?>
                    <option value="<?php echo $page->ID; ?>" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], $page->ID, false)) : (''); ?>>
                        <?php esc_html_e($page->post_title, 'gidi-movies'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <p class="description">
                Choose the Ticket viewing Page For Movies
            </p>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_pick_movies_booking_page_templates_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_page_options');
        // output the field
        $pages = get_pages();
        ?>
            <select name="gm_page_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo $options[$args['label_for']]; ?>">
            <option value="">None</option>
                <?php foreach ($pages as $key => $page) : ?>
                    <option value="<?php echo $page->ID; ?>" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], $page->ID, false)) : (''); ?>>
                        <?php esc_html_e($page->post_title, 'gidi-movies'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <p class="description">
                Choose the Booking Page For Movies
            </p>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_pick_movies_listing_page_templates_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_page_options');
        // output the field
        $pages = get_pages();
        ?>
            <select name="gm_page_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo $options[$args['label_for']]; ?>">
            <option value="">None</option>
                <?php foreach ($pages as $key => $page) : ?>
                    <option value="<?php echo $page->ID; ?>" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], $page->ID, false)) : (''); ?>>
                        <?php esc_html_e($page->post_title, 'gidi-movies'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <p class="description">
                Choose the Listing Page For Movies
            </p>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_page_settings_section_cb($args)
    {
        ?>
            <p id="<?php echo esc_attr($args['id']); ?>">
                <?php 
                esc_html_e('Please Choose the page template for cinema and movies and click save', 'gidi-movies');
                ?>
            </p>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_settings_section_cb($args)
    {
        ?>
            <p id="<?php echo esc_attr($args['id']); ?>">
                <?php 
                esc_html_e('Please Choose your options and click save', 'gidi-movies');
                ?>
            </p>

            <style>
            .gidi-movies-textbox {
                width: 30%;
                padding: 10px;
            }
            .gidi-movies-checkbox {
                text-align:center !important;
                display: inline-block !important;
            }
            </style>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_view_booking_ticket_url($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_api_options');
        // output the field
        ?>
            <input type="text" autocomplete="off" class="gidi-movies-textbox <?php echo esc_attr($args['class']); ?>" name="gm_api_options[<?php echo esc_attr($args['label_for']); ?>]" id="<?php echo esc_attr($args['label_for']); ?>" value="<?php echo $options[$args['label_for']]; ?>">
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_api_key_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_api_options');
        // output the field
        ?>
            <input type="text" autocomplete="off" class="gidi-movies-textbox <?php echo esc_attr($args['class']); ?>" name="gm_api_options[<?php echo esc_attr($args['label_for']); ?>]" id="<?php echo esc_attr($args['label_for']); ?>" value="<?php echo $options[$args['label_for']]; ?>">
            <p class="description">
            Insert the API Key of the api account
            </p>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_pick_movies_landing_page_templates_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_page_options');
        // output the field
        $pages = get_pages();
        ?>
            <select name="gm_page_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo $options[$args['label_for']]; ?>">
            <option value="">None</option>
                <?php foreach ($pages as $key => $page) : ?>
                    <option value="<?php echo $page->ID; ?>" <?php echo isset($options[$args['label_for']]) ? (selected($options[$args['label_for']], $page->ID, false)) : (''); ?>>
                        <?php esc_html_e($page->post_title, 'gidi-movies'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <p class="description">
                Choose the Landing Page For Movies
            </p>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_user_must_register_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_api_options');

            // output the field
        ?>
            <input type="checkbox" class="gidi-movies-checkbox <?php echo esc_attr($args['class']); ?>" name="gm_api_options[<?php echo esc_attr($args['label_for']); ?>]" id="<?php echo esc_attr($args['label_for']); ?>" value="1" <?php echo checked(1, $options[$args['label_for']], false); ?>>
            <p class="description">
            Must Users Register Before Been Allowed to Book a Movie?
            </p>
        <?php

    }


    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_show_scrapping_menu_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_api_options');

            // output the field
        ?>
            <input type="checkbox" class="gidi-movies-checkbox <?php echo esc_attr($args['class']); ?>" name="gm_api_options[<?php echo esc_attr($args['label_for']); ?>]" id="<?php echo esc_attr($args['label_for']); ?>" value="1" <?php echo checked(1, $options[$args['label_for']], false); ?>>
            <p class="description">
            Should The Discover Menu Be Shown on the Backend?
            </p>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_show_page_templates_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_api_options');

            // output the field
        ?>
            <input type="checkbox" class="gidi-movies-checkbox <?php echo esc_attr($args['class']); ?>" name="gm_api_options[<?php echo esc_attr($args['label_for']); ?>]" id="<?php echo esc_attr($args['label_for']); ?>" value="1" <?php echo checked(1, $options[$args['label_for']], false); ?>>
            <p class="description">
            Show Page Templates In Edit/Add Page Template Dropdown While you are either creating or editing a new page
            </p>
        <?php

    }

    /**
     * callback for the movies api
     *
     * @param array $args
     * @return void
     */
    public function gidi_movies_show_movie_bookings_menu_cb($args)
    {
        // get the value of the setting we've registered with register_setting()
        $options = get_option('gm_api_options');

        // output the field
        ?>
            <input type="checkbox" class="gidi-movies-checkbox <?php echo esc_attr($args['class']); ?>" name="gm_api_options[<?php echo esc_attr($args['label_for']); ?>]" id="<?php echo esc_attr($args['label_for']); ?>" value="1" <?php echo checked(1, $options[$args['label_for']], false); ?>>
            <p class="description">
            Should The Bookings Menu Be Shown on the Backend?
            </p>
        <?php

    }
}
