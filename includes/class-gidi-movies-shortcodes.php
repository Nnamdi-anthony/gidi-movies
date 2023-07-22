<?php

/**
 * This class contains the list of shortcodes for the plugin
 * 
 * @author peterson Umoke <umoke10@hotmail.com>
 * @version 1.0.0
 */
class Gidi_Movies_Shortcodes
{
    public function search_bar()
    {
        require_once GIDI_MOVIES_ROOT . "public/views/shortcodes/search-movies.php";
    }

    public function show_all_movies()
    {
        if( !isset($_GET) ) {
            echo do_shortcode("[show_movie_listings show_all='true' num_of_posts='-1' slide='false' cols='3']");
        } else {
            extract($_GET);

            // init the query
            $args = array(
                'post_type' => 'gidi_movies',
                'posts_per_page' => -1,
            );
            if( !empty($movie_name) ) $args['s'] = $movie_name;
            if (!empty($movie_genre)) {
                $genres = array(
                    'taxonomy' => 'gidi_movies_genres',
                    'field' => 'term_id',
                    'terms' => $movie_genre,
            );
            }
            if (!empty($movie_type)) {
                $types = array(
                        'taxonomy' => 'gidi_movies_types',
                        'field' => 'term_id',
                        'terms' => $movie_type,
                );
            }
            if( !empty($movie_genre) || !empty($movie_type) ) {
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    $types,
                    $genres
                );
            }
            $query = new WP_Query($args);

            if ($query->have_posts()) {
                echo '<div class="container"><div class="row">';
                while ($query->have_posts()) {
                    $query->the_post();
                    require GIDI_MOVIES_ROOT . "public/views/shortcodes/view-movie-card.php";
                }
                wp_reset_postdata();
                echo "</div></div>";
            } else {
                $term = $this->replaceTextFriendly($term);
                $tax_type = $this->replaceTextFriendly($tax_type);
                echo "<h1 class='text-center'> No $term to display </h1>";
                echo "<script> console.warn('There are no results for the items listed in $tax_type, Term: $term for $num_of_posts items'); </script>";
            }

        }
    } 

    // Add Shortcode
    public function show_movie_listing($atts)
    {

	// Attributes
        $atts = shortcode_atts(
            array(
                'tax_type' => 'gidi_movies_types',
                'num_of_posts' => '10',
                'slide' => 'true',
                'term' => 'now-showing',
                'show_all' => 'false',
                'cols' => 5,
            ),
            $atts,
            'show_movie_listings'
        );

        // extract args
        extract($atts);

        // init the query
        $args = array(
            'post_type' => 'gidi_movies',
            'posts_per_page' => $num_of_posts,
        );
        if ($show_all !== 'true') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $tax_type,
                    'field' => 'slug',
                    'terms' => $term,
                ),
            );
        }
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            if ($slide == 'true') {
                echo '<div class="owl-carousel owl-theme">';
            } else {
                echo '<div class="container"><div class="row">';
            }
            while ($query->have_posts()) {
                $query->the_post();
                if ($slide == 'true') {
                    require GIDI_MOVIES_ROOT . "public/views/shortcodes/view-movie-slide-card.php";
                } else {
                    require GIDI_MOVIES_ROOT . "public/views/shortcodes/view-movie-card.php";
                }
            }
            wp_reset_postdata();
            if ($slide == 'true') {
                echo "</div>";
                echo "
                <script>
                (function($){
                    'use strict';
                    
                    var doLoop = false;
                    if( $query->found_posts > 4 ) {
                        doLoop = true;
                    }
                    
                    if (jQuery().owlCarousel()) {
                        $('.owl-carousel').owlCarousel({
                            loop:doLoop,
                            margin:10,
                            dots: false,
                            lazyLoad: true,
                            autoplay: true,
                            navText: ['<i class=\" fa fa-angle-left \">', '<i class=\" fa fa-angle-right \">'],
                            autoplayHoverPause: true,
                            autoplayTimeout: 10000,
                            animateIn: true,
                            nav:true,
                            responsive:{
                                0:{
                                    items:1
                                },
                                600:{
                                    items:$cols
                                },
                                1000:{
                                    items:$cols
                                }
                            }
                        });
                    }

                    var imgLoaOwl = $('.similiar-movies-image img'),
                    imgLoaOwlSrc =  imgLoaOwl.attr('src');

                    // set attrs
                    // imgLoaOwl
                    //         // .addClass('owl-lazy')
                            // .attr('data-src', imgLoaOwlSrc);

                })(jQuery);
                </script>";
            } else {
                echo "</div></div>";
                echo "
                <script>
                    (function ($) {
                        'use strict';

                        var imgLoaOwl = $('.similiar-movies-image img'),
                            imgLoaOwlSrc = imgLoaOwl.attr('src');

                        // set attrs
                        imgLoaOwl
                            .addClass('lazyloaded')
                            .attr('data-original', imgLoaOwlSrc);

                    })(jQuery);
                </script>";
            }
        } else {
            $term = $this->replaceTextFriendly($term);
            $tax_type = $this->replaceTextFriendly($tax_type);
            echo "<h1 class='text-center'> No $term to display </h1>";
            echo "<script> console.warn('There are no results for the items listed in $tax_type, Term: $term for $num_of_posts items'); </script>";
        }

    }

    public function replaceTextFriendly($text, $capitalize = true)
    {
        $term = str_replace("-", " ", $text);
        $term = str_replace("_", " ", $term);
        if ($capitalize) $term = ucwords($term);

        return $term;
    }

}