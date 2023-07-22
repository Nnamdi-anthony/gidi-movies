/*
.......##....###....##.....##....###.....######...######..########..####.########..########
.......##...##.##...##.....##...##.##...##....##.##....##.##.....##..##..##.....##....##...
.......##..##...##..##.....##..##...##..##.......##.......##.....##..##..##.....##....##...
.......##.##.....##.##.....##.##.....##..######..##.......########...##..########.....##...
.##....##.#########..##...##..#########.......##.##.......##...##....##..##...........##...
.##....##.##.....##...##.##...##.....##.##....##.##....##.##....##...##..##...........##...
..######..##.....##....###....##.....##..######...######..##.....##.####.##...........##...
*/

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our wordpress back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

const config = require("./config");
const Axios = require("axios");
const Vue = require("vue");

/*=============================================
=            Set the Default Headers for Axios            =
=============================================*/

// Axios.defaults.headers.common['X-WP-Nonce'] = config.wp_nounce;
// Axios.defaults.baseURL = config.wp_url + "wp/v2/";
/**
 * @todo Find a better work around for this hack
 */
Axios.defaults.transformRequest = [
    function (data, headers) {
        const serializedData = []

        for (const k in data) {
            if (data[k]) {
                serializedData.push(`${k}=${encodeURIComponent(data[k])}`)
            }
        }

        return serializedData.join('&')
    },
];

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component("spin-kit", require("./components/SpinKit.vue"));
Vue.component("fetch-movies", require("./components/FetchMovies.vue"));

const searchMoviesApp = new Vue({
    el: '#listing-movies-section'
});

require("./gidi-movies-admin-settings");