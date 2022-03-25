<template>
  <div>
    <div class="card card-secundario mb-3">
      <div class="card-header font-weight-bold">DATOS DEL DOCUMENTO</div>
      <div class="card-body">
        <div class="form-group row">
          <label for="docu_fecha_doc" class="col-sm-2 col-form-label">Fecha Documento</label>
          <div class="col-sm-5">
            <input
              id="docu_fecha_doc"
              v-model="formData.docu_fecha_doc"
              type="date"
              class="form-control"
              name="docu_fecha_doc"
              disabled
            />
          </div>
        </div>
        <div class="form-group row" :class="{'has-error': errors.has('tipo') }">
          <label for="tipo" class="col-sm-2 col-form-label">Tipo Documento</label>
          <div class="col-sm-5">
            <select
              ref="tipo"
              v-model="formData.docu_idtipodocumento"
              v-validate="'required'"
              class="form-control"
              name="tipo"
            >
              <option v-for="(documentType, index) in documentTypes" :key="index" :value="documentType.idtdoc">{{
                documentType.tdoc_descripcion }}</option>
            </select>
            <span v-show="errors.has('tipo')" class="help-block">{{ errors.first('tipo') }}</span>
          </div>
          <div class="col-sm-3">
            <p style="color: #0066cc">*Puede modificar a otro tipo de documento de ser necesario</p>
          </div>
        </div>
        <div class="form-group row" :class="{'has-error': errors.has('numero de documento') }">
          <label for="numero de documento" class="col-sm-2 col-form-label">Número y Siglas</label>
          <div class="col-sm-3">
            <input
              ref="numero de documento"
              v-model="formData.docu_numero_doc"
              v-validate="'numeric'"
              type="text"
              class="form-control text-right"
              name="numero de documento"
              placeholder="Ingrese número documento"
            />
            <span v-show="errors.has('numero de documento')" class="help-block">{{ errors.first('numero de documento') }}</span>

          </div>
          <div class="col-sm-7">
            <input
              ref="siglas"
              v-model="formData.docu_siglas_doc"
              v-validate="'max:65'"
              type="text"
              name="siglas"
              class="form-control"
              placeholder="Ingrese sigla"
              @change="formData.docu_siglas_doc = formData.docu_siglas_doc.toUpperCase()"
            />
            <span v-show="errors.has('siglas')" class="help-block">{{ errors.first('siglas') }}</span>
          </div>
        </div>
        <div class="form-group row" :class="{'has-error': errors.has('folios') }">
          <label for="folios" class="col-sm-2 col-form-label">Folios</label>
          <div class="col-sm-3">
            <input
              ref="folios"
              v-model="formData.docu_folios"
              v-validate="'numeric|required'"
              type="number"
              class="form-control"
              name="folios"
              placeholder="Ingrese el número de folios"
            />
            <span v-show="errors.has('folios')" class="help-block">{{ errors.first('folios') }}</span>
          </div>
        </div>
        <div class="form-group row" :class="{ 'has-error': errors.has('asunto') }">
          <label for="asunto" class="col-sm-2 col-form-label">Asunto</label>
          <div class="col-sm-10">
            <textarea
              ref="asunto"
              v-model="formData.docu_asunto"
              v-validate="'required|max:750'"
              name="asunto"
              class="form-control"
              placeholder="Ingrese el asunto de su solicitud"
              @change="formData.docu_asunto = formData.docu_asunto.toUpperCase()"
            ></textarea>
            <span v-show="errors.has('asunto')" class="help-block">{{ errors.first('asunto') }}</span>
          </div>
        </div>
        <div v-if="archivoPrincipal.length<1" class="form-group row">
          <label for="fileInput" class="col-sm-2 col-form-label">Archivo a adjuntar</label>
          <div class="col-sm-2">
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
                @change="$emit('uploadPrincipal', $event.path[0].files)"
              />

            </button>
            <span id="upload-file-success" class="label label-info"></span>
          </div>
          <div class="col-sm-6">
            <label class="control-label">(Para el documento principal el formato es PDF)</label>
          </div>
        </div>
        <div v-if="archivosAnexo.length < 4" class="form-group row">
          <div class="col-sm-2">
            <label for="file_anexo">Anexos a adjuntar</label>
          </div>
          <div class="col-sm-2">
            <button class="btn btn-sm btn-warning" type="button" :disabled="anexos">
              Agregar anexos
              <input
                v-if="uploadReady"
                ref="file_anexo"
                type="file"
                style="position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:&quot;progid:DXImageTransform.Microsoft.Alpha(Opacity=0)&quot;;opacity:0;background-color:transparent;color:transparent;"
                size="40"
                name="docu_archivo"
                accept=".pdf"
                multiple
                :disabled="anexos"
                @change="$emit('uploadAnexo', $event.path[0].files)"
              />
            </button>
            <span id="upload-file-info" class="label label-info"></span>
          </div>
          <div class="col-sm-6">
            <label class="control-label">(Para los anexos el máximo de 4 archivos de formato PDF)</label>
          </div>
        </div>
        <div v-for="bar in progressbar" class="form-group row">
          <div class="col-sm-4">
            <progress :value="bar.p" max="100" style="width: 100%"></progress>
          </div>
        </div>
        <div class="form-group row">
          <div v-if=" formData.docu_archivo.length > 0" class="col-sm-12">
            <label class="control-label">Relación de Archivos</label><br />
            <label for="">Total cargado: {{ formatBytes(sizeTotal) }}</label>
            <div>
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
                  <tr v-for="(docu, index) in formData.docu_archivo.filter(d => d.file_mostrar)" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ docu.file_name }}</td>
                    <td>{{ formatBytes(docu.file_size) }}</td>
                    <td>{{ (docu.file_principal)?'Principal':'Anexo' }}</td>
                    <td>
                      <button
                        class="btn btn-xs btn-danger"
                        title="Eliminar"
                        :disabled="saving"
                        @click="$emit('ocultarFile', docu.file_url)"
                      >
                        <span class="icon icon-trashcan fs-18"></span>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-secundario mb-3">
      <div class="card-body text-right">
        <button
          v-if="formData.id == null"
          class="btn btn-warning"
          type="button"
          :disabled="saving"
          @click="$emit('form', false) "
        >
          <span class="icon icon-undo2 fs-18"> Regresar</span>
        </button>
        <button class="btn btn-success" type="button" :disabled="saving" @click="$emit( 'guardarDocumento') ">
          <span v-if="!saving" class="icon-floppy-disk fs-18"> Guardar</span>
          <span v-else class="icon icon-floppy-disk fs-18"> Guardando</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'FormDocumento',
    props: {
      formData: {
        type: Object,
        default: function () {
          return {}
        }
      },
      archivoPrincipal: {
        type: Array,
        default: function () {
          return []
        }
      },
      archivosAnexo: {
        type: Array,
        default: function () {
          return []
        }
      },
      anexos: {
        type: Boolean,
        default: true
      },
      saving: {
        type: Boolean,
        default: true
      },
      uploadReady: {
        type: Boolean,
        default: true
      },
      documentTypes: {
        type: Array,
        default: function () {
          return []
        }
      },
      progressbar: {
        type: Array,
        default: function () {
          return []
        }
      },
      sizeTotal:{
        type: Number,
        default: 0
      }
    },
    computed:{
      formatBytes: component => bytes => {
        if (bytes === 0) return '0 Bytes';
        const decimals  =2
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
      },
    }
  }
</script>

<style scoped>
  input,
  textarea {
    text-transform: uppercase;
  }

  .card-secundario {
    background-color: white;
    border-color: #f58634;
  }

  .card-secundario .card-header {
    background-color: #f586349e !important;
  }

  .col-md-6 {
    min-height: 98px !important;
  }
</style>
