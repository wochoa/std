<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">UNIDAD ORGÁNICA</div>
      <div class="panel-body">
        <div class="col-md-12">
          <form @submit.prevent="buscarUnidad()">
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-4">
                <label for="">Código de Unidad Orgánica</label>
                <input v-model="formData.iddependencia" type="text" class="form-control" />
              </div>
              <div v-if="tipo == 1" class="col-sm-8">
                <label for="">Dependencia</label>
                <select
                  v-model="formData.depe_depende"
                  :disabled="!(tipo == 1)"
                  class="form-control"
                  @change="buscarUnidad()"
                >
                  <option :value="null">Seleccione Opción</option>
                  <option v-for="(sede, indexSede) in getSedes" :key="indexSede" :value="sede.iddependencia">{{ sede.depe_nombre }}</option>
                </select>
              </div>
              <div v-else class="col-sm-8">
                <label>Dependencia</label>
                <p>{{ getDependenciaNombre(getDependenciaUser.depe_depende) }}</p>
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-5">
                <label for="">Nombre</label>
                <input
                  v-model="formData.depe_nombre"
                  type="text"
                  class="form-control"
                  @change="formData.depe_nombre = formData.depe_nombre.toUpperCase()"
                />
              </div>
              <div class="col-sm-5">
                <label for="">Representante</label>
                <input
                  v-model="formData.depe_representante"
                  type="text"
                  class="form-control"
                  @change="formData.depe_representante = formData.depe_representante.toUpperCase()"
                />
              </div>
              <div class="col-sm-2">
                <br />
                <button type="submit" class="btn btn-sm btn-primary">
                  <span class="glyphicon glyphicon-search"></span>Buscar
                </button>
              </div>
            </div>
          </form>
          <div v-if="mostrarUnidad" class="box">
            <div class="box-body">
              <pagination :data="dependencias" :limit="limit" @pagination-change-page="buscarUnidad" />
              <table class="table table-bordered table-condensed table-hover">
                <thead>
                  <tr class="info">
                    <th style="font-size:13px; font-family: Tahoma" nowrap>CÓDIGO</th>
                    <th style="font-size:13px; font-family: Tahoma" nowrap>NOMBRE</th>
                    <th style="font-size:13px; font-family: Tahoma" nowrap>ABREVIADO</th>
                    <th style="font-size:13px; font-family: Tahoma" nowrap>SIGLAS</th>
                    <th style="font-size:13px; font-family: Tahoma" nowrap>REPRESENTANTE</th>
                    <th style="font-size:13px; font-family: Tahoma" nowrap>DEPENDENCIA</th>
                    <th style="font-size:13px; font-family: Tahoma" nowrap>EDITAR</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(dependencia, index) in dependencias.data" :key="index">
                    <td style="font-size:13px; font-family: Tahoma">{{ dependencia.iddependencia }}</td>
                    <td style="font-size:13px; font-family: Tahoma">{{ dependencia.depe_nombre }}</td>
                    <td style="font-size:13px; font-family: Tahoma">{{ dependencia.depe_abreviado }}</td>
                    <td style="font-size:13px; font-family: Tahoma">{{ dependencia.depe_siglaxp }}</td>
                    <td style="font-size:13px; font-family: Tahoma">{{ dependencia.depe_representante }}</td>
                    <td style="font-size:13px; font-family: Tahoma">{{ dependencia.nombre }}</td>
                    <td>
                      <!--EDITAR-->
                      <router-link
                        :to="{
                          name: tipo == 1 ? 'AdminUnidadOrganicaEdit' : 'AdminUnidadOrganicaEdit2',
                          params: { id: dependencia.iddependencia }
                        }"
                      >
                        <a class="btn btn-info glyphicon glyphicon-pencil"></a>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
              </table>
              <pagination :data="dependencias" :limit="limit" @pagination-change-page="buscarUnidad" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'
export default {

  props:{
          routeUnidad:{
              type: String,
              default: ''
            },
          routeDependencias:{
              type: String,
              default: ''
            },
          tipo:{
              type: Number,
              default: 1
            },
          limit:{
              type: Number,
              default: 3
            }
        },

  data() {
    return {
      formData: {
        iddependencia: null,
        depe_depende: null,
        depe_nombre: null,
        depe_representante: null,
        tipo: this.tipo,
        page: null
      },
      mostrarUnidad: false,
      dependencias: []
    }
  },

   computed: {
    ...Vuex.mapGetters(['getSedes', 'getDependenciaUser', 'getDependenciaNombre'])
  },

  mounted() {
    if (this.tipo == 2) {
      var este = this
      window.setTimeout(function() {
        // code to run after 5 seconds...
        este.formData.depe_depende = este.getDependenciaUser.depe_depende
        este.buscarUnidad()
      }, 1500)
    }
  },

  methods: {
    buscarUnidad(page = 1) {
      this.formData.page = page
      axios.get(this.routeUnidad, { params: this.formData }).then(response => {
        this.dependencias = response.data
        this.mostrarUnidad = true;
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
