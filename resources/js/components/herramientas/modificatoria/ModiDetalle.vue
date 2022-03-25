<template>
  <div class="panel-body">
    <div class="row Filtros m-1 mb-2">
      <div class="col-12 col-sm-6 FiltrosGrupo">
        <label>Fuente de financiamiento</label>
        <v-autocomplete
          v-model="filtro.feunteFinanciamiento"
          :items="showFuentesFinanciamiento"
          :hide-details="true"
          flat
          class="FiltrosInput max-w-500"
          @change="getMetas(filtro.anio)"
        />
      </div>

      <div class="col-12 col-sm-6 FiltrosGrupo">
        <label>Tipo Fuente Financiamiento</label>
        <v-select
          v-model="filtro.tipoFuenteFinanciamiento"
          :items="tipoFuenteFinanciamiento"
          item-text="descripcion"
          item-value="key"
          :hide-details="true"
          flat
          class="FiltrosInput max-w-500"
        />
      </div>
    </div>
    <div class="ListadoAcciones">
      <template>
        <v-btn
          small
          color="#1976d2"
          class="white--text"
          @click="nuevaModificatoriaDetalle()"
        >
          Nuevo
          <v-icon right>mdi-plus</v-icon>
        </v-btn>
        <div class="d-flex">
          <v-btn
            small
            color="#2DE998"
            class="white--text"
            @click="imprimirEspecifica(1)"
          >
            Especificas
            <v-icon right>mdi-printer</v-icon>
          </v-btn>
          <v-btn small color="#E92D41" @click="imprimirEspecifica(2)">
            Proyectos
            <v-icon right>mdi-printer</v-icon>
          </v-btn>

          <v-btn small @click.prevent="imprimirEspecifica(3)">
            General
            <v-icon right>mdi-printer</v-icon>
          </v-btn>
        </div>
      </template>
    </div>

    <!-- Modal nuevo documento certificación-->
    <v-dialog v-model="dialog" max-width="1300px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="cerrarModal()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Nueva Modificatoria Detalle</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn :disabled="puedeGuardar" dark text @click="guardarModificatoriaDetalle()">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-list three-line subheader>
          <div class="d-flex flex-wrap">
            <div class="col-12 ProyectosFormulario">
              <v-textarea
                v-model="formModiDetalle.proy_nombre"
                v-validate="'required'"
                filled
                auto-grow
                rows="2"
                label="Proyecto"
                :error-messages="errors.collect('proyecto')"
                data-vv-name="proyecto"
                solo
                @change="formModiDetalle.proy_nombre = formModiDetalle.proy_nombre.toUpperCase()"
              >
                <template v-slot:append>
                  <v-menu style="top: -2px" offset-y>
                    <template v-slot:activator="{ on }">
                      <v-btn @click="buscarProyecto()">
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-icon color="primary" dark v-on="on">mdi-cloud-search</v-icon>
                          </template>
                          <span>Buscar</span>
                        </v-tooltip>
                      </v-btn>
                    </template>
                  </v-menu>
                </template>
              </v-textarea>
            </div>
            <div class="col-12 ProyectosFormulario">
              <v-textarea
                v-model="formModiDetalle.comp_nombre"
                v-validate="'required'"
                filled
                label="Proyecto"
                :error-messages="errors.collect('componente')"
                data-vv-name="componente"
                solo
                @change="formModiDetalle.comp_nombre = formModiDetalle.comp_nombre.toUpperCase()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fuente de financiamiento</v-label>
              <v-autocomplete
                v-model="formModiDetalle.det_fuente_financiamiento"
                :items="showFuentesFinanciamiento"
                :hide-details="true"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Especifica</v-label>
              <v-autocomplete
                v-model="formModiDetalle.det_id_clasif"
                dense
                :items="showEspecificasForSelect"
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
    <modi-detalle-listado />
  </div>
</template>
<script>
  import Vuex from 'vuex'
  import ModiDetalleListado from './ModiDetalleListado'

  export default {

    components: {
      ModiDetalleListado
    },

    data () {
      return {
        formModiDetalle: {
          proy_nombre: null,
          comp_nombre: null,
          det_fuente_financiamiento: null,
          det_id_clasif: null
        },
        defaultFormModiDetalle: {},
        filtro: {
          feunteFinanciamiento: null,
          tipoFuenteFinanciamiento: 'PP'
        },
        tipoFuenteFinanciamiento: [
          { key: 'APnoP', descripcion: 'ASIGNACIONES PRESUPUESTARIAS QUE NO RESULTAN EN PRODUCTOS' },
          { key: 'PP', descripcion: 'PROGRAMAS PRESUPUESTALES' },
          { key: 'all', descripcion: 'TODOS' }
        ],
        dialog: false,
        puedeGuardar: false,
        toggle_exclusive: 2
      }
    },

    computed: {
      ...Vuex.mapGetters(['showEspecificasForSelect', 'showFuentesFinanciamiento'])
    },

    mounted () {
      this.defaultFormModiDetalle = Object.assign({}, this.formModiDetalle)
      this.obtenerModificatoriaDetalle()
    },

    methods: {
      ...Vuex.mapActions(['getModificatoriaDetalle']),

      obtenerModificatoriaDetalle () {
        const params = {
          anio: this.$route.params.anio,
          modif: this.$route.params.id,
          fft: '00',
          opt: 'PP',
          option: 'listar'
        }
        this.getModificatoriaDetalle(params)
      },

      nuevaModificatoriaDetalle () {
        this.$validator.reset()
        this.dialog = true
        this.puedeGuardar = false
      },

      cerrarModal () {
        this.formModiDetalle = Object.assign({}, this.defaultFormModiDetalle)
        this.dialog = false
      },

      guardarModificatoriaDetalle () {},

      imprimirEspecifica (tipo) {
        let f = ''
        f += 'anio=' + this.$route.params.anio
        f += '&modif=' + this.$route.params.id
        f += '&fft=' + '00'
        f += '&opt=' + 'PP'
        f += '&option=' + (tipo == 1 ? 'imprimir' : tipo == 2 ? 'imprimir_proyectos' : 'imprimir_general')
        let route = '/app/herramientas/modificatoria/detalle?' + f
        window.open(route, 'Visor', 'width=1000,height=750')
      },

      buscarProyecto () {
        console.log('Holis')
      }
    }
  }
</script>
