<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div v-if="$route.params.id == null" class="panel-heading">ARCHIVADORES</div>
      <div v-else class="panel-heading">EDITAR ARCHIVADOR</div>
      <div class="panel-body">
        <!--CUERPO-->
        <form action="" @submit.prevent="guardarArchivador()">
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-1">
              <label>Ambito:</label>
            </div>
            <div class="col-sm-2">
              <input v-model="archivador.arch_idusuarioa" type="checkbox" /> Archivador Personal
            </div>
            <div class="col-sm-2">
              <label>Unidad Organica:</label>
            </div>
            <div class="col-sm-1">
              <input type="text" :value="getDependenciaUser.iddependencia" class="form-control" readonly />
            </div>
            <div class="col-sm-6">
              <input type="text" :value="getDependenciaUser.depe_nombre" class="form-control" readonly />
            </div>
          </div>
          <div v-if="archivador.arch_idusuarioa" class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-1">
              <label>Usuario</label>
            </div>
            <div class="col-sm-4">
              <input
                type="text"
                :value="getUsuario.adm_name + ' ' + getUsuario.adm_lastname"
                class="form-control"
                readonly
              />
            </div>
          </div>
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div :class="{ 'col-sm-7': true, 'has-error': errors.has('nombre') }">
              <label>Descripción</label>
              <input
                ref="nombre"
                v-model="archivador.arch_nombre"
                v-validate="'required'"
                type="text"
                class="form-control"
                name="nombre"
                @change="archivador.arch_nombre = archivador.arch_nombre.toUpperCase()"
              />
              <span v-show="errors.has('nombre')" class="help-block">{{ errors.first('nombre') }}</span>
            </div>
            <div class="col-sm-3">
              <label>Periodo</label>
              <input v-model="archivador.arch_periodo" type="text" class="form-control" readonly />
            </div>
            <div class="col-sm-2">
              <br />
              <button v-if="$route.params.id == null" class="btn btn-primary" type="submit">Registrar</button>
              <button v-else class="btn btn-primary" type="submit">Actualizar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'
export default {

  props:{
          routeGuardar:{
              type: String,
              default: ''
            },
          routeGetArchivador:{
              type: String,
              default: ''
            }
        },

  data() {
    return {
      archivador: {
        arch_nombre: null,
        arch_periodo: new Date().getFullYear(),
        arch_idusuarioa: false
      },
      edicionArchivador: true
    }
  },

  computed: {
    ...Vuex.mapGetters(['getDependenciaUser','getUsuario'])
  },

  mounted() {
    this.obtenerDependenciaUser()

    if (this.$route.params.id > 0 || this.$route.params.id != null) {
      this.obtenerArchivador()
    }
  },

  methods: {
    ...Vuex.mapActions(['obtenerDependenciaUser']),

    guardarArchivador() {
      this.$validator.validate().then(result => {
        if (result) {
          axios.post(this.routeGuardar, this.archivador).then(response => {
            console.log('guardado')
            this.$router.push('/tramite/catalogo/archivador')
          })
        } else {
          console.log('incompleto')
        }
      })
    },

    obtenerArchivador() {
      axios
        .get(this.routeGetArchivador.replace(/%s/g, this.$route.params.id))
        .then(response => (this.archivador = response.data))
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
