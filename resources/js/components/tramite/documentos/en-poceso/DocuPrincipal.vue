<template>
  <div>
    <form action="" @submit.prevent="guardarDocumento()">
      <div :class="'panel ' + (viewer ? 'panel-info' : 'panel-primary')">
        <div class="panel-body">
          <div class="form-group" style="width: 100%">
            <div class="col-sm-12">
              <label class="col-sm-2 control-label">Forma de Registro:</label>
              <div v-if="viewer || edit" class="col-sm-4">
                <strong>{{ parseInt(formData.docu_origen) === 2 ? 'Externo' : 'Interno' }}</strong>
              </div>
              <div v-else class="col-sm-4">
                <label class="radio-inline">
                  <input
                    v-model="formData.docu_origen"
                    type="radio"
                    value="1"
                    class="radio-inline"
                    @change="chngOrigen(1)"
                  />
                  Interno
                </label>
                <label v-if="!plantilla" class="radio-inline">
                  <input
                    v-model="formData.docu_origen"
                    type="radio"
                    value="2"
                    class="radio-inline"
                    @change="chngOrigen(2)"
                  />
                  Externo
                </label>
              </div>

              <div class="col-sm-6">
                <input id="invalidCheck" v-model="formData.docu_digital" class="form-check-input" type="checkbox" />
                <label class="form-check-label" for="invalidCheck">
                  Tramite Electrónico
                </label>
              </div>
            </div>
            <!--MOSTRAR OCULTO-->
            <div
              v-show="parseInt(formData.docu_origen) === 2"
              :class="{ 'col-sm-12': true, 'has-error': errors.has('entidad') }"
            >
              <label class="col-sm-2 control-label">Entidad:</label>
              <div class="col-sm-1">
                <!--id-->
                <input v-model="formData.docu_iddependencia" type="text" class="form-control" />
              </div>
              <div class="col-sm-6">
                <select v-model="formData.docu_iddependencia" class="form-control">
                  <option
                    v-for="(unidad, indexEntidad) in getEntidadesExternas"
                    :key="indexEntidad"
                    :value="unidad.iddependencia"
                  >
                    {{ unidad.depe_nombre }}
                  </option>
                </select>
                <span v-show="errors.has('entidad')" class="help-block">{{ errors.first('entidad') }}</span>
              </div>
            </div>

            <input v-model="formData.docu_iddependencia" type="hidden" />
            <div v-show="parseInt(formData.docu_origen) === 2" class="col-sm-12">
              <label class="col-sm-2 control-label">DNI:</label>
              <div class="col-sm-7">
                <!-- dependencia-->
                <input
                  ref="dni"
                  v-model="formData.docu_dni"
                  type="text"
                  class="form-control"
                  name="dni"
                  placeholder="DNI"
                  @change="validarDNI"
                />
              </div>
            </div>
            <div v-show="parseInt(formData.docu_origen) === 2" class="col-sm-12">
              <label class="col-sm-2 control-label">Detalle:</label>
              <div :class="{ 'col-sm-7': true, 'has-error': errors.has('detalle') }">
                <!-- dependencia-->
                <input
                  ref="detalle"
                  v-model="formData.docu_detalle"
                  v-validate="'max:60'"
                  type="text"
                  name="detalle"
                  class="form-control"
                  @change="formData.docu_detalle = formData.docu_detalle.toUpperCase()"
                />
                <span v-show="errors.has('detalle')" class="help-block">{{ errors.first('detalle') }}</span>
              </div>
              <div class="col-sm-3">
                <input
                  ref="ruc"
                  v-model="formData.docu_ruc"
                  type="text"
                  class="form-control"
                  name="ruc"
                  placeholder="RUC"
                  @keyup="validarRUC"
                />
              </div>
            </div>
            <!--FIN MOSTRAR OCULTO-->
            <div
              v-if="parseInt(formData.docu_origen) === 1 && ((viewer && formData.docu_tipo) || !viewer)"
              class="col-sm-12"
            >
              <label class="col-sm-2 control-label">Tipo</label>
              <div v-if="viewer" class="col-sm-7">
                <strong>{{ formData.docu_tipo ? 'Documento Personal' : '' }}</strong>
              </div>
              <div v-else class="col-sm-7">
                <label class="checkbox-inline">
                  <input
                    v-model="formData.docu_tipo"
                    type="checkbox"
                    name="docu_tipo"
                    :disabled="edit"
                    @change="chngTipo()"
                  />Documento Personal</label>
              </div>
            </div>
            <div v-if="parseInt(formData.docu_origen) === 1" class="col-sm-12">
              <label class="col-sm-2 control-label">Unidad Org</label>
              <div class="col-sm-7">
                <div>{{ formData.docu_iddependencia + ' - ' + getDependenciaNombre(formData.docu_iddependencia) }}</div>
              </div>
            </div>
            <div :class="{ 'col-sm-12': true, 'has-error': errors.has('firma') }">
              <label class="col-sm-2 control-label">Firma</label>
              <div class="col-sm-7">
                <div v-show="parseInt(formData.docu_origen) === 1">{{ formData.docu_firma }}</div>
                <input
                  v-show="parseInt(formData.docu_origen) !== 1"
                  ref="firma"
                  v-model="formData.docu_firma"
                  v-validate="'required|max:60'"
                  type="text"
                  name="firma"
                  class="form-control"
                  @change="formData.docu_firma = formData.docu_firma.toUpperCase()"
                />
                <span v-show="errors.has('firma')" class="help-block">{{ errors.first('firma') }}</span>
              </div>
            </div>
            <div :class="{ 'col-sm-12': true, 'has-error': errors.has('cargo') }">
              <label class="col-sm-2 control-label">Cargo</label>
              <div class="col-sm-7">
                <div v-show="parseInt(formData.docu_origen) === 1">{{ formData.docu_cargo }}</div>
                <input
                  v-show="parseInt(formData.docu_origen) !== 1"
                  ref="cargo"
                  v-model="formData.docu_cargo"
                  v-validate="'required|max:70'"
                  type="text"
                  name="cargo"
                  class="form-control"
                  @change="formData.docu_cargo = formData.docu_cargo.toUpperCase()"
                />
                <span v-show="errors.has('cargo')" class="help-block">{{ errors.first('cargo') }}</span>
                <div v-if="parseInt(formData.docu_origen) === 1">{{ formData.docu_telef }}</div>
              </div>
            </div>

            <div
              v-show="parseInt(formData.docu_origen) !== 1"
              :class="{ 'col-sm-12': true, 'has-error': errors.has('celular') }"
            >
              <label class="col-sm-2 control-label">Celular</label>
              <div class="col-sm-7">
                <input
                  ref="celular"
                  v-model="formData.docu_telef"
                  v-validate="'numeric|digits:9'"
                  type="text"
                  class="form-control"
                  name="celular"
                />
                <span v-show="errors.has('celular')" class="help-block">{{ errors.first('celular') }}</span>
              </div>
            </div>
            <div
              v-show="parseInt(formData.docu_origen) !== 1"
              :class="{ 'col-sm-12': true, 'has-error': errors.has('correo') }"
            >
              <label class="col-sm-2 control-label">Correo electrónico</label>
              <div class="col-sm-7">
                <input
                  ref="correo"
                  v-model="formData.docu_emailorigen"
                  v-validate="'email'"
                  type="email"
                  class="form-control"
                  name="correo"
                />
                <span v-show="errors.has('correo')" class="help-block">{{ errors.first('correo') }}</span>
              </div>
            </div>
            <div
              v-show="parseInt(formData.docu_origen) !== 1"
              :class="{ 'col-sm-12': true, 'has-error': errors.has('direccion') }"
            >
              <label class="col-sm-2 control-label">Dirección</label>
              <div class="col-sm-7">
                <input
                  ref="direccion"
                  v-model="formData.docu_domic"
                  v-validate="'max:150'"
                  type="text"
                  name="direccion"
                  class="form-control"
                  @change="formData.docu_domic = formData.docu_domic.toUpperCase()"
                />
                <span v-show="errors.has('celular')" class="help-block">{{ errors.first('direccion') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div :class="'panel ' + (viewer ? 'panel-info' : 'panel-primary')">
        <div class="panel-body">
          <div class="form-group" style="width: 100%;">
            <div v-if="!plantilla" class="col-sm-12">
              <label class="col-sm-2 control-label">Fecha Documento</label>
              <div class="col-sm-4">
                <input
                  id="docu_fecha_doc"
                  v-model="formData.docu_fecha_doc"
                  type="date"
                  class="form-control"
                  name="docu_fecha_doc"
                />
              </div>
            </div>
            <div
              v-if="!(viewer || (edit && parseInt(formData.docu_origen) === 1))"
              :class="{ 'col-sm-12': true, 'has-error': errors.has('tipo de documento') }"
            >
              <label class="col-sm-2 control-label">Tipo de Documento</label>
              <div class="col-sm-7">
                <div v-if="edit && parseInt(formData.docu_origen) !== 2">
                  {{ getTipoDocumentoNombre(formData.docu_idtipodocumento) }}
                </div>
                <select
                  v-if="!(edit && parseInt(formData.docu_origen) !== 2)"
                  ref="tipo de documento"
                  v-model="formData.docu_idtipodocumento"
                  v-validate="'required'"
                  :class="{ 'col-sm-12': true, 'has-error': errors.has('tipo de documento') }"
                  class="form-control"
                  name="tipo de documento"
                  @change="chngTipoDocumento()"
                >
                  <option
                    v-for="(tipoDocumento, indexTipo) in getTiposDocumento"
                    :key="indexTipo"
                    :value="tipoDocumento.idtdoc"
                  >
                    {{ tipoDocumento.tdoc_descripcion }}
                  </option>
                </select>
                <span v-show="errors.has('tipo de documento')" class="help-block">{{
                  errors.first('tipo de documento')
                }}</span>
              </div>
            </div>
            <div v-if="viewer || (edit && parseInt(formData.docu_origen) === 1)" class="col-sm-12">
              <label class="col-sm-2 control-label">Documento</label>
              <div class="col-sm-7">
                <div>
                  {{ nroDocumento }}
                </div>
              </div>
            </div>
            <div
              v-show="!(viewer || (edit && parseInt(formData.docu_origen) === 1))"
              :class="{ 'col-sm-12': true, 'has-error': errors.has('numero de documento') || errors.has('siglas') }"
            >
              <label class="col-sm-2 control-label">{{ !plantilla ? 'Número y ' : '' }}Siglas</label>
              <div v-if="!plantilla" class="col-sm-2">
                <input
                  ref="numero de documento"
                  v-model="formData.docu_numero_doc"
                  v-validate="'numeric'"
                  type="text"
                  class="form-control text-right"
                  :readonly="existCorrelativo"
                  name="numero de documento"
                />
                <span v-show="errors.has('numero de documento')" class="help-block">{{
                  errors.first('numero de documento')
                }}</span>
              </div>
              <div class="col-sm-8">
                <input
                  ref="siglas"
                  v-model="formData.docu_siglas_doc"
                  v-validate="'max:65'"
                  type="text"
                  name="siglas"
                  class="form-control"
                  :readonly="parseInt(formData.docu_origen) === 1"
                  @change="formData.docu_siglas_doc = formData.docu_siglas_doc.toUpperCase()"
                />
                <span v-show="errors.has('siglas')" class="help-block">{{ errors.first('siglas') }}</span>
              </div>
            </div>
            <div v-if="!plantilla && formData.docu_proyectado != null" class="col-sm-12">
              <label class="col-sm-2 control-label">Proyectado Por</label>
              <div class="col-sm-7">
                <input v-model="formData.docu_proyectado" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-sm-12">
              <label class="col-sm-2 control-label">Forma Recepción</label>
              <div class="col-sm-4">
                <div v-if="viewer || edit">{{ recepcion }}</div>
                <select v-else v-model="formData.docu_idrecepcion" class="form-control" @change="chngTipoDocumento()">
                  <option
                    v-for="(recepcion, indexRecep) in recepciones"
                    :key="indexRecep"
                    :value="recepcion.idrecepcion"
                  >
                    {{ recepcion.rece_descripcion }}
                  </option>
                </select>
              </div>
              <label for="docu_idprioridad" class="col-sm-2 control-label">Prioridad</label>
              <div id="docu_idprioridad" class="col-sm-4">
                <div v-if="viewer">{{ prioridad }}</div>
                <select v-else v-model="formData.docu_idprioridad" class="form-control">
                  <option
                    v-for="(prioridad, indexPriori) in prioridades"
                    :key="indexPriori"
                    :value="prioridad.idprioridad"
                  >
                    {{ prioridad.prio_descripcion }}
                  </option>
                </select>
              </div>
            </div>
            <div :class="{ 'col-sm-12': true, 'has-error': errors.has('folios') }">
              <label class="col-sm-2 control-label">Folios</label>
              <div class="col-sm-4">
                <input
                  ref="folios"
                  v-model="formData.docu_folios"
                  v-validate="'required'"
                  type="number"
                  class="form-control"
                  name="folios"
                />
                <span v-show="errors.has('folios')" class="help-block">{{ errors.first('folios') }}</span>
              </div>
            </div>
            <div :class="{ 'col-sm-12': true, 'has-error': errors.has('asunto') }">
              <label class="col-sm-2 control-label">Asunto</label>
              <div class="col-sm-10">
                <textarea
                  ref="asunto"
                  v-model="formData.docu_asunto"
                  v-validate="'required|max:750'"
                  name="asunto"
                  class="form-control"
                  @change="
                    formData.docu_asunto = formData.docu_asunto.toUpperCase()
                    markForGenerarDocumento()"
                ></textarea>
                <span v-show="errors.has('asunto')" class="help-block">{{ errors.first('asunto') }}</span>
              </div>
            </div>
            <div
              v-if="
                ((!plantilla && !viewer && $route.name != 'DocuGeneradoEdit') ||
                  (edit && $route.name != 'DocuGeneradoEdit')) && archivoPrincipal.length<1 && showInputFile
              "
              class="col-sm-12"
            >
              <label class="col-sm-2 control-label">Archivo</label>
              <div class="col-sm-2" style="position:relative;">
                <button class="btn btn-sm btn-success" type="button">
                  Agregar archivo principal
                  <input
                    v-if="uploadReady"
                    ref="fileInput"
                    type="file"
                    style="position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:&quot;progid:DXImageTransform.Microsoft.Alpha(Opacity=0)&quot;;opacity:0;background-color:transparent;color:transparent;"
                    size="40"
                    name="docu_archivo"
                    accept=".pdf"
                    @change="submitFile($event.path[0].files, true)"
                  />
                </button>
              </div>
              <div class="col-sm-8">
                <label class="control-label">(Para el documento principal el formato es PDF)</label>
              </div>
              <div class="col-sm-2" style="position:relative;"></div>
              <div class="col-sm-2" style="position:relative;">
                <button class="btn btn-sm btn-info" type="button" @click="generarDocumento">
                  Generar documento principal
                </button>
              </div>
            </div>
            <div
              v-if="
                ((!plantilla && !viewer && $route.name != 'DocuGeneradoEdit') ||
                  (edit && $route.name != 'DocuGeneradoEdit')) && archivosAnexo.length<4 && showInputFile
              "
              class="col-sm-12"
            >
              <label class="col-sm-2 control-label">Anexos a adjuntar</label>
              <div class="col-sm-2" style="position:relative;">
                <button class="btn btn-sm btn-warning" type="button">
                  Agregar Anexos
                  <input
                    v-if="uploadReady"
                    ref="file_anexo"
                    type="file"
                    style="position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:&quot;progid:DXImageTransform.Microsoft.Alpha(Opacity=0)&quot;;opacity:0;background-color:transparent;color:transparent;"
                    size="40"
                    name="docu_archivo"
                    accept=".JPG,.PNG,.pdf,.xlsx,.docx"
                    multiple
                    @change="submitFile($event.path[0].files, false)"
                  />
                </button> &nbsp;
                <span id="upload-file-info" class="label label-info"></span>
              </div>
              <div class="col-sm-8">
                <label class="control-label">(Para los anexos el máximo de 4 archivos de PDF, Imágenes, Word y
                  Excel)</label>
              </div>
            </div>
            <div v-for="(bar, indexBar) in progressbar" :key="indexBar" class="col-sm-12">
              <div class="col-sm-4">
                <progress :value="bar.p" max="100" style="width: 100%"></progress>
              </div>
            </div>
            <div
              v-if="
                (!plantilla && !viewer && formData.docu_archivo.filter(d => d.file_mostrar).length > 0 && $route.name != 'DocuGeneradoEdit') ||
                  (edit && $route.name != 'DocuGeneradoEdit')
              "
              class="col-sm-12"
            >
              <label class="col-sm-2 control-label">Relación de Archivos
                <br />Total cargado: {{ getFormatBytes(sizeTotal) }}
              </label>
              <div class="col-sm-10">
                <table
                  id="tabla"
                  class="table table-striped table-bordered table-condensed table-hover"
                  style="overflow-x:scroll;"
                >
                  <thead>
                    <tr class="info">
                      <th style="width: 2px">Nro</th>
                      <th style="width: 50px">Nombre</th>
                      <th style="width: 15px">Tamaño</th>
                      <th style="width: 10px">Tipo</th>
                      <th style="width: 5px">Acción</th>
                    </tr>
                  </thead>
                  <tbody class="success">
                    <tr
                      v-for="(docu, index) in formData.docu_archivo.filter(d => d.file_mostrar)"
                      :key="index"
                    >
                      <td>{{ index + 1 }}</td>
                      <td>{{ docu.file_name }}<br />
                        <span
                          v-if="docu.edit===true"
                          class="badge badge-warning"
                        >El documento será generado al Guardar</span></td>
                      <td>{{ getFormatBytes(docu.file_size) }}</td>
                      <td>{{ (docu.file_principal != null)?((docu.file_principal)?'Principal':'Anexo'):'' }}</td>
                      <td>
                        <div>
                          <button
                            v-if="docu.file_generado && $route.name!=='DocuGeneradoEdit2'"
                            class="btn btn-xs btn-success"
                            title="Editar"
                            @click.prevent="editarFile(docu)"
                          >
                            <span class="glyphicon glyphicon-pencil"></span>
                          </button>
                          <button
                            v-if="showButtonDelete(docu)"
                            class="btn btn-xs btn-danger"
                            title="Eliminar"
                            @click.prevent="ocultarFile(docu.file_url)"
                          >
                            <span class="glyphicon glyphicon-trash"></span>
                          </button>
                          <button
                            v-if="canSuper"
                            class="btn btn-xs btn-warning"
                            title="Editar"
                            @click.prevent="openRemplaceFile(docu)"
                          >remplazar
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <docu-derivar
        :derivaciones="derivaciones"
        :derivaciones2="derivaciones2"
        :viewer="viewer"
        :generado="archivoPrincipalGenerado!==undefined||viewer||plantilla"
        @derivar="markForGenerarDocumento"
      />
      <div v-if="!viewer" class="panel panel-primary">
        <div class="panel-body text-right">
          <button class="btn btn-primary" type="submit" :disabled="saving">
            <span v-if="!saving" class="glyphicon glyphicon-floppy-saved"> Guardar</span>
            <span v-else class="glyphicon glyphicon-send"> Guardando</span>
          </button>
        </div>
      </div>
    </form>
    <docu-invoker
      ref="foo"
      :iframe="iframe"
      :route-invoker-get="routeInvokerGet"
      :route-invoker-post="routeInvokerPost"
    />
    <div id="editar" class="modal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body" style="padding: 0;">
            <iframe
              ref="editor"
              title="Inline Frame Example"
              width="100%"
              height="770"
              scrolling="auto"
              src="/tramite/enproceso/editor"
            >
            </iframe>
          </div>
        </div>
      </div>
    </div>
    <div id="remplace" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" @click="remplaceFile.id = null; remplaceFile.url =null">&times;</button>
            <h4 class="modal-title">Remplazar archivo</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="col-sm-2" style="position:relative;">
                <button class="btn btn-sm btn-warning" type="button">
                  Arhivo
                  <input
                    ref="file_remplace"
                    type="file"
                    style="position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:&quot;progid:DXImageTransform.Microsoft.Alpha(Opacity=0)&quot;;opacity:0;background-color:transparent;color:transparent;"
                    size="40"
                    name="file_remplace"
                    accept=".JPG,.PNG,.pdf,.xlsx,.docx"
                    @change="fileRemplace($event.path[0].files)"
                  />
                </button> &nbsp;
                <span id="upload-file-info" class="label label-info"></span>
              </div>
             
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" @click="remplaceFile.id = null; remplaceFile.url =null">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {md5}       from 'pure-md5'
  import File        from '@/js/api/tramite/documento'
  import Vuex        from 'vuex'
  import Vue         from 'vue'
  import {Documento} from "@/js/store/models/documento"

  export default {
    name         : 'DocuPrincipal',
    components   : {},
    props        : {
      derivaciones      : {
        type   : Array,
        default: () => []
      },
      derivaciones2     : {
        type   : Array,
        default: () => []
      },
      prioridades       : {
        type   : Array,
        default: () => []
      },
      formData          : {
        type   : Object,
        default: () => ({})
      },
      defaultFormData   : {
        type   : Object,
        default: () => ({})
      },
      usuario           : {
        type   : Object,
        default: () => ({})
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
      plantilla         : {
        type   : Boolean,
        default: false
      },
      viewer            : {
        type   : Boolean,
        default: false
      },
      edit              : {
        type   : Boolean,
        default: false
      },
      origenFirst       : {
        type   : Boolean,
        default: false
      },
      saving            : {
        type   : Boolean,
        default: false
      },
      routeWebserviceDni: {
        type   : String,
        default: ''
      },
      routeWebserviceRuc: {
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
        unidadesOrganicas : null,
        dependenciaDefecto: null,
        firmaDefecto      : null,
        cargoDefecto      : null,
        siglaDefault      : null,
        existCorrelativo  : false,
        idUserCorrelativo : null,
        iframe            : {
          src   : null,
          loaded: false,
          type  : null
        },
        uploadReady       : true,
        html              : '',
        progressbar       : [],
        max_size          : 41943040,
        uploading_size    : 0,
        remplaceFile      : {
          id  : null,
          url : null,
        }
      }
    },
    beforeDestroy: function () {
      document.removeEventListener('saveIframe', this.guardarDocumentoGenerado)
      document.removeEventListener('closeIframe', this.cerrarModal)

    },

    computed: {
      ...Vuex.mapGetters([
                           'getRuta',
                           'getEntidadesExternas',
                           'getDependenciaUser',
                           'getTiposDocumento',
                           'getTipoDocumentoNombre',
                           'getDependenciaNombre',
                           'getFormatBytes']),
      nroDocumento() {
        return this.getTipoDocumentoNombre(this.formData.docu_idtipodocumento) + ' ' + (this.formData.docu_numero_doc != null ? ('000000' + this.formData.docu_numero_doc).slice(-6) : '____') + ' ' + this.formData.docu_siglas_doc
      },
      archivoPrincipal() {
        return this.formData.docu_archivo.filter(d => d.file_principal && d.file_mostrar)
      },
      archivoPrincipalGenerado() {
        return this.formData.docu_archivo.find(d => d.file_principal && d.file_mostrar && d.file_generado)
      },
      archivosAnexo() {
        return this.formData.docu_archivo.filter(d => !d.file_principal && d.file_mostrar)
      },
      showInputFile() {
        if (this.formData.iddocumento == null) {
          return true
        } else {
          if (this.formData.docu_archivo.length > 0 && this.formData.docu_archivo[0].id_documento_externo !== null) {
            return false
          } else {
            if (this.formData.operaciones.length > 0) {
              return true
            } else {
              if (this.formData.operaciones.length === 0) {
                return true
              }
            }
          }
        }
        return false
      },
      showButtonDelete: component => archivo => {
        if (component.formData.iddocumento == null) {
          return true
        } else {
          if (archivo.id_documento_externo != null) {
            return false
          } else {
            if (component.formData.docu_contrasenia != null && (archivo.file_generado || archivo.file_generado == null)) {
              return false
            } else {
              if (component.formData.operacionUltimo.oper_idusuario === component.usuario.id) {
                return true
              } else {
                if (component.formData.operaciones.length > 0 && component.formData.operaciones[0].oper_procesado === 1) {
                  return archivo.id == null
                } else {
                  if (component.formData.operaciones.length === 0) {
                    return true
                  }
                }
              }
            }
          }
        }
        return false
      },

      prioridad() {
        var d = this.prioridades.find(function (element) {
          return element.idprioridad === this.formData.docu_idprioridad
        }, this)
        return d != null ? d.prio_descripcion : null
      },
      recepcion() {
        var d = this.recepciones.find(function (element) {
          return element.idrecepcion === this.formData.docu_idrecepcion
        }, this)
        return d != null ? d.rece_descripcion : null
      },
      sizeTotal() {
        return this.formData.docu_archivo.filter(d => d.file_mostrar && d.file_size != null).reduce((acc, obj) => {
          return parseFloat(acc) + parseFloat(obj.file_size)
        }, 0) + this.uploading_size
      }
    },

    updated: function () {
      this.$nextTick(function () {
        if (this.origenFirst) {
          this.chngOrigen(parseInt(this.formData.docu_origen))
          this.$emit('loadOrigen')
        }
      })
    },

    mounted() {
      document.addEventListener('saveIframe', this.guardarDocumentoGenerado, {passive: true})
      document.addEventListener('closeIframe', this.cerrarModal, {passive: true})
      this.firmaDefecto       = this.formData.docu_firma
      this.cargoDefecto       = this.formData.docu_cargo
      this.siglaDefault       = this.formData.docu_siglas_doc
      this.dependenciaDefecto = this.formData.docu_iddependencia
    },
    methods: {

      submitFile(e, tipo) {
        if (e.length > 0) {
          return new Promise((resolve, reject) => {
            let warning_size = false
            for (let i = 0; i < e.length; i++) {
              if (this.sizeTotal + e[i].size <= this.max_size) {
                this.uploading_size += e[i].size
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
                        d.file_url      = response.data.data
                        d.file_generado = false
                        this.formData.docu_archivo.push(d)
                      } else {
                        alert('Hubo un problema al momento de subir el archivo, revise que el archivo tenga un máximo de 40 MB e intente denuevo')
                      }
                      this.uploading_size -= e[i].size
                      resolve(response)
                    }).catch(error => {
                      this.uploading_size -= e[i].size
                      this.progressbar.splice(this.progressbar.findIndex(e => e === progress), 1)
                    })
                  } else {
                    this.uploading_size -= e[i].size
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
                warning_size = true
              }
            }
            if (warning_size) {
              alert('El total de los archivos cargados supera los 40 MB permitidos')
            }
          })
        }
      },
      markForGenerarDocumento() {
        if (this.archivoPrincipalGenerado !== undefined) {
          this.archivoPrincipalGenerado.edit = true
          this.$forceUpdate()
        }
      },
      generarDocumento() {
        let html = '<div>&nbsp;</div><div>&nbsp;</div>' +
          '<p style="text-align:center;">documento firmado digitalmente</p>' +
          '<div style="text-align:center;"><strong>' + this.formData.docu_firma +
          '</strong></div>' + '<div style="text-align:center;">' + this.formData.docu_cargo + '</div>' +
          '<p>&nbsp;</p><div><strong>CC:</strong></div><div>ARCHIVO</div>'
        let put  = new CustomEvent('putHTML', {
          detail: html
        })
        this.$refs.editor.contentDocument.dispatchEvent(put)
        $('#editar').modal({
                             backdrop: 'static',
                             keyboard: false
                           })
        let event = new CustomEvent('resetSaving', {detail: null})
        this.$refs.editor.contentDocument.dispatchEvent(event)
      },
      cerrarModal(e) {
        $('#editar').modal('hide')
      },
      guardarDocumentoGenerado(e) {
        let index = this.formData.docu_archivo.findIndex(d => d.file_principal && d.file_generado)
        let value = {
          file_generado : true,
          edit          : true,
          file_mostrar  : true,
          file_html     : e.detail,
          file_name     : 'Documento principal Generado',
          file_principal: true,
          file_tipo     : "application/pdf",
          file_size     : 0
        }
        if (index === -1) {
          this.formData.docu_archivo.push(value)
        } else {
          Object.assign(this.formData.docu_archivo[index], value)
          this.$forceUpdate()
        }
        this.cerrarModal()

      },
      ocultarFile(url) {
        let indice                                      = this.formData.docu_archivo.findIndex(d => d.file_url === url)
        this.formData.docu_archivo[indice].file_mostrar = false
      },
      editarFile(file) {
        console.log(file.file_html)
        if (file.file_html === undefined) {
          Documento.getFileHtml(file).then(response => {
            file.file_html = response.data
            this.mostrarIframe(file)
          })
        } else {
          this.mostrarIframe(file)
        }

      },
      mostrarIframe(file) {
        $('#editar').modal({
                             backdrop: 'static',
                             keyboard: false
                           })
        let reset = new CustomEvent('resetSaving', {detail: null})
        let put   = new CustomEvent('putHTML', {detail: file.file_html})
        this.$refs.editor.contentDocument.dispatchEvent(reset)
        this.$refs.editor.contentDocument.dispatchEvent(put)
      },
      validar() {
        return this.$validator.validate()
      },
      obtenerCorrelativo() {
        if (parseInt(this.formData.docu_origen) === 1 && !this.plantilla && !this.edit && this.formData.docu_idtipodocumento !== null) {
          const parameters = {
            tdco_idtipodocumento: this.formData.docu_idtipodocumento,
            tdco_iddependencia  : this.formData.docu_iddependencia,
            tdco_idusuario      : this.idUserCorrelativo,
            tdco_periodo        : this.formData.docu_fecha_doc.substring(0, 4)
          }
          axios.post(this.getRuta('tramite.correlativo.buscar'), parameters).then(response => {
            if (response.data.id >= 1) {
              this.formData.docu_numero_doc = ('000000' + response.data.tdco_numero).slice(-6)
              this.formData.correlativo     = response.data.id
              this.existCorrelativo         = true
            } else {
              this.formData.docu_numero_doc = '000001'
              this.formData.correlativo     = null
              this.existCorrelativo         = false
            }
          })
        }
      },
      chngTipoDocumento() {
        this.obtenerCorrelativo()
      },
      chngTipo() {
        if (this.formData.docu_tipo) {
          this.formData.docu_firma      = this.usuario.nombre
          this.formData.docu_cargo      = this.usuario.adm_cargo
          this.formData.docu_siglas_doc = this.getDependenciaUser.depe_sigla + '-' + this.usuario.adm_inicial
          this.idUserCorrelativo        = this.usuario.id
        } else {
          this.formData.docu_firma      = this.getDependenciaUser.depe_representante
          this.formData.docu_cargo      = this.getDependenciaUser.depe_cargo
          this.formData.docu_siglas_doc = this.getDependenciaUser.depe_sigla
          this.idUserCorrelativo        = null
        }

        this.obtenerCorrelativo()
        this.$validator.reset()
      },
      chngOrigen(origen) {
        if (origen === 1 && !this.origenFirst) {
          this.formData.docu_iddependencia = this.dependenciaDefecto
          this.formData.docu_detalle       = null
          this.formData.docu_firma         = this.firmaDefecto
          this.formData.docu_cargo         = this.cargoDefecto
          this.formData.docu_siglas_doc    = this.siglaDefault
        } else {
          if (!this.origenFirst) {
            this.formData.docu_iddependencia = null
            this.formData.docu_firma         = null
            this.formData.docu_cargo         = null
            this.formData.docu_siglas_doc    = null
            this.formData.docu_numero_doc    = null
            this.existCorrelativo            = false
          }
        }

        this.defaultFormData.docu_origen        = this.formData.docu_origen
        this.defaultFormData.docu_iddependencia = this.formData.docu_iddependencia
        this.defaultFormData.docu_firma         = this.formData.docu_firma
        this.defaultFormData.docu_cargo         = this.formData.docu_cargo
        this.defaultFormData.docu_siglas_doc    = this.formData.docu_siglas_doc
        this.defaultFormData.docu_siglas_doc    = this.formData.docu_siglas_doc
        this.obtenerCorrelativo()
        this.$validator.reset()
      },
      guardarDocumento() {
        this.obtenerCorrelativo()
        this.$emit('guardarDocumento')
      },
      initInvoker(srt) {
        this.$refs.foo.initInvoker(srt)
      },
      validarDNI() {
        if (this.formData.docu_dni !== null && this.formData.docu_dni.length === 8) {
          axios.get(this.getRuta('tramite.persona.dni').replace(/%s/g, this.formData.docu_dni)).then(response => {
            if (!response.data.error) {
              this.formData.docu_firma = response.data.apPrimer + ' ' + response.data.apSegundo + ' ' + response.data.prenombres
              this.formData.docu_domic = response.data.ubigeo + ' ' + response.data.direccion
            } else {
              alert('DNI no encontrado en Padrón Electoral')
            }
          }, error => {
            alert('DNI no encontrado en Padrón Electoral')
            //this.formData.docu_dni = null;
          })
        }
      },
      validarRUC() {
        if (this.formData.docu_ruc !== null && this.formData.docu_ruc.length === 11) {
          axios.get(this.routeWebserviceRuc.replace(/%s/g, this.formData.docu_ruc)).then(response => {
            if (response.data.desc_identi.indexOf('PERSONA NATURAL') >= 0) {
              this.formData.docu_iddependencia = 182
              this.formData.docu_firma         = response.data.ddp_nombre
            } else {
              this.formData.docu_iddependencia = 758
            }
            console.log(response.data.ddp_nombre)
            this.formData.docu_detalle = response.data.ddp_nombre
            this.formData.docu_domic   = response.data.ddp_nomvia + ' ' + response.data.ddp_nomzon + ' ' + response.data.ddp_numer1 + ' ' + response.data.ddp_refer1
          }, error => {
            alert('No se encontro el RUC')
            this.formData.docu_ruc = null
          })
        }
      },
      openRemplaceFile(docu) {
        $('#remplace').modal()
        this.remplaceFile.id = docu.id
        this.remplaceFile.url = docu.file_url
      },

      fileRemplace(e) {
        if (confirm('Esta seguro de cambiar el archivo?, la acción sera irreversible!')){
          if (e.length > 0) {
            return new Promise((resolve, reject) => {
              let f = new FormData()
              f.append('file', e[0])
              f.append('id', this.remplaceFile.id)
              f.append('url', this.remplaceFile.url)
              return axios.post('/tramite/documento/remplaceFile', f, { headers: { 'Content-Type': 'multipart/form-data' } }).then( response => {
                if (response.data.status) {
                  alert('Se remplazo el archivo')
                  location.reload()
                } else {
                  alert('Ocurrio un problema revice el tamaño del archivo')
                }
              })
                .catch((e) => {
                  console.log('FAILURE!!')
                })
            })
          }
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
