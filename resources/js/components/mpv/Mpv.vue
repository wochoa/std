<template>
  <div>
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading">SOLICITUDES DE MESA DE PARTES VIRTUAL</div>
        <div class="panel-body">
          <form @submit.prevent="buscarRegistro">
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-4">
                <label></label>
                <input
                  ref="registro"
                  v-model="filtro.id"
                  type="text"
                  name="registro"
                  placeholder="Nombre, DNI, RUC"
                  class="form-control"
                  @change="filtro.id = filtro.id.toUpperCase()"
                />
              </div>
              <div class="col-sm-3">
                <label>Estado registro</label>
                <select v-model="filtro.docu_estado" class="form-control" @change="buscarRegistro">
                  <option :value="null">Todos</option>
                  <option value="0">Registrados</option>
                  <option value="3">Subsanados</option>
                </select>
              </div>
              <div class="col-sm-2">
                <br />
                <button type="submit" class="btn btn-primary">
                  <span class="glyphicon glyphicon-search"></span> Buscar
                </button>
              </div>              
              <div class="col-sm-3">
                <a href="https://drive.google.com/file/d/1EwK8WOTRoBSOwux-q3Sfj7bsMLTfI1Qc/view?usp=sharing" target="_blank">
                  <span class="icon icon-file-play fs-50" aria-hidden="true" style="font-size: 15px; margin-top: 10px"></span>Manual de administrador MPV</a>
              </div>
            </div>
          </form>
          <!-- Modal derivar-->
          <div id="derivar" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-body" style="padding: 0;">
                  <DocuDerivar :derivaciones="derivaciones" />
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-primary"
                    :disabled="saving||(derivaciones.length===0)"
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
          <!-- Modal editar-->
          <div id="editar" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Editar Registro</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Registro a Editar</label>
                    <ul v-for="(docId, indexDoc) in docIndexes" :key="indexDoc">
                      {{
                        ('00000000' + documentos.data[docId].id).slice(-8) +
                          ' - ' +
                          documentos.data[docId].docu_asunto
                      }}
                    </ul>
                  </div>
                  <div class="form-group">
                    <label>Número</label>
                    <input
                      v-model="formRegistro.docu_numero_doc"
                      type="number"
                      class="form-control"
                    />
                  </div>
                  <div class="form-group">
                    <label>Sigla</label>
                    <input
                      v-model="formRegistro.docu_siglas_doc"
                      type="text"
                      class="form-control"
                      @change="formRegistro.docu_siglas_doc = formRegistro.docu_siglas_doc.toUpperCase()"
                    />
                  </div>
                  <div class="form-group">
                    <label>Folios</label>
                    <input
                      v-model="formRegistro.docu_folios"
                      type="number"
                      class="form-control"
                    />
                  </div>
                  <div class="form-group">
                    <label>Asunto</label>
                    <input
                      v-model="formRegistro.docu_asunto"
                      type="text"
                      cols="10"
                      rows="3"
                      class="form-control"
                      @change="formRegistro.docu_asunto = formRegistro.docu_asunto.toUpperCase()"
                    />
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal" @click="editar">
                    Guardar
                  </button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
                  <h4 class="modal-title">Enviar observación al solicitante</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Registro a observar</label>
                    <ul v-for="(docId, indexDoc) in docIndexes" :key="indexDoc">
                      {{
                        ('00000000' + documentos.data[docId].id).slice(-8) +
                          ' - ' +
                          documentos.data[docId].docu_asunto
                      }}
                    </ul>
                  </div>
                  <div class="form-group">
                    <label>Observaciones</label>
                    <textarea
                      v-model="eleccionArchivador.acciones"
                      cols="10"
                      rows="3"
                      class="form-control"
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
          <!-- Modal transferir-->
          <div id="transferir" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Transferir Registro</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Registro a Transferir</label>
                    <ul v-for="(docId, indexDoc) in docIndexes" :key="indexDoc">
                      {{
                        ('00000000' + documentos.data[docId].id).slice(-8) +
                          ' - ' +
                          documentos.data[docId].docu_asunto
                      }}
                    </ul>
                  </div>
                  <div class="form-group">
                    <label>Dependencias</label>
                    <select
                      ref="dependencia"
                      v-model="id_dependencia"
                      :class="{ 'col-sm-12': true, 'has-error': errors.has('dependencia') }"
                      class="form-control"
                      name="dependencia"
                    >
                      <option
                        v-for="(dependencia, indexDepe) in getSedes"
                        :key="indexDepe"
                        :value="dependencia.iddependencia"
                      >
                        {{ dependencia.depe_nombre }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal" @click="transferir">
                    Guardar
                  </button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>

          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-12">
              <div class="btn-group" role="group" aria-label="Basic example">
                <p>
                  <button
                    class="btn btn-sm btn-outline-primary"
                    :disabled="!(docIndexes.length === 1)"
                    @click="mostrar('editar')"
                  >
                    Editar
                  </button>
                  <button
                    class="btn btn-sm btn-outline-primary"
                    :disabled="!(docIndexes.length > 0)"
                    @click="mostrar('derivar')"
                  >
                    Derivar
                  </button>
                  <button
                    class="btn btn-sm btn-danger"
                    :disabled="!(docIndexes.length > 0)"
                    @click="mostrar('archivar')"
                  >
                    Enviar observaciones al solicitante
                  </button>
                  <button
                    class="btn btn-sm btn-outline-primary"
                    :disabled="!(docIndexes.length > 0)"
                    @click="mostrar('transferir')"
                  >
                    Transferir
                  </button>
                </p>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-body">
              <pagination :data="documentos" :limit="3" @pagination-change-page="buscarRegistro" />
              <table class=" table table-bordered table-condensed table-hover ">
                <thead>
                  <tr class="info">
                    <th style="width:7%">REGISTRO</th>
                    <th style="width:15%">FECHA</th>
                    <th style="width:40%">DOCUMENTO</th>
                    <th style="width:10%">REMITENTE</th>
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
                    :class="{'danger':operSelected.indexOf(documento.id) >= 0, 'success':documento.docu_estado===1}"
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
                      {{ ' ' + ('000000' + documento.id).slice(-6) }}
                      <span
                        :class="
                          documento.docu_estado === 0
                            ? 'badge badge-info'
                            : 'badge badge-warning'
                        "
                      >
                        {{ documento.docu_estado === 0?'Registrado':'Subsanado' }}
                      </span>
                    </td>
                    <td class="registro">
                      <strong>Fecha:</strong>{{ documento.created_at }}<br />
                      <strong>Folios:</strong>{{ documento.docu_folios }}
                    </td>
                    <td class="documento">
                      <strong :class="$mq">Doc:</strong>
                      <div :class="$mq">
                        {{ documento.tipo_documento.tdoc_descripcion+' ' }}
                        {{ documento.docu_numero_doc != null?(' '+'000000' +documento.docu_numero_doc).slice(-6):'' }}
                        {{ '-'+documento.docu_fecha_doc.substr(0, 4)
                        }}{{ documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : '' }}
                      </div>
                      <strong :class="$mq">Entidad:</strong>
                      <div :class="$mq">{{ documento.docu_detalle }}</div>
                      <strong :class="$mq">Firma:</strong>
                      <div :class="$mq">{{ documento.docu_firma }}</div>
                      <strong :class="$mq">Cargo:</strong>
                      <div :class="$mq">{{ documento.docu_cargo }}<br /></div>
                      <strong :class="$mq">Asunto:</strong>
                      <div :class="$mq">{{ documento.docu_asunto }}</div>
                    </td>
                    <td>
                      <div>
                        <strong :class="$mq">DNI:</strong>{{ documento.docu_dni }}<br />
                      </div>
                      <div>
                        <strong :class="$mq">RUC:</strong>{{ documento.docu_ruc }}<br />
                      </div>
                      <div><strong :class="$mq">Celular:</strong>{{ documento.docu_telef }}</div>
                      <div><strong :class="$mq">eMail:</strong>{{ documento.docu_emailorigen }}</div>
                    </td>
                    <td>
                      <div v-if="documento.docu_archivo.length>0">
                        <table>
                          <tbody>
                            <tr
                              v-for="(archivo, indexArchivo) in documento.docu_archivo.filter(d => d.file_mostrar)"
                              :key="indexArchivo"
                            >
                              <td>
                                <button
                                  type="button"
                                  class="btn btn-xs btn-link doc-link"
                                  @click.stop="imprimirDocumentoPdf({id:archivo.id, id_documento_externo:archivo.id_documento_externo, file_tipo: archivo.file_tipo, file_name: archivo.file_name, tipo:2})"
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
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <pagination :data="documentos" :limit="3" @pagination-change-page="buscarRegistro" />
            </div>
          </div>
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-12">
              <div class="btn-group" role="group" aria-label="Basic example">
                <p>
                  <button
                    class="btn btn-sm btn-outline-primary"
                    :disabled="!(docIndexes.length === 1)"
                    @click="mostrar('editar')"
                  >
                    Editar
                  </button>
                  <button
                    class="btn btn-sm btn-outline-primary"
                    :disabled="!(docIndexes.length > 0)"
                    @click="mostrar('derivar')"
                  >
                    Derivar
                  </button>
                  <button
                    class="btn btn-sm btn-danger"
                    :disabled="!(docIndexes.length > 0)"
                    @click="mostrar('archivar')"
                  >
                    Enviar observaciones al solicitante
                  </button>
                  <button
                    class="btn btn-sm btn-outline-primary"
                    :disabled="!(docIndexes.length > 0)"
                    @click="mostrar('transferir')"
                  >
                    Transferir
                  </button>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Vuex        from 'vuex'
  import DocuDerivar from '@/js/components/tramite/documentos/en-poceso/DocuDerivar'
  import Mpv         from '@/js/store/models/mpv'
  import moment      from 'moment'

  export default {
    name      : 'Mpv',
    components: {
      DocuDerivar
    },
    props     : {
      routes: {
        type   : [Object, String],
        default: ''
      }
    },

    data() {
      return {
        filtro            : {
          id         : null,
          docu_estado: null,
          page       : null
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
        formRegistro      : {
          id             : null,
          docu_numero_doc: null,
          docu_siglas_doc: null,
          docu_folios    : null,
          docu_asunto    : null
        },
        eleccionArchivador: {
          forma      : 1,
          idarch     : null,//colocar un archivador por default
          acciones   : null,
          iddocumento: null,
          tipoDoc    : null
        },
        id_dependencia    : null,
        derivaciones      : [],
        docIndexes        : [],
        operSelected      : [],
        saving            : false
      }
    },
    computed: {
      ...Vuex.mapGetters([
                          'getDependenciaNombre',
                          'getUsuariosActivoNombre',
                          'getSedes',
                          'getFormatBytes'])
    },
    mounted() {
      this.buscarRegistro(1)
      this.obtenerRutas(this.routes)
      this.obtenerJsonAll()
    },
    methods : {
      ...Vuex.mapActions([
                          'imprimirDocumentoPdf',
                          'obtenerJsonAll',
                          'obtenerRutas']),

      moment(a) {
        return moment(a)
      },
      buscarRegistro(page = 1) {
        this.filtro.page = page
        Mpv.registrosIndex({params: this.filtro}).then(response => {
          this.documentos   = response.data
          this.operSelected = []
          this.docIndexes   = []
        })
      },
      mostrar(accion) {
        if (this.docIndexes.length === 0) {
          toastr.warning('debe de seleccionar al menos un documento!!')
        } else {
          switch (accion) {
            case 'editar': {
              $('#editar').modal({
                                   backdrop: 'static',
                                   keyboard: false
                                 })
              this.formRegistro.id              = this.documentos.data[this.docIndexes[0]].id
              this.formRegistro.docu_numero_doc = this.documentos.data[this.docIndexes[0]].docu_numero_doc
              this.formRegistro.docu_siglas_doc = this.documentos.data[this.docIndexes[0]].docu_siglas_doc
              this.formRegistro.docu_folios     = this.documentos.data[this.docIndexes[0]].docu_folios
              this.formRegistro.docu_asunto     = this.documentos.data[this.docIndexes[0]].docu_asunto
            }
              break
            case 'derivar': {
              this.derivaciones = []
              $('#derivar').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                  })
            }
              break
            case 'archivar': {
              if (this.verificarDerivado()) {
                toastr.warning('no se puede archivar un documento que se encuentre derivado!!')
              } else {
                $('#archivar').modal({
                                       backdrop: 'static',
                                       keyboard: false
                                     })
              }
            }
              break
            case 'transferir': {
              if (this.verificarDerivado()) {
                toastr.warning('no se puede transferir un documento que se encuentre derivado!!')
              } else {
                $('#transferir').modal({
                                         backdrop: 'static',
                                         keyboard: false
                                       })
              }
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
      grabarDerivaciones() {
        const params = {
          operSelected: this.operSelected,
          derivaciones: this.derivaciones
        }
        if (!this.saving) {
          this.saving = true
          Mpv.registroDerivar(params)
          .then(response => {
            console.log(response.data)
            if (response.data.status) {
              toastr.success(response.data.msg)
              $('#derivar').modal('hide')
              this.saving = false
              this.buscarRegistro()
            }
          })
          .catch(error => {
            console.log('Ocurrio un error guardar la derivacion, verifique su conexion a internet e intentelo nuevamente')
            this.saving = false
            this.buscarRegistro()
          })
        }
      },
      selectArchivar(documento) {
        if (this.operSelected.indexOf(documento.id) === -1 && this.docIndexes.indexOf(this.documentos.data.indexOf(documento)) === -1) {
          this.operSelected.push(documento.id)
          this.docIndexes.push(this.documentos.data.indexOf(documento))
        } else {
          this.operSelected.splice(this.operSelected.indexOf(documento.id), 1)
          this.docIndexes.splice(this.docIndexes.indexOf(this.documentos.data.indexOf(documento)), 1)
        }
      },
      documentoAccion() {
        const params = {
          idDocumento: this.operSelected,
          motivo     : this.eleccionArchivador.acciones
        }
        Mpv.registroArchivar(params).then(response => {
          this.operSelected = []
          this.docIndexes   = []
          this.buscarRegistro()
        })

      },
      transferir() {
        const params = {
          idDocumento   : this.operSelected,
          id_dependencia: this.id_dependencia
        }
        Mpv.registroTransferir(params).then(response => {
          this.operSelected = []
          this.docIndexes   = []
          toastr.success('se transfirió con éxito!')
          this.buscarRegistro()
        })
      },
      editar() {
        Mpv.registroEdit(this.formRegistro.id, this.formRegistro).then(response => {
          this.operSelected = []
          this.docIndexes   = []
          this.buscarRegistro()
        })
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

  input{
    text-transform: uppercase;
  }

  .doc-link {
    width: 280px;
    text-overflow: ellipsis;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    margin-bottom: 0;
  }
</style>
