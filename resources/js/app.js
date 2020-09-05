require('./bootstrap');

window.Vue = require('vue');

import vmodal from 'vue-js-modal'

Vue.use(vmodal)

new Vue({
    el: '#app'
});
