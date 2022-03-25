<template>
  <div class="panel-group">
    <form action="" @submit.prevent="guardarRol()">
      <div class="panel panel-primary">
        <div class="panel panel-primary">
          <div class="panel-heading">LLENE LOS DATOS DEL NUEVO ROL</div>
          <div class="panel-body">
            <div class="form-group" style="width: 100%;margin-left: -0px;">
              <div :class="{ 'col-sm-6': true, 'has-error': errors.has('nombre') }">
                <label class="control-label">Nombre</label>
                <input
                  ref="nombre"
                  v-model="rol.name"
                  v-validate="'required'"
                  type="text"
                  class="form-control"
                  name="nombre"
                  @change="rol.name = rol.name.toUpperCase()"
                />
                <span v-show="errors.has('nombre')" class="help-block">{{ errors.first('nombre') }}</span>
              </div>
              <div :class="{ 'col-sm-6': true, 'has-error': errors.has('url') }">
                <label class="control-label">URL Amigable</label>
                <input
                  ref="url"
                  v-model="rol.slug"
                  v-validate="'required'"
                  type="text"
                  class="form-control"
                  name="url"
                  @change="rol.slug = rol.slug.toUpperCase()"
                />
                <span v-show="errors.has('url')" class="help-block">{{ errors.first('url') }}</span>
              </div>
            </div>
            <div class="form-group" style="width: 100%;margin-left: -0px;">
              <div :class="{ 'col-sm-6': true, 'has-error': errors.has('descripcion') }">
                <label class="control-label">Descripción</label>
                <input
                  ref="descripcion"
                  v-model="rol.description"
                  v-validate="'required'"
                  type="text"
                  class="form-control"
                  name="descripcion"
                  @change="rol.description = rol.description.toUpperCase()"
                />
                <span v-show="errors.has('descripcion')" class="help-block">{{ errors.first('descripcion') }}</span>
              </div>
              <div class="col-sm-6">
                <label>Permiso especial</label>
                <br />
                <label>
                  <input v-model="rol.special" type="radio" value="1" class="radio-inline" />Acceso
                  total</label>
                <label>
                  <input v-model="rol.special" type="radio" value="0" class="radio-inline" />Ningun
                  acceso</label>
                <label>
                  <input v-model="rol.special" type="radio" class="radio-inline" :value="null" />Normal</label>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-primary">
          <div class="panel-heading">Asignar permisos al rol</div>
          <div class="panel-body">
            <div class="form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-12">
                <label>Lista de Permisos</label>
              </div>
            </div>
            <div class="form-group" style="width: 100%;margin-left: -0px;">
              <multiselect
                v-model="value"
                tag-placeholder="Add this as new tag"
                placeholder="Busca y agrega un permiso...."
                label="name"
                track-by="id"
                :options="getPermisos"
                :multiple="true"
                :taggable="true"
                @tag="addTag"
              />
            </div>
          </div>
        </div>
        <div class="panel panel-primary">
          <div class="panel-body text-right">
            <button class="btn btn-primary" type="submit">Registrar</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
export default {

  components: {
    Multiselect
  },

  props:{
          routeGuardar:{
              type: String,
              default: ''
            }, 
          routeGetRol:{
              type: String,
              default: ''
            }
        },        

  data() {
    return {
      rol: {
        id: null,
        name: null,
        slug: null,
        description: null,
        special: null
      },
      value: [],
      modoEdicion: true
    }
  },

  computed: {
    ...Vuex.mapGetters(['getPermisos'])
  },

  mounted() {
    if (this.$route.params.id > 0 || this.$route.params.id != null) {
      this.obtenerRol()
    }
  },

  methods: {
    guardarRol() {
      this.$validator.validate().then(result => {
        if (result) {
          const params = {
            rol: this.rol,
            idPermiso: []
          }
          for (var i = 0; i < this.value.length; i++) {
            params.idPermiso.push(this.value[i].id)
          }
          axios.post(this.routeGuardar, params).then(response => {
            console.log('Guardado')
            this.$router.push('/administrador/roles')
          })
        } else {
          console.log('incompleto')
        }
      })
    },

    obtenerRol() {
      axios.get(this.routeGetRol.replace(/%s/g, this.$route.params.id)).then(response => {
        this.rol = response.data
        var permisos = response.data.permisos
        for (var i = 0; i < permisos.length; i++) {
          //this.p[permisos[i].permission_id]={'id':permisos[i].id,'value':true};
          this.value.push({ id: permisos[i].permission_id, name: permisos[i].name })
        }
      })
    },

    addTag(newTag) {
      console.log(newTag)
      const tag = {
        name: newTag.name,
        id: null
      }
      console.log(tag)
      this.rolesForUser.push(tag)
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
