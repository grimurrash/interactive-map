<template>
  <div class="content subject-list" v-if="currentDistrict">
    <h2>Музеи</h2>
    <div class="wrapper">
      <ul>
        <li
            v-for="(subject) in subjectList"

            v-on:click="toSubject(subject.id)"
        >
          {{ subject.name }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import {bus} from "~/app";
import {mapGetters} from 'vuex'

export default {
  name: "SubjectList",
  methods: {
    toSubject(eoId) {
      bus.$emit('toSubject', eoId)
    }
  },
  computed: {
    ...mapGetters(['subjectList', 'currentDistrict'])
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
