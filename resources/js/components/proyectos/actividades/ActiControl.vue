<template>
  <div class="panel-body">
    <h1>Control de actividades</h1>
    <!-- Modal nueva actividad-->
    <v-dialog v-model="dialog" max-width="1000px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="cerrarModal()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title v-if="modoEdit">Editar Actividad</v-toolbar-title>
          <v-toolbar-title v-else>Crear un nueva Actividad</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn :disabled="puedeGuardar" dark text @click="guardarActividad()">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-list three-line subheader>
          <div class="d-flex flex-wrap">
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Actividad</v-label>
              <v-select
                v-model="formActividad.actividad_idactividad"
                :items="getActividades"
                item-text="act_descripcion"
                item-value="idactividad"
                solo
                @change="findActividad()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fecha de inicio</v-label>
              <v-text-field
                v-model="formActividad.aco_inicio"
                type="date"
                solo />
            </div>
            <div v-if="!(formActividad.aco_accion == 1 || formActividad.aco_accion == 2)"
              class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fecha de fin</v-label>
              <v-text-field
                v-model="formActividad.aco_programado"
                type="date"
                solo />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Acción</v-label>
              <v-select
                v-model="formActividad.aco_accion"
                :items="getActividadAccionSelect"
                item-text="descripcion"
                item-value="id"
                solo
                disabled
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>
                {{ formActividad.aco_accion == 0
                ? 'Numero'
                : formActividad.aco_accion == 1 || formActividad.aco_accion == 2
                ? 'Nro de dias de ' + getActividadAccionDescripcion(formActividad.aco_accion)
                : 'Monto de ' + getActividadAccionDescripcion(formActividad.aco_accion) }}
              </v-label>
              <v-text-field
                v-model="formActividad.aco_accion_numero"
                v-validate="'required|numeric'"
                :error-messages="errors.collect('accion_numero')"
                data-vv-name="accion_numero"
                solo
              />
            </div>
            <div v-if="formActividad.aco_ocurrencia != null" class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fecha de ocurrencia</v-label>
              <v-text-field
                v-model="formActividad.aco_ocurrencia"
                type="date"
                solo
              />
            </div>
            <div v-if="formActividad.aco_ocurrencia != null" class="col-12 col-sm-12  ProyectosFormulario">
              <v-label>Observaciones</v-label>
              <v-textarea
                v-model="formActividad.aco_observacion"
                name="input-7-4"
                solo
                @change="formActividad.aco_observacion = formActividad.aco_observacion.toUpperCase()"
              />
            </div>
          </div>
        </v-list>
        <v-divider />
        <v-list three-line subheader />
      </v-card>
    </v-dialog>
    <!--fin modal-->
    <!--Modal programar actividad-->
    <v-dialog v-model="dialogProgramar" persistent max-width="1000px">
      <v-card>
        <v-card-title>
          <span class="headline">Programar Actividad</span>
        </v-card-title>
        <v-card-text>
          <div class="d-flex flex-wrap">
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fecha de inicio</v-label>
                <v-text-field
                  v-model="formActividad.aco_inicio"
                  v-validate="'required'"
                  type="date"
                  :error-messages="errors.collect('inicio')"
                  data-vv-name="inicio"
                  solo
                />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fecha de programada</v-label>
                <v-text-field
                  v-model="formActividad.aco_programado"
                  v-validate="'required'"
                  type="date"
                  :error-messages="errors.collect('programar')"
                  data-vv-name="programar"
                  solo
                />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Avance programado S/.</v-label>
                <v-text-field
                  v-model="formActividad.aco_meta_financiero"
                  v-validate="'decimal'"
                  :error-messages="errors.collect('meta_financiera')"
                  data-vv-name="meta_financiera"
                  solo
                />
            </div>
          </div>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn :disabled="puedeGuardar" color="primary" text @click="guardarCambiosProgramar()">Guardar</v-btn>
          <v-btn color="blue darken-1" text @click="cerrarModalProgramar()">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!--Fin modal-->

    <proy-table
      width="100%"
      class="ListadoTabla estatico"
      :items="showActividades"
      tag="actividad"
      :page-length="20">
      <template slot="actions" slot-scope="data">
        <v-btn
          small
          color="#1976d2"
          class="white--text"
          @click="
            dialog = true
            $validator.reset()
          "
        >
          Nuevo
          <v-icon right>mdi-plus</v-icon>
        </v-btn>
        <div v-if="data.selected.index !== null" class="d-flex">
          <v-btn
            small
            color="#1976d2"
            class="white--text"
            @click="obtenerUnaActividad(data.selected.item.idactividades, 1)"
          >
            Editar
            <v-icon right>mdi-pencil</v-icon>
          </v-btn>
          <v-btn small @click="abrirModalProgramar(data.selected.item.idactividades, 2)">
            Programar
            <v-icon right>mdi-cloud-upload</v-icon>
          </v-btn>
        </div>
      </template>
      <template slot="header">
        <tr>
          <th style="width: 15%">Etapa</th>
          <th style="width: 25%">Actividad</th>
          <th style="width: 10%">Programado</th>
          <th style="width: 10%">Ejecución</th>
          <th style="width: 10%">Monto</th>
          <th style="width: 30%">Observaciones</th>
        </tr>
      </template>
      <template slot="body" slot-scope="row">
        <td style="width: 15%">{{ row.item.eta_descripcion }}</td>
        <td style="width: 25%">{{ row.item.act_descripcion }}</td>
        <td style="width: 10%">
          {{row.item.aco_inicio | moment('calendar')}} - {{ row.item.aco_programado | moment('calendar') }}
        </td>
        <td v-if="row.item.aco_ocurrencia != null" style="width: 10%">{{ row.item.aco_ocurrencia | moment('calendar')
          }}</td>
        <td v-else style="width: 10%">Sin ocurrencias</td>
        <td style="width: 10%">{{ row.item.aco_accion_numero > 0 ? ('S/ '+row.item.aco_accion_numero) : null }}</td>
        <td style="width: 30%" v-html="row.item.aco_observacion"></td>
      </template>
    </proy-table>
  </div>
</template>
<script>
  import Vuex from 'vuex'
  import ProyTable from '@/js/components/proyectos/ProyTable'

  export default {
    components: {
      ProyTable
    },

    data () {
      return {
        formActividad: {
          idactividades: null,
          actividad_idactividad: null,
          aco_inicio: null,
          aco_programado: null,
          aco_ocurrencia: null,
          aco_orden: 1,
          aco_accion: 0,
          aco_accion_numero: null,
          obra_idobra: this.$route.params.idcontrato,
          aco_vinculo: 0,
          aco_creado: 0,
          aco_observacion: null,
          tipo: 1
        },
        defaultFormActividad: {},
        dialog: false,
        dialogProgramar: false,
        modoEdit: false,
        toggle_exclusive: 2,
        puedeGuardar: false
      }
    },

    computed: {
      ...Vuex.mapGetters([
        'getActividadAccionDescripcion',
        'getActividadAccion',
        'getActividadAccionSelect',
        'getActividades',
        'showActividades',
        'getOneActividad'
      ])
    },

    created: function () {
      this.defaultFormActividad = Object.assign({}, this.formActividad)
      this.getActividadesOfContrato(this.formActividad)
    },

    mounted: function () {
      this.obtenerActividad()
      this.obtenerActividadAccion()
    },

    methods: {
      ...Vuex.mapActions([
        'obtenerActividad',
        'obtenerActividadAccion',
        'getActividadesOfContrato',
        'saveActividades'
      ]),

      guardarActividad () {
        if (!this.puedeGuardar) {
          this.$validator.validate().then(result => {
            if (result) {
              this.saveActividades(this.formActividad)
              this.getActividadesOfContrato(this.formActividad)
              this.cerrarModal()
              // axios.post(this.routeGuardarActividad,this.formActividad).then(response=>{
              //     console.log('actualizado');
              //     this.obtenerActividades();
              //     this.cerrarModal();
              // });
            } else {
              console.log('incompleto')
            }
          })
        }
      },

      obtenerUnaActividad (idactividades, tipo) {
        this.$validator.reset()
        if (tipo == 1) this.dialog = true
        this.puedeGuardar = false
        this.modoEdit = true
        this.formActividad = JSON.parse(JSON.stringify(this.getOneActividad(idactividades)))
        this.formActividad.tipo = 1
      },

      findActividad () {
        this.formActividad.aco_accion = this.getActividadAccion(this.formActividad.actividad_idactividad)
      },

      cerrarModal () {
        this.formActividad = Object.assign({}, this.defaultFormActividad)
        this.dialog = false
      },

      cerrarModalProgramar () {
        this.formActividad = Object.assign({}, this.defaultFormActividad)
        this.dialogProgramar = false
      },

      nuevaActividad () {
        this.$validator.reset()
        this.dialog = true
        this.puedeGuardar = false
        var date = new Date() // Or the date you'd like converted.
        var isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
        this.formActividad.aco_inicio = isoDate.slice(0, 10)
      },

      guardarCambiosProgramar () {
        if (!this.puedeGuardar) {
          this.$validator.validate().then(result => {
            if (result) {
              const params = {
                idactividades: this.formActividad.idactividades,
                aco_inicio: this.formActividad.aco_inicio,
                aco_programado: this.formActividad.aco_programado,
                aco_meta_financiero: this.formActividad.aco_meta_financiero,
                tipo: 5
              }
              this.saveActividades(params)
              this.getActividadesOfContrato(this.formActividad)
              this.cerrarModalProgramar()
            } else {
              console.log('incompleto')
            }
          })
        }
        // axios.post(this.routeGuardarActividad, params).then(response => {
        //   console.log('actualizado')
        //   this.obtenerActividades()
        //   this.cerrarModal()
        // })
      },

      abrirModalProgramar (idactividad, tipo) {
        this.$validator.reset()
        if (tipo == 2) this.dialogProgramar = true
        this.obtenerUnaActividad(idactividad)
      }
    }
  }
</script>
