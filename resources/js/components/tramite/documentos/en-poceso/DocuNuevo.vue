<template>
  <div class="panel-group container">
    <!--Modal -->
    <div id="nuevoRegistro" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Registro generado</h4>
          </div>
          <div class="modal-body">
            <div class="form-group text-center" style="font-size: 18px; height: 125px;">
              <div v-if="documento != null" class="col-sm-12">
                <div>Documento:</div>
                <div>
                  <strong>{{ getTipoDocumentoNombre(documento.docu_idtipodocumento) + ' ' }}{{ ('000000' +
                    documento.docu_numero_doc).slice(-6) }}
                    {{ documento.docu_origen == 1 ? '-' + documento.docu_fecha_doc.substr(0, 4) : '' }}{{
                    documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : '' }}
                  </strong>
                </div>
              </div>
              <div v-if="documento != null" class="col-sm-12">
                <div>Nuevo Reg. Documento:</div>
                <div>
                  <strong>{{ ('00000000' + documento.iddocumento).slice(-8) }}</strong>
                </div>
              </div>
              <div v-if="documento != null" class="col-sm-12">
                <div>Nuevo Reg. Expediente:</div>
                <div>
                  <strong>{{ ('00000000' + documento.docu_idexma).slice(-8) }}</strong>
                </div>
              </div>
              <div>.</div>
            </div>
            <strong v-if="show_digital_message" style="color: #fb6565;">¡Los documentos generados no
              contienen una firma electrónica!.</strong>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="moverSolicitados()">
              Explorar Documentos en proceso
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal" @click="show_digital_message=false;resetear">
              Registrar otro docuento
            </button>
          </div>
        </div>
      </div>
    </div>
    <!--Fin modal-->
    <form action="" @submit.prevent="validarDocumento()">
      <div class="panel panel-primary">
        <div class="panel-body">
          <docu-bloqueo v-if="!docBloqueados.status" :doc-bloqueados="docBloqueados" />
          <docu-expediente
            v-if="docBloqueados.status"
            ref="expediente"
            :expediente="expediente"
            :origen-first="origenFirst"
            @find="setExpediente"
          />
          <div v-if="docBloqueados.status" class="panel panel-primary">
            <div class="panel-body">
              <div class="form-group" style="width: 100%">
                <div class="col-sm-12">
                  <label v-if="!edit" class="col-sm-2 control-label">Plantilla</label>
                  <div v-if="!edit" class="col-sm-10">
                    <select class="form-control" required @change="selectPlantilla($event)">
                      <option :value="null">Sin plantilla</option>
                      <option v-for="(p, index) in plantillas" :key="index" :value="index">
                        (Plantilla {{ p.plt_idadmin == null ? 'de Oficina' : 'Personal' }}) - {{ p.plt_nombre }}
                      </option>
                    </select>
                  </div>

                  <label class="col-sm-2 control-label">Referencias</label>
                  <div class="col-sm-10">
                    <DocuReferencias :referencias="formData.docu_referencias" :viewer="true" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <docu-principal
            v-if="docBloqueados.status"
            ref="documento"
            style="margin-top: 5px;"
            :prioridades="prioridades"
            :form-data="formData"
            :default-form-data="defaultFormData"
            :usuario="usuario"
            :recepciones="recepciones"
            :route-invoker-get="routeInvokerGet"
            :route-invoker-post="routeInvokerPost"
            :route-webservice-ruc="routeWebserviceRuc"
            :route-webservice-dni="routeWebserviceDni"
            :origen-first="origenFirst"
            :derivaciones="derivaciones"
            :derivaciones2="derivaciones2"
            :saving="saving"
            :edit="edit"
            :can-super="canSuper"
            @loadOrigen="loadOrigen"
            @guardarDocumento="validarDocumento"
          />
        </div>
      </div>
    </form>
  </div>
</template>

<script>
  import Vuex                              from 'vuex'
  import {Documento, Operacion, Plantilla} from '@/js/store/models/documento'
  import DocuReferencias                   from "@/js/components/tramite/documentos/DocuReferencias"

  export default {

    name: 'DocuNuevo',

    components: {
      DocuReferencias,
    },
    props     : {
      prioridades       : {
        type   : Array,
        default: () => []
      },
      now               : {
        type   : String,
        default: ''
      },
      usuario           : {
        type   : Object,
        default: () => ({})
      },
      userId            : {
        type   : String,
        default: ''
      },
      recepciones       : {
        type   : Array,
        default: () => []
      },
      routeInvokerGet   : {
        type   : String,
        default: ''
      },
      routeInvokerPost  : {
        type   : String,
        default: ''
      },
      routeWebserviceDni: {
        type   : String,
        default: ''
      },
      routeWebserviceRuc: {
        type   : String,
        default: ''
      },
      routePlantillas   : {
        type   : String,
        default: ''
      },
      canSuper : {
        type: Boolean,
        default: false
      }
    },

    data() {
      return {
        expediente          : {
          iddocumentomain: null,
          doc            : []
        },
        defaultFormData     : {},
        formData            : {},
        derivaciones        : [],
        derivaciones2       : [],
        documento           : null,
        docBloqueados       : {},
        edit                : false,
        origenFirst         : false,
        saving              : false,
        docsRegistred       : [],
        plantillas          : null,
        plantilla           : Plantilla.getDefault(),
        isoDate             : null,
        show_digital_message: false,
      }
    },

    computed: {
      ...Vuex.mapGetters(['getDependenciaUser', 'getTipoDocumentoNombre'])
    },

    mounted() {
      let date                            = new Date() // Or the date you'd like converted.
      this.isoDate                        = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString().slice(0, 10)
      this.defaultFormData                = Documento.getDefault()
      this.defaultFormData.docu_fecha_doc = this.now
      this.defaultFormData.docu_fecha     = this.now
      this.defaultFormData.docu_idusuario = this.userId
      this.obtenerDependenciaUser().then(response => {
        this.montar()
      })
      this.getPlantillas()
      this.obtenerDocBloqueo()
      if (this.$route.name === 'DocuEdit') {
        this.obtenerDocumento()
      }      
      if (this.$route.name === 'DocuResponse') { 
        this.setExpedienteResponse()        
      }    
      this.montar() 
    },

    methods: {
      ...Vuex.mapActions(['obtenerDependenciaUser', 'validarHijo', 'ejecutarRecursivamente']),

      resetear() {
        this.formData              = Object.assign({}, this.defaultFormData)
        this.formData.docu_archivo = []
        this.derivaciones          = []
        this.expediente            = {
          iddocumentomain: null,
          doc            : []
        }
        this.ejecutarRecursivamente({
                                      context: this,
                                      after  : function (context) {
                                        context.$validator.reset()
                                      }
                                    })
      },
      montar() {
        this.defaultFormData.docu_iddependencia        = this.getDependenciaUser.iddependencia
        this.defaultFormData.oficina                   = this.getDependenciaUser.depe_nombre
        this.defaultFormData.docu_firma                = this.getDependenciaUser.depe_representante
        this.defaultFormData.docu_cargo                = this.getDependenciaUser.depe_cargo
        this.defaultFormData.docu_siglas_doc           = this.getDependenciaUser.depe_sigla
        this.defaultFormData.docu_idusuariodependencia = this.getDependenciaUser.iddependencia
        this.resetear()
      },
      setExpediente(expediente) {
        this.expediente           = expediente
        this.formData.docu_idexma = this.expediente.iddocumentomain
      },
      setExpedienteResponse() {
          Documento.show(this.$route.params.idrecepcion).then(response => {
          this.formData.docu_idexma = response.data.docu_idexma 
          this.expediente.iddocumentomain = this.formData.docu_idexma

        })
      },
      validarDocumento() {
        this.docsRegistred.push(this.formData)
        this.validarHijo({
                           context      : this,
                           afterValidate: this.guardarDocumento
                         })
      },
      guardarDocumento() {
        if (!this.saving) {
            const parameters   = {
              documento   : this.formData,
              derivaciones: this.derivaciones,
              operaciones : this.$route.name === 'DocuResponse'?this.$route.params.operaciones:[]
            }
          
          let generado       = this.formData.docu_archivo.find(d => d.file_generado)
          let validarEdicion = true
          if (generado !== undefined && generado.edit && this.$route.name === 'DocuEdit') {
            validarEdicion = confirm('En caso el documento contenga una firma electrónica, esta se perderá! tendrá que firmarlo nuevamente!\n¿Desea continuar?')
          }
          if (validarEdicion) {
            this.saving = true
            Documento.create(parameters)
            .then(response => {
              this.documento = response.data
              if (this.$route.params.id === 0 || this.$route.params.id == null || this.$route.name === 'DocuResponse') {
                this.$forceUpdate()
                if(this.$refs.documento.archivoPrincipalGenerado!==undefined)
                  this.show_digital_message=true
                this.resetear()
                $('#nuevoRegistro').modal({
                                            backdrop: 'static',
                                            keyboard: false
                                          })
              } else {
                this.moverSolicitados()
              }

              this.saving = false
            })
            .catch(error => {
              console.log('Ocurrio un error guardar el documento, verifique su conexion a internet e intentelo nuevamente')
              this.saving = false
            })
          }
        }
      },
      obtenerDocumento() {
        this.edit = true
        Documento.show(this.$route.params.id).then(response => {
          this.origenFirst                = true
          this.formData                   = response.data
          this.expediente.iddocumentomain = this.formData.docu_idexma
          this.derivaciones2              = this.formData.operaciones
          let generado                    = this.formData.docu_archivo.find(d => d.file_generado)
          if (generado !== undefined) {
            generado.edit = false
            Documento.getFileHtml(generado).then(response => {
              generado.file_html = response.data
            })
          }

        })
      },
      loadOrigen() {
        this.origenFirst = false
      },
      obtenerDocBloqueo() {
        Documento.getBloqueoDocumentos().then(response => {
          this.docBloqueados = response.data
          if (this.$route.name === 'DocuEdit') {
            this.docBloqueados.status = true
          }
        })
      },
      moverSolicitados() {
        this.$router.push('/tramite/enproceso')
      },
      getPlantillas() {
        const params = {todo: 'true'}
        Plantilla.getAll(params)
        .then(response => {
          this.plantillas = response.data
        })
      },
      selectPlantilla(event) {
        if (event.target.value != null && event.target.value !== '') {
          this.plantilla                                      = this.plantillas[event.target.value]
          this.plantilla.plt_derivaciones                     = this.plantilla.plt_derivaciones !== null ? this.plantilla.plt_derivaciones : []
          this.plantilla.plt_derivaciones                     = this.plantilla.plt_derivaciones.map(function (oper) {
            return Object.assign(Operacion.getDefault(), oper)
          })
          this.plantilla.plt_datos.documento.docu_referencias = this.plantilla.plt_referencias !== null ? this.plantilla.plt_referencias : []
          this.plantilla.plt_datos.documento.docu_fecha_doc   = this.isoDate
          this.plantilla.plt_datos.documento.docu_idexma      = this.expediente.iddocumentomain
          this.plantilla.plt_datos.documento.docu_archivo     = [
            {
              edit          : true,
              file_generado : true,
              file_html     : this.plantilla.plt_plantilla,
              file_mostrar  : true,
              file_name     : "Documento principal Generado",
              file_principal: true,
              file_tipo     : "application/pdf",
              file_size     : 0
            }]
          this.formData                                       = Object.assign(Documento.getDefault(), this.plantilla.plt_datos.documento)
          this.derivaciones                                   = [].concat(this.plantilla.plt_derivaciones)
          setTimeout(this.$refs.documento.chngTipo, 300)
        } else {
          this.plantilla = Plantilla.getDefault()
          this.resetear()
        }
      },
    }
  }
</script>

<style scoped></style>
