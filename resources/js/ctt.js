import Vue from 'vue'

import CoachingBlogList from './components/CoachingBlogList.vue'

const coachingBlog = new Vue({
    el: '#coaching-blog',
    components: { 'coaching-blog-list': CoachingBlogList }
});