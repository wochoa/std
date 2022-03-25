<template>
  <div class="container">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div v-if="this.$route.params.id == null" class="panel-heading">ENTIDADES</div>
        <div v-else class="panel-heading">EDITAR ENTIDAD</div>
        <div class="panel-body">
          <form action="" @submit.prevent="guardarEntidad()">
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div :class="{ 'col-sm-6': true, 'has-error': errors.has('nombre') }">
                <label class="control-label">Nombre</label>
                <input
                  ref="nombre"
                  v-model="dependencia.depe_nombre"
                  v-validate="'required'"
                  type="text"
                  class="form-control"
                  name="nombre"
                  @change="dependencia.depe_nombre = dependencia.depe_nombre.toUpperCase()"
                />
                <span v-show="errors.has('nombre')" class="help-block">{{ errors.first('nombre') }}</span>
              </div>
              <div :class="{ 'col-sm-3': true, 'has-error': errors.has('abreviado') }">
                <label class="control-label">Nombre Abreviado</label>
                <input
                  ref="abreviado"
                  v-model="dependencia.depe_abreviado"
                  v-validate="'required'"
                  class="form-control"
                  name="abreviado"
                  type="text"
                  @change="dependencia.depe_abreviado = dependencia.depe_abreviado.toUpperCase()"
                />
                <span v-show="errors.has('abreviado')" class="help-block">{{ errors.first('abreviado') }}</span>
              </div>
              <div class="col-sm-3">
                <label for="">Siglas de Documentos</label>
                <input
                  v-model="dependencia.depe_sigla"
                  type="text"
                  class="form-control"
                  @change="dependencia.depe_sigla = dependencia.depe_sigla.toUpperCase()"
                />
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-4">
                <label for="">Representantes</label>
                <input
                  v-model="dependencia.depe_representante"
                  type="text"
                  class="form-control"
                  @change="dependencia.depe_representante = dependencia.depe_representante.toUpperCase()"
                />
              </div>
              <div class="col-sm-4">
                <label for="">Cargo</label>
                <input
                  v-model="dependencia.depe_cargo"
                  type="text"
                  class="form-control"
                  @change="dependencia.depe_cargo = dependencia.depe_cargo.toUpperCase()"
                />
              </div>
              <div class="form-group" style="display: none;">
                <label for="">Usuario</label>
                <input type="text" class="form-control" disabled />
              </div>
              <div class="form-group" style="display: none;">
                <label for="">Password</label>
                <input type="password" class="form-control" readonly />
              </div>
              <div v-if="this.$route.params.id == null" class="col-sm-4">
                <br />
                <button type="submit" class="btn btn-primary">Registrar</button>
              </div>
              <div v-else class="col-sm-4">
                <br />
                <button type="submit" class="btn btn-primary">Actualizar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {  

  props:{
          routeGuardar:{
              type: String,
              default: ''
          }, 
          routeGetEntidad:{
              type: String,
              default: ''
          }
        },
  
  data() {
    return {
      dependencia: {
        depe_nombre: null,
        depe_abreviado: null,
        depe_sigla: null,
        depe_representante: null,
        depe_cargo: null
      },
      edicionEntidades: true
    }
  },

  mounted() {
    if (this.$route.params.id > 0 || this.$route.params.id != null) {
      this.obtenerEntidad()
    }
  },

  methods: {
    guardarEntidad() {
      this.$validator.validate().then(result => {
        if (result) {
          axios.post(this.routeGuardar, this.dependencia).then(response => {
            console.log('guardado')
            this.$router.push('/tramite/administrador/entidades')
          })
        } else {
          console.log('incompleto')
        }
      })
    },

    obtenerEntidad() {
      axios
        .get(this.routeGetEntidad.replace(/%s/g, this.$route.params.id))
        .then(response => (this.dependencia = response.data))
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
