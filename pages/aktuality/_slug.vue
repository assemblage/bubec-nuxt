<template>
  <div v-html="pageContent"></div>
</template>

<script>
import {getOpenGraphMeta} from '../../utils/functions';

export default {
  name: 'ArticleDetail',

  data() {
    return {
    }
  },

  async asyncData({params, error, payload, store, $axios}) {
      if (payload) {
        const articleDetail = payload.articleDetail;
        const articles = payload.articles;

        return {
          articles,
          articleDetail
        }
      } else {
        await store.dispatch("getArticles");

        const articles = store.state.articles;
        const articleDetail = [...store.state.articles].filter(item => item.slug == params.slug)[0];        

        return {
          articles,
          articleDetail
        }
      }
  },

  computed: {
    title() {
      if( !this.articleDetail ) return;

      return this.articleDetail.title.rendered;
    },

    pageContent() {
      if( !this.articleDetail ) return;

      return this.articleDetail.content.rendered;      
    },

    excerpt() {
      if( !this.articleDetail ) return;

      return this.articleDetail.excerpt.rendered.replace(/<[^>]*>?/gm, '');      
    }
  },
  
  head() {

    const openGraphMetaArr = getOpenGraphMeta({
      site_name: this.$config.globalTitle,
      title: `${this.title} — ${this.$config.globalTitle}`,
      description: this.excerpt || this.$t('seo.description'),
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
