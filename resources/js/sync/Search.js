import stages from "~/consts/stages"
export default {
    '$route.query': function ($new, $old) {
        if ($new.search !== $old.search) {
            this.$store.commit('setSettings', {
                name: 'search',
                value: this.$route.query.search || ''
            })
            this.$store.commit('setSettings', {
                name: 'showPanel',
                value: true
            })

            if (stages.search.indexOf(this.$store.state.settings.stage) > -1) {
                this.$store.dispatch('getSearch')
            }
        }
    }
}
