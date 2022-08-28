<template>
  <div>
    <h1 class="text-xl 2xl:text-2xl tracking-tight text-center mt-[30vh]">Program</h1>

    <nav class="max-w-3xl text-base px-4 sm:px-6 lg:px-8 mx-auto flex flex-wrap justify-center items-center space-x-4 my-20">
      <NuxtLink :to="`/program/`" :key="'all'" :class="[selectedCategory == 'all' ? '' : 'opacity-40 hover:opacity-100 transition']">
        Vše
      </NuxtLink>

      <NuxtLink :to="`/program/${item.slug}/`" v-for="(item, index) in programCategories" :key="index" :class="[selectedCategory == item.id ? '' : 'opacity-40 hover:opacity-100 transition']">
        {{ item.name }}
      </NuxtLink>
    </nav>

    <nav class="max-w-3xl text-base px-4 sm:px-6 lg:px-8 mx-auto flex justify-center items-center space-x-4 my-20">
      <button v-for="(item, index) in years" :key="index" :class="[programYear == item ? '' : 'opacity-40 hover:opacity-100 transition']" @click="changeYear(item)">
        {{ item }}
      </button>
    </nav>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'ProgramFilters',

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
    changeYear( year ) {
      this.$store.commit( "updateProgramYear", year );
    }
  },

  computed: {
    ...mapState(['programYear']),

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
  },
}
</script>
