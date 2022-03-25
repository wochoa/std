<template>
  <div class="panel-body">
    <div class="row Filtros m-1 mb-2">
      <div class="col-12 col-sm-2 FiltrosGrupo">
        <label>Número</label>
        <v-text-field
          v-model="formData.aco_numero"
          class="FiltrosInput"
          :hide-details="true"
        />
      </div>
      <div class="col-12 col-sm-6 FiltrosGrupo">
        <label>Valorizaciones</label>
        <v-autocomplete
          v-model="formActividad.aco_vinculo"
          :items="showAdicionalObra"
          :hide-details="true"
          flat
          class="FiltrosInput max-w-150"
          item-text="text"
          item-value="value"
          @change="obtenerValorizaciones()"
        />
      </div>
    </div>

    <!--Modal para editar valorización-->
    <v-dialog v-model="dialog" persistent max-width="1500px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="cerrarModal()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Editar Valorización</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn dark text @click="editarValorizacion()">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-list three-line subheader>
          <div class="d-flex flex-wrap">
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Ocurrencia</v-label>
              <v-text-field
                v-model="formActividad.aco_ocurrencia"
                type="date"
                solo />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Acción número</v-label>
              <v-text-field
                v-model="formActividad.aco_accion_numero"
                v-validate="'numeric'"
                :error-messages="errors.collect('acción_número')"
                data-vv-name="acción_número"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Monto valorizado</v-label>
              <v-text-field
                v-model="formActividad.aco_avance_financiero"
                v-validate="'decimal'"
                solo
                :error-messages="errors.collect('monto_valorizado')"
                data-vv-name="monto_valorizado"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Tipo valorización</v-label>
              <v-select
                v-model="formActividad.aco_vinculo"
                :items="showAdicionalObra"
                item-text="text"
                item-value="value"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Reajuste (reintegro)</v-label>
              <v-text-field
                v-model="formActividad.aco_amor_reajuste"
                v-validate="'decimal'"
                solo
                :error-messages="errors.collect('reajuste')"
                data-vv-name="reajuste"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Valorización N°</v-label>
              <v-text-field
                v-model="formActividad.aco_numero"
                v-validate="'numeric'"
                solo
                :error-messages="errors.collect('valorización_número')"
                data-vv-name="valorización_número"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Deducciones d</v-label>
              <v-text-field
                v-model="formActividad.aco_amor_deduc"
                v-validate="'decimal'"
                solo
                :error-messages="errors.collect('deducciones')"
                data-vv-name="deducciones"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Documento supervisor</v-label>
              <v-text-field
                v-model="formActividad.aco_doc_supervisor"
                label="Documento supervisor"
                @change="formActividad.aco_doc_supervisor = formActividad.aco_doc_supervisor.toUpperCase()"
              />
            </div>
            <div class="col-12 ProyectosFormulario">
              <v-label>Deducciones</v-label>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">Descripción</th>
                      <th class="text-left">Monto</th>
                      <th class="text-left">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(deduc, index) in formActividad.aco_amor_deduc_det" :key="index">
                      <td>
                        <v-text-field
                          v-model="deduc.desc"
                          @change="deduc.desc = deduc.desc.toUpperCase()"
                        />
                      </td>
                      <td>
                        <v-text-field
                          v-model="deduc.mont"
                          v-validate="'decimal'"
                          :error-messages="errors.collect('deducción_monto')"
                          data-vv-name="deducción_monto"
                        />
                      </td>
                      <td>
                        <v-icon color="primary" dark @click="deleteDeduccion(index)">mdi-minus-box</v-icon>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <v-icon color="primary" dark @click="newDeduccion()">mdi-plus</v-icon>
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Valorización bruta VB</v-label>
              <strong>
                    <span v-if="formActividad.val_bruta != undefined">{{
                      'S/. ' + formActividad.val_bruta
                    }}</span>
              </strong>
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Amortización directa</v-label>
              <v-text-field
                v-model="formActividad.aco_amor_ad"
                v-validate="'decimal'"
                solo
                :error-messages="errors.collect('amortización_directa')"
                data-vv-name="amortización_directa"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Amortización materiales</v-label>
              <v-text-field
                v-model="formActividad.aco_amor_am"
                v-validate="'decimal'"
                solo
                :error-messages="errors.collect('amortización_materiales')"
                data-vv-name="amortización_materiales"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Valorización neta VN</v-label>
              <strong>
                    <span v-if="formActividad.val_neta != undefined">
                      {{ 'S/. ' + formActividad.val_neta }}
                    </span>
              </strong>
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Retención</v-label>
              <v-text-field
                v-model="formActividad.aco_amor_reten"
                v-validate="'decimal'"
                solo
                :error-messages="errors.collect('retención')"
                data-vv-name="retención"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Otros</v-label>
              <v-text-field
                v-model="formActividad.aco_amor_otros"
                v-validate="'decimal'"
                solo
                :error-messages="errors.collect('otros')"
                data-vv-name="otros"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Valorización liquida VL</v-label>
              <v-text-field
                v-model="formActividad.aco_girado"
                v-validate="'decimal'"
                solo
                :error-messages="errors.collect('valorización_liquida')"
                data-vv-name="valorización_liquida"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Amortizado</v-label>
              <v-text-field
                v-model="formActividad.aco_saldo_amortizado"
                v-validate="'decimal'"
                solo
                :error-messages="errors.collect('amortizado')"
                data-vv-name="amortizado"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Imprimir acumulados</v-label>
              <v-checkbox
                v-model="formActividad.aco_doc_imprimir_acumulados"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fecha documento</v-label>
              <v-text-field
                v-model="formActividad.aco_doc_supervisor_fecha"
                type="date"
                solo
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Reg. documento</v-label>
              <v-text-field
                v-model="formActividad.aco_doc_supervisor_reg_sisgedo"
                v-validate="'numeric'"
                solo
                :error-messages="errors.collect('reg_documento')"
                data-vv-name="reg_documento"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Exp. documento</v-label>
              <v-text-field
                v-model="formActividad.aco_doc_emitido_sisgedo_expe"
                v-validate="'numeric'"
                solo
                :error-messages="errors.collect('exp_documento')"
                data-vv-name="exp_documento"
              />
            </div>
            <div class="col-12 ProyectosFormulario">
              <v-textarea
                v-model="formActividad.aco_observacion"
                filled
                name="input-7-4"
                label="Observaciones"
                solo
                @change="formActividad.aco_observacion = formActividad.aco_observacion.toUpperCase()"
              />
            </div>
          </div>
        </v-list>
        <v-divider />
        <v-list three-line subheader />
      </v-card>
    </v-dialog>
    <!--fin modal-->

    <!--Modal programar valorizaciones-->
    <v-dialog v-model="dialogProgramar" persistent max-width="1000px">
      <v-card>
        <v-card-title>
          <span class="headline">Programar Actividad</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="3" md="4">
                <v-text-field v-model="formActividad.aco_inicio" type="date" label="Fecha de inicio" />
              </v-col>
              <v-col cols="12" sm="3" md="4">
                <v-text-field
                  v-model="formActividad.aco_programado"
                  type="date"
                  label="Fecha de programada"
                />
              </v-col>
              <v-col cols="12" sm="3" md="4">
                <v-text-field
                  v-model="formActividad.aco_meta_financiero"
                  v-validate="'decimal'"
                  label="Avance programado S/."
                  :error-messages="errors.collect('meta_financiera')"
                  data-vv-name="meta_financiera"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn color="primary" text @click="guardarCambiosProgramar()">Guardar</v-btn>
          <v-btn color="blue darken-1" text @click="cerrarModalProgramar()">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!--Fin modal-->

    <h5 v-if="showValorizaciones != undefined && showValorizaciones.total_deductivo > 0">
      Monto contrato:
      <strong>{{ formatMoney(showValorizaciones.obr_monto_contrato) }}</strong>
    </h5>
    <h5 v-if="showValorizaciones != undefined && showValorizaciones.total_deductivo > 0">
      Deductivos:
      <strong>{{ ' ' + formatMoney(showValorizaciones.total_deductivo) }}</strong>
    </h5>
    <h5 v-if="showValorizaciones != undefined">
      Monto Contractual Sin IGV :
      <strong>{{ formatMoney(showValorizaciones.sinigv) }}</strong>
    </h5>

    <proy-table
      width="100%"
      class="ListadoTabla estatico"
      :items="valorizacionesFilter"
      tag="valorizacion"
      :page-length="30">
      <template slot="actions" slot-scope="data">
        <div v-if="data.selected.index !== null" class="d-flex">
          <v-btn
            small
            color="#1976d2"
            class="white--text"
            @click="obtenerUnaValorizacion(data.selected.item.idactividades, 1)"
          >
            Editar
            <v-icon right>mdi-pencil</v-icon>
          </v-btn>
          <v-btn small @click="obtenerUnaValorizacionProgramar(data.selected.item.idactividades, 2)">
            Programar
            <v-icon right>mdi-cloud-upload</v-icon>
          </v-btn>
        </div>
      </template>
      <template slot="header">
        <tr>
          <th style="width: 6%">Etapa</th>
          <th style="width: 15%">Actividad</th>
          <th style="width: 8%">Programado</th>
          <th style="width: 8%">Ejecución</th>
          <th style="width: 48%" colspan="4">
            <table class="table-normal">
              <tbody>
                <tr>
                  <td colspan="8" class="text-center">AVANCE FISICO Y FINANCIERO</td>
                </tr>
                <tr>
                  <th style="width: 8%" colspan="2">Programado</th>
                  <th style="width: 8%" colspan="2">Valorización Bruta</th>
                  <th style="width: 8%" colspan="2">Amortización</th>
                  <th style="width: 8%" colspan="2">Valorización Neta</th>
                </tr>
                <tr>
                  <th>Men</th>
                  <th>Acu</th>
                  <th>Men</th>
                  <th>Acu</th>
                  <th>Men</th>
                  <th>Acu</th>
                  <th>Men</th>
                  <th>Acu</th>
                </tr>
              </tbody>
            </table>
          </th>
          <th style="width: 15%">Observaciones</th>
        </tr>
      </template>
      <template slot="body" slot-scope="row">
        <td style="width: 6%">{{ row.item.eta_descripcion }}</td>
        <td style="width: 15%">{{ row.item.act_descripcion }}</td>
        <td style="width: 8%">{{row.item.aco_inicio | moment('calendar')}} - {{ row.item.aco_programado |
          moment('calendar') }}
        </td>

        <td style="width: 9%" v-if="row.item.aco_ocurrencia != null && row.item.aco_ocurrencia!=='0001-01-01'">{{
          row.item.aco_ocurrencia | moment('calendar')}}
        </td>
        <td style="width: 9%" v-else>Sin ocurrencias</td>

        <td style="width: 12%">
          <table class="table-normal">
            <tbody>
              <tr>
                <td>{{formatMoney(row.item.aco_meta_financiero)}}</td>
              </tr>
              <tr>
                <td>{{ parseFloat((row.item.aco_meta_financiero / showValorizaciones.sinigv) * 100).toFixed(2) }}%</td>
                <td>{{ parseFloat((row.item.acumulado / showValorizaciones.sinigv) * 100).toFixed(2) }}%</td>
              </tr>
            </tbody>
          </table>

        </td>
        <td style="width: 12%">
          <table class="table-normal">
            <tbody>
              <tr>
                <td>{{formatMoney(row.item.aco_avance_financiero)}}</td>
              </tr>
              <tr>
                <td>{{ parseFloat((row.item.aco_avance_financiero / showValorizaciones.sinigv) * 100).toFixed(2) }}%
                </td>
                <td>{{ parseFloat((row.item.acumuladoVb / showValorizaciones.sinigv) * 100).toFixed(2) }}%</td>
              </tr>
            </tbody>
          </table>
        </td>
        <td style="width: 12%">{{formatMoney(row.item.aco_saldo_amortizado)}}</td>
        <td style="width: 12%">{{formatMoney(row.item.aco_girado)}}</td>
        <td style="width: 15%"></td>

      </template>
    </proy-table>
  </div>
</template>
<script>
  import Vuex from 'vuex'
  import ProyTable from '@/js/components/proyectos/ProyTable'

  export default {

    components: {
      ProyTable
    },

    data () {
      return {
        formData: {
          aco_numero: null
        },
        formActividad: {
          idactividades: null,
          actividad_idactividad: null,
          aco_ocurrencia: null,
          aco_accion_numero: null,
          aco_avance_financiero: null,
          aco_amor_reajuste: null,
          aco_amor_deduc: null,

          aco_amor_deduc_det: [
            {
              desc: null,
              mont: null
            }],
          aco_amor_ad: null,
          aco_amor_am: null,
          aco_amor_reten: null,
          aco_amor_otros: null,
          aco_girado: null,
          aco_saldo_amortizado: null,
          aco_doc_imprimir_acumulados: null,
          aco_vinculo: 0,
          aco_numero: null,
          aco_doc_supervisor: null,
          aco_doc_supervisor_fecha: null,
          aco_doc_supervisor_reg_sisgedo: null,
          aco_doc_emitido_sisgedo_expe: null,
          aco_observacion: null,
          obra_idobra: this.$route.params.idcontrato,
          tipo: 2
        },
        defaulFormActividad: {},
        dialog: false,
        dialogProgramar: false,
        toggle_exclusive: 2
      }
    },

    computed: {
      ...Vuex.mapGetters([
        'showAdicionalObra',
        'showValorizaciones',
        'getOneValorizacion',
        'showValorizacionesData',
        'formatMoney']),

      valorizacionesFilter () {
        let filtrado = this.showValorizacionesData
        if (this.formData.aco_numero != null && this.formData.aco_numero !== '') {
          filtrado = filtrado.filter(d => d.aco_numero === parseInt(this.formData.aco_numero))
        }
        return filtrado
      }
    },

    created: function () {
      this.defaulFormActividad = Object.assign({}, this.formActividad)
      this.getAdicionalObra(this.$route.params.idcontrato)
      this.obtenerValorizaciones()
    },

    methods: {
      ...Vuex.mapActions([
        'getAdicionalObra', 'getActividadesOfContrato',]),

      obtenerValorizaciones () {
        const params = {
          obra_idobra: this.formActividad.obra_idobra,
          aco_vinculo: this.formActividad.aco_vinculo,
          tipo: this.formActividad.tipo
        }
        this.getActividadesOfContrato(params)
      },

      obtenerUnaValorizacion (idactividades, tipo) {
        this.$validator.reset()
        if (tipo == 1) {
          this.dialog = true
        }
        this.formActividad = JSON.parse(JSON.stringify(this.getOneValorizacion(idactividades)))
        this.formActividad.tipo = 2
        this.formActividad.aco_avance_financiero = this.formActividad.aco_avance_financiero != null ? parseFloat(this.formActividad.aco_avance_financiero) : 0.0
        this.formActividad.aco_amor_reajuste = this.formActividad.aco_amor_reajuste != null ? parseFloat(this.formActividad.aco_amor_reajuste) : 0.0
        this.formActividad.aco_amor_deduc = this.formActividad.aco_amor_deduc != null ? parseFloat(this.formActividad.aco_amor_deduc) : 0.0

        this.formActividad.val_bruta = this.formActividad.aco_avance_financiero + this.formActividad.aco_amor_reajuste - this.formActividad.aco_amor_deduc
        this.formActividad.aco_amor_ad = this.formActividad.aco_amor_ad != null ? parseFloat(this.formActividad.aco_amor_ad) : 0.0
        this.formActividad.aco_amor_am = this.formActividad.aco_amor_am != null ? parseFloat(this.formActividad.aco_amor_am) : 0.0

        var val_amortizado = this.formActividad.aco_amor_ad + this.formActividad.aco_amor_am
        this.formActividad.val_neta = this.formActividad.val_bruta - val_amortizado
        this.formActividad.aco_amor_otros = this.formActividad.aco_amor_otros != null ? parseFloat(this.formActividad.aco_amor_otros) : 0.0
        var val_liquida = this.formActividad.val_neta - this.formActividad.aco_amor_otros
        this.formActividad.aco_saldo_amortizado = Math.round(val_amortizado * 100) / 100
        this.formActividad.aco_girado = Math.round(val_liquida * 100) / 100
        this.formActividad.val_bruta = parseFloat(Math.round(this.formActividad.val_bruta * 100) / 100)
        this.formActividad.val_neta = parseFloat(Math.round(this.formActividad.val_neta * 100) / 100)

        /*var object = JSON.parse(response.data.aco_amor_deduc_det);
          var array = [];
          for(var i in object) {
          array.push(object[i]);
          }*/
        if (this.formActividad.aco_amor_deduc_det.length == 0) {
          this.formActividad.aco_amor_deduc_det = [
            {
              desc: null,
              mont: null
            }]
        }
      },

      obtenerUnaValorizacionProgramar (idactividades, tipo) {
        if (tipo == 2) {
          this.dialogProgramar = true
        }
        this.obtenerUnaValorizacion(idactividades)
      },

      newDeduccion () {
        this.formActividad.aco_amor_deduc_det.push({
          desc: null,
          mont: null
        })
      },

      deleteDeduccion (index) {
        this.formActividad.aco_amor_deduc_det.splice(index, 1)
      },

      guardarCambiosProgramar () {
        const params = {
          idactividades: this.formActividad.idactividades,
          aco_inicio: this.formActividad.aco_inicio,
          aco_programado: this.formActividad.aco_programado,
          aco_meta_financiero: this.formActividad.aco_meta_financiero,
          tipo: 5
        }
        axios.post(this.routeGuardarActividad, params).then(response => {
          console.log('actualizado')
          this.obtenerValorizaciones()
          this.cerrarModal()
        })
      },

      cerrarModal () {
        this.formActividad = Object.assign({}, this.defaulFormActividad)
        this.dialog = false
      },

      cerrarModalProgramar () {
        this.formActividad = Object.assign({}, this.defaulFormActividad)
        this.dialogProgramar = false
      },

      editarValorizacion () {
        axios.post(this.routeGuardarActividad, this.formActividad).then(response => {
          console.log('guardado')
          this.obtenerValorizaciones()
          this.cerrarModal()
        })
      }
    }
  }
</script>
<style scoped>
  .table-normal tbody {
    height: auto;
    overflow: hidden;
  }

  .table-normal, .table-normal tbody tr td {
    border: none;
  }
</style>
