<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">PAPELETAS PARA AUTORIZAR</div>
      <div class="panel-body">
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
          <form action="" @submit.prevent="buscarDocumentos()">
            <div class="col-sm-2">
              <label>Registro:</label>
              <input v-model="formData.iddocumento" class="form-control" />
            </div>
            <div class="col-sm-2">
              <label>Apellidos</label>
              <input
                type="text"
                class="form-control"
                :value="formData.lastname_usuario != null ? formData.lastname_usuario.toUpperCase() : null"
                @input="formData.lastname_usuario = $event.target.value.toUpperCase()"
              />
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
              <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-search"></span> Buscar
              </button>
            </div>
          </form>
        </div>
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
          <div class="col-sm-12">
            <div class="btn-group" role="group" aria-label="Basic example">
              <p>
                <button
                  :disabled="!(docIndexes.length == 1 && derivaciones[0].oper_depeid_d != null)"
                  class="btn btn-sm btn-success"
                  @click="recepcionDocumento()"
                >
                  <span class=""></span>Autorizar
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
                  :class="docRecibir.indexOf(documento.idoperacion) >= 0 ? 'danger' : null"
                  @click="selectRecepcion(documento)"
                >
                  <td class="registro">
                    <strong>Reg.</strong>{{ ('00000000' + documento.iddocumento).slice(-8) }}<br />
                    <strong>Exp.</strong>{{ ('00000000' + documento.docu_idexma).slice(-8) }}
                  </td>
                  <td class="registro"><strong>Fecha:</strong>{{ documento.created_at }}</td>
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
                    <strong :class="$mq">Dependencia:</strong>
                    <div :class="$mq">{{ documento.depe_nombre_origen }}</div>
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
                  :disabled="!(docIndexes.length == 1 && derivaciones[0].oper_depeid_d != null)"
                  class="btn btn-sm btn-success"
                  @click="recepcionDocumento()"
                >
                  <span class=""></span>Autorizar
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

  props: ['route-autorizar-papeleta', 'route-recepcionar', 'route-recursos-humanos', 'limit', 'tipo-doc-papeleta'],
  
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
      docRecibir: [],
      docIndexes: [],
      mostrarDocumentos: true,
      tipoDoc: this.tipoDocPapeleta,
      derivaciones: [
        { oper_acciones: null, oper_depeid_d: null, oper_detalledestino: null, oper_forma: false, oper_usuid_d: null }
      ]
    }
  },

  mounted() {
    this.obtenerRecursosHuamnos()
    this.buscarDocumentos()
    var date = new Date() // Or the date you'd like converted.
    var isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
    this.formData.docu_fecha_desde = isoDate.slice(0, 10)
    this.formData.docu_fecha_hasta = isoDate.slice(0, 10)
  },

  methods: {
    buscarDocumentos(page = 1) {
      this.formData.page = page
      axios.get(this.routeAutorizarPapeleta, { params: this.formData }).then(response => {
        this.docPorRecibir = response.data
        this.docRecibir = []
      })
    },

    selectRecepcion(documento) {
      if (
        this.docRecibir.indexOf(documento.idoperacion) == -1 &&
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
      if (confirm('Esta seguro de autorizar la papeleta?')) {
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
      }
    },

    obtenerRecursosHuamnos() {
      axios.get(this.routeRecursosHumanos).then(response => {
        console.log(response.data.recursos.iddependencia)
        if (response.data.status) {
          this.derivaciones[0].oper_depeid_d = response.data.recursos.iddependencia
        } else {
          alert('No cuenta con una oficina de Recursos Humanos que le recepcione')
        }
        this.buscarDocumentos()
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
