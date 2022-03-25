<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">ARCHIVADORES</div>
      <div class="panel-body">
        <!--CUERPO-->
        <form action="" @submit.prevent="buscarArchivador()">
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-2">
              <label>Unidad Org</label>
            </div>
            <div class="col-sm-2">
              <input type="text" :value="getDependenciaUser.iddependencia" class="form-control" readonly />
            </div>
            <div class="col-sm-8">
              <input type="text" :value="getDependenciaUser.depe_nombre" class="form-control" />
            </div>
          </div>
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-6">
              <label>Descripción</label>
              <input
                v-model="formData.arch_nombre"
                type="text"
                class="form-control"
                placeholder="Buscar"
                @change="formData.arch_nombre = formData.arch_nombre.toUpperCase()"
              />
            </div>
            <div class="col-sm-3">
              <label>Periodo</label>
              <select v-model="formData.arch_periodo" class="form-control">
                <option :value="null">Opciones</option>
                <option v-for="(periodo, indexPeriodo) in getPeriodosCorrelativo" :key="indexPeriodo">{{ periodo.tdco_periodo }}</option>
              </select>
            </div>
            <div class="col-sm-3">
              <br />
              <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-search"></span>Buscar
              </button>
            </div>
          </div>
        </form>
        <div class="box">
          <div class="box-body">
            <pagination :data="archivadores" :limit="limit" @pagination-change-page="buscarArchivador" />
            <table class="table table-bordered table-condensed table-hover">
              <thead>
                <tr class="info">
                  <th style="font-size:13px; font-family: Tahoma" nowrap>DESCRIPCION</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>PERIODO</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>ARCHIVADO_DE</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>Editar</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(archivador, index) in archivadores.data" :key="index">
                  <td style="font-size:13px; font-family: Tahoma" nowrap>{{ archivador.arch_nombre }}</td>
                  <td style="font-size:13px; font-family: Tahoma" nowrap>{{ archivador.arch_periodo }}</td>
                  <td style="font-size:13px; font-family: Tahoma" nowrap>{{ archivador.adm_email }}</td>
                  <td style="font-size:13px; font-family: Tahoma" nowrap>
                    <!--EDITAR-->
                    <router-link
                      v-if="getUsuario.id == archivador.id || archivador.arch_idusuarioa == null"
                      :to="{ name: 'CataArchivadorEdit', params: { id: archivador.idarch } }"
                    >
                      <a class="btn btn-info glyphicon glyphicon-pencil"></a>
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="archivadores" :limit="limit" @pagination-change-page="buscarArchivador" />
          </div>
        </div>
        <!--FINCUERPO-->
      </div>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'
export default {

  props:{
          routeArchivador:{
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
        arch_nombre: null,
        arch_periodo: new Date().getFullYear(),
        idarch: null,
        page: null
      },
      mostrarArchivado: false,
      archivadores: {}
    }
  },

  computed: {
    ...Vuex.mapGetters(['getDependenciaUser','getPeriodosCorrelativo','getUsuario'])
  },


  created: function() {
    this.buscarArchivador()
  },
  mounted() {
    this.obtenerDependenciaUser()
    this.obtenerPeriodosCorrelativo()
  },

  methods: {
    ...Vuex.mapActions(['obtenerDependenciaUser', 'obtenerPeriodosCorrelativo']),

    buscarArchivador(page = 1) {
      this.formData.page = page
      axios.get(this.routeArchivador, { params: this.formData }).then(response => {
        this.archivadores = response.data
        this.mostrarArchivado = true
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
