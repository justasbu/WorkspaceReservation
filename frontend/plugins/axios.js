export default function ({$axios, store, redirect}) {
  $axios.onRequest((config) => {
    const token = store.getters["auth/token"];
    console.log(token)
    if (token) {
      config.headers.common.Authorization = `Bearer ${token}`
    }

  });
  $axios.onError(error => {
    if (error.response.status === 422) {
      store.dispatch("validation/setErrors", error.response.data.errors);
    }


    return Promise.reject(error);
  });
}
