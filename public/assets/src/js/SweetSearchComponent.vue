<template>
  <div class="search-for-movie-bar movies-search-form">
    <div class="container">
      <div class="row">
        <form :action="siteUrl + '/view-all-movies'">
          <input type="hidden" name="cstm_lovad" value="search_in">
          <div class="col-md-4">
            <div class="autocomplete">
              <input
                type="text"
                name="movie_name"
                id="movie_name"
                class="form-control"
                placeholder="Type Movie Name"
                v-model="movie_name"
                @input="onChange"
                autocomplete="off"
                @keydown.esc="focusout"
              >
              <ul class="autocomplete-results" v-show="isOpen">
                <li
                  class="autocomplete-result"
                  v-for="item in movie_name_results"
                  :key="item.id"
                  @click="setResult(item.name)"
                >{{item.name}}</li>
              </ul>
            </div>
          </div>
          <div class="col-md-3">
            <select name="movie_type" id="movie_type" class="form-control">
              <option value>Choose Movie Type</option>
              <option
                v-if="movie_types"
                :value="item.id"
                v-for="item in movie_types"
                :key="item.id"
              >{{item.name}}</option>
            </select>
          </div>
          <div class="col-md-3">
            <select name="movie_genre" id="movie_genre" class="form-control">
              <option value>Choose Movie Genre</option>
              <option
                v-if="movie_genres"
                :value="item.id"
                v-for="item in movie_genres"
                :key="item.id"
              >{{item.name}}</option>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="gh-button-roundeds button">{{button_name}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.search-for-movie-bar {
  margin-top: -300px !important;

  .form-control {
    background-color: white !important;
  }

  .autocomplete {
    position: relative;
    width: 100%;

    &-results {
      padding: 0;
      margin: 0;
      border: 1px solid #eeeeee;
      max-height: 120px;
      overflow: auto;
      background-color: white;
      position: absolute;
      width: 100%;
      z-index: 999;
    }

    &-result {
      list-style: none;
      text-align: left;
      padding: 4px 2px;
      cursor: pointer;
      :hover {
        background-color: #d31f0d;
        color: white;
      }
    }
  }
}
</style>


<script>
import Axios from "axios";

export default {
  data: function() {
    return {
      siteUrl: gidi_movies.site_url,
      movie_name: null,
      movie_name_results: null,
      movie_names: null,
      isOpen: false,
      movie_genres: null,
      movie_types: null,
      button_name: "Search For Movie"
    };
  },
  methods: {
    onChange: function() {
      this.isOpen = true;
      this.filterResults();
      console.log(this.movie_name_results);
    },
    setResult: function(result) {
      this.movie_name = result;
      this.isOpen = false;
    },
    filterResults: function() {
      this.movie_name_results = this.movie_names.filter(
        item =>
          item.name.toLowerCase().indexOf(this.movie_name.toLowerCase()) > -1
      );
    },
    focusout: function() {
      this.isOpen = false;
    },
    getMovieTypes: function() {
      Axios({
        url: gidi_movies.admin_ajax_url,
        data: {
          action: "get_movie_types",
          nounce: gidi_movies.gm_nounce
        },
        method: "POST"
      })
        .then(
          result => {
            // console.log(result.data);
            this.movie_types = result.data;
          },
          err => {
            console.log(err);
          }
        )
        .catch(error => {
          console.log(error);
        });
    },
    getMovieNames: function() {
      Axios({
        url: gidi_movies.admin_ajax_url,
        data: {
          action: "get_movie_names",
          nounce: gidi_movies.gm_nounce
        },
        method: "POST"
      })
        .then(
          result => {
            // console.log(result.data);
            this.movie_names = result.data;
          },
          err => {
            console.log(err);
          }
        )
        .catch(error => {
          console.log(error);
        });
    },
    getUrlParameter: function(name) {
      name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
      var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
      var results = regex.exec(location.search);
      return results === null
        ? ""
        : decodeURIComponent(results[1].replace(/\+/g, " "));
    },
    getMovieGenres: function() {
      Axios({
        url: gidi_movies.admin_ajax_url,
        data: {
          action: "get_movie_genres",
          nounce: gidi_movies.gm_nounce
        },
        method: "POST"
      })
        .then(
          result => {
            this.movie_genres = result.data;
          },
          err => {
            console.log(err);
          }
        )
        .catch(error => {
          console.log(error);
        });
    }
  },
  mounted: function() {
    this.getMovieTypes();
    this.getMovieGenres();
    this.getMovieNames();
  }
};
</script>
