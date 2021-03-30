import Vue from 'vue'
import VueRouter from 'vue-router'

import MapPage from "~/views/MapPage";
import NotFoundPage from "~/views/NotFoundPage"

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: '/map'
        },
        {
            path: '/map',
            component: MapPage
        },
        {path: '*', component: NotFoundPage}
    ]
})
