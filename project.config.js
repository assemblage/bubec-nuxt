// responsive
export default {
  globalTitle: 'Bubec',
  apiBaseUrl: 'https://bubec-wordpress.assemblage.cz/',
  useFileCachedAPI: true,
  cookiePolicy: {
    isActive: false,
    cookiePolicyNamespace: 'bubec-cookie-policy',
  },
  seo: {
    google: {
      tagManagerID: 'GTM-WFJDBWG',
      googleVerification: 'QKLpI8qwfS31qBm0k_frXamb_MhTsmYyX7W34EQfmQA',
    },
    themeColor: '#000000',
  },
  baseURL: {
    production: 'https://bubec.cz',
    staging: 'https://bubec-nuxt.netlify.app/',
    development: 'http://localhost:3000/',
  },
  project: {
  },
};
