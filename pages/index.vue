<template>
  <div v-html="homepageContent"></div>
</template>

<script>
import {getOpenGraphMeta} from '../utils/functions';
import { mapState } from 'vuex';

export default {
  name: 'Homepage',

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
        const url = this.$i18n.locale == 'en' ? this.$config.apiBaseUrl + 'en/' : this.$config.apiBaseUrl;
        return item.link == url;
      })

      return homepage[0].content.rendered;
    },

    excerpt() {
      if ( !this.pages ) return;

      const homepage = this.pages.filter( item => {
        const url = this.$i18n.locale == 'en' ? this.$config.apiBaseUrl + 'en/' : this.$config.apiBaseUrl;
        return item.link == url;
      })

      return homepage[0].excerpt.rendered.replace(/<[^>]*>?/gm, '');      
    }

  },

  head() {

    const openGraphMetaArr = getOpenGraphMeta({
      site_name: this.$config.globalTitle,
      title: `${this.title} — ${this.$config.globalTitle}`,
      description: this.excerpt,
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
