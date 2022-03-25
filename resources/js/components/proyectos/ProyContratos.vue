<template>
  <div class="panel-body">
    <h1>Control de contratos</h1>

    <!-- Modal nuevo contrato-->
    <v-dialog v-model="dialog" max-width="1500px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="cerrarModal()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title v-if="modoEdit">Editar Contrato</v-toolbar-title>
          <v-toolbar-title v-else>Crear un nuevo Contrato</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn :disabled="puedeGuardar" dark text @click="guardarContrato()">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-list three-line subheader>
          <div class="d-flex flex-wrap">
            <div class="col-12 ProyectosFormulario">
              <v-textarea
                v-model="formContrato.obr_nombre"
                v-validate="'required'"
                solo
                label="Descripción de contrato"
                :error-messages="errors.collect('nombre')"
                data-vv-name="nombre"
                @change="formContrato.obr_nombre = formContrato.obr_nombre.toUpperCase()"
              />
            </div>
            <div class="col-12 ProyectosFormulario">
              <v-textarea
                v-model="formContrato.obr_componentes_metas"
                v-validate="'required'"
                solo
                label="Componentes y metas del Proyecto"
                :error-messages="errors.collect('nombre')"
                data-vv-name="nombre"
                @change="formContrato.obr_componentes_metas = formContrato.obr_componentes_metas.toUpperCase()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Modalidad de ejecución</v-label>
              <v-select
                v-model="formContrato.obr_modalidad_ejecucion"
                :items="modalidadEjecucion"
                item-text="descripcion"
                item-value="id"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Estado de la obra</v-label>
              <v-select
                v-model="formContrato.obr_estado"
                :items="mostrarEstados"
                item-text="descripcion"
                item-value="id"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Tipo de contrato</v-label>
              <v-select
                v-model="formContrato.obr_tipo_contrato"
                :items="showTiposContrato"
                item-text="descripcion"
                item-value="id"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Monto del Expediente Técnico</v-label>
              <v-text-field
                v-model="formContrato.obr_monto_exp_tec"
                v-validate="'decimal'"
                :error-messages="errors.collect('monto_exp_tecnico')"
                data-vv-name="monto_exp_tecnico"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>N° Res. Exp. Técnico</v-label>
              <v-text-field
                v-model="formContrato.obr_numero_contrato"
                v-validate="'required|numeric'"
                :error-messages="errors.collect('num_contrato')"
                data-vv-name="num_contrato"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fecha de Aprobación Exp. Técnico</v-label>
              <v-text-field
                v-model="formContrato.obr_fecha_exp_tec"
                type="date"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Proceso de Selección</v-label>
              <v-text-field
                v-model="formContrato.obr_proceso_seleccion"
                solo
                @change="formContrato.obr_proceso_seleccion = formContrato.obr_proceso_seleccion.toUpperCase()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Nombre del contratista</v-label>
              <v-text-field
                v-model="formContrato.obr_nombre_ejecutor"
                solo
                @change="formContrato.obr_nombre_ejecutor = formContrato.obr_nombre_ejecutor.toUpperCase()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Dirección contratista</v-label>
              <v-text-field
                v-model="formContrato.obr_direccion_ejecutor"
                solo
                @change="formContrato.obr_direccion_ejecutor = formContrato.obr_direccion_ejecutor.toUpperCase()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Representante contratista</v-label>
              <v-text-field
                v-model="formContrato.obr_representante_ejecutor"
                solo
                @change="
                    formContrato.obr_representante_ejecutor = formContrato.obr_representante_ejecutor.toUpperCase()
                  "
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>RUC contratista</v-label>
              <v-text-field
                v-model="formContrato.obr_representante_ejecutor"
                :error-messages="errors.collect('contratista_ruc')"
                data-vv-name="contratista_ruc"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>N° Contrato de Ejecucion</v-label>
              <v-text-field
                v-model="formContrato.obr_contrato_ejecucion"
                solo
                @change="formContrato.obr_contrato_ejecucion = formContrato.obr_contrato_ejecucion.toUpperCase()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Monto Contratado de ejecución</v-label>
              <v-text-field
                v-model="formContrato.obr_monto_contrato"
                v-validate="'decimal'"
                :error-messages="errors.collect('monto_contrato')"
                data-vv-name="monto_contrato"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fecha del Contrato</v-label>
              <v-text-field
                v-model="formContrato.obr_fecha_contrato"
                type="date"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Inicio Ejecución</v-label>
              <v-text-field
                v-model="formContrato.obr_fecha_inicio_ejecucion"
                type="date"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Días de Plazo Ejecución</v-label>
              <v-text-field
                v-model="formContrato.obr_plazo"
                v-validate="'numeric'"
                :error-messages="errors.collect('plazo')"
                data-vv-name="plazo"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Factor de Relación</v-label>
              <v-text-field
                v-model="formContrato.obr_otros"
                solo
                @change="formContrato.obr_otros = formContrato.obr_otros.toUpperCase()"
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
      :items="showContratos"
      tag="contrato"
      :page-length="10"
      @enter="goToAdministrar"
    >
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
            @click="obtenerUnContrato(data.selected.item.idobra)"
          >
            Editar
            <v-icon right>mdi-pencil</v-icon>
          </v-btn>
          <v-btn small @click="goToAdministrar(data.selected)">
            Administrar
            <v-icon right>mdi-format-list-bulleted</v-icon>
          </v-btn>
        </div>
      </template>
      <template slot="header">
        <tr>
          <th style="width: 10%">Fecha</th>
          <th style="width: 55%">Contratista</th>
          <th style="width: 10%">Monto</th>
          <th style="width: 5%">Plazo</th>
          <th style="width: 10%">Tipo</th>
          <th style="width: 10%">Estado</th>
        </tr>
      </template>
      <template slot="body" slot-scope="row">
        <td style="width: 10%">{{ row.item.obr_fecha_contrato | moment('calendar') }}</td>
        <td style="width: 55%">
          {{ row.item.obr_nombre }}<br />
          <strong>{{ row.item.obr_contratista_ruc != null ? (row.item.obr_contratista_ruc + '-') : '' }}
            {{ row.item.obr_nombre_ejecutor }}
          </strong>
        </td>
        <td style="width: 10%">{{ 'S/ '+row.item.obr_monto_contrato }}</td>
        <td style="width: 5%">{{ row.item.obr_plazo + ' dias' }}</td>
        <td style="width: 10%">{{ showNameTiposDocumento(row.item.obr_tipo_contrato) }}</td>
        <td style="width: 10%">{{ showNameEstate(row.item.obr_estado) }}</td>
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
        formContrato: {
          idobra: null,
          proy_proyecto_idproy_proyecto: this.$route.params.idproyecto,
          obr_nombre: null,
          obr_componentes_metas: null,
          obr_modalidad_ejecucion: null,
          obr_estado: null,
          obr_tipo_contrato: null,
          obr_monto_exp_tec: null,
          obr_numero_contrato: null,
          obr_fecha_exp_tec: null,
          obr_proceso_seleccion: null,
          obr_nombre_ejecutor: null,
          obr_direccion_ejecutor: null,
          obr_representante_ejecutor: null,
          obr_contratista_ruc: null,
          obr_contrato_ejecucion: null,
          obr_monto_contrato: null,
          obr_fecha_contrato: null,
          obr_fecha_inicio_ejecucion: null,
          obr_plazo: null,
          obr_otros: null
        },
        defaultFormContrato: {},
        contratos: {},
        dialog: false,
        modoEdit: false,
        toggle_exclusive: 2,
        modalidadEjecucion: [
          { id: null, descripcion: 'Seleccione' },
          { id: '1', descripcion: 'Administracion Directa' },
          { id: '2', descripcion: 'Contrato' }
        ],
        puedeGuardar: false
      }
    },

    computed: {
      ...Vuex.mapGetters(['mostrarEstados',
        'showContratos',
        'getOneContrato',
        'showNameEstate',
        'showTiposContrato',
        'showNameTiposDocumento']),
    },

    created: function () {
      this.defaultFormContrato = Object.assign({}, this.formContrato)
      this.getContratos(this.formContrato)
      this.getEstados()
    },

    methods: {
      ...Vuex.mapActions(['getEstados',
        'getContratos',
        'saveContratos']),

      goToAdministrar (data) {
        this.$router.push({
          name: 'ActiControl',
          params: { idproyecto: this.$route.params.idproyecto, idcontrato: data.item.idobra }
        })
      },

      guardarContrato () {
        if (!this.puedeGuardar) {
          this.$validator.validate().then(result => {
            if (result) {
              this.puedeGuardar = true
              this.saveContratos(this.formContrato)
              this.cerrarModal()
              this.getContratos(this.formContrato)
            } else {
              console.log('incompleto')
            }
          })
        }
      },

      obtenerUnContrato (idobra) {
        this.$validator.reset()
        this.puedeGuardar = false
        this.dialog = true
        this.modoEdit = true
        this.formContrato = JSON.parse(JSON.stringify(this.getOneContrato(idobra)))
      },

      cerrarModal () {
        this.dialog = false
        this.puedeGuardar = false
        this.formContrato = Object.assign({}, this.defaultFormContrato)
      }
    }
  }
</script>
<style scoped>
  input,
  textarea {
    text-transform: uppercase;
  }
</style>
