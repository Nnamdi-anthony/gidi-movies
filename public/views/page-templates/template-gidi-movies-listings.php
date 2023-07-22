<?php

/**
 * Provide a public-facing view for a single movie genre
 *
 * @package    Gidi_Movies_Wp
 * @subpackage Gidi_Movies_Wp/public/views
 * @author     Emeodi Nnamdi <email@email.com>
 * @version    GIT: <90df0sdfosfd>
 * @link       https://github.com/Nnamdi-anthony/
 * @since      1.0.0
 */
$page_name = "Movie Genre(s)";
$term_type = "gidi_movies_genres";
$post_type = "gidi_movies";
$genres = get_terms( 'gidi_movies_genres', array(
    'hide_empty' => false,
) );
$types = get_terms( 'gidi_movies_types', array(
    'hide_empty' => false,
) );
?>
<?php get_header(); ?>

<script>
/* When the user clicks on the button, 
toggle between hiding and gm-showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("gm-show");
}
function typesMyFunction() {
    document.getElementById("typesMyFunctionID").classList.toggle("gm-show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.gm-dropbtn')) {

    var dropdowns = document.getElementsByClassName("gm-dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('gm-show')) {
        openDropdown.classList.remove('gm-show');
      }
    }
  }
}

</script>

<style>

.large-header-section {
    background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/img/pattern.jpg'); ?>');
}
img.attachment-post-thumbnail.wp-post-image {
    min-height: 400px;
}
</style>

<section class="large-header-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class='standing-out-header'>
                    Showing All Movies
                </h3>
            </div>
            <div class="col-md-6">
                <form action="<?php echo site_url(); ?>/movie-listings" method="get">
                    <div class="form-group">
                        <input type="text" name="movies_like" id="search-genres-field" placeholder="Search For A Movie, Genre, Movie Type">
                        <button type="submit" class="button damp-button" id="search-genres-btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="large-tab-section">
    <div class="container">
        <div class="row"> 
            <div class="col-md-12">
                <div class="gm-dropdown">
                    <button onclick="myFunction()" class="gm-dropbtn">Filter By Movie Genre <span class="caret"></span></button>
                    <div id="myDropdown" class="gm-dropdown-content">
                        <a href="">--</a>
                        <?php foreach ($genres as $count => $genre): ?>
                            <a href="<?php echo get_term_link($genre->slug, $term_type); ?>">
                                <?php echo $genre->name; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="gm-dropdown">
                    <button onclick="typesMyFunction()" class="gm-dropbtn">Filter By Movie Types <span class="caret"></span></button>
                    <div id="typesMyFunctionID" class="gm-dropdown-content">
                        <a href="">--</a>
                        <?php foreach ($types as $count => $type): ?>
                            <a href="<?php echo get_term_link($type->slug, "gidi_movies_types"); ?>">
                                <?php echo $type->name; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="listing-movies-wrapper">
    <div class="container">
        <div class="row">
        <?php 
        $tax = $wp_query->get_queried_object();
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        $term_id = $tax->term_id;
        $args = array(
            'post_type' => 'gidi_movies',
            'order'         => 'desc',
            'posts_per_page'    => -1,
            // // 'paged'     => $paged,
            // 'tax_query' => array(
            //     array( 
            //         'taxonomy' => $term_type,
            //         'field'    => 'term_id',
            //         'terms'    => array($term_id),
            //     )
            // )
        );
        $query = new WP_Query($args);
        while( $query->have_posts() ): $query->the_post();
        ?>

        <div class="col-md-3">
            <a href="<?php echo the_permalink(); ?>">
                <div class="similar-movies-box">
                    <div class="similiar-movies-image">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <div class="similar-movies-title">
                        <h3><?php the_title(); ?></h3>
                    </div>
                    <div class="similar-movies-action">
                        <button href="void(0);" class="button damp-button" onclick="window.location='<?php echo the_permalink(); ?>'">View Movie</button>
                    </div>
                </div>
            </a>
        </div>

        <?php
        endwhile; 
        
        // next_posts_link() usage with max_num_pages
        // next_posts_link( 'Older Entries', $query->max_num_pages );
        // previous_posts_link( 'Newer Entries' );
        
        ?>

        <?php wp_reset_postdata(); ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>
