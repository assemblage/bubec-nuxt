<template>
  <div>
    <h1 class="text-center text-xl lg:text-1xl xl:text-2xl tracking-tight mt-20 lg:mt-[30vh]">{{ $t('news') }}</h1>

    <nav class="max-w-3xl text-base px-4 sm:px-6 lg:px-8 mx-auto flex justify-center items-center space-x-4 my-20">
      <button v-for="(item, index) in years" :key="index" :class="[selectedYear == item ? '' : 'opacity-40 hover:opacity-100 transition']" @click="selectedYear = item">
        {{ item }}
      </button>
    </nav>

    <div class="flex flex-col text-sm md:text-base max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <NuxtLink :to="getLink(item)" class="py-4 text-center border-b-2 border-black-900 last:border-b-0" v-for="(item, index) in filteredArticles" :key="index">
        {{ item.title.rendered }}&nbsp;–&nbsp;{{ getFormattedDate(item) }}
      </NuxtLink>
    </div>
  </div>
</template>

<script>
import {getOpenGraphMeta} from '../../utils/functions';

export default {
  name: 'Articles',

  data() {
    return {
      selectedYear: 0
    }
  },

  async asyncData({app, params, error, payload, store, $axios}) {
      if (payload) {
        let articles = payload.articles;

        articles = articles.filter( item => {
          if( app.i18n.locale == 'en' ) {
            return item.link.indexOf('/en/') !== -1;
          } else {
            return item.link.indexOf('/en/') == -1;
          }
        });

        return {
          articles
        }
      } else {
        await store.dispatch("getArticles");

        let articles = store.state.articles;  
        
        articles = articles.filter( item => {
          if( app.i18n.locale == 'en' ) {
            return item.link.indexOf('/en/') !== -1;
          } else {
            return item.link.indexOf('/en/') == -1;
          }
        });

        return {
          articles
        }
      }      
  },

  methods: {
    getFormattedDate( item ) {
        const date = new Date(item.date);
        const options = { year: 'numeric', month: 'numeric', day: 'numeric' };

        return date.toLocaleDateString("cs-CZ", options);
    },
    getLink( item ) {
      return this.$i18n.locale == 'en' ? `/en/news/${item.slug}/` : `/aktuality/${item.slug}/`;
    }     
  },

  computed: {
    title() {
      return this.$t('news');
    },

    years() {
      if ( !this.articles ) return;

      const years = this.articles.map( item => {
        const date = new Date(item.date);
        const options = { year: 'numeric' };

        return date.toLocaleDateString("cs-CZ", options);
      });

      const sortedYears = [...new Set(years)].sort().reverse()

      this.selectedYear = sortedYears[0];

      return sortedYears;
    },

    filteredArticles() {
      if( !this.articles || !this.selectedYear ) return;

      return this.articles.filter( item => {
        const date = new Date(item.date);
        const options = { year: 'numeric' };

        const year = date.toLocaleDateString("cs-CZ", options);  
        
        return year == this.selectedYear;
      })
    }
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
