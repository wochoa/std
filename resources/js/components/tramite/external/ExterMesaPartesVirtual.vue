<template>
  <div>
    <nav class="navbar navbar-gorehco navbar-static-top" role="navigation">
      <div class="container">
        <div class="Navbar-wrapper">
          <a href="#" class="img">
            <img src="/img/logo1.png" alt="" />
          </a>
          <a href="" class="navbar-brand">{{ titulo }}</a>
          <!--<a href="/login" target="_blank" class="btn btn-sm btn-success">Buscar Expediente</a>-->
          <a href="http://digital.regionhuanuco.gob.pe/registro/mpv/obs/3" target="_blank" class="btn btn-danger btn-sm ">Ver estado de mi trámite</a>
        </div>
      </div>
    </nav>
    <div class="container">
      <div class="card card-principal mb-3">
        <div class="card-header font-weight-bold">MESA DE PARTES VIRTUAL</div>
        <div class="card-body">
          <h1 class="text-center">{{ nameDependencia }}</h1>
          <div class="form-group">
            <div v-if="!start && !formulario">
              <div v-if="formulario" class="card card-secundario  mb-3">
                <div class="card-header font-weight-bold">DEPENDENCIA</div>
                <div class="card-body">
                  <div class="form-group">
                    <div :class="{ 'col-sm-12': true, 'has-error': errors.has('dependencia') }">
                      <label class="text-left">Dependencia a remitir <span style="color:#FF0000">(*)</span></label>
                      <select
                        ref="dependencia"
                        v-model="formData.id_dependencia"
                        v-validate="'required'"
                        :class="{ 'col-sm-12': true, 'has-error': errors.has('dependencia') }"
                        class="form-control"
                        name="dependencia"
                        disabled
                      >
                        <option
                          v-for="(dependencia, indexDepe) in dependencias"
                          :key="indexDepe"
                          :value="dependencia.iddependencia"
                        >
                          {{ dependencia.depe_nombre }}
                        </option>
                      </select>
                      <span
                        v-show="errors.has('dependencia')"
                        class="help-block"
                      >{{ errors.first('dependencia') }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card card-secundario  mb-3">
                <div class="card-header font-weight-bold">
                <div class="col-sm-6">DATOS DEL REMITENTE </div>
                <div class="col-sm-6 text-right"> </div>
                   


                </div>
                <div class="card-body">
                  <div class="form-group">
                    <div class="form-row d-flex">
                      <div class="form-group col-md-6">
                        <label for="tipo">Tipo documento de identidad <span style="color:#FF0000">(*)</span></label>
                        <select
                          v-model="tipo"
                          v-validate="'required'"
                          :class="{ 'has-error': errors.has('tipo') }"
                          class="form-control"
                          name="tipo"
                        >
                          <option selected :value="1">DNI</option>
                          <option :value="0">RUC</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4" :class="{'has-error': errors.has('Numero de documento') }">
                        <label for="Numero de documento">Numero de documento <span
                          style="color:#FF0000">(*)</span></label>
                        <input
                          v-model="tipoNumero"
                          v-validate="'numeric|required|length:'+(tipo===1?8:11)"
                          type="text"
                          class="form-control"
                          name="Numero de documento"
                          placeholder="Numero de documento"
                          @keydown="registrarCorreos = false; tipoNumeroValidado=false"
                          @keypress.enter.prevent.stop="validar"
                        />
                        <span 
                          v-show="errors.has('Numero de documento')"
                          class="help-block"
                        >{{ errors.first('Numero de documento') }}</span>
                      </div>
                      <div class="form-group col-md-2">
                        <button class="btn btn-primary" @click="validar">Validar Documento</button>
                      </div>
                    </div>
                    <div class="form-row d-flex">
                      <div class="form-group col-md-12">
                        <label for="detalle">Entidad <span style="color:#FF0000">(*)</span></label>
                        <div :class="{'has-error': errors.has('detalle') }">
                          <input
                            id="detalle"
                            ref="detalle"
                            v-model="formData.docu_detalle"
                            v-validate="'required|max:60'"
                            type="text"
                            name="detalle"
                            class="form-control uppercase"
                          />
                          <span v-show="errors.has('detalle')" class="help-block">{{ errors.first('detalle') }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-row d-flex">
                      <div :class="{ 'col-md-6': true, 'has-error': errors.has('firma') }">
                        <label class="control-label">Firmante <span style="color:#FF0000">(*)</span></label>
                        <input
                          ref="firma"
                          v-model="formData.docu_firma"
                          v-validate="'required|max:60'"
                          type="text"
                          name="firma"
                          class="form-control uppercase"
                          @change="formData.docu_firma = formData.docu_firma.toUpperCase()"
                        />
                        <span v-show="errors.has('firma')" class="help-block">{{ errors.first('firma') }}</span>
                      </div>
                      <div :class="{ 'col-md-6': true, 'has-error': errors.has('direccion') }">
                        <label class="control-label">Dirección <span style="color:#FF0000">(*)</span></label>
                        <div>
                          <input
                            ref="direccion"
                            v-model="formData.docu_domic"
                            v-validate="'max:150'"
                            type="text"
                            name="direccion"
                            class="form-control uppercase"
                            @change="formData.docu_domic = formData.docu_domic.toUpperCase()"
                          />
                          <span
                            v-show="errors.has('direccion')"
                            class="help-block"
                          >{{ errors.first('direccion') }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-row d-flex">
                      <div :class="{ 'col-md-6': true, 'has-error': errors.has('celular') }">
                        <label class="control-label">Celular <span style="color:#FF0000">(*)</span></label>
                        <div>
                          <input
                            ref="celular"
                            v-model="formData.docu_telef"
                            v-validate="'required|numeric|digits:9'"
                            type="text"
                            class="form-control"
                            name="celular"
                          />
                          <span v-show="errors.has('celular')" class="help-block">{{ errors.first('celular') }}</span>
                        </div>
                      </div>
                      <div :class="{ 'col-md-6': true, 'has-error': errors.has('cargo') }">
                        <label class="control-label">Cargo</label>
                        <div>
                          <input
                            ref="cargo"
                            v-model="formData.docu_cargo"
                            v-validate="'max:70'"
                            type="text"
                            name="cargo"
                            class="form-control uppercase"
                            @change="formData.docu_cargo = formData.docu_cargo.toUpperCase()"
                          />
                          <span v-show="errors.has('cargo')" class="help-block">{{ errors.first('cargo') }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-4" :class="{'has-error': errors.has('email') }">
                        <label class="control-label">Correo electrónico <span style="color:#FF0000">(*)</span></label>
                        <div>
                          <select
                            ref="email"
                            v-model="formData.docu_emailorigen"
                            v-validate="'required'"
                            :class="{ 'col-sm-12': true, 'has-error': errors.has('email') }"
                            class="form-control"
                            name="email"
                          >
                            <option
                              v-for="(correo, indexDepe) in correosValidados"
                              :key="indexDepe"
                              :value="correo.correo"
                            >
                              {{ correo.correo }}
                            </option>
                          </select>
                          <span v-show="errors.has('email')" class="help-block">{{ errors.first('email') }}</span>
                        </div>
                      </div>
                      <div class="form-group col-md-2" style="margin-top: 30px;">
                        <button class="btn btn-primary" :disabled="!tipoNumeroValidado" @click="registrarCorreos=true">
                          Agregar correo
                        </button>
                      </div>
                      <div class="form-group col-md-6" :class="{'has-error': errors.has('Términos y Condiciones') }">
                        <label class="control-label">Términos y Condiciones 
                          <span
                            style="color:#FF0000"
                          >(*)</span>
                        </label>
                        <div>
                          <label class="control-label" style="font-weight:500;">
                            <input
                              v-validate="'required'"
                              type="checkbox"
                              name="Términos y Condiciones"
                            /> Acepto que las
                            comunicaciones del Gobierno Regional Huánuco sean enviadas a
                            la dirección de correo electrónico y celular que proporcione.</label>
                        </div>
                        <span v-show="errors.has('Términos y Condiciones')" class="help-block">{{ errors.first('Términos y Condiciones') }}</span>
                      </div>
                    </div>
                    <div v-if="correosNoValidados.length>0 && tipoNumeroValidado" class="form-row">
                      <div class="col-md-12">
                        <div class="alert alert-success">Se a enviado un código de validación a su correo electrónico,
                          <strong>introduzca el código</strong> para validar su correo electrónico <span style="color:red">(si demora y no le llega el código, revise que este bien digitado el correo electrónico e intente de nuevo, antes elimine el correo electrónico ingresado)</span>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <ul class="list-group">
                          <li
                            v-for="(correo, index) in correosNoValidados"
                            :key="'email_validate'+index"
                            class="list-group-item list-group-item-info"
                          >
                            <form @submit.prevent.stop="validarCorreo">
                              <div class="col-md-6 email">{{ correo.correo }}</div>
                              <div class="form-group col-md-2">
                                <input
                                  type="hidden"
                                  name="correo"
                                  class="form-control"
                                  :value="correo.correo"
                                />
                                <input
                                  name="codigo"
                                  class="form-control"
                                  style="text-transform: none;"
                                />
                              </div>
                              <div class="form-group col-md-1">
                                <button class="btn btn-primary" type="submit">Validar</button>
                              </div>
                              <div class="form-group col-md-1">
                                <button class="btn btn-danger" type="button" @click="eliminarCorreo(correo)">Eliminar
                                </button>
                              </div>
                            </form>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div v-if="registrarCorreos" class="form-row">
                      <div class="col-md-12">
                      </div>
                      <div class="col-md-6">
                        <input
                          ref="email"
                          v-model="email"
                          type="email"
                          name="email"
                          class="form-control"
                          placeholder="Ingrese su correo electrónico"
                        />
                      </div>
                      <div class="form-group col-md-2">
                        <button class="btn btn-primary" @click="agregarCorreo">Enviar código de validación</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card card-secundario mb-3">
                <div class="card-body">
                  <div class="col-sm-8" v-html="message" style="color: red"></div>
                  <div class="col-sm-2">
                    <a href="https://drive.google.com/file/d/1IDVAjkUBx3ykztO6qu2acKyb2OZwZG6N/view?usp=sharing" target="_blank">
                      <span class="icon icon-file-play fs-50" aria-hidden="true" style="font-size: 15px; margin-top: 10px"></span>Manual de usuario</a>
                  </div>
                  <button
                    class="btn btn-primary col-sm-2"
                    type="button"
                    :disabled="!tipoNumeroValidado"
                    @click="siguiente"
                  >
                    <span class="icon icon-redo2 fs-18">Continuar</span>
                  </button>
                </div>
              </div>
            </div>
            <FormDocumento
              v-if="!start && formulario"
              ref="formDocumento"
              :form-data="formData"
              :saving="saving"
              :upload-ready="uploadReady"
              :archivo-principal="archivoPrincipal"
              :archivos-anexo="archivosAnexo"
              :anexos="disableAnexo"
              :document-types="documentTypes"
              :progressbar="progressbar"
              :size-total="sizeTotal"
              @uploadPrincipal="submitFile($event, true)"
              @uploadAnexo="submitFile($event, false)"
              @ocultarFile="ocultarFile($event)"
              @form="form($event)"
              @guardarDocumento="guardarDocumento"
            />
            <!--Modal -->
            <div id="nuevoRegistro" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h4 class="modal-title">Registro generado</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <p>Estimado(a) Sr(a): <strong>{{ documento.docu_firma }}</strong>
                        Se le comunica a usted que se recibido su trámite.</p>
                      <p>Tan pronto como podamos nos pondremos en contacto con usted por medio del correo electrónico registrado.</p>
                      <ul>
                        <li><strong>Dependencia Remitida: </strong> {{ nameDependencia }}</li>
                        <li><strong>Asunto: </strong>{{ documento.docu_asunto }}</li>
                        <li><strong>Entidad: </strong>{{ documento.docu_detalle }}</li>
                        <li><strong>Firmante: </strong>{{ documento.docu_firma }}</li>
                        <li><strong>DNI: </strong>{{ documento.docu_dni }}</li>
                        <li><strong>RUC: </strong>{{ documento.docu_ruc }}</li>
                        <li><strong>Teléfono: </strong>{{ documento.docu_telef }}</li>
                        <li><strong>eMail: </strong>{{ documento.docu_emailorigen }}</li>
                      </ul>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                      Cerrar
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!--Modal -->
            <div id="hoursOpened" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Mesa de partes virtual - Hora: {{ currentTime }}</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group" v-html="message" style="color: red"></div>
                  </div>
                  <br />
                  <div class="modal-footer">
                       <a href="http://digital.regionhuanuco.gob.pe/registro/mpv/obs/3" target="_blank" class="btn btn-danger btn-sm ">Ver estado de mi trámite</a> 
                  </div>
                </div>
              </div>
            </div>
            <!--Modal -->
            <div id="registroPersona" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Registro de datos</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <div class="form-group col-md-12">
                        <label for="dni">DNI <span style="color:#FF0000">(*)</span></label>
                        <div :class="{'has-error': errors.has('dni') }">
                          <input
                            v-model="personaN.dni"
                            type="text"
                            name="dni"
                            class="form-control"
                            disabled
                          />
                          <span 
                            v-show="errors.has('dni')"
                            class="help-block"
                          >{{ errors.first('dni') }}</span>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <label for="prenombres">Nombres <span style="color:#FF0000">(*)</span></label>
                        <div :class="{'has-error': errors.has('prenombres') }">
                          <input
                            v-model="personaN.prenombres"
                            type="text"
                            name="prenombres"
                            class="form-control"
                          />
                          <span 
                            v-show="errors.has('prenombres')"
                            class="help-block"
                          >{{ errors.first('prenombres') }}</span>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <label for="apPrimer">Apellido paterno <span style="color:#FF0000">(*)</span></label>
                        <div :class="{'has-error': errors.has('apPrimer') }">
                          <input
                            v-model="personaN.apPrimer"
                            type="text"
                            name="apPrimer"
                            class="form-control"
                          />
                          <span v-show="errors.has('apPrimer')" class="help-block">{{ errors.first('apPrimer') }}</span>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <label for="apSegundo">Apellido materno <span style="color:#FF0000">(*)</span></label>
                        <div :class="{'has-error': errors.has('apSegundo') }">
                          <input
                            v-model="personaN.apSegundo"
                            type="text"
                            name="apSegundo"
                            class="form-control"
                          />
                          <span 
                            v-show="errors.has('apSegundo')"
                            class="help-block"
                          >{{ errors.first('apSegundo') }}</span>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <label for="direccion1">Direccion <span style="color:#FF0000">(*)</span></label>
                        <div :class="{'has-error': errors.has('direccion1') }">
                          <input
                            v-model="personaN.direccion1"
                            type="text"
                            name="direccion1"
                            class="form-control"
                          />
                          <span v-show="errors.has('direccion1')" class="help-block">{{ errors.first('direccion1') }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="modal-footer">

                    <button
                      type="button"
                      class="btn btn-primary"
                      :disabled="savingPersona"
                      @click="guardarPersona()"
                    >
                      <span v-if="!savingPersona" class="glyphicon glyphicon-floppy-saved"> Guardar</span>
                      <span v-else class="glyphicon glyphicon-send"> Guardando</span>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" :disabled="savingPersona">Cerrar
                    </button>
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
  import {md5}         from 'pure-md5'
  import File          from '@/js/api/tramite/documento'
  import FormDocumento from "@/js/components/tramite/external/FormDocumento"
  import {Persona}     from "@/js/store/models/persona"

  export default {
    name      : 'ExterMesaPartesVirtual',
    components: {FormDocumento},

    props: {
      formDataView         : {
        type   : Object,
        default: function () {
          return {}
        }
      },
      titulo               : {
        type   : String,
        default: ''
      },
      limit                : {
        type   : Number,
        default: 3
      },
      routePersonaDni      : {
        type   : String,
        default: ''
      },
      routeWebserviceRuc   : {
        type   : String,
        default: ''
      },
      routeGuardarDocumento: {
        type   : String,
        default: ''
      },
      persona              : {
        type   : Number,
        default: 182
      },
      empresa              : {
        type   : Number,
        default: 758
      },
    },

    data() {
      return {
        formData          : {
          id                       : null,
          docu_dni                 : '',
          docu_ruc                 : '',
          docu_firma               : '',
          docu_domic               : '',
          docu_detalle             : '',
          docu_cargo               : '',
          docu_telef               : '',
          docu_emailorigen         : '',
          docu_fecha_doc           : '',
          docu_idusuario           : '',
          docu_idusuariodependencia: '',
          docu_idtipodocumento     : 5,
          docu_numero_doc          : null,
          docu_siglas_doc          : '',
          docu_folios              : '',
          docu_asunto              : '',
          docu_archivo             : [],
          correlativo              : null,
          id_dependencia           : null,
          token                    : null,
        },
        max_size                  :41943040,
        uploading_size            :0,
        defaultFormData   : {},
        correos           : [],
        email             : null,
        documento         : {
          docu_firma : null,
          docu_asunto : null,
          docu_detalle : null,
          docu_dni : null,
          docu_ruc : null,
          docu_telef : null,
          docu_emailorigen : null
        },
        tipo              : 1,
        tipoNumero        : null,
        formulario        : false,
        start             : true,
        dependencias      : [],
        uploadReady       : true,
        saving            : false,
        origenFirst       : false,
        tipoNumeroValidado: false,
        registrarCorreos  : false,
        now               : new Date(),
        holidays          : [],
        schedules         : [],
        documentTypes     : [],
        message           : null,
        progressbar       : [],
        savingPersona     : false,
        personaN          : Persona.getDefault()
      }
    },
    computed: {
      correosValidados() {
        return this.correos.filter(correo => correo.estado === 1)
      },
      correosNoValidados() {
        return this.correos.filter(correo => correo.estado === 0)
      },
      archivoPrincipal() {
        return this.formData.docu_archivo.filter(d => d.file_principal && d.file_mostrar)
      },
      archivosAnexo() {
        return this.formData.docu_archivo.filter(d => !d.file_principal && d.file_mostrar)
      },
      disableAnexo() {
        return this.formData.docu_archivo.length === 0 || this.formData.docu_archivo.filter(d => d.file_principal && d.file_mostrar)[0] === undefined
      },
      verificarPrincipal() {
        if (this.formData.docu_archivo.length > 0) {
          return this.formData.docu_archivo.filter(d => d.file_principal && d.file_mostrar)[0] !== undefined
        } else {
          return true
        }
      },
      nameDependencia() {
        let sede = this.dependencias.filter(d => d.iddependencia === parseInt(this.$route.params.id))[0]
        if (sede !== undefined) {
          return sede.depe_nombre
        } else {
          return 'SEDE NO SELECCIONADO'
        }
      },
      currentTime() {
        let hours = this.now.getHours(), minutes = ('00' + this.now.getMinutes()).slice(-2),
            seconds                              = ('00' + this.now.getSeconds()).slice(-2)
        let suffix                               = 'AM'
        if (hours >= 12) {
          suffix = 'PM'
          hours  = hours - 12
        }
        if (hours === 0) {
          hours = 12
        }
        return hours + ':' + minutes + ':' + seconds + ' ' + suffix
      },
      hoursOpened() {

        let hours       = this.now.getHours(), minutes = ('00' + this.now.getMinutes()).slice(-2)
        let date        = new Date() // Or the date you'd like converted.
        let isoDate     = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
        let currentDate = isoDate.slice(0, 10)
        let day         = date.getDay() //0=Domingo; 6=Sabado
        let now         = hours + minutes / 60

        if (this.holidays.length > 0) {
          let holiday = this.holidays.filter(d => d.holiday === currentDate)[0]
          if (holiday !== undefined) {
            this.message = 'Hoy es un dia no laborable para la ' + this.nameDependencia
            return false
          }
        }
        if (day === 0 || day === 6) {
          this.message = 'Hoy es un dia no laborable para la ' + this.nameDependencia
          return false
        }
        if (this.schedules.length > 0) {
          let estado   = false
          this.message = '<div class="col-sm-3">Horario de atención:</div><ul class="col-sm-9">'
          for (let i = 0; i < this.schedules.length; i++) {
            let entry  = this.schedules[i].entry_time.split(':')
            entry      = parseFloat(entry[0]) + parseFloat(entry[1]) / 60 + parseFloat(entry[2]) / 3600
            let output = this.schedules[i].output_time.split(':')
            output     = parseFloat(output[0]) + parseFloat(output[1]) / 60 + parseFloat(output[2]) / 3600
            this.message += "<li>" + this.schedules[i].entry_time + ' hasta ' + this.schedules[i].output_time + "</li>"
            if (now >= entry && now <= output) {
              estado = true
            }
          }
          this.message += '</ul>'
          return estado

        } else {
          if (this.schedules.length === 0) {
            this.message = 'Horario de atención de 7:30 am a 3:30 pm'
            if (hours >= 16) {
              return false
            } else {
              if (hours <= 6) {
                return false
              } else {
                if (hours === 7 && 31 >= parseInt(minutes)) {
                  return false
                } else {
                  return !(hours === 15 && parseInt(minutes) >= 31)
                }
              }
            }
          }
        }
      },
      activeModal() {
        if (!this.hoursOpened && !this.formulario) {
          $('#hoursOpened').modal()
          return true
        }
        return false
      },
      sizeTotal() {
          return this.formData.docu_archivo.filter(d => d.file_mostrar).reduce((acc, obj) => {
            return parseFloat(acc) + parseFloat(obj.file_size)
          }, 0)+this.uploading_size
      }
    },

    created() {
      setInterval(() => {
        this.now = new Date()
      }, 1000)
    },

    updated: function () {
      this.$nextTick(() => {
        if (!this.hoursOpened && !this.formulario) {
          $('#hoursOpened').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                  })
        } else {
          $('#hoursOpened').modal('hide')
        }
      })
    },

    mounted() {
      this.defaultFormData         = Object.assign({}, this.formData)
      this.formData.id_dependencia = this.$route.params.id
      if (this.formDataView.docu_archivo !== undefined) {
        this.formData       = JSON.parse(JSON.stringify(this.formDataView))
        this.formData.token = null
        this.formulario     = true
      }
      let date                     = new Date() // Or the date you'd like converted.
      let isoDate                  = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
      this.formData.docu_fecha_doc = isoDate.slice(0, 10)
      axios.get('/tramite/dependencia/dependenciaMesaPartesVirtual').then(response => {
        this.dependencias = response.data
      })
      this.start   = false
      const params = {
        id: this.$route.params.id
      }
      axios.get('/tramite/dependencia/schedules', {params: params}).then(response => {
        this.holidays  = response.data.holidays
        this.schedules = response.data.schedules
      })
      axios.get('/tramite/tipoDocumento/mpv').then(response => {
        this.documentTypes = response.data
      })

    },
    methods: {
      ...Vuex.mapActions(['obtenerDocumentos', 'ejecutarRecursivamente']),
      siguiente() {
        this.$validator.validate().then(result => {
          let dependencia = this.dependencias.filter(d => d.iddependencia == this.formData.id_dependencia)[0]
          if (result && dependencia !== undefined && this.hoursOpened) {
            this.formulario = true
          } else {
            alert('Revise los datos ingresados')
          }
        })
      },
      validar() {
        if (this.tipoNumero !== '') {
          if (this.tipo === 1 && this.tipoNumero.length === 8) {
            axios.get(this.routePersonaDni.replace(/%s/g, this.tipoNumero)).then(response => {
              if (!response.data.error) {
                this.formData.docu_firma         = response.data.apPrimer + ' ' + response.data.apSegundo + ' ' + response.data.prenombres
                this.formData.docu_domic         = response.data.direccion
                this.formData.docu_iddependencia = this.persona
                this.formData.docu_dni           = this.tipoNumero
                this.formData.docu_detalle       = 'PERSONA NATURAL'
                this.correos                     = response.data.correos
                if (this.correos.length > 0) {
                  this.formData.docu_emailorigen = this.correos[0].correo
                }
                this.tipoNumeroValidado = true
              } else {
                alert('Regístrese en forma manual')
                this.personaN.dni = this.tipoNumero
                $("#registroPersona").modal({
                                              backdrop: 'static',
                                              keyboard: false
                                            })
                console.log('Regístrese en forma manual')
              }
            }, error => {
              alert('Ocurrio un error')
              console.log('Ocurrio un error')
            })
          } else {
            if (this.tipo === 0 && this.tipoNumero.length === 11) {
              axios.get(this.routeWebserviceRuc.replace(/%s/g, this.tipoNumero)).then(response => {
                if (response.data.desc_identi.indexOf('PERSONA NATURAL') >= 0) {
                  this.formData.docu_iddependencia = this.empresa
                } else {
                  this.formData.docu_iddependencia = this.persona
                }
                this.formData.docu_detalle = response.data.ddp_nombre
                this.formData.docu_domic   = response.data.ddp_nomvia + ' ' + response.data.ddp_nomzon + ' ' + response.data.ddp_numer1 + ' ' + response.data.ddp_refer1
                this.formData.docu_ruc     = this.tipoNumero
                this.correos               = response.data.correos
                if (this.correos.length > 0) {
                  this.formData.docu_emailorigen = this.correos[0].correo
                }
                this.tipoNumeroValidado = true
              }, error => {
                alert('No se encontro el RUC')
                this.formData.docu_ruc = null
              })
            } else {
              alert('El numero de documento esta mal.')
            }
          }
        } else {
          alert('Escriba correctamente')
        }
      },
      refresh() {
        if (this.formData.id != null) {
          this.$router.push({
                              name  : 'ExterMesaPartesVirtual',
                              params: {id: this.$route.params.id}
                            })
        }
        this.formulario            = false
        this.formData              = Object.assign({}, this.defaultFormData)
        this.tipoNumero            = null
        this.formData.docu_archivo = []
        this.correos               = []
        this.$validator.reset()
        this.ejecutarRecursivamente({
                                      context: this,
                                      after  : function (context) {
                                        context.$validator.reset()
                                      }
                                    })
        let date                     = new Date() // Or the date you'd like converted.
        let isoDate                  = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
        this.formData.docu_fecha_doc = isoDate.slice(0, 10)
        this.formData.id_dependencia = this.$route.params.id
      },
      submitFile(e, tipo) {
        if (e.length > 0) {
          return new Promise((resolve, reject) => {
           let warning_size=false
           let warning_type=false
            for (let i = 0; i < e.length; i++) {   
              if (e[i].type == 'application/pdf') {
                if(this.sizeTotal+e[i].size<=this.max_size){
                  this.uploading_size+=e[i].size
                  let archivo      = new File(e[i])
                  const reader     = new FileReader()
                  reader.onloadend = () => {
                    archivo.md5            = md5(reader.result)
                    archivo.file_principal = !!(tipo)
                    let index              = this.formData.docu_archivo.findIndex(d => d.md5 === archivo.md5)
                    if (index === -1) {
                      let progress = {p: 0}
                      this.progressbar.push(progress)
                      archivo.cargarFile(function (e) {
                        progress.p = Math.round((e.loaded * 100.0) / e.total)
                      }).then(response => {
                        this.progressbar.splice(this.progressbar.findIndex(e => e === progress), 1)
                        let d = archivo.getData()
                        if (response.data.status) {
                          d.file_url = response.data.data
                          this.formData.docu_archivo.push(d)
                        } else {
                          alert('Hubo un problema al momento de subir el archivo, revise que el archivo tenga un máximo de 10MB e intente denuevo')
                        }
                        this.uploading_size-=e[i].size
                        resolve(response)
                      }).catch(error => {
                        this.uploading_size-=e[i].size
                        this.progressbar.splice(this.progressbar.findIndex(e => e === progress), 1)
                      })
                    } else {
                      this.uploading_size-=e[i].size
                      if (!this.formData.docu_archivo[index].file_mostrar) {
                        this.formData.docu_archivo[index].file_mostrar = true
                      } else {
                        alert('El archivo que desea cargar, ya se encuentra cargada!')
                      }
                    }
                  }
                  reader.readAsDataURL(e[i])
                  this.uploadReady = false
                  this.$nextTick(() => {
                    this.uploadReady = true
                  })
                } else {
                  warning_size=true
                }    
              } else {
                warning_type = true
              } 
            }    
            if(warning_size){
              alert('El total de los archivos cargados supera los 40 MB permitidos')
            }
            if(warning_type){
              alert('Solo esta permitido formato PDF')
            }   
          })
        }
      },
      ocultarFile(url) {
        let index                                      = this.formData.docu_archivo.findIndex(d => d.file_url === url)
        this.formData.docu_archivo[index].file_mostrar = false
      },
      guardarPersona() {
        this.savingPersona = true
        Persona.create(this.personaN).then(response => {
          this.formData.docu_firma         = response.data.apPrimer + ' ' + response.data.apSegundo + ' ' + response.data.prenombres
          this.formData.docu_domic         = response.data.direccion
          this.formData.docu_iddependencia = this.persona
          this.formData.docu_dni           = this.tipoNumero
          this.formData.docu_detalle       = 'PERSONA NATURAL'
          this.correos                     = response.data.correos
          if (this.correos.length > 0) {
            this.formData.docu_emailorigen = this.correos[0].correo
          }
          this.tipoNumeroValidado = true
          $('#registroPersona').modal('hide')
          this.savingPersona = false
        })
        .catch(function () {
          this.savingPersona = false
        })
      },
      guardarDocumento() {
        this.$refs.formDocumento.$validator.validate().then(result => {
          if (result) {
            if (this.formData.docu_archivo.length > 0 && this.verificarPrincipal) {
              if (!this.saving) {
                this.saving = true
                this.$recaptcha('login').then(token => {
                  this.formData.token = token
                  axios.post(this.routeGuardarDocumento, this.formData).then(response => {
                    if (response.data.status) {
                      this.documento = response.data.documento
                      $('#nuevoRegistro').modal()
                      this.refresh()
                      this.saving = false
                    } else {
                      alert('Hubo un problema, revise los datos rellenados o su internet')
                      this.saving = false
                    }                   
                  })
                })
              }
            } else {
              alert('Debe de cargar el documento principal antes de los anexos en formato PDF para continuar')
            }
          }
        })
      },
      agregarCorreo() {
        if (confirm('Esta seguro que el correo electrónico '+this.email+' Esta bien escrito?')) {
          if (this.email == null || this.email == ''){
            alert('Ingrese antes el correo electrónico')
          } else {         
            axios.post("/tramite/persona/dni/" + this.tipoNumero + "/registrarCorreo", {
              correo: this.email,
              tipo  : this.tipo
            }).then(response => {
              if (response.data.status) {
                if (response.data.error == null){
                  this.correos = response.data.correo
                } else {
                  alert(response.data.error)
                }
                this.email            = null
                this.registrarCorreos = false
              } else {
                alert('Registre bien el email')
              }
            })
            
          }
        }        
      },
      validarCorreo($e) {
        if($e.target[1].value != "") {
          let params = {
            correo: $e.target[0].value,
            codigo: $e.target[1].value,
            tipo  : this.tipo
          }
          axios.post("/tramite/persona/dni/" + this.tipoNumero + "/validateCorreo", params).then(response => {
            if (!response.data.status) {
              alert('El código no corresponde')
            } else {
              this.correos                   = response.data.correos
              this.formData.docu_emailorigen = $e.target[0].value
            }
          })
        } else {
          alert('Digite el código')
        }
        
      },
      eliminarCorreo(correo) {
        if (confirm('Esta seguro de eliminar el correo electrónico?')) {
          let params = {
            tipo: this.tipo
          }
          return axios.delete("/tramite/persona/dni/" + this.tipoNumero + "/eliminarCorreo" + '/' + correo.id, {params: params}).then(response => {
            this.correos = response.data
          })
        }        
      },
      form(e) {
        this.formulario = e
      }
    }
  }
</script>

<style scoped>
  .uppercase {
    text-transform: uppercase;
  }
  

  .card-principal {
    background-color: white;
    border-color: #00afef;
  }

  .card-principal .card-header {
    background-color: #00afef9c !important;
  }

  .card-secundario {
    background-color: white;
    border-color: #f58634;
  }

  .card-secundario .card-header {
    background-color: #f586349e !important;
  }

  li {
    height: 37px;
    padding: 0px;
  }

  li .email {
    padding: 6px 10px;
  }
</style>
