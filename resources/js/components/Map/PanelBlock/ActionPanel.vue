<template>
  <section class="action-panel">
    <template v-if="settings.showFilters">
      <button class="action-panel__title" v-on:click="toggleFilters">Категории</button>
    </template>
    <template v-else>
      <button class="action-panel__btn" @click="prevStage" v-if="settings.stage !== 'CITY'">
        <img alt="prev" src="public/img/prev-icon-black.svg"/>
      </button>
      <button class="action-panel__btn" @click="togglePanel">
        <template v-if="settings.stage === 'CITY'">
          {{ settings.showPanel ? 'КАРТА' : 'СПИСОК' }}
        </template>
        <template v-else>
          <img alt="up" v-if="settings.showPanel" src="public/img/up-icon-black.svg"/>
          <img alt="down" v-else src="public/img/down-icon-black.svg"/>
        </template>
      </button>
      <input
          class="action-panel__search"
          type="search"

          v-bind:class="{ open: !openSearch }"

          v-on:focus="toggleSearch"
          v-on:blur="toggleSearch"

          v-model.trim="search"
      >
    </template>
    <button class="action-panel__btn" v-on:click="toggleFilters" v-if="openSearch">
      <img alt="filter" width="18" height="17" src="public/img/filter-icon-black.svg"/>
      <div class="badge">{{ filters.current.length }}</div>
    </button>
  </section>
</template>

<script>
import {mapGetters} from 'vuex'
import stages from "~/consts/stages";

export default {
  name: "ActionPanel",
  data() {
    return {
      openSearch: true,
      search: this.$route.query.search || ''
    }
  },
  computed: {
    ...mapGetters(['settings', 'filters'])
  },
  watch: {
    search() {
      clearTimeout(this.searchTimeout)
      this.searchTimeout = setTimeout(this.searchToRoute, 1000)
    },

    '$route.query'() {
      this.search = this.settings.search
    }
  },
  methods: {
    prevStage() {
      const query = JSON.parse(
          JSON.stringify(
              this.$route.query
          )
      )
      switch (this.settings.stage) {
        case stages.district:
          delete query.district
          break
        case stages.subject:
          delete query.subject
          break
        case stages.search:
          delete query.search
          delete query.subject
          break
      }
      this.$router.push({
        name: this.$route.name,
        params: this.$route.params,
        query: query
      })
    },

    searchTimeout() {
    },

    searchToRoute() {
      const query = JSON.parse(
          JSON.stringify(
              this.$route.query
          )
      )

      if (this.search.length > 0) {
        delete query.subject
        if (query.search !== this.search) {
          query.search = this.search
          this.$router.push({
            name: this.$route.name,
            params: this.$route.params,
            query: query
          })
        }
      } else {
        delete query.search
        if (this.settings.stage === stages.search) {
          this.$router.push({
            name: this.$route.name,
            params: this.$route.params,
            query: query
          })
        }
      }

    },

    toggleFilters() {
      this.$store.commit('setSettings', {
        name: 'showFilters',
        value: !this.settings.showFilters
      })
    },

    togglePanel() {
      this.$store.commit('setSettings', {
        name: 'showPanel',
        value: !this.settings.showPanel
      })
    },

    toggleSearch() {
      this.openSearch = !this.openSearch
    }
  }
}
</script>

<style lang="scss" scoped>

</style>
