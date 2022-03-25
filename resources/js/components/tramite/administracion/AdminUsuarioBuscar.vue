<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">USUARIOS</div>
      <div class="panel-body">
        <form action="" @submit.prevent="buscarUsuario()">
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-2">
              <label for="FormGroup">Código de Usuario:</label>
              <input v-model="formData.id" type="text" class="form-control" placeholder="Buscar" />
            </div>
            <div class="col-sm-2">
              <label for="FormGroup">DNI:</label>
              <input v-model="formData.adm_dni" type="text" class="form-control" placeholder="Buscar" />
            </div>
            <div class="col-sm-2">
              <label for="FormGroup">Usuario:</label>
              <input
                v-model="formData.adm_email"
                type="text"
                class="form-control"
                @change="formData.adm_email = formData.adm_email.toUpperCase()"
              />
            </div>
            <div class="col-sm-3">
              <label for="FormGroup">Nombre:</label>
              <input
                v-model="formData.adm_name"
                type="text"
                class="form-control"
                placeholder="Buscar"
                @change="formData.adm_name = formData.adm_name.toUpperCase()"
              />
            </div>
            <div class="col-sm-3">
              <label for="FormGroup">Apellido:</label>
              <input
                v-model="formData.adm_lastname"
                type="text"
                class="form-control"
                placeholder="Buscar"
                @change="formData.adm_lastname = formData.adm_lastname.toUpperCase()"
              />
            </div>
          </div>
          <div class="panel-group">
            <div class="panel panel-primary">
              <div class="panel-heading">DATOS DE USUARIO</div>
              <div class="panel-body">
                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                  <div class="col-sm-2">
                    <label>Tipo de Usuario:</label>
                    <select v-model="formData.adm_tipo" class="form-control">
                      <option :value="null">Seleccione Opcion</option>
                      <option v-for="(rol, indexRol) in getRoles" :key="indexRol" :value="rol.id">{{ rol.name }}</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label>Estado:</label>
                    <select v-model="formData.adm_estado" class="form-control">
                      <option>Seleccione Opcion</option>
                      <option value="1">Activo</option>
                      <option value="2">Inactivo</option>
                    </select>
                  </div>
                  <div class="col-sm-1">
                    <label>Unidad Org:</label>
                    <input v-model="formData.depe_nombre" class="form-control" @change="buscarUsuario()" />
                  </div>
                  <div class="col-sm-6">
                    <br />
                    <select v-model="formData.depe_nombre" class="form-control" @change="buscarUsuario()">
                      <option :value="null">Seleccione opción</option>
                      <option
                        v-for="(uni, indexUni) in getUnidadesDependenciaForCorrelativo(tipoUsuarios)"
                        :key="indexUni"
                        :value="uni.iddependencia"
                      >{{ uni.depe_nombre }}</option>
                    </select>
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
        </form>
        <!--tabla-->
        <div v-if="mostrarUser" class="box">
          <!-- /.tabla -->
          <div class="box-body">
            <pagination :data="users" :limit="limit" @pagination-change-page="buscarUsuario" />
            <table class="table table-bordered table-condensed table-hover">
              <thead>
                <tr class="info">
                  <th style="font-size:13px; font-family: Tahoma" nowrap>ID</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>NOMBRE</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>APELLIDOS</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>CARGO</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>NICK</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>EMAIL</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>DNI</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>UNIDAD</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>DEPENDENCIA</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>ESTADO</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>FECHA REGISTRO</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>EDITAR</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users.data" :key="index">
                  <td style="font-size:13px; font-family: Tahoma">{{ user.id }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ user.adm_name }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ user.adm_lastname }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ user.adm_cargo }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ user.adm_email }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ user.adm_correo }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ user.adm_dni }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ user.oficina }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ user.dependencia }}</td>
                  <td style="font-size:13px; font-family: Tahoma">
                    {{ user.adm_estado == 1 ? 'Activo' : 'Inactivo' }}
                  </td>
                  <td style="font-size:13px; font-family: Tahoma">{{ user.created_at }}</td>
                  <td>
                    <!--EDITAR-->
                    <router-link :to="{ name: tipo == 1 ? 'AdminUsuarioEdit' : 'AdminUsuarioEdit2', params: { id: user.id } }">
                      <a class="btn btn-sm btn-info" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>
                    </router-link>
                    <a
                      class="btn btn-sm btn-success"
                      title="Restablecer contraseña"
                      @click="restablecerContrasenia(user.id)"
                    ><span class="glyphicon glyphicon-flash"></span></a>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="users" :limit="limit" @pagination-change-page="buscarUsuario" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'
export default {

  props: {
          routeUsuario:{
              type: String,
              default: ''
            },
          routeUser:{
              type: String,
              default: ''
            },
          tipo:{
              type: Number,
              default: 1
            },
          tipoUsuarios:{
              type: Number,
              default: 2
            },
          limit:{
              type: Number,
              default: 3
            }
        },

  data() {
    return {
      formData: {
        id: null,
        adm_dni: null,
        adm_email: null,
        adm_name: null,
        adm_lastname: null,
        adm_tipo: null,
        adm_estado: null,
        depe_nombre: null,
        tipo: this.tipo,
        page: null
      },
      mostrarUser: false,
      adm_password: 123456,
      reset: 1,
      users: {}
    }
  },

  computed: {
    ...Vuex.mapGetters(['getUnidadesDependenciaForCorrelativo', 'getRoles'])
  },

  created: function() {
    this.buscarUsuario()
  },

  mounted: function() {
    this.obtenerRoles()
  },

  methods: {
    ...Vuex.mapActions(['obtenerRoles']),

    buscarUsuario(page = 1) {
      this.formData.page = page
      axios.get(this.routeUsuario, { params: this.formData }).then(response => {
        this.users = response.data
        this.mostrarUser = true
      })
    },

    restablecerContrasenia(id) {
      if (confirm('Esta seguro de resetear la contraseña?')) {
        const params = {
          adm_password: this.adm_password,
          reset: this.reset,
          id: id,
          tipo: 2
        }
        axios.post(this.routeUser, params).then(response => {
          console.log('Contraseña restablecida')
        })
      }
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
