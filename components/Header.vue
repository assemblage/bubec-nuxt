<template>
  <header class="pb-8 fixed z-50 top-0 left-0 w-full" :class="[ showMenu ? 'bg-yellow-900 h-screen flex flex-col' : 'bg-gray-900']">
    <div v-if="newArticles" class="max-w-screen-3xl mx-auto relative text-sm lg:text-base 2xl:text-lg uppercase flex py-4 h-16 overflow-x-hidden" :class="[showMenu ? 'hidden lg:flex' : '']">

      <span class="z-10 absolute left-0 top-0 h-full w-10 lg:w-20 bg-gradient-to-r" :class="[ showMenu ? 'from-yellow-900' : 'from-gray-900']"></span>

      <div class="marquee flex">

        <NuxtLink v-show="showArticles" :to="item.link" v-for="(item, index) in newArticles" :key="index" class="whitespace-nowrap">
          {{ item.title }}<span v-if="index !== newArticles.length - 1" class="px-6">&bull;</span>
        </NuxtLink>

        <NuxtLink v-show="showArticles" :to="item.link" v-for="(item, index) in newArticles" :key="index+10" class="whitespace-nowrap">
          <span class="px-6">&bull;</span>{{ item.title }}
        </NuxtLink>

      </div>

      <button @click="showArticles = !showArticles" class="absolute top-0 right-0 flex h-full">
        <span class="h-full w-20 bg-gradient-to-l" :class="[ showMenu ? 'from-yellow-900' : 'from-gray-900']"></span>

        <span class="h-full inline-flex items-center pl-2" :class="[ showMenu ? 'bg-yellow-900' : 'bg-gray-900']">
          <Icons icon="star" classes="h-6 2xl:h-8 w-auto" />
        </span>

        <span class="h-full w-4 sm:w-6 lg:w-8" :class="[ showMenu ? 'bg-yellow-900' : 'bg-gray-900']"></span>
      </button>
    </div>

    <div class="w-full max-w-screen-3xl mx-auto flex justify-between px-4 sm:px-6 lg:px-10" :class="[ !newArticles ? 'mt-4' : '']">
      <NuxtLink to="/" :class="[showMenu ? 'invisible' : '']">
        <Icons v-if="!scrolled" icon="logo" classes="h-12 w-auto 2xl:h-20" />

        <Icons v-else icon="logo-sm" classes="h-8 2xl:h-12 w-auto" />
      </NuxtLink>

      <button @click="showMenu = !showMenu" :class="[showMenu ? 'mt-4 lg:mt-0' : '']">
        <Icons v-if="!showMenu" icon="menu" :classes="!scrolled ? 'w-auto h-12 2xl:h-20' : 'w-auto h-8 2xl:h-12'" />

        <Icons v-else icon="close" :classes="!scrolled ? 'w-auto h-12 2xl:h-16' : 'w-auto h-8 2xl:h-14'" />
      </button>
    </div> 

    <div v-if="showMenu" class="w-full max-w-screen-3xl mx-auto lg:pt-20 lg:pb-10 px-4 sm:px-6 lg:px-10 bg-yellow-900 flex flex-col grow h-screen">
      <nav class="flex justify-between lg:space-x-16 flex-col lg:flex-row items-center lg:items-start text-center lg:text-left">
        <div v-for="(item, index) in global.menus" :key="index">
          <h3 class="font-bold text-lg 2xl:text-xl uppercase my-5 lg:mt-0 lg:mb-20 cursor-pointer sm:cursor-default" @click=" activeSubmenu = activeSubmenu == index ? null : index">{{ index }}</h3>

          <div :class="[ activeSubmenu == index ? '' : 'overflow-hidden max-h-0 sm:overflow-visible sm:max-h-auto' ]">
            <NuxtLink :to="parseUrl(item)" v-for="(item, index) in item" :key="index" class="lowercase block text-sm lg:text-base mb-3 lg:mb-4 hover:underline decoration-2">
              {{ item.title }}
            </NuxtLink>
          </div>
        </div>
      </nav>

      <div class="flex flex-wrap items-center mt-auto">

        <a :href="global.social.fb" target="_blank" v-if="global.social.fb">
          <Icons icon="fb" classes="h-6 lg:h-8 w-auto mr-12" />
        </a>
        <a :href="global.social.tw" target="_blank" v-if="global.social.tw">
          <Icons icon="tw" classes="h-6 lg:h-8 w-auto mr-12" />
        </a>
        <a :href="global.social.ig" target="_blank" v-if="global.social.ig">
          <Icons icon="ig" classes="h-6 lg:h-8 w-auto mr-0 sm:mr-12" />
        </a>

        <a href="mailto:info@bubec.cz" class="text-lg lg:text-xl w-full sm:w-auto my-4 sm:my-0 hover:underline decoration-2">info@bubec.cz</a>
      </div>
    </div>

  </header>
</template>

<script>
import { mapState } from 'vuex';
import Icons from './Icons.vue';

export default {
  components: {
    Icons
  },
  props: [],
  data() {
    return {
      showMenu: false,
      showArticles: true,
      scrolled: false,
      activeSubmenu: null,
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
    ...mapState(['global']),

    newArticles() {
      if ( !this.global.featured_posts ) return 

      const articles =  this.global.featured_posts.map( item => {
        let urlBase = '/';
        if( item.post_type == 'post' ) {
          urlBase = '/aktuality/';
        } else if( item.post_type == 'program' ) {
          urlBase = '/program/detail/';
        } else if( item.post_type == 'kurz' ) {
          urlBase = '/kurz/';
        }

        return {
          'title': item.post_title,
          'link': `${urlBase}${item.post_name}/`,
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

