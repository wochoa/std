<template>
  <div>
    <nav class="navbar navbar-gorehco navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a href="" class="navbar-brand">{{ titulo }}</a>
        </div>
      </div>
    </nav>
    <div class="container">
      <div>
        <div class="panel-group">
          <div class="panel panel-success">
            <form class="form-horizontal" @submit.prevent="recaptcha()">
              <div class="panel panel-success">
                <div class="panel-heading">VERIFICACIÓN DE DOCUMENTOS EXTERNOS</div>
                <div class="panel-body text-center">
                  <div class="form-group">
                    <div class="col-sm-12">
                      <label v-if="!formData.busquedaEspecifico">
                        <input type="checkbox" class="checkbox-inline" @change="busquedaMasEspecifico()" />Busqueda más
                        especifico</label>
                      <label v-else>
                        <input type="checkbox" class="checkbox-inline" @change="busquedaNormal()" />Busqueda
                        Normal</label>
                    </div>
                    <div class="col-sm-6">
                      <label class="col-md-4 control-label">Fecha Desde:</label>
                      <div class="col-md-8">
                        <input v-model="formData.docu_fecha_desde" type="date" class="form-control" />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label class="col-md-4 control-label">Fecha Hasta:</label>
                      <div class="col-md-8">
                        <input v-model="formData.docu_fecha_hasta" type="date" class=" form-control" />
                      </div>
                    </div>
                  </div>
                  <div v-if="formData.busquedaEspecifico">
                    <div class="form-group">
                      <label class="col-md-2 control-label">DNI</label>
                      <div :class="{ 'col-sm-4': true, 'has-error': errors.has('dni') }">
                        <input
                          ref="dni"
                          v-model="formData.docu_dni"
                          v-validate="'numeric|digits:8'"
                          type="text"
                          name="dni"
                          class="form-control"
                        />
                        <span v-show="errors.has('dni')" class="help-block">{{ errors.first('dni') }}</span>
                      </div>
                      <label class="col-md-2 control-label">Firma</label>
                      <div class="col-sm-4">
                        <input
                          v-model="formData.docu_firma"
                          type="text"
                          class="form-control"
                          @change="formData.docu_firma = formData.docu_firma.toUpperCase()"
                        />
                      </div>
                      <label class="col-md-2 control-label">Detalle</label>
                      <div class="col-sm-4">
                        <input
                          v-model="formData.docu_detalle"
                          type="text"
                          class="form-control"
                          @change="formData.docu_detalle = formData.docu_detalle.toUpperCase()"
                        />
                      </div>
                      <label class="col-md-2 control-label">Siglas Doc.</label>
                      <div class="col-sm-4">
                        <input
                          v-model="formData.docu_siglas_doc"
                          type="text"
                          class="form-control"
                          @change="formData.docu_siglas_doc = formData.docu_siglas_doc.toUpperCase()"
                        />
                      </div>
                      <label class="col-md-2 control-label">Número de Doc.</label>
                      <div class="col-sm-4">
                        <input v-model="formData.docu_numero_doc" type="number" class="form-control" />
                      </div>
                    </div>
                    <div>
                      <label class="col-md-2 control-label">Entidad</label>
                      <div class="col-sm-2">
                        <input v-model="formData.docu_iddependencia" type="text" class="form-control" />
                      </div>
                      <div class="col-sm-8">
                        <select v-model="formData.docu_iddependencia" class="form-control">
                          <option :value="null">Seleccione</option>
                          <option v-for="(unidad, indexUnidad) in getEntidadesExternas" :key="indexUnidad" :value="unidad.iddependencia">{{
                            unidad.depe_nombre
                          }}</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div
                    v-if="!formData.busquedaEspecifico"
                    :class="{ 'form-group': true, 'has-error': errors.has('asunto') }"
                  >
                    <label class="col-md-2 control-label">DIGITE AQUI</label>
                    <div class="col-md-10">
                      <input
                        ref="asunto"
                        v-model="formData.docu_asunto"
                        v-validate="'required'"
                        type="text"
                        class="form-control"
                        name="asunto"
                        @change="formData.docu_asunto = formData.docu_asunto.toUpperCase()"
                      />
                      <span v-show="errors.has('asunto')" class="help-block">{{ errors.first('asunto') }}</span>
                    </div>
                  </div>
                  <div v-else>
                    <label class="col-md-2 control-label">Asunto</label>
                    <div class="col-md-10">
                      <input
                        ref="asunto"
                        v-model="formData.docu_asunto"
                        type="text"
                        class="form-control"
                        name="asunto"
                        @change="formData.docu_asunto = formData.docu_asunto.toUpperCase()"
                      />
                    </div>
                  </div>
                  <div v-if="!formData.busquedaEspecifico">
                    <label class="col-md-4 control-label">Campos de busqueda</label>
                    <label>
                      <input
                        v-model="formData.selectOption.docu_dni"
                        type="checkbox"
                        class="checkbox-inline"
                      />DNI</label>
                    <label>
                      <input
                        v-model="formData.selectOption.docu_asunto"
                        type="checkbox"
                        class="checkbox-inline"
                      />Asunto</label>
                    <label>
                      <input
                        v-model="formData.selectOption.docu_firma"
                        type="checkbox"
                        class="checkbox-inline"
                      />Firma</label>
                    <label>
                      <input
                        v-model="formData.selectOption.docu_detalle"
                        type="checkbox"
                        class="checkbox-inline"
                      />Detalle</label>
                    <label>
                      <input
                        v-model="formData.selectOption.docu_numero_doc"
                        type="checkbox"
                        class="checkbox-inline"
                      />Número del Doc.</label>
                    <label>
                      <input
                        v-model="formData.selectOption.docu_siglas_doc"
                        type="checkbox"
                        class="checkbox-inline"
                      />Siglas del Doc.</label>
                  </div>
                </div>
              </div>
              <div class="panel panel-success">
                <div class="panel-body text-right">
                  <button class="btn btn-success">Buscar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div v-if="status" class="container">
      <div class="panel-group">
        <div class="panel panel-success">
          <div class="panel-heading">Documentos relacionados</div>
          <div class="panel-body">
            <div class="box">
              <div class="box-body">
                <pagination :data="documentos" :limit="limit" @pagination-change-page="buscarDocumento" />
                <table class="table table-bordered table-hover table-condensed">
                  <thead>
                    <tr class="info">
                      <th style="width:7%">REGISTRO<br />EXPEDIENTE</th>
                      <th style="width:10%">REGISTRO</th>
                      <th style="width:25%">DOCUMENTO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(documento, index) in documentos.data" :key="index">
                      <td class="registro">
                        <strong>Reg.</strong><a href="#" target="_blank" @click.prevent="recargar(documento.iddocumento)">
                          {{ ('00000000' + documento.iddocumento).slice(-8) }}</a><br />
                        <strong>Exp.</strong>{{ ('00000000' + documento.docu_idexma).slice(-8) }}
                      </td>
                      <td class="registro">
                        <strong>Fecha:</strong>{{ documento.docu_fecha_doc }}<br />
                        <strong>Folios:</strong>{{ documento.docu_folios }}<br />
                        <strong>Detalle:</strong>{{ documento.docu_detalle }}<br />
                        <strong>DNI:</strong>{{ documento.docu_dni }}
                      </td>
                      <td class="documento">
                        <strong :class="$mq">Doc:</strong>
                        <div v-if="documento.tdoc_descripcion != null" :class="$mq">
                          {{ documento.tdoc_descripcion + ' ' }}{{ ('000000' + documento.docu_numero_doc).slice(-6)
                          }}{{ documento.docu_siglas_doc }}
                        </div>
                        <div v-else :class="$mq">&nbsp;</div>
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
                <pagination :data="documentos" :limit="limit" @pagination-change-page="recaptcha" />
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

  props:{
          routeBuscarDocexterno:{
              type: String,
              default: ''
            }, 
          routeDocumento:{
              type: String,
              default: ''
            }, 
          routeDependencias:{
              type: String,
              default: ''
            }, 
          titulo:{
              type: String,
              default: ''
            }, 
          limit:{
              type: Number,
              default: 3
            }
        },

  data() {
    return {
      formData: {
        docu_fecha_desde: null,
        docu_fecha_hasta: null,
        docu_asunto: null,
        docu_dni: null,
        docu_firma: null,
        docu_detalle: null,
        docu_numero_doc: null,
        docu_siglas_doc: null,
        docu_iddependencia: null,
        busquedaEspecifico: false,
        token: null,
        selectOption: {
          docu_dni: true,
          docu_asunto: true,
          docu_firma: true,
          docu_detalle: true,
          docu_numero_doc: true,
          docu_siglas_doc: true
        },
        page: null
      },
      status: false,
      documentos: {}
    }
  },

  computed: {
    ...Vuex.mapGetters(['getEntidadesExternas'])
  },

  mounted() {
    var date = new Date() // Or the date you'd like converted.
    var isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
    this.formData.docu_fecha_desde = isoDate.slice(0, 10)
    this.formData.docu_fecha_hasta = isoDate.slice(0, 10)
    this.obtenerDependencias(this.routeDependencias)
  },

  methods: {
    ...Vuex.mapActions(['obtenerDependencias']),

    buscarDocumento(page = 1) {
      this.formData.page = page
      axios.get(this.routeBuscarDocexterno, { params: this.formData }).then(response => {
        if (response.data.data.length > 0) {
          this.status = true
          this.documentos = response.data
        } else {
          alert('No se encontro ningun documento relacionado con lo digitado')
        }
      })
    },

    recaptcha(page = 1) {
      this.$validator.validate().then(result => {
        if (result) {
          this.$recaptcha('login').then(token => {
            this.formData.token = token
            this.buscarDocumento(page)
          })
        } else {
          console.log('incompleto')
        }
      })
    },

    busquedaMasEspecifico() {
      this.formData.busquedaEspecifico = true
    },

    busquedaNormal() {
      this.formData.busquedaEspecifico = false
      /*this.formData.docu_dni              = null;
            this.formData.docu_firma            = null;
            this.formData.docu_detalle          = null;
            this.formData.docu_numero_doc       = null;
            this.formData.docu_siglas_doc       = null;
            this.formData.docu_iddependencia    = null;*/
    },

    nuevaBusqueda() {
      //this.status                         = false;
      this.formData.busquedaEspecifico = false
      /*this.formData.docu_dni              = null;
            this.formData.docu_firma            = null;
            this.formData.docu_detalle          = null;
            this.formData.docu_numero_doc       = null;
            this.formData.docu_siglas_doc       = null;
            this.formData.docu_iddependencia    = null;
            this.formData.docu_asunto           = null;
            this.formData.token                 = null;
            this.formData.page                  = null;*/
    },

    recargar(iddocumento) {
      window.open(this.routeDocumento.replace(/%s/g, iddocumento), 'visorExp', 'width=1000, height=750')
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
  font-size: 12px;
  font-family: Tahoma;
  vertical-align: middle;
}
input,
textarea {
  text-transform: uppercase;
}
</style>
