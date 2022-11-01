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
    },
    themeColor: '#000000',
    title: 'Bubec',
    description: 'Sochařské studio je provozováno obecně prospěšnou společností Bubec, založenou jako občanské sdružení 7. 3. 2000 v Praze 5, Řeporyjích. Řeporyje jsou stará vesnička založená v 11 století, nacházející se na jihozápadním okraji Prahy, v těsném sousedství Prokopského údolí. Studio pořádá pravidelné výstavy Art Safari, výtvarné dílny a kurzy pro dospělé i děti. Další z činností Sochařského studia je pronájem prostor vhodných pro výtvarné práce a rezidenční pobyty umělců. Founded in 2000, Studio Bubec provides a perfect opportunity for artists to work in a unique environment.',

  },
  baseURL: {
    production: 'https://bubec.cz',
    staging: 'https://bubec-nuxt.netlify.app/',
    development: 'http://localhost:3000/',
  },
  project: {
  },
};
