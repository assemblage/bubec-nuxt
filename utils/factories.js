import axios from "axios";
import axiosRetry from "axios-retry";

const axiosInstance = axios.create({
  // Keep the timeout low in development so it at least somehow responsive
  timeout: process.dev ? 10000 : 45000,
});

// We need retrying on timeout, because wordpress api quite often hangs
axiosRetry(axiosInstance, {
  retries: 50,
  retryDelay: () => 5000,
  shouldResetTimeout: true,
  retryCondition: (error) => {
    return !error.response;
  },
});


export async function getMenusFactory($config) {
  const resource = await axiosInstance.get( `${$config.apiBaseUrl}wp-json/bubec/data`);

  return resource.data;
}


export async function getArticlesFactory($config) {
  let batchLength = 100;
  let batchIndex = 1;
  let items = [];

  while (batchLength == 100) {
    const resource = await axiosInstance.get( `${$config.apiBaseUrl}wp-json/wp/v2/posts?page=${batchIndex}&per_page=100&_embed=1&acf_format=standard`, {
      method: 'GET'
    }
    );

    batchLength = resource.data.length;
    batchIndex++;

    items = [...items, ...resource.data];
  }

  return items
  .filter(article => article.status === "publish");

}

export async function getPagesFactory($config) {
  let batchLength = 100;
  let batchIndex = 1;
  let items = [];

  while (batchLength == 100) {
    const resource = await axiosInstance.get( `${$config.apiBaseUrl}wp-json/wp/v2/pages?page=${batchIndex}&per_page=100&_embed=1&acf_format=standard`, {
      method: 'GET'
    }
    );

    batchLength = resource.data.length;
    batchIndex++;

    items = [...items, ...resource.data];
  }

  return items.filter(article => article.status === "publish");
}


export async function getProgramCategoriesFactory($config) {
  const resource = await axiosInstance.get( `${$config.apiBaseUrl}wp-json/wp/v2/program_type?page=1&per_page=100&acf_format=standard`, {
    method: 'GET',
  }
  );

  return resource.data;
}

export async function getProgramFactory($config) {
  let totalPages = 1;
  let items = [];

  try {
    let resource = await axiosInstance.get(
      `${$config.apiBaseUrl}wp-json/wp/v2/program?page=1&per_page=100&_embed=1&acf_format=standard`, {
        method: 'GET'
      }
    );
    totalPages = resource.headers['x-wp-totalpages'];
    items = [...items, ...resource.data];

    if (totalPages > 1) {
      for (const i = 0; i < totalPages; i++) {
        resource = await axiosInstance.get(
          `${$config.apiBaseUrl}wp-json/wp/v2/program?page=${i + 2}&per_page=100&_embed=1&acf_format=standard`, {
            method: 'GET'
          }
        );
        items = [...items, ...resource.data];
      }
    }

    return items;
  } catch (e) {
    console.error(e);
  }
}

export async function getCoursesFactory($config) {
  let batchLength = 100;
  let batchIndex = 1;
  let items = [];

  while (batchLength == 100) {
    const resource = await axiosInstance.get( `${$config.apiBaseUrl}wp-json/wp/v2/kurz?page=${batchIndex}&per_page=100&_embed=1&acf_format=standard`, {
      method: 'GET'
    }
    );

    batchLength = resource.data.length;
    batchIndex++;

    items = [...items, ...resource.data];
  }

  return items;
}


