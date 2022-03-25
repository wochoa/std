<template>
  <div class="panel-group">
    <form action="" @submit.prevent="guardarTipoDocumento()">
      <div class="panel panel-primary">
        <div v-if="$route.params.id == null" class="panel-heading">TIPO DE DOCUMENTO</div>
        <div v-else class="panel-heading">EDITAR TIPO DE DOCUMENTO</div>
        <div class="panel-body">
          <div class="form-group" style="width: 100%;margin-left: -0px;">
            <div :class="{ 'col-sm-5': true, 'has-error': errors.has('nombre') }">
              <label class="control-label">Descripción</label>
              <input
                ref="nombre"
                v-model="tipoDocumento.tdoc_descripcion"
                v-validate="'required'"
                type="text"
                class="form-control"
                name="nombre"
                @change="tipoDocumento.tdoc_descripcion = tipoDocumento.tdoc_descripcion.toUpperCase()"
              />
              <span v-show="errors.has('nombre')" class="help-block">{{ errors.first('nombre') }}</span>
            </div>
            <div :class="{ 'col-sm-5': true, 'has-error': errors.has('abreviado') }">
              <label class="control-label">Descripción Abreviado:</label>
              <input
                ref="abreviado"
                v-model="tipoDocumento.tdoc_abreviado"
                v-validate="'required'"
                type="text"
                class="form-control"
                name="abreviado"
                @change="tipoDocumento.tdoc_abreviado = tipoDocumento.tdoc_abreviado.toUpperCase()"
              />
              <span v-show="errors.has('abreviado')" class="help-block">{{ errors.first('abreviado') }}</span>
            </div>
            <div :class="{ 'col-sm-2': true, 'has-error': errors.has('mpv') }">
              <label class="control-label">Usado MPV</label>
              <select
                ref="mpv"
                v-model="tipoDocumento.tdoc_mpv"
                v-validate="'required'"
                class="form-control"
                name="mpv"
              >
                <option :value="true">Si</option>
                <option :value="false">No</option>
              </select>
              <span v-show="errors.has('mpv')" class="help-block">{{ errors.first('mpv') }}</span>
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
</template>
<script>
export default {

  props:{
          routeGuardar:{
              type: String,
              default: ''
            },
          routeGetTipo:{
              type: String,
              default: ''
            }
        },

  data() {
    return {
      tipoDocumento: {
        tdoc_descripcion: null,
        tdoc_abreviado: null,
        tdoc_correlativo: 0,
        tdoc_mpv: false,
        idtdoc: null
      },
      modoEdicion: true
    }
  },

  mounted() {
    if (this.$route.params.id > 0 || this.$route.params.id != null) {
      this.obtenerTipoDocumento()
    }
  },

  methods: {
    guardarTipoDocumento() {
      this.$validator.validate().then(result => {
        if (result) {
          axios.post(this.routeGuardar, this.tipoDocumento).then(reponse => {
            console.log('guardado')
            this.$router.push('/tramite/catalogo/tipoDocumento')
          })
        } else {
          console.log('incompleto')
        }
      })
    },

    obtenerTipoDocumento() {
      axios
        .get(this.routeGetTipo.replace(/%s/g, this.$route.params.id))
        .then(response => (this.tipoDocumento = response.data))
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
