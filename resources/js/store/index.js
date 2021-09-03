import Vue from "vue"
import Vuex from 'vuex'

import districts from "./modules/districts";
import subjects from "./modules/subjects"
import mapConfig from "./modules/map"
import filters from "./modules/filters";
import search from "./modules/search"

import RenderCity from "~/plugins/store/RenderCity";
import RenderDistrict from "~/plugins/store/RenderDistrict";
import RenderSubject from "~/plugins/store/RenderSubject";
import RenderSearch from "~/plugins/store/RenderSearch";

Vue.use(Vuex)

const state = {
    settings: {
        loadedMap: false,
        loading: false,
        search: '',
        showFilters: false,
        showPanel: false,
        stage: 0
    }
}

export default new Vuex.Store({
    state,
    modules: {
        mapConfig, districts, subjects, filters, search
    },
    plugins: [
        RenderCity, RenderDistrict, RenderSubject, RenderSearch
    ],
    mutations: {
        setSettings(state, {name, value}) {
            // if (name === 'loading' && value === false) {
            //     setTimeout(function () {
            //         state.settings[name] = value
            //     }, 500)
            // } else
                state.settings[name] = value
        }
    },
    getters: {
        settings: (state) => {
            return state.settings
        },
    }
})
