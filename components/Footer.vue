<template>
  <footer class="main-footer relative h-[30rem] md:h-96 flex items-end">

    <div class="footer-logos py-4 md:py-2 px-4 sm:px-6 lg:px-10">

      <a href="#"><img src="~assets/images/eu-logo.png" alt="Logo projektu Evropské unie" /></a>
      <a href="#"><img src="~assets/images/praha.png" alt="Logo Hlavního města Prahy" /></a>
      <a href="#"><img src="~assets/images/mk.jpg" alt="Logo ministerstva kultury" /></a>
      <a href="#"><img src="~assets/images/npo.png" alt="Logo Národního plánu obnovy" /></a>
      <a href="#"><img src="~assets/images/nupz.jpeg" alt="Logo Nadaxe umění pro zdraví" /></a>
      <a href="#"><img src="~assets/images/sfk.png" alt="Logo Státního fondu kultury" /></a>

    </div>

    <div aria-hidden="true" class="absolute inset-0 overflow-hidden">
      <img src="/footer.jpg" alt="" class="w-full h-full object-center object-cover hidden lg:block">

      <img src="/footer-mobile.jpg" alt="" class="w-full h-full object-center object-cover lg:hidden">
    </div>

    <div class="w-full flex flex-col md:flex-row py-4 md:py-2 px-4 sm:px-6 lg:px-10 bg-black-900 text-white-900 max-w-screen-3xl mx-auto relative z-10 justify-between gap-4">
      <NuxtLink :to="'/newsletter/'" class="inline-flex items-center"><Icons icon="arr" classes="h-2.5 w-auto text-white-900 mr-0.5"/>newsletter</NuxtLink>

      <a :href="global.social.ig" target="_blank" v-if="global.social.ig" class="inline-flex items-center">
        <Icons icon="arr" classes="h-2.5 w-auto text-white-900 mr-0.5"/>ig
      </a>

      <a :href="global.social.fb" target="_blank" v-if="global.social.fb" class="inline-flex items-center">
        <Icons icon="arr" classes="h-2.5 w-auto text-white-900 mr-0.5"/>fcb
      </a>

      <a href="https://maps.google.com/?q=BUBEC" target="_blank" v-if="global.footer_text" class="inline-flex items-center">
        <Icons icon="arr" classes="h-2.5 w-auto text-white-900 mr-0.5"/>
        <span v-html="global.footer_text"></span>
      </a>

      <a :href="`mailto:${global.email}`" target="_blank" v-if="global.email" class="inline-flex items-center">
        <Icons icon="arr" classes="h-2.5 w-auto text-white-900 mr-0.5"/>
        <span v-html="global.email"></span>
      </a>
    </div>
  </footer>
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

    }
  },
  computed: {
    ...mapState(['global']),

    footerText() {
      //return this.$i18n.locale == 'en' ? this.global.footer_text_en : this.global.footer_text;
    }
  },
}
</script>
<style lang="scss" scoped>
@import '~/assets/scss/variables';
.main-footer {
  flex-direction: column-reverse;
}
.footer-logos {
  background-color: #fff;
  min-height: 100px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  position: relative;
  z-index: 1;
  width: 100%;
  column-gap: 1em;

  a {
      width: auto;
    }
  img {
    height: 60px;
    width: auto;
  }

}
</style>
