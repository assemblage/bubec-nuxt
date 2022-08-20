<template>
  <header class="px-4 sm:px-6 lg:px-8 pb-8 fixed z-50 top-0 left-0 w-full" :class="[ showMenu ? 'bg-yellow-900 h-screen flex flex-col' : 'bg-gray-900']">
    <div v-if="newArticles" class="relative text-base 2xl:text-lg uppercase flex overflow-x-hidden py-4 h-16">

      <NuxtLink v-show="showArticles" :to="item.link" v-for="(item, index) in newArticles" :key="index" class="whitespace-nowrap">
        {{ item.title }}<span v-if="index !== newArticles.length - 1" class="px-6">&bull;</span>
      </NuxtLink>

      <button @click="showArticles = !showArticles" class="absolute top-0 right-0 flex h-full">
        <span class="w-20 bg-gradient-to-l" :class="[ showMenu ? 'from-yellow-900' : 'from-gray-900']"></span>
        <span class="inline-flex items-center pl-2" :class="[ showMenu ? 'bg-yellow-900' : 'bg-gray-900']">
          <img class="h-6 2xl:h-8 w-auto" src="/star.svg" alt="">
        </span>
      </button>
    </div>

    <div class="w-full max-w-screen-2xl mx-auto flex justify-between">
      <NuxtLink to="/" :class="[showMenu ? 'invisible' : '']">
        <img v-if="!scrolled" class="h-12 w-auto 2xl:h-20" src="/logo.svg" alt="">

        <img v-else class="h-8 2xl:h-12 w-auto" src="/logo-sm.svg" alt="">
      </NuxtLink>

      <button @click="showMenu = !showMenu">
        <img v-if="!showMenu" class="w-auto" :class="[!scrolled ? 'h-12 2xl:h-20' : 'h-8 2xl:h-12']" src="/menu.svg" alt="">

        <img v-else class="w-auto" :class="[!scrolled ? 'h-12 2xl:h-20' : 'h-8 2xl:h-12']" src="/close.svg" alt="">
      </button>
    </div> 

    <div v-if="showMenu" class="pt-20 pb-10 bg-yellow-900 flex flex-col grow">
      <nav class="flex space-x-16">
        <div v-for="(item, index) in global.menus" :key="index">
          <h3 class="font-bold text-xl uppercase mb-12">{{ index }}</h3>

          <NuxtLink :to="parseUrl(item)" v-for="(item, index) in item" :key="index" class="block text-base mb-4">
            {{ item.title }}
          </NuxtLink>
        </div>
      </nav>

      <div class="flex items-center space-x-12 mt-auto">
        <a href="" target="_blank"><img class="h-8 w-auto" src="/fb.svg" alt=""></a>
        <a href="" target="_blank"><img class="h-8 w-auto" src="/tw.svg" alt=""></a>
        <a href="" target="_blank"><img class="h-8 w-auto" src="/ig.svg" alt=""></a>

        <a href="mailto:info@bubec.cz" class="text-xl">info@bubec.cz</a>
      </div>
    </div>

  </header>
</template>

<script>
import { mapState } from 'vuex';

export default {
  components: {

  },
  props: [],
  data() {
    return {
      showMenu: false,
      showArticles: true,
      scrolled: false
    }
  },
  methods: { 
    parseUrl( item ) {
      let url;
      if( item.url.indexOf(this.$config.apiBaseUrl) !== -1 ) {
        url = '/' + item.url.replace(this.$config.apiBaseUrl, '');
      }
      else if ( item.url.indexOf('http:/') !== -1 ) {
        url = item.url.replace('http:/', '');
      } else {
        url = item.url.charAt(0) === '/' ? item.url : `/${item.url}`;
      }

      return url.charAt(url.length - 1) === '/' ? url : `${url}/`;
    } 
  },
  computed: {
    ...mapState(['global', 'articles']),

    newArticles() {
      if (!this.articles) return 

      const articles =  this.articles.slice(0, 5).map( item => {
        return {
          'title': item.title.rendered,
          'link': `/aktuality/${item.slug}/`,
        }
      });

      return articles;
    },

    availableLocales () {
      //return this.$i18n.locales.filter(i => i.code !== this.$i18n.locale)
      return this.$i18n.locales;
    },

    activeLocale() {
      return this.$i18n.locale;
    },
  },
  mounted() {  
    window.addEventListener('scroll', e => {
      requestAnimationFrame(() => {
        this.scrolled = window.scrollY > 10
      })
    })
  },
  watch: {
    $route () {     
      this.$nextTick(() => {
        this.showMenu = false;
      });
    }
  },
  head () {

  }
}
</script>

