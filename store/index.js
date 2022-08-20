import { getArticlesFactory, getPagesFactory, getProgramCategoriesFactory, getProgramFactory, getCoursesFactory, getMenusFactory } from '~/utils/factories';

export const state = () => ({
  articles: [],
  pages: [],
  articlesPage: 0,
  global: [],
  program: [],
  programCategories: [],
  courses: [],
})

export const mutations = {
  updateArticles: (state, newData) => {
    state.articles = newData;
  },

  updatePages: (state, newData) => {
    state.pages = newData;
  },

  updateArticlesPage: (state, newData) => {
    state.articlesPage = newData;
  },

  updateProgram: (state, newData) => {
    state.program = newData;
  },

  updateProgramCategories: (state, newData) => {
    state.programCategories = newData;
  },

  updateCourses: (state, newData) => {
    state.courses = newData;
  },

  updateMenus: (state, newData) => {
    state.global = newData;
  },
}

export const actions = {
  async nuxtServerInit({ state, dispatch }) {
    await dispatch('getMenus');
    await dispatch('getPages');
  },

  async getArticles({ state, commit }) {
    if (state.articles.length) return;
    try {
      const articles = await getArticlesFactory(this.$config);
      commit("updateArticles", articles);

    } catch (err) {
      console.warn(err)
    }
 },

 async getPages({ state, commit }) {
  if (state.pages.length) return;

  try {
    const pages = await getPagesFactory(this.$config);
    commit("updatePages", pages);

  } catch (err) {
    console.warn(err);
  }
},

 async getProgramCategories({ state, commit }) {
  if (state.programCategories.length) return
  try {
    const programCategories = await getProgramCategoriesFactory(this.$config);
    commit("updateProgramCategories", programCategories);

  } catch (err) {
    console.warn(err);
  }
 },

 async getProgram({ state, commit, dispatch }) {
  if (state.program.length) return
  try {
    const program = await getProgramFactory(this.$config);
    commit("updateProgram", program);

  } catch (err) {
    console.warn(err)
  }
 },

 async getCourses({ state, commit, dispatch }) {
  if (state.courses.length) return
  try {
    const courses = await getCoursesFactory(this.$config);
    commit("updateCourses", courses);

  } catch (err) {
    console.warn(err)
  }
 },

 async getMenus({ state, commit }) {
  if (state.global.length) return
  try {

    const global = await getMenusFactory(this.$config);
    commit("updateMenus", global.data);

  } catch (err) {
    console.warn(err)
  }
 },

}
