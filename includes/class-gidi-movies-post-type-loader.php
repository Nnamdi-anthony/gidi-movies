<?php
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Class Gidi_movies_post_type_loader
 *
 * @class Gidi_movies_post_type_loader
 * @package gidi-movies/
 * @subpackage gidi-movies/includes
 * @author Code Vision
 */
class Gidi_movies_post_type_loader
{
    /**
     * Initialize template loader
     *
     * @access public
     * @return void
     */
    public static function init()
    {

    }

    /**
     * Default templates
     *
     * @access public
     * @param string $template
     * @return string
     * @throws Exception
     */
    public static function templates($template)
    {
        $post_type = get_post_type();
        $custom_post_types = array('cinema', 'cinema_cat', 'cinema_locations', 'gidi_movies', 'gidi_movies_genres', 'gidi_movies_types');

        if (in_array($post_type, $custom_post_types)) {
            if (is_archive()) {
                if (is_tax()) {
                    return self::locate('taxonomy-' . get_query_var('taxonomy'));
                }

                return self::locate('archive-' . $post_type);
            }

            if (is_single()) {
                return self::locate('single-' . $post_type);
            }
        }

        return $template;
    }

    /**
     * Gets template path
     *
     * @access public
     * @param string $name
     * @param string $plugin_dir
     * @return string
     * @throws Exception
     */
    public static function locate($name, $plugin_dir = GIDI_MOVIES_ROOT)
    {
        $template = '';

		// Current theme base dir
        if (!empty($name)) {
            $template = locate_template("{$name}.php");
        }

		// Child theme
        if (!$template && !empty($name) && file_exists(get_stylesheet_directory() . "/gidi-movies-templates/{$name}.php")) {
            $template = get_stylesheet_directory() . "/gidi-movies-templates/{$name}.php";
        }

		// Original theme
        if (!$template && !empty($name) && file_exists(get_template_directory() . "/gidi-movies-templates/{$name}.php")) {
            $template = get_template_directory() . "/gidi-movies-templates/{$name}.php";
        }

		// Plugin
        if (!$template && !empty($name) && file_exists($plugin_dir . "/public/views/post-types/{$name}.php")) {
            $template = $plugin_dir . "/public/views/post-types/{$name}.php";
        }

		// Nothing found
        if (empty($template)) {
            throw new Exception("Template /public/views/post-types/{$name}.php in plugin dir {$plugin_dir} not found.");
        }

        return $template;
    }
}