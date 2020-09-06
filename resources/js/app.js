require('./bootstrap');

window.Vue = require('vue');

import vmodal from 'vue-js-modal'

Vue.use(vmodal)

Vue.component('new-project-modal', require('./components/NewProjectModal').default);

new Vue({
    el: '#app'
});


