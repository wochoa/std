<template>
  <div>
    <acti-navbar />
    <div>
      <acti-control v-if="$route.name == 'ActiControl'" />
      <acti-valorizaciones v-if="$route.name == 'ActiValorizaciones'" />
      <acti-plazo v-if="$route.name == 'ActiPlazo'" :tipo-ruta="tipoRuta" />
      <acti-plazo v-if="$route.name == 'ActiAlcance'" :tipo-ruta="tipoRuta" />
    </div>
  </div>
</template>
<script>
import Vuex from 'vuex'
import ActiNavbar from '@/js/components/proyectos/actividades/ActiNavbar'
import ActiControl from '@/js/components/proyectos/actividades/ActiControl'
import ActiValorizaciones from '@/js/components/proyectos/actividades/ActiValorizaciones'
import ActiPlazo from '@/js/components/proyectos/actividades/ActiPlazo'
export default {

  components: {
    ActiNavbar,
    ActiControl,
    ActiValorizaciones,
    ActiPlazo
  },

  data() {
    return {
      tipoRuta: this.$attrs.tipo
    }
  },

  updated: function() {
    this.$nextTick(function() {
      if (this.tipoRuta != this.$attrs.tipo) {
        this.tipoRuta = this.$attrs.tipo
      }
    })
  },

  mounted() {
    this.selectProyecto(this.$route.params.idproyecto)
  },
  methods: {
    ...Vuex.mapActions(['selectProyecto'])
  }
}
</script>
