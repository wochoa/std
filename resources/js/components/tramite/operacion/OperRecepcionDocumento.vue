<template>
  <div class="row">
    <div class="col-sm-12">
      <docu-expediente :expediente="expediente" @find="setExpediente" />
      <div class="panel-group">
        <div class="panel panel-primary">
          <div class="panel-heading">Recepcion Documento</div>
          <div class="panel-body">
            <form action="" @submit.prevent="generarRegistro()">
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div :class="{ 'col-sm-6': true, 'has-error': errors.has('dni') }">
                  <label class="control-label">DNI</label>
                  <input
                    ref="dni"
                    v-model="formData.docu_dni"
                    v-validate="'numeric|digits:8'"
                    class="form-control"
                    type="text"
                    name="dni"
                    @change="validarDNI"
                  />
                  <span v-show="errors.has('dni')" class="help-block">{{ errors.first('dni') }}</span>
                </div>
                <div class="col-sm-6">
                  <label class="control-label">Nombre</label>
                  <input
                    v-model="formData.docu_firma"
                    type="text"
                    class="form-control"
                    @change="formData.docu_firma = formData.docu_firma.toUpperCase()"
                  />
                </div>
                <div :class="{ 'col-sm-6': true, 'has-error': errors.has('ntelf') }">
                  <label class="control-label">Telefono</label>
                  <input
                    ref="ntelf"
                    v-model="formData.docu_telef"
                    v-validate="'numeric|digits:9'"
                    type="text"
                    name="ntelf"
                    class="form-control"
                  />
                  <span v-show="errors.has('ntelf')" class="help-block">{{ errors.first('ntelf') }}</span>
                </div>
                <div class="col-sm-6">
                  <label>Dirección</label>
                  <input
                    v-model="formData.docu_domic"
                    type="text"
                    class="form-control"
                    @change="formData.docu_domic = formData.docu_domic.toUpperCase()"
                  />
                </div>
              </div>
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-success btn-block" :disabled="saving">
                    <span :class="{ glyphicon: true, 'glyphicon-ok': !saving, 'glyphicon-send': saving }"></span>
                    Generar Registro
                  </button>
                </div>
              </div>
            </form>
            <!--Modal -->
            <div id="nuevoRegistro" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Registro generado</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Nuevo Reg. Documento</label>
                      <ul v-if="documento != null">
                        {{
                          ('00000000' + documento.iddocumento).slice(-8)
                        }}
                      </ul>
                    </div>
                    <div class="form-group">
                      <label>Nuevo Reg. Expediente</label>
                      <ul v-if="documento != null">
                        {{
                          ('00000000' + documento.docu_idexma).slice(-8)
                        }}
                      </ul>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'
export default {

  props:{
          routeGuardarDocumento:{
              type: String,
              default: ''
            },
          now: {
              type: String,
              default: ''
            },
          userId: {
              type: String,
              default: ''
            },
          userDependencia: {
              type: String,
              default: ''
            }
        },

  data() {
    return {
      formData: {
        iddocumento: null,
        docu_idexma: null,
        docu_idprioridad: 1,
        docu_origen: 2,
        docu_tipo: false, //personal, de la oficina
        docu_iddependencia: null,
        //oficina                     :this.unidad.depe_nombre,
        docu_firma: null,
        docu_cargo: null,
        docu_detalle: null,
        docu_fecha_doc: this.now,
        docu_siglas_doc: null,
        docu_numero_doc: '0',
        docu_idusuario: this.userId,
        docu_idusuariodependencia: this.userDependencia,
        docu_idtipodocumento: null,
        docu_proyectado: null,
        docu_idrecepcion: 1,
        docu_folios: null,
        docu_asunto: null,
        docu_clastupa: 9,
        docu_diasatencion: null,
        docu_archivo: [],
        docu_dni: null,
        docu_telef: null,
        docu_domic: null,
        docu_emailorigen: null,
        correlativo: null,
        docu_referencias : []
      },
      expediente: { iddocumentomain: null, doc:[] },
      documento: null,
      derivaciones: [],
      defaulfFormData: null,
      saving: false
    }
  },

  computed: {
    ...Vuex.mapGetters(['getRuta'])
  },

  mounted() {
    this.defaultFormData = Object.assign({}, this.formData)
  },

  methods: {
    setExpediente(expediente) {
      this.expediente = expediente
      this.formData.docu_idexma = this.expediente.iddocumentomain
    },

    generarRegistro() {
      this.$validator.validate().then(result => {
        if (result) {
          if (confirm('Esta seguro de generar un nuevo registro?')) {
            const params = {
              documento: this.formData,
              derivaciones: this.derivaciones,
              operaciones : []
            }
            if (!this.saving) {
              this.saving = true
              axios.post(this.routeGuardarDocumento, params).then(response => {
                this.documento = response.data
                $('#nuevoRegistro').modal()
                console.log('Generado Nuevo')
                this.expediente = { iddocumentomain: null, doc:[] }
                this.formData = Object.assign({}, this.defaultFormData)
                this.saving = false
              })
            }
          }
        } else {
          console.log('incompleto')
        }
      })
    },
    validarDNI() {
      if (this.formData.docu_dni !== null && this.formData.docu_dni.length === 8) {
        axios.get(this.getRuta('tramite.persona.dni').replace(/%s/g, this.formData.docu_dni)).then(
          response => {
            if (!response.data.error) {
              this.formData.docu_firma =
                response.data.apPrimer + ' ' + response.data.apSegundo + ' ' + response.data.prenombres
              this.formData.docu_domic = response.data.ubigeo + ' ' + response.data.direccion
            }
          },
          error => {
            alert('DNI no encontrado en Padrón Electoral')
            //this.formData.docu_dni = null;
          }
        )
      }
    }
  }
}
</script>

<style scoped>
.modal-body {
  font-size: 25px;
}
input,
textarea {
  text-transform: uppercase;
}
</style>
