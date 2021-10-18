<template>
    <div class="content district-list">
        <h2>Административные округа</h2>
        <div class="wrapper">
            <ul>
                <li
                    v-for="(district) in districts"
                    v-on:click="toDistrict(district.id)"
                >
                    {{ district.shortName }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import {bus} from "~/app"
import {mapGetters} from 'vuex'

export default {
    name: "DistrictList",
    methods: {
        toDistrict(eoId) {
            bus.$emit('toDistrict', eoId)
        }
    },
    computed: {
        ...mapGetters(['districts'])
    },
    mounted() {
        bus.$on('toDistrict', (eoId) => {
            const query = JSON.parse(JSON.stringify(
                this.$route.query
            ))
            query.district = eoId

            this.$router.push({
                name: this.$route.name,
                params: this.$route.params,
                query: query
            })
        })
    },

    beforeDestroy() {
        bus.$off('toDistrict')
    }
}
</script>

<style lang="scss" scoped>
</style>
