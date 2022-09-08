<template>
  <div>
    <section v-for="(program, monthName) in filteredProgram" :key="monthName" v-show="program.length > 0" ref="months" class="scroll-mt-40">
      <h2 class="text-center text-xl lg:text-1xl xl:text-2xl tracking-tight capitalize">{{ monthName }}</h2> 

      <div class="px-4 sm:px-6 lg:px-8 gap-8 flex flex-wrap justify-center lg:justify-start my-20">

        <NuxtLink :to="getLink(item)" class="has-white-background-color has-grey-border-color border py-6 px-2 basis-1/4 flex flex-col text-center min-w-[18rem] min-h-[18rem] 2xl:basis-auto md:min-w-[20rem] md:min-h-[20rem] 2xl:!min-h-[22rem] 2xl:!min-w-[22rem] 3xl:!min-h-[26rem] 3xl:!min-w-[26rem]" v-for="(item, index) in sortProgram(program)" :key="index">
          <h3 class="text-sm lg:text-base font-bold basis-12" v-html="item.title.rendered.replace('–','<br>')"></h3>

          <span class="flex flex-1 items-center justify-center text-xl 2xl:text-2xl tracking-tight md:font-light">{{ getFormattedDate(item) }}</span>

          <span class="text-sm lg:text-base font-bold">{{ getCategoryName(item) }}</span>
        </NuxtLink> 

      </div>
    </section>

    <p v-if="filteredProgramTotal == 0" class="text-base text-center" v-html="$t('noEvents')"></p>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'ProgramList',

  props: {
    programCategories: Array,
    program: Array,
    selectedCategory: [String, Number],
  },

  data() {
    return {
    }
  },

  methods: {
    getLink( item ) {
      return this.$i18n.locale == 'en' ? `/en/events/detail/${item.slug}/` : `/program/detail/${item.slug}/`;
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
    ...mapState(['programYear']),

    filteredProgram() {
      if( !this.program || !this.programYear ) return;

      const program = this.program.filter( item => {
        const date = new Date(item.acf.event_date);
        const options = { year: 'numeric' };

        const year = date.toLocaleDateString("cs-CZ", options);  

        if( this.selectedCategory == 'all' ) {
          return year == this.programYear;
        } else {
          return year == this.programYear && item.program_type[0] == this.selectedCategory;
        }       
      });

      let programByMonths = {};

      if( this.$i18n.locale == 'en' ) {
        programByMonths = {
          'january': [],
          'february': [],
          'march': [],
          'april': [],
          'may': [],
          'june': [],
          'july': [],
          'august': [],
          'september': [],
          'october': [],
          'november': [],
          'december': []
        };
      } else {
        programByMonths = {
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
      }

      program.forEach( item => {
        const date = new Date(item.acf.event_date);
        const options = { month: 'long' };

        const monthName = this.$i18n.locale == 'en' ? date.toLocaleDateString("en-GB", options).toLowerCase() : date.toLocaleDateString("cs-CZ", options);

        programByMonths[monthName].push(item);
      });

      return programByMonths;
    },

    filteredProgramTotal() {
      if( !this.program || !this.programYear ) return;

      let total = 0;

      Object.values(this.filteredProgram).forEach( item => {
        total += item.length;
      });

      return total;
    }
  },
}
</script>
