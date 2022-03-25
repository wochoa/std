<template>
  <!--PANEL Registro-->
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Búsqueda Datos</div>
      <div class="panel-body">
        <!--CUERPO-->
        <div class="col-md-12">
          <form action="" @submit.prevent="buscarEntidad()">
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-2">
                <label for="">Codigo</label>
                <input v-model="formData.iddependencia" type="text" class="form-control" placeholder="Buscar" />
              </div>
              <div class="col-sm-4">
                <label for="">Nombre</label>
                <input
                  v-model="formData.depe_nombre"
                  type="text"
                  class="form-control"
                  @change="formData.depe_nombre = formData.depe_nombre.toUpperCase()"
                />
              </div>
              <div class="col-sm-4">
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
        </div>
        <!--tabla-->
        <div class="box">
          <div class="box-body">
            <pagination :data="dependencias" :limit="limit" @pagination-change-page="buscarEntidad" />
            <table class="table table-bordered table-condensed table-hover">
              <thead>
                <tr class="info">
                  <th style="font-size:13px; font-family: Tahoma" nowrap>CÓDIGO</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>NOMBRE</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>ABREVIADO</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>SIGLAS</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>REPRESENTANTE</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>Editar</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(dependencia, index) in dependencias.data" :key="index">
                  <td style="font-size:13px; font-family: Tahoma">{{ dependencia.iddependencia }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ dependencia.depe_nombre }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ dependencia.depe_abreviado }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ dependencia.depe_sigla }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ dependencia.depe_representante }}</td>
                  <td>
                    <!--EDITAR-->
                    <router-link :to="{ name: 'AdminEntidadExternaEdit', params: { id: dependencia.iddependencia } }">
                      <a class="btn btn-info glyphicon glyphicon-pencil"></a>
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="dependencias" :limit="limit" @pagination-change-page="buscarEntidad" />
          </div>
        </div>
        <!--fintabla-->
        <!--FINCUERPO-->
      </div>
    </div>
  </div>
  <!--FINPANEL Registro-->
</template>
<script>
export default {  
  props:{
          routeEntidades:{
              type: String,
              default: ''
          }, 
          routeGetEntidad:{
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
        iddependencia: null,
        depe_nombre: null,
        depe_representante: null,
        page: null
      },
      mostrarDependencia: false,
      dependencias: {}
    }
  },
  
  created: function() {
    this.buscarEntidad()
  },

  methods: {
    buscarEntidad(page = 1) {
      this.formData.page = page
      axios.get(this.routeEntidades, { params: this.formData }).then(response => {
        this.dependencias = response.data
        this.mostrarDependencia = true
        //this.formData={}
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
