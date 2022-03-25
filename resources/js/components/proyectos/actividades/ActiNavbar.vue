<template>
  <div class="overflow-hidden">
    <div class="text-center mb-2">
      <v-btn text color="deep-purple" @click="showNav = !showNav">
        {{ mostrarContratoNombreSelectd }}
      </v-btn>
    </div>

    <v-bottom-navigation color="indigo">
      <v-btn :to="{ name: 'ProyContratos', params: { idproyecto: $route.params.idproyecto } }" exact>
        <span>Contratos</span>
        <v-icon>mdi-file-document-edit</v-icon>
      </v-btn>
      <v-btn
        :to="{
          name: 'ActiControl',
          params: { idproyecto: $route.params.idproyecto, idcontrato: $route.params.idcontrato }
        }"
      >
        <span>Actividades adicionales</span>
        <v-icon>mdi-clipboard-list</v-icon>
      </v-btn>
      <v-btn
        :to="{
          name: 'ActiValorizaciones',
          params: { idproyecto: $route.params.idproyecto, idcontrato: $route.params.idcontrato }
        }"
      >
        <span>Control de Avance</span>
        <v-icon>mdi-clipboard-list</v-icon>
      </v-btn>
      <v-btn
        :to="{
          name: 'ActiPlazo',
          params: { idproyecto: $route.params.idproyecto, idcontrato: $route.params.idcontrato }
        }"
      >
        <span>Control de Plazos</span>
        <v-icon>mdi-clipboard-list</v-icon>
      </v-btn>
      <v-btn
        :to="{
          name: 'ActiAlcance',
          params: { idproyecto: $route.params.idproyecto, idcontrato: $route.params.idcontrato }
        }"
      >
        <span>Control de Alcance</span>
        <v-icon>mdi-clipboard-list</v-icon>
      </v-btn>
    </v-bottom-navigation>
  </div>
</template>
<script>
import Vuex from 'vuex'

export default {

  data() {
    return {
      activeBtn: 1,
      showNav: true
    }
  },

  computed: {
    ...Vuex.mapGetters(['mostrarContratoNombreSelectd'])
  },

  mounted() {
    this.selectContrato(this.$route.params.idcontrato)
  },

  methods: {
    ...Vuex.mapActions(['selectContrato'])
  }
}
</script>
