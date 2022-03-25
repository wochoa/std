<template>
  <div class="container">
    <div class="panel-group">
      <form action="" @submit.prevent="guardarDependencia()">
        <div class="panel panel-primary">
          <div class="panel-heading">DEPENDENCIA</div>
          <div class="panel-body">
            <!--CUERPO-->
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div
                v-if="tipo == 1"
                :class="{ 'col-sm-6': true, 'has-error': errors.has('nombre') }"
              >
                <label class="control-label">Nombre de la Dependencia</label>
                <input
                  ref="nombre"
                  v-model="dependencia.depe_nombre"
                  v-validate="'required'"
                  class="form-control"
                  name="nombre"

                  type="text"
                  @change="dependencia.depe_nombre = dependencia.depe_nombre.toUpperCase()"
                />
                <span v-show="errors.has('nombre')" class="help-block">{{
                  errors.first("nombre")
                }}</span>
              </div>
              <div v-else class="col-sm-6">
                <label>Nombre de la Dependencia</label>
                <p>{{ dependencia.depe_nombre }}</p>
              </div>
              <div
                v-if="tipo == 1"
                :class="{
                  'col-sm-3': true,
                  'has-error': errors.has('abreviado')
                }"
              >
                <label class="control-label">Nombre Abreviado</label>
                <input
                  ref="abreviado"
                  v-model="dependencia.depe_abreviado"
                  v-validate="'required'"
                  type="text"
                  class="form-control"
                  name="abreviado"
                  @change="dependencia.depe_abreviado = dependencia.depe_abreviado.toUpperCase()"
                />
                <span v-show="errors.has('abreviado')" class="help-block">{{
                  errors.first("abreviado")
                }}</span>
              </div>
              <div v-else class="col-sm-3">
                <label>Nombre Abreviado</label>
                <p>{{ dependencia.depe_abreviado }}</p>
              </div>
              <div
                v-if="tipo == 1"
                :class="{ 'col-sm-3': true, 'has-error': errors.has('estado') }"
              >
                <label class="control-label">Estado</label>
                <select
                  ref="estado"
                  v-model="dependencia.depe_estado"
                  v-validate="'required'"
                  class="form-control"
                  name="estado"
                >
                  <option :value="null">Seleccione opción</option>
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
                <span v-show="errors.has('estado')" class="help-block">{{
                  errors.first("estado")
                }}</span>
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-6">
                <label class="control-label">Logo de Dependencia</label>
                <input
                  ref="fileInput"
                  type="file"
                  class="form-control"
                  name="imagen_header"
                  accept=".JPG,.PNG"
                  @change="processFile($event.path[0].files, 1)"
                />
              </div>
              <div class="col-sm-6">
                <label class="control-label">Pie de Página de Dependencia</label>
                <input
                  ref="fileInput"
                  type="file"
                  class="form-control"
                  name="imagen_footer"
                  accept=".JPG,.PNG"
                  @change="processFile($event.path[0].files, 2)"
                />
              </div>
            </div>
            <div v-if="$route.params.id != null" class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-6">
                <label class="control-label">Responsable Mesa de partes</label>
                <multiselect
                  :value="userTramite"
                  :options="usuarios"
                  :close-on-select="true"
                  :clear-on-select="false"
                  placeholder="Usuario responsable de mesa de partes...."
                  label="name"
                  track-by="id"
                  :multiple="false"
                  @select="usuarioMesaPartes = $event
                           dependencia.depe_idusuariotransp=$event.id"
                  @remove="usuarioMesaPartes = null
                           dependencia.depe_idusuariotransp=null"
                />
              </div>
              <div class="col-sm-6">
                <label class="control-label">Reclamos</label>

                <multiselect
                  :value="userReclamo"
                  name="roles"
                  tag-placeholder="Add this as new tag"
                  placeholder="Usuario responsable de mesa de partes...."
                  label="name"
                  track-by="id"
                  :options="usuarios"
                  :multiple="false"
                  @select="usuarioReclamo = $event
                           dependencia.depe_idusuarioreclamo=$event.id"
                  @remove="usuarioReclamo = null
                           dependencia.depe_idusuarioreclamo=null"
                />
              </div>
            </div>
            <div
              v-if="
                dependencia.depe_imagen_header != null ||
                  dependencia.depe_imagen_footer != null
              "
              class="row form-group"
              style="width: 100%;margin-left: -0px;"
            >
              <div class="col-sm-12">
                <label class="control-label">Imagenes</label>
                <button
                  type="button"
                  class="btn btn-xs btn-link"
                  @click="imprimirImagen(dependencia.iddependencia, 1)"
                >
                  <span class="glyphicon glyphicon-picture"></span>
                  {{ dependencia.depe_imagen_header }}
                </button>
                <button
                  type="button"
                  class="btn btn-xs btn-link"
                  @click="imprimirImagen(dependencia.iddependencia, 2)"
                >
                  <span class="glyphicon glyphicon-picture"></span>
                  {{ dependencia.depe_imagen_footer }}
                </button>
              </div>
            </div>
            <div
              class="row form-group"
              style="width: 100%;margin-left: -0px;"
            >
              <div class="col-sm-6">
                <label for="">Ciudad</label>
                <input
                  ref="ciudad"
                  v-model="dependencia.depe_ciudad"
                  type="text"
                  class="form-control"
                  name="ciudad"
                  @change="dependencia.depe_ciudad = dependencia.depe_ciudad.toUpperCase()"
                />
              </div>
              <div class="col-sm-6">
                <label for="">Minutos de tolerancia</label>
                <input
                  ref="minuto_tolerancia"
                  v-model="dependencia.depe_minuto_tolerancia"
                  type="number"
                  class="form-control"
                  name="minuto_tolerancia"
                  max="60"
                />
              </div>
            </div>

            <div
              v-if="tipo == 1"
              class="row form-group"
              style="width: 100%;margin-left: -0px;"
            >
              <div class="col-sm-7">
                <label for="">Tipo Dependencia:Es Agente?</label>
                <input
                  v-model="dependencia.depe_agente"
                  type="checkbox"
                  class="checkbox-inline"
                />
              </div>
            </div>
            <!--MOSTRAR OCULTO-->
            <div
              v-if="dependencia.depe_agente && tipo == 1"
              class="row form-group"
              style="width: 100%;margin-left: -0px;"
            >
              <div class="col-sm-3">
                <label for="">Siglas del Documento</label>
                <input
                  v-model="dependencia.depe_sigla"
                  type="text"
                  class="form-control"
                  @change="dependencia.depe_sigla = dependencia.depe_sigla.toUpperCase()"
                />
              </div>
              <div class="col-sm-3">
                <label for="">Representante</label>
                <input
                  v-model="dependencia.depe_representante"
                  type="text"
                  class="form-control"
                  @change="dependencia.depe_representante = dependencia.depe_representante.toUpperCase()"
                />
              </div>
              <div class="col-sm-3">
                <label for="">Cargo</label>
                <input
                  v-model="dependencia.depe_cargo"
                  type="text"
                  class="form-control"
                  @change="dependencia.depe_cargo = dependencia.depe_cargo.toUpperCase()"
                />
              </div>
              <div class="col-sm-3">
                <label for="">Al Registrar Documento</label>
                <input
                  v-model="dependencia.depe_proyectado"
                  type="checkbox"
                  class="checkbox-inline"
                />Solicitar quien proyectó Documento
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-6">
                <label class="control-label">IPs</label>
                <div>
                  <button
                    class="btn btn-primary"
                    @click.prevent="ipNew"
                  >
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                  <div v-for="(ip, indexIp) in dependencia.ips" :key="indexIp" class="d-flex">
                    <input v-model="ip.ip" type="text" class="form-control" />
                    <button
                      class="btn btn-danger"
                      @click.prevent="ipDelete(indexIp)"
                    >
                      <span class="glyphicon glyphicon-minus"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-12">
                <p style="color:red">Ip publica encontrada - solo registrar si se encuentra en la red de la Dependencia: {{ ip }}</p>
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-6">
                <label class="control-label">Configurar horarios de atención la Mesa de Partes Virtual</label>
                <div>
                  <button
                    v-if="scheduleMpv.length <= 1"
                    class="btn btn-primary"
                    @click.prevent="scheduleNew(1)"
                  >
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                  <div v-for="(schedule, indexSchedule) in scheduleMpv" :key="indexSchedule" class="d-flex">
                    <input v-model="schedule.entry_time" type="time" class="form-control" />
                    <input v-model="schedule.output_time" type="time" class="form-control" />
                    <select v-model="schedule.status" class="form-control">
                      <option :value="true">Activo</option>
                      <option :value="false">Inactivo</option>
                    </select>
                    <button
                      class="btn btn-danger"
                      @click.prevent="scheduleDelete(schedule)"
                    >
                      <span class="glyphicon glyphicon-minus"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-6">
                <label class="control-label">Configurar horarios de entrada y salida para el control de asistencia</label>
                <div>
                  <button
                    v-if="scheduleAsistance.length <= 1"
                    class="btn btn-primary"
                    @click.prevent="scheduleNew(0)"
                  >
                    <span class="glyphicon glyphicon-plus"></span>
                  </button>
                  <div v-for="(schedule, indexSchedule) in scheduleAsistance" :key="indexSchedule" class="d-flex">
                    <input v-model="schedule.entry_time" type="time" class="form-control" />
                    <input v-model="schedule.output_time" type="time" class="form-control" />
                    <select v-model="schedule.status" class="form-control">
                      <option :value="true">Activo</option>
                      <option :value="false">Inactivo</option>
                    </select>
                    <button
                      class="btn btn-danger"
                      @click.prevent="scheduleDelete(schedule)"
                    >
                      <span class="glyphicon glyphicon-minus"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-primary">
          <div class="panel-body text-right">
            <button class="btn btn-primary" name="insertar" type="submit">
              Registrar
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import {Usuario}   from "@/js/store/models/tramite/administracion"
import Multiselect from 'vue-multiselect'
import Assistance from '@/js/api/tramite/assistance'

export default {

  name: "AdminDependenciaNuevo",

  components: {
    Multiselect
  },
  props     : {
    routeGuardar       : {
      type   : String,
      default: ''
    },
    routeGetDependencia: {
      type   : String,
      default: ''
    },
    tipo               : {
      type   : Number,
      default: 1
    },
    dependenciaSede    : {
      type   : Number,
      default: undefined
    }
  },

  data() {
    return {
      dependencia       : {
        iddependencia        : null,
        depe_nombre          : null,
        depe_abreviado       : null,
        depe_estado          : null,
        depe_agente          : false,
        depe_sigla           : null,
        depe_representante   : null,
        depe_cargo           : null,
        depe_proyectado      : null,
        depe_idusuariotransp : null,
        depe_idusuarioreclamo: null,
        depe_imagen_header   : null,
        depe_imagen_footer   : null,
        depe_ciudad          : null,
        depe_minuto_tolerancia  : null,
        ips                  : [],
        schedules            : []
      },
      edicionDependencia: true,
      imagen_header     : null,
      imagen_footer     : null,
      usuarios          : [],
      usuarioMesaPartes : null,
      usuarioReclamo    : null,
      ip                : null,
    }
  },
  computed: {
    userTramite: function () {
      let u = this.usuarios.find(u => u.id === this.dependencia.depe_idusuariotransp)
      return u
    },
    userReclamo: function () {
      let u = this.usuarios.find(u => u.id === this.dependencia.depe_idusuarioreclamo)
      return u
    },
    scheduleAsistance: function () {
      return this.dependencia.schedules.filter( d => d.type === 0)
    },
    scheduleMpv: function () {
      return this.dependencia.schedules.filter( d => d.type === 1)
    }
  },

  mounted() {
    if (this.$route.params.id > 0 || this.$route.params.id != null || this.dependenciaSede !== undefined) {
      this.obtenerDependencia()
    }
    this.getIpLocal()

  },

  methods: {
    processFile(e, tipo) {
      var este = this
      let f    = new FormData()
      f.append("file", e[0])
      return axios
      .post("/tramite/dependencias/upload", f, {
        headers: {"Content-Type": "multipart/form-data"}
      })
      .then(response => {
        if (tipo == 1) {
          este.imagen_header = response.data
        } else {
          este.imagen_footer = response.data
        }
      })
      .catch(e => {
        console.log("FAILURE!!")
      })
    },

    guardarDependencia() {
      this.$validator.validate().then(result => {
        if (result) {
          const params = {
            dependencia  : this.dependencia,
            imagen_header: this.imagen_header,
            imagen_footer: this.imagen_footer,
            tipo         : this.tipo
          }
          axios.post(this.routeGuardar, params).then(response => {
            console.log("guardado")
            if (this.tipo == 1) {
              this.$router.push("/tramite/administrador/dependencias")
            } else {
              document.location.href = '/tramite/inicio'
            }
          })
        } else {
          console.log("Incompleto")
        }
      })
    },

    obtenerDependencia() {
      let dependenciaId=this.dependenciaSede == undefined ? this.$route.params.id : this.dependenciaSede
      axios
      .get(this.routeGetDependencia.replace(/%s/g, dependenciaId))
      .then(response => {
        (this.dependencia = response.data)
        Usuario.getAll({
                         dependencia: dependenciaId,
                         select     : ['id', 'adm_name', 'adm_lastname']
                       }).then(response => {
          this.usuarios = []
          for (var i = 0; i < response.data.length; i++) {
            let u = response.data[i]
            this.usuarios.push({
                                 id  : u.id,
                                 name: u.adm_name + ' ' + u.adm_lastname
                               })
          }
        })
      })
    },

    imprimirImagen(id, tipo) {
      let f     = ""
      f += "iddependencia=" + id
      f += "&tipo=" + tipo
      let route = "/tramite/dependencias/print?" + f
      window.open(route, "Visor", "width=1000,height=750")
    },

    ipNew() {
      this.dependencia.ips.push({
                                  id: null,
                                  ip: null,
                                })
    },
    ipDelete(index) {
      this.dependencia.ips.splice(index, 1)
    },
    scheduleNew(type) {
      this.dependencia.schedules.push({
                                        id            : null,
                                        entry_time    : null,
                                        output_time   : null,
                                        status        : true,
                                        dependencia_id: null,
                                        type          : type
                                      })
    },
    scheduleDelete(schedule) {
      let index = this.dependencia.schedules.findIndex( d => d === schedule)
      this.dependencia.schedules.splice(index, 1)
    },
    getIpLocal () {
      return new Promise((resolve, reject) => {
        Assistance.ipPublicLocal().then(response => {
          this.ip = response.data.ip
          resolve(response)
        }).catch(() => {
          this.ip = '0.0.0.0'
        })
      })
    },
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
