
<h2>Auto Scrap and Import Movie Genres, Movie Types and Popular Cinema Locations</h2>
<p>
    Click the Buttons One After the OTher To Automatically Fetch Data and Import them to the WP Database For Use.
</p>
<div id="gidi-movies-settings">
    
    <table class="form-table">
        <tbody>
            <tr class="gidi_movies_api_key_row">
                <th scope="row">
                    <label for="gidi_movies_api_key">Movie Genres</label>
                </th>
                <td>
                    <!-- <button v-on:click="importMovieGenres" type="button" name="submit" id="get_movie_genres" class="button button-primary">Import Movie Genres</button> -->
                    <button v-on:click="createMovieGenres" type="button" id="get_movie_genres" class="button button-primary">Import Movie Genres</button>
                    <p class="description">
                        <span>Fetch and Import Movie Genres from the TMDB API ?</span>
                    </p>
                </td>
            </tr>
            <tr class="gidi_movies_user_must_register_row">
                <th scope="row">
                    <label for="gidi_movies_user_must_register">Movie Types</label>
                </th>
                <td>
                    <!-- <button v-on:click="importMovieTypes" type="button" id="get_movie_types" class="button button-primary">Import Movie Types</button> -->
                    <button v-on:click="createMovieTypes" type="button" id="get_movie_types" class="button button-primary">Import Movie Types</button>
                    <p class="description">
                        <span>Fetch and Import Movie Types ?</span>
                    </p>
                </td>
            </tr>
            <tr class="gidi_movies_show_scrapping_menu_row">
                <th scope="row">
                    <label for="gidi_movies_show_scrapping_menu">Cinema Locations</label>
                </th>
                <td>
                    <!-- <button v-on:click="importCinemaLocations" type="button" id="get_cinema_locations" class="button button-primary">Import Cinema Locations</button> -->
                    <button v-on:click="createCinemaLocations" type="button" id="get_cinema_locations" class="button button-primary">Import Cinema Locations</button>
                    <p class="description">
                        <span>Fetch and Import Cinema Locations ?</span>
                    </p>
                </td>
            </tr>

            <tr class="gidi_movies_show_scrapping_menu_row">
                <th scope="row">
                    <label for="gidi_movies_show_scrapping_menu">Import Movies</label>
                </th>
                <td>
                    <!-- <button v-on:click="importCinemaLocations" type="button" id="get_cinema_locations" class="button button-primary">Import Cinema Locations</button> -->
                    <button v-on:click="importProductTypeMovies" id="get_cinema_locations" type="button" class="button button-primary">Import Movies</button>
                    <p class="description">
                        <span>Fetch and Import Product Type Movies to Post Type Movies ?</span>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>