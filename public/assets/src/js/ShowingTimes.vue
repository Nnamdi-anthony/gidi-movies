<template>
  <div class="now-showing-time">
    <h3>Showing Times For This Movie</h3>
    <div class="table-responsive">
      <table class="table table-striped text-left">
        <thead>
          <tr>
            <th>#</th>
            <th>Cinema Details</th>
            <th>Ticket Price</th>
            <th>Showing Time + Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>12</td>
            <td>John</td>
            <td>John</td>
            <td>John</td>
            <td>
              <buy-now></buy-now>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style lang="scss">
</style>

<script>
export default {
  props: {
    movie_id: {
      type: String
    },
    movie_name: {
      type: String
    }
  },
  data: function() {
    return {
      totalData: null,
      showing_times: ""
    };
  },
  methods: {},
  created: function() {
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
          this.showing_times = result.data;
          console.log(result);
        },
        err => {
          console.log(err);
        }
      )
      .catch(error => {
        console.log(error);
      });
  }
};
</script>
