<template>
<div class="la5lo1">
      <div v-if="loading" class="coaching-blog-loading">
        Loading...
      </div>
      <div v-else class="owl-carousel1 courses_performance1 owl-theme1">
      
          <div class="row">

              <coaching-blog-item v-for="post in posts" :post="post" v-bind:key="post.id"></coaching-blog-item>
              
              <div class="col-xl-12 col-lg-12 col-md-12 text-center mt-5 mb-5">
                  <a href="https://coach-to-transformation.com/coaching-blog/" target="_blank" class="btn btn-primary bg-theme2 border-0">View More Posts</a>
              </div>
              
          </div>
      </div>
  </div>
</template>
<script>
import axios from 'axios';

import coachingBlogItem from './CoachingBlogItem.vue';

const default_layout = "default";

export default {
  components: {
      'coaching-blog-item': coachingBlogItem 
  },
  computed: {},
  data() {
      return {
            loading: false,
            posts: null,
            error: null,
      }
  },
  created() {
      this.fetchData();
  },
  methods: {
      fetchData() {
          this.error = this.posts = null;
          this.loading = true;
          axios
              .get('https://coach-to-transformation.com/wp-json/wl/v1/posts')
              .then(response => {
                  this.loading = false;
                  this.posts = response.data;
              }).catch(error => {
                  this.loading = false;
                  this.error = error.response.data.message || error.message;
              });
      }
  }
};
</script>