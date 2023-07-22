/*=============================================
=            settings setup page            =
=============================================*/

const config = require("./config");
const swal = require("sweetalert2");
const Axios = require("axios");
const Vue = require("vue");

/*=============================================
=            Helper Functions            =
=============================================*/

/**
 * Shows a error message to the user
 * @param {string} message message to tbe shown to the user
 * @param {string} title title to tbe show to the user
 */
function showErrorMessage(message = "Error Occurred", title = "Something went wrong!") {
    swal(title, message, 'error');
}

/*=====  End of Helper Functions  ======*/

const settingsPage = new Vue({
    el: "#gidi-movies-settings",
    methods: {
        createMovieGenres: function () {
            swal({
                title: "Please Wait...",
                text: "Creating Movie Genres, Dont Click Anything Else... Thanks",
                showCancelButton: false,
                showLoaderOnConfirm: false,
                showCloseButton: false,
                onOpen: () => {
                    swal.showLoading();
                }
            });

            Axios({
                    data: {
                        action: 'create_movies_genres',
                        nounce: gidi_movies.gm_nounce
                    },
                    url: gidi_movies.admin_ajax_url,
                    method: 'POST'
                })
                .then(response => {
                    swal(response.data.title, response.data.body, response.data.type);
                }, response => {
                    console.log(response);
                    showErrorMessage(response.data);
                });
        },
        createMovieTypes: function () {
            swal({
                title: "Please Wait...",
                text: "Creating Movie Types, Dont Click Anything Else... Thanks",
                showCancelButton: false,
                showLoaderOnConfirm: false,
                showCloseButton: false,
                onOpen: () => {
                    swal.showLoading();
                }
            });

            Axios({
                    data: {
                        action: 'create_movies_types',
                        nounce: gidi_movies.gm_nounce
                    },
                    url: gidi_movies.admin_ajax_url,
                    method: 'POST'
                })
                .then(response => {
                    swal(response.data.title, response.data.body, response.data.type);
                }, response => {
                    console.log(response);
                    showErrorMessage(response.data);
                });
        },
        createCinemaLocations: function () {
            swal({
                title: "Please Wait...",
                text: "Creating Cinema Locations, Dont Click Anything Else... Thanks",
                showCancelButton: false,
                showLoaderOnConfirm: false,
                showCloseButton: false,
                onOpen: () => {
                    swal.showLoading();
                }
            });

            Axios({
                    data: {
                        action: 'create_cinema_locations',
                        nounce: gidi_movies.gm_nounce
                    },
                    url: gidi_movies.admin_ajax_url,
                    method: 'POST'
                })
                .then(response => {
                    swal(response.data.title, response.data.body, response.data.type);
                }, response => {
                    console.log(response);
                    showErrorMessage(response.data);
                });
        },
        importProductTypeMovies: function () {
            swal({
                title: "Please Wait...",
                text: "Exporting and Importing Movies To Their New Locations, Dont Click Anything Else... Thanks",
                showCancelButton: false,
                showLoaderOnConfirm: false,
                showCloseButton: false,
                onOpen: () => {
                    swal.showLoading();
                }
            });

            Axios({
                    data: {
                        action: 'import_movies',
                        nounce: gidi_movies.gm_nounce
                    },
                    url: gidi_movies.admin_ajax_url,
                    method: 'POST'
                })
                .then(response => {
                    console.log(response.data);
                    swal(response.data.title, response.data.body, response.data.type);
                }, response => {
                    console.log(response);
                    showErrorMessage(response.data);
                });
        },
    }
});

/*=====  End of settings setup page  ======*/