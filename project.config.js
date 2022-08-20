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
      tagManagerID: '',
    },
    themeColor: '#000000',
  },
  baseURL: {
    production: 'https://bubec.cz',
    staging: 'https://assemblage-bubec.netlify.app/',
    development: 'http://localhost:3000/',
  },
  project: {
  },
};
