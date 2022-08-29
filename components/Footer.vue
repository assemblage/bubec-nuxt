<template>
  <footer class="relative h-[30rem] md:h-96 p-8 bg-black flex items-end">
    <div aria-hidden="true" class="absolute inset-0 overflow-hidden">            
      <img src="/footer.jpg" alt="" class="w-full h-full object-center object-cover">
    </div>  

    <div class="max-w-screen-3xl mx-auto px-4 sm:px-6 lg:px-8 relative text-base lg:text-lg font-bold flex justify-between w-full space-y-8 md:space-y-0 md:space-x-8 flex-col md:flex-row items-center md:items-start text-center md:text-left" v-html="footerText">
    </div>
  </footer>
</template>

<script>
import { mapState } from 'vuex';

export default {
  components: {
  },
  props: [],
  data() {
    return {
      
    }
  },
  computed: {
    ...mapState(['global']),

    footerText() {
      return this.global.footer_text;
    }
  },
}
</script>
