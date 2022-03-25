<template>
  <div class="overflow-hidden">
    <div class="text-center mb-2">
      <v-btn text color="deep-purple">{{ mostrarProyectoNombreSelected }}</v-btn>
    </div>

    <v-tabs grow dense centered icons-and-text background-color="#dfdfdf" height="48px">
      <v-tab :to="{ name: 'ProyAnalitico', params: { idproyecto: $route.params.idproyecto } }">
        Analitico de gasto
        <span class="icon icon-calculator fs-22"></span>
      </v-tab>
      <v-tab :to="{ name: 'ProyGastos', params: { idproyecto: $route.params.idproyecto } }">
        Gastos
        <span class="icon icon-stats-dots fs-22"></span>
      </v-tab>
      <v-tab :to="{ name: 'ProyComponentesTareas', params: { idproyecto: $route.params.idproyecto } }">
        Componentes tareas
        <span class="icon icon-list-numbered fs-22"></span>
      </v-tab>
      <v-tab :to="{ name: 'ProyLineaTiempo', params: { idproyecto: $route.params.idproyecto } }">
        Programacion
        <span class="icon icon-keyboard fs-22"></span>
      </v-tab>
      <v-tab :to="{ name: 'ProyContratos', params: { idproyecto: $route.params.idproyecto } }">
        Contratos
        <span class="icon icon-files-empty fs-22"></span>
      </v-tab>
      <v-tab :to="{ name: 'ProyInformes', params: { idproyecto: $route.params.idproyecto } }">
        Informes
        <span class="icon icon-file-picture fs-22"></span>
      </v-tab>
    </v-tabs>
  </div>
</template>
<script>
import Vuex from 'vuex'
export default {
  data() {
    return {}
  },
  computed: {
    ...Vuex.mapGetters(['mostrarProyectoNombreSelected'])
  }
}
</script>
