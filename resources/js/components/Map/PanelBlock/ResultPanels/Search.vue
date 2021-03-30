<template>
  <div class="content search">
    <h2>Результаты поиска</h2>
    <div class="wrapper">
      <ul>
        <li
            v-for="(museum) in searchList"
            v-on:click="toMuseum(museum.id)"
        >
          {{ museum.name }}
        </li>
      </ul>
    </div>
    <div class="wrapper not-found" v-if="searchList.length === 0">
      По запросу ничего не найдено
    </div>
  </div>
</template>

<script>
import {bus} from "~/app";
import {mapGetters} from 'vuex'

export default {
  name: "Search",
  computed: {
    ...mapGetters(['searchList'])
  },
  methods: {
    toMuseum(eoId) {
      bus.$emit('toMuseum', eoId)
    }
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
