<template>
  <div class="panel" :class="{'is-full-panel': settings.isFullResultBlock}">
    <action-panel/>
    <template v-if="settings.showFilters">
      <filter-panel/>
    </template>
    <template v-else>
      <transition name="slide-fade">
        <result-panel v-show="settings.showPanel"/>
      </transition>
    </template>
  </div>
</template>

<script>
import FilterPanel from "./PanelBlock/FilterPanel";
import ResultPanel from "./PanelBlock/ResultPanel";
import ActionPanel from "./PanelBlock/ActionPanel";

import {mapState} from 'vuex'

export default {
  name: "PanelBlock",
  components: {
    ActionPanel,
    FilterPanel,
    ResultPanel
  },
  computed: {
    ...mapState(['settings'])
  }
}
</script>

<style lang="scss" scoped>

</style>
