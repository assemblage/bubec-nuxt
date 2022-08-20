<template>
  <div>
    <h1 class="text-xl 2xl:text-2xl tracking-tight text-center mt-[30vh]">Program</h1>

    <nav class="max-w-3xl text-base px-4 sm:px-6 lg:px-8 mx-auto flex flex-wrap justify-center items-center space-x-8 my-20">
      <button :class="[selectedCategory == 'all' ? '' : 'opacity-40 hover:opacity-100 transition']" @click="selectedCategory = 'all'">Vše</button>

      <NuxtLink :to="`/program/${item.slug}/`" v-for="(item, index) in programCategories" :key="index" :class="[selectedCategory == item.id ? '' : 'opacity-40 hover:opacity-100 transition']">
        {{ item.name }}
      </NuxtLink>
    </nav>

    <nav class="max-w-3xl text-base px-4 sm:px-6 lg:px-8 mx-auto flex justify-center items-center space-x-8 my-20">
      <button v-for="(item, index) in years" :key="index" :class="[selectedYear == item ? '' : 'opacity-40 hover:opacity-100 transition']" @click="selectedYear = item">
        {{ item }}
      </button>
    </nav>

    <section v-for="(program, monthName) in filteredProgram" :key="monthName" v-show="program.length > 0" ref="months" class="scroll-mt-40">
      <h2 class="text-center text-xl 2xl:text-2xl tracking-tight capitalize">{{ monthName }}</h2> 

      <div class="px-4 sm:px-6 lg:px-8 gap-8 flex flex-wrap my-20">

        <NuxtLink :to="getLink(item)" class="has-white-background-color has-grey-border-color border py-6 px-10 basis-1/4 flex flex-col text-center min-h-[21rem]" v-for="(item, index) in sortProgram(program)" :key="index">
          <h3 class="text-base font-bold basis-12">{{ item.title.rendered }}</h3>

          <span class="flex flex-1 items-center justify-center text-xl 2xl:text-2xl tracking-tight">{{ getFormattedDate(item) }}</span>

          <span class="text-base font-bold">{{ getCategoryName(item) }}</span>
        </NuxtLink> 

      </div>
    </section>

    <p v-if="filteredProgramTotal == 0" class="text-base text-center">Pro zvolené parametry jsme nenašli žádný program&hellip;</p>


  </div>
</template>

<script>
import {getOpenGraphMeta} from '../../utils/functions';

export default {
  name: 'Program',

  data() {
    return {
      selectedYear: 0,
      selectedCategory: 'all',
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

    getLink( item ) {
      return `/program/detail/${item.slug}/`;
    },

    getFormattedDate( item ) {
        const date = new Date(item.acf.event_date);

        return ("" + date.getDate()).slice(-2)+ "/" + ("" + (date.getMonth()+1)).slice(-2);
    },

    getCategoryName( item ) {
      if( !this.programCategories ) return;

      return this.programCategories.filter( cat => {
        return cat.id == item.program_type[0]
      })[0].name;
    },
    
    sortProgram( program ) {
      if( program.length == 0 ) return;
      program.sort((a, b) => {
        const aDate = new Date(a.acf.event_date).getTime();
        const bDate = new Date(b.acf.event_date).getTime();

        if( aDate < bDate ) {
          return -1;
        }

        if( aDate > bDate ) {
          return 1
        }

        return 0;
      })
      return program;
    },
  },

  computed: {
    title() {
      return 'Program';
    },

    years() {
      if ( !this.program ) return;

      const years = this.program.map( item => {
        const date = new Date(item.acf.event_date);
        const options = { year: 'numeric' };

        return date.toLocaleDateString("cs-CZ", options);
      });

      const sortedYears = [...new Set(years)].sort().reverse()

      this.selectedYear = sortedYears[0];

      return sortedYears;
    },

    filteredProgram() {
      if( !this.program || !this.selectedYear ) return;

      const program = this.program.filter( item => {
        const date = new Date(item.acf.event_date);
        const options = { year: 'numeric' };

        const year = date.toLocaleDateString("cs-CZ", options);  

        if( this.selectedCategory == 'all' ) {
          return year == this.selectedYear;
        } else {
          return year == this.selectedYear && item.program_type[0] == this.selectedCategory;
        }       
      });

      const programByMonths = {
        'leden': [],
        'únor': [],
        'březen': [],
        'duben': [],
        'květen': [],
        'červen': [],
        'červenec': [],
        'srpen': [],
        'září': [],
        'říjen': [],
        'listopad': [],
        'prosinec': []
      };

      program.forEach( item => {
        const date = new Date(item.acf.event_date);
        const options = { month: 'long' };

        const monthName = date.toLocaleDateString("cs-CZ", options); 

        programByMonths[monthName].push(item);
      });

      return programByMonths;
    },

    filteredProgramTotal() {
      if( !this.program || !this.selectedYear ) return;

      let total = 0;

      Object.values(this.filteredProgram).forEach( item => {
        total += item.length;
      });

      return total;
    }
  },

  mounted() {
    const currentMonth = new Date().getMonth();

    this.$refs.months[currentMonth].scrollIntoView({behavior: "smooth"});
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
