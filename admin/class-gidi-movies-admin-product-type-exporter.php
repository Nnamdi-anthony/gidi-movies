<?php

/**
 * this class is used to export the list of movies from the database into the new post type
 * 
 * @author Peterson Umoke <umoke10@Hotmail.com>
 * @version 1.9.0
 * @uses Woocommerce Uses the woocomerce stuffy thingy
 * @category exporting-tool
 */
class Gidi_movies_admin_product_type_exporter
{
    public function __construct()
    {
    }

    /**
     * get all the product type from the string given
     *
     * @param string $type
     * @return array
     */
    public function get_product_types($type = "movies_listing")
    {
        global $woocommerce_loop;
        $args = array(
            'post_type' => 'product',
            'post_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => $type,
                ),
            ),
        );

        $movie_product_types = new WP_Query($args);
        return $movie_product_types;
    }

    /**
     * Imports the array of data into a post type
     *
     * @param string $post_type
     * @return void
     */
    public function import_product_types($post_type = "")
    {

    }
}