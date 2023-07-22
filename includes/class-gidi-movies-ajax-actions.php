<?php

use Goutte\Client;

defined("ABSPATH") or exit();

/**
 * Perform Ajax Actions
 *
 * @link       https://github.com/peterson-umoke
 * @since      1.0.0
 *
 * @package    Gidi_movies_Wp
 * @subpackage Gidi_movies_Wp/includes
 */

/**
 * Perform Ajax Actions.
 *
 * This class is used to do certain ajax actions and functions.
 *
 * @since      1.0.0
 * @package    Gidi_movies_Wp
 * @subpackage Gidi_movies_Wp/includes
 * @author     Peterson Umoke <umoke10@hotmail.com>
 */
class Gidi_movies_ajax_actions
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
     * Ajax Response data
     * 
     * Used to Hold data for ajax
     *
     * @var array
     */
    public $data;

    /**
     * the variables that holds the key for the api calls
     *
     * @var string
     */
    public $tmdb_base_url;
    public $tmdb_picture_url;
    public $tmdb_api_key;
    public $tmdb_picture_url_org;

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
        $this->data = array();
        $this->tmdb_api_key = get_option('gm_api_options')['gidi_movies_api_key'];
        $this->tmdb_base_url = "https://api.themoviedb.org/3"; // base url for tmdb
        $this->tmdb_picture_url = "https://image.tmdb.org/t/p/w500"; // the compressed image
        $this->tmdb_picture_url_org = "https://image.tmdb.org/t/p/original"; // the original image

        // set the defaults for response calls
        $this->data['title'] = "Unauthorized Request";
        $this->data['status'] = 401; // success or error
        $this->data['type'] = "error"; // success or error
        $this->data['body'] = "Please Try Again!";

    }

    /**
     * Create Movies
     *
     * Takes the Array of requests sent by the plugin and does something with it
     *
     * @since    1.0.0
     */
    public function create_movies()
    {
        // make sure the user is logged in  and is sending the right nounces
        if (!wp_verify_nonce($_POST['nounce'], "wp_gm_ajax")) {
            $this->transformRequest();
        }

        // convert all the post data sent to this function a variable
        extract($_POST);

        // make the api call for the genres
        $curl = curl_init(); // init curl

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tmdb_base_url . "/movie/" . $movie_id . "?language=en-US&api_key=" . $this->tmdb_api_key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->data['body'] = $response;
            $this->data['title'] = "Couldnt Fetch the Movie From TMDB";
            $this->data['type'] = 'error';
            $this->transformRequest();
        } else {
            // convert the json response to array
            $movieArr = json_decode($response);

            // print_r($movieArr);
            // setup the insert data for the movie
            $movieDataArray = array(
                'post_content' => $movieArr->overview,
                'post_title' => $movieArr->title,
                'post_status' => $post_type,
                'post_type' => 'gidi_movies',
                'post_parent' => 0,
                'menu_order' => 0,
            );

            // make sure the movies is created twice or more
            $page = get_page_by_title($movieArr->title, OBJECT, 'gidi_movies');

            // checks if the page exists
            if (count($page) < 1) {
                $movie_post_id = wp_insert_post($movieDataArray);

            // get the thriller video for the movie
                $videoResults = $this->getVideoId($movie_id, $this->tmdb_api_key);
                $cnVidResults = json_decode($videoResults);
                $movieVideoID = $cnVidResults->results[0]->key;

                // update the tagline
                update_post_meta($movie_post_id, "gidi_movies_duration", $this->convertToHoursMins($movieArr->runtime, '%02d hour(s) %02d minutes'));
                update_post_meta($movie_post_id, "gidi_movies_tagline", $movieArr->tagline);
                update_post_meta($movie_post_id, "gidi_movies_release_date", $movieArr->release_date);
                update_post_meta($movie_post_id, "gidi_movies_language", $movieArr->original_language);
                update_post_meta($movie_post_id, "gidi_movies_rating", $movieArr->vote_average);
                update_post_meta($movie_post_id, "gidi_movies_youtubeID", "https://youtu.be/" . $movieVideoID);

                // set the genres for this movie
                foreach ($movieArr->genres as $key => $genre) {
                    $currGenreData = get_term_by('name', $genre->name, 'gidi_movies_genres');
                    $movieGenreID = $currGenreData->term_id;
                    wp_set_object_terms($movie_post_id, $movieGenreID, 'gidi_movies_genres', true);
                }

                // set the type for this movie
                $currentMovieType = get_term_by('name', "Hollywood Movies", 'gidi_movies_types');
                $defaultMovieType = $currentMovieType->term_id;
                wp_set_object_terms($movie_post_id, $defaultMovieType, 'gidi_movies_types', true);

                if (!empty($movie_type)) {
                    $currentMovieType = get_term_by('name', $movie_type, 'gidi_movies_types');
                    $defaultMovieType = $currentMovieType->term_id;
                    wp_set_object_terms($movie_post_id, $defaultMovieType, 'gidi_movies_types', true);
                }

                // set the post thumbnail
                $this->upload_featured_image($movie_post_id, $this->tmdb_picture_url . $movieArr->poster_path);

                // return the status of the request
                $this->data['title'] = "Movie Created!";
                $this->data['body'] = $movieArr->title . " has been created successfully";
                $this->data['status'] = 200;
                $this->data['type'] = 'success';
                $this->transformRequest();
            }

            // what happens when a movie already exists
            $this->data['status'] = 205;
            $this->data['title'] = $movieArr->title . " Already Exists";
            $this->data['body'] = "Action failed to complete, this movie already exists.";
            $this->data['type'] = "error";

            // return the requests
            $this->transformRequest();
        }
    }

    /**
     * Create movie genres
     *
     * Takes the Array of requests sent by the plugin and does something with it
     *
     * @since    1.0.0
     */
    public function create_movies_genres()
    {
        // make sure the user is logged in  and is sending the right nounces
        if (!wp_verify_nonce($_POST['nounce'], "wp_gm_ajax")) {
            $this->transformRequest();
        }
        
        // make the api call for the genres
        $curl = curl_init(); // init curl

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->tmdb_base_url . "/genre/movie/list?language=en-US&api_key=" . $this->tmdb_api_key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // $this->data['body'] = $response;
            $this->data['body'] = "Please Check your api key and try again";
            $this->data['title'] = "Couldnt Fetch Genres";
            $this->data['type'] = 'error';
            $this->transformRequest();
        } else {

            // convert the response to an object
            $responseCnv = json_decode($response);
            $genres = $responseCnv->genres;

            foreach ($genres as $index => $args) {

                $taxArgs = array(
                    'taxonomy' => 'gidi_movies_genres',
                    'cat_name' => $args->name,
                );
                $tax_id = wp_insert_category($taxArgs);

            }

            $this->data['body'] = "Movie Genres Imported Successfully";
            $this->data['title'] = "Action Done Successfully";
            $this->data['status'] = 200;
            $this->data['type'] = 'success';
            $this->transformRequest();
        }
    }

    /**
     * Create movie types
     *
     * Takes the Array of requests sent by the plugin and does something with it
     *
     * @since    1.0.0
     */
    public function create_movies_types()
    {
        // make sure the user is logged in  and is sending the right nounces
        if (!wp_verify_nonce($_POST['nounce'], "wp_gm_ajax")) {
            $this->transformRequest();
        }

        $movie_types = [
            'Now Showing',
            'Popular Movies',
            'Upcoming Movies',
            'Top Rated Movies',
            'Hollywood Movies',
            'Nollywood Movies',
        ];

        foreach ($movie_types as $index => $movie_type) {

            $taxArgs = array(
                'taxonomy' => 'gidi_movies_types',
                'cat_name' => $movie_type,
            );
            $tax_id = wp_insert_category($taxArgs);

        }

        // say a response to the user
        $this->data['body'] = "Movie Types Imported Successfully";
        $this->data['title'] = "Imports Done Successfully";
        $this->data['status'] = 200;
        $this->data['type'] = 'success';
        $this->transformRequest();
    }

    /**
     * Create Cinema Locations
     *
     * Takes the Array of requests sent by the plugin and does something with it
     *
     * @since    1.0.0
     */
    public function create_cinema_locations()
    {
        // make sure the user is logged in  and is sending the right nounces
        if (!wp_verify_nonce($_POST['nounce'], "wp_gm_ajax")) {
            $this->transformRequest();
        }

        $top_cinema_locations = ['Lagos', 'Abuja', 'Kano', 'Port Harcourt'];

        foreach ($top_cinema_locations as $index => $args) {

            $taxArgs = array(
                'taxonomy' => 'cinema_locations',
                'cat_name' => $args,
            );
            $tax_id = wp_insert_category($taxArgs);

        }

        // return a response
        $this->data['body'] = "Cinema Locations Imported Successfully";
        $this->data['title'] = "Imports Successful";
        $this->data['type'] = 'success';
        $this->data['status'] = 200;
        $this->transformRequest();
    }

    /**
     * used to import all the movies on the site that exists as a product type to a post type
     *
     * @return void
     */
    public function import_export_product_type_to_post_type()
    {
        global $woocommerce_loop;

        $args = array(
            'post_type' => 'product',
            "posts_per_page" => -1,
            'post_status' => 'publish,pending,draft',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'movies_listing',
                ),
            ),
        );
        $products = new WP_Query($args);
        $time_akldjfsd = 1;

        while ($products->have_posts()) : $products->the_post();

        /**
         * @todo Make the import of date correct
         */
        $post_time = str_replace("/", "-", get_the_date());
        $post_time_date = strtotime($post_time);

        if ($time_akldjfsd <= 4) {

            $movieDataArray = array(
                'post_content' => get_the_content(),
                'post_title' => get_the_title(),
                'post_status' => get_post_status(),
                "post_date" => $post_time_date,
                'post_type' => 'gidi_movies',
                "meta_input" => array(
                    "gidi_movies_youtubeID" => get_post_meta(get_the_ID(), 'mv_video', true),
                    "gidi_movies_release_date" => get_post_meta(get_the_ID(), 'mv_release_date', true),
                    "gidi_movies_duration" => get_post_meta(get_the_ID(), 'mv_duration', true),
                    "gidi_movies_language" => get_post_meta(get_the_ID(), 'mv_language', true),
                ),
                'post_parent' => 0,
                'menu_order' => 0,
            );
            $genres = explode(", ", get_post_meta(get_the_ID(), 'mv_genre', true));
            $movie_id = wp_insert_post($movieDataArray); // insert the movie
    
                // set the genres for this movie
            foreach ($genres as $key => $genre) {
                $currGenreData = get_term_by('name', $genre, 'gidi_movies_genres');
                $movieGenreID = $currGenreData->term_id;
                wp_set_object_terms($movie_id, $movieGenreID, 'gidi_movies_genres', true);
            }

            if (strtolower(get_post_meta(get_the_ID(), 'is_nollywood', true)) == 'yes') {
                    // set the type for this movie
                $currentMovieType = get_term_by('name', "Nollywood Movies", 'gidi_movies_types');
                $defaultMovieType = $currentMovieType->term_id;
                wp_set_object_terms($movie_id, $defaultMovieType, 'gidi_movies_types', true);
            }

            if (strtolower(get_post_meta(get_the_ID(), 'is_nollywood', true)) == 'no') {
                    // set the type for this movie
                $currentMovieType = get_term_by('name', "Hollywood Movies", 'gidi_movies_types');
                $defaultMovieType = $currentMovieType->term_id;
                wp_set_object_terms($movie_id, $defaultMovieType, 'gidi_movies_types', true);
            }
    
                // set the type for this movie
            if (strtolower(get_post_meta(get_the_ID(), 'is_most_popular', true)) == 'yes') {
                    // set the type for this movie
                $currentMovieType = get_term_by('name', "Popular Movies", 'gidi_movies_types');
                $defaultMovieType = $currentMovieType->term_id;
                wp_set_object_terms($movie_id, $defaultMovieType, 'gidi_movies_types', true);
            }

            $this->upload_featured_image($movie_id, get_the_post_thumbnail_url());
        }

        $time_akldjfsd++;

        endwhile; 
        
        // return a response
        $this->data['body'] = "Import to The Movies is Done!";
        $this->data['title'] = "Imports Successful";
        $this->data['type'] = 'success';
        $this->data['status'] = 200;
        $this->transformRequest();
    }

    /**
     * upload a image to the wp upload directory and set it as the featured image
     *
     * @param int $post_id
     * @param string $image_url
     * @return void
     */
    public function upload_featured_image($post_id, $image_url)
    {
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);
        $filename = basename($image_url);
        if (wp_mkdir_p($upload_dir['path'])) $file = $upload_dir['path'] . '/' . $filename;
        else $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        $res1 = wp_update_attachment_metadata($attach_id, $attach_data);
        $res2 = set_post_thumbnail($post_id, $attach_id);
    }

    /**
     * convert a integer value to time format
     *
     * @param int $time
     * @param string $format
     * @return mixed
     */
    public function convertToHoursMins($time, $format = '%02d:%02d')
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    /**
     * get the video arrays needed for the movie
     *
     * @param string $movieID the id of the movie
     * @param string $key the secret api key of tmdb
     * @return array
     */
    public function getVideoId($movieID, $key)
    {
        $curl = curl_init(); // init curl

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.themoviedb.org/3/movie/" . $movieID . "/videos" . "?language=en-US&api_key=" . $key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        // return $err;
        } else {
            return $response;
        }

    }

    public function getMovieGenres()
    {
        // make sure the user is logged in and is sending the right nounces
        if (!wp_verify_nonce($_POST['nounce'], "wp_gm_ajax")) {
            $this->transformRequest();
        }

        $genres = get_terms(array(
            'taxonomy' => 'gidi_movies_genres',
            'hide_empty' => true,
        ));
        $genres_ids = array();
        foreach ($genres as $count => $genre) {
            $genres_ids[] = array('id' => $genre->term_id, 'name' => $genre->name); // store the id of the current genres
        }

        $this->data = $genres_ids;
        $this->transformRequest();
    }

    public function getMovieTypes()
    {
       // make sure the user is logged in  and is sending the right nounces
        if (!wp_verify_nonce($_POST['nounce'], "wp_gm_ajax")) {
            $this->transformRequest();
        }

        // convert all the post data sent to this function a variable
        extract($_POST);

        $types = get_terms(array(
            'taxonomy' => 'gidi_movies_types',
            'hide_empty' => true,
        ));
        $types_ids = array();
        foreach ($types as $count => $genre) {
            $types_ids[] = array('id' => $genre->term_id, 'name' => $genre->name); // store the id of the current types
        }

        $this->data = $types_ids;
        $this->transformRequest();
    }

    public function getMovieNames()
    {
        // make sure the user is logged in  and is sending the right nounces
        if (!wp_verify_nonce($_POST['nounce'], "wp_gm_ajax")) {
            $this->transformRequest();
        }

        // convert all the post data sent to this function a variable
        extract($_POST);
        $args = array(
            'post_type' => 'gidi_movies',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $names[] = array('id' => get_the_ID(), 'name' => get_the_title()); // store the id of the current types
            }
            wp_reset_postdata();
        } else {
            $name[] = array('id' => '', 'name' => 'No Movie Found');
        }
        $this->data = $names;
        $this->transformRequest();
    }

    public function get_now_showing_times()
    {
        // make sure the user is logged in  and is sending the right nounces
        if (!wp_verify_nonce($_POST['nounce'], "wp_gm_ajax")) {
            $this->transformRequest();
        }

        $client = new Client();
        // $crawler = $client->request('GET', 'https://www.nowshowing.com.ng/today.php');
        // $crawler->filter('div.card-header > a > h2')->each(function ($node) {
        //     echo $node->text() . "<br />";
        // });

        $this->data = array("klsdjflsfd" => "klsjdfklsdf");
        $this->transformRequest();
    }


    /**
     * transform the request to json data for the user to consume
     * 
     * @return void
     */
    public function transformRequest()
    {
        // transform the request to ajax
        echo json_encode($this->data);
        
        // kill the script once the class is finish running
        // wp_die("Request is not valid", "401");
        die();
    }

}