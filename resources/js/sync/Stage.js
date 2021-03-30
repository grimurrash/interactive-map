import stages from "~/consts/stages"

const getStage = function () {
    const routeKeys = Object.keys(this.$route.query)

    if (routeKeys.indexOf('museum') > -1) {
        return stages.museum
    }

    if (routeKeys.indexOf('search') > -1) {
        return stages.search
    }

    if (routeKeys.indexOf('district') > -1) {
        return stages.district
    }

    return stages.city
}
export default {
    '$route.query': function () {
        this.$store.commit('setSettings', {
            name: 'stage',
            value: getStage.call(this)
        })
    }
}
