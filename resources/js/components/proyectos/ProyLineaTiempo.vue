<template>
  <div>
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-toolbar-title>Guardar la version del plan</v-toolbar-title>
        </v-toolbar>
        <v-list three-line subheader>
          <v-container fluid>
            <v-row>
              <v-col cols="12" sm="12" md="12">
                <v-autocomplete
                  v-model="formVersion.vers_cargo"
                  :items="cargos"
                  outlined
                  label="Cargo"
                />
              </v-col>
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  v-model="formVersion.vers_observacion"
                  v-validate="'required'"
                  outlined
                  label="Observaciones"
                  :error-messages="errors.collect('vers_observacion')"
                  data-vv-name="vers_observacion"
                  @change="formVersion.vers_observacion = formVersion.vers_observacion.toUpperCase()"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-list>

        <v-card-actions>
          <v-spacer />
          <v-btn color="red darken-1" text @click="dialog = false">Cerrar</v-btn>
          <v-btn :disabled="puedeGuardar" color="blue darken-1" text @click="guardarVersion">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-row dense>
      <v-col cols="12" sm="6" md="2">
        <v-select
          v-model="filtro.version"
          :items="[{ text: 'Borrador', value: 1 }].concat(mostrarVersionsPlanProyetoSelected)"
          label="Version"
          @change="obternerPlan({ versionPlan: filtro.version })"
        />
      </v-col>

      <v-col cols="12" sm="6" md="2">
        <v-autocomplete
          v-model="filtro.anio"
          :items="getAniosReporte"
          label="Año"
          :hide-details="true"
          @change="
            obternerPlan({ anio: filtro.anio })
            getProyectoGastos()
            obternerVersionesPlan({ anio: filtro.anio })
          "
        />
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-autocomplete
          v-model="filtro.fuente"
          :items="showFuentesFinanciamiento"
          label="Fuente de financiamiento"
          :hide-details="true"
          @change="establecerFormGastos({ fft: filtro.fuente })"
        />
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-switch v-model="filtro.soloPresupuesto" class="ma-2" label="Mostrar solo con presupuesto" />
      </v-col>
      <v-col cols="12" sm="12" md="6">
        <v-btn outlined color="primary" @click="abrirModal"><v-icon left>mdi-floppy</v-icon> Guardar version</v-btn>
        <v-btn outlined color="primary"><v-icon left>mdi-printer</v-icon> Imprimir</v-btn>
      </v-col>
    </v-row>
    <div
      class="table-scroll"
      :style="tableDrag.tableStyle"
      @mousedown="
        tableDrag.tableStyle.cursor = '-webkit-grabbing'
        tableDrag.xPosition = $event.pageX
        tableDrag.clicked = true
      "
      @mouseup="
        tableDrag.tableStyle.cursor = '-webkit-grab'
        tableDrag.clicked = false
      "
      @mouseleave="
        tableDrag.tableStyle.cursor = '-webkit-grab'
        tableDrag.clicked = false
      "
      @mousemove="mousemove"
    >
      <v-simple-table fixed-header :dense="true" style="width: 2575px;">
        <template v-slot:default>
          <thead>
            <tr class="text-center active">
              <td width="500">ESPECIFICA</td>
              <td width="100">COSTO</td>
              <td width="100">EJEC ACUM {{ filtro.anio - 1 }}</td>
              <td width="100">PIM</td>
              <td width="100">DE</td>
              <td width="100">A</td>
              <td width="100">PROG.<br />FIN./ FIS.</td>
              <td width="100" style="border-right: solid #000 2px;">
                EJECUTADO<br />
                {{ filtro.anio }}
              </td>
              <td width="100">ENE</td>
              <td width="100">FEB</td>
              <td width="100">MAR</td>
              <td width="100">ABR</td>
              <td width="100">MAY</td>
              <td width="100">JUN</td>
              <td width="100">JUL</td>
              <td width="100">AGO</td>
              <td width="100">SET</td>
              <td width="100">OCT</td>
              <td width="100">NOV</td>
              <td width="100">DIC</td>
              <td width="250">ACCION</td>
            </tr>
          </thead>
          <tbody
            v-for="(componente, index) in mostrarAnaliticoProyectoSelected"
            v-if="
              getProyectoGastosCalculados({
                ANO_EJE: filtro.anio,
                FUENTE_FIN: filtro.fuente,
                COMPONENTE: parseInt(componente[0].ana_componente),
                ID_CLASIFI: null
              }).monto_pim > 0 || !filtro.soloPresupuesto
            "
            :key="index"
            :set="
              (gastoComp = getProyectoGastosCalculados({
                ANO_EJE: filtro.anio,
                FUENTE_FIN: filtro.fuente,
                COMPONENTE: parseInt(componente[0].ana_componente),
                ID_CLASIFI: null
              }))
            "
          >
            <tr class="separador_top">
              <td colspan="21"></td>
            </tr>
            <tr class="cyan lighten-4">
              <td>{{ showComponenteNombre(componente[0].ana_componente) }}</td>
              <td class="text-right">
                {{ formatDecimal(acarreo(componente, 'ana_monto') + acarreo(componente, 'ana_modificaciones')) }}
              </td>
              <td class="text-right">{{ formatDecimal(acarreo(componente, 'ejecutado')) }}</td>
              <td>{{ formatDecimal(gastoComp.monto_pim) }}</td>
              <td></td>
              <td></td>
              <td></td>
              <td class="border-right"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr
              v-for="(analitico, index2) in componente"
              v-show="
                getProyectoGastosCalculados({
                  ANO_EJE: filtro.anio,
                  FUENTE_FIN: filtro.fuente,
                  COMPONENTE: parseInt(analitico.ana_componente),
                  ID_CLASIFI: analitico.ana_especifca
                }).monto_pim > 0 || !filtro.soloPresupuesto
              "
              :key="index2"
              :set="
                (d = {
                  gasto: getProyectoGastosCalculados({
                    ANO_EJE: filtro.anio,
                    FUENTE_FIN: filtro.fuente,
                    COMPONENTE: parseInt(analitico.ana_componente),
                    ID_CLASIFI: analitico.ana_especifca
                  }),
                  plan: mostrarPlanProyectoSelected(
                    Object.assign({ plan_anio: filtro.anio, plan_fftt: filtro.fuente }, analitico)
                  ),
                  total: function() {
                    return (
                      this.plan.plan_m1 +
                      this.plan.plan_m2 +
                      this.plan.plan_m3 +
                      this.plan.plan_m4 +
                      this.plan.plan_m5 +
                      this.plan.plan_m6 +
                      this.plan.plan_m7 +
                      this.plan.plan_m8 +
                      this.plan.plan_m9 +
                      this.plan.plan_m10 +
                      this.plan.plan_m11 +
                      this.plan.plan_m12
                    )
                  }
                })
              "
            >
              <td>{{ showEspecificaDescripcion(analitico.ana_especifca) }}</td>
              <td class="text-right">{{ formatDecimal(analitico.ana_monto + analitico.ana_modificaciones) }}</td>
              <td class="text-right">{{ formatDecimal(analitico.ejecutado) }}</td>
              <td>{{ formatDecimal(d.gasto.monto_pim) }}</td>
              <td class="text-right de">
                {{ d.gasto.monto_pim > d.total() ? formatDecimal(d.gasto.monto_pim - d.total()) : '' }}
              </td>
              <td class="text-right">
                {{ d.total() > d.gasto.monto_pim ? formatDecimal(d.total() - d.gasto.monto_pim) : '' }}
              </td>
              <td class="text-right">{{ formatDecimal(d.total()) }}</td>
              <td class="text-right border-right">{{ formatDecimal(d.gasto.monto_dev) }}</td>
              <td class="text-right no-padding" v-for="n in 12" :key="n">
                <input
                  v-if="filtro.version === 1"
                  class="text-right"
                  type="text"
                  :value="formatDecimal(d.plan['plan_m' + n])"
                  @change="
                    updatePlan({
                      plan: mostrarPlanProyectoSelected(
                        Object.assign({ plan_anio: filtro.anio, plan_fftt: filtro.fuente }, analitico)
                      ),
                      n: n,
                      value: $event.target.value
                    })
                  "
                />
                <div v-else class="orange lighten-3">{{ formatDecimal(d.plan['plan_m' + n]) }}</div>
                <div class="grey lighten-4">{{ formatDecimal(d.gasto['g_' + (n + 1)]) }}</div>
              </td>
              <td></td>
            </tr>
            <tr class="separador_bottom">
              <td colspan="21"></td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </div>
  </div>
</template>
<script>
import Vuex from 'vuex'
export default {

  data() {
    return {
      formVersion: {},
      defaultForm: {
        vers_cargo: null,
        vers_observacion: null,
        vers_anio: null,
        vers_proyecto: null,
        analitico_version_id: 1
      },
      cargos: [
        { value: 'Residente de Obra', text: 'Residente de Obra' },
        { value: 'Administrador de Contrato de Obra', text: 'Administrador de Contrato de Obra' },
        { value: 'Supervisor de Obra', text: 'Supervisor de Obra' },
        { value: 'Inspector de Obra', text: 'Inspector de Obra' },
        { value: 'Evaluador de Proyecto', text: 'Evaluador de Proyecto' },
        { value: 'Asistente administrativo', text: 'Asistente administrativo' },
        { value: 'Especialista administrativo', text: 'Especialista administrativo' }
      ],
      filtro: {
        version: 1,
        anio: 2018,
        fuente: '00',
        soloPresupuesto: true
      },
      dialog: false,
      puedeGuardar: false,
      componentes: [],
      tableDrag: {
        tableStyle: {
          cursor: '-webkit-grab'
        },
        clicked: false,
        xPosition: null
      },
      planChanged: []
    }
  },

  computed: {
    ...Vuex.mapGetters([
      'mostrarAnaliticoProyectoSelected',
      'formatDecimal',
      'showComponenteNombre',
      'showEspecificaDescripcion',
      'showComponentes',
      'showEspecificasForSelect',
      'getAniosReporte',
      'showFuentesFinanciamiento',
      'getProyectoGastosCalculados',
      'mostrarProyectoSelected',
      'mostrarVersionsPlanProyetoSelected',
      'mostrarPlanProyectoSelected'
    ])
  },

  mounted() {
    this.obternerAnalitico({ act_proy: this.$route.params.idproyecto, version: this.filtro.version })
    this.establecerFormGastos({ anio: this.filtro.anio })
    this.getProyectoGastos()
    this.obternerPlan({
      versionPlan: this.filtro.version,
      anio: this.filtro.anio,
      fftt: this.filtro.fuente
    })
    this.obternerVersionesPlan({ anio: this.filtro.anio })
  },

  methods: {
    ...Vuex.mapActions([
      'obternerAnalitico',
      'obternerVersionesPlan',
      'establecerFormGastos',
      'getProyectoGastos',
      'obternerPlan',
      'updatePlan',
      'saveVersionPlan'
    ]),
    mousemove(e) {
      if (this.tableDrag.clicked) {
        let table = document.querySelector('.table-scroll')
        let max_scroll = table.scrollWidth - table.clientWidth
        let sLeft = table.scrollLeft + this.tableDrag.xPosition - e.pageX
        sLeft = sLeft < 0 ? 0 : sLeft > max_scroll ? max_scroll : sLeft
        table.scrollLeft = sLeft
        this.tableDrag.xPosition = e.pageX
      }
    },
    acarreo(obj, key) {
      var acarreo = 0
      for (var index in obj) acarreo += obj[index][key]
      return acarreo
    },
    variar(key, plan) {
      this.planChanged.push(key)
      console.log(plan)
    },
    editar(analitico) {
      let c = this.componentes.concat(this.showComponentes).filter(d => d.COMPONENTE === analitico.ana_componente)
      if (c.length !== 1)
        this.componentes.push({
          COMPONENTE: analitico.ana_componente,
          NOMBRE: 'COMPONENTE DESCONOCIDO'
        })
      this.$validator.reset()
      this.formAnalitico = JSON.parse(JSON.stringify(analitico))
      this.puedeGuardar = true
      this.dialog = true
    },
    abrirModal() {
      this.$validator.reset()
      this.formVersion = JSON.parse(JSON.stringify(this.defaultForm))
      this.formVersion.vers_anio = this.filtro.anio
      this.formVersion.vers_proyecto = this.mostrarProyectoSelected.proy_cod_siaf
      this.puedeGuardar = false
      this.dialog = true
    },
    guardarVersion() {
      if (!this.puedeGuardar) {
        this.$validator.validate().then(result => {
          if (result) {
            this.puedeGuardar = true
            this.saveVersionPlan(this.formVersion)
            this.dialog = false
          }
        })
      }
    }
  }
}
</script>

<style scoped>
thead tr th {
  background-color: red;
}
.separador_top td {
  padding: 0px;
  height: 10px;
  border-right: hidden !important;
  border-left: hidden !important;
  border-bottom: solid 2px #9e9c9c !important;
}
.separador_bottom td {
  padding: 0px;
  height: 10px;
  border-right: hidden !important;
  border-left: hidden !important;
  border-top: solid 2px grey !important;
}
table tbody tr td:last-child {
  border-right: solid grey 2px;
}
table tbody tr td:first-child {
  border-left: solid grey 2px;
}
table tbody tr:first-child {
  border-top: solid grey 2px;
}
table thead tr th {
  border-width: 1px;
  padding: 0px !important;
  text-align: center !important;
}

.border-right {
  border-right: 2px solid rgb(0, 0, 0);
}
table tbody td {
  padding: 0px 5px;
  border-right: 1px solid grey;
}
.no-padding {
  padding: 0px;
}
.no-padding div {
  padding: 0px 5px;
}
input {
  padding: 0px 5px !important;
  width: 100%;
}
.table-scroll {
  overflow-x: auto;
  padding-bottom: 50px;
}
.de {
  color: red;
}
</style>
