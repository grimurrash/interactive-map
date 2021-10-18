import Vue from "vue"
import Vuex from 'vuex'

import districts from "./modules/districts";
import museums from "./modules/museums"
import mapConfig from "./modules/map"
import filters from "./modules/filters";
import search from "./modules/search"

import RenderCity from "~/plugins/store/RenderCity";
import RenderDistrict from "~/plugins/store/RenderDistrict";
import RenderMuseum from "~/plugins/store/RenderMuseum";
import RenderSearch from "~/plugins/store/RenderSearch";

Vue.use(Vuex)

const state = {
    settings: {
        loadedMap: false,
        loading: false,
        search: '',
        showFilters: false,
        showPanel: false,
        isFullResultBlock: false,
        stage: 0
    }
}

export default new Vuex.Store({
    state,
    modules: {
        mapConfig, districts, museums, filters, search
    },
    plugins: [
        RenderCity, RenderDistrict, RenderMuseum, RenderSearch
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
