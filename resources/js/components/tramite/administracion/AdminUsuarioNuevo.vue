<template>
  <div class="container">
    <div class="panel-group">
      <form action="" @submit.prevent="guardarUsuario()">
        <div class="panel panel-primary">
          <div class="panel panel-primary">
            <div v-if="$route.params.id == null" class="panel-heading">LLENE LOS DATOS DEL NUEVO USUARIOS</div>
            <div v-else class="panel-heading">EDITE LOS DATOS DEL USUARIO</div>
            <div class="panel-body">
              <!--CUERPO-->
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div :class="{ 'col-sm-3': true, 'has-error': errors.has('nombre') }">
                  <label class="control-label">Nombre</label>
                  <input
                    ref="nombre"
                    v-model="user.adm_name"
                    v-validate="'required'"
                    name="nombre"
                    type="text"
                    class="form-control"
                    @change="user.adm_name = user.adm_name.toUpperCase()"
                  />
                  <span v-show="errors.has('nombre')" class="help-block">{{ errors.first('nombre') }}</span>
                </div>
                <div :class="{ 'col-sm-3': true, 'has-error': errors.has('apellido') }">
                  <label class="control-label">Apellido</label>
                  <input
                    ref="apellido"
                    v-model="user.adm_lastname"
                    v-validate="'required'"
                    name="apellido"
                    type="text"
                    class="form-control"
                    @change="user.adm_lastname = user.adm_lastname.toUpperCase()"
                  />
                  <span v-show="errors.has('apellido')" class="help-block">{{ errors.first('apellido') }}</span>
                </div>
                <div :class="{ 'col-sm-6': true, 'has-error': errors.has('cargo') }">
                  <label class="control-label">Cargo</label>
                  <input
                    ref="cargo"
                    v-model="user.adm_cargo"
                    v-validate="'required'"
                    name="cargo"
                    type="text"
                    class="form-control"
                    @change="user.adm_cargo = user.adm_cargo.toUpperCase()"
                  />
                  <span v-show="errors.has('cargo')" class="help-block">{{ errors.first('cargo') }}</span>
                </div>
              </div>
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div :class="{ 'col-sm-4': true, 'has-error': errors.has('email') }">
                  <label class="control-label">Email</label>
                  <input
                    ref="email"
                    v-model="user.adm_correo"
                    v-validate="'required|email'"
                    type="email"
                    class="form-control"
                    name="email"
                  />
                  <span v-show="errors.has('email')" class="help-block">{{ errors.first('email') }}</span>
                </div>
                <div :class="{ 'col-sm-3': true, 'has-error': errors.has('inicial') }">
                  <label class="control-label">Iniciales</label>
                  <input
                    ref="inicial"
                    v-model="user.adm_inicial"
                    v-validate="'required'"
                    type="text"
                    class="form-control"
                    name="inicial"
                    @change="user.adm_inicial = user.adm_inicial.toUpperCase()"
                  />
                  <span v-show="errors.has('inicial')" class="help-block">{{ errors.first('inicial') }}</span>
                </div>
                <div class="col-sm-5">
                  <label>Especialidad</label>
                  <input
                    v-model="user.adm_con_especialidad"
                    type="text"
                    class="form-control"
                    @change="user.adm_con_especialidad = user.adm_con_especialidad.toUpperCase()"
                  />
                </div>
              </div>
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div :class="{ 'col-sm-4': true, 'has-error': errors.has('dni') }">
                  <label class="control-label">DNI</label>
                  <input
                    ref="dni"
                    v-model="user.adm_dni"
                    v-validate="'numeric|digits:8'"
                    type="text"
                    name="dni"
                    class="form-control"
                    @change="validarDNI()"
                  />
                  <span v-show="errors.has('dni')" class="help-block">{{ errors.first('dni') }}</span>
                </div>
                <div :class="{ 'col-sm-4': true, 'has-error': errors.has('ntelf') }">
                  <label class="control-label">Telefono</label>
                  <input
                    ref="ntelf"
                    v-model="user.adm_telefono"
                    v-validate="'numeric|digits:9'"
                    type="text"
                    name="ntelf"
                    class="form-control"
                  />
                  <span v-show="errors.has('ntelf')" class="help-block">{{ errors.first('ntelf') }}</span>
                </div>
                <div class="col-sm-4">
                  <label>Dirección</label>
                  <input
                    v-model="user.adm_direccion"
                    type="text"
                    class="form-control"
                    @change="user.adm_direccion = user.adm_direccion.toUpperCase()"
                  />
                </div>
              </div>
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div :class="{ 'col-sm-2': true, 'has-error': errors.has('unidad') }">
                  <label class="control-label">Unidad Org</label>
                </div>
                <div :class="{ 'col-sm-2': true, 'has-error': errors.has('unidad') }">
                  <input v-model="user.depe_id" class="form-control" />
                </div>
                <div :class="{ 'col-sm-8': true, 'has-error': errors.has('unidad') }">
                  <select
                    ref="unidad"
                    v-model="user.depe_id"
                    v-validate="'required'"
                    class="form-control"
                    name="unidad"
                  >
                    <option>Seleccione opción</option>
                    <option
                      v-for="(uni, indexUni) in getUnidadesDependenciaForCorrelativo(tipoUsuarios)"
                      :key="indexUni"
                      :value="uni.iddependencia"
                    >{{ uni.depe_nombre }}</option>
                  </select>
                  <span v-show="errors.has('unidad')" class="help-block">{{ errors.first('unidad') }}</span>
                </div>
              </div>
              <!--FINCUERPO-->
            </div>
          </div>
          <div class="panel panel-primary">
            <div class="panel-heading">DATOS DE LA CUENTA</div>
            <div class="panel-body">
              <!--CUERPO-->
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div :class="{ 'col-sm-3': true, 'has-error': errors.has('usuario') }">
                  <label class="control-label">Usuario</label>
                  <input
                    ref="usuario"
                    v-model="user.adm_email"
                    v-validate="'required|unique'"
                    type="text"
                    class="form-control"
                    name="usuario"
                    @change="user.adm_email = user.adm_email.toUpperCase()"
                  />
                  <span v-show="errors.has('usuario')" class="help-block">{{ errors.first('usuario') }}</span>
                </div>
                <div :class="{ 'col-sm-3': true, 'has-error': errors.has('password') }">
                  <label class="control-label">Password</label>
                  <input
                    ref="password"
                    v-model="user.adm_password"
                    v-validate="$route.params.id == null ? 'required' : ''"
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Password"
                  />
                  <span v-show="errors.has('password')" class="help-block">{{ errors.first('password') }}</span>
                </div>
                <div :class="{ 'col-sm-3': true, 'has-error': errors.has('password_confirmation') }">
                  <label class="control-label">Repite Password</label>
                  <input
                    v-model="user.confirmPassword"
                    v-validate="$route.params.id == null ? 'required|confirmed:password' : ''"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Password, otra vez"
                    data-vv-as="password"
                  />
                  <span v-show="errors.has('password_confirmation')" class="help-block">{{
                    errors.first('password_confirmation')
                  }}</span>
                </div>
                <div class="col-sm-3">
                  <label>Solicitar cambio contraseña</label>
                  <div>
                    <label>
                      <input
                        v-model="user.adm_primer_logeo"
                        type="radio"
                        :value="null"
                        class="radio-inline"
                        @click="setContrasenia()"
                      />Si</label>
                    <label>
                      <input
                        v-model="user.adm_primer_logeo"
                        type="radio"
                        :value="1"
                        class="radio-inline"
                        @click="setContraseniaNull()"
                      />No</label>
                  </div>
                </div>
              </div>
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div :class="{ 'col-sm-3': true, 'has-error': errors.has('vigencia') }">
                  <label class="control-label">Vigente Hasta</label>
                  <input
                    ref="vigencia"
                    v-model="user.adm_vigencia"
                    v-validate="'required'"
                    type="date"
                    class="form-control"
                    name="vigencia"
                  />
                  <span v-show="errors.has('vigencia')" class="help-block">{{ errors.first('vigencia') }}</span>
                </div>
                <div :class="{ 'col-sm-3': true, 'has-error': errors.has('estado') }">
                  <label class="control-label">Estado</label>
                  <select
                    ref="estado"
                    v-model="user.adm_estado"
                    v-validate="'required'"
                    class="form-control"
                    name="estado"
                  >
                    <option :value="null">Seleccione Opción</option>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                  <span v-show="errors.has('estado')" class="help-block">{{ errors.first('estado') }}</span>
                </div>
                <div class="col-sm-6">
                  <label>Observaciones</label>
                  <input
                    v-model="user.adm_observacion"
                    type="text"
                    class="form-control"
                    @change="user.adm_observacion = user.adm_observacion.toUpperCase()"
                  />
                </div>
              </div>
              <!--FINCUERPO-->
            </div>
          </div>
          <div class="panel panel-primary">
            <div class="panel-heading">Asignar roles al usuario</div>
            <div class="panel-body">
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div :class="{ 'col-sm-12': true, 'has-error': errors.has('roles') }">
                  <label class="control-label">Roles</label>
                  <multiselect
                    ref="roles"
                    v-model="value"
                    v-validate="'required'"
                    name="roles"
                    tag-placeholder="Add this as new tag"
                    placeholder="Busca y agrega un rol...."
                    label="name"
                    track-by="id"
                    :options="getRoles"
                    :multiple="true"
                    :taggable="true"
                    @tag="addTag"
                  />
                  <span v-show="errors.has('roles')" class="help-block">{{ errors.first('roles') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-primary">
          <div v-if="$route.params.id == null" class="panel-body text-right">
            <button class="btn btn-primary" type="submit">Registrar</button>
          </div>
          <div v-else class="panel-body text-right">
            <button class="btn btn-primary" type="submit">Actualizar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import Vuex from 'vuex'
import Multiselect from 'vue-multiselect'

export default {

  name: 'AdminUsuarioNuevo',

  components: {
    Multiselect
  },

  props: {
          routeGuardar:{
              type: String,
              default: ''
            },
          routeGetUser:{
              type: String,
              default: ''
            },
          routeWebserviceDni:{
              type: String,
              default: ''
            },
          tipo:{
              type: Number,
              default: 1
            },
          tipoUsuarios:{
              type: Number,
              default: 1
            }
        },

  data() {
    return {
      user: {
        adm_name: null,
        adm_lastname: null,
        adm_cargo: null,
        adm_correo: null,
        adm_inicial: null,
        adm_telefono: null,
        adm_dni: null,
        adm_direccion: null,
        adm_con_especialidad: null,
        depe_id: null,
        adm_email: null,
        adm_password: null,
        confirmPassword: null,
        adm_vigencia: null,
        adm_estado: null,
        adm_observacion: null,
        adm_primer_logeo: 1,
        id: null
      },
      modoEdicion: true,
      value: [],
      //Unique Validation
      validating: false
    }
  },

  computed: {
    ...Vuex.mapGetters(['getUnidadesDependenciaForCorrelativo', 'getRoles', 'getRuta']),

    checkUnidad() {
      let unidades = this.getUnidadesDependenciaForCorrelativo(this.tipoUsuarios)
      let oneDependencia = unidades.filter( d => d.iddependencia == this.user.depe_id)[0]
      if (oneDependencia != undefined) {
        return true
      } else {
        return false
      }
    }
  },

  mounted() {
    this.obtenerRoles()
    if (this.$route.params.id > 0 || this.$route.params.id != null) {
      this.obtenerUser()
    }

    const isUnique = value => {
      this.validating = true
      return axios
        .post(this.getRuta('tramite.usuarios.checkUsuario'), { id: this.user.id, adm_email: value })
        .then(({ data }) => {
          this.validating = false
          return data
        })
        .catch(error => {
          console.log(error)
          return error.response.data
          this.validating = false
        })
    }
    this.$validator.extend('unique', {
      validate: isUnique,
      getMessage: (field, params, data) => data.message
    })
  },

  methods: {
    ...Vuex.mapActions(['obtenerRoles']),

    guardarUsuario() {
      this.$validator.validate().then(result => {
        if (result && this.checkUnidad) {
          const params = {
            user: this.user,
            valueRol: []
          }
          for (var i = 0; i < this.value.length; i++) {
            params.valueRol.push(this.value[i].id)
          }

          axios.post(this.routeGuardar, params).then(response => {
            if (response.data.length === 0) {
              console.log('guardado')
              if (this.tipo == 1) {
                this.$router.push('/tramite/administrador/usuario')
              } else {
                this.$router.push('/administrador/usuarios')
              }
            } else {
              toastr.error('El usuario ya existe, elija otro')
            }
          })
        } else {
          alert('Registre los campos obligatorios')
        }
      })
    },

    obtenerUser() {
      axios.get(this.routeGetUser.replace(/%s/g, this.$route.params.id)).then(response => {
        this.user = response.data
        var roles = response.data.roles
        var v = []
        for (var i = 0; i < roles.length; i++) {
          this.value.push({ id: roles[i].role_id, role_id: roles[i].id, name: roles[i].name })
        }
      })
    },

    validarDNI() {
      if (this.user.adm_dni !== null && this.user.adm_dni.length === 8) {
        axios.get(this.getRuta('tramite.persona.dni').replace(/%s/g, this.user.adm_dni)).then(
          response => {
            if (!response.data.error) {
              this.user.adm_name = response.data.prenombres
              this.user.adm_lastname = response.data.apPrimer + ' ' + response.data.apSegundo
            }
          },
          error => {
            alert('DNI no encontrado en Padrón Electoral')
            this.user.adm_dni = null
          }
        )
      }
    },

    setContrasenia() {
      this.user.adm_password = 123456
      this.user.confirmPassword = 123456
    },

    setContraseniaNull() {
      this.user.adm_password = null
      this.user.confirmPassword = null
    },

    addTag(newTag) {
      console.log(newTag)
      const tag = {
        name: newTag.name,
        role_id: newTag.id,
        id: null
      }
      //this.rolesForUser.push(tag)
      this.value.push(tag)
    }
  }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
input,
textarea {
  text-transform: uppercase;
}
</style>
