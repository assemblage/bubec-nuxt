<template>
  <div class="whitespace-nowrap flex items-center">
    <NuxtLink :to="item.link" v-for="(item, index) in articles" :key="index" :class="showArticles ? '' : 'invisible'" class="inline-flex items-center">
      {{ item.title }}<span v-if="index !== articles.length - 1" class="px-6">
      <Icons icon="arr" classes="h-4 md:h-5 w-auto"/>
      </span>
    </NuxtLink>
    <span class="px-6">
      <Icons icon="arr" classes="h-4 md:h-5 w-auto"/>
    </span>
  </div>
</template>

<script>

import Icons from './Icons.vue';

export default {
  components: {
    Icons
  },
  name: 'articlesMarquee',
  props: {
    articles: Array,
    showArticles: Boolean,
  },

  data() {
    return {
    }
  },

  methods: {
  },

  computed: {
  },
}
</script>
