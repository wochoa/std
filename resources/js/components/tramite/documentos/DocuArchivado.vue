<template>
  <div class="panel-body">
    <div class="row form-group" style="width: 100%;margin-left: -0px;">
      <form @submit.prevent="buscarDocArchivados()">
        <div class="form-group" style="width: 100%;margin-left: -0px;">
          <div class="col-sm-3">
            <label>Documentos del Usuario</label>
            <select v-model="formData.oper_idusuario" class="form-control" @change="buscarDocArchivados()">
              <option :value="null">Todos</option>
              <option v-for="(user, indexUser) in getUsuarios" :key="indexUser" :value="user.id">{{ user.adm_name }}</option>
            </select>
          </div>
          <div class="col-sm-4">
            <label>Archivador</label>
            <select v-model="formData.idarch" class="form-control" @change="buscarDocArchivados()">
              <option :value="null">Todos</option>
              <option v-for="(archivador, indexArchivado) in getArchivadores" :key="indexArchivado" :value="archivador.idarch">
                {{ archivador.arch_periodo + '/' + archivador.arch_nombre }}
              </option>
            </select>
          </div>
          <div class="col-sm-2">
            <label>Forma</label>
            <select v-model="formData.oper_tarchi_id" class="form-control">
              <option :value="null">Todos</option>
              <option value="0">Temporal</option>
              <option value="1">Definitivo</option>
            </select>
          </div>
          <div :class="{ 'col-sm-2': true, 'has-error': errors.has('registro') }">
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
          <div class="col-sm-1">
            <br />
            <button class="btn btn-primary" type="submit">
              <span class="glyphicon glyphicon-search"></span> Buscar
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="row form-group" style="width: 100%;margin-left: -0px;">
      <div class="col-sm-12">
        <div class="col-sm-6">
          <button
            class="btn btn-sm btn-success"
            :disabled="!puedeDevolver || docDevolveProceso.length == 0"
            @click="devolverProceso()"
          >
            <span class=""></span>Devolver a en proceso
          </button>
        </div>
      </div>
    </div>
    <!--TABLA-->
    <div class="box" style="overflow-x:scroll;">
      <div class="box-body">
        <pagination :data="archivados" :limit="limit" @pagination-change-page="buscarDocArchivados" />
        <table class="table table-bordered table-condensed table-hover">
          <thead>
            <tr class="info">
              <th style="width:7%">Registro</th>
              <th style="width:7%">Adjuntado al</th>
              <th style="width:16%">Archivador</th>
              <th style="width:40%">Documento</th>
              <th style="width:20%">Detalles</th>
              <th style="width:10%">Archivos</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td v-if="archivados.data.length == 0" colspan="21" class="text-center">
                No hay documentos, pruebe cambiando los filtros
              </td>
            </tr>
            <tr
              v-for="(documento, index) in archivados.data"
              :key="index"
              :class="docDevolveProceso.indexOf(documento.idoperacion) >= 0 ? 'danger' : null"
              @click="selectDevolverProceso(documento)"
            >
              <td class="registro">
                <strong>Reg.</strong>
                <a
                  href="#"
                  @click.prevent.stop="buscarByDocumento({ iddocumento: documento.iddocumento, modal: true })"
                >{{ ' ' + ('00000000' + documento.iddocumento).slice(-8) }}</a>
              </td>
              <td v-if="documento.oper_iddocumento_adj != null" class="registro">
                <strong>Reg.</strong>{{ ('00000000' + documento.oper_iddocumento_adj).slice(-8) }}
              </td>
              <td v-else class="registro">&nbsp;</td>
              <td v-if="documento.arch_nombre != null" class="registro">
                {{ documento.arch_periodo + ' / ' }}{{ documento.arch_nombre }}
              </td>
              <td v-else class="registro">&nbsp;</td>
              <td class="documento">
                <strong :class="$mq">Doc:</strong>
                <div v-if="documento.tdoc_descripcion != null" :class="$mq">
                  {{ documento.tdoc_descripcion + ' ' }}{{ ('000000' + documento.docu_numero_doc).slice(-6)
                  }}{{ documento.docu_origen == 1 ? '-' + documento.docu_fecha_doc.substr(0, 4) : ''
                  }}{{ documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : null }}
                </div>
                <div v-else :class="$mq">&nbsp;</div>
                <strong :class="$mq">Firma:</strong>
                <div :class="$mq">{{ documento.docu_firma }}</div>
                <strong :class="$mq">Cargo:</strong>
                <div :class="$mq">{{ documento.docu_cargo }}</div>
                <strong :class="$mq">Asunto:</strong>
                <div :class="$mq">{{ documento.docu_asunto }}</div>
                <strong :class="$mq">Dependencia:</strong>
                <div :class="$mq">{{ documento.depe_nombre }}</div>
              </td>
              <td>
                <strong :class="$mq">Detalle:</strong>{{ documento.oper_acciones }}<br />
                <strong :class="$mq">Fecha:</strong>{{ documento.fecha_archivado }}<br />
                <strong :class="$mq">Usuario:</strong>{{ documento.adm_name + ' ' }}{{ documento.adm_lastname }}
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
                              :class=" archivo.file_tipo.indexOf('image') === 0? 'glyphicon glyphicon-picture': 'glyphicon glyphicon-file'"
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
        <pagination :data="archivados" :limit="limit" @pagination-change-page="buscarDocArchivados" />
      </div>
    </div>
    <!--FIN TABLA -->
    <div class="row form-group" style="width: 100%;margin-left: -0px;">
      <div class="col-sm-12">
        <div class="col-sm-6">
          <button
            class="btn btn-sm btn-success"
            :disabled="docDevolveProceso.length == 0"
            @click="devolverProceso()"
          >
            <span class=""></span>Devolver a en proceso
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'
export default {

  props:{
            routePrintPdf:{
              type: String,
              default: ''
            },
          routeArchivado:{
              type: String,
              default: ''
            },
          routeDevolver:{
              type: String,
              default: ''
            },
          routeUsuariosDependencia:{
              type: String,
              default: ''
            },
          routeArchivadores:{
              type: String,
              default: ''
            },
          usuario:{
              type: Number,
              default: 4
            },
          limit:{
              type: Number,
              default: 3
            }
        },

  data() {
    return {
      puedeDevolver: true,
      formData: {
        oper_idusuario: this.usuario,
        idarch: null,
        iddocumento: null,
        oper_tarchi_id: null,
        page: null
      },
      archivados: {
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
      docDevolveProceso: [],
      mostrarDocumentos: true
    }
  },

  computed: {
    ...Vuex.mapGetters(['getUsuarios', 'getArchivadores','getFormatBytes'])
  },

  mounted() {
    if (location.hash == '#temporal') this.formData.oper_tarchi_id = 0
    this.buscarDocArchivados()
    this.obtenerArchivadores()
  },

  methods: {
    ...Vuex.mapActions([
      'buscarByDocumento',
      'obtenerArchivadores',
      'imprimirDocumentoPdf'
      ]),

    buscarDocArchivados(page = 1) {
      this.$validator.validate().then(result => {
        if (result) {
          this.formData.page = page
          axios.get(this.routeArchivado, { params: this.formData }).then(reponse => {
            this.archivados = reponse.data
          })
        } else {
          console.log('incompleto')
        }
      })
    },

    selectDevolverProceso(documento) {
      if (this.docDevolveProceso.indexOf(documento.idoperacion) == -1) {
        this.docDevolveProceso.push(documento.idoperacion)
      } else {
        this.docDevolveProceso.splice(this.docDevolveProceso.indexOf(documento.idoperacion), 1)
      }
    },

    devolverProceso() {
      if (confirm('Esta seguro de devolver en proceso el documento?')) {
        const params = {
          devolver: this.docDevolveProceso
        }
        this.puedeDevolver = false
        axios.post(this.routeDevolver, params).then(response => {
          toastr.success('Documento devuelto a en procesos')
          this.buscarDocArchivados()
          this.docDevolveProceso = []
          this.puedeDevolver = true
        })
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
