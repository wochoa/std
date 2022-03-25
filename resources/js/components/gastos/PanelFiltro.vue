<template>
  <v-row dense no-gutters class="Filtros FiltrosEstatico sticky-top">
    <v-col cols="12" sm="6" md="2" class="FiltrosGrupo">
      <label>Año</label>
      <v-select
        v-model="filtro.anio"
        :items="getAniosReporte"
        :hide-details="true"
        class="FiltrosInput"
        flat
        @change="updateReporte"
      />
    </v-col>
    <v-col cols="12" sm="6" md="5" class="FiltrosGrupo">
      <label>Oficina</label>
      <v-autocomplete
        v-model="filtro.oficina"
        :items="[{ text: 'Todos', value: null }].concat(mostarOficinasForSelect)"
        :hide-details="true"
        class="FiltrosInput"
        @change="obtenerReporteGeneral(Object.assign({},filtro))"
      />
    </v-col>
    <v-col cols="12" sm="6" md="5" class="FiltrosGrupo">
      <label>Actividad/Proyecto</label>
      <v-autocomplete
        v-model="filtro.act_proy"
        :items="[{ text: 'Todos', value: 'all' }].concat(mostrarProyectosForSelect)"
        :hide-details="true"
        item-value="value"
        :filter="filtroProyectos"
        class="FiltrosInput"
        @change="obtenerReporteGeneral(Object.assign({},filtro))"
      />
    </v-col>
  </v-row>
</template>
ö
<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'PanelFiltro',
  data() {
    return {
      filtro: {
        anio: curryear,
        oficina: null,
        act_proy: 'all'
      }
    }
  },

  mounted () {
    this.getSecfuncOficinas(this.filtro.anio)
    this.getActProyecto(this.filtro.anio)
  },
  computed: {
    ...mapGetters(['getAniosReporte', 'mostarOficinasForSelect', 'mostrarProyectosForSelect'])
  },
  methods: {
    ...mapActions(['obtenerReporteGeneral','getSecfuncOficinas','getActProyecto']),

    filtroProyectos(item, queryText, itemText) {
      let status = true
      let words = queryText.split(' ')
      for (let i = 0; i < words.length; i++)
        if (itemText.toUpperCase().indexOf(words[i].toUpperCase()) === -1) status = false
      return status
    },

    updateReporte(){
      this.obtenerReporteGeneral(Object.assign({},this.filtro))
      this.getSecfuncOficinas(this.filtro.anio)
      this.getActProyecto(this.filtro.anio)
    }
  }
}
</script>

<style scoped></style>
