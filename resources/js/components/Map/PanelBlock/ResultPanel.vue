<template>
  <section class="result-panel">
    <district-list v-if="settings.stage === stages.city"/>
    <subject-list v-if="settings.stage === stages.district"/>
    <subject v-if="settings.stage === stages.subject"/>
    <search v-if="settings.stage === stages.search"/>
  </section>
</template>

<script>
import DistrictList from "./ResultPanels/DistrictList";
import SubjectList from "./ResultPanels/SubjectList";
import Subject from "./ResultPanels/Subject";
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
    DistrictList, Subject, SubjectList, Search
  },
  computed: {
    ...mapGetters(['settings'])
  }
}
</script>

<style scoped lang="scss">

</style>
