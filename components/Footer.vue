<template>
  <footer class="relative h-96 p-8 bg-black flex items-end">
    <div aria-hidden="true" class="absolute inset-0 overflow-hidden">            
      <img src="/footer.jpg" alt="" class="w-full h-full object-center object-cover">
    </div>  

    <div class="relative text-lg font-bold flex justify-between w-full space-x-8" v-html="footerText">
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
