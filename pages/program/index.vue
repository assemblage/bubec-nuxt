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

  async asyncData({params, error, payload, store, $axios}) {
      if (payload) {
        const program = payload.program;
        const programCategories = payload.programCategories;

        return {
          program,
          programCategories
        }
      } else {
        await store.dispatch("getProgram");
        await store.dispatch("getProgramCategories");

        const program = store.state.program;  
        const programCategories = store.state.programCategories; 

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
