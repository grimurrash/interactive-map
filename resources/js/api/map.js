export default function (instance) {
    return {
        getSettings() {
            return instance.get('settings')
        },
        getCityPoints(payload) {
            return instance.get('districts', {params: payload})
        },
        getCurrentRegion(payload) {
            return instance.get('museums', {params: payload})
        },
        getMuseum(payload) {
            return instance.get('museums/show', {params: payload})
        },
        getSearch(payload) {
            return instance.get('museums/search', {params: payload})
        }
    }
}
