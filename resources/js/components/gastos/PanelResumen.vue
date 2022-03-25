<template>
  <div class="card">
    <div class="row no-gutters">
      <div
        v-for="(gasto, index) in getEstiloReporteGeneral"
        :key="index"
        class="col-12 col-lg-2 col-md-6 col-sm-6 p-2 d-flex flex-column align-items-center"
      >
        <v-progress-circular :size="150" :width="25" :value="getReporeteGeneralAvance(index)" :color="gasto.color">
          <div class="d-flex flex-column align-items-center">
            <div class="font-weight-bold">{{ gasto.text }}</div>
            <div class="font-weight-bold" style="font-size:24px">{{ getReporeteGeneralAvance(index) }}</div>
          </div>
        </v-progress-circular>
        <div class="m-2 font-weight-bold" style="font-size:24px">{{ getReporeteGeneralMonto(index) }}</div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'PanelResumen',
  computed: {
    ...mapGetters(['getEstiloReporteGeneral', 'getReporeteGeneralAvance', 'getReporeteGeneralMonto'])
  }
}
</script>
