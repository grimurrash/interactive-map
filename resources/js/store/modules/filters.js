const state = {
    list: [
        { id: 1, name: 'воинских частей'},
        { id: 2, name: 'общего профиля'},
        { id: 4, name: 'истории школ'},
        { id: 5, name: 'Героев Советского Союза и Российской Федерации'},
        { id: 6, name: 'народного ополчения'},
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
