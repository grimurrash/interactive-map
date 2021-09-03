<template>
  <div class="content museum" v-if="currentMuseum">
    <h2>{{ currentMuseum.name }}</h2>

    <div class="wrapper">
      <div class="info" v-if="currentMuseum.imagesUrl.length !== 0">
        <viewer :images="currentMuseum.imagesUrl"
                @inited="inited"
                class="viewer" ref="viewer"
        >
          <template #default="scope">
            <agile :initial-slide="0">
              <img class="slide" v-for="src in scope.images" :src="src" :key="src" alt="">
              <template v-slot:nextButton>
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right"
                     class="svg-inline--fa fa-chevron-right fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 320 512">
                  <path fill="currentColor"
                        d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path>
                </svg>
              </template>
              <template v-slot:prevButton>
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left"
                     class="svg-inline--fa fa-chevron-left fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 320 512">
                  <path fill="currentColor"
                        d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path>
                </svg>
              </template>
            </agile>
          </template>
        </viewer>
      </div>
      <div class="info">
        <ul>
          <li v-if="currentMuseum.website">
            <a :href="`http://${currentMuseum.website}`">
              <img src="public/img/website-icon.svg"/>
              {{ currentMuseum.website }}
            </a>
          </li>
          <li v-if="currentMuseum.email">
            <a :href="`mailto:${currentMuseum.email}`">
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
          <li v-if="currentMuseum.type.name"><b>Тип:</b> Музей {{ currentMuseum.type.name }}</li>
          <li v-if="currentMuseum.location"><b>Школа:</b> {{ currentMuseum.location }}</li>
          <li v-if="currentMuseum.founderFIO"><b>Основатель:</b> {{ currentMuseum.founderFIO }}</li>
          <li v-if="currentMuseum.createDate"><b>Дата основания музея:</b> {{ currentMuseum.createDate }}</li>
        </ul>
      </div>
      <div class="info">
        <h3>Историческая справка (кратко)</h3>
        <ul>
          <li>
            {{ currentMuseum.description }}
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
import 'viewerjs/dist/viewer.css'
import {component as Viewer} from "v-viewer"
import {mapGetters} from 'vuex'
import {VueAgile} from 'vue-agile'
import {bus} from "~/app";
import map from '~/lib/map'

export default {
  name: "Museum",
  components: {
    agile: VueAgile,
    Viewer,
  },
  computed: {
    ...mapGetters(['currentMuseum'])
  },
  mounted() {
    bus.$on('toMuseum', () => {
      this.$store.commit('setSettings', {
        name: 'showPanel',
        value: true
      })
    })
  },
  methods: {
    openBaloon(id) {
      this.$store.commit('setSettings', {
        name: 'showPanel',
        value: false
      })

      setTimeout(() => {
        map.openBalloon(id)
      }, 500)
    },
    inited(viewer) {
      this.$viewer = viewer
    },
    show() {
      this.$viewer.show()
    }
  },
  beforeDestroy() {
    bus.$off('toMuseum')
  }
}
</script>

<style lang="scss">
.agile {
  &__nav-button {
    background: transparent;
    border: none;
    color: #fff;
    cursor: pointer;
    height: 100%;
    position: absolute;
    top: 0;
    transition-duration: .3s;
    width: 80px;

    svg {
      max-height: 24px;
    }

    &:hover {
      background-color: rgba(#000, .5);
      opacity: 1;
    }

    &--prev {
      left: 0
    }

    &--next {
      right: 0
    }
  }

  &__dots {
    bottom: 10px;
    left: 50%;
    position: absolute;
    transform: translateX(-50%);
  }

  &__dot {
    margin: 0 10px;

    button {
      background-color: transparent;
      border: 1px solid #fff;
      border-radius: 50%;
      cursor: pointer;
      display: block;
      height: 10px;
      font-size: 0;
      line-height: 0;
      margin: 0;
      padding: 0;
      transition-duration: .3s;
      width: 10px;
    }

    &--current,
    &:hover {
      button {
        background-color: #fff;
        border: 1px solid #000;
      }
    }
  }
}

.slide {
  display: block;
  object-fit: contain;
  width: 100%;
  max-height: 210px;
  cursor: pointer;
}
</style>
