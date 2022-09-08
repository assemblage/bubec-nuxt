<template>
  <div>
    <ProgramFilters :program="program" :programCategories="programCategories" :selectedCategory="selectedCategory" />

    <ProgramList :program="program" :programCategories="programCategories" :selectedCategory="selectedCategory" />
  </div>
</template>

<script>
import {getOpenGraphMeta} from '../../utils/functions';
import ProgramFilters from '../../components/ProgramFilters.vue';
import ProgramList from '../../components/ProgramList.vue';

export default {
  name: 'ProgramCategory',

  components: {
    ProgramFilters,
    ProgramList
  },

  data() {
    return {
    }
  },

  async asyncData({app, params, error, payload, store, $axios}) {
      if (payload) {
        let program = payload.program;
        let programCategories = payload.programCategories;
        const categoryDetail = payload.categoryDetail;

        program = program.filter( item => {
          if( app.i18n.locale == 'en' ) {
            return item.link.indexOf('/en/') !== -1;
          } else {
            return item.link.indexOf('/en/') == -1;
          }
        });

        programCategories = programCategories.filter( item => {
          if( app.i18n.locale == 'en' ) {
            return item.link.indexOf('/en/') !== -1;
          } else {
            return item.link.indexOf('/en/') == -1;
          }
        });

        return {
          program,
          programCategories,
          categoryDetail
        }
      } else {
        await store.dispatch("getProgram");
        await store.dispatch("getProgramCategories");

        let program = store.state.program;  
        let programCategories = store.state.programCategories; 
        const categoryDetail = [...store.state.programCategories].filter(item => item.slug == params.slug)[0];

        program = program.filter( item => {
          if( app.i18n.locale == 'en' ) {
            return item.link.indexOf('/en/') !== -1;
          } else {
            return item.link.indexOf('/en/') == -1;
          }
        });

        programCategories = programCategories.filter( item => {
          if( app.i18n.locale == 'en' ) {
            return item.link.indexOf('/en/') !== -1;
          } else {
            return item.link.indexOf('/en/') == -1;
          }
        });

        return {
          program,
          programCategories,
          categoryDetail
        }
      }
  },

  computed: {
    title() {
      return this.categoryDetail.name;
    },
    selectedCategory() {
      return this.categoryDetail.id;
    }
  },

  mounted() {
    /*
    this.selectedCategory = this.programCategories.filter( item => {
      return item.slug == this.$route.params.slug
    })[0].id;*/
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
