<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">PAPELETAS SOLICITADAS</div>
      <div class="panel-body">
        <form @submit.prevent="buscarDocumentos()">
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-2">
              <label>Registro:</label>
              <input v-model="formData.iddocumento" class="form-control" name="depe_nombre" />
            </div>
            <div class="col-sm-4">
              <div class="input-group date">
                <label>Fecha Desde:</label>
                <input v-model="formData.docu_fecha_desde" type="date" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="input-group date">
                <label>Fecha Hasta:</label>
                <input v-model="formData.docu_fecha_hasta" type="date" class="form-control" />
              </div>
            </div>
            <div class="col-sm-2">
              <br />
              <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-search"></span> Buscar
              </button>
            </div>
          </div>
        </form>
        <!-- Modal derivar-->
        <div id="derivar" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-body" style="padding: 0;">
                <derivar-c :derivaciones="derivaciones" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="grabarDerivaciones()">
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
                    <option v-for="(archivador, indexArchivador) in getArchivadorProceso" :key="indexArchivador" :value="archivador.idarch">{{
                      archivador.arch_periodo + '/' + archivador.arch_nombre
                    }}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Acciones</label>
                  <textarea
                    :value="eleccionArchivador.acciones != null ? eleccionArchivador.acciones.toUpperCase() : null"
                    cols="10"
                    rows="3"
                    class="form-control"
                    @input="eleccionArchivador.acciones = $event.target.value.toUpperCase()"
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
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
          <div class="col-sm-12">
            <div class="btn-group" role="group" aria-label="Basic example">
              <p>
                <button
                  class="btn btn-sm btn-secundary"
                  :disabled="
                    !(
                      docIndexes.length == 1 &&
                      userId == documentos.data[docIndexes[0]].docu_idusuario &&
                      3 != documentos.data[docIndexes[0]].oper_idtope
                    )
                  "
                  @click="editar()"
                >
                  <span class="glyphicon glyphicon-print"></span>Editar
                </button>
                <button
                  :disabled="!(docIndexes.length == 1 && 1 == documentos.data[docIndexes[0]].oper_idtope)"
                  class="btn btn-sm btn-secundary"
                  @click="derivar()"
                >
                  <span class=""></span>Derivar
                </button>
                <button
                  :disabled="
                    !(
                      docIndexes.length == 1 &&
                      2 == documentos.data[docIndexes[0]].oper_idtope &&
                      documentos.data[docIndexes[0]].oper_depeid_d == documentos.data[docIndexes[0]].oper_iddependencia
                    )
                  "
                  class="btn btn-sm btn-danger"
                  @click="eliminarDerivacion()"
                >
                  <span class=""></span>Eliminar derivación
                </button>
                <button
                  :disabled="!(docIndexes.length == 1 && 2 == documentos.data[docIndexes[0]].oper_idtope)"
                  class="btn btn-sm btn-success"
                  @click="archivar()"
                >
                  Archivar papeleta
                </button>
              </p>
            </div>
          </div>
        </div>
        <div v-if="mostrarDocumentos" class="box">
          <div class="box-body">
            <table class=" table table-bordered table-condensed table-hover ">
              <thead>
                <tr class="info">
                  <th style="width:7%">REGISTRO<br />EXPEDIENTE</th>
                  <th style="width:15%">REGISTRO</th>
                  <th style="width:40%">DOCUMENTO</th>
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
                  :class="
                    operSelected.indexOf(documento.idoperacion) >= 0
                      ? 'danger'
                      : documento.depe_nombre_destino != null
                        ? 'success'
                        : 'null'
                  "
                  @click="selectPapeleta(documento)"
                >
                  <td>
                    <strong>Reg.</strong>{{ ' ' + ('00000000' + documento.iddocumento).slice(-8) }}<br />
                    <strong>Exp.</strong>{{ ' ' + ('00000000' + documento.docu_idexma).slice(-8) }}<br />
                    {{
                      documento.oper_idtope == 1 ? 'REGISTRADO' : documento.oper_idtope == 2 ? 'DERIVADO' : 'ARCHIVADO'
                    }}
                  </td>
                  <td class="registro"><strong>Fecha:</strong>{{ documento.docu_fecha_doc }}</td>
                  <td class="documento">
                    <strong :class="$mq">Doc:</strong>
                    <div :class="$mq">
                      {{ documento.tdoc_descripcion + ' ' }}{{ ('000000' + documento.docu_numero_doc).slice(-6)
                      }}{{ documento.docu_siglas_doc }}
                    </div>
                    <strong :class="$mq">Firma:</strong>
                    <div :class="$mq">{{ documento.docu_firma }}</div>
                    <strong :class="$mq">Cargo:</strong>
                    <div :class="$mq">{{ documento.docu_cargo }}</div>
                    <strong :class="$mq">Asunto:</strong>
                    <div :class="$mq">{{ documento.docu_asunto }}</div>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="documentos" :limit="limit" @pagination-change-page="buscarDocumentos" />
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-12">
                <div class="btn-group" role="group" aria-label="Basic example">
                  <p>
                    <button
                      class="btn btn-sm btn-secundary"
                      :disabled="
                        !(
                          docIndexes.length == 1 &&
                          userId == documentos.data[docIndexes[0]].docu_idusuario &&
                          3 != documentos.data[docIndexes[0]].oper_idtope
                        )
                      "
                      @click="editar()"
                    >
                      <span class="glyphicon glyphicon-print"></span>Editar
                    </button>
                    <button
                      :disabled="!(docIndexes.length == 1 && 1 == documentos.data[docIndexes[0]].oper_idtope)"
                      class="btn btn-sm btn-secundary"
                      @click="derivar()"
                    >
                      <span class=""></span>Derivar
                    </button>
                    <button
                      :disabled="
                        !(
                          docIndexes.length == 1 &&
                          2 == documentos.data[docIndexes[0]].oper_idtope &&
                          documentos.data[docIndexes[0]].oper_depeid_d ==
                          documentos.data[docIndexes[0]].oper_iddependencia
                        )
                      "
                      class="btn btn-sm btn-danger"
                      @click="eliminarDerivacion()"
                    >
                      <span class=""></span>Eliminar derivación
                    </button>
                    <button
                      :disabled="!(docIndexes.length == 1 && 2 == documentos.data[docIndexes[0]].oper_idtope)"
                      class="btn btn-sm btn-success"
                      @click="archivar()"
                    >
                      Archivar papeleta
                    </button>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {

  props: ['route-papeletas', 'route-derivar', 'route-eliminar-derivacion', 'route-archivar', 'limit', 'user-id'],  

  data() {
    return {
      formData: {
        iddocumento: null,
        idadmin: this.userId,
        docu_fecha_desde: null,
        docu_fecha_hasta: null,
        page: null
      },
      documentos: {
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
      eleccionArchivador: {
        forma: null,
        idarch: null,
        acciones: null,
        iddocumento: null,
        tipoDoc: 1
      },
      operSelected: [],
      docIndexes: [],
      mostrarDocumentos: true,
      derivaciones: []
    }
  },
  
  computed: {
    ...Vuex.mapGetters(['getArchivadorProceso'])
  },

  mounted() {
    this.buscarDocumentos()
    var date = new Date() // Or the date you'd like converted.
    var isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
    this.formData.docu_fecha_desde = isoDate.slice(0, 10)
    this.formData.docu_fecha_hasta = isoDate.slice(0, 10)
  },

  methods: {
    buscarDocumentos(page = 1) {
      this.formData.page = page
      axios.get(this.routePapeletas, { params: this.formData }).then(response => {
        this.documentos = response.data
        this.operSelected = []
        this.docIndexes = []
      })
    },

    selectPapeleta(documento) {
      if (
        this.operSelected.indexOf(documento.idoperacion) === -1 &&
        this.docIndexes.indexOf(this.documentos.data.indexOf(documento)) === -1
      ) {
        this.operSelected.push(documento.idoperacion)
        this.docIndexes.push(this.documentos.data.indexOf(documento))
      } else {
        this.operSelected.splice(this.operSelected.indexOf(documento.idoperacion), 1)
        this.docIndexes.splice(this.docIndexes.indexOf(this.documentos.data.indexOf(documento)), 1)
      }
    },

    derivar() {
      this.derivaciones = []
      $('#derivar').modal()
    },

    grabarDerivaciones() {
      const params = {
        operSelected: this.operSelected,
        derivaciones: this.derivaciones
      }
      axios.post(this.routeDerivar, params).then(response => {
        if (response.data.status) {
          toastr.success(response.data.msg)
          this.buscarDocumentos()
        }
      })
    },

    eliminarDerivacion() {
      if (confirm('Esta seguro de eliminar la derivación?')) {
        const params = {
          devolver: this.operSelected
        }
        axios.post(this.routeEliminarDerivacion, params).then(response => {
          if (response.data.status) {
            toastr.success(response.data.msg)
            this.buscarDocumentos()
          }
        })
      }
    },

    archivar() {
      $('#archivar').modal()
    },

    documentoAccion() {
      const params = {
        idDocumento: this.operSelected,
        datoDocumento: this.eleccionArchivador
      }
      axios.post(this.routeArchivar, params).then(response => {
        this.buscarDocumentos()
        this.operSelected = []
        this.eleccionArchivador = []
      })
    },

    editar() {
      if (this.docIndexes.length === 1) {
        this.$router.push({
          name: 'OperPapeletaEdit',
          params: { id: this.documentos.data[this.docIndexes[0]].iddocumento }
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
</style>
