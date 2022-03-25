<template>
  <div :class="'panel ' + (viewer ? 'panel-info' : 'panel-primary')">
    <div class="panel-heading">
      DESTINO(S)-DERIVACIÓN DEL DOCUMENTO
    </div>
    <div class="panel-body">
      <form action="" @submit.prevent="derivar()">
        <div class="form-group" style="width: 100%;">
          <div class="col-sm-12">
            <label class="col-sm-2 control-label">Forma</label>
            <div v-if="getDerivarSoloCopia" class="col-sm-4">Solo Copia</div>
            <div v-else class="col-sm-4">
              <label class="checkbox-inline">
                <input v-model="formData.oper_forma" type="checkbox" name="oper_forma" />Copia
              </label>
            </div>
            <div class="col-sm-4" v-if="generado">
              <label class="checkbox-inline">
                <input v-model="formData.oper_manual" type="checkbox" name="docu_tipo" />Registro manual
              </label>
            </div>
          </div>
          <div class="col-sm-12">
            <label class="col-sm-2 control-label">Unidad Orgánica</label>
            <div class="col-sm-2">
              <!--id-->
              <input
                v-model="formData.oper_depeid_d"
                type="text"
                class="form-control"
                @change="verificarUsuariosforDerivar()"
              />
            </div>
            <div class="col-sm-7">
              <select
                v-model="formData.oper_depeid_d"
                class="form-control"
                required
                @change="verificarUsuariosforDerivar()"
              >
                <option
                  v-for="(unidad, indexUnidad) in unidadesOrganicas"
                  :key="indexUnidad"
                  :value="unidad.iddependencia"
                >
                  {{ unidad.depe_nombre }}
                </option>
              </select>
            </div>
          </div>
          <div v-show="formData.oper_manual" :class="{ 'col-sm-12': true, 'has-error': errors.has('Destinatario') }">
            <label class="col-sm-2 control-label">Destinatario</label>
            <div class="col-sm-9">
              <input
                ref="detalle de proveido"
                v-model="formData.oper_persona"
                v-validate="'max:150'"
                name="Destinatario"
                type="text"
                class="form-control"
                @change="formData.oper_persona = formData.oper_persona.toUpperCase()"
              />
              <span v-show="errors.has('Destinatario')" class="help-block">{{
                errors.first('Destinatario')
              }}</span>
            </div>
          </div>
          <div v-show="formData.oper_manual" :class="{ 'col-sm-12': true, 'has-error': errors.has('Cargo') }">
            <label class="col-sm-2 control-label">Cargo</label>
            <div class="col-sm-9">
              <input
                ref="detalle de proveido"
                v-model="formData.oper_cargo"
                v-validate="'max:150'"
                name="Cargo"
                type="text"
                class="form-control"
                @change="formData.oper_cargo = formData.oper_cargo.toUpperCase()"
              />
              <span v-show="errors.has('Cargo')" class="help-block">{{
                errors.first('Cargo')
              }}</span>
            </div>
          </div>
          <div :class="{ 'col-sm-12': true, 'has-error': errors.has('detalle de proveido') }">
            <label class="col-sm-2 control-label">Detalle</label>
            <div class="col-sm-9">
              <input
                ref="detalle de proveido"
                v-model="formData.oper_detalledestino"
                v-validate="'max:150'"
                name="detalle de proveido"
                type="text"
                class="form-control"
                @change="formData.oper_detalledestino = formData.oper_detalledestino.toUpperCase()"
              />
              <span v-show="errors.has('detalle de proveido')" class="help-block">{{
                errors.first('detalle de proveido')
              }}</span>
            </div>
          </div>
          <div v-if="getDependenciaUser.iddependencia == formData.oper_depeid_d" id="iducuario" class="col-sm-12">
            <label class="col-sm-2 control-label">Usuario</label>
            <div class="col-sm-9">
              <select v-model="formData.oper_usuid_d" class="form-control" required>
                <option v-for="(usuario, indexUser) in getUsuariosActivo" :key="indexUser" :value="usuario.id">
                  {{ usuario.adm_name }}
                </option>
              </select>
            </div>
          </div>
          <div :class="{ 'col-sm-12': true, 'control-label': true, 'has-error': errors.has('proveido') }">
            <label class="col-sm-2 control-label">Proveido de atención</label>
            <div class="col-sm-9">
              <textarea
                ref="proveido"
                v-model="formData.oper_acciones"
                v-validate="'max:450'"
                name="proveido"
                required
                class="form-control"
                rows="2"
                @change="formData.oper_acciones = formData.oper_acciones.toUpperCase()"
              ></textarea>
              <span v-show="errors.has('proveido')" class="help-block">{{ errors.first('proveido') }}</span>
            </div>
          </div>
          <div class="col-sm-12">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-9">
              <button type="submit" class="btn btn-primary" value="Añadir">
                <span class="glyphicon glyphicon-ok"> Añadir</span>
              </button>
              <button class="btn btn-warning" @click="limpiar()">
                <span class="glyphicon glyphicon-ban-circle"> Limpiar</span>
              </button>
            </div>
          </div>
        </div>
        <!--tabla-->
        <div class="box">
          <div class="box-body">
            <table
              id="tabla"
              class="table table-striped table-bordered table-condensed table-hover"
              style="overflow-x:scroll;"
            >
              <!-- Cabecera de la tabla -->
              <thead>
                <tr class="info">
                  <th>FORMA</th>
                  <th>UNIDAD ORGANICA</th>
                  <th>DETALLE</th>
                  <th>USUARIO</th>
                  <th>PROVEIDO DE ATENCIÓN</th>
                  <th style="width: 10px"></th>
                </tr>
              </thead>
              <!-- Cuerpo de la tabla con los campos -->
              <tbody>
                <!-- fila base para clonar y agregar al final -->
                <tr v-for="(derivacion, index2) in derivaciones2" :key="'show_'+index2" class="success">
                  <td>
                    <p v-if="derivacion.oper_forma">Copia</p>
                    <p v-else>Original</p>
                  </td>
                  <td>
                    <p>{{ getDependenciaNombre(derivacion.oper_depeid_d) }}</p>
                  </td>
                  <td>
                    <p>{{ derivacion.oper_detalledestino }}</p>
                  </td>
                  <td>
                    <p v-if="derivacion.oper_usuid_d != null">{{ getUsuariosActivoNombre(derivacion.oper_usuid_d) }}</p>
                    <p v-if="derivacion.oper_manual">{{ derivacion.oper_persona }}<br />{{ derivacion.oper_cargo }}</p>
                  </td>
                  <td>
                    <p>{{ derivacion.oper_acciones }}</p>
                  </td>
                  <td>
                    <label v-if="generado" class="control-label" style="font-weight:500; width: 90px;">
                      <input
                        v-if="!derivacion.oper_manual"
                        v-model="derivacion.oper_es_destino"
                        type="checkbox"
                      /> Es destino.</label>
                  </td>
                </tr>
                <tr v-for="(derivacion, index1) in derivaciones" :key="index1">
                  <td>
                    <p v-if="derivacion.oper_forma">Copia</p>
                    <p v-else>Original</p>
                  </td>
                  <td>
                    <p>{{ getDependenciaNombre(derivacion.oper_depeid_d) }}</p>
                  </td>
                  <td>
                    <p>{{ derivacion.oper_detalledestino }}</p>
                  </td>
                  <td>
                    <p v-if="derivacion.oper_usuid_d != null">{{ getUsuariosActivoNombre(derivacion.oper_usuid_d) }}</p>
                    <p v-if="derivacion.oper_manual">{{ derivacion.oper_persona }}<br />{{ derivacion.oper_cargo }}</p>
                  </td>
                  <td>
                    <p>{{ derivacion.oper_acciones }}</p>
                  </td>
                  <td>
                    <a
                      class="btn btn-danger"
                      @click="eliminarDerivacion(index1)"
                    ><span class="glyphicon glyphicon-trash"></span></a>
                    <br />
                    <label v-if="generado" class="control-label" style="font-weight:500; width: 90px;">
                      <input
                        v-if="!derivacion.oper_manual"
                        v-model="derivacion.oper_es_destino"
                        type="checkbox"
                      /> Es destino.</label>
                  </td>
                </tr>
                <tr v-if="derivaciones.length === 0">
                  <td colspan="6" class="text-center">
                    No se realizo ninguna derivacion.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import Vuex        from 'vuex'
  import {Operacion} from "@/js/store/models/documento"

  export default {

    name: 'DocuDerivar',

    props: {
      derivaciones : {
        type   : Array,
        default: () => []
      },
      derivaciones2: {
        type   : Array,
        default: () => []
      },
      viewer       : {
        type   : Boolean,
        default: false
      },
      generado     : {
        type   : Boolean,
        default: false
      }
    },

    data() {
      return {
        formData: {},
      }
    },

    computed: {
      ...Vuex.mapGetters([
                           'getUnidadesForDerivacion',
                           'getEntidadesExternas',
                           'getDependenciaNombre',
                           'getUsuariosActivo',
                           'getUsuariosActivoNombre',
                           'getDependenciaUser',
                           'getDerivarSoloCopia']),
      unidadesOrganicas() {
        if (this.formData.oper_manual) {
          return this.getEntidadesExternas
        } else {
          return this.getUnidadesForDerivacion
        }

      },
    },

    mounted() {
      this.formData = Operacion.getDefault()
    },
    methods: {
      verificarUsuariosforDerivar() {
        if (this.getDependenciaUser.iddependencia != this.formData.oper_depeid_d) {
          this.formData.oper_usuid_d = null
        }
      },
      derivar() {
        var este = this
        this.$validator.validate().then(function (result) {
          if (result) {
            if (este.getDerivarSoloCopia) {
              este.formData.oper_forma = true
            }
            este.derivaciones.push(Object.assign({}, este.formData))
            este.$forceUpdate()
            este.limpiar()
            este.$emit('derivar')
          } else {
            alert('Verifique que los campos esten llenados correctamente')
          }
        }, function (error) {
          console.log('Error' + error)
        })
      },
      limpiar() {
        this.formData = Operacion.getDefault()
      },
      eliminarDerivacion(index) {
        this.derivaciones.splice(index, 1)
        this.$forceUpdate()
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
