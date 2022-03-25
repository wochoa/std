<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">DOCUMENTOS EN PROCESO</div>
      <div class="panel-body">
        <form @submit.prevent="buscarDocumentos()">
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div :class="{ 'col-sm-2': true, 'has-error': errors.has('registro') }">
              <label class="control-label">Registro:</label>
              <input
                ref="registro"
                v-model="formData.iddocumento"
                v-validate="'numeric'"
                type="text"
                name="registro"
                class="form-control"
              />
              <span v-show="errors.has('registro')" class="help-block">{{ errors.first('registro') }}</span>
            </div>
            <div class="col-sm-4">
              <label>Documento del Usuario:</label>
              <select v-model="formData.idadmin" class="form-control" @change="buscarDocumentos()">
                <option :value="null">Todos</option>
                <option v-for="(usuario, indexUser) in getUsuariosActivo" :key="indexUser" :value="usuario.id">
                  {{ usuario.adm_name }}
                </option>
              </select>
            </div>
            <div class="col-sm-2">
              <label>Estado de documento</label>
              <select v-model="formData.oper_idtope" class="form-control" @change="buscarDocumentos()">
                <option :value="null">Todos</option>
                <option value="1">Pendientes</option>
                <option value="2">Procesados</option>
              </select>
            </div>
            <div class="col-sm-2">
              <label>Tipo documento</label>
              <select v-model="formData.docu_digital" class="form-control" @change="buscarDocumentos()">
                <option :value="null">Todos</option>
                <option value="1">Tramite Electrónico</option>
                <option value="0">Tramite manual</option>
              </select>
            </div>
            <div class="col-sm-2">
              <br />
              <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-search"></span> Buscar
              </button>
            </div>
          </div>
        </form>
        <MenuDocuBuscar
          :user-id="userId"
          :can-interoperabilidad="canInteroperabilidad"
          :doc-indexes="docIndexes"
          :documentos="documentos"
          @mostrar="mostrar"
          @editar="editar"
          @eliminarDerivacion="eliminarDerivacion"
          @responder="responder"
        />

        <!-- Modal enviar por interoperabilidad-->
        <div id="enviar" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Interoperabilidad con otras Instituciones</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Registro para pasar a despacho a otra Entidad del Estado</label>
                  <ul v-for="(docId, indexDoc) in docIndexes" :key="indexDoc">
                    {{
                      ('00000000' + documentos.data[docId].iddocumento).slice(-8) +
                        ' - ' +
                        documentos.data[docId].tdoc_descripcion
                    }}
                  </ul>
                </div>
                <div class="form-group">
                  <label>Tipo entidad</label>
                  <select v-model="categoria_id" class="form-control" @change="buscarEntidad">
                    <option :value="null">Seleccione</option>
                    <option
                      v-for="(categoria, indexCategoria) in categorias"
                      :key="indexCategoria"
                      :value="categoria.codcat"
                    >{{ categoria.descripcion }}
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Entidad</label>
                  <select v-model="formEntidad.sident" class="form-control">
                    <option :value="null">Seleccione</option>
                    <option
                      v-for="(entidad, indexEntidad) in entidades.filter( d => d.vrucent !== 0)"
                      :key="indexEntidad"
                      :value="entidad.sident"
                    >{{ entidad.vnoment }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-primary"
                  :disabled="saving || (formEntidad.sident===null)"
                  @click="grabarEnvio"
                >
                  Guardar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal derivar-->
        <div id="derivar" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-body" style="padding: 0;">
                <docu-derivar :derivaciones="derivaciones" />
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-primary"
                  :disabled="saving || (derivaciones.length===0)"
                  @click="grabarDerivaciones()"
                >
                  <span v-if="!saving" class="glyphicon glyphicon-floppy-saved"> Guardar</span>
                  <span v-else class="glyphicon glyphicon-send"> Guardando</span>
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal" :disabled="saving">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal archivar-->
        <div id="archivar" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Archivar documento</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Registro a archivar</label>
                  <ul v-for="(docId, indexDoc) in docIndexes" :key="indexDoc">
                    {{
                      ('00000000' + documentos.data[docId].iddocumento).slice(-8) +
                        ' - ' +
                        documentos.data[docId].tdoc_descripcion
                    }}
                  </ul>
                </div>
                <div class="form-group">
                  <label>Forma</label>
                  <select v-model="eleccionArchivador.forma" class="form-control">
                    <option :value="null">Seleccione</option>
                    <option value="0">Temporal</option>
                    <option value="1">Definitivo</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Archivador</label>
                  <select v-model="eleccionArchivador.idarch" class="form-control">
                    <option :value="null">Seleccione</option>
                    <option
                      v-for="(archivador, indexArchivador) in getArchivadores"
                      :key="indexArchivador"
                      :value="archivador.idarch"
                    >{{
                      archivador.arch_periodo + '/' + archivador.arch_nombre
                    }}
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Acciones</label>
                  <textarea
                    v-model="eleccionArchivador.acciones"
                    cols="10"
                    rows="3"
                    class="form-control"
                    @change="eleccionArchivador.acciones = eleccionArchivador.acciones.toUpperCase()"
                  ></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="documentoAccion()">
                  Guardar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal adjuntar-->
        <div id="adjuntar" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Adjuntar documentos</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Registro a adjuntar</label>
                  <ul v-for="(docId, indexDocId) in docIndexes" :key="indexDocId">
                    {{
                      ('00000000' + documentos.data[docId].iddocumento).slice(-8) +
                        ' - ' +
                        documentos.data[docId].tdoc_descripcion
                    }}
                  </ul>
                </div>
                <div class="form-group">
                  <label>Registro</label>
                  <input v-model="eleccionArchivador.iddocumento" type="text" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Acciones</label>
                  <textarea
                    v-model="eleccionArchivador.acciones"
                    cols="10"
                    rows="3"
                    class="form-control"
                    @change="eleccionArchivador.acciones = eleccionArchivador.acciones.toUpperCase()"
                  ></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="documentoAccion()">
                  Guardar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal observacion-->
        <div id="observacion" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Observación</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Registro a observar</label>
                  <ul v-for="(docId, indexObservar) in docIndexes" :key="indexObservar">
                    {{
                      ('00000000' + documentos.data[docId].iddocumento).slice(-8) +
                        ' - ' +
                        documentos.data[docId].tdoc_descripcion
                    }}
                  </ul>
                </div>
                <div class="form-group">
                  <label>Observación</label>
                  <textarea
                    v-model="docObservar.oper_detalledestino"
                    cols="10"
                    rows="3"
                    class="form-control"
                    @change="docObservar.oper_detalledestino = docObservar.oper_detalledestino.toUpperCase()"
                  ></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="generarObservacion()">
                  Guardar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Liberar Documento-->
        <div id="liberar" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Liberar documento</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Motivo</label>
                  <textarea v-model="docLiberar.oper_acciones" class="form-control" cols="10" rows="3"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="liberarDocumento()">
                  Guardar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

        <div v-if="mostrarDocumentos" class="box">
          <div class="box-body">
            <pagination :data="documentos" :limit="limit" @pagination-change-page="buscarDocumentos" />
            <table class=" table table-bordered table-condensed table-hover ">
              <thead>
                <tr class="info">
                  <th style="width:7%">REGISTRO<br />EXPEDIENTE</th>
                  <th style="width:15%">REGISTRO</th>
                  <th style="width:40%">DOCUMENTO</th>
                  <th style="width:10%">DESTINO</th>
                  <th style="width:10%">ARCHIVO</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td v-if="documentos.data.length == 0" colspan="21" class="text-center">
                    No hay documentos, pruebe cambiando los filtros
                  </td>
                </tr>
                <tr
                  v-for="(documento, index) in documentos.data"
                  :key="index"
                  :set="(dias = moment().diff(moment(documento.created_at), 'days'))"
                  :class="
                    operSelected.indexOf(documento.idoperacion) >= 0
                      ? 'danger'
                      : documento.depe_destino != null
                        ? 'success'
                        : 'null'
                  "
                  @click="selectArchivar(documento)"
                >
                  <td>
                    <span
                      :class="{
                        badge: true,
                        'badge-danger': dias > 20,
                        'badge-warning': dias > 10 && dias <= 20,
                        'badge-success': dias <= 10
                      }"
                    >{{ dias }} días</span><br />
                    <strong>Reg.</strong>
                    <a
                      href="#"
                      @click.prevent.stop="buscarByDocumento({ iddocumento: documento.iddocumento, modal: true })"
                    >{{ ' ' + ('00000000' + documento.iddocumento).slice(-8) }}</a><br />
                    <strong>Exp.</strong>{{ ' ' + ('00000000' + documento.docu_idexma).slice(-8) }}<br />
                    {{ documento.oper_idtope == 1 ? 'REGISTRADO' : 'DERIVADO' }}
                  </td>
                  <td class="registro">
                    <strong>Fecha:</strong>{{ documento.created_at }}<br />
                    <strong>Forma:</strong>{{ documento.oper_forma == 1 ? 'COPIA' : 'ORIGINAL' }}<br />
                    <strong>Folios:</strong>{{ documento.docu_folios }}<br />
                    <strong>Proveido:</strong>{{ documento.proveido }}
                  </td>
                  <td class="documento">
                    <strong :class="$mq">Doc:</strong>
                    <div :class="$mq">
                      {{ documento.tdoc_descripcion + ' ' }}{{ ('000000' + documento.docu_numero_doc).slice(-6)
                      }}{{ documento.docu_origen == 1 ? '-' + documento.docu_fecha_doc.substr(0, 4) : ''
                      }}{{ documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : '' }}
                    </div>
                    <strong :class="$mq">Firma:</strong>
                    <div :class="$mq">{{ documento.docu_firma }}</div>
                    <strong :class="$mq">Cargo:</strong>
                    <div :class="$mq">{{ documento.docu_cargo }}</div>
                    <strong :class="$mq">Asunto:</strong>
                    <div :class="$mq">{{ documento.docu_asunto }}</div>
                    <strong :class="$mq">Dependencia:</strong>
                    <div :class="$mq">{{ getDependenciaNombre(documento.depe_origen) }}</div>
                  </td>
                  <td>
                    <div v-if="documento.depe_destino != null">
                      <div>
                        <strong :class="$mq">Destino:</strong>{{ getDependenciaNombre(documento.depe_destino) }}<br />
                      </div>
                      <div v-if="documento.oper_usuid_d != null">
                        <strong :class="$mq">Para:</strong>{{ getUsuariosActivoNombre(documento.oper_usuid_d) }}<br />
                      </div>
                      <div><strong :class="$mq">Acciones:</strong>{{ documento.oper_acciones }}</div>
                    </div>
                    <div v-if="documento.depe_destino == null && documento.oper_detalledestino != null">
                      <div>
                        <strong :class="$mq">Observacion:</strong>{{ documento.oper_detalledestino != null ?
                          documento.oper_detalledestino : 'Ninguna' }}
                      </div>
                    </div>
                  </td>
                  <td>
                    <div v-if="documento.docu_archivo.length>0">
                      <table>
                        <tbody>
                          <tr>
                            <td>
                              <span
                                v-if="documento.docu_digital"
                                class="badge badge-info glyphicon glyphicon-lock"
                              > Tramite Electrónico</span>
                            </td>
                          </tr>
                          <tr
                            v-for="(archivo, indexArchivo) in documento.docu_archivo.filter(d => d.file_mostrar)"
                            :key="indexArchivo"
                          >
                            <td>                              
                              <button
                                type="button"
                                class="btn btn-xs btn-link doc-link"
                                @click.stop="imprimirDocumentoPdf({id:archivo.id, id_documento:archivo.id_documento, file_tipo: archivo.file_tipo, file_name: archivo.file_name,tipo:1})"
                              >
                                <span style="color:blue;font-size:80%">{{ getFormatBytes(archivo.file_size) }}</span>
                                <span
                                  v-if="archivo.file_principal != null"
                                  :class="
                                    archivo.file_principal
                                      ? 'badge badge-danger'
                                      : 'badge badge-warning'
                                  "
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
                              </button>
                            </td>
                            <td>
                              <button
                                v-if="archivo.file_tipo === 'application/pdf'"
                                class="btn btn-sm btn-success"
                                @click.stop="firmar({id:archivo.id, id_documento:archivo.id_documento})"
                              >
                                <span class="glyphicon glyphicon-pencil"></span> Firmar
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="documentos" :limit="limit" @pagination-change-page="buscarDocumentos" />

            <MenuDocuBuscar
              :user-id="userId"
              :can-interoperabilidad="canInteroperabilidad"
              :doc-indexes="docIndexes"
              :documentos="documentos"
              @mostrar="mostrar"
              @editar="editar"
              @eliminarDerivacion="eliminarDerivacion"
              @responder="responder"
            />
          </div>
        </div>
      </div>
    </div>

    <docu-invoker
      ref="foo"
      :iframe="iframe"
      :route-invoker-get="routeInvokerGet"
      :route-invoker-post="routeInvokerPost"
      @firmado="firmado"
    />
  </div>
</template>

<script>
import moment              from 'moment'
import Vuex                from 'vuex'
import {Interoperabilidad} from '@/js/store/models/interoperabilidad'
import MenuDocuBuscar      from "@/js/components/tramite/documentos/en-poceso/componets/MenuDocuBuscar"

export default {

  name      : 'DocuBuscar',
  components: {
    MenuDocuBuscar
  },
  props     : {
    routeDocumentosList    : {
      type   : String,
      default: ''
    },
    routeArchivar          : {
      type   : String,
      default: ''
    },
    routeAdjuntar          : {
      type   : String,
      default: ''
    },
    routeDerivar           : {
      type   : String,
      default: ''
    },
    routeDevolver          : {
      type   : String,
      default: ''
    },
    routeEliminarDerivacion: {
      type   : String,
      default: ''
    },
    routeLiberarDocumento  : {
      type   : String,
      default: ''
    },
    routeGenerarObservacion: {
      type   : String,
      default: ''
    },
    routePrintPdf          : {
      type   : String,
      default: ''
    },
    routeInvokerGet        : {
      type   : String,
      default: ''
    },
    routeInvokerPost       : {
      type   : String,
      default: ''
    },
    userId                 : {
      type   : String,
      default: ''
    },
    limit                  : {
      type   : Number,
      default: 3
    },
    routeWebserviceEntidad : {
      type   : String,
      default: ''
    },
    routeArchivador        : {
      type   : String,
      default: ''
    },
    canInteroperabilidad   : {
      type   : Boolean,
      default: false
    },
    routeCuo:{
      type : String,
      default : ''
    }
  },

  data() {
    return {
      formData          : {
        iddocumento : null,
        idadmin     : this.userId,
        oper_idtope : null,
        docu_digital: null,
        page        : null
      },
      documentos        : {
        current_page : null,
        data         : [],
        from         : null,
        last_page    : null,
        next_page_url: null,
        path         : null,
        per_page     : null,
        prev_page_url: null,
        to           : null,
        total        : null
      },
      eleccionArchivador: {
        forma      : null,
        idarch     : null,
        acciones   : null,
        iddocumento: null,
        tipoDoc    : null
      },
      docLiberar        : {
        oper_detalledestino: 'Liberación de registro',
        oper_acciones      : null
      },
      docObservar       : {
        oper_detalledestino: null
      },
      operSelected      : [],
      docIndexes        : [],
      mostrarDocumentos : true,
      derivaciones      : [],
      iframe            : {
        src   : null,
        loaded: false,
        type  : null
      },
      saving            : false,
      categorias        : [
        {
          codcat     : 1,
          descripcion: 'PODER EJECUTIVO'
        }, {
          codcat     : 2,
          descripcion: 'PODER LEGISLATIVO'
        }, {
          codcat     : 3,
          descripcion: 'PODER JUDICIAL'
        }, {
          codcat     : 4,
          descripcion: 'ORGANISMOS AUTONOMOS'
        }, {
          codcat     : 5,
          descripcion: 'UNIVERSIDADES PUBLICAS'
        }, {
          codcat     : 6,
          descripcion: 'GOBIERNO REGIONAL'
        }, {
          codcat     : 7,
          descripcion: 'GOBIERNO LOCAL PROVINCIAL'
        }, {
          codcat     : 8,
          descripcion: 'GOBIERNO LOCAL DISTRITAL'
        },],
      entidades         : [],
      categoria_id      : null,
      formEntidad       : {
        sident   : null,
        sidpadent: null,
        vnoment  : null,
        vrucent  : null
      },
      defaultFormEntidad: {},
      cuo: null,
    }
  },

  computed: {
    ...Vuex.mapGetters([
                         'getDependenciaNombre',
                         'getMiDependencia',
                         'getArchivadores',
                         'getUsuariosActivo',
                         'getUsuariosActivoNombre',
                         'getFormatBytes'])
  },
  watch   : {
    'formEntidad.sident': function () {
      if (this.formEntidad.sident != null) {
        this.setFormEntidad(this.formEntidad.sident)
      } else {
        this.formEntidad = JSON.parse(JSON.stringify(this.defaultFormEntidad))
      }
    },
  },

  mounted() {
    if (location.hash == '#pendiente') {
      this.formData.oper_idtope = 1
    }
    this.buscarDocumentos()
    this.obtenerArchivadores()
    this.defaultFormEntidad = JSON.parse(JSON.stringify(this.formEntidad))

  },

  methods: {
    ...Vuex.mapActions([
                         'buscarByDocumento',
                         'imprimirDocumentoPdf',
                         'obtenerArchivadores']),
    ...Vuex.mapMutations(['llenarDerivarSoloCopia']),

    firmado() {
      this.buscarDocumentos()
    },
    mostrar(accion) {
      if (this.docIndexes.length === 0) {
        toastr.warning('debe de seleccionar al menos un documento!!')
      } else {
        switch (accion) {
          case 'enviar': {
            if (this.verificarDerivado()) {
              toastr.warning('no puede enviar un documento que se encuentre derivado!!')
            } else {
              $('#enviar').modal()
              axios.get(this.routeCuo).then( response => {
                if (response.data.status) {
                  this.cuo = response.data.data.cou
                } else {
                  alert('CUO no encontrado')
                }
              })
            }
          }
            break
          case 'derivar': {
            var a = this.docIndexes.filter(id => this.documentos.data[id].oper_forma === 1)
            this.llenarDerivarSoloCopia(a.length > 0)
            console.log(a.length)
            this.derivaciones = []
            $('#derivar').modal({
                                  backdrop: 'static',
                                  keyboard: false
                                })
          }
            break
          case 'archivar': {
            if (this.verificarDerivado()) {
              toastr.warning('no puede archivar un documento que se encuentre derivado!!')
            } else {
              $('#archivar').modal()
            }
          }
            break
          case 'adjuntar': {
            if (this.verificarDerivado()) {
              toastr.warning('no puede adjuntar un documento que se encuentre derivado!!')
            } else {
              $('#adjuntar').modal()
            }
          }
            break
          case 'liberar': {
            $('#liberar').modal()
          }
            break
          case 'observacion': {
            $('#observacion').modal()
          }
            break
        }
      }
    },

    verificarDerivado() {
      var r = false
      for (var i = 0; i < this.docIndexes.length; i++) {
        if (this.documentos.data[this.docIndexes[i]].depe_destino != null) {
          r = true
          break
        }
      }
      return r
    },

    eliminarDerivacion() {
      if (confirm('Esta seguro de eliminar la derivación?')) {
        const params = {
          devolver: this.operSelected
        }
        axios.post(this.routeEliminarDerivacion, params).then(response => {
          if (response.data.status) {
            toastr.success(response.data.msg)
            this.operSelected = []
            this.docIndexes   = []
            this.buscarDocumentos()
          }
        })
      }
    },

    grabarDerivaciones() {
      const params = {
        operSelected: this.operSelected,
        derivaciones: this.derivaciones
      }
      if (!this.saving) {
        this.saving = true
        axios
        .post(this.routeDerivar, params)
        .then(response => {
          if (response.data.status) {
            toastr.success(response.data.msg)
            this.buscarDocumentos()
            $('#derivar').modal('hide')
            this.saving = false
          }
        })
        .catch(error => {
          console.log('Ocurrio un error guardar la derivacion, verifique su conexion a internet e intentelo nuevamente')
          this.saving = false
        })
      }
    },

    buscarDocumentos(page = 1) {
      this.$validator.validate().then(result => {
        if (result) {
          this.formData.page = page
          axios.get(this.routeDocumentosList, {params: this.formData}).then(response => {
            this.documentos   = response.data
            this.operSelected = []
            this.docIndexes   = []
          })
        } else {
          console.log('incompleto')
        }
      })
    },

    selectArchivar(documento) {
      if (this.operSelected.indexOf(documento.idoperacion) === -1 && this.docIndexes.indexOf(this.documentos.data.indexOf(documento)) === -1) {
        this.operSelected.push(documento.idoperacion)
        this.docIndexes.push(this.documentos.data.indexOf(documento))
      } else {
        this.operSelected.splice(this.operSelected.indexOf(documento.idoperacion), 1)
        this.docIndexes.splice(this.docIndexes.indexOf(this.documentos.data.indexOf(documento)), 1)
      }
    },

    documentoAccion() {
      const params = {
        idDocumento  : this.operSelected,
        datoDocumento: this.eleccionArchivador
      }
      if (this.eleccionArchivador.iddocumento == null) {
        if (this.eleccionArchivador.idarch != null || this.eleccionArchivador.forma != null) {
          axios.post(this.routeArchivar, params).then(response => {
            this.operSelected = []
            this.docIndexes   = []
            this.buscarDocumentos()
          })
        } else {
          alert('seleccione un archivador y la forma de archivamiento')
        }
      } else {
        if (this.eleccionArchivador.iddocumento > 0) {
          axios.post(this.routeAdjuntar, params).then(response => {
            this.operSelected = []
            this.docIndexes   = []
            this.buscarDocumentos()
          })
        } else {
          alert('Digite bien el registro')
        }
      }
    },

    firmar(documento) {
      this.$refs.foo.initInvoker('W', documento)
    },

    liberarDocumento() {
      if (confirm('Esta seguro de liberar el documento')) {
        const params = {
          idOperacion  : this.operSelected,
          datoOperacion: this.docLiberar
        }
        axios.post(this.routeLiberarDocumento, params).then(response => {
          if (response.data.status) {
            toastr.success(response.data.msg)
            this.operSelected = []
            this.docIndexes   = []
            this.buscarDocumentos()
          }
        })
      }
    },

    generarObservacion() {
      if (confirm('Esta seguro de agregar una observación')) {
        const params = {
          idOperacion  : this.operSelected,
          datoOperacion: this.docObservar
        }
        axios.post(this.routeGenerarObservacion, params).then(response => {
          if (response.data.status) {
            toastr.success(response.data.msg)
            this.operSelected                    = []
            this.docIndexes                      = []
            this.docObservar.oper_detalledestino = null
            this.buscarDocumentos()
          }
        })
      }
    },

    moment(a) {
      return moment(a)
    },

    editar() {
      if (this.docIndexes.length === 1) {
        if (this.documentos.data[this.docIndexes[0]].docu_doc_generado == null) {
          this.$router.push({
                              name  : 'DocuEdit',
                              params: {id: this.documentos.data[this.docIndexes[0]].iddocumento}
                            })
        } else {
          this.$router.push({
                              name  : 'DocuGeneradoEdit2',
                              params: {id: this.documentos.data[this.docIndexes[0]].docu_doc_generado}
                            })
        }
      }
    },

    grabarEnvio() {
      this.obtenerArchivador()
      const params = {
        idOperacion  : this.operSelected,
        datoDocumento: {
          forma       : 1,
          idarch      : this.eleccionArchivador.idarch,
          acciones    : 'Ok',
          iddocumento : null,
          arch_periodo: new Date().getFullYear(),
          tipoDoc     : null
        },
        idDocumento  : this.documentos.data[this.docIndexes[0]].iddocumento,
        entidad      : this.formEntidad,
        cuo : this.cuo
      }
      if (this.formEntidad.sident != null) {
        Interoperabilidad.saveForDispatch(params).then(response => {
          if (response.data.status) {
            toastr.success(response.data.msg)
            this.operSelected = []
            this.docIndexes   = []
            this.buscarDocumentos()
          }
        })
      } else {
        alert('Seleccione una entidad')
      }
    },

    buscarEntidad() {
      axios.get(this.routeWebserviceEntidad.replace(/%s/g, this.categoria_id)).then(response => {
        if (response.data.status) {
          this.entidades   = response.data.data
          this.formEntidad = JSON.parse(JSON.stringify(this.defaultFormEntidad))
        } else {
          alert('Datos no encontrado')
        }
      })
    },

    setFormEntidad(id) {
      let entidad = this.entidades.filter(d => d.sident === id)[0]
      if (entidad !== undefined) {
        this.formEntidad = JSON.parse(JSON.stringify(entidad))
      }
    },

    obtenerArchivador() {
      const params = {
        arch_periodo: new Date().getFullYear()
      }
      axios.post(this.routeArchivador, params).then(response => {
        if (response.data.idarch >= 1) {
          this.eleccionArchivador.idarch = response.data.idarch
        } else {
          this.eleccionArchivador.idarch = null
        }
      })
    },

    responder() {

      if (this.verificarDerivado()) {
        toastr.warning('no puede responder un documento que se encuentre derivado!!')
      } else {
        if (this.docIndexes.length > 0) {
            this.$router.push({
              name : 'DocuResponse',
              params : {
                idrecepcion: this.documentos.data[this.docIndexes[0]].iddocumento,
                operaciones: this.operSelected
                }
            })
          }
      }
    }
  }
}
</script>

<style scoped>
  .registro strong {
    width: 60px;
    display: inline-block;
  }

  .documento strong {
    display: inline-block;
    float: left;
  }

  .documento strong.mobile {
    width: 100%;
  }

  .documento strong.tablet {
    width: 100%;
  }

  .documento strong.laptop {
    width: 30%;
  }

  .documento strong.desktop {
    width: 20%;
  }

  .documento div {
    float: left;
  }

  .documento div.mobile {
    width: 100%;
  }

  .documento div.tablet {
    width: 100%;
  }

  .documento div.laptop {
    width: 70%;
  }

  .documento div.desktop {
    width: 80%;
  }

  .table tbody tr td,
  .table thead tr th {
    font-size: 11px;
    font-family: Tahoma;
    vertical-align: middle;
    padding: 2px 0px;
  }

  input,
  textarea {
    text-transform: uppercase;
  }

  .doc-link {
    width: 250px;
    text-overflow: ellipsis;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    margin-bottom: 0;
  }
</style>
