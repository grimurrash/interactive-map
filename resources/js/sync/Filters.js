const getFilters = function () {
    try {
        return this.$route.query.filters.split(',')
            .map((value) => parseInt(value))
            .filter((value) => value === value) // eslint-disable-line no-self-compare
    } catch (_) {
        return []
    }
}
export default {
    '$route.query': function () {
        this.$store.commit('setCurrentFilters', getFilters.call(this))
    }
}