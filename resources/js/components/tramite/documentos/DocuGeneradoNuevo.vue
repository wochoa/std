<template>
  <div class="panel-group container">
    <docu-expediente v-if="documento == null" :expediente="expediente" :viewer="true" @find="setExpediente" />
    <div v-if="documento == null && !edit" class="panel panel-info">
      <div class="panel-heading">DATOS DE LA PLANTILLA</div>
      <div class="panel-body">
        <div class="form-group" style="width: 100%">
          <div class="col-sm-12">
            <label class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-10">
              <select class="form-control" required @change="selecPlantilla($event)">
                <option :value="null">Seleccione</option>
                <option v-for="(p, index) in plantillas" :key="index" :value="index">
                  (Plantilla {{ p.plt_idadmin == null ? 'de Oficina' : 'Personal' }}) - {{ p.plt_nombre }}
                </option>
              </select>
            </div>

            <label class="col-sm-2 control-label">Referencias</label>
            <div class="col-sm-10">
              <DocuReferencias :referencias="plantilla.plt_referencias" :viewer="true" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <docu-principal
      v-if="(documento == null && plantilla.id != null) || edit"
      ref="documento"
      :prioridades="prioridades"
      :form-data="plantilla.plt_datos.documento"
      :usuario="usuario"
      :recepciones="recepciones"
      :origen-first="origenFirst"
      :plantilla="false"
      :viewer="true"
      :edit="edit"
      :derivaciones="plantilla.plt_derivaciones"
      :derivaciones2="derivaciones2"
      @loadOrigen="loadOrigen"
      @guardarDocumento="validarDocumento"
    />
    <div v-if="documento == null && plantilla.id != null" class="panel panel-info">
      <div class="panel-heading">PLANTILLA</div>
      <div class="panel-body">
        <div class="form-group" style="width: 100%">
          <div class="col-sm-12">
            <CKEditorDocument v-model="plantilla.plt_plantilla" @input="$refs.documento.markForGenerarDocumento()" />
          </div>
        </div>
      </div>
    </div>
    <div v-if="documento == null && plantilla.id != null" class="panel panel-info">
      <div class="panel-body text-right">
        <button type="button" class="btn btn-info" @click="validarDocumento">
          <span class="glyphicon glyphicon-floppy-saved"> Guardar</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import Vuex                   from 'vuex'
import DocuReferencias        from "@/js/components/tramite/documentos/DocuReferencias"
import CKEditorDocument                  from '../CKEditorDocument'
import {Documento, Operacion, Plantilla} from "@/js/store/models/documento"

export default {
  name      : 'DocuGeneradoNuevo',
  components: {
    DocuReferencias,
    CKEditorDocument
  },
  props     : {
    routeUsuariosDerivar   : {
      type   : String,
      default: ''
    },
    routeGuardarDocGenerado: {
      type   : String,
      default: ''
    },
    routeGetDocGenerado    : {
      type   : String,
      default: ''
    },
    routeGetDocumento      : {
      type   : String,
      default: ''
    },
    prioridades            : {
      type   : Array,
      default: () => []
    },
    routePlantillas        : {
      type   : String,
      default: ''
    },
    usuario                : {
      type   : Object,
      default: () => ({})
    },
    recepciones            : {
      type   : Array,
      default: () => []
    }
  },

  data() {
    return {
      expediente     : {
        iddocumentomain: null,
        doc            : []
      },
      isoDate        : null,
      derivaciones2  : [],
      plantilla      : {
        id              : null,
        plt_nombre      : null,
        plt_plantilla   : '',
        plt_datos       : {
          documento: {
            iddocumento              : null,
            docu_idexma              : null,
            docu_idprioridad         : null,
            docu_origen              : 1,
            docu_tipo                : null, //personal, de la oficina
            docu_iddependencia       : null,
            oficina                  : null,
            docu_firma               : null,
            docu_cargo               : null,
            docu_detalle             : null,
            docu_fecha_doc           : null,
            docu_siglas_doc          : null,
            docu_numero_doc          : null,
            docu_idusuario           : null,
            docu_idusuariodependencia: null,
            docu_emailorigen         : null,
            docu_idtipodocumento     : null,
            docu_proyectado          : null,
            docu_idrecepcion         : null,
            docu_folios              : null,
            docu_asunto              : null,
            docu_clastupa            : null,
            docu_diasatencion        : null,
            docu_archivo             : [],
            docu_dni                 : null,
            docu_telef               : null,
            docu_domic               : null,
            correlativo              : null,
            docu_contrasenia         : null
          },
          required : []
        },
        plt_referencias : [],
        plt_derivaciones: []
      },
      plantillas     : null,
      documento      : null,
      defaultFormData: {},
      edit           : false,
      origenFirst    : false
    }
  },
  computed: {
    ...Vuex.mapGetters(['getTipoDocumentoNombre'])
  },
  mounted() {
    this.obtenerDependenciaUser()

    var date     = new Date() // Or the date you'd like converted.
    this.isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString().slice(0, 10)

    this.defaultFormData = Object.assign({}, this.plantilla)
    this.resetear()
    this.getPlantillas()
    if (this.$route.name === 'DocuGeneradoEdit' || this.$route.name === 'DocuGeneradoEdit2') {
      this.obtenerDocGenerado()
    }
  },
  methods : {
    ...Vuex.mapActions(['obtenerDependenciaUser', 'validarHijo']),

    onReady(editor) {
      // Insert the toolbar before the editable area.
      editor.ui
      .getEditableElement()
      .parentElement.insertBefore(editor.ui.view.toolbar.element, editor.ui.getEditableElement())
    },
    selecPlantilla(event) {
      if (event.target.value != null && event.target.value !== '') {
        this.plantilla = this.plantillas[event.target.value]
        console.log(this.plantilla)
        this.plantilla.plt_derivaciones = this.plantilla.plt_derivaciones !== null ? this.plantilla.plt_derivaciones : []
        this.plantilla.plt_derivaciones = this.plantilla.plt_derivaciones.map(function (oper) {
          return Object.assign(Operacion.getDefault(),oper)
        })
        this.plantilla.plt_referencias                    = this.plantilla.plt_referencias !== null ? this.plantilla.plt_referencias : []
        this.plantilla.plt_datos.documento.docu_fecha_doc = this.isoDate
        this.plantilla.plt_datos.documento.docu_idexma    = this.defaultFormData.plt_datos.documento.docu_idexma
        this.plantilla.plt_datos.documento.docu_archivo   = []
      } else {
        this.plantilla = Object.assign({}, this.defaultFormData)
      }
    },
    getPlantillas() {
      const params = {todo: 'true'}
      Plantilla.getAll(params)
      .then(response => {
        this.plantillas = response.data
      })
    },
    setExpediente(expediente) {
      for (let i = 0; i < expediente.doc.length; i++) {
        let ref  = expediente.doc[i]
        let text = this.getTipoDocumentoNombre(ref.docu_idtipodocumento) + ' ' + (ref.docu_numero_doc != null ? ('000000' + ref.docu_numero_doc).slice(-6) : '____') + ' ' + ref.docu_siglas_doc
        this.plantilla.plt_referencias.push(text)
      }
      this.expediente                                      = Object.assign(this.expediente, expediente)
      //this.plantilla.plt_referencias                        = this.plantilla.plt_referencias.concat(this.expediente.doc)
      this.defaultFormData.plt_datos.documento.docu_idexma = this.expediente.iddocumentomain
      this.plantilla.plt_datos.documento.docu_idexma       = this.expediente.iddocumentomain
    },
    validarDocumento() {
      this.validarHijo({
                         context      : this,
                         afterValidate: this.guardarDocumento
                       })
    },
    guardarDocumento() {
      let generado       = this.plantilla.plt_datos.documento.docu_archivo.find(d => d.file_generado)
      let validarEdicion = true
      if (generado !== undefined && generado.edit && (this.$route.name === 'DocuGeneradoEdit' || this.$route.name === 'DocuGeneradoEdit2')) {
        validarEdicion = confirm('En caso el documento contenga una firma electrónica, esta se perderá! tendrá que firmarlo nuevamente!\n¿Desea continuar?')
      }
      if (validarEdicion) {
        if (this.edit || this.plantilla.plt_derivaciones.length > 0) {
          let params              = JSON.parse(JSON.stringify(this.plantilla))
          params.id               = this.edit ? params.id : null
          //params.plt_derivaciones = params.plt_derivaciones.concat(this.derivaciones2)
          axios.post(this.routeGuardarDocGenerado, params).then(response => {
            this.documento = response.data
            if (this.documento.status) {
              if (this.$route.name === 'DocuGeneradoEdit2') {
                this.$router.push({name: 'DocuBuscar'})
              } else {
                this.$router.push({name: 'DocuGeneradoBuscar'})
              }
            } else {
              alert('Hubo un error')
            }
          })

        } else {
          alert('Debe de tener por lo menos una derivacion!')
        }
      }
    },
    resetear() {
      this.plantilla                                  = Object.assign(this.plantilla, this.defaultFormData)
      this.plantilla.plt_derivaciones                 = []
      this.plantilla.plt_referencias                  = []
      this.plantilla.plt_datos.documento.docu_archivo = []
      this.documento                                  = null
    },
    loadOrigen() {
      this.origenFirst = false
    },
    obtenerDocGenerado() {
      this.edit = true

      axios.get(this.routeGetDocGenerado.replace(/%s/g, this.$route.params.id)).then(response => {
        let plantilla            = response.data
        this.plantilla.id        = plantilla.id
        if(plantilla.dgen_datos.documento.docu_archivo===undefined) {
          plantilla.dgen_datos.documento.docu_archivo = []
        }
        this.plantilla.plt_datos = plantilla.dgen_datos


        this.derivaciones2           = plantilla.dgen_datos.documento.operaciones !== undefined ? plantilla.dgen_datos.documento.operaciones : []
        this.plantilla.plt_plantilla = plantilla.dgen_html
        if (plantilla.dgen_datos.documento.iddocumento === undefined || plantilla.dgen_datos.documento.iddocumento === null) {
          this.plantilla.plt_derivaciones = plantilla.dgen_derivaciones !== null ? plantilla.dgen_derivaciones : plantilla.dgen_datos.derivaciones
        } else {
          this.plantilla.plt_derivaciones = []
        }
        this.plantilla.plt_referencias  = plantilla.dgen_referencias !== null ? plantilla.dgen_referencias : []
        this.expediente.iddocumentomain = plantilla.dgen_datos.documento.docu_idexma

        let generado = this.plantilla.plt_datos.documento.docu_archivo.find(d => d.file_generado)
        if (generado !== undefined) {
          generado.edit = false
        }

      })
    }
  }
}
</script>

<style scoped></style>
