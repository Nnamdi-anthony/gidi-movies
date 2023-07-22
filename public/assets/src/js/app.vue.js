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
  function(data, headers) {
    const serializedData = [];

    for (const k in data) {
      if (data[k]) {
        serializedData.push(`${k}=${encodeURIComponent(data[k])}`);
      }
    }

    return serializedData.join("&");
  }
];

// Global Components regs
Vue.component("buy-now", require("./BuyNowButton.vue"));

// start the vue app of searching for a film
const searchApp = new Vue({
  el: "#search-for-movies",
  components: {
    "search-movies-app": require("./SweetSearchComponent.vue")
  }
});

// start the vue app of showings times for a movie
const showingTimes = new Vue({
  el: "#cinema-showing-times",
  components: {
    "showing-times": require("./ShowingTimes.vue")
  }
});
