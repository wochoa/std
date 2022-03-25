<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">TIPOS DE DOCUMENTOS</div>
      <div class="panel-body">
        <div class="col-md-12">
          <form action="" @submit.prevent="buscarTipoDocumento()">
            <div class="form-group">
              <div class="input-group">
                <input
                  v-model="formData.tdoc_descripcion"
                  type="text"
                  class="form-control"
                  @change="formData.tdoc_descripcion = formData.tdoc_descripcion.toUpperCase()"
                />
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-search"></span> Buscar
                  </button>
                </span>
              </div>
            </div>
          </form>
          <div class="box">
            <div class="box-body">
              <table class="table table-bordered table-condensed table-hover">
                <thead>
                  <tr class="info">
                    <th style="font-size:13px; font-family: Tahoma" nowrap>ID</th>
                    <th style="font-size:13px; font-family: Tahoma" nowrap>DESCRIPCION</th>
                    <th style="font-size:13px; font-family: Tahoma" nowrap>ABREVIATURA</th>
                    <th style="font-size:13px; font-family: Tahoma" nowrap>USADO MPV</th>
                    <th style="font-size:13px; font-family: Tahoma" nowrap>EDITAR</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(tipo, index) in tipoDocumentos.data" :key="index">
                    <td style="font-size:13px; font-family: Tahoma">{{ tipo.idtdoc }}</td>
                    <td style="font-size:13px; font-family: Tahoma">{{ tipo.tdoc_descripcion }}</td>
                    <td style="font-size:13px; font-family: Tahoma">{{ tipo.tdoc_abreviado }}</td>
                    <td style="font-size:13px; font-family: Tahoma">{{ tipo.tdoc_mpv?'SI':'NO' }}</td>
                    <td>
                      <!--EDITAR-->
                      <router-link :to="{ name: 'CataTipoDocumentoEdit', params: { id: tipo.idtdoc } }">
                        <a class="btn btn-info glyphicon glyphicon-pencil"></a>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
              </table>
              <pagination
                :data="tipoDocumentos"
                :limit="limit"
                @pagination-change-page="buscarTipoDocumento"
              />
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
          routeTipo:{
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
        tdoc_descripcion: null,
        page: null
      },
      mostrarTipo: false,
      tipoDocumentos: {}
    }
  },

  created: function() {
    this.buscarTipoDocumento()
  },

  methods: {
    buscarTipoDocumento(page = 1) {
      this.formData.page = page
      axios.get(this.routeTipo, { params: this.formData }).then(response => {
        this.tipoDocumentos = response.data
        this.mostrarTipo = true
      })
    }
  }
}
</script>
<style scoped>
input,
textarea {
  text-transform: uppercase;
}
</style>
