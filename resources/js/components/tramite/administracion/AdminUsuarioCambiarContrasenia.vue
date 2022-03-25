<template>
  <div class="container">
    <div class="panel-group">
      <form action="" @submit.prevent="cambiarContrasenia()">
        <div class="panel panel-primary">
          <div v-if="tipo == 1" class="panel-heading">PARA CONTINUAR ES NECESARIO ACTUALIZAR SUS DATOS</div>
          <div v-else class="panel-heading">ACTUALIZAR DATOS PERSONALES</div>
          <div class="panel-body">
            <div class="col-lg-6">
              <div class="col-sm-3">
                <label>Nombre</label>
              </div>
              <div class="col-sm-9">
                <p>{{ formData.adm_name }}</p>
              </div>
              <div class="col-sm-3">
                <label>Apellido</label>
              </div>
              <div class="col-sm-9">
                <p>{{ formData.adm_lastname }}</p>
              </div>
              <div class="col-sm-3">
                <label>Cargo</label>
              </div>
              <div class="col-sm-9">
                <p>{{ formData.adm_cargo }}</p>
              </div>
              <div class="col-sm-3">
                <label>Iniciales</label>
              </div>
              <div class="col-sm-9">
                <p>{{ formData.adm_inicial }}</p>
              </div>
              <div class="col-sm-3">
                <label>Usuario</label>
              </div>
              <div class="col-sm-9">
                <p>{{ formData.adm_email }}</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div :class="{ 'col-sm-3': true, 'has-error': errors.has('dni') }">
                <label class="control-label">DNI</label>
              </div>
              <div :class="{ 'col-sm-9': true, 'has-error': errors.has('dni') }">
                <input
                  ref="dni"
                  v-model="formData.adm_dni"
                  v-validate="'required|numeric|digits:8'"
                  type="text"
                  name="dni"
                  class="form-control"
                  @change="validarDNI()"
                />
                <span v-show="errors.has('dni')" class="help-block">{{ errors.first('dni') }}</span>
              </div>
              <div :class="{ 'col-sm-3': true, 'has-error': errors.has('email') }">
                <label class="control-label">Email</label>
              </div>
              <div :class="{ 'col-sm-9': true, 'has-error': errors.has('email') }">
                <input
                  ref="email"
                  v-model="formData.adm_correo"
                  v-validate="'required|email'"
                  name="email"
                  type="email"
                  class="form-control"
                />
                <span v-show="errors.has('email')" class="help-block">{{ errors.first('email') }}</span>
              </div>
              <div :class="{ 'col-sm-3': true, 'has-error': errors.has('ntelf') }">
                <label class="control-label">Telefono</label>
              </div>
              <div :class="{ 'col-sm-9': true, 'has-error': errors.has('ntelf') }">
                <input
                  ref="ntelf"
                  v-model="formData.adm_telefono"
                  v-validate="'required|numeric|digits:9'"
                  type="text"
                  name="ntelf"
                  class="form-control"
                />
                <span v-show="errors.has('ntelf')" class="help-block">{{ errors.first('ntelf') }}</span>
              </div>
              <div :class="{ 'col-sm-3': true, 'has-error': errors.has('contrasenia') }">
                <label class="control-label">Contraseña</label>
              </div>
              <div :class="{ 'col-sm-9': true, 'has-error': errors.has('contrasenia') }">
                <input
                  ref="contrasenia"
                  v-model="adm_password"
                  v-validate="'required'"
                  type="password"
                  name="contrasenia"
                  class="form-control"
                />
                <span v-show="errors.has('contrasenia')" class="help-block">{{ errors.first('contrasenia') }}</span>
              </div>
              <div :class="{ 'col-sm-3': true, 'has-error': errors.has('confirmar_contraseña') }">
                <label class="control-label">Repite contraseña</label>
              </div>
              <div :class="{ 'col-sm-9': true, 'has-error': errors.has('confirmar_contraseña') }">
                <input
                  v-model="confirmPassword"
                  v-validate="'required|confirmed:contrasenia'"
                  type="password"
                  class="form-control"
                  name="confirmar_contraseña"
                  data-vv-as="contrasenia"
                />
                <span v-show="errors.has('confirmar_contraseña')" class="help-block">{{
                  errors.first('confirmar_contraseña')
                }}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-primary">
          <div class="panel-body text-right">
            <a v-if="tipo != 1" :href="routeInicio" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" type="submit">Actualizar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {

  props: {
          routeInicio:{
              type: String,
              default: ''
            },
          routePrincipal:{
              type: String,
              default: ''
            },
          routeUser:{
              type: String,
              default: ''
            }, 
          routeWebserviceDni:{
              type: String,
              default: ''
            },
          user:{
              type: Object,
              default: () => ({}),
            },
          tipo:{
              type: Number,
              default: 1
            }
        },
  
  data() {
    return {
      formData: {
        id: this.user.id,
        adm_name: this.user.adm_name,
        adm_lastname: this.user.adm_lastname,
        adm_cargo: this.user.adm_cargo,
        adm_inicial: this.user.adm_inicial,
        adm_email: this.user.adm_email,
        adm_dni: this.user.adm_dni,
        adm_correo: this.user.adm_correo,
        adm_telefono: this.user.adm_telefono
      },
      adm_password: null,
      reset: null,
      confirmPassword: null
    }
  },

  methods: {
    cambiarContrasenia() {
      this.$validator.validate().then(result => {
        if (result) {
          const params = {
            id: this.user.id,
            adm_password: this.adm_password,
            tipo: this.tipo,
            reset: this.reset,
            adm_name: this.formData.adm_name,
            adm_lastname: this.formData.adm_lastname,
            adm_dni: this.formData.adm_dni,
            adm_correo: this.formData.adm_correo,
            adm_telefono: this.formData.adm_telefono
          }
          axios.post(this.routeUser, params).then(response => {
            if (response.data.status) {
              alert('Datos actualizados correctamente!')
              if (this.tipo == 1) {
                window.location.assign(this.routePrincipal)
              } else {
                window.location.assign(this.routeInicio)
              }
            }
          })
        } else {
          console.log('Incompleto')
        }
      })
    },

    validarDNI() {
      if (this.formData.adm_dni !== null && this.formData.adm_dni.length === 8) {
        var este = this
        axios
          .get(this.routeWebserviceDni.replace(/%s/g, this.formData.adm_dni))
          .then(response => {
            if (!response.data.error) {
              this.formData.adm_name = response.data.prenombres
              this.formData.adm_lastname = response.data.apPrimer + ' ' + response.data.apSegundo
            } else {
              window.location.reload(true)
            }
          })
          .catch(function(error) {
            if (error.response) {
              // The request was made and the server responded with a status code
              // that falls out of the range of 2xx
              /*console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);*/

              if ((error.status = 400)) alert(error.response.data)
            } else if (error.request) {
              // The request was made but no response was received
              // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
              // http.ClientRequest in node.js
              console.log(error.request)
              window.location.reload(true)
            } else {
              window.location.reload(true)
              // Something happened in setting up the request that triggered an Error
              console.log('Error', error.message)
            }
            este.formData.adm_dni = null
            console.log(error.config)
          })
      }
    }
  }
}
</script>
