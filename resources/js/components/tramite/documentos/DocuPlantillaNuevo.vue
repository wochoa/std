<template>
  <div class="panel-group container">
    <div class="panel panel-primary">
      <div class="panel-body">
        <div v-if="documento == null" class="panel panel-primary">
          <div class="panel-body">
            <div class="form-group" style="width: 100%">
              <div :class="{ 'col-sm-12': true, 'has-error': errors.has('nombre') }">
                <label class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                  <input
                    ref="nombre"
                    v-model="formData.plt_nombre"
                    v-validate="'required'"
                    class="form-control"
                    type="text"
                    name="nombre"
                    @change="formData.plt_nombre = formData.plt_nombre.toUpperCase()"
                  />
                  <span v-show="errors.has('nombre')" class="help-block">{{ errors.first('nombre') }}</span>
                </div>


                <label class="col-sm-2 control-label">Referencias</label>
                <div class="col-sm-10">
                  <DocuReferencias :referencias="formData.plt_referencias" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <docu-principal
          v-if="documento == null"
          :prioridades="prioridades"
          style="margin-top: 5px;"
          :form-data="formData.plt_datos.documento"
          :derivaciones="formData.plt_derivaciones"
          :usuario="usuario"
          :recepciones="recepciones"
          :plantilla="true"
          @guardarDocumento="validarDocumento"
        />

        <div v-if="documento == null" class="panel panel-primary">
          <div class="panel-heading">PLANTILLA</div>
          <div class="panel-body">
            <div class="form-group" style="width: 100%">
              <div class="col-sm-12">
                <CKEditorDocument v-model="formData.plt_plantilla" />
              </div>
            </div>
          </div>
        </div>

        <div v-if="documento == null" class="panel panel-primary">
          <div class="panel-body text-right">
            <button class="btn btn-primary" type="button" @click="validarDocumento">
              <span class="glyphicon glyphicon-floppy-saved"> Guardar</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DocuReferencias  from './DocuReferencias'
import CKEditorDocument from '../CKEditorDocument'
import Vuex             from 'vuex'

export default {

  name      : 'DocuPlantillaNuevo',
  components: {
    DocuReferencias,
    CKEditorDocument
  },
  props     : {
    routeUsuariosDerivar : {
      type   : String,
      default: ''
    },
    routeGuardarPlantilla: {
      type   : String,
      default: ''
    },
    routeGetPlantilla    : {
      type   : String,
      default: ''
    },
    prioridades          : {
      type   : Array,
      default: () => []
    },
    recepciones          : {
      type   : Array,
      default: () => []
    },
    usuario              : {
      type   : Object,
      default: () => ({})
    },
    userId               : {
      type   : String,
      default: ''
    },
    csrf                 : {
      type   : String,
      default: ''
    }
  },

  data() {
    return {
      formData       : {
        id              : null,
        plt_nombre      : null,
        plt_plantilla   : '<div>&nbsp;</div><div>&nbsp;</div>'+
          '<p style="text-align:center;">documento firmado digitalmente</p>'+
          '<div style="text-align:center;"><strong>FIRMA</strong></div>'+
          '<div style="text-align:center;">CARGO</div>' +
          '<p>&nbsp;</p><div><strong>CC:</strong></div><div>ARCHIVO</div>',
        plt_datos       : {
          documento: {
            iddocumento              : null,
            docu_idexma              : null,
            docu_fecha               : null,
            docu_idprioridad         : 1,
            docu_origen              : 1,
            docu_tipo                : false, //personal, de la oficina
            docu_iddependencia       : null,
            oficina                  : null,
            docu_firma               : null,
            docu_cargo               : null,
            docu_detalle             : null,
            docu_fecha_doc           : null,
            docu_siglas_doc          : null,
            docu_numero_doc          : null,
            docu_idusuario           : this.userId,
            docu_idusuariodependencia: null,
            docu_idtipodocumento     : null,
            docu_proyectado          : null,
            docu_idrecepcion         : 1,
            docu_folios              : null,
            docu_asunto              : null,
            docu_clastupa            : 9,
            docu_diasatencion        : null,
            correlativo              : null,
            docu_archivo             : [],
            docu_dni                 : null,
            docu_telef               : null,
            docu_domic               : null,
            docu_contrasenia         : null
          },
          required : []
          //token_          :   this.csrf,
        },
        plt_referencias : [],
        plt_derivaciones: []
      },
      documento      : null,
      defaultFormData: {},
      edit           : false
    }
  },

  computed: {
    ...Vuex.mapGetters(['getDependenciaUser'])
  },

  created() {
    this.obtenerDependenciaUser().then(response => {
      this.montar()
    })
    this.defaultFormData = JSON.parse(JSON.stringify(this.formData))
    this.montar()
    if (this.$route.name === 'DocuPlantillaEdit') {
      this.obtenerPantilla()
    }
  },

  methods: {
    ...Vuex.mapActions(['obtenerDependenciaUser', 'validarHijo']),

    montar() {
      this.formData.plt_datos.documento.docu_iddependencia        = this.getDependenciaUser.iddependencia
      this.formData.plt_datos.documento.oficina                   = this.getDependenciaUser.depe_nombre
      this.formData.plt_datos.documento.docu_firma                = this.getDependenciaUser.depe_representante
      this.formData.plt_datos.documento.docu_cargo                = this.getDependenciaUser.depe_cargo
      this.formData.plt_datos.documento.docu_siglas_doc           = this.getDependenciaUser.depe_sigla
      this.formData.plt_datos.documento.docu_idusuariodependencia = this.getDependenciaUser.iddependencia
      this.resetear()
    },
    setExpediente(expediente) {
      this.expediente           = expediente
      this.formData.docu_idexma = this.expediente.iddocumentomain
    },

    validarDocumento() {
      var este = this
      this.$validator.validate().then(function (result) {
        if (result) {
          este.validarHijo({
                             context      : este,
                             afterValidate: este.guardarDocumento
                           })
        } else {
          este.$refs[este.errors.items[0].field].focus()
          este.validarHijo({
                             context      : este,
                             afterValidate: este.guardarDocumento,
                             status       : false,
                             focused      : true
                           })
        }
      }, function (error) {
        console.log('Error' + error)
      })
    },
    guardarDocumento() {
      //this.formData.token_=this.csrf;
      axios.post(this.routeGuardarPlantilla, this.formData).then(response => {
        this.documento = response.data

        if (this.documento.status) {
          this.$router.push('/tramite/plantilla')
        } else {
          alert('Hubo un error')
        }
      })
    },
    resetear() {
      this.formData                        = Object.assign({}, this.defaultFormData)
      this.formData.plt_datos.derivaciones = []
      this.documento                       = null
    },

    obtenerPantilla() {
      this.edit = true
      axios.get(this.routeGetPlantilla.replace(/%s/g, this.$route.params.id)).then(response => {
        this.formData           = Object.assign(this.formData, response.data)
        this.formData.plt_datos = this.formData.plt_datos
      })
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
