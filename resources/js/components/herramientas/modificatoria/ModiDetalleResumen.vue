<template>
  <table class="no-border" width="100%">
    <tbody>
      <tr v-if="dato.limite > 0">
        <td><strong>Limite: </strong></td>
        <td class="text-right">{{ formatDecimal(dato.limite) }}</td>
      </tr>
      <tr>
        <td><strong>Acumulado: </strong></td>
        <td class="text-right">{{ formatDecimal(dato.acumulado) }}</td>
      </tr>
      <tr v-if="dato.otras_ejecutoras > 0">
        <td><strong>Otras Ejecutoras:</strong></td>
        <td class="text-right">{{ formatDecimal(dato.otras_ejecutoras) }}</td>
      </tr>
      <tr>
        <td><strong>PIM:</strong></td>
        <td class="text-right">{{ formatDecimal(dato.pim) }}</td>
      </tr>
      <tr v-if="dato.limite > 0">
        <td style="border-top: solid 1px;"><strong>Saldo:</strong></td>
        <td class="text-right" style="border-top: solid 1px;">
          {{ dato.limite - dato.acumulado + dato.otras_ejecutoras + dato.pim }}
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import Vuex from 'vuex'
export default {

  name: 'ModiDetalleResumen',

  props: ['dato'],

  computed: {
    ...Vuex.mapGetters(['formatDecimal'])
  }
}
</script>

<style scoped>
.no-border td {
  border: 0px !important;
}
tr {
  background-color: transparent !important;
  border-color: transparent !important;
}
</style>
