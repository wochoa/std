<template>
  <div>
    <div class="row form-group" style="width: 100%;margin-left: -0px;">
      <form action="" @submit.prevent="documentoRecibir()">
        <div class="form-group" style="width: 100%;margin-left: -0px;">
          <div :class="{ 'col-sm-4': true, 'has-error': errors.has('registro') }">
            <label>Registro</label>
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
            <label>Documento del Usuario</label>
            <select v-model="formData.idadmin" class="form-control" @change="documentoRecibir()">
              <option :value="null">Todos</option>
              <option v-for="(admin, indexAdmin) in getUsuariosActivo" :key="indexAdmin" :value="admin.id">{{ admin.adm_name }}</option>
            </select>
          </div>
          <div class="col-sm-4">
            <br />
            <button type="submit" class="btn btn-primary">
              <span class="glyphicon glyphicon-search"> Buscar</span>
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="row form-group" style="width: 100%;margin-left: -0px;">
      <div class="col-sm-12">
        <div class="col-sm-6">
          <button
            :disabled="!puedeRecibir || docRecibir.length == 0"
            class="btn btn-sm btn-success"
            @click="recepcionarDocumento()"
          >
            <span class=""></span>Recepción
          </button>
        </div>
      </div>
    </div>
    <!--TABLA-->
    <div v-if="mostrarDocumentos" class="box">
      <div class="box-body">
        <pagination :data="docPorRecibir" :limit="limit" @pagination-change-page="documentoRecibir" />
        <table class="table table-bordered table-hover table-condensed">
          <thead>
            <tr class="info">
              <th style="width:7%">REGISTRO<br />EXPEDIENTE</th>
              <th style="width:10%">REGISTRO</th>
              <th style="width:25%">DOCUMENTO</th>
              <th style="width:15%">DESTINO</th>
              <th style="width:5%">ARCHIVO</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td v-if="docPorRecibir.data.length == 0" colspan="21" class="text-center">
                No hay documentos, pruebe cambiando los filtros
              </td>
            </tr>
            <tr
              v-for="(documento, index) in docPorRecibir.data"
              :key="index"
              :set="(dias = moment().diff(moment(documento.created_at), 'days'))"
              :class="docRecibir.indexOf(documento.idoperacion) >= 0 ? 'danger' : null"
              @click="selectRecepcion(documento)"
            >
              <td class="registro">
                <span
                  :class="{
                    badge: true,
                    'badge-danger': dias > 20,
                    'badge-warning': dias > 10 && dias <= 20,
                    'badge-success': dias <= 10}"
                >{{ dias }} días</span><br />
                <strong>Reg.</strong>
                <a href="#" @click.prevent.stop="buscarByDocumento({ iddocumento: documento.iddocumento, modal: true })">
                  {{ ' ' + ('00000000' + documento.iddocumento).slice(-8) }}</a><br />
                <strong>Exp.</strong>{{ ('00000000' + documento.docu_idexma).slice(-8) }}
              </td>
              <td class="registro">
                <strong>Fecha:</strong>{{ documento.docu_fecha_doc }}<br />
                <strong>Forma:</strong>{{ documento.oper_forma == 1 ? 'COPIA' : 'ORIGINAL' }}<br />
                <strong>Folios:</strong>{{ documento.docu_folios }}
              </td>
              <td class="documento">
                <strong :class="$mq">Doc:</strong>
                <div v-if="documento.tdoc_descripcion != null" :class="$mq">
                  {{ documento.tdoc_descripcion + ' ' }}{{ ('000000' + documento.docu_numero_doc).slice(-6)
                  }}{{ documento.docu_origen == 1 ? '-' + documento.docu_fecha_doc.substr(0, 4) : ''
                  }}{{ documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : '' }}
                </div>
                <div v-else :class="$mq">&nbsp;</div>
                <strong :class="$mq">Firma:</strong>
                <div :class="$mq">{{ documento.docu_firma }}</div>
                <strong :class="$mq">Cargo:</strong>
                <div :class="$mq">{{ documento.docu_cargo }}</div>
                <strong :class="$mq">Asunto:</strong>
                <div :class="$mq">{{ documento.docu_asunto }}</div>
                <strong :class="$mq">Dependencia:</strong>
                <div :class="$mq">{{ documento.depe_nombre_origen }}</div>
              </td>
              <td>
                <strong :class="$mq">Destino:</strong>{{ documento.depe_nombre_destino }}<br />
                <strong :class="$mq">Para:</strong>{{
                  documento.name_usuario_destino != null
                    ? documento.name_usuario_destino + ' ' + documento.lastname_usuario_destino
                    : documento.depe_nombre_destino
                }}<br />
                <strong :class="$mq">Detalle:</strong>{{ documento.docu_detalle }}<br />
                <strong :class="$mq">Remitente:</strong>{{ documento.name_usuario + ' '
                }}{{ documento.lastname_usuario }}
              </td>
              <td>
                <div v-if="documento.docu_archivo.length > 0">
                  <table>
                    <tbody>
                      <tr>
                        <td>
                          <span v-if="documento.docu_digital" class="badge badge-info">Documento ingresado MPV</span>
                          <span v-else class="badge badge-warning">Documento registrado internamente</span>
                        </td>
                      </tr>
                      <tr v-for="(archivo, indexArchivo) in documento.docu_archivo.filter(d => d.file_mostrar)" :key="indexArchivo">
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
        <pagination :data="docPorRecibir" :limit="limit" @pagination-change-page="documentoRecibir" />
      </div>
    </div>
    <div class="row form-group" style="width: 100%;margin-left: -0px;">
      <div class="col-sm-12">
        <div class="col-sm-6">
          <button
            class="btn btn-sm btn-success"
            :disabled="!(docRecibir.length > 0)"
            @click="recepcionarDocumento()"
          >
            <span class=""></span>Recepción
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import moment from 'moment'
  import Vuex from 'vuex'
export default {

  name: 'DocuRecibir',

  props: {
          routePrintPdf:{
              type: String,
              default: ''
            },
          routeRecibir:{
              type: String,
              default: ''
            },
          routeRecepcionar:{
              type: String,
              default: ''
            },
          routeUsuariosDependencia:{
              type: String,
              default: ''
            },
          user:{
              type: Number,
              default: 1
            },
          limit:{
              type: Number,
              default: 3
            }
        },

  data() {
    return {
      puedeRecibir: true,
      formData: {
        iddocumento: null,
        idadmin: this.user,
        page: null
      },
      docPorRecibir: {
        current_page: null,
        data: [],
        from: null,
        last_page: null,
        next_page_url: null,
        path: null,
        per_page: null,
        prev_page_url: null,
        to: null,
        total: null
      },
      docRecibir: [],
      mostrarDocumentos: true,
      tipoDoc: null,
      derivaciones: [
        { oper_acciones: null, oper_depeid_d: null, oper_detalledestino: null, oper_forma: false, oper_usuid_d: null }
      ]
    }
  },

  computed: {
    ...Vuex.mapGetters(['getUsuariosActivo','getFormatBytes'])
  },

  mounted() {
    this.documentoRecibir()
  },

  methods: {
    ...Vuex.mapActions(['buscarByDocumento','imprimirDocumentoPdf']),

    documentoRecibir(page = 1) {
      this.$validator.validate().then(result => {
        if (result) {
          this.formData.page = page
          axios.get(this.routeRecibir, { params: this.formData }).then(response => {
            this.docPorRecibir = response.data
            this.docRecibir = []
          })
        } else {
          console.log('incompleto')
        }
      })
    },

    selectRecepcion(documento) {
      //console.log(this.docRecibir.indexOf(documento.idoperacion));
      if (this.docRecibir.indexOf(documento.idoperacion) == -1) {
        this.docRecibir.push(documento.idoperacion)
      } else {
        this.docRecibir.splice(this.docRecibir.indexOf(documento.idoperacion), 1)
      }
    },

    recepcionarDocumento() {
      if (confirm('Esta seguro de recepcionar el documento?')) {
        const params = {
          recibir: this.docRecibir,
          derivaciones: this.derivaciones,
          tipoDoc: this.tipoDoc
        }
        this.puedeRecibir = false
        axios.post(this.routeRecepcionar, params).then(response => {
          this.documentoRecibir()
          this.docRecibir = []
          this.puedeRecibir = true
        })
      }
    },

    moment(a) {
      return moment(a)
    },
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
.doc-link {
  width: 280px;
  text-overflow: ellipsis;
  text-align: left;
  white-space: nowrap;
  overflow: hidden;
  margin-bottom: 0;
}
</style>
