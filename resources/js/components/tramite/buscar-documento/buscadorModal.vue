<template>
  <div id="modalImprimir">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" style="color:red">&times;</button>
      <h4 class="modal-title">Datos del documento</h4>
      <span class="modal-title"><strong>Reg. Documento: </strong>{{ ('00000000' + getBuscarDocumento.iddocumento).slice(-8) }}</span>
      <span class="modal-title"><strong>Expediente: </strong>{{ ('00000000' + getBuscarDocumento.expediente).slice(-8) }}</span>
    </div>
    <div class="modal-body">
      <div>
        <table>
          <thead></thead>
          <tbody>
            <tr>
              <td style="width: 10%"><strong>Documento: </strong></td>
              <td style="width: 40%; font-size: 11px">
                {{ getBuscarDocumento.tdoc_descripcion + ' '
                }}{{ ('000000' + getBuscarDocumento.docu_numero_doc).slice(-6)
                }}{{ getBuscarDocumento.docu_origen == 1 ? '-' + getBuscarDocumento.docu_fecha_doc.substr(0, 4) : ''
                }}{{ getBuscarDocumento.docu_siglas_doc != null ? '-' + getBuscarDocumento.docu_siglas_doc : '' }}<br />
              </td>
              <td style="width: 10%"><strong>Fecha doc: </strong></td>
              <td style="width: 40%; font-size: 11px">{{ getBuscarDocumento.docu_fecha_doc }}</td>
            </tr>
            <tr>
              <td><strong>Asunto: </strong></td>
              <td style="font-size: 11px">{{ getBuscarDocumento.docu_asunto }}</td>
              <td><strong>Folios: </strong></td>
              <td style="font-size: 11px">{{ getBuscarDocumento.docu_folios }}</td>
            </tr>
            <tr>
              <td><strong>Firma: </strong></td>
              <td style="font-size: 11px">{{ getBuscarDocumento.docu_firma }}</td>
              <td><strong>Cargo: </strong></td>
              <td style="font-size: 11px">{{ getBuscarDocumento.docu_cargo }}</td>
            </tr>
            <tr>
              <td><strong>Dependencia: </strong></td>
              <td style="font-size: 11px">{{ getBuscarDocumento.dependencia }}</td>
              <td><strong>Unidad: </strong></td>
              <td style="font-size: 11px">{{ getBuscarDocumento.unidad }}</td>
            </tr>
            <tr>
              <td v-if="getBuscarDigitales.length && !auth.guest"><strong>Digitales: </strong></td>
              <td v-else></td>
              <td style="font-size: 11px">
                <div v-if="getBuscarDigitales.length && !auth.guest">
                  <table>
                    <tbody>
                      <tr
                        v-for="(archivo, index) in getBuscarDigitales.filter(d => d.file_mostrar)"
                        :key="index"
                      >
                        <td>
                          <button
                            type="button"
                            class="btn btn-xs btn-link doc-link"
                            @click.stop="imprimirDocumentoPdf({id:archivo.id, id_documento:archivo.id_documento, file_tipo: archivo.file_tipo, file_name: archivo.file_name, tipo:1})"
                          >
                            <span style="color:blue;font-size:80%">{{ getFormatBytes(archivo.file_size) }}</span>
                            <span
                              v-if="archivo.file_principal != null"
                              :class="archivo.file_principal? 'badge badge-danger': 'badge badge-warning'"
                            >
                              {{ archivo.file_principal?'P':'A' }}
                            </span>
                            <span
                              :class="
                                archivo.file_tipo.indexOf('image') === 0
                                  ? 'glyphicon glyphicon-picture'
                                  : 'glyphicon glyphicon-file'
                              "
                            ></span>
                            {{ archivo.file_name }}
                          </button><br /><span style="color:red">{{ 'Fecha Adjuntada: '+archivo.created_at.substr(0, 10) }}</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </td>
              <td v-if="!auth.guest && (getBuscarDocumento.docu_emailorigen || getBuscarDocumento.docu_telef)"><strong>Correo/Celular: </strong></td>
              <td v-if="!auth.guest && (getBuscarDocumento.docu_emailorigen || getBuscarDocumento.docu_telef)" style="font-size: 11px">
                <a :href="'mailto:'+getBuscarDocumento.docu_emailorigen">
                  {{ getBuscarDocumento.docu_emailorigen?getBuscarDocumento.docu_emailorigen:'' }}
                </a> <br />
                <a :href="'tel:+51'+getBuscarDocumento.docu_telef">
                  {{ getBuscarDocumento.docu_telef?getBuscarDocumento.docu_telef:'' }}
                </a>
              </td>
            </tr>
            <tr v-if="getBuscarRelacionados.length > 0">
              <td colspan="4"><strong>Documentos Relacionados: </strong></td>
            </tr>
            <tr v-for="(relacionado, indexRelacion) in getBuscarRelacionados" :key="indexRelacion">
              <td colspan="4">
                <a href="#" @click.prevent="recargar(relacionado.iddocumento)">{{ ('00000000' +relacionado.iddocumento).slice(-8) }} - {{ relacionado.tdoc_descripcion + ' ' }}
                  {{ ('000000' + relacionado.docu_numero_doc).slice(-6) }}{{ '-' + relacionado.docu_siglas_doc }}:
                </a>
                <a
                  v-if="relacionado.docu_archivo != null && !auth.guest"
                  href="#"
                  @click.prevent="imprimirDocumentoPdf(relacionado.iddocumento)"
                >
                  <span class="glyphicon glyphicon-print"></span> Ver Documento</a>
              </td>
            </tr>
          </tbody>
        </table>
        <br />
        <!--TABLA-->
        <div class="box">
          <div class="box-body">
            <table class="table table-bordered table-condensed">
              <tbody>
                <tr>
                  <td style="width: 1%">
                    <div id="commits-graph2"></div>
                  </td>
                  <td>
                    <div class="list-group">
                      <a
                        v-for="(operacion, index) in getBuscarOperaciones"
                        :key="index"
                        :class="{
                          'list-group-item': true,
                          'list-group-item-success':
                            parseInt(operacion.oper_idtope) === 3 || parseInt(operacion.oper_idtope === 4),
                          'list-group-item-danger active':
                            parseInt(operacion.oper_procesado) === 0 &&
                            parseInt(operacion.oper_idtope) !== 3 &&
                            parseInt(operacion.oper_idtope) !== 4
                        }"
                        :set="
                          (demora = {
                            dias: (operacion.fecha_procesado !== null
                              ? moment(operacion.fecha_procesado)
                              : moment()
                            ).diff(moment(operacion.created_at), 'days'),
                            horas: (operacion.fecha_procesado !== null
                              ? moment(operacion.fecha_procesado)
                              : moment()
                            ).diff(moment(operacion.created_at), 'hours'),
                            minutos: (operacion.fecha_procesado !== null
                              ? moment(operacion.fecha_procesado)
                              : moment()
                            ).diff(moment(operacion.created_at), 'minutes')
                          })
                        "
                      >
                        <span class="badge badge-info">{{ operacion.created_at }}</span>
                        <span
                          v-if="operacion.oper_idtope !== 3 && operacion.oper_idtope !== 4"
                          :class="{
                            badge: true,
                            'badge-danger': demora.dias > 20,
                            'badge-warning': demora.dias > 10 && demora.dias <= 20,
                            'badge-success': demora.dias <= 10 }"
                        >
                          {{ demora.dias > 0
                            ? demora.dias + ' días'
                            : demora.horas > 0
                              ? demora.horas + ' horas'
                              : demora.minutos > 0
                                ? demora.minutos + ' minutos'
                                : 'al instante'
                          }}
                        </span>
                        <h5 class="list-group-item-heading">
                          {{
                            operacion.oper_idtope == 1
                              ? 'REGISTRADO': operacion.oper_idtope == 2
                                ? 'DERIVADO': operacion.oper_idtope == 3
                                  ? 'ARCHIVADO EN FILE: ' + operacion.arch_periodo + '/' + operacion.arch_nombre: 'ADJUNTADO AL '
                          }}
                          <a
                            v-if="operacion.oper_idtope == 4"
                            href="#"
                            @click.prevent="recargar(operacion.oper_iddocumento_adj)"
                          >{{ ('00000000' + operacion.oper_iddocumento_adj).slice(-8) }}</a>
                          en {{ operacion.oper_forma == 0 ? 'ORIGINAL' : 'COPIA' }}
                        </h5>
                        <div class="row">
                          <div
                            :class="{
                              'col-md-10 col-xs-10': operacion.depe_destino == null,
                              'col-md-6 col-xs-6': operacion.depe_destino != null
                            }"
                          >
                            <div :title="operacion.dependencia">{{ operacion.unidad }}</div>
                            <div>{{ operacion.nombre + ' ' + operacion.apellido }}</div>
                          </div>
                          <div :class="operacion.depe_destino == null ? 'col-md-2 col-xs-2' : 'col-md-6 col-xs-6'">
                            <div v-if="operacion.depe_destino != null">{{ operacion.depe_destino }}</div>
                            <div v-if="operacion.adm_name_destino != null">
                              {{ operacion.adm_name_destino + ' ' + operacion.adm_lastname_destino }}
                            </div>
                          </div>
                        </div>
                        <p v-if="operacion.oper_acciones != null" class="list-group-item-text">
                          <span
                            v-if="operacion.oper_detalledestino != null && operacion.oper_detalledestino.length > 0">
                            {{ operacion.oper_detalledestino + '/' }}</span>
                          <span v-else>&nbsp;</span>{{ operacion.oper_acciones }}
                        </p>

                        <p
                          v-if="operacion.depe_destino == null && operacion.oper_detalledestino != null"
                          class="list-group-item-text"
                        >
                          <strong>OBS: </strong>{{ operacion.oper_detalledestino }}
                        </p>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!--FIN TABLA -->
      </div>
    </div>
    <div class="modal-footer">
      <button v-if="!getBuscarFormModal" type="button" class="btn btn-sm btn-warning" @click="regresar">
        Volver atrás
      </button>
      <button v-if="!getBuscarFormModal" type="button" class="btn btn-sm btn-primary" @click="imprimirDocumento()">
        Imprimir
      </button>
      <button v-if="getBuscarFormModal" type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'

  export default {

    props: {
      routeDocumento: {
        type: String,
        default: ''
      },
      routeExpediente: {
        type: String,
        default: ''
      },
      formData: {
        type: Object,
        default: () => ({})
      },
      auth: {
        type: Object,
        default: () => ({})
      }
    },

    data () {
      return {
        documento: {},
        operaciones: [],
        acarreoOperaciones: [],
        grafico: [],
        numeroBranchs: 0
      }
    },
    computed: {
      ...Vuex.mapGetters([
        'getBuscarOperaciones',
        'getRuta',
        'getBuscarDocumento',
        'getBuscarFormModal',
        'getBuscarRelacionados',
        'getBuscarDigitales',
        'getFormatBytes'
      ])
    },
    mounted () {
      if (this.formData.iddocumento != null)
        this.buscarByDocumento({
          iddocumento: this.formData.iddocumento,
          modal: false,
          name: 'tramite.documento.buscarDocumento',
          route: { route: this.routeDocumento, can: true }
        })
    },

    methods: {
      ...Vuex.mapActions(['buscarByDocumento', 'addRuta', 'imprimirDocumentoPdf']),
      recargar (iddocumento) {
        this.buscarByDocumento({ iddocumento: iddocumento })
      },

      moment (a) {
        return moment(a)
      },

      imprimirDocumento () {
        window.print()
      },
      regresar () {
        window.location.assign(this.routeExpediente.replace(/%s/g, this.getBuscarDocumento.expediente))
      }
    }
  }
</script>
<style scoped>
  hr {
    margin: 5px 5px;
  }

  .registro strong {
    width: 60px;
    display: inline-block;
  }

  .list-group-item {
    height: 90px;
    margin-bottom: 0px;
    padding-top: 0.2rem;
    padding-right: 1rem;
    padding-bottom: 0;
    padding-left: 0.5rem;
    line-height: 1.5rem;
    background-color: #ffffffcc;
  }

  .modal-content .list-group-item-heading {
    max-width: 500px;
  }

  .table tbody tr td,
  .table thead tr th {
    font-size: 10px;
    font-family: Tahoma;
    vertical-align: middle;
  }

  .list-group {
    margin: 0;
  }

  h5 {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    margin-bottom: 0;
  }

  .badge {
    font-size: 13px;
  }

  .doc-link {
    width: 320px;
    text-overflow: ellipsis;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    margin-bottom: 0;
  }
</style>
