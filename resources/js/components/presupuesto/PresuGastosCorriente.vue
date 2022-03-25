<template>
  <div>
    <h1>Gastos Corriente</h1>
    <proy-gastos :form-gasto="formGastos" />
  </div>
</template>
<script>
import Vuex from 'vuex'
import ProyGastos from '@/js/components/proyectos/ProyGastos'
export default {
  components: {
    ProyGastos
  },

  data() {
    return {
      formGastos: {
        formato: ['ano_eje', 'fuente_financ', 'sec_func', 'id_clasificador', 'cert', 'compromiso', 'expediente'],
        anio: curryear
      }
    }
  },

  computed: {
    ...Vuex.mapGetters(['shwoUser'])
  },

  mounted: function() {
    this.newGastosCalculado()
    this.deleteReferenceProyectGasto()
    this.newFormGastos()
    this.formGastos.user_id = this.shwoUser
    this.establecerFormGastos(JSON.parse(JSON.stringify(this.formGastos)))
    this.getProyectoGastos(true)
  },
  methods: {
    ...Vuex.mapActions([
      'getProyectoGastos',
      'establecerFormGastos',
      'newFormGastos',
      'newGastosCalculado',
      'deleteReferenceProyectGasto'
    ]),
    ...Vuex.mapMutations(['setUser'])
  }
}
</script>
