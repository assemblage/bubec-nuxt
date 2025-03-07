import projectConfig from "./project.config";
import {
  getArticlesFactory,
  getPagesFactory,
  getProgramCategoriesFactory,
  getProgramFactory,
  getCoursesFactory,
  getMenusFactory,
} from "./utils/factories";

const dev = process.env.NODE_ENV !== "production";

const config = { dev, ...projectConfig };

const getRoutes = async () => {
  let routes = [];

  const articlesRes = await getArticlesFactory(projectConfig);

  const articlesRoutes = articlesRes.map((item) => {
    if (item.link.indexOf("/en/") !== -1) {
      return {
        route: `/en/news/${item.slug}/`,
        payload: {
          articles: articlesRes,
          articleDetail: item,
        },
      };
    } else {
      return {
        route: `/aktuality/${item.slug}/`,
        payload: {
          articles: articlesRes,
          articleDetail: item,
        },
      };
    }
  });

  const pagesRes = await getPagesFactory(projectConfig);

  const pagesRoutes = pagesRes.map((item) => {
    return {
      route: `/${item.slug}/`,
      payload: item,
    };
  });

  // Program
  const programCategoriesRes = await getProgramCategoriesFactory(projectConfig);
  const programRes = await getProgramFactory(projectConfig);

  const programCategoriesRoutes = programCategoriesRes.map((item) => {
    if (item.link.indexOf("/en/") !== -1) {
      return {
        route: `/en/events/${item.slug}/`,
        payload: {
          categoryDetail: item,
          programCategories: programCategoriesRes,
          program: programRes,
        },
      };
    } else {
      return {
        route: `/program/${item.slug}/`,
        payload: {
          categoryDetail: item,
          programCategories: programCategoriesRes,
          program: programRes,
        },
      };
    }
  });

  const programRoutes = programRes.map((item) => {
    if (item.link.indexOf("/en/") !== -1) {
      return {
        route: `/en/events/detail/${item.slug}/`,
        payload: {
          programDetail: item,
          program: programRes,
          programCategories: programCategoriesRes,
        },
      };
    } else {
      return {
        route: `/program/detail/${item.slug}/`,
        payload: {
          programDetail: item,
          program: programRes,
          programCategories: programCategoriesRes,
        },
      };
    }
  });

  // Courses
  const coursesRes = await getCoursesFactory(projectConfig);

  const coursesRoutes = coursesRes.map((item) => {
    if (item.link.indexOf("/en/") !== -1) {
      return {
        route: `/en/course/${item.slug}/`,
        payload: {
          courseDetail: item,
          courses: coursesRes,
        },
      };
    } else {
      return {
        route: `/kurz/${item.slug}/`,
        payload: {
          courseDetail: item,
          courses: coursesRes,
        },
      };
    }
  });

  routes = [
    ...articlesRoutes,
    ...pagesRoutes,
    ...programRoutes,
    ...programCategoriesRoutes,
    ...coursesRoutes,
    {
      route: "/aktuality",
      payload: {
        articles: articlesRes,
      },
    },
    {
      route: "/program",
      payload: {
        program: programRes,
        programCategories: programCategoriesRes,
      },
    },
  ];

  return routes;
};

const getAssets = async () => {
  const menusRes = await getMenusFactory(projectConfig);

  return menusRes.data.assets;
};

export default async () => {
  const routes = await getRoutes();
  const assets = await getAssets();

  return {
    // Target: https://go.nuxtjs.dev/config-target
    globalName: config.globalTitle,
    target: "static", // default is 'server'
    ssr: true,
    components: true,
    publicRuntimeConfig: { ...config },
    server: {
      port: 3000, // default: 3000
      host: "0.0.0.0", // default: localhost
    },
    env: {
      baseUrl: process.env.BASE_URL || "https://localhost:3000",
    },
    router: {
      trailingSlash: true,
    },
    sitemap: {
      hostname: !dev ? config.baseURL.production : config.baseURL.development,
      trailingSlash: true,
    },
    render: {
      static: {
        // Add CORS header to static files.
        setHeaders(res) {
          res.setHeader("Access-Control-Allow-Origin", "*");
          res.setHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
          res.setHeader(
            "Access-Control-Allow-Headers",
            "Origin, X-Requested-With, Content-Type, Accept"
          );
        },
      },
    },
    generate: {
      crawler: true,
      fallback: "404.html",
      routes: routes,
    },
    build: {
      analyze: false,
      html: {
        minify: {
          collapseBooleanAttributes: true,
          decodeEntities: true,
          minifyCSS: true,
          minifyJS: true,
          processConditionalComments: true,
          removeEmptyAttributes: true,
          removeRedundantAttributes: true,
          trimCustomFragments: true,
          useShortDoctype: true,
          minifyURLs: true,
          removeComments: true,
          removeEmptyElements: true,
        },
      },
      loaders: {
        vue: { cacheBusting: false },
      },
      postcss: {
        postcssOptions: {
          plugins: {
            tailwindcss: {},
            autoprefixer: {},
          },
        },
      },
    },
    // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
    buildModules: ["@nuxtjs/style-resources"],
    styleResources: {
      // your settings here
      sass: [],
      scss: ["~assets/scss/_variables.scss"],
      hoistUseStatements: true, // Hoists the "@use" imports. Applies only to "sass", "scss" and "less". Default: false.
    },
    css: ["@/assets/css/main.css"],
    storybook: {},
    proxy: {},
    modules: [
      ["@nuxtjs/axios"],
      ["cookie-universal-nuxt"],
      [
        "@nuxtjs/i18n",
        {
          baseURL: !dev
            ? config.baseURL.production
            : config.baseURL.development /* :TODO: must set because of SEO! */,
          locales: [
            { code: "cs", iso: "cs-cz", file: "cs-CZ.js", dir: "ltr" },
            { code: "en", iso: "en-gb", file: "en-GB.js", dir: "ltr" },
          ],
          lazy: true,
          langDir: "~lang/",
          defaultLocale: "cs",
          vueI18n: {
            fallbackLocale: "cs",
          },
          detectBrowserLanguage: false,
        },
      ],
      [
        "@nuxtjs/sitemap",
        {
          hostname: !dev
            ? config.baseURL.production
            : config.baseURL.development,
          gzip: true,
          trailingSlash: true,
        },
      ], // If you use other modules (eg. nuxt-i18n), always declare the sitemap module at end of array
    ],
    i18n: {
      parsePages: false,
      pages: {
        "aktuality/index": {
          en: "/news/",
        },
        "aktuality/_slug": {
          en: "/news/:slug/",
        },
        "program/index": {
          en: "/events/",
        },
        "program/_slug": {
          en: "/events/:slug/",
        },
        "program/detail/_slug": {
          en: "/events/detail/:slug/",
        },
        "kurz/_slug": {
          en: "/course/:slug/",
        },
      },
    },
    // Global CSS: https://go.nuxtjs.dev/config-css
    css: ["@/assets/css/main.css"],
    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [],
    head: {
      meta: [
        { charset: "utf-8" },
        { name: "viewport", content: "width=device-width, initial-scale=1" },
        { name: "theme-color", content: config.seo.themeColor },
        { name: "msapplication-TileColor", content: config.seo.themeColor },
        {
          name: "google-site-verification",
          content: config.seo.google.googleVerification,
        },
      ],
      link: [
        ...assets.css,
        {
          rel: "icon",
          type: "image/x-icon",
          href: "/favicons/favicon.ico",
          media: "(prefers-color-scheme:light)",
        },
        {
          rel: "icon",
          type: "image/png",
          sizes: "16x16",
          href: "/favicons/favicon-16x16.png",
          media: "(prefers-color-scheme:light)",
        },
        {
          rel: "icon",
          type: "image/png",
          sizes: "32x32",
          href: "/favicons/favicon-32x32.png",
          media: "(prefers-color-scheme:light)",
        },
        {
          rel: "icon",
          type: "image/png",
          sizes: "144x144",
          href: "/favicons/android-chrome-144x144.png",
          media: "(prefers-color-scheme:light)",
        },
        {
          rel: "icon",
          name: "msapplication-TileImage",
          sizes: "150x150",
          content: "/favicons/mstile-150x150.png",
          media: "(prefers-color-scheme:light)",
        },
        {
          hid: "apple-touch-icon",
          rel: "apple-touch-icon",
          sizes: "180x180",
          href: "/favicons/apple-touch-icon.png",
          media: "(prefers-color-scheme:light)",
        },
        {
          rel: "icon",
          type: "image/x-icon",
          href: "/favicons/favicon.ico",
          media: "(prefers-color-scheme:dark)",
        },
        {
          rel: "icon",
          type: "image/png",
          sizes: "16x16",
          href: "/favicons/favicon-16x16.png",
          media: "(prefers-color-scheme:dark)",
        },
        {
          rel: "icon",
          type: "image/png",
          sizes: "32x32",
          href: "/favicons/favicon-32x32.png",
          media: "(prefers-color-scheme:dark)",
        },
        {
          rel: "icon",
          type: "image/png",
          sizes: "144x144",
          href: "/favicons/android-chrome-144x144.png",
          media: "(prefers-color-scheme:dark)",
        },
        {
          rel: "icon",
          name: "msapplication-TileImage",
          sizes: "150x150",
          content: "/favicons/mstile-150x150.png",
          media: "(prefers-color-scheme:dark)",
        },
        {
          hid: "apple-touch-icon",
          rel: "apple-touch-icon",
          sizes: "180x180",
          href: "/favicons/apple-touch-icon.png",
          media: "(prefers-color-scheme:dark)",
        },
        {
          rel: "preconnect",
          hid: "preconnect-google-tag-manager",
          href: "https://www.googletagmanager.com",
        },
      ],
      script: [...assets.script],
    },
  };
};
