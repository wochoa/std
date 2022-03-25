<template>
  <div>
    <v-col cols="12" sm="12" md="12">
      <v-card>
        <v-card-title>Proyectos</v-card-title>
        <v-card-text>
          <v-row dense>

            <v-col cols="12" lg="4" md="6" sm="12">
              <v-card>
                <v-card-title class="headline">
                  <u>Resumen</u>
                </v-card-title>

                <v-card-subtitle style="height:100px">Proyectos x Año
                </v-card-subtitle>

                <div v-for="(project, index) in showTotalProjectYear" :key="index" class="d-flex flex-row">
                  <div class="col col-3 py-1"><strong>{{ index }}</strong></div>
                  <div class="col col-9 py-1">
                    {{ project }}
                  </div>
                </div>
               
              </v-card>
            </v-col>
            
            <v-col cols="12" lg="4" md="6" sm="12">
              <v-card>
                <v-card-title class="headline">
                  <u>Proyectos</u>
                </v-card-title>

                <v-card-subtitle style="height:100px">Proyectos
                </v-card-subtitle>

                <div class="d-flex flex-row">
                  <div class="col col-3 py-1">Total Proyecto</div>
                  <div class="col col-9 py-1">
                    <v-progress-linear color="primary" height="30" value="100" striped>
                      <b>55</b>
                    </v-progress-linear>
                  </div>
                </div>

                <div class="d-flex flex-row">
                  <div class="col col-3 py-1">Proyectos culminados</div>
                  <div class="col col-9 py-1">
                    <v-progress-linear
                      color="success"
                      height="30"
                      :value="20"
                      striped
                    >
                      <b>15</b>
                    </v-progress-linear>
                  </div>
                </div>

                <div class="d-flex flex-row">
                  <div class="col col-3 py-1">Proyectos en ejecución</div>
                  <div class="col col-9 py-1">
                    <v-progress-linear
                      color="warning"
                      height="30"
                      :value="40"
                      striped
                    >
                      <b>30</b>
                    </v-progress-linear>
                  </div>
                </div>

                <div class="d-flex flex-row">
                  <div class="col col-3 pt-1">Proyectos paralizados</div>
                  <div class="col col-9 pt-1">
                    <v-progress-linear
                      color="#dc3545"
                      height="30"
                      :value="5"
                      striped
                    >
                      <b>5</b>
                    </v-progress-linear>
                  </div>
                </div>
              </v-card>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  export default {
    data () {
      return {}
    },

    computed: {
      ...mapGetters(['showTotalProjectYear'])
    },
    mounted() {
      this.getTotalProjectYear()
    },

    methods: {
      ...mapActions(['getTotalProjectYear'])
    }
  }
</script>

<style scoped>

</style>
