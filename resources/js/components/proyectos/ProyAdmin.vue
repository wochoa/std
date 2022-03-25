<template>
  <div>
    <proy-navbar-admin />

    <proy-contratos v-if="$route.name == 'ProyContratos'" />
    <proy-analitico v-if="$route.name == 'ProyAnalitico'" />
    <proy-gastos v-if="$route.name == 'ProyGastos'" />
    <proy-componentes-tareas v-if="$route.name == 'ProyComponentesTareas'" />
    <proy-linea-tiempo v-if="$route.name == 'ProyLineaTiempo'" />
    <proy-informes v-if="$route.name == 'ProyInformes'" />
  </div>
</template>
<script>
import ProyNavbarAdmin from '@/js/components/proyectos/ProyNavbarAdmin'
import ProyContratos from '@/js/components/proyectos/ProyContratos'
import ProyAnalitico from '@/js/components/proyectos/ProyAnalitico'
import ProyComponentesTareas from '@/js/components/proyectos/ProyComponentesTareas'
import ProyGastos from '@/js/components/proyectos/ProyGastos'
import ProyLineaTiempo from '@/js/components/proyectos/ProyLineaTiempo'
import ProyInformes from '@/js/components/proyectos/ProyInformes'
import Vuex from 'vuex'
export default {

  components: {
    ProyNavbarAdmin,
    ProyContratos,
    ProyAnalitico,
    ProyGastos,
    ProyComponentesTareas,
    ProyLineaTiempo,
    ProyInformes
  },

  mounted() {
    this.selectProyecto(this.$route.params.idproyecto)
  },

  methods: {
    ...Vuex.mapActions(['selectProyecto'])
  }
}
</script>
