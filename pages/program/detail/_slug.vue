<template>
  <div v-html="pageContent"></div>
</template>

<script>
import {getOpenGraphMeta} from '../../../utils/functions';

export default {
  name: 'ProgramDetail',

  data() {
    return {
    }
  },

  async asyncData({params, error, payload, store, $axios}) {
      if (payload) {
        const programDetail = payload.programDetail;
        const program = payload.program;

        return {
          program,
          programDetail
        }
      } else {
        await store.dispatch("getProgram");

        const program = store.state.program;
        const programDetail = [...store.state.program].filter(item => item.slug == params.slug)[0];        

        return {
          program,
          programDetail
        }
      }
  },

  computed: {
    title() {
      if( !this.programDetail ) return;

      return this.programDetail.title.rendered;
    },

    pageContent() {
      if( !this.programDetail ) return;

      return this.programDetail.content.rendered;      
    },

    excerpt() {
      if( !this.programDetail) return;

      return this.programDetail.excerpt.rendered.replace(/<[^>]*>?/gm, '');      
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
