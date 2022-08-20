<template>
  <div v-html="pageContent"></div>
</template>

<script>
import {getOpenGraphMeta} from '../../utils/functions';

export default {
  data() {
    return {
    }
  },

  async asyncData({params, error, payload, store, $axios}) {
      if (payload) {
        const courseDetail = payload.courseDetail;
        const courses = payload.courses;

        return {
          courses,
          courseDetail
        }
      } else {
        await store.dispatch("getCourses");

        const courses = store.state.courses;
        const courseDetail = [...store.state.courses].filter(item => item.slug == params.slug)[0];        

        return {
          courses,
          courseDetail
        }
      }
  },

  computed: {
    title() {
      if( !this.courseDetail ) return;

      return this.courseDetail.title.rendered;
    },

    pageContent() {
      if( !this.courseDetail ) return;

      return this.courseDetail.content.rendered;      
    }
  },

  head() {

    const openGraphMetaArr = getOpenGraphMeta({
      site_name: this.$config.globalTitle,
      title: `${this.title} — ${this.$config.globalTitle}`,
      description: this.$t('seo.description'),
      url: this.$config.baseURL.production,
      type: 'website',
      mainImage: `/project-main-image.png`
    });

    return {
      title: `${this.title} — ${this.$config.globalTitle}`,        
      meta: [
        ...openGraphMetaArr,
      ],
    }
  }
}
</script>
