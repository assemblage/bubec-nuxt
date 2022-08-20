<template>
  <div v-html="homepageContent"></div>
</template>

<script>
import {getOpenGraphMeta} from '../utils/functions';
import { mapState } from 'vuex';

export default {
  data() {
    return {
       title: `Úvod`,
    }
  },

  computed: {
    ...mapState(['pages']),

    homepageContent() {
      if ( !this.pages ) return;

      const homepage = this.pages.filter( item => {
        return item.link == this.$config.apiBaseUrl
      })

      return homepage[0].content.rendered;
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
