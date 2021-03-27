<template>
  <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
      <div class="fcrse_1">
      <a :href="post.link" target="_blank" class="fcrse_img">
          <img :src="getImageUrl(post.image)" :alt="post.title" style="height:200px;" />
          <div class="course-overlay">
              <div class="badge_seller" v-if="isNewPost(post.date)">{{ isNewPost(post.date) ? 'NEW' : '' }}</div>
          </div>
      </a>
      <div class="fcrse_content">
          <div class="vdtodt">
          <span class="vdt14">
              <i class="fa fa-user"></i> {{ post.author }}</span>
              <i class="fa fa-clock"></i> {{ getFormatedDate(post.date) }}</span>
          </div>
          <a :href="post.link" target="_blank" class="crse14s">{{ post.title }}</a>
          <a :href="post.link" target="_blank" class="crse-cate" style="height: 100px;">{{ post.description }}</a>
      </div>
      </div>
  </div>
</template>
<script>
import moment from 'moment';

const default_layout = "default";

export default {
  props: ['post'],
  computed: {},
  data() {
      return {
          post: this.post.body
      }
  },
  methods: {
      getImageUrl(image) {
        return image ? image : '/img/default-blog.png'
      },
      getFormatedDate(date) {
        return moment(String(date)).format('MMM DD, YYYY')
      },
      isNewPost(date) {
        const nowDate = new Date()
        const postDate = new Date(date)
        return ( (nowDate - postDate) /1000/60/60/24 ) < 14 ? true : false
      }
  }
};
</script>