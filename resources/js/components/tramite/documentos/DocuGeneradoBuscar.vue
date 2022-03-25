<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">DOCUMENTOS EN PROCESO</div>
      <div class="panel-body">
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
          <div class="col-sm-4">
            <label>Registro:</label>
            <input v-model="formData.iddocumento" class="form-control" name="depe_nombre" />
          </div>
          <div class="col-sm-4">
            <label>Documento del Usuario:</label>
            <select v-model="formData.idadmin" name="adm_estado" class="form-control" @change="buscarDocumentos">
              <option :value="null">Todos</option>
              <option v-for="(usuario, indexUser) in getUsuariosActivo" :key="indexUser" :value="usuario.id">
                {{ usuario.adm_name }}
              </option>
            </select>
          </div>
          <div class="col-sm-2">
            <br />
            <button type="submit" class="btn btn-primary" @click="buscarDocumentos()">
              <span class="glyphicon glyphicon-search"></span> Buscar
            </button>
          </div>
        </div>
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
          <div class="col-sm-12">
            <div class="btn-group" role="group" aria-label="Basic example">
              <p>
                <router-link
                  :disabled="!(docSelected != null && docSelected.dgen_datos.documento.iddocumento == null)"
                  :to="{ name: 'DocuGeneradoEdit', params: { id: docSelected != null ? docSelected.id : 0 } }"
                  tag="button"
                  class="btn btn-sm btn-outline-primary"
                >
                  <span class="glyphicon glyphicon-pencil"></span> Editar
                </router-link>
                <button class="btn btn-sm btn-success" :disabled="docSelected == null" @click.prevent="openVisor()">
                  <span class="glyphicon glyphicon-print"></span> Imprimir
                </button>
                <button
                  v-if="
                    docSelected == null ||
                      (docSelected.dgen_datos.documento.docu_tipo &&
                        parseInt(docSelected.dgen_datos.documento.docu_idusuario) === parseInt(userId)) ||
                      !docSelected.dgen_datos.documento.docu_tipo
                  "
                  class="btn btn-sm btn-warning"
                  :disabled="!(docSelected != null && docSelected.dgen_datos.documento.iddocumento == null)"
                  @click.prevent="validar()"
                >
                  <span class="glyphicon glyphicon-ok"></span> Validar / Registrar
                </button>
              </p>
            </div>
          </div>
        </div>
        <!-- Modal derivar-->
        <div v-if="mostrarDocumentos" class="box">
          <div class="box-body">
            <pagination :data="documentos" :limit="limit" @pagination-change-page="buscarDocumentos" />
          </div>
        </div>
        <table class=" table table-bordered table-condensed table-hover ">
          <thead>
            <tr class="info">
              <th style="width:10%">REGISTRO<br />EXPEDIENTE</th>
              <th style="width:50%">DOCUMENTO</th>
              <th style="width:40%">DESTINO</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td v-if="documentos.data.length === 0" colspan="21" class="text-center">
                No hay documentos, pruebe cambiando los filtros
              </td>
            </tr>
            <tr
              v-for="(d, index) in documentos.data"
              :key="index"
              :set="(doc = d.dgen_datos.documento)"
              :class="
                docSelected != null && docSelected.id === d.id
                  ? 'danger'
                  : d.dgen_datos.documento.iddocumento != null
                    ? 'success'
                    : ''
              "
              @click="select(d)"
            >
              <td>{{ doc.iddocumento }}{{ doc.iddocumento == null ? '' : ' / ' }}{{ doc.docu_idexma }}</td>
              <td class="documento">
                <strong :class="$mq">Doc:</strong>
                <div :class="$mq">
                  {{ getTipoDocumentoNombre(doc.docu_idtipodocumento) + ' '
                  }}{{ ('000000' + (doc.docu_numero_doc != null ? doc.docu_numero_doc : '______')).slice(-6)
                  }}{{ doc.docu_origen == 1 ? '-' + doc.docu_fecha_doc.substr(0, 4) : ''
                  }}{{ '-' + doc.docu_siglas_doc }}
                </div>
                <strong :class="$mq">Firma:</strong>
                <div :class="$mq">{{ doc.docu_firma }}</div>
                <strong :class="$mq">Cargo:</strong>
                <div :class="$mq">{{ doc.docu_cargo }}</div>
                <strong :class="$mq">Asunto:</strong>
                <div :class="$mq">{{ doc.docu_asunto }}</div>
              </td>
              <td>
                <div v-for="(der, index2) in d.dgen_derivaciones" :key="index2">
                  <div><strong :class="$mq">Destino:</strong>{{ getDependenciaNombre(der.oper_depeid_d) }}<br /></div>
                  <div v-if="der.oper_usuid_d != null">
                    <strong :class="$mq">Para:</strong>{{ getUsuariosActivoNombre(der.oper_usuid_d) }}<br />
                  </div>
                  <div><strong :class="$mq">Acciones:</strong>{{ der.oper_acciones }}</div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="mostrarDocumentos" class="box">
          <div class="box-body">
            <pagination :data="documentos" :limit="limit" @pagination-change-page="buscarDocumentos" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Vuex from 'vuex'
export default {

  name: 'DocuGeneradoBuscar',
  
  props:{
          routePrint:{
              type: String,
              default: ''
            },
          routeDocGeneradoList:{
              type: String,
              default: ''
            }, 
          routeGuardarDocGenerado:{
              type: String,
              default: ''
            }, 
          userId:{
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
        iddocumento: null,
        idadmin: this.userId,
        adjuntos: null,
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
        iddocumento: null
      },
      docSelected: null,
      mostrarDocumentos: true,
      derivaciones: []
    }
  },  

  computed: {
    ...Vuex.mapGetters([
      'getDependenciaNombre',
      'getUsuariosActivoNombre',
      'getUsuariosActivo',
      'getTipoDocumentoNombre'
    ])
  },

  mounted() {
    this.buscarDocumentos()
  },

  methods: {
    buscarDocumentos(page = 1) {
      this.formData.page = page
      axios.get(this.routeDocGeneradoList, { params: this.formData }).then(response => {
        this.documentos = response.data
        for (var i = 0; i < this.documentos.data.length; i++) {
          this.documentos.data[i].dgen_datos = JSON.parse(this.documentos.data[i].dgen_datos)
        }
        this.docSelected = null
      })
    },
    select(d) {
      if (this.docSelected == null || this.docSelected.id !== d.id) this.docSelected = d
      else this.docSelected = null
    },
    openVisor() {
      if (this.docSelected != null) {
        var route = this.routePrint
        route = route.replace(/%s/g, this.docSelected.id)
        window.open(route, 'Visor', 'width=1000,height=750')
        //window.open(route,'_blank')
      }
    },
    validar() {
      if (confirm('Esta seguro de validar?')) {
        var parameters = Object.assign({}, this.docSelected)
        parameters.dgen_datos = {}
        parameters.validar = true
        axios.post(this.routeGuardarDocGenerado, parameters).then(response => {
          this.documento = response.data
          this.buscarDocumentos()
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
