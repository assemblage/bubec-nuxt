<template>
  <div class="app-container">
    <CookiePolicyBar />
    <Header />
    <main :class="['min-h-[70vh] bg-gray-900 sm:tracking-wide antialiased', ($route.path == '/' || $route.path == '/en/')  ? 'pt-28' : 'py-28']">
      <Nuxt />
    </main>
    <Footer />

    <span style="display:none !important;" class="sm:block"></span>
  </div>
</template>

<script>

import {getOpenGraphMeta} from '../utils/functions';


export default {
  name: 'DefaultLayout',

  mounted() {
    const googleTagManagerID = this.$config.seo.google.tagManagerID;

    const cookie = Boolean(this.$cookies.get(this.$config.cookiePolicy.cookiePolicyNamespace));

    if (cookie === true || !this.$config.cookiePolicy.isActive) {

      // Google Tag Manager
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer', googleTagManagerID);

    }
  },
  head () {
    let i18nHead = this.$nuxtI18nHead({ addSeoAttributes: true });

    i18nHead.link.map((item) => {

      const baseURL = !this.$config.dev ? this.$config.baseURL.production : this.$config.baseURL.development;

      item.href = `${baseURL}${item.href}`;

    });

    const openGraphMetaArr = getOpenGraphMeta({
      site_name: this.$config.globalTitle,
      title: this.$t('seo.title'),
      description: this.$t('seo.description'),
      url: this.$config.baseURL.production,
      type: 'website',
      mainImage: '/favicons/android-chrome-192x192.png'
    });

    return {
      htmlAttrs: {
        ...i18nHead.htmlAttrs
      },
      title: this.$t('seo.title'),
      meta: [
        {
          hid: 'description',
          name: 'description',
          content: this.$t('seo.description'),
        },
        ...i18nHead.meta,
        ...openGraphMetaArr,
      ],
    //   link: [

    //     {
    //       rel:"preload",
    //       hid:"preload",
    //       as: 'image',
    //       href: this.$img('/images/nimbee-header-large.jpg', {quality: 80, format: 'webp'})
    //     },
    //     ...i18nHead.link
    //  ]
    }
  }
}
</script>


