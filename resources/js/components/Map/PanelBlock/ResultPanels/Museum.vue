<template>
  <div class="content museum" v-if="currentMuseum">
    <h2>{{ currentMuseum.name }}</h2>
    <div class="wrapper">
      <div class="info">
        <ul>
          <li v-if="currentMuseum.website">
            <a v-bind:href="`http://${currentMuseum.website}`" target="_blank">
              <img src="public/img/website-icon.svg"/>
              {{ currentMuseum.website }}
            </a>
          </li>
          <li v-if="currentMuseum.email">
            <a v-bind:href="`mailto:${currentMuseum.email}`">
              <img src="public/img/email-icon.svg"/>
              {{ currentMuseum.email }}
            </a>
          </li>
          <li v-if="currentMuseum.phone">
            <a v-bind:href="`tel:${currentMuseum.phone}`">
              <img src="public/img/phone-icon.svg"/>
              {{ currentMuseum.phone }}
            </a>
          </li>
          <li v-if="currentMuseum.address">
            <a href="" v-on:click.prevent="openBaloon(currentMuseum.id)">
              <img src="public/img/place-icon.svg"/>
              {{ currentMuseum.address }}
            </a>
          </li>
        </ul>
      </div>
      <div class="info">
        <h3>Дополнительная информация</h3>
        <ul>
          <li v-if="currentMuseum.type.name"><b>Тип:</b> Музей {{ currentMuseum.type.name}} </li>
          <li v-if="currentMuseum.location"><b>Школа:</b> {{ currentMuseum.location }} </li>
          <li v-if="currentMuseum.founderFIO"><b>Основатель:</b> {{ currentMuseum.founderFIO }} </li>
          <li v-if="currentMuseum.createDate"><b>Дата основания музея:</b> {{ currentMuseum.createDate }} </li>
        </ul>
      </div>
      <div class="info">
        <h3>Историческая справка (кратко)</h3>
        <ul>
          <li>
            {{ currentMuseum.description}}
          </li>
        </ul>
      </div>
<!--      <div class="info">-->
<!--        <h3>Руководитель музея</h3>-->
<!--        <ul>-->
<!--          <li>{{ currentMuseum.director.fio }}</li>-->
<!--          <li>-->
<!--            <a v-bind:href="`mailto:${currentMuseum.director.email}`">-->
<!--              <img src="public/img/email-icon.svg"/>-->
<!--              {{ currentMuseum.director.email }}-->
<!--            </a>-->
<!--          </li>-->
<!--          <li>-->
<!--            <a v-bind:href="`tel:${currentMuseum.director.phone}`">-->
<!--              <img src="public/img/phone-icon.svg"/>-->
<!--              {{ currentMuseum.director.phone }}-->
<!--            </a>-->
<!--          </li>-->
<!--        </ul>-->
<!--      </div>-->
    </div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {bus} from "~/app";
import map from '~/lib/map'

export default {
  name: "Museum",
  computed: {
    ...mapGetters(['currentMuseum'])
  },
  mounted () {
    bus.$on('toMuseum', () => {
        this.$store.commit('setSettings', {
          name: 'showPanel',
          value: true
        })
    })
  },
  methods: {
    openBaloon (id) {
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
    bus.$off('toMuseum')
  }
}
</script>

<style lang="scss" scoped>

</style>
