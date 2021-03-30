<template>
  <section class="result-panel">
    <district-list v-if="settings.stage === stages.city"/>
    <museum-list v-if="settings.stage === stages.district"/>
    <museum v-if="settings.stage === stages.museum"/>
    <search v-if="settings.stage === stages.search"/>
  </section>
</template>

<script>
import DistrictList from "./ResultPanels/DistrictList";
import MuseumList from "./ResultPanels/MuseumList";
import Museum from "./ResultPanels/Museum";
import Search from "./ResultPanels/Search";

import stages from "~/consts/stages";

import {mapGetters} from 'vuex'

export default {
  name: "ResultPanel",
  data() {
    return {
      stages
    }
  },
  props: {
    showPanel: Boolean
  },
  components: {
    DistrictList, Museum, MuseumList, Search
  },
  computed: {
    ...mapGetters(['settings'])
  }
}
</script>

<style scoped lang="scss">

</style>
