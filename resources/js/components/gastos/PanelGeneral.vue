<template>
  <div>
    <panel-filtro />
    <panel-resumen />
    <div class="card">
      <v-tabs v-model="tabEjecucion" background-color="#ddd" color="basil">
        <v-tab v-for="(item1, indexTabs) in itemsEjecucion" :key="indexTabs">
          {{ item1.title }}
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="tabEjecucion">
        <v-tab-item v-for="(item1, indexTab) in itemsEjecucion" :key="indexTab">
          <v-card v-if="item1.content === 'PanelEjecucionAcumulada'" flat>
            <panel-ejecucion-acumulada />
          </v-card>
          <v-card v-if="item1.content === 'PanelEjecucionDiaria'" flat>
            <panel-ejecucion-diaria />
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </div>

    <div class="card">
      <v-tabs v-model="tab" background-color="#ddd" color="basil" grow>
        <v-tab v-for="(item, indexTabs) in items" :key="indexTabs" @click="cambiarTab">
          {{ item.title }}
        </v-tab>
      </v-tabs>
      <div class="row Filtros m-1 mb-3">
        <div class="col-12 col-sm-auto FiltrosGrupo">
          <label>Mostrar</label>
          <v-select
            v-model="filtroCicloGasto.selectValue"
            :items="show"
            :hide-details="true"
            flat
            class="FiltrosInput max-w-60"
            @change="
              obtenerCicloGasto({
                show: filtroCicloGasto.selectValue,
                tipo: tab,
                notas: filtroCicloGasto.notas,
                cuentaCorriente: filtroCicloGasto.cuentaCorriente,
                anulaciones: filtroCicloGasto.anulaciones
              })
            "
          />
        </div>

        <div class="col-12 col-sm FiltrosGrupo">
          <label>Buscar:</label>
          <v-text-field
            v-model="filtroCicloGasto.notas"
            class="FiltrosInput"
            :hide-details="true"
            @change="
              filtroCicloGasto.notas = filtroCicloGasto.notas.toUpperCase()
              obtenerCicloGasto({
                show: filtroCicloGasto.selectValue,
                tipo: tab,
                notas: filtroCicloGasto.notas,
                cuentaCorriente: filtroCicloGasto.cuentaCorriente,
                anulaciones: filtroCicloGasto.anulaciones
              })
            "
          />
        </div>

        <div class="col-12 col-sm-2 FiltrosGrupo">
          <v-switch
            v-model="filtroCicloGasto.cuentaCorriente"
            label="Gastos Corrientes"
            hide-details
            class="FiltrosInput"
            @change="
              obtenerCicloGasto({
                show: filtroCicloGasto.selectValue,
                tipo: tab,
                notas: filtroCicloGasto.notas,
                cuentaCorriente: filtroCicloGasto.cuentaCorriente,
                anulaciones: filtroCicloGasto.anulaciones
              })
            "
          />
        </div>

        <div class="col-12 col-sm-2 FiltrosGrupo">
          <v-switch
            v-model="filtroCicloGasto.anulaciones"
            label="Anulaciones"
            hide-details
            class="FiltrosInput"
            @change="
              obtenerCicloGasto({
                show: filtroCicloGasto.selectValue,
                tipo: tab,
                notas: filtroCicloGasto.notas,
                cuentaCorriente: filtroCicloGasto.cuentaCorriente,
                anulaciones: filtroCicloGasto.anulaciones
              })
            "
          />
        </div>
      </div>

      <v-tabs-items v-model="tab">
        <v-tab-item v-for="(item, indexTab) in items" :key="indexTab">
          <v-card v-if="item.content == 'PanelCertificados'" flat>
            <panel-certificados />
          </v-card>
          <v-card v-if="item.content == 'PanelCompromisoAnual'" flat>
            <panel-compromiso-anual />
          </v-card>
          <v-card v-if="item.content == 'PanelCompromiso'" flat>
            <panel-compromiso />
          </v-card>
          <v-card v-if="item.content == 'PanelDevengado'" flat>
            <panel-devengado />
          </v-card>
          <v-card v-if="item.content == 'PanelGirados'" flat>
            <panel-girados />
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </div>
    <panel-proyectos-seguimiento />
  </div>
</template>

<script>
import PanelFiltro from './PanelFiltro'
import PanelResumen from './PanelResumen'
import PanelEjecucionAcumulada from './PanelEjecucionAcumulada'
import PanelEjecucionDiaria from './PanelEjecucionDiaria'
import PanelCertificados from './PanelCertificados'
import PanelCompromisoAnual from './PanelCompromisoAnual'
import PanelCompromiso from './PanelCompromiso'
import PanelDevengado from './PanelDevengado'
import PanelGirados from './PanelGirados'
import PanelProyectosSeguimiento from './PanelProyectosSeguimiento'
import { mapActions } from 'vuex'
import { mapGetters } from 'vuex'

export default {
  name: 'PanelGeneral',
  components: {
    PanelFiltro,
    PanelResumen,
    PanelEjecucionAcumulada,
    PanelEjecucionDiaria,
    PanelCertificados,
    PanelCompromisoAnual,
    PanelCompromiso,
    PanelDevengado,
    PanelGirados,
    PanelProyectosSeguimiento
  },
  data() {
    return {
      tab: null,
      items: [
        { title: 'Certificados', content: 'PanelCertificados' },
        { title: 'Compromiso Anual', content: 'PanelCompromisoAnual' },
        { title: 'Compromiso', content: 'PanelCompromiso' },
        { title: 'Devengado', content: 'PanelDevengado' },
        { title: 'Girados', content: 'PanelGirados' }
      ],
      tabEjecucion: null,
      itemsEjecucion: [
        { title: 'Ejecución Acumulada', content: 'PanelEjecucionAcumulada' },
        { title: 'Ejecución Diaria', content: 'PanelEjecucionDiaria' }
      ],
      show: [10, 25, 50, 100],
      filtroCicloGasto: {
        selectValue: 100,
        notas: null,
        cuentaCorriente: false,
        anulaciones: false
      }
    }
  },
  mounted() {
    this.obtenerReporteGeneral({
      anio: curryear,
      oficina: null,
      act_proy: 'all'
    })
  },

  methods: {
    ...mapActions(['obtenerReporteGeneral', 'obtenerCicloGasto']),

    cambiarTab() {
      this.filtroCicloGasto = {
        selectValue: 100,
        notas: null,
        cuentaCorriente: false,
        anulaciones: false
      }
    }
  }
}
</script>

<style scoped></style>
