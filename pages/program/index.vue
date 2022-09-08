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
  name: 'Program',

  components: {
    ProgramFilters,
    ProgramList
  },

  data() {
    return {
      selectedCategory: 'all'
    }    
  },

  async asyncData({app, params, error, payload, store, $axios}) {
      if (payload) {
        let program = payload.program;
        let programCategories = payload.programCategories;

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
          programCategories
        }
      } else {
        await store.dispatch("getProgram");
        await store.dispatch("getProgramCategories");

        let program = store.state.program;  
        let programCategories = store.state.programCategories; 

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
          programCategories
        }
      }
  },

  methods: {
  },

  computed: {
    title() {
      return 'Program';
    },
  },

  mounted() {
    /*
    const currentMonth = new Date().getMonth();

    this.$refs.months[currentMonth].scrollIntoView({behavior: "smooth"});*/
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
