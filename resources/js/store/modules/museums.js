import api from '~/api/index'

const state = {
    current: null,
}

export default {
    actions: {
        getMuseum(ctx, museumId) {
            ctx.commit('setSettings', {
                name: 'loading',
                value: true
            })
            api.mapAPI.getMuseum({
                museumId: museumId
            }).then((result) => {
                ctx.commit('setMuseum',result.data.museum)
                ctx.commit('setSettings', {
                    name: 'loading',
                    value: false
                })
            })
        }
    },
    mutations: {
        setMuseum(state, data) {
            state.current = data;
        }
    },
    state,
    getters: {
        currentMuseum: (state) => {
            if (state.current)  return state.current
            else [];
        }
    }
}
