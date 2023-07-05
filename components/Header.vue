<template>
  <header ref="mainHeader" class="main-header pb-4 md:pb-8 fixed z-50 top-0 left-0 w-full flex flex-col" :class="[ showMenu ? 'bg-yellow-900 h-screen' : 'bg-gray-900']">
    <div v-if="newArticles" class="w-full max-w-screen-3xl mx-auto relative text-xs sm:text-sm lg:text-base 2xl:text-lg uppercase flex py-2 sm:py-4 min-h-[2.5rem] md:min-h-[4rem] overflow-x-hidden max-w-full" :class="[showMenu ? 'hidden lg:flex ' : '']">

      <span class="z-10 w-full absolute left-0 top-0 h-full w-10 lg:w-20 bg-gradient-to-r" :class="[ showMenu ? 'from-yellow-900' : 'from-gray-900']"></span>

      <div class="marquee flex items-center leading-none">
        <articles-marquee :articles="newArticles" :showArticles="showArticles"></articles-marquee>
        <articles-marquee :articles="newArticles" :showArticles="showArticles"></articles-marquee>
        <articles-marquee :articles="newArticles" :showArticles="showArticles"></articles-marquee>
        <articles-marquee :articles="newArticles" :showArticles="showArticles"></articles-marquee>
        <articles-marquee :articles="newArticles" :showArticles="showArticles"></articles-marquee>
        <articles-marquee :articles="newArticles" :showArticles="showArticles"></articles-marquee>
      </div>

      <button @click="showArticlesHandler" class="absolute top-0 right-0 flex h-full">
        <span class="h-full w-20 bg-gradient-to-l" :class="[ showMenu ? 'from-yellow-900' : 'from-gray-900']"></span>

        <span class="h-full inline-flex items-center lg:px-2" :class="[ showMenu ? 'bg-yellow-900' : 'bg-gray-900']">
          <Icons icon="star" classes="h-5 md:h-6 2xl:h-8 w-auto" :class="showArticles ? '' : 'articles-toggle--active'" />
        </span>

        <span class="h-full w-4 sm:w-6 lg:w-8" :class="[ showMenu ? 'bg-yellow-900' : 'bg-gray-900']"></span>
      </button>
    </div>

    <div class="w-full max-w-screen-3xl mx-auto flex justify-between px-4 sm:px-6 lg:px-10" :class="[ !newArticles ? 'mt-4' : 'pt-3']">
      <NuxtLink :to=" activeLocale == 'en' ? '/en/' : '/'" :class="[showMenu ? 'invisible' : '', 'relative']">
        <Icons icon="logo" :classes="!scrolled ? 'h-8 md:h-12 w-auto 2xl:h-20' : 'hidden'" />

        <Icons icon="logo-sm" :classes="!scrolled ? 'hidden' : 'absolute top-0 left-0 h-8 2xl:h-12 w-auto'" />
      </NuxtLink>

      <nav v-if="sectionsMenu && scrolled" class="space-x-3 md:space-x-8 flex relative z-20">
        <button @click.prevent="handleSubmenu(item.link)" v-for="(item, index) in sectionsMenu" :key="index" class="text-xxs md:text-xs uppercase inline-flex items-center">
          <span class="underline mr-0.5 md:mr-1">{{ item.title }}</span>

          <svg class="h-2 md:h-3 w-auto" :class="[item.link.indexOf('#') !== -1 ? 'rotate-90' : '']" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 64.9 56" enable-background="new 0 0 64.9 56" xml:space="preserve">
              <g enable-background="new    ">
                <path d="M36.8,56l-4.2-4.4l20.6-20.4H0v-6.3h53.2L32.6,4.4L36.8,0l28.1,28L36.8,56z"/>
              </g>
          </svg>
        </button>
      </nav>

      <button @click="showMenu = !showMenu" :class="[showMenu ? 'mt-4 lg:mt-0 mr-4 md:mr-0' : '']">
        <Icons v-if="!showMenu" icon="menu" :classes="!scrolled ? 'w-auto h-8 md:h-12 2xl:h-20' : 'w-auto h-8 2xl:h-12'" />

        <Icons v-else icon="close" :classes="!scrolled ? 'w-auto h-8 md:h-12 2xl:h-20' : 'w-auto h-8 2xl:h-14'" />
      </button>
    </div>

    <div v-if="showMenu" class="w-full max-w-screen-3xl mx-auto lg:pt-14 lg:pb-6 px-4 sm:px-6 lg:px-10 bg-yellow-900 flex flex-col grow h-screen overflow-y-auto">

      <nav class="flex justify-between lg:space-x-16 flex-col lg:flex-row items-center lg:items-start text-center lg:text-left">
        <div v-for="(item, index) in global.menus[activeLocale]" :key="index">
          <h3 class="font-bold text-base sm:text-lg 2xl:text-xl uppercase my-2 sm:my-5 lg:mt-0 lg:mb-10 cursor-pointer lg:cursor-default" @click=" activeSubmenu = activeSubmenu == index ? null : index">{{ $t(index) }}</h3>

          <div :class="[ activeSubmenu == index ? '' : 'overflow-hidden max-h-0 lg:overflow-visible lg:max-h-auto' ]">
            <span
              v-for="(item, index) in item"
              :key="index"
              class="lowercase block text-sm lg:text-base mb-2 lg:mb-4"
              @click="showMenu = false"
            >
              <NuxtLink :to="parseUrl(item)" class="hover:underline decoration-2">
                {{ item.title }}
              </NuxtLink>
            </span>
          </div>
        </div>
      </nav>

      <div class="flex justify-center mt-6">
        <NuxtLink v-if="activeLocale == 'cs'" :to="'/en/'" class="md:hidden font-bold text-base uppercase my-3 cursor-pointer">English</NuxtLink>

        <NuxtLink v-if="activeLocale == 'en'" :to="'/'" class="md:hidden font-bold text-base uppercase my-3 cursor-pointer">Česky</NuxtLink>
      </div>

      <div class="flex items-center mt-auto px-4 sm:px-6 pb-4 md:p-0 justify-between md:justify-start">

        <div class="flex justify-center md:justify-start">
          <a :href="global.social.fb" target="_blank" v-if="global.social.fb">
            <Icons icon="fb" classes="h-6 sm:h-8 w-auto mr-6 md:mr-12" />
          </a>
          <a :href="global.social.ig" target="_blank" v-if="global.social.ig">
            <Icons icon="ig" classes="h-6 sm:h-8 w-auto mr-6 md:mr-12" />
          </a>
        </div>

        <div class="flex md:basis-full">
          <a href="mailto:info@bubec.cz" class=" hover:underline decoration-2 text-[1.2rem] md:text-[2.4rem] leading-none font-bold md:font-normal">info@bubec.cz</a>

          <NuxtLink v-if="activeLocale == 'cs'" :to="'/en/'" class="ml-auto text-[2rem] leading-none hidden md:inline">English</NuxtLink>

          <NuxtLink v-if="activeLocale == 'en'" :to="'/'" class="ml-auto text-[2rem] leading-none hidden md:inline">Česky</NuxtLink>
        </div>
      </div>
    </div>

  </header>
</template>

<script>
import { mapState } from 'vuex';
import Icons from './Icons.vue';
import articlesMarquee from './articlesMarquee.vue';

export default {
  components: {
    Icons,
    articlesMarquee
  },
  props: [],
  data() {
    return {
      showMenu: false,
      showArticles: true,
      scrolled: false,
      activeSubmenu: null,
      sectionsMenu: false,
    }
  },
  created() {

    if(!process.server){
      this.mainTitleSectionYSizeHandler();
      window.addEventListener("resize", this.resizeHandlers);
    }

  },
  destroyed() {
    window.removeEventListener("resize", this.resizeHandlers);
  },
  methods: {

    resizeHandlers() {
      this.mainTitleSectionYSizeHandler();
      this.setMenuWindow100Height();
    },

    setMenuWindow100Height() {
      if (process.server) return false;
      // due to mobile issues with 100vh, we have to calculate the inner height of the viewport
      const mainHeader = document.querySelector('.main-header');
      const documentInnerHeight = window.innerHeight;

      if (this.showMenu) {
        mainHeader.style.height = `calc(${documentInnerHeight}px)`;
      } else {
        mainHeader.style.height = `auto`;
      }
    },

    mainTitleSectionYSizeHandler(e) {
      if (process.server) return false;
      if (this.showMenu) return false;
      setTimeout(() => {
        const mainHeader = document.querySelector('.main-header');
        const $el = document.querySelector('.homepage-title-section');
        const mainElement = $el.parentElement.parentElement;
        const documentInnerHeight = window.innerHeight;
        mainElement.style.paddingTop = `${mainHeader.getBoundingClientRect().height}px`;
        $el.style.height = `calc(${documentInnerHeight}px - ${mainHeader.getBoundingClientRect().height}px)`;
      }, 0);
    },
    showArticlesHandler() {
      this.showArticles = !this.showArticles;
    },
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

      if( url.indexOf('#') !== -1 ) {
        url = url.split('#');
        return {
          path: url[0].charAt(url[0].length - 1) === '/' ? url[0] : `${url[0]}/`,
          hash: '#'+url[1]
        };
      } else {
        return {
          path: url.charAt(url.length - 1) === '/' ? url : `${url}/`
        };
      }
    },

    loadSubmenu() {
      if ( typeof $nuxt == 'undefined' ) return;

      const pageSlug = $nuxt.context.route.params.slug;
      const state = $nuxt.context.nuxtState.state;

      const pages = state.pages.filter( item => item.slug == pageSlug );

      if( pages.length ) {
        this.sectionsMenu = pages[0].acf.submenu;
        return;
      }

      const articles = state.articles.filter( item => item.slug == pageSlug );

      if( articles.length ) {
        this.sectionsMenu = articles[0].acf.submenu;
        return;
      }

      const courses = state.courses.filter( item => item.slug == pageSlug );

      if( courses.length ) {
        this.sectionsMenu = courses[0].acf.submenu;
        return;
      }

      this.sectionsMenu = false;
    },

    handleSubmenu( link ) {
      if ( link.indexOf('#') !== -1 ) {
        // document.querySelector(link).scrollIntoView({ behavior: "smooth", block: 'start' });

        const mainHeader = this.$refs.mainHeader;
        const element = document.querySelector(link);
        const y = (element.getBoundingClientRect().top + window.pageYOffset) - mainHeader.getBoundingClientRect().height;

        window.scrollTo({top: y, behavior: 'smooth'});

      } else {
        window.open(link, "_blank");
      }
    },
  },
  computed: {
    ...mapState(['global']),

    newArticles() {
      if ( !this.global.featured_posts ) return

      const featured_posts = this.activeLocale == 'en' ? this.global.featured_posts_en : this.global.featured_posts;

      if ( !featured_posts ) return

      const articles =  featured_posts.map( item => {
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
    this.loadSubmenu();

    window.addEventListener('scroll', e => {
      requestAnimationFrame(() => {
        this.scrolled = window.scrollY > 10
      })
    })
  },
  watch: {
    $route(to, from) {
      this.$nextTick(() => {
        this.showMenu = false;
        this.loadSubmenu();
        if (to.path === '/') {
          setTimeout(() => {
            this.mainTitleSectionYSizeHandler();
          }, 100);
        }
      });
    },
    showMenu(newVal, oldVal) {
      if (process.server) return false;
      const appContainer = document.querySelector('.app-container');

      if( newVal === true ) {
        appContainer.classList.add('locked');
      } else {
        appContainer.classList.remove('locked');
      }
      this.setMenuWindow100Height();
    }
  },
  head () {

  }
}
</script>
<style lang="sass">
  .homepage-title-section
    & h1,
    & div
      height: 100%
  .articles-toggle--active
    & > svg > path
      fill: red
</style>




