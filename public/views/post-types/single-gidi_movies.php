<?php


/**
 * Provide a public-facing view for a single movie
 *
 * @package    Gidi_Movies_Wp
 * @subpackage Gidi_Movies_Wp/public/views
 * @author     Emeodi Nnamdi <email@email.com>
 * @version    GIT: <90df0sdfosfd>
 * @link       https://github.com/Nnamdi-anthony/
 * @since      1.0.0
 */

// $html = new Gidi_Movies_Data_Scraper();
// $dom = $html::load_site('https://gidievents.com');
// $curl = curl_init();
// curl_setopt($curl, CURLOPT_HEADER, 0);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
// curl_setopt($curl, CURLOPT_URL, "https://gidievents.com");
// $html=curl_exec($curl);
// $dom = new simple_html_dom();
// $html = $dom->load($html, true, true); 
// $data = $dom->find('img');
// // Find all images 
// foreach ($data as $element) {
//     print_r($element->src);
// }
// print_r($dom);
?>
<?php get_header(); ?>
<?php
$date = get_post_meta(get_the_ID(), 'gidi_movies_release_date', true);
$human_date = date("F d, Y", strtotime($date));
$genres = wp_get_post_terms(get_the_ID(), 'gidi_movies_genres');
$genres_ids = array();
$date_args = explode(", ", $human_date);
$year = $date_args[1];
$video_id = substr(get_post_meta(get_the_ID(), 'gidi_movies_youtubeID', true), strlen("https://youtu.be/"));
?>

<script>
    (function ($) {
        $(document).ready(function () {
            $("#read_more").on("click", function () {
                var position = jQuery('#cinemas').offset();
                console.log(position);
                jQuery('body,html').animate({
                    scrollTop: (position.top - 150)
                }, 800);

                jQuery('.movies-tab-buttons li').each(function () {
                    jQuery('.movies-tab-buttons li').removeClass('active');
                });
                jQuery('.movies-tab-buttons li:first').addClass('active');
            });
        });
    })(jQuery);
</script>

<style>
    .jumbotron-header:before {
        background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');
    }
</style>
<section class="jumbotron-header-wrapper">
    <div class="jumbotron-header">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="take-airr">
                        <div class="movie-poster-wrapper">
                            <div class="poster-image">
                                <?php echo get_the_post_thumbnail(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="take-airr">
                        <div class="movie-genres-wrapper">
                            <ul class="list-inline">
                                <?php foreach ($genres as $count => $genre) : ?>
                                <?php $genres_ids[] = $genre->term_id; // store the id of the current genres?>
                                <li class="cat-sty purple">
                                    <a href="<?php echo get_term_link($genre->slug, 'gidi_movies_genres'); ?>">
                                        <?php echo $genre->name; ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="movie-title-wrapper">
                            <h1 class="movie-title">
                                <?php the_title(); ?> <span style="font-weight: 100;">(
                                    <?php echo $year; ?>)</span></h1>
                        </div>
                        <div class="movie-tagline-wrapper">
                            <small class="movie-tagline">Movie Tagline: <span class='make-font-slim'>
                                    <?php echo get_post_meta(get_the_ID(), 'gidi_movies_tagline', true); ?></span></small>
                            <div class="thriller-frame">
                                <button class="thriller-play-btn" data-video-id="<?php echo $video_id; ?>"><i class="fa fa-play"></i>
                                    Play Thriller</button>
                            </div>
                        </div>
                        <div class="movie-overview-wrapper">
                            <div class="movie-overview-title">
                                <h4>Overview:</h4>
                            </div>
                            <div class="movie-overview-content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <div class="movie-action-buttons-wrapper">
                            <!-- <button type="button" class="button damp-button" data-buy-button="here">Buy Ticket Now!</button> -->
                            <a data-toggle="tab" href="#overview" id="read_more" class="button damp-button"
                                data-buy-button="here">Buy Ticket Now!</a>
                            <button type="button" class="button damp-button">Remind Me Now</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 hidden-xs hidden-sm">
                    <div class="take-airr">
                        <section class="video-thriller-wrapper">
                            <iframe width="100%" height="300" src="https://www.youtube.com/embed/<?php echo $video_id; ?>"></iframe>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="large-tab-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills movies-tab-buttons">
                    <li class="active"><a data-toggle="tab" href="#overview">Overview</a></li>
                    <li><a data-toggle="tab" href="#videos">Pictures + Videos</a></li>
                    <li><a data-toggle="tab" href="#cinemas">Movies + Time</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="large-tab-content-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="tab-content">
                    <div id="overview" class="tab-pane fade in active">
                        <section id="overview">
                            <h3>Movie Overview</h3>
                            <?php the_content(); ?>
                        </section>
                        <section id="extra-details">
                            <div class="row">
                                <?php if (get_post_meta(get_the_id(), 'gidi_movies_tagline', true)) : ?>
                                <div class="col-md-6">
                                    <h5><i class="fa fa-clock-o"></i> Running Time</h5>
                                    <p>
                                        <?php echo get_post_meta(get_the_id(), 'gidi_movies_duration', true); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                                <?php if (get_post_meta(get_the_id(), 'gidi_movies_tagline', true)) : ?>
                                <div class="col-md-6">
                                    <h5><i class="fa fa-pencil"></i> Movie Tagline</h5>
                                    <p>
                                        <?php echo get_post_meta(get_the_id(), 'gidi_movies_tagline', true); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <?php if ($human_date) : ?>
                                <div class="col-md-6">
                                    <h5><i class="fa fa-calendar"></i> Release Date</h5>
                                    <p>
                                        <?php echo $human_date; ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                                <div class="col-md-6">
                                    <?php if (get_post_meta(get_the_id(), 'gidi_movies_rating', true)) : ?>
                                    <h5><i class="fa fa-thumbs-o-up"></i> Rating</h5>
                                    <p>
                                        <?php echo get_post_meta(get_the_id(), 'gidi_movies_rating', true) . "/10"; ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <?php if (get_post_meta(get_the_id(), 'gidi_movies_language', true)) : ?>
                                <div class="col-md-6">
                                    <h5><i class="fa fa-language"></i> Language</h5>
                                    <p>
                                        <?php echo get_post_meta(get_the_id(), 'gidi_movies_language', true); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                                <?php if (get_post_meta(get_the_id(), 'gidi_movies_general_movie_price_meta', true)) : ?>
                                <div class="col-md-6">
                                    <h5><i class="fa fa-money"></i> Average Price Per Ticket</h5>
                                    <p>
                                        <?php echo get_post_meta(get_the_id(), 'gidi_movies_general_movie_price_meta', true); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </section>
                    </div>
                    <div id="videos" class="tab-pane fade">
                        <h3>Videos</h3>
                        <div class="scrollable-video-wrapper">
                            <div class="scroll-video-gallery">
                                <div class="single-video-frame">
                                    <iframe width="100%" height="300" src="https://www.youtube.com/embed/<?php echo $video_id; ?>"></iframe>
                                </div>
                            </div>
                        </div>

                        <h3>Pictures</h3>
                        <div class="scrollable-image-wrapper">
                            <div class="scroll-image-gallery">
                                <div class="single-image-frame">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="cinemas" class="tab-pane fade">
                        <div id="cinema-showing-times">
                            <showing-times movie_name="<php echo get_the_title(); ?>" movie_id="<php echo get_the_ID(); ?>"></showing-times>
                        </div>
                    </div>
                </div>
            </div>

            <div class="vr-divide hidden"></div>

            <div class="col-md-3">
                <h3>Similar Movies</h3>
                <?php
                    $similar_query = array(
                        'post_type' => 'gidi_movies',
                        "post__not_in" => array(get_the_ID()),
                        // 'posts_per_page'    => 2,
                        'posts_per_page' => 1,
                        'orderby' => 'rand',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'gidi_movies_genres',
                                'field' => 'term_id',
                                'terms' => $genres_ids,
                            ),
                        ),
                );
        $similar_movies = new WP_Query($similar_query);

        while ($similar_movies->have_posts()) : $similar_movies->the_post();
        ?>

                <a href="<?php echo the_permalink(); ?>">
                    <div class="similar-movies-box">
                        <div class="similiar-movies-image">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div class="similar-movies-title">
                            <h3>
                                <?php the_title(); ?>
                            </h3>
                        </div>
                        <div class="similar-movies-action">
                            <button href="void(0);" class="button damp-button" onclick="window.location='<?php echo the_permalink(); ?>'">View
                                Movie</button>
                        </div>
                    </div>
                </a>

                <?php
            endwhile;
            wp_reset_postdata();
            ?>
            </div>
        </div>
    </div>

</section>

<hr>

<!-- <div class="container hidden">
    <div class="row">
        <div class="col-md-12">
            <h3>Movies Now Showing In Cinemas Today</h3>
        </div>
    </div>
</div> -->

<?php get_footer(); ?>