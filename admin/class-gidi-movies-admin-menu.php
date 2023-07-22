<?php

class Gidi_movies_admin_menu
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
     * The currently active tab
     * 
     * @access private
     * @var string
     */
    private $active_tab;

    /**
     * The special name for the settings
     * 
     * @access private
     * @var string
     */
    private $parent_settings_name;

    /**
     * The plugin settings holder
     * 
     * @access private
     * @var string
     */
    private $plugin_settings;

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
        $this->parent_settings_name = $this->plugin_name . "-menu";
        $this->plugin_settings = get_option('gm_api_options');

        if (isset($_GET['tab'])) {
            $this->active_tab = $_GET['tab'];
        }
    }

    /**
     * adds a menu to the dashboard
     *
     * @return void
     */
    public function add_options_page()
    {
        add_menu_page(esc_attr__('Gidi Movies', 'gidi-movies'), esc_attr__('Gidi Movies', 'gidi-movies'), "manage_options", $this->parent_settings_name, null, 'dashicons-video-alt', '9');

        /**
         * ===========================================
         * CPT and Taxonomies Menu 
         * ===========================================
         */
        add_submenu_page($this->parent_settings_name, 'All Gidi Movies', "All Movies", "edit_posts", "edit.php?post_type=gidi_movies", false);
        add_submenu_page($this->parent_settings_name, 'Add A New Movie', "Add A New Movie", "edit_posts", "post-new.php?post_type=gidi_movies", false);

        add_submenu_page($this->parent_settings_name, 'All Cinemas', "All Cinemas", "edit_posts", "edit.php?post_type=cinema", false);
        add_submenu_page($this->parent_settings_name, 'Add A New Cinema', "Add New Cinema", "edit_posts", "post-new.php?post_type=cinema", false);

        // custom taxonomies
        add_submenu_page($this->parent_settings_name, 'Movie Types', "Movie Types", "edit_posts", "edit-tags.php?taxonomy=gidi_movies_types", false);
        add_submenu_page($this->parent_settings_name, 'Movie Genre', "Movie Genre", "edit_posts", "edit-tags.php?taxonomy=gidi_movies_genres", false);
        add_submenu_page($this->parent_settings_name, 'Cinema Locations', "Cinema Locations", "edit_posts", "edit-tags.php?taxonomy=cinema_locations", false);
        add_submenu_page($this->parent_settings_name, 'Cinema Categories', "Cinema Categories", "edit_posts", "edit-tags.php?taxonomy=cinema_cat", false);


        /**
         * ===========================================
         * Actual Settings Menu
         * ===========================================
         */
        // if ($this->plugin_settings['gidi_movies_show_movie_bookings_menu']) add_submenu_page($this->parent_settings_name, 'Movie Bookings', "Movie Bookings", "edit_posts", "edit.php?post_type=gidi_movies_bookings", false);
        add_submenu_page($this->parent_settings_name, 'Movie Bookings', "Movie Bookings", "edit_posts", "edit.php?post_type=gidi_movies_bookings", false);
        if ($this->plugin_settings['gidi_movies_show_scrapping_menu']) add_submenu_page($this->parent_settings_name, 'Discover Movies From TMDB', "Discover Movies", "edit_posts", $this->plugin_name . "-view-movies", array($this, 'view_movies_html'));
        add_submenu_page($this->parent_settings_name, 'Movie Settings', "Movie Settings", "edit_posts", $this->plugin_name . "-api-accounts-setup", array($this, 'settings'));

        // remove sub menus we wont be needing anymore
        remove_submenu_page($this->parent_settings_name, $this->parent_settings_name);

        // remove menu pages
        remove_menu_page("woocommerce");
        remove_menu_page("edit.php");
        remove_menu_page("edit-comments.php");
        remove_menu_page("edit.php?post_type=ecard");
        remove_menu_page("edit.php?post_type=product");
        remove_menu_page("edit.php?post_type=my-menu");
    }

    /**
     * This options is what allows the user to automagically create movies
     *
     * @return void
     */
    public function view_now_showing_movies_html()
    {
        require_once plugin_dir_path(__FILE__) . "views/gidi-movies-admin-create-now-showing-movies.php";
    }

    /**
     * This options is what allows the user to automagically create movies
     *
     * @return void
     */
    public function view_popular_movies_html()
    {
        require_once plugin_dir_path(__FILE__) . "views/gidi-movies-admin-create-popular-movies.php";
    }

    /**
     * This options is what allows the user to automagically create movies
     *
     * @return void
     */
    public function view_movies_html()
    {
        require_once plugin_dir_path(__FILE__) . "views/gidi-movies-admin-create-movies.php";
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function settings()
    {
        // check user capabilities for only admin users only
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // add error/update messages
        
        // check if the user have submitted the settings
        // wordpress will add the "settings-updated" $_GET parameter to the url
        if (isset($_GET['settings-updated'])) {
            // add settings saved message with the class of "updated"
            add_settings_error('gidi_movies_api_error_messages', 'gidi_movies_api_error_message', __('Movie Settings Saved', 'gidi-movies'), 'updated');
        }
        
        // show error/update messages
        settings_errors('gidi_movies_api_error_messages'); ?>
<div class="wrap">
    <h1>
        <?php echo esc_html(get_admin_page_title()); ?>
    </h1>
    <h2 class="nav-tab-wrapper">
        <a class="nav-tab <?php echo $this->active_tab == 'general_settings' || $this->active_tab == '' ? 'nav-tab-active' : ''; ?>"
            href="<?php echo admin_url() ?>admin.php?page=gidi-movies-api-accounts-setup&tab=general_settings">General
            Settings</a>
        <!-- <a class="nav-tab <?php echo $this->active_tab == 'web_scraping_settings' || $this->active_tab == '' ? 'nav-tab-active' : ''; ?>"
            href="<?php echo admin_url() ?>admin.php?page=gidi-movies-api-accounts-setup&tab=web_scraping_settings">Web
            Scrapping
            Settings</a> -->
        <a class="nav-tab <?php echo $this->active_tab == 'setup_pages' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url() ?>admin.php?page=gidi-movies-api-accounts-setup&tab=setup_pages">Setup
            Page Templates</a>
        <a class="nav-tab <?php echo $this->active_tab == 'setup_taxonomies' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url() ?>admin.php?page=gidi-movies-api-accounts-setup&tab=setup_taxonomies">Setup
            Tools</a>
    </h2>
    <?php if ($this->active_tab == 'general_settings' || $this->active_tab == '') :
            require_once GIDI_MOVIES_ROOT . "admin/views/movie-settings/setup-api.php"; // import view file
// elseif ($this->active_tab == 'web_scraping_settings') :
//             require_once GIDI_MOVIES_ROOT . "admin/views/movie-settings/web-scraping.php"; // import view file
        elseif ($this->active_tab == 'setup_pages') :
            require_once GIDI_MOVIES_ROOT . "admin/views/movie-settings/setup-pages.php"; // import view file
        elseif ($this->active_tab == 'setup_taxonomies') :
            require_once GIDI_MOVIES_ROOT . "admin/views/movie-settings/setup-tools.php"; // import view file
        endif;
        ?>
</div>
<?php

    }
}