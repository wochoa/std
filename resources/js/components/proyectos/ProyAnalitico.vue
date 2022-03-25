<template>
  <div>
    <!--Modal nuevo analitico-->
    <v-dialog v-model="dialog" max-width="1000px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="cerrarModal()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title v-if="modoEdit">Editar Analitico</v-toolbar-title>
          <v-toolbar-title v-else>Crear un nuevo Registro</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn dark text :disabled="puedeGuardar" @click="guardarAnalitico()">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-list three-line subheader>
          <div class="d-flex flex-wrap">
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Componente</v-label>
              <v-autocomplete
                v-model="formAnalitico.ana_componente"
                v-validate="'required'"
                :item-text="item => item.componente + ' - ' + item.nombre"
                item-value="componente"
                :items="componentes.concat(showComponentes)"
                :error-messages="errors.collect('ana_componente')"
                data-vv-name="ana_componente"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Especifica</v-label>
              <v-autocomplete
                v-model="formAnalitico.ana_especifca"
                v-validate="'required'"
                dense
                :items="showEspecificasForSelect"
                :error-messages="errors.collect('ana_especifca')"
                data-vv-name="ana_especifca"
                solo
              />
            </div>
            <div class="col-12 col-sm-3  ProyectosFormulario">
              <v-label>Monto Inicial</v-label>
              <v-text-field
                v-model="formAnalitico.ana_monto"
                v-validate="'required|decimal'"
                type="number"
                :error-messages="errors.collect('ana_monto')"
                data-vv-name="ana_monto"
                solo
              />
            </div>
            <div class="col-12 col-sm-3  ProyectosFormulario">
              <v-label>Modificaciones</v-label>
              <v-text-field
                v-model="formAnalitico.ana_modificaciones"
                v-validate="'required|decimal'"
                type="number"
                :error-messages="errors.collect('ana_modificaciones')"
                data-vv-name="ana_modificaciones"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Descripción</v-label>
              <v-text-field
                v-model="formAnalitico.ana_descricion"
                @change="formAnalitico.ana_descricion = formAnalitico.ana_descricion.toUpperCase()"
                solo
              />
            </div>
          </div>
        </v-list>
        <v-divider />
        <v-list three-line subheader />
      </v-card>
    </v-dialog>
    <!--fin modal-->

    <!--Modal Nueva version-->
    <v-dialog v-model="dialogVersion" max-width="500px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-toolbar-title>Guardar la version del analitico</v-toolbar-title>
        </v-toolbar>
        <v-list three-line subheader>
          <div class="d-flex flex-wrap">
            <div class="col-12 ProyectosFormulario">
              <v-autocomplete
                v-model="formVersion.vers_cargo"
                :items="cargos"
                solo
                label="Cargo" />
            </div>
            <div class="col-12 ProyectosFormulario">
              <v-textarea
                v-model="formVersion.vers_observacion"
                v-validate="'required'"
                solo
                label="Observaciones"
                :error-messages="errors.collect('vers_observacion')"
                data-vv-name="vers_observacion"
                @change="formVersion.vers_observacion = formVersion.vers_observacion.toUpperCase()"
              />
            </div>
          </div>
        </v-list>
        <v-card-actions>
          <v-spacer />
          <v-btn color="red darken-1" text @click="dialogVersion = false">Cerrar</v-btn>
          <v-btn color="blue darken-1" text :disabled="puedeGuardar" @click="guardarVersion">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!--fin modal-->
    <div class="Tabulador d-flex align-items-baseline">
      <v-col cols="12" sm="6" md="4" class="Filtros">
        <v-select
          v-model="version"
          class="FiltrosInput"
          :items="[{ text: 'Borrador', value: 1 }].concat(showVersionsAnaliticoProyectSelect)"
        />
      </v-col>
      <v-col cols="12" sm="6" md="8">
        <v-btn outlined color="primary" @click="agregar">
          <v-icon left>mdi-file-plus</v-icon>
          Agregar
        </v-btn>
        <v-btn outlined color="primary" @click="abrirModal">
          <v-icon left>mdi-floppy</v-icon>
          Guardar version
        </v-btn>
        <v-btn outlined color="primary" @click="printAnalitico(version)">
          <v-icon left>mdi-printer</v-icon>
          Imprimir
        </v-btn>
      </v-col>
    </div>
    <div>
      <v-simple-table fixed-header dense>
        <template v-slot:default>
          <thead>
            <tr>
              <th>Especifica</th>
              <th>Observación</th>
              <th>Monto Inicial</th>
              <th>Monto Modif.</th>
              <th>Monto Vigente</th>
              <th>Ejecutado</th>
              <th>Saldo</th>
            </tr>
          </thead>
          <tbody v-for="(componente, index) in mostrarAnaliticoProyectoSelected" :key="index">
            <tr class="cyan lighten-4">
              <td colspan="2">{{ showComponenteNombre(componente[0].ana_componente) }}</td>

              <td class="text-right">{{ formatDecimal(acarreo(componente, 'ana_monto')) }}</td>
              <td class="text-right">{{ formatDecimal(acarreo(componente, 'ana_modificaciones')) }}</td>
              <td class="text-right">
                {{ formatDecimal(acarreo(componente, 'ana_monto') + acarreo(componente, 'ana_modificaciones')) }}
              </td>
              <td class="text-right">{{ formatDecimal(acarreo(componente, 'ejecutado')) }}</td>
              <td class="text-right">
                {{
                formatDecimal(
                acarreo(componente, 'ana_monto') +
                acarreo(componente, 'ana_modificaciones') -
                acarreo(componente, 'ejecutado')
                )
                }}
              </td>
              <td></td>
            </tr>
            <tr v-for="(analitico, index) in componente" :key="index">
              <td>{{ showEspecificaDescripcion(analitico.ana_especifca) }}</td>
              <td>{{ analitico.ana_descricion }}</td>
              <td class="text-right">{{ formatDecimal(analitico.ana_monto) }}</td>
              <td class="text-right">{{ formatDecimal(analitico.ana_modificaciones) }}</td>
              <td class="text-right">{{ formatDecimal(analitico.ana_monto + analitico.ana_modificaciones) }}</td>
              <td class="text-right">{{ formatDecimal(analitico.ejecutado) }}</td>
              <td class="text-right">{{ formatDecimal(analitico.ana_monto - analitico.ejecutado) }}</td>
              <!-- <td>
                <v-btn icon dark @click="editar(analitico)">
                  <v-tooltip bottom>
                    <template v-slot:activator="index">
                      <v-icon color="primary" dark :v-on="index">mdi-pencil</v-icon>
                    </template>
                    <span>Editar</span>
                  </v-tooltip>
                </v-btn>
              </td> -->
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
    data () {
      return {
        version: 1,
        formAnalitico: {},
        defaultForm: {
          analitico_id: null,
          ana_act_proy: null,
          ana_componente: null,
          ana_descricion: null,
          ana_especifca: null,
          ana_modificaciones: 0,
          ana_monto: null,
          analitico_version_id: 1,
          ejecutado: 0
        },
        dialog: false,
        dialogVersion: false,
        modoEdit: false,
        puedeGuardar: false,
        componentes: [],
        cargos: [
          { value: 'Residente de Obra', text: 'Residente de Obra' },
          { value: 'Administrador de Contrato de Obra', text: 'Administrador de Contrato de Obra' },
          { value: 'Supervisor de Obra', text: 'Supervisor de Obra' },
          { value: 'Inspector de Obra', text: 'Inspector de Obra' },
          { value: 'Evaluador de Proyecto', text: 'Evaluador de Proyecto' },
          { value: 'Asistente administrativo', text: 'Asistente administrativo' },
          { value: 'Especialista administrativo', text: 'Especialista administrativo' }
        ],
        formVersion: {},
        defaultVersion: {
          vers_cargo: null,
          vers_observacion: null,
          vers_proyecto: null,
          analitico_version_id: 1
        }
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
        'mostrarCodigoSiafProyectoSelect',
        'showVersionsAnaliticoProyectSelect',
        'mostrarProyectoSelected'
      ])
    },
    mounted () {
      this.obternerAnalitico({ act_proy: this.$route.params.idproyecto, version: this.version })
      this.getVersionesAnalitico()
    },
    methods: {
      ...Vuex.mapActions([
        'obternerAnalitico',
        'saveAnalitico',
        'printAnalitico',
        'getVersionesAnalitico',
        'saveVersionAnalitico'
      ]),

      acarreo (obj, key) {
        var acarreo = 0
        for (var index in obj) acarreo += obj[index][key]
        return acarreo
      },
      editar (analitico) {
        let c = this.componentes.concat(this.showComponentes).filter(d => d.componente == analitico.ana_componente)[0]
        if (c == undefined)
          this.componentes.push({
            componente: analitico.ana_componente,
            nombre: 'COMPONENTE DESCONOCIDO'
          })
        this.$validator.reset()
        this.formAnalitico = JSON.parse(JSON.stringify(analitico))
        this.puedeGuardar = false
        this.dialog = true
        this.modoEdit = true
      },
      agregar () {
        this.$validator.reset()
        this.formAnalitico = JSON.parse(JSON.stringify(this.defaultForm))
        this.puedeGuardar = false
        this.dialog = true
        this.modoEdit = false
      },
      cerrarModal () {
        this.dialog = false
        this.formAnalitico = Object.assign({}, this.defaultForm)
        this.componentes = []
      },
      guardarAnalitico () {
        if (!this.puedeGuardar) {
          this.$validator.validate().then(result => {
            if (result) {
              this.puedeGuardar = true
              this.saveAnalitico(this.formAnalitico)
              this.cerrarModal()
            } else {
              console.log('incompleto')
            }
          })
        }
      },
      abrirModal () {
        this.$validator.reset()
        this.formVersion = JSON.parse(JSON.stringify(this.defaultVersion))
        this.formVersion.vers_proyecto = this.mostrarProyectoSelected.proy_cod_siaf
        this.puedeGuardar = false
        this.dialogVersion = true
      },
      guardarVersion () {
        if (!this.puedeGuardar) {
          this.$validator.validate().then(result => {
            if (result) {
              this.puedeGuardar = true
              this.saveVersionAnalitico(this.formVersion)
              this.dialogVersion = false
            }
          })
        }
      }
    }
  }
</script>

<style scoped>
  /* thead tr th {
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
  } */
</style>
