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

      return homepage[0]?.content?.rendered;
    },

    excerpt() {
      if ( !this.pages ) return;

      const homepage = this.pages.filter( item => {
        const url = this.$i18n.locale == 'en' ? this.$config.apiBaseUrl + 'en/' : this.$config.apiBaseUrl;
        return item.link == url;
      })

      return homepage[0]?.excerpt?.rendered.replace(/<[^>]*>?/gm, '');
    }

  },

  head() {
    const openGraphMetaArr = getOpenGraphMeta({
      site_name: this.$config.globalTitle,
      title: `${this.title} — ${this.$config.globalTitle}`,
      description: this?.excerpt,
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

<style lang="scss">
@import '~/assets/scss/variables';


.homepage-title {
  display: flex;
  align-items: flex-start;
  justify-content: flex-end;
  text-align: left;
  flex-direction: column;
  & > br {
    display: none;
  }

  & * {
    font-size: clamp(50px, 15vw, 80px);
    line-height: .95;

    @include media-up(lg) {
      font-size: clamp(80px, 11vw, 170px)
    }
  }

}



</style>
