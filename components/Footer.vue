<template>
  <footer class="relative h-[30rem] md:h-96 flex items-end">
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
