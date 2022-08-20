<template>
  <div v-html="pageContent"></div>
</template>

<script>
import {getOpenGraphMeta} from '../utils/functions';

export default {
  name: 'Page',

  data() {
    return {
    }
  },

  async asyncData({params, error, payload, store, $axios}) {
      if (payload) {
        const page = payload;

        return {
          page,
        }
      } else {
        await store.dispatch("getPages");

        const page = [...store.state.pages].filter(item => item.slug == params.slug)[0];

        if(!page) {
          error({ statusCode: 404 });
        }

        return {
          page,
        }
      }
  },

  computed: {
    title() {
      if( !this.page ) return;

      return this.page.title.rendered;
    },

    pageContent() {
      if( !this.page ) return;

      return this.page.content.rendered;      
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
