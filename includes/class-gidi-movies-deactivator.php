<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/peterson-umoke
 * @since      1.0.0
 *
 * @package    Gidi_movies
 * @subpackage Gidi_movies/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Gidi_movies
 * @subpackage Gidi_movies/includes
 * @author     Peterson Umoke <umoke10@hotmail.com>
 */
class Gidi_movies_Deactivator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
	{
		// deals with rewrites and links
		flush_rewrite_rules();
	}

}
