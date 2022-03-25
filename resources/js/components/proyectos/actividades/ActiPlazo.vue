<template>
  <div class="panel-body">
    <div class="ListadoFiltros">
      <v-card-title>{{(tipoRuta==3)?'Control de Plazos':'Control de alcance'}}</v-card-title>
      <div class="d-flex justify-content-end">
        <div class="Filtros min-w-500 m-1 mb-2">
          <div class="col-12 col-sm-6 FiltrosGrupo">
            <label>Numero</label>
            <v-text-field
              v-model="dessertFilterValue"
              class="FiltrosInput"
              :hide-details="true"
            />
          </div>
        </div>
      </div>
    </div>
    <!-- Modal editar control de plazos-->
    <v-dialog v-model="dialog" persistent max-width="1000px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="cerrarModal()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title><strong>{{ (tipoRuta==3)?'Editar control de plazos':'Editar control de alcance' }}</strong>
          </v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn dark text @click="editControlPlazo()">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-list three-line subheader>
          <div class="d-flex flex-wrap">
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Actividad</v-label>
              <div class="body-1">{{ getActividadDescripcion(formActividad.actividad_idactividad) }}</div>
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Acción</v-label>
              <div class="body-1">{{ getActividadAccionDescripcion(formActividad.aco_accion) }}</div>
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fecha de inicio</v-label>
                <v-text-field
                  type="date"
                  solo
                  :value="(formActividad.aco_inicio!=null)?formActividad.aco_inicio:formActividad.aco_programado"
                  @input="formActividad.aco_inicio = $event.target.value"
                />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>{{ (tipoRuta==3)?'Dias':'Monto S/.' }}</v-label>
                <v-text-field
                  v-model="formActividad.aco_accion_numero"
                  v-validate="'numeric'"
                  :error-messages="errors.collect('accion_numero')"
                  solo
                  data-vv-name="accion_numero"
                />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>{{ 'Número de '+getActividadDescripcion(formActividad.actividad_idactividad) }}</v-label>
                <v-text-field
                  v-model="formActividad.aco_numero"
                  v-validate="'numeric'"
                  solo
                  :error-messages="errors.collect('número')"
                  data-vv-name="número"
                />
            </div>
            <div class="col-12 col-sm-6">
                <div class="subheading">Documentos</div>
                <table>
                  <thead>
                    <tr>
                      <th>Documento</th>
                      <th>Fecha</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Documento</td>
                      <td>Fecha</td>
                    </tr>
                  </tbody>
                </table>
            </div>
            <div class="col-12 ProyectosFormulario">
                <v-textarea
                  v-model="formActividad.aco_observacion"
                  solo
                  name="input-7-4"
                  label="Observaciones"
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
    <proy-table
      width="100%"
      class="ListadoTabla estatico"
      :items="plazosFilter"
      tag="plazo"
      :page-length="30">
      <template slot="actions" slot-scope="data">
        <div v-if="data.selected.index !== null" class="d-flex">
          <v-btn
            small
            color="#1976d2"
            class="white--text"
            @click="obtenerUnaActividad(data.selected.item.idactividades)"
          >
            Editar
            <v-icon right>mdi-pencil</v-icon>
          </v-btn>
          <v-btn small>
            Programar
            <v-icon right>mdi-cloud-upload</v-icon>
          </v-btn>
        </div>
      </template>
      <template slot="header">
        <tr>
          <th style="width: 15%">Etapa</th>
          <th style="width: 25%">Actividad</th>
          <th style="width: 10%">{{ (tipo === 3)?'Fecha Inicio / Fecha Fin':'Fecha' }}</th>
          <th style="width: 10%">{{ (tipo === 3)?'N° de Dias':'Monto' }}</th>
          <th style="width: 30%">Observaciones</th>
        </tr>
      </template>
      <template slot="body" slot-scope="row">
        <td style="width: 15%">{{ row.item.eta_descripcion }}</td>
        <td style="width: 25%">{{ row.item.act_descripcion+((row.item.aco_numero != null)?row.item.aco_numero:'')
          }}</td>
        <td style="width: 10%">
          {{row.item.aco_inicio | moment('calendar')}} - {{ row.item.aco_programado | moment('calendar') }}
        </td>
        <td style="width: 10%">{{
          ((tipoRuta===4)?'S/.':'')+Math.trunc(row.item.aco_accion_numero)+((tipoRuta===3)?'dias':'') }}</td>
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

    props: {
      tipoRuta: {
        type: Number,
        default: 3
      }
    },

    data () {
      return {
        formActividad: {
          idactividades: null,
          actividad_idactividad: null,
          aco_accion: null,
          aco_inicio: null,
          aco_programado: null,
          aco_numero: null,
          aco_accion_numero: null,
          aco_observacion_otro: null,
          aco_observacion: null,
          obra_idobra: this.$route.params.idcontrato,
          page: null
        },
        tipo: null,
        defaultformActividad: {},
        dialog: false,
        toggle_exclusive: 2,
        dessertFilterValue: ''

      }
    },

    computed: {
      ...Vuex.mapGetters(['showActividadesPlazos',
        'getOneActividadesPlazos',
        'getActividadDescripcion',
        'getActividadAccionDescripcion']),

      plazosFilter () {
        let filtrado = this.showActividadesPlazos
        if (this.dessertFilterValue != null && this.dessertFilterValue !== '') {
          filtrado = filtrado.filter(d => d.aco_numero === parseInt(this.dessertFilterValue))
        }
        return filtrado
      }
    },

    created: function () {
      this.defaultformActividad = Object.assign({}, this.formActividad)
    },

    updated: function () {
      this.$nextTick(function () {

        if (this.tipo != this.tipoRuta) {
          this.tipo = this.tipoRuta
          this.obtenerActividades()
        }
      })
    },

    mounted: function () {
      this.obtenerActividad()
      this.obtenerActividadAccion()
      this.obtenerActividades()
    },

    methods: {

      ...Vuex.mapActions(['getActividadesOfContrato',
        'obtenerActividad',
        'obtenerActividadAccion']),

      obtenerActividades () {
        var tipo = (this.$route.name == 'controlPlazo') ? 3 : 4
        const params = {
          obra_idobra: this.formActividad.obra_idobra,
          tipo: (this.tipoRuta != null) ? this.tipoRuta : tipo
        }
        this.getActividadesOfContrato(params)
      },

      obtenerUnaActividad (idactividades) {
        this.$validator.reset()
        this.dialog = true
        this.formActividad = JSON.parse(JSON.stringify(this.getOneActividadesPlazos(idactividades)))
      },

      editControlPlazo () {
        this.formActividad.tipo = this.tipo
        axios.post(this.routeGuardarActividad, this.formActividad).then(response => {
          console.log('actualizado')
          this.obtenerActividades()
          this.cerrarModal()
        })
      },

      cerrarModal () {
        this.formActividad = Object.assign({}, this.defaultformActividad)
        this.dialog = false
      }
    }
  }
</script>

