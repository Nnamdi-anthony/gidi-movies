export const wp_url = gidi_movies.root;
export const wp_nounce = gidi_movies.nonce;
export const tmdb_url = "https://api.themoviedb.org/3";
export const tmdb_key = gidi_movies.api_key;
export const importUrl = gidi_movies.gidi_movies_url + "admin/scripts/import-posts.php";

/**
 * get the image paths
 */
export const tmdb_image_url_fast = "https://image.tmdb.org/t/p/w500";
export const tmdb_image_url_slow = "https://image.tmdb.org/t/p/original";

/**
 * get the latest and the best genres
 */
export const genre_list = tmdb_url + "/genre/movie/list?language=en-US&api_key=" + tmdb_key;

/**
 * get the upcoming movies
 */
export const upcoming_movies = tmdb_url + "/movie/upcoming?language=en-US&api_key=" + tmdb_key;

/**
 * get the top rated movies
 */
export const top_rated_movies = tmdb_url + "/movie/top_rated?language=en-US&api_key=" + tmdb_key;

/**
 * get the popular movies dont forget to page the results
 * 
 * e.g &page=1
 */
export const popular_movies = tmdb_url + "/movie/popular?language=en-US&api_key=" + tmdb_key;

export const now_playing_movies = tmdb_url + "/movie/now_playing?language=en-US&api_key=" + tmdb_key;

export const latest_movies = tmdb_url + "/movie/latest?language=en-US&api_key=" + tmdb_key;