<template>
  <div class="content museum-list" v-if="currentDistrict">
    <h2>Музеи</h2>
    <div class="wrapper">
      <ul>
        <li
            v-for="(museum) in museumList"

            v-on:click="toMuseum(museum.id)"
        >
          {{ museum.name }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import {bus} from "~/app";
import {mapGetters} from 'vuex'

export default {
  name: "MuseumList",
  methods: {
    toMuseum(eoId) {
      bus.$emit('toMuseum', eoId)
    }
  },
  computed: {
    ...mapGetters(['museumList', 'currentDistrict'])
  },
  mounted() {
    bus.$on('toMuseum', (eoId) => {
      const query = JSON.parse(JSON.stringify(
          this.$route.query
      ))

      query.museum = eoId

      this.$router.push({
        name: this.$route.name,
        params: this.$route.params,
        query: query
      })
    })
  },

  beforeDestroy() {
    bus.$off('toMuseum')
  }
}
</script>

<style lang="scss" scoped>

</style>
