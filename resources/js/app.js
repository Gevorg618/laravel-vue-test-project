require('./bootstrap');
import Vue from 'vue'
import vuetify from './plugins/vuetify'
import App from './App'
import router from './router/main'
import store from './store';


const app = new Vue({
    vuetify,
    router,
    store,
    render: h=>h(App),
}).$mount('#app');
