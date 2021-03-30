export default {
    '$route.query': function () {
        if (Object.keys(this.$route.query).indexOf('district') === -1) {
            this.$store.commit('setCurrentDistrict', null)
        }
    }
}