<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">PAPELETAS SOLICITADAS</div>
      <div class="panel-body">
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
          <form action="" @submit.prevent="buscarDocumentos()">
            <div class="col-sm-2">
              <label>Registro:</label>
              <input v-model="formData.iddocumento" class="form-control" name="depe_nombre" />
            </div>
            <div class="col-sm-2">
              <label>Apellidos</label>
              <input v-model="formData.lastname_usuario" type="text" class="form-control" />
            </div>
            <div class="col-sm-3">
              <div class="input-group date">
                <label>Fecha Desde:</label>
                <input v-model="formData.docu_fecha_desde" type="date" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="input-group date">
                <label>Fecha Hasta:</label>
                <input v-model="formData.docu_fecha_hasta" type="date" class="form-control" />
              </div>
            </div>
            <div class="col-sm-2">
              <br />
              <button type="button" class="btn btn-primary" @click="buscarDocumentos()">
                <span class="glyphicon glyphicon-search"></span>Buscar
              </button>
            </div>
          </form>
        </div>
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
          <div class="col-sm-12">
            <div class="btn-group" role="group" aria-label="Basic example">
              <p>
                <button
                  :disabled="!(docIndexes.length == 1 && docPorRecibir.data[docIndexes[0]].oper_idtope == 2)"
                  class="btn btn-sm btn-success"
                  @click="recepcionDocumento()"
                >
                  Registrar hora salida
                </button>
                <button
                  :disabled="!(docIndexes.length == 1 && docPorRecibir.data[docIndexes[0]].oper_idtope == 1)"
                  class="btn btn-sm btn-danger"
                  @click="registroHoraRetorno()"
                >
                  <span class=""></span>Registrar hora retorno
                </button>
              </p>
            </div>
          </div>
        </div>
        <div class="box">
          <div class="box-body">
            <table class="table table-bordered table-hover table-condensed">
              <thead>
                <tr class="info">
                  <th style="width:7%">REGISTRO<br />EXPEDIENTE</th>
                  <th style="width:10%">REGISTRO</th>
                  <th style="width:25%">DOCUMENTO</th>
                  <th style="width:15%">DESTINO</th>
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
                  :class="
                    docRecibir.indexOf(documento.idoperacion) >= 0
                      ? 'danger'
                      : documento.depe_nombre_destino != null
                        ? 'success'
                        : 'null'
                  "
                  @click="selectRecepcion(documento)"
                >
                  <td class="registro">
                    <strong>Reg.</strong>{{ ('00000000' + documento.iddocumento).slice(-8) }}<br />
                    <strong>Exp.</strong>{{ ('00000000' + documento.docu_idexma).slice(-8) }}<br />
                    {{
                      documento.oper_idtope == 1 ? 'REGISTRADO' : documento.oper_idtope == 2 ? 'DERIVADO' : 'ARCHIVADO'
                    }}
                  </td>
                  <td class="registro"><strong>Fecha:</strong>{{ documento.created_at }}<br /></td>
                  <td class="documento">
                    <strong :class="$mq">Doc:</strong>
                    <div v-if="documento.tdoc_descripcion != null" :class="$mq">
                      {{ documento.tdoc_descripcion + ' ' }}{{ ('000000' + documento.docu_numero_doc).slice(-6)
                      }}{{ '-' + documento.docu_siglas_doc }}
                    </div>
                    <div v-else :class="$mq">&nbsp;</div>
                    <strong :class="$mq">Firma:</strong>
                    <div :class="$mq">{{ documento.docu_firma }}</div>
                    <strong :class="$mq">Cargo:</strong>
                    <div :class="$mq">{{ documento.docu_cargo }}</div>
                    <strong :class="$mq">Asunto:</strong>
                    <div :class="$mq">{{ documento.docu_asunto }}</div>
                  </td>
                  <td>
                    <strong :class="$mq">Detalle:</strong>{{ documento.docu_detalle }}<br />
                    <strong :class="$mq">Destino:</strong>{{ documento.depe_nombre_destino }}<br />
                    <strong :class="$mq">Para:</strong>
                    {{
                      documento.name_usuario_destino != null
                        ? documento.name_usuario_destino + ' ' + documento.lastname_usuario_destino
                        : documento.depe_nombre_destino
                    }}<br />
                    <strong :class="$mq">Remitente:</strong>{{ documento.name_usuario + ' '
                    }}{{ documento.lastname_usuario }}
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="docPorRecibir" :limit="limit" @pagination-change-page="buscarDocumentos" />
          </div>
        </div>
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
          <div class="col-sm-12">
            <div class="btn-group" role="group" aria-label="Basic example">
              <p>
                <button
                  :disabled="!(docIndexes.length == 1 && docPorRecibir.data[docIndexes[0]].oper_idtope == 2)"
                  class="btn btn-sm btn-success"
                  @click="recepcionDocumento()"
                >
                  Registrar hora salida
                </button>
                <button
                  :disabled="!(docIndexes.length == 1 && docPorRecibir.data[docIndexes[0]].oper_idtope == 1)"
                  class="btn btn-sm btn-danger"
                  @click="registroHoraRetorno()"
                >
                  <span class=""></span>Registrar hora retorno
                </button>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {

  props: ['route-papeletas-solicitadas', 'route-recepcionar', 'route-archivar', 'route-archivador', 'limit'],
  
  data() {
    return {
      formData: {
        iddocumento: null,
        lastname_usuario: null,
        docu_fecha_desde: null,
        docu_fecha_hasta: null,
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
      eleccionArchivador: {
        forma: 1,
        idarch: null,
        acciones: 'Ok',
        iddocumento: null,
        arch_periodo: new Date().getFullYear(),
        tipoDoc: null
      },
      docRecibir: [],
      docIndexes: [],
      mostrarDocumentos: true,
      tipoDoc: null,
      arch_periodo: new Date().getFullYear(),
      derivaciones: [
        { oper_acciones: null, oper_depeid_d: null, oper_detalledestino: null, oper_forma: false, oper_usuid_d: null }
      ]
    }
  },

  mounted() {
    this.buscarDocumentos()
    this.obtenerArchivador()
    var date = new Date() // Or the date you'd like converted.
    var isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
    this.formData.docu_fecha_desde = isoDate.slice(0, 10)
    this.formData.docu_fecha_hasta = isoDate.slice(0, 10)
  },

  methods: {
    buscarDocumentos(page = 1) {
      this.formData.page = page
      axios.get(this.routePapeletasSolicitadas, { params: this.formData }).then(response => {
        this.docPorRecibir = response.data
        this.docRecibir = []
      })
    },

    selectRecepcion(documento) {
      if (
        this.docRecibir.indexOf(documento.idoperacion) === -1 &&
        this.docIndexes.indexOf(this.docPorRecibir.data.indexOf(documento)) === -1
      ) {
        this.docRecibir.push(documento.idoperacion)
        this.docIndexes.push(this.docPorRecibir.data.indexOf(documento))
      } else {
        this.docRecibir.splice(this.docRecibir.indexOf(documento.idoperacion), 1)
        this.docIndexes.splice(this.docIndexes.indexOf(this.docPorRecibir.data.indexOf(documento)), 1)
      }
    },

    recepcionDocumento() {
      const params = {
        recibir: this.docRecibir,
        derivaciones: this.derivaciones,
        tipoDoc: this.tipoDoc
      }
      axios.post(this.routeRecepcionar, params).then(response => {
        this.buscarDocumentos()
        this.derivaciones = []
        this.docIndexes = []
      })
    },

    registroHoraRetorno() {
      const params = {
        idDocumento: this.docRecibir,
        datoDocumento: this.eleccionArchivador
      }
      axios.post(this.routeArchivar, params).then(response => {
        this.buscarDocumentos()
        this.docIndexes = []
      })
    },

    obtenerArchivador() {
      const params = {
        arch_periodo: this.arch_periodo
      }
      axios.post(this.routeArchivador, params).then(response => {
        if (response.data.idarch >= 1) {
          this.eleccionArchivador.idarch = response.data.idarch
        } else {
          this.eleccionArchivador.idarch = null
        }
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
}
</style>
