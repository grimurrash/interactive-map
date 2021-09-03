<template>
  <div class="content subject" v-if="currentSubject">
    <h2>{{ currentSubject.name }}</h2>
    <div class="wrapper">
      <div class="info">
        <ul>
          <li v-if="currentSubject.website">
            <a :href="`http://${currentSubject.website}`">
              <img src="public/img/website-icon.svg"/>
              {{ currentSubject.website }}
            </a>
          </li>
          <li v-if="currentSubject.address">
            <a href="" v-on:click.prevent="openBaloon(currentSubject.id)">
              <img src="public/img/place-icon.svg"/>
              {{ currentSubject.address }}
            </a>
          </li>
        </ul>
      </div>
      <div class="info">
        <h3>Дополнительная информация</h3>
        <ul>
          <!--                    <li v-if="currentSubject.type.name"><b>Тип:</b> Музей {{ currentSubject.type.name }}</li>-->
          <li v-if="currentSubject.founderFIO"><b>Основатель:</b> {{ currentSubject.founderFIO }}</li>
          <li v-if="currentSubject.createDate"><b>Дата открытия:</b> {{ currentSubject.createDate }}</li>
        </ul>
      </div>
      <div class="info">
        <h3>Историческая справка (кратко)</h3>
        <ul>
          <li>
            {{ currentSubject.description }}
          </li>
        </ul>
      </div>
      <div class="info" v-if="currentSubject.video !== ''">
        <h3>Видео</h3>
        <iframe ref="iframe" id="iframeVideo" :src="currentSubject.video" :title="currentSubject.name" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen :style="{height: iframeHeight + 'px'}" @load="setHeight"></iframe>

      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {bus} from "~/app";
import map from '~/lib/map'

export default {
  name: "Subject",
  data() {
    return {
      iframeHeight: 0,
      ro: null
    }
  },
  computed: {
    ...mapGetters(['currentSubject'])
  },
  mounted() {
    bus.$on('toSubject', () => {
      this.$store.commit('setSettings', {
        name: 'showPanel',
        value: true
      })
    })
  },
  methods: {
    setHeight() {
      if (!this.ro) {
        this.ro = new ResizeObserver(() => {
          let iframe = this.$refs.iframe
          this.iframeHeight = (9 / 16) * iframe.clientWidth
        })
        this.ro.observe(this.$refs.iframe)
      }
    },
    openBaloon(id) {
      this.$store.commit('setSettings', {
        name: 'showPanel',
        value: false
      })

      setTimeout(() => {
        map.openBalloon(id)
      }, 500)
    }
  },
  beforeDestroy() {
    bus.$off('toSubject')
    this.ro.unobserve(this.$refs.iframe)
  }
}
</script>

<style lang="scss" scoped>
.info iframe {
  width: 100%;
}
</style>
