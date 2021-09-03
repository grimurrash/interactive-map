<template>
  <div class="content search">
    <h2>Результаты поиска</h2>
    <div class="wrapper">
      <ul>
        <li
            v-for="(subject) in searchList"
            v-on:click="toSubject(subject.id)"
        >
          {{ subject.name }}
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
    toSubject(eoId) {
      bus.$emit('toSubject', eoId)
    }
  },
  mounted() {
    bus.$on('toSubject', (eoId) => {
      const query = JSON.parse(JSON.stringify(
          this.$route.query
      ))
      query.subject = eoId
      this.$router.push({
        name: this.$route.name,
        params: this.$route.params,
        query: query
      })
    })
  },
  beforeDestroy() {
    bus.$off('toSubject')
  }
}
</script>

<style lang="scss" scoped>

</style>
