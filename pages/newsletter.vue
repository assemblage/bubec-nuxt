<template>
  <div>
    <h1 class="text-center text-xl mt-[30vh]">Newsletter</h1>

    <p class="text-sm max-w-[70ch] mx-auto my-10 text-center">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Fusce consectetuer risus a nunc. Fusce aliquam vestibulum ipsum. Nulla accumsan, elit sit amet varius semper, nulla mauris mollis quam, tempor suscipit diam nulla vel leo.</p>

    <div class="flex items-center justify-center">
      <input ref="email" v-model="email" type="email" required placeholder="Váš email" class="appearance-none min-w-[9rem] mr-4 border-0 border-b-2 border-black-900 bg-gray-900 text-lg">

      <button @click="handleSubmit" class="inline-flex items-center px-2">
        <span class="text-lg mr-6">Přihlásit se</span>
        <span class="text-xl">→</span>      
      </button>
    </div>

    <p class="uppercase text-sm text-center font-bold mt-8" :class="formResponse.type == 'error' ? 'text-red-900' : 'text-green-900'">{{ formResponse.text }}</p>
  </div>
</template>

<script>
import {getOpenGraphMeta} from '../utils/functions';

export default {
  name: 'Newsletter',

  data() {
    return {
      email: '',
      title: `Newsletter`,
      formResponse: {
        'type': null,
        'text': null
      }
    }
  },

  methods: {
    handleSubmit() {
      this.formResponse = {
        'type': null,
        'text': null
      }

      if( !this.$refs.email.validity.valid ) {
        this.formResponse.type = 'error';
        this.formResponse.text = 'Zadejte prosím validní email.';

        return;
      }

      // TODO setup middleware or WP endpoint
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
