<template>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel-group">
        <div class="panel panel-primary">
          <div class="panel-heading">CORRELATIVOS</div>
          <div class="panel-body">
            <form action="" @submit.prevent="buscarCorrelativo()">
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-3">
                  <label>Periodo</label>
                  <select v-model="formData.tdco_periodo" class="form-control">
                    <option :value="null">Seleccione</option>
                    <option v-for="(periodo, indexPeriodo) in getPeriodosCorrelativo" :key="indexPeriodo" :value="periodo.tdco_periodo">{{
                      periodo.tdco_periodo
                    }}</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  <br />
                  <input
                    v-model="formData.iddependencia"
                    type="text"
                    class="form-control"
                    @change="obtenerUser()"
                  />
                </div>
                <div class="col-sm-7">
                  <label>Unidad Org:</label>
                  <select v-model="formData.iddependencia" class="form-control" @change="obtenerUser()">
                    <option :value="null">Seleccione</option>
                    <option
                      v-for="(unidad, indexUnidad) in getUnidadesDependenciaForCorrelativo(tipoCorrelativos)"
                      :key="indexUnidad"
                      :value="unidad.iddependencia"
                    >{{ unidad.depe_nombre }}</option>
                  </select>
                </div>
              </div>
              <div id="iducuario" class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-5">
                  <label>Usuario</label>
                  <select v-model="formData.idadmin" class="form-control">
                    <option :value="null">Todos</option>
                    <option v-for="(user, indexUser) in users" :key="indexUser" :value="user.id">{{ user.adm_name }}</option>
                  </select>
                </div>
                <div class="col-sm-5">
                  <label>Tipo de Documento</label>
                  <select v-model="formData.idtdoc" class="form-control">
                    <option :value="null">Seleccione</option>
                    <option v-for="(tipo, indexTipo) in getTiposDocumento" :key="indexTipo" :value="tipo.idtdoc">{{ tipo.tdoc_descripcion }}</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  <br />
                  <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-search"></span>Buscar
                  </button>
                </div>
              </div>
            </form>
            <div class="box">
              <div class="box-body">
                <pagination
                  :data="correlativos"
                  :limit="limit"
                  @pagination-change-page="buscarCorrelativo"
                />
                <table class="table table-bordered table-condensed table-hover">
                  <thead>
                    <tr class="info">
                      <th style="font-size:13px; font-family: Tahoma" nowrap>PERIODO</th>
                      <th style="font-size:13px; font-family: Tahoma" nowrap>DEPENDENCIA</th>
                      <th style="font-size:13px; font-family: Tahoma" nowrap>TIPO</th>
                      <th style="font-size:13px; font-family: Tahoma" nowrap>USUARIO</th>
                      <th style="font-size:13px; font-family: Tahoma" nowrap>Siguiente_Número</th>
                      <th style="font-size:13px; font-family: Tahoma" nowrap>Editar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(correlativo, index) in correlativos.data" :key="index">
                      <td style="font-size:13px; font-family: Tahoma">{{ correlativo.tdco_periodo }}</td>
                      <td style="font-size:13px; font-family: Tahoma">{{ correlativo.depe_nombre }}</td>
                      <td style="font-size:13px; font-family: Tahoma">{{ correlativo.tdoc_descripcion }}</td>
                      <td v-if="correlativo.usuario != 0" style="font-size:13px; font-family: Tahoma">
                        {{ correlativo.adm_email }}
                      </td>
                      <td v-else>&nbsp;</td>
                      <td v-if="editMode && editId == correlativo.id" style="font-size:13px; font-family: Tahoma, sans-serif">
                        <input v-model="correlativo.tdco_numero" type="text" class="form-control" />
                      </td>

                      <td v-else style="font-size:13px; font-family: Tahoma">{{ correlativo.tdco_numero }}</td>
                      <td>
                        <a
                          v-if="editMode && editId == correlativo.id"
                          class="btn btn-success"
                          @click="updateCorrelativo(index)"
                        >Guardar</a>
                        <a
                          v-else
                          class="btn btn-info glyphicon glyphicon-pencil"
                          @click="editCorrelativo(correlativo.id)"
                        ></a>
                        <a
                          v-if="editMode && editId == correlativo.id"
                          class="btn btn-danger"
                          @click="cancelCorrelativo(index)"
                        >x</a>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <pagination
                  :data="correlativos"
                  :limit="limit"
                  @pagination-change-page="buscarCorrelativo"
                />
              </div>
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

  props: {routeCorrelativo:{
              type: String,
              default: ''
            },
          routeUser:{
              type: String,
              default: ''
            },
          routeUpdate:{
              type: String,
              default: ''
            },
          tipoCorrelativos:{
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
        tdco_periodo: null,
        iddependencia: null,
        idtdoc: null,
        idadmin: null,
        page: null
      },
      mostrarCorrelativo: false,
      correlativos: {},
      users: [],
      editMode: false,
      editId: null
    }
  },

  computed: {
    ...Vuex.mapGetters(['getUnidadesDependenciaForCorrelativo', 'getTiposDocumento', 'getPeriodosCorrelativo']),

    checkUnidad() {
      let unidades = this.getUnidadesDependenciaForCorrelativo(this.tipoCorrelativos)
      let oneDependencia = unidades.filter( d => d.iddependencia == this.formData.iddependencia)[0]
      if (oneDependencia != undefined) {
        return true
      } else {
        return false
      }
    }
  },

  mounted() {
    this.obtenerPeriodosCorrelativo()
  },


  methods: {
    ...Vuex.mapActions(['obtenerPeriodosCorrelativo']),

    buscarCorrelativo(page = 1) {
      if (this.checkUnidad) {
        this.formData.page = page
        axios.get(this.routeCorrelativo, { params: this.formData }).then(response => {
          this.correlativos = response.data
          this.mostrarCorrelativo = true
        })
      } else {
        alert('Seleccione Una Unidad Organica que pertenezca a la Dependencia')
        this.users = []
      }     
    },

    obtenerUser() {
      if (this.checkUnidad) {
        const parm = {
          depe_id: this.formData.iddependencia
        }
        axios.get(this.routeUser, { params: parm }).then(response => {
          this.users = response.data
        })
      } else {
        alert('Seleccione Una Unidad Organica que pertenezca a la Dependencia')
        this.users = []
      }
    },

    editCorrelativo(index) {
      this.editId = index
      this.editMode = true
    },

    updateCorrelativo(index) {
      const params = {
        tdco_numero: this.correlativos.data[index].tdco_numero
      }

      axios.put(this.routeUpdate.replace(/%s/g, this.editId), params).then(response => {
        //this.correlativos.data[index]=response.data;
        this.editId = null
        this.editMode = false
      })
    },

    cancelCorrelativo(index) {
      this.editId = null
      this.editMode = false
    }
  }
}
</script>
