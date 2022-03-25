<template>
  <div class="panel-body">
    <div class="d-flex justify-content-end">
      <div class="Filtros min-w-500 m-1 mb-2">
        <div class="col-12 col-sm-12 FiltrosGrupo">
          <label>Certificado</label>
          <v-text-field
            v-model="filtro.certificado"
            class="FiltrosInput"
            :hide-details="true"
          />
        </div>
      </div>
    </div>

    <!-- Modal nuevo documento certificación-->
    <v-dialog v-model="dialog" max-width="1000px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="cerrarModal()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title v-if="modoEdit">Editar Certificado</v-toolbar-title>
          <v-toolbar-title v-else>Crear nuevo Certificado</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn :disabled="puedeGuardar" dark text @click="guardarCertificado()">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-list three-line subheader>
          <div class="d-flex flex-wrap">
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Certificación</v-label>
              <v-text-field
                v-model="formCertificado.solc_certificado"
                v-validate="'required|numeric'"
                :error-messages="errors.collect('solicitud_certificado')"
                data-vv-name="solicitud_certificado"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Tipo valorización</v-label>
              <v-select
                v-model="formCertificado.solc_tipo_gasto"
                :items="tipoGasto"
                item-text="text"
                item-value="value"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Objeto</v-label>
              <v-text-field
                v-model="formCertificado.solc_objeto"
                solo
                @change="formCertificado.solc_objeto = formCertificado.solc_objeto.toUpperCase()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Tipo de selección</v-label>
              <v-text-field
                v-model="formCertificado.solc_tipo_proceso_seleccion"
                solo
                @change="formCertificado.solc_tipo_proceso_seleccion = formCertificado.solc_tipo_proceso_seleccion.toUpperCase()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Otros</v-label>
              <v-text-field
                v-model="formCertificado.solc_otros"
                solo
                @change="formCertificado.solc_otros = formCertificado.solc_otros.toUpperCase()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Doc. Priorización</v-label>
              <v-text-field
                v-model="formCertificado.solc_doc_priorizacion"
                solo
                @change="formCertificado.solc_doc_priorizacion = formCertificado.solc_doc_priorizacion.toUpperCase()"
              />
            </div>
            <div class="col-12 ProyectosFormulario">
              <v-textarea
                v-model="formCertificado.solc_justificacion"
                v-validate="'required'"
                filled
                label="Justificación"
                :error-messages="errors.collect('justificacion')"
                data-vv-name="justificacion"
                solo
                @change="formCertificado.solc_justificacion = formCertificado.solc_justificacion.toUpperCase()"
              />
            </div>
          </div>
        </v-list>
        <v-divider />
        <v-list three-line subheader />
      </v-card>
    </v-dialog>
    <!--fin modal-->

    <!-- Modal Detalle certificado-->
    <v-dialog v-model="dialogDetalle" max-width="1400px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="cerrarModalDetalle()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Detalle Certificado</v-toolbar-title>
          <v-spacer />
        </v-toolbar>
        <div class="d-flex justify-content-end">
          <div class="Filtros min-w-500 m-1 mb-2">
            <div class="col-12 col-sm-12 FiltrosGrupo">
              <label>Certificado</label>
              <v-text-field
                v-model="filtro.filterValueDetalle"
                class="FiltrosInput"
                :hide-details="true"
              />
            </div>
          </div>
        </div>

        <proy-table
          width="100%"
          class="ListadoTabla estatico"
          :items="showDetalleCertificado"
          tag="certificadoDetalle"
          :page-length="30">
          <template slot="actions" slot-scope="data">
            <div v-if="data.selected.index !== null" class="d-flex">
              <v-btn
                v-if="data.selected.item.key !== -1"
                small
                color="#E94E2D"
                class="white--text"
                @click="deleteCertificadoDetalle(data.selected.item.key)"
              >
                Eliminar
                <v-icon right>mdi-delete</v-icon>
              </v-btn>
              <v-btn small @click="saveDetalleCertificado(data.selected.item.key)">
                Agregar
                <v-icon right>mdi-plus</v-icon>
              </v-btn>
            </div>
          </template>
          <template slot="header">
            <tr>
              <th style="width: 5%">Sec.</th>
              <th style="width: 5%">Estado</th>
              <th style="width: 10%">Función</th>
              <th style="width: 10%">Especifica</th>
              <th style="width: 10%">Documento</th>
              <th style="width: 10%">Fecha</th>
              <th style="width: 20%">Cert. Actual</th>
              <th style="width: 10%">Saldo por Certificar</th>
              <th style="width: 20%">Monto Solicitado</th>
            </tr>
          </template>
          <template slot="body" slot-scope="row">
            <td style="width: 5%">{{ row.item.sec }}</td>
            <td style="width: 5%">{{ row.item.estado_registro }}</td>
            <td style="width: 10%">{{ row.item.sec_func }}</td>
            <td style="width: 10%">{{ row.item.especifica }}</td>
            <td style="width: 10%">{{ row.item.num_doc }}</td>
            <td style="width: 10%">{{ row.item.fecha_doc | moment('calendar') }}</td>
            <td style="width: 20%">{{ 'S/. ' +formatDecimal(row.item.monto_cert) }}</td>
            <td style="width: 10%">{{ 'S/. ' +formatDecimal(row.item.monto_solicitado) }}</td>
            <td style="width: 20%">{{ 'S/. ' +formatDecimal(row.item.monto) }}</td>
          </template>
        </proy-table>
      </v-card>
    </v-dialog>
    <!--fin modal-->

    <proy-table
      width="100%"
      class="ListadoTabla estatico"
      :items="certificadosFilter"
      tag="certificados"
      :page-length="30">
      <template slot="actions" slot-scope="data">
        <v-btn
          small
          color="#1976d2"
          class="white--text"
          @click="nuevoCertificado()"
        >
          Nuevo
          <v-icon right>mdi-plus</v-icon>
        </v-btn>
        <div v-if="data.selected.index !== null" class="d-flex">
          <v-btn
            small
            color="#1976d2"
            class="white--text"
            @click="editCertificado(data.selected.item.id)"
          >
            Editar
            <v-icon right>mdi-pencil</v-icon>
          </v-btn>
          <v-btn
            small
            color="#E94E2D"
            class="white--text"
            @click="deleteCertificado(data.selected.item.id)"
          >
            Eliminar
            <v-icon right>mdi-delete</v-icon>
          </v-btn>
          <v-btn
            small
            color="#2DE998"
            @click="detalleCertificado(data.selected.item.id)">
            Detalle
            <v-icon right>mdi-format-list-bulleted</v-icon>
          </v-btn>
          <v-btn small @click="imprimir(data.selected.item.id)">
            Imprimir
            <v-icon right>mdi-format-list-bulleted</v-icon>
          </v-btn>
        </div>
      </template>
      <template slot="header">
        <tr>
          <th style="width: 10%">Certificado</th>
          <th style="width: 30%">Sec. Función</th>
        </tr>
      </template>
      <template slot="body" slot-scope="row">
        <td style="width: 10%">{{ row.item.solc_certificado }}</td>
        <td style="width: 30%">{{ row.item.solc_sec_func }}</td>
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
        formCertificado: {
          id: null,
          solc_certificado: null,
          solc_tipo_gasto: 1,
          solc_objeto: null,
          solc_tipo_proceso_seleccion: null,
          solc_otros: null,
          solc_justificacion: null,
          solc_doc_priorizacion: null,
          documento_id: this.$route.params.idcertificacion,
          solc_anio: this.$route.params.anio
        },
        defaultFormCertificado: {},
        filtro: {
          certificado: '',
          filterValueDetalle: ''
        },
        tipoGasto: [
          { value: 1, text: 'Gasto Corriente' },
          { value: 2, text: 'Gasto de Capital' }
        ],
        dialog: false,
        dialogDetalle: false,
        puedeGuardar: false,
        modoEdit: false,
        toggle_exclusive: 4
      }
    },

    computed: {
      ...Vuex.mapGetters(['showCertificados',
        'getOneCertificado',
        'showDetalleCertificado',
        'showNameLvl3',
        'formatDecimal']),

      certificadosFilter () {
        let filtrado = this.showCertificados
        if (this.filtro.certificado != null && this.filtro.certificado !== '') {
          if(this.filtro.certificado.length > 1)
            filtrado = filtrado.filter( d => d.solc_certificado === parseInt(this.filtro.certificado))
        }
        return filtrado
      }
    },

    created: function () {
      this.defaultFormCertificado = Object.assign({}, this.formCertificado)
      this.getCertificados(this.$route.params.idcertificacion)
    },

    methods: {
      ...Vuex.mapActions([
        'getCertificados',
        'getDetalleCertificado',
        'saveCertificado',
        'deleteOneCertificado',
        'newDetalleCertificado',
        'deleteCertificadoDetalle',
        'saveDetalleCertificado'
      ]),

      nuevoCertificado () {
        this.$validator.reset()
        this.dialog = true
        this.modoEdit = false
        this.puedeGuardar = false
      },

      cerrarModal () {
        this.formCertificado = Object.assign({}, this.defaultFormCertificado)
        this.dialog = false
      },

      editCertificado (item) {
        this.$validator.reset()
        this.puedeGuardar = false
        this.dialog = true
        this.modoEdit = true
        this.formCertificado = JSON.parse(JSON.stringify(this.getOneCertificado(item)))
      },
      guardarCertificado () {
        if (!this.puedeGuardar) {
          this.$validator.validate().then(result => {
            if (result) {
              this.puedeGuardar = true
              this.saveCertificado(this.formCertificado)
              this.cerrarModal()
              this.getCertificados(this.$route.params.idcertificacion)
            } else {
              console.log('incompleto')
            }
          })
        }
      },

      deleteCertificado (item) {
        if (confirm('Esta seguro de eliminar certificado?')) {
          this.deleteOneCertificado(item)
          this.getCertificados(this.$route.params.idcertificacion)
        }
      },
      detalleCertificado (item) {
        this.dialogDetalle = true
        this.getDetalleCertificado(item)
      },
      cerrarModalDetalle () {
        this.dialogDetalle = false
        this.newDetalleCertificado()
      },

      imprimir (item) {
        let f = ''
        f += 'id_certificacion=' + this.$route.params.idcertificacion
        f += '&id_certificado=' + item
        let route = '/app/herramientas/certificacion/certificados/imprimir?' + f
        window.open(route, 'Visor', 'width=1000,height=750')
      }
    }
  }
</script>
