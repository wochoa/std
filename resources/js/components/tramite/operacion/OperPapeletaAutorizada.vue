<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">PAPELETAS AUTORIZADAS</div>
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
        <div class="box">
          <div class="box-body">
            <table class="table table-bordered table-hover table-condensed">
              <thead>
                <tr class="info">
                  <th style="width:7%">REGISTRO<br />EXPEDIENTE</th>
                  <th style="width:10%">REGISTRO</th>
                  <th style="width:25%">DOCUMENTO</th>
                  <th style="width:15%">MOTIVO</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td v-if="docPorRecibir.data.length == 0" colspan="21" class="text-center">
                    No hay documentos, pruebe cambiando los filtros
                  </td>
                </tr>
                <tr v-for="(documento, index) in docPorRecibir.data" :key="index">
                  <td class="registro">
                    <strong>Reg.</strong>{{ ('00000000' + documento.iddocumento).slice(-8) }}<br />
                    <strong>Exp.</strong>{{ ('00000000' + documento.docu_idexma).slice(-8) }}
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
                    <strong :class="$mq">Dependencia:</strong>
                    <div :class="$mq">{{ documento.depe_nombre_origen }}</div>
                  </td>
                  <td>
                    <strong :class="$mq">Asunto:</strong>{{ documento.docu_asunto }}<br />
                    <strong :class="$mq">Detalle:</strong>{{ documento.docu_detalle }}<br />
                    <strong :class="$mq">Destino:</strong>{{ documento.depe_nombre_destino }}<br />
                    <strong :class="$mq">Autoriza:</strong>{{ documento.name_usuario + ' '
                    }}{{ documento.lastname_usuario }}
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="docPorRecibir" :limit="limit" @pagination-change-page="buscarDocumentos" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {

  props: ['route-papeletas-autorizadas', 'limit'],
  
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
      }
    }
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
      axios.get(this.routePapeletasAutorizadas, { params: this.formData }).then(response => {
        this.docPorRecibir = response.data
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
