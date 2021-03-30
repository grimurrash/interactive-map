<template>
    <div id="app">
        <loading
            :height="loader.height"
            :width="loader.width"
            :loader="loader.loader"
            :color="loader.color"
            :opacity="loader.opacity"
            :active.sync="settings.loading"
            :is-full-page="true"></loading>
        <router-view/>
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import {mapGetters} from 'vuex'
export default {
    name: "Main",
    data: () => ({
        loader: {
            color: '#1E90FF',
            loader: 'spinner',
            width: 50,
            height: 50,
            backgroundColor: '#ffffff',
            opacity: 0.9,
            zIndex: 999,
        }
    }),
    components: {
        Loading
    },
    computed: {
        ...mapGetters(['settings'])
    },
}
</script>

<style scoped>

</style>
