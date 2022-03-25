<template>
  <div>
    <div class="panel-body">
      <div class="row Filtros m-1 mb-2">
        <div class="col-12 col-sm-2 FiltrosGrupo">
          <label>Año</label>
          <v-select
            v-model="filtro.anio"
            :items="getAniosReporte"
            :hide-details="true"
            flat
            class="FiltrosInput max-w-100"
            @change="getMetas(filtro.anio)"
          />
        </div>

        <div class="col-12 col-sm-2 FiltrosGrupo">
          <label>Sec. Funcional</label>
          <v-text-field
            v-model="filtro.sec_func"
            class="FiltrosInput"
            :hide-details="true"
          />
        </div>

        <div class="col-12 col-sm-4 FiltrosGrupo">
          <label>Programa</label>
          <v-autocomplete
            v-model="filtro.programa"
            :items="componentes.concat(showProgramasComponente)"
            :hide-details="true"
            flat
            class="FiltrosInput max-w-150"
            :item-text="item =>( (item.programa_ppto != '')?item.programa_ppto + ' - ':'') + item.nombre"
            item-value="programa_ppto"
          />
        </div>

        <div class="col-12 col-sm-4 FiltrosGrupo">
          <label>Componente</label>
          <v-text-field
            v-model="filtro.componente"
            class="FiltrosInput"
            :hide-details="true"
          />
        </div>
      </div>

      <!--Modal Asignar Oficina-->
      <v-dialog v-model="dialog" max-width="1200px">
        <v-card>
          <v-toolbar dark color="primary">
            <v-btn icon dark @click="cerrarModal()">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Asignar Metas por Oficina</v-toolbar-title>
            <v-spacer />
            <v-toolbar-items>
              <v-btn dark text :disabled="puedeGuardar" @click="actualizarMetas()">Guardar</v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-list three-line subheader>
            <v-container fluid>
              <v-row dense>
                <v-col cols="6" md="3">
                  <div class="subheading"><strong>SEC. FUNCIONAL</strong></div>
                </v-col>
                <v-col cols="6" md="9">
                  <div class="body-1">{{ ('000000'+formMetas.sec_func).slice(-4) }}</div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6" md="3">
                  <div class="subheading"><strong>PROGRAMA</strong></div>
                </v-col>
                <v-col cols="6" md="9">
                  <div class="body-1">{{ showOneProgramaComponente(formMetas.programa_ppto) }}</div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6" md="3">
                  <div class="subheading"><strong>Prod / Proy</strong></div>
                </v-col>
                <v-col cols="6" md="9">
                  <div class="body-1">{{ formMetas.act_proy }}</div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6" md="3">
                  <div class="subheading"><strong>Act / AI / Obra</strong></div>
                </v-col>
                <v-col cols="6" md="9">
                  <div class="body-1">{{ showOneComponente(formMetas.componente) }}</div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6" md="3">
                  <div class="subheading"><strong>FUNCIÓN</strong></div>
                </v-col>
                <v-col cols="6" md="9">
                  <div class="body-1">{{ showOneFuncion(formMetas.funcion) }}</div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6" md="3">
                  <div class="subheading"><strong>DIVISIÓN FUNCIONAL</strong></div>
                </v-col>
                <v-col cols="6" md="9">
                  <div class="body-1">{{ showOneDivisionFuncional(formMetas.programa) }}</div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6" md="3">
                  <div class="subheading"><strong>GRUPO FUNCIONAL</strong></div>
                </v-col>
                <v-col cols="6" md="9">
                  <div class="body-1">{{ showOneGrupoFuncional(formMetas.sub_programa) }}</div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6" md="3">
                  <div class="subheading"><strong>META</strong></div>
                </v-col>
                <v-col cols="6" md="9">
                  <div class="body-1">{{ formMetas.meta }}</div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6" md="3">
                  <div class="subheading"><strong>FINALIDAD</strong></div>
                </v-col>
                <v-col cols="6" md="9">
                  <div class="body-1">{{ formMetas.finalidad }}</div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="6" md="3">
                  <div class="subheading"><strong>PIM</strong></div>
                </v-col>
                <v-col cols="6" md="9">
                  <div class="body-1">{{ formatMoney(formMetas.pim) }}</div>
                </v-col>
              </v-row>
              <v-row dense>
                <v-col cols="4" md="3">
                  <div class="subheading"><strong>OFICINA</strong></div>
                </v-col>
                <v-col cols="4" md="1">
                  <v-text-field
                    v-model="formMetas.proy_tram_dependencia"
                    outlined
                    @change="formMetas.proy_tram_dependencia = parseInt(formMetas.proy_tram_dependencia)"
                  />
                </v-col>
                <v-col cols="4" md="8">
                  <v-autocomplete
                    v-model="formMetas.proy_tram_dependencia"
                    v-validate="'required'"
                    label="OFICINA"
                    outlined
                    :items="mostarOficinas"
                    item-text="depe_nombre"
                    item-value="iddependencia"
                    :error-messages="errors.collect('dependencia')"
                    data-vv-name="dependencia"
                  />
                </v-col>
              </v-row>
            </v-container>
          </v-list>
          <v-divider />
          <v-list three-line subheader />
        </v-card>
      </v-dialog>
      <!--fin modal-->
      <!--Modal Ver Gastos por meta-->
      <v-dialog v-model="dialogShow" max-width="1600px">
        <v-card>
          <v-toolbar dark color="primary">
            <v-btn icon dark @click="cerrarModalShow()">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Gastos por meta</v-toolbar-title>
            <v-spacer />
            <v-toolbar-items>
              <v-btn dark text @click="cerrarModalShow()">Cerrar</v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-list three-line subheader>
            <v-container fluid>
              <proy-gastos
                :form-gasto="formGastos"
              />
            </v-container>
          </v-list>
          <v-divider />
          <v-list three-line subheader />
        </v-card>
      </v-dialog>
      <!--fin modal-->

      <proy-table
        width="100%"
        class="ListadoTabla estatico"
        :items="metasFilter"
        tag="metas"
        :page-length="50">
        <template slot="actions" slot-scope="data">
          <div v-if="data.selected.index !== null" class="d-flex">
            <v-btn
              small
              color="#1976d2"
              class="white--text"
              @click="asignarOficina(data.selected.item)"
            >
              Asignar
              <v-icon right>mdi-pencil</v-icon>
            </v-btn>
            <v-btn small @click="verGastoCorriente(data.selected.item.sec_func)">
              Ver
              <v-icon right>mdi-format-list-bulleted</v-icon>
            </v-btn>
          </div>
        </template>
        <template slot="header">
          <tr>
            <th style="width: 10%">AÑO</th>
            <th style="width: 30%">CADENA PRESUPUESTAL</th>
            <th style="width: 30%">COMPONENTE</th>
            <th style="width: 10%">PIM</th>
            <th style="width: 20%">OFICINA</th>
          </tr>
        </template>
        <template slot="body" slot-scope="row">
          <td style="width: 10%">{{ row.item.ano_eje }}</td>
          <td style="width: 30%">{{ row.item.sec_func+ '.' + row.item.programa_ppto + '.' + row.item.act_proy + '.' + row.item.componente + '.' + row.item.funcion + '.' + row.item.programa + '.' + row.item.sub_programa + '.' + row.item.meta }}</td>
          <td style="width: 30%">{{ row.item.act_proy + ' - ' + row.item.nombre }}</td>
          <td style="width: 10%">{{ formatMoney(row.item.pim) }}</td>
          <td style="width: 20%">{{ showNameOficina(row.item.proy_tram_dependencia) }}</td>
        </template>
      </proy-table>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'
  import ProyGastos from '@/js/components/proyectos/ProyGastos'
  import ProyTable from '@/js/components/proyectos/ProyTable'

  export default {

    components: {
      ProyGastos,
      ProyTable
    },
    data () {
      return {
        filtro: {
          anio: curryear,
          componente: null,
          sec_func: null,
          programa: null
        },
        formPresupuesto: {
          id_presupuesto: null,
          proy_siaf_anio: null,
          proy_sec_ejec: null,
          proy_siaf_sec_func: null,
          proy_tram_dependencia: null
        },
        formMetas: {
          ano_eje: null,
          sec_ejec: null,
          sec_func: null,
          programa_ppto: null,
          act_proy: null,
          componente: null,
          funcion: null,
          programa: null,
          sub_programa: null,
          meta: null,
          finalidad: null,
          nombre: null,
          id_presupuesto: null,
          proy_tram_dependencia: null,
          pim: null
        },
        defaultFormMetas: {},
        dialog: false,
        dialogShow: false,
        puedeGuardar: false,
        componentes: [
          {
            programa_ppto: '',
            nombre: 'Todos'
          }],
        formGastos: {
          formato: ['ano_eje', 'fuente_financ', 'sec_func', 'id_clasificador', 'cert', 'compromiso', 'expediente'],
          anio: curryear
        }
      }
    },

    computed: {
      ...Vuex.mapGetters([
        'mostrarMetas',
        'mostarOficinas',
        'getAniosReporte',
        'getOneMeta',
        'showOneProgramaComponente',
        'showOneFuncion',
        'showOneDivisionFuncional',
        'showOneGrupoFuncional',
        'showProgramasComponente',
        'showOneComponente',
        'formatMoney',
        'showNameOficina']),

      metasFilter(){
        let filtrado = this.mostrarMetas
        if(this.filtro.sec_func != null && this.filtro.sec_func !== '') {
          if(this.filtro.sec_func.length == 4){
            filtrado = filtrado.filter( d => d.sec_func === this.filtro.sec_func)
          }
        }
        if(this.filtro.programa != null && this.filtro.programa !== '') {
          filtrado = filtrado.filter( d => d.programa_ppto === this.filtro.programa)
        }
        if(this.filtro.componente != null && this.filtro.componente !== '') {
          let words = this.filtro.componente.split(' ')
          for (let i = 0; i < words.length; i++) {
            filtrado = filtrado.filter( d => d.nombre != null && d.nombre.toLowerCase().indexOf(words[i].toLowerCase()) > -1 )
          }
        }
        return filtrado
      }
    },

    created: function () {
      this.defaultFormMetas = JSON.parse(JSON.stringify(this.formMetas))
    },

    updated: function () {
      this.$nextTick(function () {

        if (this.filtro.anio != this.formGastos.anio) {
          this.formGastos.anio = this.filtro.anio
        }
      })
    },

    mounted () {
      this.getProgramasComponente()
      this.getDivisionesFuncionales()
      this.getGruposFuncionales()
      this.getMetas(this.filtro.anio)
      this.getOficinas()
      this.deleteReferenceProyectGasto()
      this.newFormGastos()
    },

    methods: {

      ...Vuex.mapActions([
        'getMetas',
        'getOficinas',
        'getProgramasComponente',
        'getDivisionesFuncionales',
        'getGruposFuncionales',
        'savePresupuesto',
        'getProyectoGastos',
        'establecerFormGastos',
        'newFormGastos',
        'newGastosCalculado',
        'deleteReferenceProyectGasto']),

      asignarOficina (item) {
        this.$validator.reset()
        this.puedeGuardar = false
        this.dialog = true
        this.formMetas = JSON.parse(JSON.stringify(this.getOneMeta(item)))
      },
      cerrarModal () {
        this.dialog = false
        this.formMetas = JSON.parse(JSON.stringify(this.defaultFormMetas))
      },

      actualizarMetas () {
        this.formPresupuesto.proy_siaf_anio = this.formMetas.ano_eje
        this.formPresupuesto.proy_sec_ejec = this.formMetas.sec_ejec
        this.formPresupuesto.proy_siaf_sec_func = this.formMetas.sec_func
        this.formPresupuesto.id_presupuesto = this.formMetas.id_presupuesto
        this.formPresupuesto.proy_tram_dependencia = this.formMetas.proy_tram_dependencia

        this.savePresupuesto(this.formPresupuesto)
        this.dialog = false

      },
      // nameFilter (value) {
      //   // If this filter has no value we just skip the entire filter.
      //   if (!this.filtro.dessertFilterValue) {
      //     return true
      //   }
      //   // Check if the current loop value (The dessert name)
      //   // partially contains the searched word.
      //   return value.toLowerCase().includes(this.filtro.dessertFilterValue.toLowerCase())
      // },
      //
      // metaFilter (value) {
      //   let filtrado = true
      //   if (this.filtro.programaFilterValue && filtrado) {
      //     filtrado = value.split('.')[1].includes(this.filtro.programaFilterValue)
      //   }
      //   if (this.filtro.secFunFilterValue && filtrado) {
      //     filtrado = value.split('.')[0].includes(this.filtro.secFunFilterValue)
      //   }
      //   return filtrado
      // },

      verGastoCorriente (item) {
        this.dialogShow = true
        this.formGastos.sec_func = item
        this.establecerFormGastos(JSON.parse(JSON.stringify(this.formGastos)))
        this.getProyectoGastos(true)
      },

      cerrarModalShow () {
        this.dialogShow = false
        this.newGastosCalculado()
      }
    }
  }
</script>

