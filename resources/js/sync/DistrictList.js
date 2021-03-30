import stages from "~/consts/stages"

export default {
    '$route.query': async function () {
        if (stages.city.indexOf(this.$store.state.settings.stage) > -1) {
           await this.$store.dispatch('getCityPoints')
        }
    }
}
