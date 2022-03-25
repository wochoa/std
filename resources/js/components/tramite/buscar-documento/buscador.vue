<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form action="" @submit.prevent="buscarDoc()">
          <!--PANEL Origen-->
          <div class="panel-group">
            <div class="panel panel-primary">
              <div class="panel-heading">ORIGEN</div>
              <div class="panel-body">
                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                  <div class="col-sm-2">
                    <label>Fecha Desde</label>
                    <input v-model="formData.docu_fecha_desde" type="date" class="form-control" />
                  </div>
                  <div class="col-sm-2">
                    <label>Fecha Hasta</label>
                    <input v-model="formData.docu_fecha_hasta" type="date" class="form-control" />
                  </div>
                  <div class="col-sm-3">
                    <label>Orígen:</label><br />
                    <input v-model="formData.docu_origen" type="radio" :value="null" class="radio-inline" />Todos
                    <input v-model="formData.docu_origen" type="radio" :value="1" class="radio-inline" />Interno
                    <input v-model="formData.docu_origen" type="radio" :value="2" class="radio-inline" />Externo
                  </div>
                  <div class="col-sm-5">
                    <label>Dependencias:</label>
                    <select v-model="formData.depe_depende" class="form-control" @change="resetDependencia">
                      <option :value="null">Seleccione</option>
                      <option
                        v-for="(dependencia, indexDepe) in getSedes"
                        :key="indexDepe"
                        :value="dependencia.iddependencia"
                      >{{ dependencia.depe_nombre }}</option>
                    </select>
                  </div>
                </div>
                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                  <div class="col-sm-1">
                    <br />
                    <input
                      v-model="formData.docu_iddependencia"
                      type="text"
                      class="form-control"
                      @change="obtenerUser()"
                    />
                  </div>
                  <div class="col-sm-5">
                    <label>Unidad Org:</label>
                    <select v-model="formData.docu_iddependencia" class="form-control" @change="obtenerUser()">
                      <option :value="null">Seleccione</option>
                      <option
                        v-for="(unidad, indexUnidad) in getUnidadesSede(formData.depe_depende)"
                        :key="indexUnidad"
                        :value="unidad.iddependencia"
                      >{{ unidad.depe_nombre }}</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <label>Usuario:</label>
                    <select v-model="formData.docu_idusuario" class="form-control">
                      <option :value="null">Seleccione usuario</option>
                      <option v-for="(user, indexUser) in users" :key="indexUser" :value="user.id">{{ user.adm_name }}</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <label>Firma</label>
                    <input
                      v-model="formData.docu_firma"
                      type="text"
                      class="form-control"
                      @change="formData.docu_firma = formData.docu_firma.toUpperCase()"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--FINPANEL Origen-->
          <!--PANEL Datos-->
          <div class="panel-group">
            <div class="panel panel-primary">
              <div class="panel-heading">DATOS</div>
              <div class="panel-body">
                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                  <div class="col-sm-3">
                    <label>Tipos de Documentos:</label>
                    <select v-model="formData.idtdoc" class="form-control">
                      <option :value="null">Seleccione opción</option>
                      <option v-for="(tipo, indexTipo) in getTiposDocumento" :key="indexTipo" :value="tipo.idtdoc">{{
                        tipo.tdoc_descripcion
                      }}</option>
                    </select>
                  </div>
                  <div :class="{ 'col-sm-2': true, 'has-error': errors.has('numero') }">
                    <label>Número</label>
                    <input
                      ref="numero"
                      v-model="formData.docu_numero_doc"
                      v-validate="'numeric'"
                      type="text"
                      name="numero"
                      class="form-control"
                    />
                    <span v-show="errors.has('numero')" class="help-block">{{ errors.first('numero') }}</span>
                  </div>
                  <div class="col-sm-2">
                    <label>Siglas</label>
                    <input
                      v-model="formData.docu_siglas_doc"
                      type="text"
                      class="form-control"
                      @change="formData.docu_siglas_doc = formData.docu_siglas_doc.toUpperCase()"
                    />
                  </div>
                  <div class="col-sm-4">
                    <label>Asunto:</label>
                    <textarea
                      v-model="formData.docu_asunto"
                      name="docu_detalle"
                      cols="30"
                      rows="2"
                      class="form-control"
                      @change="formData.docu_asunto = formData.docu_asunto.toUpperCase()"
                    ></textarea>
                  </div>
                  <div class="col-sm-1">
                    <br />
                    <button type="submit" class="btn btn-primary">
                      <span class="glyphicon glyphicon-search"></span>Buscar
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--FINPANEL Datos-->
        </form>
        <!--TABLA-->
        <div class="panel-group">
          <div class="panel panel-primary">
            <div class="panel-heading">BUSCAR DOCUMENTOS</div>
            <div class="panel-body">
              <div class="box" style="overflow-x:scroll;">
                <div class="box-body">
                  <pagination :data="documentos" :limit="limit" @pagination-change-page="buscarDoc" />
                  <table class="table table-bordered table-condensed table-hover">
                    <thead>
                      <tr class="info">
                        <th style="width:7%">REGISTRO<br />EXPEDIENTE</th>
                        <th style="width:20%">DOCUMENTO</th>
                        <th style="width:20%">FIRMA</th>
                        <th style="width:20%">ASUNTO</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(documento, index) in documentos.data" :key="index">
                        <td>
                          <strong>Reg.</strong>{{ ' ' + ('000000' + documento.iddocumento).slice(-8) }}<br />
                          <strong>Exp.</strong>{{ ' ' + ('000000' + documento.docu_idexma).slice(-8) }}
                        </td>
                        <td class="registro">
                          <strong :class="$mq">Fecha:</strong>{{ documento.docu_fecha_doc }}<br />
                          <strong :class="$mq">Doc.</strong>{{ documento.tdoc_descripcion + ' '
                          }}{{ ('000000' + documento.docu_numero_doc).slice(-6)
                          }}{{ '-' + documento.docu_fecha_doc.substr(0, 4) }}{{ '-' + documento.docu_siglas_doc }}
                        </td>
                        <td class="documento">
                          <strong :class="$mq">Dependencia:</strong>
                          <div :class="$mq">{{ documento.dependencia }}</div>
                          <strong :class="$mq">Firma:</strong>
                          <div :class="$mq">{{ documento.docu_firma }}</div>
                          <strong :class="$mq">Cargo:</strong>
                          <div :class="$mq">{{ documento.docu_cargo }}</div>
                        </td>
                        <td class="registro">
                          <strong :class="$mq">Asunto:</strong>{{ documento.docu_asunto }}<br />
                          <strong :class="$mq">Detalle:</strong>{{ documento.docu_detalle }}<br />
                          <strong :class="$mq">User:</strong>{{ documento.usuario }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <pagination :data="documentos" :limit="limit" @pagination-change-page="buscarDoc" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--FIN TABLA -->
      </div>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'
export default {

  props:{
          routeBuscarDoc:{
              type: String,
              default: ''
            },
          routeUser:{
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
        docu_fecha_desde: new Date().toISOString().substr(0, 10),
        docu_fecha_hasta: new Date().toISOString().substr(0, 10),
        docu_origen: null,
        depe_depende: null,
        docu_iddependencia: null,
        docu_idusuario: null,
        docu_firma: null,
        idtdoc: null,
        iddocumento: null,
        docu_numero_doc: null,
        docu_siglas_doc: null,
        docu_asunto: null,
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
      users: {}
    }
  },

  computed: {
    ...Vuex.mapGetters([
      'getSedes',
      'getUnidadesSede',
      'getDependenciaUser',
      'getUsuarios',
      'getSedeDeUnidad',
      'getTiposDocumento'
    ])
  },

  mounted() {
    var date = new Date() // Or the date you'd like converted.
    var isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
    this.formData.docu_fecha_desde = isoDate.slice(0, 10)
    this.formData.docu_fecha_hasta = isoDate.slice(0, 10)
    var este = this
    window.setTimeout(function() {
      // code to run after 5 seconds...
      este.formData.depe_depende = este.getDependenciaUser.depe_depende
      este.formData.docu_iddependencia = este.getDependenciaUser.iddependencia
      este.users = este.getUsuarios
    }, 1500)
  },

  methods: {
    resetDependencia() {
      this.formData.docu_iddependencia = null
      this.users = {}
    },

    obtenerUser() {
      if (this.formData.docu_iddependencia) {
        this.formData.depe_depende = this.getSedeDeUnidad(this.formData.docu_iddependencia)
        const params = {
          depe_id: this.formData.docu_iddependencia
        }
        axios.get(this.routeUser, { params: params }).then(response => {
          this.users = response.data
        })
      } else {
        alert('Seleccione una Unidad Orgánica')
      }
    },

    buscarDoc(page = 1) {
      this.$validator.validate().then(result => {
        if (result) {
          this.formData.page = page
          axios.get(this.routeBuscarDoc, { params: this.formData }).then(response => {
            this.documentos = response.data
          })
        } else {
          console.log('incompleto')
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
input,
textarea {
  text-transform: uppercase;
}
</style>
