import stages from "~/consts/stages"

export default {
    '$route.query': async function () {
        if (stages.district.indexOf(this.$store.state.settings.stage) > -1) {
           await this.$store.dispatch('getCurrentDistrict', this.$route.query.district)
        }
    }
}
