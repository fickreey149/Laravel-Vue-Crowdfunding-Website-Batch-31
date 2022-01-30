import Vue from 'vue'
import router from './router.js'
import store from './store'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import './bootstrap.js'


const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    components : {
        App
    }
});
