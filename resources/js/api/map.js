export default function (instance) {
    return {
        getSettings() {
            return instance.get('settings')
        },
        getCityPoints(payload) {
            return instance.get('districts', {params: payload})
        },
        getCurrentRegion(payload) {
            return instance.get('subjects', {params: payload})
        },
        getSubject(payload) {
            return instance.get('subjects/show', {params: payload})
        },
        getSearch(payload) {
            return instance.get('subjects/search', {params: payload})
        }
    }
}
