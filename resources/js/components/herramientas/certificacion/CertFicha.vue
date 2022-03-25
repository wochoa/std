<template>
  <div>
    <div class="panel-body">
      <div class="row Filtros m-1 mb-2">
        <div class="col-12 col-sm-4 FiltrosGrupo">
          <label>Documento Certificación</label>
        </div>
        <div class="col-12 col-sm-2 FiltrosGrupo">
          <label>Año</label>
          <v-select
            v-model="filtro.anio"
            :items="getAniosReporte"
            :hide-details="true"
            flat
            class="FiltrosInput max-w-100"
            @change="obtenerCertificaciones()"
          />
        </div>

        <div class="col-12 col-sm-6 FiltrosGrupo">
          <label>Certificación</label>
          <v-text-field
            v-model="filtro.dessertFilterValue"
            class="FiltrosInput"
            :hide-details="true"
          />
        </div>
      </div>
      <!-- Modal nuevo documento certificación-->
      <v-dialog v-model="dialog" max-width="1000px">
        <v-card>
          <v-toolbar dark color="primary">
            <v-btn icon dark @click="cerrarModal()">
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title v-if="modoEdit">Editar Documento Certificación</v-toolbar-title>
            <v-toolbar-title v-else>Crear nuevo Documento Certificación</v-toolbar-title>
            <v-spacer />
            <v-toolbar-items>
              <v-btn :disabled="puedeGuardar" dark text @click="guardarDocCertificacion()">Guardar</v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-list three-line subheader>
            <div class="d-flex flex-wrap">
              <div class="col-12 col-sm-6  ProyectosFormulario">
                <v-label>Reg. Tramite</v-label>
                <v-text-field
                  v-model="formCertificacion.doc_reg_sisgedo"
                  v-validate="'required|numeric'"
                  :type="'text'"
                  solo
                  :error-messages="errors.collect('reg_tramite')"
                  data-vv-name="reg_tramite"
                >
                  <template v-slot:append>
                    <v-menu style="top: -2px" offset-y>
                      <template v-slot:activator="{ on }">
                        <v-btn @click="buscarRegDocumento()">
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
                </v-text-field>
              </div>
              <div class="col-12 col-sm-6  ProyectosFormulario">
                <v-label>Oficina</v-label>
                <v-text-field v-model="formCertificacion.doc_oficina" solo />
              </div>
              <div class="col-12 col-sm-6  ProyectosFormulario">
                <v-label>Nro. Documento</v-label>
                <v-text-field
                  v-model="formCertificacion.doc_documento"
                  v-validate="'required'"
                  solo
                  :error-messages="errors.collect('numero_doc')"
                  data-vv-name="numero_doc"
                />
              </div>
              <div class="col-12 col-sm-6  ProyectosFormulario">
                <v-label>Fecha</v-label>
                <v-text-field v-model="formCertificacion.doc_fecha" type="date" solo />
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
        :items="certificacionFilter"
        tag="fichaCert"
        :page-length="30"
        @enter="goToAdministrar">
        <template slot="actions" slot-scope="data">
          <v-btn
            small
            color="#1976d2"
            class="white--text"
            @click="nuevoDocCertificacion"
          >
            Nuevo
            <v-icon right>mdi-plus</v-icon>
          </v-btn>
          <div v-if="data.selected.index !== null" class="d-flex">
            <v-btn
              small
              color="#1976d2"
              class="white--text"
              @click="editCertificacion(data.selected.item.id)"
            >
              Editar
              <v-icon right>mdi-pencil</v-icon>
            </v-btn>
            <v-btn small @click="goToAdministrar(data.selected)">
              Listar
              <v-icon right>mdi-format-list-bulleted</v-icon>
            </v-btn>
          </div>
        </template>
        <template slot="header">
          <tr>
            <th class="text-left" width="50%">Documento</th>
            <th class="text-left" width="15%">Registro Doc.</th>
            <th class="text-left" width="25%">Oficina</th>
            <th class="text-left" width="10%">Fecha</th>
          </tr>
        </template>
        <template slot="body" slot-scope="row">
          <td width="50%">{{ row.item.doc_documento }}</td>
          <td width="15%">{{ row.item.doc_reg_sisgedo }}</td>
          <td width="25%">{{ row.item.doc_oficina }}</td>
          <td width="10%">{{ row.item.doc_fecha | moment('calendar') }}</td>
        </template>
      </proy-table>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'
  import certificacion from '@/js/api/herramientas/certificacion'
  import ProyTable from '@/js/components/proyectos/ProyTable'

  export default {
    components: {
      ProyTable
    },

    data () {
      return {
        formCertificacion: {
          id: null,
          doc_reg_sisgedo: null,
          doc_oficina: null,
          doc_documento: null,
          doc_fecha: null
        },
        defaultFormCertificacion: {},
        filtro: {
          anio: curryear,
          dessertFilterValue: ''
        },
        singleExpand: false,
        dialog: false,
        puedeGuardar: false,
        modoEdit: false,
        toggle_exclusive: 2
      }
    },

    computed: {
      ...Vuex.mapGetters(['getAniosReporte',
        'mostrarCertificaciones',
        'getOneCertificacion']),

      certificacionFilter () {
        let filtrado = this.mostrarCertificaciones
        if (this.filtro.dessertFilterValue != null && this.filtro.dessertFilterValue !== '') {
          if(this.filtro.dessertFilterValue.length>6)
            filtrado = filtrado.filter(d => d.doc_reg_sisgedo === parseInt(this.filtro.dessertFilterValue))
        }
        return filtrado
      }
    },

    created: function () {
      this.defaultFormCertificacion = Object.assign({}, this.formCertificacion)
      this.obtenerCertificaciones()
    },

    methods: {
      ...Vuex.mapActions(['getCertificaciones', 'saveDocCertificacion']),

      obtenerCertificaciones () {
        this.getCertificaciones(this.filtro.anio)
      },

      nuevoDocCertificacion () {
        this.$validator.reset()
        this.dialog = true
        this.modoEdit = false
        this.puedeGuardar = false
      },

      guardarDocCertificacion () {
        if (!this.puedeGuardar) {
          this.$validator.validate().then(result => {
            if (result) {
              this.puedeGuardar = true
              this.saveDocCertificacion(this.formCertificacion)
              this.cerrarModal()
              this.obtenerCertificaciones()
            } else {
              console.log('incompleto')
            }
          })
        }
      },

      buscarRegDocumento () {
        certificacion.requestRegistroDocumento(this.formCertificacion.doc_reg_sisgedo).then(response => {
          if (response.data.status) {
            this.formCertificacion.doc_oficina = response.data.data[0].depe_nombre
            this.formCertificacion.doc_documento = response.data.data[0].docu_siglas_doc
            this.formCertificacion.doc_fecha = response.data.data[0].docu_fecha_doc
          } else {
            alert('Registro de documento no existe')
          }
        })
      },

      cerrarModal () {
        this.formCertificacion = Object.assign({}, this.defaultFormCertificacion)
        this.dialog = false
      },

      editCertificacion (item) {
        this.$validator.reset()
        this.puedeGuardar = false
        this.dialog = true
        this.modoEdit = true
        this.formCertificacion = JSON.parse(JSON.stringify(this.getOneCertificacion(item)))
      },
      goToAdministrar (data) {
        this.$router.push({
          name: 'CertControl',
          params: { anio: this.filtro.anio, idcertificacion: data.item.id }
        })
      }
    }
  }
</script>
