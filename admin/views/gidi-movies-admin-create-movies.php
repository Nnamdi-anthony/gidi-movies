<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the settings admin-facing aspects of the api the plugin uses.
 *
 * @link       https://github.com/peterson-umoke
 * @since      1.0.0
 *
 * @package    Gidi_movies_Wp
 * @subpackage Gidi_movies_Wp/admin/views
 */
?>

<div class="wrap">

    <section id="listing-movies-section">
        <?php
        if (isset($_GET['tab'])) {
            $active_tab = $_GET['tab'];
        }
        ?>
        
    
        <?php 
        if ($active_tab == 'discover_movies' || $active_tab == '') {
            echo "<h2>Discover Movies &raquo; Search For Movies &raquo; List All Movies</h2>";
        } elseif ($active_tab == 'popular_movies') {
            echo "<h2>Discover the Top 100 Most Popular Movies</h2>";
        } elseif ($active_tab == 'now_showing_movies') {
            echo "<h2>Discover New Movies Now Showing in Cinemas</h2>";
        } elseif ($active_tab == 'upcoming_movies') {
            echo "<h2>Discover Up and Coming Movies To Be Released</h2>";
        }
        ?>
    
        <h2 class="nav-tab-wrapper">
          <a class="nav-tab <?php echo $active_tab == 'discover_movies' || $active_tab == '' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url() ?>admin.php?page=gidi-movies-view-movies&tab=discover_movies">Discover Movies</a>
          <a class="nav-tab <?php echo $active_tab == 'popular_movies' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url() ?>admin.php?page=gidi-movies-view-movies&tab=popular_movies">Popular Movies</a>
          <a class="nav-tab <?php echo $active_tab == 'now_showing_movies' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url() ?>admin.php?page=gidi-movies-view-movies&tab=now_showing_movies">Now Showing in Cinemas</a>
          <a class="nav-tab <?php echo $active_tab == 'upcoming_movies' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url() ?>admin.php?page=gidi-movies-view-movies&tab=upcoming_movies">Upcoming Movies</a>
        </h2>
    
        <?php 
        if ($active_tab == 'discover_movies' || $active_tab == '') {
            require_once GIDI_MOVIES_ROOT . "admin/views/discover-movies/discover-movies.php";
        } elseif ($active_tab == 'popular_movies') {
            require_once GIDI_MOVIES_ROOT . "admin/views/discover-movies/popular-movies.php";
        } elseif ($active_tab == 'now_showing_movies') {
            require_once GIDI_MOVIES_ROOT . "admin/views/discover-movies/now-showing-movies.php";
        } elseif ($active_tab == 'upcoming_movies') {
            require_once GIDI_MOVIES_ROOT . "admin/views/discover-movies/upcoming-movies.php";
        }
        ?>
        
    </section>
  </div>