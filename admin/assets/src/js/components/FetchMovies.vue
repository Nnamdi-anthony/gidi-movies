<template>
    <section id="grabber">
      <section v-if="showSearch == 'on' || showSearch == 'true'" class="search-movies">
          <div class='center-search-bar'>
              <form class='search-movie-form' method="post" v-on:submit.prevent="searchForMovie">
                  <!-- <input type="text" v-on:change="searchForMovie()" v-model="searchText" class="search-movie-text" name="search-movie-text" placeholder="Enter the Name of a Movie ..."/> -->
                  <input type="text" v-model="searchText" class="search-movie-text" name="search-movie-text" placeholder="Enter the Name of a Movie ..."/>
                  <button type="button" class="search-movie-button" v-on:click="searchForMovie()"> Search For Movie </button> 
              </form>
          </div>
      </section>

      <!-- main data -->
      <section class='fetch-movies'>
          <div class="gm-container clip">

            <section class="gm-container" v-if="heading && !searchText">
              <h1 style="text-align:center; text-transform:capitalize;font-weight:bold;">
                {{heading}}
              </h1>
            </section>

            <section class="gm-container" v-if="searchText">
              <h1 style="text-align:center; text-transform:capitalize;font-weight:bold;">
                Please wait, Searching For "{{searchText}}"
              </h1>
            </section>

            <section class="gm-container gimme-space-top" v-if="showMeta">
                <section class="take-left">
                  <h4 class="take-space lh-2">
                    <strong>Page</strong> {{dataFromAPI.page}} <strong> of </strong> {{dataFromAPI.total_pages}} | <strong>Total Results Found: </strong> {{dataFromAPI.total_results}}
                  </h4>
                </section>
                <section class="take-right">
                  <button v-on:click="viewPrev()" class="button button-secondary" v-if="pageCount > 1"> Previous </button>
                  <button disabled class="button button-secondary" v-else> Previous </button>
                  <button disabled class="button button-secondary" v-if="dataFromAPI.page == dataFromAPI.total_pages"> Next </button>
                  <button v-on:click="viewNext()" class="button button-secondary" v-else> Next </button>
                </section>
            </section>

            <hr>
            
            <!-- if there is a result to show -->
              <div class="gm-row" v-if="dataFromAPI.results && !showSpinner">
                  <div class="single-movie-column" v-for="item in dataFromAPI.results" v-bind:key="item.id">
                      <div class="card-columns">
                          <div class="take-it-left">
                              <img v-bind:src="getThumbnail(item.poster_path)" alt="" title="" class="responsive-image"/>
                          </div>
                          <div class="take-it-right">
                              <div class="heading">
                                  <h2> {{ item.title }} </h2>
                              </div>
                              <div class="content">
                                  <p> {{item.overview}} </p>
                              </div>
                              <div class="action-buttons">
                                  <button v-on:click="createMovie(item)" title="Create & Publish This Movie" class="button button-secondary action-button"> <i class="fas fa-check"></i> Publish Movie </button>
                                  <button v-on:click="viewMovie(item.id, true)" title="View This Movie On the Original Site" class="button button-secondary action-button"> <i class="fas fa-external-link-alt"></i> View Movie </button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- spit this out if not result is found -->
              <div class="" v-else>
                  <spin-kit></spin-kit>
              </div>

              <div class="gm-container">
                <hr>

              <section class="gm-container gimme-space-top" v-if="showMeta">
                <section class="take-left">
                  <h4 class="take-space lh-2">
                    <strong>Page</strong> {{dataFromAPI.page}} <strong> of </strong> {{dataFromAPI.total_pages}} | <strong>Total Results Found: </strong> {{dataFromAPI.total_results}}
                  </h4>
                </section>
                <section class="take-right">
                  <button v-on:click="viewPrev()" class="button button-secondary" v-if="pageCount > 1"> Previous </button>
                  <button disabled class="button button-secondary" v-else> Previous </button>
                  <button disabled class="button button-secondary" v-if="dataFromAPI.page == dataFromAPI.total_pages"> Next </button>
                  <button v-on:click="viewNext()" class="button button-secondary" v-else> Next </button>
                </section>
            </section>
              </div>
              
          </div>
      </section>
    </section>
</template>

<script>
import Axios from "axios";
import * as config from "./../config";
import * as swal from "sweetalert2";

export default {
  props: {
    url: {
      default: "/movie/top_rated",
      type: String
    },
    movieType: {
      default: "Hollywood Movies",
      type: String
    },
    heading: {
      default: "Movie Results",
      type: String
    },
    showMeta: {
      default: true,
      type: Boolean
    },
    showSearch: {
      default: "off",
      type: String
    }
  },
  data: function() {
    return {
      checkResults: "",
      pageCount: 1,
      showSpinner: false,
      searchText: "",
      debugData: "",
      apiUrl:
        config.tmdb_url +
        this.url +
        "?language=en-US&api_key=" +
        config.tmdb_key,
      searchUrl: "",
      dataFromAPI: ""
    };
  },
  methods: {
    searchForMovie: async function() {
      this.showSpinner = true;

      if (this.searchText !== "") {
        this.apiUrl =
          config.tmdb_url +
          "/search/movie?api_key=" +
          config.tmdb_key +
          "&language=en-US&query=" +
          this.searchText +
          "&page=1&include_adult=false";
      } else {
        this.apiUrl =
          config.tmdb_url +
          this.url +
          "?language=en-US&api_key=" +
          config.tmdb_key;
      }

      this.dataFromAPI = [];
      await Axios.get(this.apiUrl)
        .then(
          result => {
            this.showSpinner = false;
            this.dataFromAPI = result.data;
          },
          error => {
            console.log(error);
          }
        )
        .catch(err => {
          console.log("yep another result here");
        });
    },
    getThumbnail: function(imageID = "") {
      return config.tmdb_image_url_fast + "/" + imageID;
    },
    createMovie: async function(movie = "", type = "", statusType = "publish") {
      // place a default from the users options
      type = this.movieType;

      // show a loading screen
      swal({
        title: "Please Wait...",
        text: "Creating Movies, Dont Click Anything Else... Thanks",
        showCancelButton: false,
        showLoaderOnConfirm: false,
        showCloseButton: false,
        onOpen: () => {
          swal.showLoading();
        }
      });

      // creating movies 
      await Axios({ 
        url: gidi_movies.admin_ajax_url,
        data: { 
          movie_id: movie.id,
          post_type: statusType,
          movie_type: type,
          action: "create_movies",
          nounce: gidi_movies.gm_nounce
        },
        method: "POST"
      })
        .then(
          result => {
            console.log(result.data);
            swal(result.data.title, result.data.body, result.data.type);
          },
          err => {
            console.log(err);
          }
        )
        .catch(error => {
          console.log(error);
        });
    },
    viewMovie: function(movieID = "") {
      var win = window.open(
        "https://www.themoviedb.org/movie/" + movieID,
        "_blank"
      );
      win.focus();
    },
    viewNext: function() {
      this.dataFromAPI = [];

      Axios.get(this.apiUrl + "&page=" + ++this.pageCount)
        .then(
          result => {
            this.dataFromAPI = result.data;
          },
          error => {
            console.log(error);
          }
        )
        .catch(err => {
          console.log("yep another result here");
        });
    },
    viewPrev: function() {
      this.dataFromAPI = [];

      Axios.get(this.apiUrl + "&page=" + --this.pageCount)
        .then(
          result => {
            this.dataFromAPI = result.data;
          },
          error => {
            console.log(error);
          }
        )
        .catch(err => {
          console.log("yep another result here");
        });
    }
  },
  created: async function() {
    this.dataFromAPI = [];
    this.showSpinner = true;

    await Axios.get(this.apiUrl)
      .then(
        result => {
          this.showSpinner = false;
          this.dataFromAPI = result.data;
        },
        error => {
          console.log(error);
        }
      )
      .catch(err => {
        console.log("yep another result here");
      });
  }
};
</script>

<style lang="scss">
/**
 *==================================
 * styles for this component
 *==================================
 */
$gm_base_color: #d31f0d;
$secondary-color: #333; // grid configs
$max_columns: 12;
$mq-breakpoints: (
  mobile: 320px,
  tablet: 740px,
  desktop: 980px,
  wide: 1300px
); // impor the vendors styles
@import "~compass-mixins/lib/compass";
@import "~bourbon/core/bourbon";
@import "~bourbon-neat/core/neat";
@import "~mq-sass/stylesheets/mq-sass";
@import "~sass-mq/mq";
::-webkit-scrollbar {
  width: 5px;
}
/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
  /* Handle on hover */
  &:hover {
    background: #555;
  }
}
.gm-container {
  @include grid-container;
  // @include legacy-pie-clearfix();
  // @include pie-clearfix();
  // @include clearfix();
  clear: both;
  &.space {
    @include padding(null 20px);
  }
  &.clip {
    overflow: hidden;
  }
  .gm-row {
    @include grid-collapse;
    &.space {
      @include padding(null 20px);
    }
  }
  .single-movie-column {
    @include grid-column(12);
    @include mq($from: tablet) {
      @include grid-column(6);
    }
    @include mq($from: desktop) {
      @include grid-column(3);
    }
  }
}
.single-movie-column {
  @include margin(10px null);
  background: #fff;
  max-height: 520px;
  min-height: 520px;
  border: 1px solid #ccc;
  .card-columns {
    @include padding(10px);
    .responsive-image {
      max-height: 300px;
      min-height: 100px;
      min-width: 100%;
    }
    .content {
      max-height: 100px;
      overflow: hidden;
      overflow-y: scroll;
      @include margin(5px auto); /* width */
      line-height: 1.5em;
    }
    .heading {
      max-height: 50px;
      overflow: hidden;
    }
  }
  .action-buttons {
    margin: auto;
    text-align: center;
    button {
      text-align: center;
      // width: 23%;
      margin: auto;
    }
  }
}
.center-search-bar {
  @include padding(20px null);
  @include margin(10px auto);
  @include grid-container;
  background-color: rgba(black, 0.2);
  h3 {
    @include grid-column(12);
    text-align: center;
    font-size: 2em;
  }
  %common_prop {
    @include padding(20px 10px);
    @include border-width(1px);
    @include border-style(solid);
    @include border-color(#cccccc);
    border-radius: 3px;
    text-transform: uppercase;
    @include grid-column(12);
  }
  .search-movie-text {
    @include mq($from: tablet) {
      @include grid-column(9);
    }
    @extend %common_prop;
  }
  .search-movie-button {
    @include mq($from: tablet) {
      @include grid-column(3);
    }
    @extend %common_prop;
    cursor: pointer;
    background-color: $gm_base_color;
    color: contrast-switch($secondary-color);
  }
}
</style>