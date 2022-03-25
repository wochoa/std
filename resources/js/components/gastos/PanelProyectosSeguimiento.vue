<template>
  <v-col cols="12" sm="12" md="12">
    <v-card>
      <v-card-title>Proyectos en seguimiento</v-card-title>
      <v-card-text>
        <v-row dense>
          <v-col v-for="(presupuesto, index) in getPrioritarios" :key="index" cols="12" lg="4" md="6" sm="12">
            <v-card>
              <v-card-title class="headline">
                <u>{{ presupuesto.act_proy }}</u>
              </v-card-title>

              <v-card-subtitle style="height:100px">
                {{ mostrarProyectoByActProy(presupuesto.act_proy).proy_nombre }}
              </v-card-subtitle>

              <div class="d-flex flex-row">
                <div class="col col-2 py-1">P.I.M. :</div>
                <div class="col col-10 py-1">
                  <v-progress-linear color="primary" height="30" value="100" striped>
                    <b>{{ formatMoney(presupuesto.pim) }}</b>
                  </v-progress-linear>
                </div>
              </div>

              <div class="d-flex flex-row">
                <div class="col col-2 py-1">Cert. :</div>
                <div class="col col-10 py-1">
                  <v-progress-linear
                    color="success"
                    height="30"
                    :value="(presupuesto.monto_cert / presupuesto.pim) * 100"
                    striped
                  >
                    <b>{{ formatMoney(presupuesto.monto_cert) }}</b>
                  </v-progress-linear>
                </div>
              </div>

              <div class="d-flex flex-row">
                <div class="col col-2 py-1">Comp. :</div>
                <div class="col col-10 py-1">
                  <v-progress-linear
                    color="warning"
                    height="30"
                    :value="(presupuesto.monto_comp / presupuesto.pim) * 100"
                    striped
                  >
                    <b>{{ formatMoney(presupuesto.monto_comp) }}</b>
                  </v-progress-linear>
                </div>
              </div>

              <div class="d-flex flex-row">
                <div class="col col-2 pt-1">Dev. :</div>
                <div class="col col-10 pt-1">
                  <v-progress-linear
                    color="#dc3545"
                    height="30"
                    :value="(presupuesto.monto_dev / presupuesto.pim) * 100"
                    striped
                  >
                    <b>{{ formatMoney(presupuesto.monto_dev) }}</b>
                  </v-progress-linear>
                </div>
              </div>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-col>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'PanelProyectosSeguimiento',
  computed: {
    ...mapGetters(['mostrarProyectoByActProy', 'getPrioritarios', 'formatMoney'])
  }
}
</script>

<style scoped></style>
