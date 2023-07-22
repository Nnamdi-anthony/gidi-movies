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
$genres = wp_get_post_terms(get_the_ID(), 'cinema_cat');
$genres_ids = array();
$video_id = substr(get_post_meta(get_the_ID(), 'gidi_movies_youtubeID', true), strlen("https://youtu.be/"));

$lat = "6.6084801";
$lng = "3.3915728";
$api_key = get_option("listing_manager_google_maps_api_key","AIzaSyCQYiKz8PIAv2gzUEpepJaLcp6JrmcsZFI");
$lat = get_post_meta(get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_latitude', true);
$lng = get_post_meta(get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_longitude', true);
define("WEATHER_LAT", $lat);
define("WEATHER_LNG", $lng);
?>

<style>
    .jumbotron-header:before {
        background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');
    }

    .read-more-wrapper {
        display: none;
    }
</style>
<script>
    (function ($) {
        $(document).ready(function () {
            $("#read_more").on("click", function () {
                var position = jQuery('#overview').offset();
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
<section class="jumbotron-header-wrapper">
    <div class="jumbotron-header">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="take-airr">
                        <div class="movie-poster-wrapper">
                            <div class="poster-image">
                                <?php echo (!empty(get_the_post_thumbnail())) ? get_the_post_thumbnail() : "<img src='https://via.placeholder.com/500x750.png?text=//' />"; ?>
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
                                    <a href="<?php echo get_term_link($genre->slug, 'cinema_cat'); ?>">
                                        <?php echo $genre->name; ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="movie-title-wrapper">
                            <h1 class="movie-title">
                                <?php the_title(); ?>
                            </h1>
                        </div>
                        <div class="movie-tagline-wrapper">
                            <small class="movie-tagline">Address: <span class='make-font-slim'>
                                    <?php echo get_post_meta(get_the_ID(), 'cinema_listing_address', true); ?></span></small>
                            <div class="clear"></div>
                            <small class="movie-tagline">State: <span class='make-font-slim'>
                                    <?php echo get_post_meta(get_the_ID(), 'cinema_listing_state', true); ?></span></small>
                            <!-- <div class="thriller-frame">
                                <button class="thriller-play-btn" data-video-id="<?php echo $video_id; ?>"><i class="fa fa-play"></i>
                                    Play Thriller</button>
                            </div> -->
                        </div>
                        <div class="weather-widgetshortcode">
                            <?php echo do_shortcode("[gidiweather_form]"); ?>
                        </div>
                        <div class="movie-overview-wrapper">
                            <div class="movie-overview-title">
                                <h4>Overview:</h4>
                            </div>
                            <div class="movie-overview-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                        <div class="movie-action-buttons-wrapper">

                            <a data-toggle="tab" href="#overview" id="read_more" class="button damp-button"
                                data-buy-button="here">Read
                                More!</a>
                            <!-- <button type="button" class="button damp-button">Plan A Tour</button> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-4 hidden-xs hidden-sm">
                    <div class="take-airr">
                        <section class="video-thriller-wrapper">
                            <iframe width="100%" height="300" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=<?php echo $api_key; ?>
						&q=<?php echo $lat; ?>,<?php echo $lng; ?>"
                                allowfullscreen>
                            </iframe>
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
                    <li class="active"><a data-toggle="tab" href="#overview">Description</a></li>
                    <li><a data-toggle="tab" href="#videos">Pictures + Videos</a></li>
                    <li><a data-toggle="tab" href="#location">Location</a></li>
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
                    <div id="location" class="tab-pane fade-in">
                        <iframe width="100%" height="500px" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=<?php echo $api_key; ?>
						&q=<?php echo $lat; ?>,<?php echo $lng; ?>"
                            allowfullscreen>
                        </iframe>
                    </div>
                    <div id="overview" class="tab-pane fade-in active">
                        <?php if(!empty(get_the_content())): ?>
                        <section id="overview">
                            <h3>Cinema Description</h3>
                            <?php the_content(); ?>
                        </section>
                        <?php endif; ?>
                        <section id="extra-details">
                            <div class="">
                                <?php if (     get_post_meta(get_the_id(), 'cinema_listing_social_facebook', true) 
                                            || get_post_meta(get_the_id(), 'cinema_listing_social_twitter', true)
                                            || get_post_meta(get_the_id(), 'cinema_listing_social_linkedin', true)
                                            || get_post_meta(get_the_id(), 'cinema_listing_social_google', true)
                                        ) : ?>
                                <section id="overview">
                                    <h3>Social Media Contacts</h3>
                                </section>
                                <?php if (get_post_meta(get_the_id(), 'cinema_listing_social_facebook', true)) : ?>
                                <div class="col-md-12">
                                    <h5><i class="fa fa-facebook-square fa-2x"></i> Facebook</h5>
                                    <p>
                                        <?php echo get_post_meta(get_the_id(), 'cinema_listing_social_facebook', true); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                                <?php if (get_post_meta(get_the_id(), 'cinema_listing_social_twitter', true)) : ?>
                                <div class="col-md-12">
                                    <h5><i class="fa fa-twitter-square fa-2x"></i> Twitter</h5>
                                    <p>
                                        <?php echo get_post_meta(get_the_id(), 'cinema_listing_social_twitter', true); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                                <?php if (get_post_meta(get_the_id(), 'cinema_listing_social_linkedin', true)) : ?>
                                <div class="col-md-12">
                                    <h5><i class="fa fa-linkedin-square fa-2x"></i> LinkedIn</h5>
                                    <p>
                                        <?php echo get_post_meta(get_the_id(), 'cinema_listing_social_linkedin', true); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                                <?php if (get_post_meta(get_the_id(), 'cinema_listing_social_google', true)) : ?>
                                <div class="col-md-12">
                                    <h5><i class="fa fa-google-plus-square fa-2x"></i> Google Plus</h5>
                                    <p>
                                        <?php echo get_post_meta(get_the_id(), 'cinema_listing_social_google', true); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
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
                </div>
            </div>

            <div class="vr-divide hidden"></div>

            <div class="col-md-3">
                <h3>Cinema Information</h3>
                <section id="extra-details">
                    <div class="row">
                        <?php if (get_post_meta(get_the_id(), 'cinema_listing_email', true)) : ?>
                        <div class="col-md-12">
                            <h5><i class="fa fa-envelope-o"></i> Email</h5>
                            <p>
                                <?php echo get_post_meta(get_the_id(), 'cinema_listing_email', true); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        <?php if (get_post_meta(get_the_id(), 'cinema_listing_web', true)) : ?>
                        <div class="col-md-12">
                            <h5><i class="fa fa-globe"></i> Website</h5>
                            <p>
                                <?php echo get_post_meta(get_the_id(), 'cinema_listing_web', true); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <?php if (get_post_meta(get_the_id(), 'cinema_listing_phone', true)) : ?>
                        <div class="col-md-12">
                            <h5><i class="fa fa-phone"></i> Phone Number</h5>
                            <p>
                                <?php echo get_post_meta(get_the_id(), 'cinema_listing_phone', true); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-12">
                            <?php if (get_post_meta(get_the_id(), 'cinema_listing_address', true)) : ?>
                            <h5><i class="fa fa-map"></i> Address</h5>
                            <p>
                                <?php echo get_post_meta(get_the_id(), 'cinema_listing_address', true); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <?php if (get_post_meta(get_the_id(), 'cinema_listing_state', true)) : ?>
                        <div class="col-md-12">
                            <h5><i class="fa fa-language"></i> State</h5>
                            <p>
                                <?php echo get_post_meta(get_the_id(), 'cinema_listing_state', true); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        <?php if (get_post_meta(get_the_id(), 'cinema_listing_city', true)) : ?>
                        <div class="col-md-12">
                            <h5><i class="fa fa-money"></i> Nearest City With State</h5>
                            <p>
                                <?php echo get_post_meta(get_the_id(), 'cinema_listing_city', true); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        <?php if (get_post_meta(get_the_id(), 'cinema_listing_ratings', true)) : ?>
                        <div class="col-md-12">
                            <h5><i class="fa fa-money"></i> Rating</h5>
                            <p>
                                <?php echo get_post_meta(get_the_id(), 'cinema_listing_ratings', true); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

</section>

<hr>

<?php get_footer(); ?>