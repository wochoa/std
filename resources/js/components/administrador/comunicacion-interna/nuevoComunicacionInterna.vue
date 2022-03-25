<template>
  <div class="panel-group">
    <form @submit.prevent="guardarPublicacion()">
      <div class="panel panel-primary">
        <div class="panel-heading">LLENE LOS DATOS DE LA NUEVA PUBLICACIÓN</div>
        <div class="panel-body">
          <div class="form-group" style="width: 100%;margin-left: -0px;">
            <div :class="{ 'col-sm-6': true, 'has-error': errors.has('sustento') }">
              <label class="control-label">Contenido del comunicado</label>
              <input
                ref="sustento"
                v-model="publicacion.sustento"
                v-validate="'required'"
                type="text"
                class="form-control"
                name="sustento"
                @change="publicacion.sustento = publicacion.sustento.toUpperCase()"
              />
              <span v-show="errors.has('sustento')" class="help-block">{{ errors.first('sustento') }}</span>
            </div>
            <div class="col-sm-6">
              <br />
              <p>
                <strong>Las imagenes deberan de tener una resolución de 720x482 px. Esto para que se visualice correctamente
                  en la portada y no atentar contra el rendimiento del Portal web</strong>
              </p>
              <br />
            </div>
          </div>
          <div class="form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-12">
              <div :class="{ 'col-sm-2': true, 'has-error': errors.has('fecha_inicio') }">
                <label class="control-label">Inicio difusión</label>
                <input
                  ref="fecha_inicio"
                  v-model="publicacion.fecha_inicio"
                  v-validate="'required'"
                  type="date"
                  class="form-control"
                  name="fecha_inicio"
                />
                <span v-show="errors.has('fecha_inicio')" class="help-block">{{ errors.first('fecha_inicio') }}</span>
              </div>
              <div :class="{ 'col-sm-2': true, 'has-error': errors.has('fecha_fin') }">
                <label class="control-label">Fin difusión</label>
                <input
                  ref="fecha_fin"
                  v-model="publicacion.fecha_fin"
                  v-validate="'required'"
                  type="date"
                  class="form-control"
                  name="fecha_fin"
                />
                <span v-show="errors.has('fecha_fin')" class="help-block">{{ errors.first('fecha_fin') }}</span>
              </div>
              <div class="col-sm-2">
                <label>Estado</label>
                <select v-model="publicacion.estado" class="form-control">
                  <option :value="null">Seleccione</option>
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
              <div :class="{ 'col-sm-4': true, 'has-error': errors.has('imagen') }">
                <label class="control-label">Imagen</label>
                <input
                  ref="imagen"
                  v-validate=""
                  class="form-control"
                  type="file"
                  name="imagen"
                  accept="image/jpg, image/png"
                  @change="processFile($event)"
                />

                <span v-show="errors.has('imagen')" class="help-block">{{ errors.first('imagen') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-primary">
        <div class="panel-body text-right">
          <button class="btn btn-primary" type="submit">Registrar</button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  data() {
    return {
      publicacion: {
        id: null,
        id_solicitante: this.userId,
        sustento: null,
        imagen: null,
        fecha_inicio: null,
        fecha_fin: null,
        estado: null
      }
    }
  },

  props:{
            routeGuardar:{
              type: String,
              default: ''
            }, 
            routeGetPublicacion:{
              type: String,
              default: ''
            }, 
            userId:{
              type: String,
              default: ''
            }
        },

  mounted() {
    if (this.$route.params.id > 0 || this.$route.params.id != null) this.obtenerPublicacion()
  },

  methods: {
    processFile(event) {
      this.publicacion.imagen = event.target.files[0]
    },

    guardarPublicacion() {
      this.$validator.validate().then(result => {
        if (result) {
          let f = new FormData()
          f.append('id', this.publicacion.id)
          f.append('id_solicitante', this.publicacion.id_solicitante)
          f.append('sustento', this.publicacion.sustento)
          f.append('imagen', this.publicacion.imagen)
          f.append('fecha_inicio', this.publicacion.fecha_inicio)
          f.append('fecha_fin', this.publicacion.fecha_fin)
          f.append('estado', this.publicacion.estado)
          axios.post(this.routeGuardar, f, { headers: { 'Content-Type': 'multipart/form-data' } }).then(response => {
            console.log('guardado')
            this.$router.push('/administrador/publicaciones')
          })
        } else {
          console.log('incompleto')
        }
      })
    },

    obtenerPublicacion() {
      axios.get(this.routeGetPublicacion.replace(/%s/g, this.$route.params.id)).then(response => {
        this.publicacion = response.data
      })
    }
  }
}
</script>
