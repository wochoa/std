<template>

  <form class="form-horizontal" @submit.prevent="">
    <div class="row">
      <div class="col-lg-4">
        <select
          v-model="formData.opcion"
          multiple
          class="form-control"
          size="14"
          @change="formData.opcion[0].id == 6 ? putHasta() : false"
        >
          <option v-for="(op, index) in opciones" :key="index" :value="op">{{ op.data }}</option>
        </select>
      </div>
      <div class="col-lg-8 form-group mb-6">
        <div class="TramiteReporte">
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('iddocumento_inicial') >= 0"
            class=" form-group"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-6">
              <br />
              <label>Registro inicial:</label>
              <input v-model="formData.iddocumento" type="text" class="form-control" />
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('tipo_formato') >= 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-12">
              <br />
              <label>Tipo de Formato:</label>
              <label>
                <input v-model="formData.tipo_formato" type="radio" :value="2" class="radio-inline" />Formato de
                documentos derivados
              </label>
              <label>
                <input
                  v-model="formData.tipo_formato"
                  type="radio"
                  :value="1"
                  class="radio-inline"
                  @change="formatUnidadDestino()"
                />Formato de documentos recibidos
              </label>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('docu_fecha_desde') >= 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-6">
              <div class="input-group date">
                <br />
                <label>Fecha Desde:</label>
                <input v-model="formData.docu_fecha_desde" type="date" class="form-control" @change="putHasta()" />
              </div>
            </div>
            <div
              v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('docu_fecha_hasta') > 0"
              class="col-sm-6"
            >
              <div class="input-group date">
                <br />
                <label>Fecha Hasta:</label>
                <input v-model="formData.docu_fecha_hasta" type="date" class="form-control" />
              </div>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('docu_desde') >= 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-6">
              <br />
              <div class="col-sm-4">
                <label>Desde:</label>
              </div>
              <div class="col-sm-8">
                <input v-model="formData.docu_desde" type="text" class="form-control" />
              </div>
            </div>
            <div
              v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('docu_hasta') > 0"
              class="col-sm-6"
            >
              <br />
              <div class="col-sm-4">
                <label>Hasta:</label>
              </div>
              <div class="col-sm-8">
                <input v-model="formData.docu_hasta" type="text" class="form-control" />
              </div>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('docu_origen') > 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-12">
              <br />
              <label>Orígen:</label>
              <label style="margin-left:5px;">
                <input v-model="formData.docu_origen" type="radio" :value="null" class="radio-inline" />Todos
              </label>
              <label style="margin-left:5px;">
                <input v-model="formData.docu_origen" type="radio" :value="1" class="radio-inline" />Interno
              </label>
              <label style="margin-left:5px;">
                <input v-model="formData.docu_origen" type="radio" :value="2" class="radio-inline" />Externo
              </label>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('oper_procesado') > 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-12">
              <br />
              <label>Estado derivación:</label>
              <label>
                <input v-model="formData.oper_procesado" type="radio" :value="null" class="radio-inline" />Todos
              </label>
              <label>
                <input v-model="formData.oper_procesado" type="radio" :value="0" class="radio-inline" />Pendiente
              </label>
              <label>
                <input v-model="formData.oper_procesado" type="radio" :value="1" class="radio-inline" />Recibido
              </label>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('depe_depende') >= 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-12">
              <label>Dependencia:</label>
              <select v-model="formData.depe_depende" class="form-control" @change="resetDependencia">
                <option :value="null">Todos</option>
                <option
                  v-for="(dependencia, indexDepe) in getSedes"
                  :key="indexDepe"
                  :value="dependencia.iddependencia"
                >
                  {{ dependencia.depe_nombre }}
                </option>
              </select>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('docu_iddependencia') > 0"
            class=" form-group mb-0 col-sm-12"
            style="width: 100%;margin-left: -0px;"
          >
            <label>Unidad Org:</label>
            <div>
              <div class="col-sm-3" style="padding-left: 0;">
                <input
                  v-model="formData.docu_iddependencia"
                  type="text"
                  class="form-control"
                  @change="obtenerUser()"
                />
              </div>
              <div class="col-sm-9" style="padding-right: 0;">
                <select v-model="formData.docu_iddependencia" class="form-control" @change="obtenerUser()">
                  <option :value="null">Todos</option>
                  <option
                    v-for="(unidad, indexUnidad) in getUnidadesSede(formData.depe_depende)"
                    :key="indexUnidad"
                    :value="unidad.iddependencia"
                  >
                    {{ unidad.depe_nombre }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('docu_tipo') > 0"
            class=" form-group mb-0 "
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-12">
              <br />
              <label>Tipo:</label>
              <input v-model="formData.docu_tipo" type="radio" :value="null" class="radio-inline" />Todos
              <input v-model="formData.docu_tipo" type="radio" :value="0" class="radio-inline" />Oficina
              <input v-model="formData.docu_tipo" type="radio" :value="1" class="radio-inline" />Personal
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('oper_idusuario') > 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-8">
              <label>Usuario Remitente:</label>
              <select v-model="formData.oper_idusuario" class="form-control">
                <option :value="null">Todos</option>
                <option v-for="(user, indexUser) in users" :key="indexUser" :value="user.id">{{
                  user.adm_name
                }}</option>
              </select>
            </div>
            <div
              v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('docu_firma') > 0"
              class="col-sm-4"
            >
              <label>Firmante:</label>
              <input
                v-model="formData.docu_firma"
                type="text"
                class="form-control"
                @change="formData.docu_firma = formData.docu_firma.toUpperCase()"
              />
            </div>
          </div>
          <div
            v-if="formData.tipo_formato == 2"
            class=" form-group col-sm-12 mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('oper_depeid_d') > 0">
              <div class="col-sm-8" style="padding-left: 0;">
                <label>Unidad Org. Destino:</label>
                <div>
                  <div class="col-sm-3" style="padding-left: 0;">
                    <input
                      v-model="formData.oper_depeid_d"
                      type="text"
                      class="form-control"
                      @change="verificarUsuariosforDerivar()"
                    />
                  </div>
                  <div class="col-sm-9" style="padding-right: 0;">
                    <select
                      v-model="formData.oper_depeid_d"
                      class="form-control"
                      @change="verificarUsuariosforDerivar()"
                    >
                      <option :value="null">Todos</option>
                      <option
                        v-for="(unidad, indexUni) in getUnidadesForReporte(formData.depe_depende)"
                        :key="indexUni"
                        :value="unidad.iddependencia"
                      >
                        {{ unidad.depe_nombre }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div
              v-if="
                formData.opcion.length > 0 &&
                  formData.opcion[0].inputs.indexOf('oper_usuid_d') > 0 &&
                  getDependenciaUser.iddependencia == formData.oper_depeid_d
              "
              class="col-sm-4"
              style="padding-right: 0;"
            >
              <label>Usuario destino:</label>
              <select v-model="formData.oper_usuid_d" class="form-control">
                <option :value="null">Todos</option>
                <option v-for="(user, indexUserActivo) in getUsuariosActivo" :key="indexUserActivo" :value="user.id">
                  {{ user.adm_name }}
                </option>
              </select>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('arch_periodo') > 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-6">
              <label>Periodo</label>
              <select v-model="formData.arch_periodo" class="form-control">
                <option :value="null">Todos</option>
                <option v-for="(periodo, indexPeriodo) in getPeriodosCorrelativo" :key="indexPeriodo">{{
                  periodo.tdco_periodo
                }}</option>
              </select>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('archivador') > 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-12">
              <label>Archivador:</label>
              <select v-model="formData.archivador" class="form-control">
                <option :value="null">Todos</option>
                <option
                  v-for="(archivador, indexArchivador) in archivadores"
                  :key="indexArchivador"
                  :value="archivador.idarch"
                >
                  {{ archivador.arch_periodo + '/' + archivador.arch_nombre }}
                </option>
              </select>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('idtdoc') > 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-12">
              <label>Tipos de Documentos:</label>
              <select v-model="formData.idtdoc" class="form-control">
                <option :value="null">Todos</option>
                <option v-for="(tipoDoc, indexTipo) in getTiposDocumento" :key="indexTipo" :value="tipoDoc.idtdoc">{{
                  tipoDoc.tdoc_descripcion
                }}</option>
              </select>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('docu_asunto') > 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-12">
              <label>Detalle:</label>
              <textarea
                v-model="formData.docu_asunto"
                cols="30"
                rows="2"
                class="form-control"
                @change="formData.docu_asunto = formData.docu_asunto.toUpperCase()"
              ></textarea>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('espaciado') > 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-12">
              <br />
              <label>Modo de impresión:</label>
              <label>
                <input v-model="espaciado" type="radio" :value="2" class="radio-inline" />Formato sin espaciado para
                el sello
              </label>
              <label>
                <input v-model="espaciado" type="radio" :value="10" class="radio-inline" />Formato con espaciado para
                el sello
              </label>
            </div>
          </div>
          <div
            v-if="formData.opcion.length > 0 && formData.opcion[0].inputs.indexOf('ordenamiento') > 0"
            class=" form-group mb-0"
            style="width: 100%;margin-left: -0px;"
          >
            <div class="col-sm-12">
              <br />
              <label>Modo de ordenamiento:</label>
              <label>
                <input v-model="formData.ordenamiento" type="radio" value="ASC" class="radio-inline" />
                Ascendentemente
              </label>
              <label>
                <input v-model="formData.ordenamiento" type="radio" value="DESC" class="radio-inline" />
                Descendentemente
              </label>
            </div>
          </div>
          <div class=" form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-12" style="margin-bottom:15px">
              <div class="col-sm-6">
                <button
                  v-if="formData.opcion.length > 0 && formData.opcion[0].pdf"
                  class="btn btn-primary btn-lg btn-block"
                  :disabled="getting"
                  @click="exportPdf()"
                >
                  <span class="glyphicon glyphicon-print"></span>Imprimir PDF
                </button>
              </div>
              <div class="col-sm-6">
                <button
                  v-if="formData.opcion.length > 0 && formData.opcion[0].excel"
                  class="btn btn-success btn-lg btn-block"
                  :disabled="getting"
                  @click="generarExcel()"
                >
                  <span class="glyphicon glyphicon-print"></span>Imprimir EXCEL
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

</template>
<script>
  import Vuex from 'vuex'
export default {
  props: {
    routeUser: {
      type: String,
      default: ''
    },
    routeArchivador: {
      type: String,
      default: ''
    },
    routeReporte: {
      type: String,
      default: ''
    },
    opciones: {
      type: Object,
      default: () => ({})
    },
    titulo: {
      type: String,
      default: ''
    },
    tipo: {
      type: Number,
      default: 1
    }
  },

  data() {
    return {
      formData: {
        opcion: [],
        tipo_formato: 2,
        iddocumento: null,
        docu_fecha_desde: null,
        docu_fecha_hasta: null,
        docu_desde: 1,
        docu_hasta: 700,
        docu_origen: null,
        depe_depende: null,
        docu_iddependencia: null,
        oper_idusuario: null,
        oper_depeid_d: null,
        oper_usuid_d: null,
        docu_firma: null,
        docu_tipo: null,
        idtdoc: null,
        arch_periodo: null,
        docu_asunto: null,
        archivador: null,
        ordenamiento: 'ASC',
        oper_procesado: null
      },
      users: {},
      archivadores: {},
      reportes: {},
      espaciado: 2,
      getting: false
    }
  },

  computed: {
    ...Vuex.mapGetters([
      'getSedes',
      'getUnidadesSede',
      'getUnidadesForReporte',
      'getDependenciaUser',
      'getUsuariosActivo',
      'getUsuarios',
      'getArchivadores',
      'getPeriodosCorrelativo',
      'getTiposDocumento',
      'getSedeDeUnidad'
    ])
  },

  mounted() {
    this.formData.opcion = [this.opciones[0]]
    this.obtenerPeriodosCorrelativo()
    var date = new Date() // Or the date you'd like converted.
    var isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
    this.formData.docu_fecha_desde = isoDate.slice(0, 10)
    this.formData.docu_fecha_hasta = isoDate.slice(0, 10)
    this.obtenerArchivadores()
    var este = this
    window.setTimeout(function() {
      // code to run after 5 seconds...
      este.formData.depe_depende = este.getDependenciaUser.depe_depende
      este.formData.docu_iddependencia = este.getDependenciaUser.iddependencia
      este.users = este.getUsuarios
      este.archivadores = este.getArchivadores
    }, 1500)
  },

  methods: {
    ...Vuex.mapActions(['obtenerPeriodosCorrelativo', 'obtenerArchivadores']),

    resetDependencia() {
      this.formData.docu_iddependencia = null
      this.users = {}
      this.archivadores = {}
    },

    formatUnidadDestino() {
      this.formData.oper_depeid_d = null
      this.formData.oper_usuid_d = null
    },

    verificarUsuariosforDerivar() {
      if (this.getDependenciaUser.iddependencia != this.formData.oper_depeid_d) {
        this.formData.oper_usuid_d = null
      }
    },

    putHasta() {
      this.formData.docu_fecha_hasta = this.formData.docu_fecha_desde
    },

    obtenerUser() {
      if (this.formData.docu_iddependencia) {
        this.formData.depe_depende = this.getSedeDeUnidad(this.formData.docu_iddependencia)
        const parm = {
          depe_id: this.formData.docu_iddependencia
        }
        axios.get(this.routeUser, { params: parm }).then(reponse => {
          this.users = reponse.data
        })
        axios.get(this.routeArchivador, { params: parm }).then(reponse => {
          this.archivadores = reponse.data
        })
      } else {
        alert('Seleccione una Unidad Organica')
      }
    },

    exportPdf() {
      if (this.formData.opcion[0].id !== 12 && this.formData.opcion[0].id !== 13 && this.formData.opcion[0].id !== 14) {
        if (this.formData.depe_depende == null || this.formData.docu_iddependencia == null) {
          this.formData.depe_depende = 3
          this.formData.docu_iddependencia = 2
        }
      }

      if (!this.getting) {
        this.getting = true
        axios.get(this.routeReporte, { params: this.formData }).then(reponse => {
          this.reportes = reponse.data
          if (reponse.data.length > 0) {
            let pdfName = 'Reporte1'
            var config = {
              orientation: 'l',
              unit: 'mm',
              format: 'a4',
              setFont: 'helvetica',
              setFontType: 'bold'
            }
            var configTable = {
              columns: null,
              columnStyles: {},
              bodyStyles: { fontSize: 7, textColor: 0, lineColor: 0 },
              headStyles: { fontSize: 7, textColor: 0, lineColor: 0, fillColor: 200, lineWidth: 0.12 },
              theme: 'grid',
              margin: { top: 25 },
              rowPageBreak: 'avoid',
              body: reponse.data,
            }
            let factor = 1.64
            var header = []
            var cuerpo = []
            var total = ''
            switch (this.formData.opcion[0].id) {
              case 1:
                {
                  configTable.columns = [
                    { header: 'Registro', dataKey: 'iddocumento', width: 10*factor },
                    { header: 'Expediente', dataKey: 'docu_idexma', width: 10*factor },
                    { header: 'Fecha', dataKey: 'docu_fecha_doc', width: 10*factor },
                    { header: 'Documento', dataKey: 'tdoc_descripcion', width: 30*factor },
                    { header: 'Folios', dataKey: 'docu_folios', width: 10*factor },
                    { header: 'Asunto', dataKey: 'docu_asunto', width: 55*factor },
                    { header: 'Destino', dataKey: 'depe_destino', width: 38*factor }
                  ]

                  header = [
                    { text: 'DOCUMENTO GENERADO POR UNIDAD ORGANICA', x: 90, y: 15 },
                    {
                      text: 'Desde: ' + this.formData.docu_fecha_desde + '  Hasta: ' + this.formData.docu_fecha_hasta,
                      x: 100,
                      y: 20
                    }
                  ]
                  total = reponse.data.length
                }
                break
              case 2:
                {
                  configTable.columns = [
                    { header: 'Reg.', dataKey: 'iddocumento', width: 10*factor },
                    { header: 'FechaRe', dataKey: 'created_at', width: 10*factor },
                    { header: 'Expediente', dataKey: 'tdoc_descripcion', width: 20*factor },
                    { header: 'Fecha', dataKey: 'docu_fecha_doc', width: 10*factor },
                    { header: 'Folio', dataKey: 'docu_folios', width: 7*factor },
                    { header: 'Unidad Org.', dataKey: 'depe_nombre', width: 22*factor },
                    { header: 'Detalle', dataKey: 'docu_detalle', width: 12*factor },
                    { header: 'Firma', dataKey: 'docu_firma', width: 20*factor },
                    { header: 'Cargo', dataKey: 'docu_cargo', width: 20*factor },
                    { header: 'Asunto', dataKey: 'docu_asunto', width: 32*factor }
                  ]

                  header = [
                    { text: 'EXPEDIENTES RECIBIDOS', x: 120, y: 15 },
                    {
                      text: 'Desde: ' + this.formData.docu_fecha_desde + '  Hasta: ' + this.formData.docu_fecha_hasta,
                      x: 110,
                      y: 20
                    }
                  ]
                  total = reponse.data.length
                }
                break
              case 3:
                {
                  configTable.columns = [
                    { header: 'Registro', dataKey: 'oper_iddocumento', width: 10*factor },
                    { header: 'FechaA', dataKey: 'created_at', width: 10*factor },
                    { header: 'Expediente', dataKey: 'tdoc_descripcion', width: 20*factor },
                    { header: 'FechaD', dataKey: 'docu_fecha_doc', width: 10*factor },
                    { header: 'Folio', dataKey: 'docu_folios', width: 7*factor },
                    { header: 'Unidad Org.', dataKey: 'depe_nombre', width: 21*factor },
                    { header: 'Detalle', dataKey: 'docu_detalle', width: 12*factor },
                    { header: 'Firma', dataKey: 'docu_firma', width: 16*factor },
                    { header: 'Cargo', dataKey: 'docu_cargo', width: 12*factor },
                    { header: 'Asunto', dataKey: 'docu_asunto', width: 25*factor },
                    { header: 'Forma', dataKey: 'oper_tarchi_id', width: 8*factor },
                    { header: 'Acciones', dataKey: 'oper_acciones', width: 12*factor }
                  ]
                  header = [
                    { text: 'DOCUMENTOS ARCHIVADOS/PROCESADOS', x: 120, y: 15 },
                    {
                      text: 'Desde: ' + this.formData.docu_fecha_desde + '  Hasta: ' + this.formData.docu_fecha_hasta,
                      x: 125,
                      y: 20
                    }
                  ]
                  total = reponse.data.length
                }
                break
              case 4:
                {
                  configTable.columns = [
                    { header: 'Registro', dataKey: 'iddocumento', width: 10*factor },
                    { header: 'FechaR', dataKey: 'created_at', width: 10*factor },
                    { header: 'Forma', dataKey: 'oper_forma', width: 8*factor },
                    { header: 'Expediente', dataKey: 'tdoc_descripcion', width: 20*factor },
                    { header: 'FechaD', dataKey: 'docu_fecha_doc', width: 10*factor },
                    { header: 'Folio', dataKey: 'docu_folios', width: 7*factor },
                    { header: 'Unidad Org.', dataKey: 'depe_nombre', width: 21*factor },
                    { header: 'Detalle', dataKey: 'docu_detalle', width: 12*factor },
                    { header: 'Firma', dataKey: 'docu_firma', width: 16*factor },
                    { header: 'Cargo', dataKey: 'docu_cargo', width: 12*factor },
                    { header: 'Asunto', dataKey: 'docu_asunto', width: 30*factor },
                    { header: 'Dias', dataKey: 'dias', width: 5*factor }
                  ]

                  header = [{ text: 'DOCUMENTOS EN PROCESO', x: 120, y: 15 }]
                  total = reponse.data.length
                }
                break

              case 5:
                {
                  configTable.columns = [
                    { header: 'Registro', dataKey: 'iddocumento', width: 10*factor },
                    { header: 'FechaD', dataKey: 'created_at', width: 10*factor },
                    { header: 'Expediente', dataKey: 'tdoc_descripcion', width: 22*factor },
                    { header: 'Unidad org.', dataKey: 'depe_nombre', width: 27*factor },
                    { header: 'Asunto', dataKey: 'docu_asunto', width: 33*factor },
                    { header: 'Proveido', dataKey: 'oper_acciones', width: 15*factor },
                    { header: 'UnidadDes', dataKey: 'depe_nombre_destino', width: 25*factor },
                    { header: 'Estado', dataKey: 'estado_derivacion', width: 20*factor }
                  ]
                  header = [
                    { text: 'DOCUMENTOS DERIVADOS', x: 120, y: 15 },
                    {
                      text: 'Desde: ' + this.formData.docu_fecha_desde + '  Hasta: ' + this.formData.docu_fecha_hasta,
                      x: 115,
                      y: 20
                    }
                  ]
                  total = reponse.data.length
                }
                break
              case 6:
                {
                  /*const doc1 = new jsPDF('l','pt');

                                    var table = document.createElement('table');
                                    var htmlString = "<thead><tr><th>Reg. | Doc. | Folios | Remitente | Asunto</th> <th>Destino | Proveido</th> <th>Firma</th></tr></thead> <tbody><tr><td><b>Reg.</b>1<br> <strong>Doc.</strong>INFORME 000002-GRH-GRPPAT/SGDIS-JRCS<br> <strong>Remitente:</strong><br>SUB GERENCIA DE DESARROLLO INSTITUCIONAL Y SISTEMAS<strong>Asunto:</strong>El próximo domingo, los ciudadanos tendrán ocasión de hacer política, de participar en la toma de decisiones públicas</td> <td><strong>Destino:</strong>conocimiento<br> <strong>Proveiodo</strong>Atención</td> <td></td></tr><tr><td><b>Reg.</b>2<br> <strong>Doc.</strong>INFORME 000001-GRH-GRPPAT/SGDIS-waguirre<br> <strong>Remitente:</strong><br>SUB GERENCIA DE DESARROLLO INSTITUCIONAL Y SISTEMAS<strong>Asunto:</strong>Una vez que bajes del vehículo, observarás varios comercios dentro de la estación de autobuses. No entres, venden muy caro.</td> <td><strong>Destino:</strong>En respuesta a lo solicitado<br> <strong>Proveiodo</strong>Conocimiento</td> <td></td></tr><tr><td><b>Reg.</b>3<br> <strong>Doc.</strong>INFORME 000002-GRH-GRPPAT/SGDIS-JRCS<br> <strong>Remitente:</strong><br>SUB GERENCIA DE DESARROLLO INSTITUCIONAL Y SISTEMAS<strong>Asunto:</strong>Una vez que haya desembalado su paquete, proceda como sigue: retire este instructivo y léalo antes de comenzar</td> <td><strong>Destino:</strong>Preparacion de expediente<br> <strong>Proveiodo</strong>Tramite</td> <td></td></tr></tbody>";
                                    table.innerHTML = htmlString;
                                    doc1.autoTable({html: table});
                                    doc1.save('table.pdf');*/
                  config.orientation = 'p'
                  configTable.columns = [
                    { header: 'N°', dataKey: 'id', width: 1*factor },
                    { header: 'Reg. | Doc. | Folios | Remitente | Asunto', dataKey: 'doc', width: 42*factor },
                    { header: 'Destino | Proveido', dataKey: 'destino', width: 28*factor },
                    { header: 'Firma', dataKey: 'firma', width: 35*factor }
                  ]
                  header = [
                    {
                      text:
                        this.formData.tipo_formato == 2
                          ? 'FORMATO DOCUMENTOS DERIVADOS'
                          : 'FORMATO DOCUMENTOS RECIBIDOS',
                      x: 85,
                      y: 15
                    },
                    { text: 'Del: ' + this.formData.docu_fecha_desde, x: 95, y: 20 }
                  ]
                  total = reponse.data.length
                }
                break
              case 8:
                {
                  config.orientation = 'p'
                  configTable.margin.top = 20
                  configTable.columns = [
                    { header: 'Descripcion', dataKey: 'arch_nombre' },
                    { header: 'Archivador de:', dataKey: 'adm_name' },
                    { header: 'Periodo', dataKey: 'arch_periodo' }
                  ]
                  header = [{ text: 'ARCHIVADORES', x: 85, y: 15 }]
                  total = reponse.data.length
                }
                break
              case 9:
                {
                  configTable.margin.top = 65
                  configTable.bodyStyles.fontSize = 7
                  configTable.headStyles.fontSize = 7
                  configTable.theme = 'grid'
                  configTable.columns = [
                    { header: 'Origen.', dataKey: 'oficina_origen', width: 30 },
                    { header: 'Destino.', dataKey: 'oficina_destino', width: 30 },
                    { header: 'Proveido', dataKey: 'oper_acciones', width: 30 }
                  ]
                  config.orientation = 'p'
                  config.format = 'a5'
                  var d = new jsPDF(config)
                  header = [
                    { text: 'N° de registro:', x: 15, y: 20, t: 'bold' },
                    { text: 'N° de Fecha: ', x: 70, y: 20, t: 'bold' },
                    { text: 'Folios: ', x: 115, y: 20 },
                    { text: 'N° de expediente:', x: 15, y: 25, t: 'bold' },
                    { text: 'Remitente:', x: 15, y: 30, t: 'bold' },
                    { text: 'Cargo:', x: 15, y: 35, t: 'bold' },
                    { text: 'Documento:', x: 15, y: 40, t: 'bold' },
                    { text: 'Asunto:', x: 15, y: 45, t: 'bold' }
                  ]
                  cuerpo = [
                    { text: reponse.data[0].oper_iddocumento, x: 39, y: 20, t: 'bold' },
                    { text: reponse.data[0].docu_fecha_doc, x: 88, y: 20, t: 'normal' },
                    { text: String(reponse.data[0].docu_folios), x: 125, y: 20, t: 'normal' },
                    { text: reponse.data[0].docu_idexma, x: 39, y: 25, t: 'bold' },
                    { text: reponse.data[0].docu_firma, x: 39, y: 30, t: 'normal' },
                    { text: reponse.data[0].docu_cargo, x: 39, y: 35, t: 'normal' },
                    { text: reponse.data[0].tdoc_descripcion, x: 39, y: 40, t: 'normal' },
                    { text: d.splitTextToSize(reponse.data[0].docu_asunto, 210), x: 39, y: 45, t: 'normal' }
                  ]
                  d.setFontSize(8)
                  configTable.margin.top = 46 + 6 * d.splitTextToSize(reponse.data[0].docu_asunto, 210).length
                  d.autoTable(configTable)
                  d.text(this.titulo, 10, 10)
                  d.text('HOJA DE TRAMITE', 60, 15)
                  for (var j = 0; j < header.length; j++) {
                    d.setFontType(header[j].t)
                    d.text(header[j].text, header[j].x, header[j].y)
                    d.setFontType(cuerpo[j].t)
                    d.text(cuerpo[j].text, cuerpo[j].x, cuerpo[j].y)
                  }
                  window.open(d.output('bloburl', { filename: pdfName + '.pdf' }), '_blank')
                }
                break
              case 10:
                {
                  configTable.margin.top = 20
                  configTable.columns = [
                    { header: 'Reg.', dataKey: 'oper_iddocumento', width: 10*factor },
                    { header: 'Fecha', dataKey: 'created_at', width: 15*factor },
                    { header: 'Documento', dataKey: 'tdoc_descripcion', width: 30*factor },
                    { header: 'OficinaOri.', dataKey: 'depe_nombre', width: 33*factor },
                    { header: 'Remitente', dataKey: 'remite', width: 20*factor },
                    { header: 'OficinaDes.', dataKey: 'oficina_destino', width: 33*factor },
                    { header: 'UsuarioDes.', dataKey: 'usuario_destino', width: 15*factor },
                    { header: 'dias', dataKey: 'dias', width: 5*factor }
                  ]
                  header = [{ text: 'DOCUMENTOS EN PROCESOS BLOQUEADOS', x: 110, y: 15 }]
                  total = reponse.data.length
                }
                break
              case 11:
                {
                  configTable.margin.top = 20
                  configTable.columns = [
                    { header: 'Reg.', dataKey: 'oper_iddocumento', width: 10*factor },
                    { header: 'Fecha', dataKey: 'created_at', width: 15*factor },
                    { header: 'Documento', dataKey: 'tdoc_descripcion', width: 30*factor },
                    { header: 'OficinaOri.', dataKey: 'depe_nombre', width: 33*factor },
                    { header: 'Remitente', dataKey: 'remite', width: 20*factor },
                    { header: 'OficinaDes.', dataKey: 'oficina_destino', width: 33*factor },
                    { header: 'UsuarioDes.', dataKey: 'usuario_destino', width: 15*factor },
                    { header: 'dias', dataKey: 'dias', width: 5*factor }
                  ]
                  header = [{ text: 'DOCUMENTOS POR RECIBIR BLOQUEADOS', x: 110, y: 15 }]
                  total = reponse.data.length
                }
                break
              case 12:
                {
                  configTable.margin.top = 20
                  configTable.columns = [
                    { header: 'Sede', dataKey: 'sede', width: 40*factor },
                    { header: 'Unidad Organica', dataKey: 'depe_nombre', width: 70*factor },
                    { header: 'Usuarios', dataKey: 'usuarios', width: 10*factor },
                    { header: 'Usuarios_acti_vigente', dataKey: 'usuarios_activos_vigentes', width: 20*factor },
                    { header: 'Admins_acti_vigente', dataKey: 'admins_activos_vigentes', width: 20*factor }
                  ]
                  header = [{ text: 'RESUMEN DE USUARIOS POR DEPENDENCIA', x: 110, y: 15 }]
                  total = reponse.data.length
                }
                break
              case 13:
                {
                  configTable.margin.top = 20
                  configTable.columns = [
                    { header: 'Sede', dataKey: 'sede', width: 35*factor },
                    { header: 'Unidad Organica', dataKey: 'depe_nombre', width: 50*factor },
                    { header: 'Nombre', dataKey: 'adm_name', width: 38*factor },
                    { header: 'Cargo', dataKey: 'adm_cargo', width: 30*factor },
                    { header: 'Estado', dataKey: 'adm_estado', width: 10*factor }
                  ]
                  header = [{ text: 'RELACIÓN DE USUARIOS', x: 125, y: 15 }]
                  total = reponse.data.length
                }
                break
              case 14: {
                config.orientation = 'p'
                configTable.margin.top = 20
                configTable.columns = [
                  { header: 'NOMBRE', dataKey: 'depe_nombre' },
                  { header: 'TOTAL', dataKey: 'total' }
                ]
                header = [{ text: 'DOCUMENTOS EXTERNO X DEPENDENCIA', x: 80, y: 15 }]
                //total = reponse.data.length;
                let reducer = function(accumulator, currentValue) {
                  accumulator += parseInt(currentValue.total)
                  return accumulator
                }
                total = reponse.data.reduce(reducer, 0)
                break
              }
            }

            if (this.formData.opcion[0].id == 6) {
              for (var i = 1; i < configTable.columns.length; i++) {
                Object.defineProperty(configTable.columnStyles, configTable.columns[i].dataKey, {
                  value: {
                    cellPadding: this.espaciado,
                    haling: 'right',
                    valign: 'middle',
                    cellWidth: configTable.columns[i].width
                  },
                  writable: true,
                  enumerable: true,
                  configurable: true
                })
              }
            } else {
              for (var i = 0; i < configTable.columns.length; i++) {
                Object.defineProperty(configTable.columnStyles, configTable.columns[i].dataKey, {
                  value: {
                    haling: 'right',
                    valign: 'middle',
                    cellWidth: configTable.columns[i].width
                  },
                  writable: true,
                  enumerable: true,
                  configurable: true
                })
              }
            }
            //console.log(configTable.columnStyles);
            if (this.formData.opcion[0].id != 9) {
              var doc = new jsPDF(config)
              doc.setFontSize(10)
              doc.autoTable(configTable)
              //pagination
              var pageCount = doc.internal.getNumberOfPages()
              for (var i = 0; i < pageCount; i++) {
                doc.setPage(i)
                doc.text(doc.internal.getCurrentPageInfo().pageNumber + '/' + pageCount, 10, 10)
                doc.text(this.titulo, 23, 10)
                for (var j = 0; j < header.length; j++) {
                  doc.text(header[j].text, header[j].x, header[j].y)
                }
              }
              doc.setPage(pageCount)
              if (config.orientation == 'l') {
                doc.text('Total: ' + total.toString(), 10, 200)
              } else {
                doc.text('Total: ' + total.toString(), 10, 288)
              }

              window.open(doc.output('bloburl', { filename: pdfName + '.pdf' }), '_blank')
              //doc.save(pdfName + '.pdf');
            }
          } else {
            alert('Elija otras condicionales, no hay datos que mostrar')
          }
          this.getting = false
        })
      }
    },

    generarExcel() {
      if (!this.getting) {
        this.getting = true
        axios.get(this.routeReporte, { params: this.formData }).then(reponse => {
          console.log('ok')

          if (reponse.data.length > 0) {
            var wscols = []
            switch (this.formData.opcion[0].id) {
              case 1:
                {
                  wscols = [{ wch: 15 }, { wch: 15 }, { wch: 15 }, { wch: 50 }, { wch: 10 }, { wch: 50 }]
                }
                break
              case 2:
                {
                  wscols = [
                    { wch: 10 },
                    { wch: 20 },
                    { wch: 50 },
                    { wch: 15 },
                    { wch: 10 },
                    { wch: 50 },
                    { wch: 30 },
                    { wch: 40 },
                    { wch: 40 },
                    { wch: 40 }
                  ]
                }
                break
              case 3:
                {
                  wscols = [
                    { wch: 10 },
                    { wch: 15 },
                    { wch: 40 },
                    { wch: 15 },
                    { wch: 10 },
                    { wch: 50 },
                    { wch: 25 },
                    { wch: 35 },
                    { wch: 35 },
                    { wch: 50 },
                    { wch: 20 },
                    { wch: 30 }
                  ]
                }
                break
              case 4:
                {
                  wscols = [
                    { wch: 10 },
                    { wch: 20 },
                    { wch: 10 },
                    { wch: 50 },
                    { wch: 15 },
                    { wch: 10 },
                    { wch: 50 },
                    { wch: 30 },
                    { wch: 40 },
                    { wch: 40 },
                    { wch: 40 }
                  ]
                }
                break
              case 5:
                {
                  wscols = [
                    { wch: 15 },
                    { wch: 18 },
                    { wch: 45 },
                    { wch: 50 },
                    { wch: 50 },
                    { wch: 30 },
                    { wch: 50 },
                    { wch: 15 },
                    { wch: 25 }
                  ]
                }
                break
              case 7:
                {
                  wscols = [
                    { wch: 12 },
                    { wch: 12 },
                    { wch: 15 },
                    { wch: 15 },
                    { wch: 15 },
                    { wch: 40 },
                    { wch: 10 },
                    { wch: 40 },
                    { wch: 30 },
                    { wch: 30 },
                    { wch: 50 },
                    { wch: 15 },
                    { wch: 40 },
                    { wch: 20 },
                    { wch: 20 },
                    { wch: 35 },
                    { wch: 20 }
                  ]
                }
                break
              case 8:
                {
                  wscols = [{ wch: 40 }, { wch: 40 }, { wch: 20 }]
                }
                break
              case 12:
                {
                  wscols = [{ wch: 50 }, { wch: 50 }, { wch: 20 }, { wch: 20 }, { wch: 20 }]
                }
                break
              case 13:
                {
                  wscols = [{ wch: 40 }, { wch: 50 }, { wch: 40 }, { wch: 30 }, { wch: 10 }]
                }
                break
            }
            var hoja = xlsx.utils.json_to_sheet(reponse.data)
            hoja['!cols'] = wscols
            var wb = xlsx.utils.book_new() // make Workbook of Excel
            xlsx.utils.book_append_sheet(wb, hoja, 'reporte') // sheetAName is name of Worksheet
            // export Excel file
            xlsx.writeFile(wb, 'reporte.xlsx') // name of the file is 'book.xlsx'
          } else {
            alert('No existen datos que mostar')
          }

          this.getting = false
        })
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
