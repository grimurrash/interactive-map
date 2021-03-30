<template>
  <div class="map-wrapper">
    <div id="map">
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import map from '~/lib/map'

export default {
  name: "Map",
  computed: {
    ...mapGetters(['mapConfig', 'polygons', 'points'])
  },
  methods: {
    ...mapActions(['getCityPoints']),
  },
  created() {
    let timerId = setInterval(() => {
      if (this.polygons.length > 0) {
        map.initMap(this.mapConfig).then(() => {
          map.drawPolygons(this.polygons)
          map.drawPoints(this.points, true)
          this.$store.commit('setSettings', {
            name: 'loadedMap',
            value: true
          })
        })
        clearInterval(timerId)
      }
    }, 500)
  }
}
</script>

<style scoped lang="scss">
</style>
