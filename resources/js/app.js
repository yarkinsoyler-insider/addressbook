require('./bootstrap');

import Vue from 'vue';
import axios from 'axios';
import App from './App.vue';
import router from './router';

Vue.prototype.$axios = axios;
axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.withCredentials = true;

await axios.get('/sanctum/csrf-cookie');

new Vue({
    router,
    render: h => h(App)
}).$mount('#app');
