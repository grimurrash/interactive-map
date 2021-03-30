import Vue from 'vue'
import router from './router'
import store from './store'

import Main from "./views/Main";

import Sync from "./plugins/Sync";
import syncs from './sync'

Vue.config.productionTip = false
Vue.use(Sync, syncs)

export const bus = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(Main)
})
