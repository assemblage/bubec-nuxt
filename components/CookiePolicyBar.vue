<template>

</template>

<script>
export default {
  props: [],
  data() {
    return {
      cookieVoted: false,
      cookieConsent: false,
    }
  },
  computed: {

  },
  created() {
    //this.$cookies.remove(this.$config.seo.cookiePolicyNamespace);

    // const cookie = this.$cookies.get(this.$config.seo.cookiePolicyNamespace)

    // if (cookie) {
    //   this.cookieVoted = true;

    //   if (cookie === 'true') {
    //     this.cookieConsent = Boolean(this.$cookies.get(this.$config.seo.cookiePolicyNamespace))
    //   }

    // } else {
    //   this.cookieVoted = false;
    //   this.cookieConsent = false;
    // }

  },
  mounted() {

    // if (!this.cookieVoted) {
    //   this.$el.classList.add('is-active');
    // }

  },
  methods: {
    // setCookiePolicyHandler(confirmation, $event) {

    //   this.$cookies.set(this.$config.seo.cookiePolicyNamespace, confirmation, {
    //     path: '/',
    //     maxAge: 60 * 60 * 24 * 7
    //   })

    //   this.$el.classList.remove('is-active');

    // }
  }
}
</script>
