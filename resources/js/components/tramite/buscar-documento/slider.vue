<template>
  <div>
    <transition-group name="fade" tag="div">
      <div v-for="i in [currentIndex]" :key="i">
        <img :src="currentImg" />
      </div>
    </transition-group>
    <a v-if="getBuscarImagenesCantidad > 1" class="prev" href="#" @click="prev">&#10094; Previous</a>
    <a v-if="getBuscarImagenesCantidad > 1" class="next" href="#" @click="next">&#10095; Next</a>
  </div>
</template>

<script>
  import Vuex from 'vuex'
export default {
  name: 'slider',

  data() {
    return {
      timer: null,
      currentIndex: 0
    }
  },

  computed: {
    ...Vuex.mapGetters(['getBuscarImagenesCantidad', 'getBuscarImagenesRuta']),
    currentImg: function() {
      return this.getBuscarImagenesRuta[Math.abs(this.currentIndex) % this.getBuscarImagenesRuta.length]
    }
  },

  mounted: function() {
    this.startSlide()
  },

  methods: {
    startSlide: function() {
      if (this.getBuscarImagenesCantidad > 1) this.timer = setTimeout(this.next, 6000)
    },

    next: function() {
      this.currentIndex += 1
      clearTimeout(this.timer)
      this.timer = setTimeout(this.next, 6000)
    },
    prev: function() {
      this.currentIndex -= 1
      clearTimeout(this.timer)
      this.timer = setTimeout(this.next, 6000)
    }
  }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.9s ease;
  overflow: hidden;
  visibility: visible;
  position: absolute;
  width: 100%;
  opacity: 1;
}

.fade-enter,
.fade-leave-to {
  visibility: hidden;
  width: 100%;
  opacity: 0;
}

img {
  width: 100%;
}

.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.7s ease;
  border-radius: 0 4px 4px 0;
  text-decoration: none;
  user-select: none;
}

.next {
  right: 0;
}

.prev {
  left: 0;
}

.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.9);
}
</style>
