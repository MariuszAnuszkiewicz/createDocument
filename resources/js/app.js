require('./bootstrap');

import Vue from 'vue';

   Vue.component('parse-xlsx', require('./components/documents/ParseXlsx.vue').default);

const app = new Vue({
    el: '#app',
});
