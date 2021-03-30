import stages from "~/consts/stages"

export default {
    '$route.query': function () {
        if (stages.museum.indexOf(this.$store.state.settings.stage) > -1) {
            this.$store.dispatch('getMuseum', this.$route.query.museum)

            this.$store.commit('setSettings', {
                name: 'showPanel',
                value: true
            })
        }
    }
}
