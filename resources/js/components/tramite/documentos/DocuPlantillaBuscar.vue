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
            <select v-model="formData.idadmin" name="adm_estado" class="form-control" @change="buscarDocumentos()">
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
                  :disabled="!(docIndexes.length === 1)"
                  :to="{
                    name: 'DocuPlantillaEdit',
                    params: { id: docIndexes.length === 1 ? plantillas.data[docIndexes[0]].id : 0 }
                  }"
                  tag="button"
                  class="btn btn-sm btn-outline-primary"
                >
                  <span class="glyphicon glyphicon-pencil"></span> Editar
                </router-link>
              </p>
            </div>
          </div>
        </div>
        <!-- Modal derivar-->

        <div v-if="mostrarDocumentos" class="box">
          <div class="box-body">
            <table class=" table table-bordered table-condensed table-hover ">
              <thead>
                <tr class="info">
                  <th style="width:7%">ID</th>
                  <th style="width:15%">NOMBRE</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td v-if="plantillas.data.length == 0" colspan="21" class="text-center">
                    No hay plantillas, pruebe cambiando los filtros
                  </td>
                </tr>
                <tr
                  v-for="(plantilla, index) in plantillas.data"
                  :key="index"
                  :class="operSelected.indexOf(plantilla.id) >= 0 ? 'danger' : 'null'"
                  @click="selectArchivar(plantilla)"
                >
                  <td><strong>Reg.</strong>{{ ' ' + ('00000000' + plantilla.id).slice(-8) }}<br /></td>
                  <td class="registro">{{ plantilla.plt_nombre }}</td>
                </tr>
              </tbody>
            </table>
            <pagination :data="plantillas" :limit="limit" @pagination-change-page="buscarDocumentos" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Vuex from 'vuex'
export default {

  name: 'DocuPlantillaBuscar',
  
  props:{
          routePlantillaList:{
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
      plantillas: {
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
      operSelected: [],
      docIndexes: [],
      mostrarDocumentos: true,
      derivaciones: []
    }
  },  

  computed: {
    ...Vuex.mapGetters(['getUsuariosActivo'])
  },

  mounted() {
    this.buscarDocumentos()
  },

  methods: {
    buscarDocumentos(page = 1) {
      this.formData.page = page
      axios.get(this.routePlantillaList, { params: this.formData }).then(response => {
        this.plantillas = response.data
        this.operSelected = []
        this.docIndexes = []
      })
    },
    selectArchivar(plantilla) {
      if (
        this.operSelected.indexOf(plantilla.id) === -1 &&
        this.docIndexes.indexOf(this.plantillas.data.indexOf(plantilla)) === -1
      ) {
        this.operSelected.push(plantilla.id)
        this.docIndexes.push(this.plantillas.data.indexOf(plantilla))
      } else {
        this.operSelected.splice(this.operSelected.indexOf(plantilla.id), 1)
        this.docIndexes.splice(this.docIndexes.indexOf(this.plantillas.data.indexOf(plantilla)), 1)
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
.plantilla strong {
  display: inline-block;
  float: left;
}
.plantilla strong.mobile {
  width: 100%;
}
.plantilla strong.tablet {
  width: 100%;
}
.plantilla strong.laptop {
  width: 30%;
}
.plantilla strong.desktop {
  width: 20%;
}
.plantilla div {
  float: left;
}
.plantilla div.mobile {
  width: 100%;
}
.plantilla div.tablet {
  width: 100%;
}
.plantilla div.laptop {
  width: 70%;
}
.plantilla div.desktop {
  width: 80%;
}

.table tbody tr td,
.table thead tr th {
  font-size: 11px;
  font-family: Tahoma;
  vertical-align: middle;
}
</style>
