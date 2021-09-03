import api from "~/api";

const state = {
    list: []
}

export default {
    actions: {
        getSearch(ctx) {
            ctx.commit('setSettings', {
                name: 'loading',
                value: true
            })
            let filters = ctx.rootState.filters.current.join(',')
            if (filters.length < 0) {
                filters = ctx.rootState.filters.list.join(',')
            }
            api.mapAPI.getSearch({
                subjectTypeIds: filters,
                search: ctx.rootState.settings.search
            }).then((result) => {
                ctx.commit('setSearch',result.data.search)
                ctx.commit('setSettings', {
                    name: 'loading',
                    value: false
                })
            })
        }
    },
    mutations: {
        setSearch(state, data) {
            state.list = data;
        }
    },
    state,
    getters: {
        searchList: (state)=>{
            return state.list
        }
    }
}
