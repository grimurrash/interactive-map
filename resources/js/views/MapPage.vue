<template>
    <main>
        <map-header/>
        <map-component :showPanel="true"/>
        <panel/>
    </main>
</template>

<script>
import store from "~/store/index"
import Map from "~/components/Map/Map"
import Panel from "~/components/Map/PanelBlock"
import MapHeader from "~/components/Map/MapHeader";

export default {
    name: "MapPage",
    components: {
        MapHeader,
        'map-component': Map,
        Panel
    },
    beforeRouteEnter(to, from, next) {
        return Promise.all([
            store.dispatch('loadSettings'),
        ]).then(() => {
            next()
        })
    },
}
</script>

<style scoped>

</style>
