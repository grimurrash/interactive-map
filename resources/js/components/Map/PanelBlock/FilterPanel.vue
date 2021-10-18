<template>
  <section class="filter-panel">
    <button
        v-for="(type, i) in filters.list"

        class="filter-panel__btn"

        v-bind:class="{active: activeFilter(type.id)}"

        v-bind:key="i"

        v-on:click="toggleFilter(type.id)"
    >
      {{ type.name }}
    </button>
  </section>
</template>

<script>
import {mapGetters} from 'vuex'
import {bus} from "~/app";

export default {
  name: "FilterPanel",
  computed: {
    ...mapGetters(['filters','settings'])
  },
  methods: {
    activeFilter(id) {
      return this.filters.current.indexOf(id) > -1
    },
    toggleFilter(id) {
      const query = JSON.parse(JSON.stringify(this.$route.query))

      const filterIndex = this.filters.current.indexOf(id)

      query.filters = this.filters.current

      if (filterIndex > -1) {
        query.filters.splice(filterIndex, 1)
      } else {
        query.filters.push(id)
      }

      if (query.filters.length > 0) {
        query.filters = query.filters.sort().join(',')
      } else {
        delete query.filters
      }

      this.$router.push({
        name: this.$route.name,
        params: this.$route.params,
        query: query
      })
    }
  },
  mounted() {
    bus.$on('toDistrict', (eoId) => {
      const query = JSON.parse(JSON.stringify(
          this.$route.query
      ))
      query.district = eoId
      this.$store.commit('setSettings', {
        name: 'showFilters',
        value: false
      })
      this.$router.push({
        name: this.$route.name,
        params: this.$route.params,
        query: query
      })
    })
    bus.$on('toSubject', (eoId) => {
      const query = JSON.parse(JSON.stringify(
          this.$route.query
      ))
      query.subject = eoId
      this.$store.commit('setSettings', {
        name: 'showFilters',
        value: false
      })
      this.$router.push({
        name: this.$route.name,
        params: this.$route.params,
        query: query
      })
    })
  },
  beforeDestroy() {
    bus.$off('toSubject')
    bus.$off('toDistrict')
  }
}
</script>

<style lang="scss" scoped>

</style>
