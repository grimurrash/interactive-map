const state = {
    list: [
        { id: 1, name: 'общий'},
    ],
    current: [],
}

export default {
    actions: {},
    mutations: {
        setFilterList(state, types) {
            state.list = types
        },
        setCurrentFilters(state, filters) {
            state.current = filters
        }
    },
    state,
    getters: {
        filters: (state) => {
            return {
                list: state.list,
                current: state.current
            }
        },
    }
}
