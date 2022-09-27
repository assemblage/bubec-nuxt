<template>
  <div class="relative pt-20">

    <div class="absolute top-0 elft-0 w-full h-[20rem] has-gradient-background-color has-background"></div>
    
    <section v-for="(program, monthName) in filteredProgram" :key="monthName" ref="months" class="scroll-mt-40 relative z-10">
      <div v-show="program.length > 0">
        <h2 class="text-center text-xl lg:text-1xl xl:text-2xl tracking-tight capitalize font-bold">{{ monthName }}</h2> 

        <div class="px-4 sm:px-6 lg:px-8 gap-8 flex flex-wrap justify-center lg:justify-start my-10 sm:my-20">

          <NuxtLink :to="getLink(item)" class="has-white-background-color has-grey-border-color border py-6 px-2 basis-1/4 flex flex-col text-center min-w-[18rem] min-h-[18rem] 2xl:basis-auto md:min-w-[20rem] md:min-h-[20rem] 2xl:!min-h-[22rem] 2xl:!min-w-[22rem] 3xl:!min-h-[26rem] 3xl:!min-w-[26rem]" v-for="(item, index) in sortProgram(program)" :key="index">
            <h3 class="text-sm lg:text-base font-bold basis-12" v-html="item.title.rendered.replace('–','<br>')"></h3>

            <span class="flex flex-1 items-center justify-center tracking-tight md:font-light" :class="[ item.acf.event_end ? 'text-lg xl:text-xl whitespace-nowrap' : 'text-1xl 2xl:text-2xl' ]">
              {{ getFormattedDate(item) }}
            </span>

            <span class="text-sm lg:text-base font-bold">{{ getCategoryName(item) }}</span>
          </NuxtLink> 

        </div>
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

        if( item.acf.event_end ) {
          const dateEnd = new Date(item.acf.event_end);

          return ("" + date.getDate()).slice(-2)+ "/" + ("" + (date.getMonth()+1)).slice(-2) + " – " + ("" + dateEnd.getDate()).slice(-2)+ "/" + ("" + (dateEnd.getMonth()+1)).slice(-2);
        } else {
          return ("" + date.getDate()).slice(-2)+ "/" + ("" + (date.getMonth()+1)).slice(-2);
        }       
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

        if( item.acf.event_end ) {
          const dateEnd = new Date(item.acf.event_end);
          const monthNameEnd = this.$i18n.locale == 'en' ? dateEnd.toLocaleDateString("en-GB", options).toLowerCase() : dateEnd.toLocaleDateString("cs-CZ", options);

          let started = false;

          for (const [monthKey, monthItems] of Object.entries(programByMonths)) {
            if ( monthKey == monthName ) started = true;
            if ( monthKey == monthNameEnd ) break;

            if( started ) {
              programByMonths[monthKey].push(item);
            }
          }
          
        } else {
          programByMonths[monthName].push(item);
        }        
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
