<template>
  <div class="container">
    <div class="panel-group">
      <form action="" @submit.prevent="guardarUnidad()">
        <div class="panel panel-primary">
          <div v-if="$route.params.id == null" class="panel-heading">DATOS DE LA UNIDAD ORGÁNICA</div>
          <div v-else class="panel-heading">EDITE LOS DATOS DE LA UNIDAD</div>
          <div class="panel-body">
            <!--CUERPO-->
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div v-if="tipo == 1" :class="{ 'col-sm-6': true, 'has-error': errors.has('dependencia') }">
                <label class="control-label">Dependencia</label>
                <select
                  ref="dependencia"
                  v-model="unidad.depe_depende"
                  v-validate="'required'"
                  :disabled="!(tipo == 1)"
                  class="form-control"
                  name="dependencia"
                >
                  <option :value="null">Seleccione Opción</option>
                  <option v-for="(sede, indexSede) in getSedes" :key="indexSede" :value="sede.iddependencia">{{ sede.depe_nombre }}</option>
                </select>
                <span v-show="errors.has('dependencia')" class="help-block">{{ errors.first('dependencia') }}</span>
              </div>
              <div v-else class="col-sm-6">
                <label>Dependencia</label>
                <p>{{ getDependenciaNombre(unidad.depe_depende) }}</p>
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div v-if="tipo == 1" :class="{ 'col-sm-6': true, 'has-error': errors.has('nombre') }">
                <label class="control-label">Nombre</label>
                <input
                  ref="nombre"
                  v-model="unidad.depe_nombre"
                  v-validate="'required'"
                  type="text"
                  class="form-control"
                  name="nombre"
                  @change="unidad.depe_nombre = unidad.depe_nombre.toUpperCase()"
                />
                <span v-show="errors.has('nombre')" class="help-block">{{ errors.first('nombre') }}</span>
              </div>
              <div v-else class="col-sm-6">
                <label class="control-label">Nombre</label>
                <p>{{ unidad.depe_nombre }}</p>
              </div>
              <div v-if="tipo == 1" :class="{ 'col-sm-3': true, 'has-error': errors.has('abreviado') }">
                <label class="control-label">Nombre Abreviado</label>
                <input
                  ref="abreviado"
                  v-model="unidad.depe_abreviado"
                  v-validate="'required'"
                  type="text"
                  class="form-control"
                  name="abreviado"
                  :disabled="!(tipo == 1)"
                  @change="unidad.depe_abreviado = unidad.depe_abreviado.toUpperCase()"
                />
                <span v-show="errors.has('abreviado')" class="help-block">{{ errors.first('abreviado') }}</span>
              </div>
              <div v-else class="col-sm-3">
                <label class="control-label">Nombre Abreviado</label>
                <p>{{ unidad.depe_abreviado }}</p>
              </div>
              <div v-if="tipo == 1" :class="{ 'col-sm-3': true, 'has-error': errors.has('siglas') }">
                <label class="control-label">Siglas de Documentos</label>
                <input
                  ref="siglas"
                  v-model="unidad.depe_sigla"
                  v-validate="'required'"
                  class="form-control"
                  name="siglas"
                  type="text"
                  :disabled="!(tipo == 1)"
                  @change="unidad.depe_sigla = unidad.depe_sigla.toUpperCase()"
                />
                <span v-show="errors.has('siglas')" class="help-block">{{ errors.first('siglas') }}</span>
              </div>
              <div v-else class="col-sm-3">
                <label class="control-label">Siglas de Documentos</label>
                <p>{{ unidad.depe_sigla }}</p>
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div :class="{ 'col-sm-2': true, 'has-error': errors.has('dni') }">
                <label class="control-label">DNI</label>
                <input
                  ref="dni"
                  v-model="unidad.depe_dni"
                  v-validate="'required|numeric|digits:8'"
                  type="text"
                  name="dni"
                  class="form-control"
                  @change="validarDNI()"
                />
                <span v-show="errors.has('dni')" class="help-block">{{ errors.first('dni') }}</span>
              </div>
              <div :class="{ 'col-sm-4': true, 'has-error': errors.has('representante') }">
                <label class="control-label">Representante</label>
                <input
                  ref="representante"
                  v-model="unidad.depe_representante"
                  v-validate="'required'"
                  class="form-control"
                  name="representante"
                  type="text"
                  @change="unidad.depe_representante = unidad.depe_representante.toUpperCase()"
                />
                <span v-show="errors.has('representante')" class="help-block">{{ errors.first('representante') }}</span>
              </div>
              <div :class="{ 'col-sm-3': true, 'has-error': errors.has('cargo') }">
                <label class="control-label">Cargo</label>
                <input
                  ref="cargo"
                  v-model="unidad.depe_cargo"
                  v-validate="'required'"
                  class="form-control"
                  name="cargo"
                  type="text"
                  @change="unidad.depe_cargo = unidad.depe_cargo.toUpperCase()"
                />
                <span v-show="errors.has('cargo')" class="help-block">{{ errors.first('cargo') }}</span>
              </div>
              <div class="col-sm-3">
                <label>Re.Tramite:</label>
                <div>
                  <label>
                    <input
                      v-model="unidad.depe_recibetramite"
                      type="radio"
                      :value="1"
                      class="radio-inline"
                    />Si</label>
                  <label>
                    <input
                      v-model="unidad.depe_recibetramite"
                      type="radio"
                      :value="null"
                      class="radio-inline"
                    />No</label>
                </div>
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div v-if="tipo == 1" class="col-sm-2">
                <label>Es RRHH:</label>
                <div>
                  <label><input v-model="unidad.depe_rrhh" type="radio" :value="1" class="radio-inline" />Si</label>
                  <label><input v-model="unidad.depe_rrhh" type="radio" :value="null" class="radio-inline" />No</label>
                </div>
              </div>
              <div v-if="tipo == 1" :class="{ 'col-sm-3': true, 'has-error': errors.has('dias') }">
                <label class="control-label"># Días.Máx.atención Exp</label>
                <input
                  ref="dias"
                  v-model="unidad.depe_diasmaxenproceso"
                  v-validate="'required'"
                  type="text"
                  class="form-control"
                  name="dias"
                />
                <span v-show="errors.has('dias')" class="help-block">{{ errors.first('dias') }}</span>
              </div>
              <div v-if="tipo == 1" :class="{ 'col-sm-3': true, 'has-error': errors.has('estado') }">
                <label class="control-label">Estado</label>
                <select
                  ref="estado"
                  v-model="unidad.depe_estado"
                  v-validate="'required'"
                  class="form-control"
                  name="estado"
                >
                  <option :value="null">Seleccione Opcion</option>
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
                <span v-show="errors.has('estado')" class="help-block">{{ errors.first('estado') }}</span>
              </div>
              <div v-if="tipo == 1" class="col-sm-4">
                <label>Observaciones</label>
                <input
                  v-model="unidad.depe_observaciones"
                  type="text"
                  class="form-control"
                  @change="unidad.depe_observaciones = unidad.depe_observaciones.toUpperCase()"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-primary">
          <div class="panel-heading">CABECERA</div>
          <div class="panel-body">
            <div class="row form-group">
              <div class="col-sm-6">
                <label class="control-label">Cabecera 1</label>
                <select
                  ref="superior"
                  v-model="unidad.depe_superior.dependencia"
                  class="form-control"
                  name="superior"
                >
                  <option :value="null">Ninguna</option>
                  <option v-for="(sede, indexSede) in getUnidadesSede(unidad.depe_depende)" :key="indexSede" :value="sede.iddependencia">{{
                    sede.depe_nombre
                  }}</option>
                </select>
              </div>
              <div :class="{ 'col-sm-6': true }">
                <label class="control-label">Cabecera 2</label>
                <input
                  v-model="unidad.depe_superior.nombre"
                  type="text"
                  class="form-control"
                  @change="unidad.depe_superior.nombre = unidad.depe_superior.nombre.toUpperCase()"
                />
              </div>
            </div>
          </div>
        </div>
        <!--FINCUERPO-->
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
export default {

  name: 'AdminUnidadOrganicaNuevo',

  props: {
          routeGuardar:{
              type: String,
              default: ''
            },
          routeGetUnidad:{
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
            }
        },

  data() {
    return {
      unidad: {
        iddependencia: null,
        depe_depende: null,
        depe_nombre: null,
        depe_abreviado: null,
        depe_sigla: null,
        depe_representante: null,
        depe_cargo: null,
        depe_dni: null,
        depe_diasmaxenproceso: null,
        depe_estado: null,
        depe_observaciones: null,
        depe_rrhh: null,
        depe_recibetramite: null,
        depe_superior: { dependencia: null, nombre: null }
      },
      edicionUnidad: true
    }
  },

  computed: {
    ...Vuex.mapGetters(['getSedes', 'getUnidadesSede', 'getDependenciaNombre', 'getRuta'])
  },

  mounted() {
    if (this.$route.params.id > 0 || this.$route.params.id != null) {
      this.obtenerUnidad()
    }
  },

  methods: {
    guardarUnidad() {
      this.$validator.validate().then(result => {
        if (result) {
          const params = {
            tipo: this.tipo,
            unidad: this.unidad
          }
          axios.post(this.routeGuardar, params).then(response => {
            console.log('guardado')
            if (this.tipo == 1) {
              this.$router.push('/tramite/administrador/unidades')
            } else {
              this.$router.push('/tramite/administrador/unidadesSedes')
            }
          })
        } else {
          console.log('incompleto')
        }
      })
    },

    obtenerUnidad() {
      axios.get(this.routeGetUnidad.replace(/%s/g, this.$route.params.id)).then(response => {
        this.unidad = response.data
      })
    },

    validarDNI() {
      if (this.unidad.depe_dni !== null && this.unidad.depe_dni.length === 8) {
        axios.get(this.getRuta('tramite.persona.dni').replace(/%s/g, this.unidad.depe_dni)).then(
          response => {
            if (!response.data.error) {
              this.unidad.depe_representante =
                response.data.prenombres + ' ' + response.data.apPrimer + ' ' + response.data.apSegundo
            }
          },
          error => {
            alert('DNI no encontrado en Padrón Electoral')
            this.unidad.depe_dni = null
          }
        )
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
