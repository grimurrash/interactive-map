import stages from "~/consts/stages"

export default {
    '$route.query': function () {
        if (stages.subject.indexOf(this.$store.state.settings.stage) > -1) {
            this.$store.dispatch('getSubject', this.$route.query.subject)

            this.$store.commit('setSettings', {
                name: 'showPanel',
                value: true
            })
        }
    }
}
