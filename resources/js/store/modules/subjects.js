import api from '~/api/index'

const state = {
    current: null,
}

export default {
    actions: {
        getSubject(ctx, subjectId) {
            ctx.commit('setSettings', {
                name: 'loading',
                value: true
            })
            api.mapAPI.getSubject({
                subjectId: subjectId
            }).then((result) => {
                ctx.commit('setSubject',result.data.subject)
                ctx.commit('setSettings', {
                    name: 'loading',
                    value: false
                })
            })
        }
    },
    mutations: {
        setSubject(state, data) {
            state.current = data;
        }
    },
    state,
    getters: {
        currentSubject: (state) => {
            if (state.current)  return state.current
            else [];
        }
    }
}
