import api from '~/api/index'

export default {
    actions: {
        loadSettings(ctx) {
            api.mapAPI.getSettings().then((result)=> {
                ctx.commit('setPolygons', result.data.polygons)
                ctx.commit('setFilterList', result.data.subjectTypes)
            })
        },
        getCityPoints(ctx) {
            ctx.commit('setSettings', {
                name: 'loading',
                value: true
            })
            let filters = ctx.rootState.filters.current.join(',')
            if (filters.length < 0) {
                filters = ctx.rootState.filters.list.join(',')
            }
            api.mapAPI.getCityPoints({
                subjectTypeIds: filters
            }).then((result) => {
                ctx.commit('setDistrict',result.data.districts)
                ctx.commit('setPoints', result.data.points)
                ctx.commit('setSettings', {
                    name: 'loading',
                    value: false
                })
            })
        },
        getCurrentDistrict(ctx, eoId) {
            ctx.commit('setSettings', {
                name: 'loading',
                value: true
            })
            let filters = ctx.rootState.filters.current.join(',')
            if (filters.length < 0) {
                filters = ctx.rootState.filters.list.join(',')
            }
            api.mapAPI.getCurrentRegion({
                subjectTypeIds: filters,
                districtId: eoId
            }).then((result) => {
                ctx.commit('setCurrentDistrict',result.data.district)
                ctx.commit('setSettings', {
                    name: 'loading',
                    value: false
                })
            })
        },
    },
    mutations: {
        setPolygons(state, polygons) {
            state.polygons = polygons.map(item => {
                item.coordinates = JSON.parse(item.coordinates);
                return item
            })

        },
        setDistrict(state, districts) {
            state.districts = districts;
        },
        setCurrentDistrict(state, district) {
            state.current = district
        },
        setPoints(state, points) {
            state.points = points
        }
    },
    state: {
        current: null,
        polygons: [],
        districts: [],
        points: []
    },
    getters: {
        districts: (state) => {
            return state.districts.sort((a,b) => a.id - b.id)
        },
        polygons: (state) => {
            return state.polygons
        },
        points: (state) => {
            return state.points
        },
        currentDistrict: (state) => {
            return state.current
        },
        subjectList: (state) => {
            return state.current.points
        }
    }
}
