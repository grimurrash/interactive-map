const state = {
    list: [],
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
