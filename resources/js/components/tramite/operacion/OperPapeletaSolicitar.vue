<template>
  <div class="container">
    <div class="panel-group">
      <form action="" @submit.prevent="guardarDocumento()">
        <div class="panel panel-primary">
          <div class="panel-heading">SOLICITAR NUEVA PAPELETA</div>
          <div class="panel-body">
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-8">
                <label for="">Justificación</label>
                <textarea
                  :value="formData.docu_asunto != null ? formData.docu_asunto.toUpperCase() : null"
                  cols="3"
                  rows="2"
                  class="form-control"
                  @input="formData.docu_asunto = $event.target.value.toUpperCase()"
                ></textarea>
              </div>
              <div class="col-sm-4">
                <label>Fecha Documento</label>
                <input v-model="formData.docu_fecha_doc" type="date" class="form-control" />
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-6">
                <label>Destino</label>
                <input
                  type="text"
                  :value="formData.docu_detalle != null ? formData.docu_detalle.toUpperCase() : null"
                  class="form-control"
                  @input="formData.docu_detalle = $event.target.value.toUpperCase()"
                />
              </div>
              <div class="col-sm-4">
                <label>Motivo de salida</label>
                <select v-model="formData.docu_justificacion" class="form-control">
                  <option :value="null">Seleccione</option>
                  <option value="COMISIÓN">COMISIÓN</option>
                  <option value="SALUD">SALUD</option>
                  <option value="PARTICULAR">PARTICULAR</option>
                  <option value="COBRO DE HABERES 1H">COBRO DE HABERES 1H</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div v-if="$route.params.id == null" class="row form-group" style="width: 100%;margin-left: -0px;">
          <derivar-c :derivaciones="derivaciones" />
        </div>
        <div class="panel panel-primary">
          <div v-if="$route.params.id == null" class="panel-body text-right">
            <button class="btn btn-primary" type="submit">Registrar</button>
          </div>
          <div v-else class="panel-body text-right">
            <button class="btn btn-primary" type="submit">Actualizar</button>
          </div>
        </div>
      </form>
    </div>
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
                <strong>{{ ('00000000' + documento.iddocumento).slice(-8) }}</strong>
              </ul>
            </div>
            <div class="form-group">
              <label>Nuevo Reg. Expediente</label>
              <ul v-if="documento != null">
                <strong>{{ ('00000000' + documento.docu_idexma).slice(-8) }}</strong>
              </ul>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="moverSolicitados()">
              Aceptar
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  
  props: [
    'route-guardar',
    'route-get-papeleta',
    'route-correlativo',
    'user-id',
    'user-dependencia',
    'user-cargo',
    'user-name',
    'user-inicial',
    'tipo-doc-papeleta'
  ],  

  data() {
    return {
      formData: {
        iddocumento: null,
        docu_idexma: null,
        docu_idprioridad: 1,
        docu_origen: 1,
        docu_tipo: false, //personal, de la oficina
        docu_iddependencia: null,
        docu_firma: this.userName,
        docu_cargo: this.userCargo,
        docu_detalle: null,
        docu_fecha_doc: null,
        docu_idtipodocumento: this.tipoDocPapeleta,
        docu_siglas_doc: null,
        docu_numero_doc: null,
        docu_idusuario: this.userId,
        docu_idusuariodependencia: this.userDependencia,
        docu_proyectado: null,
        docu_idrecepcion: 1,
        docu_folios: null,
        docu_asunto: null,
        docu_clastupa: 9,
        docu_diasatencion: null,
        docu_justificacion: null,
        docu_archivo: null,
        docu_dni: null,
        docu_ruc: null,
        docu_telef: null,
        docu_domic: null,
        correlativo: null
      },
      derivaciones: [],
      documento: {}
    }
  },
  
  computed: {
    ...Vuex.mapGetters(['getDependenciaUser'])
  },

  mounted() {
    this.obtenerDependenciaUser().then(response => {
      this.montar()
    })

    var date = new Date() // Or the date you'd like converted.
    var isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
    this.formData.docu_fecha_doc = isoDate.slice(0, 10)

    this.montar()

    this.obtenerCorrelativo()

    if (this.$route.name === 'OperPapeletaEdit') {
      this.obtenerDocumento()
    }
  },

  methods: {
    ...Vuex.mapActions(['obtenerDependenciaUser']),

    guardarDocumento() {
      this.formData.docu_asunto = this.formData.docu_justificacion + '/' + this.formData.docu_asunto
      const parameters = {
        documento: this.formData,
        derivaciones: this.derivaciones
      }
      axios.post(this.routeGuardar, parameters).then(respose => {
        console.log('guardado')
        this.documento = respose.data
      })
      if (this.$route.params.id == 0 || this.$route.params.id == null) {
        $('#nuevoRegistro').modal()
      } else {
        this.moverSolicitados()
      }
    },

    montar() {
      this.formData.docu_iddependencia = this.getDependenciaUser.iddependencia
      this.formData.docu_siglas_doc = this.getDependenciaUser.depe_sigla + '-' + this.userInicial
    },

    obtenerDocumento() {
      axios.get(this.routeGetPapeleta.replace(/%s/g, this.$route.params.id)).then(response => {
        this.formData = response.data
      })
    },

    obtenerCorrelativo() {
      const parameters = {
        tdco_idtipodocumento: this.formData.docu_idtipodocumento,
        tdco_iddependencia: this.formData.docu_idusuariodependencia,
        tdco_idusuario: this.formData.docu_idusuario,
        tdco_periodo: this.formData.docu_fecha_doc.substring(0, 4)
      }
      axios.post(this.routeCorrelativo, parameters).then(response => {
        if (response.data.id >= 1) {
          this.formData.docu_numero_doc = ('000000' + response.data.tdco_numero).slice(-6)
          this.formData.correlativo = response.data.id
        } else {
          this.formData.docu_numero_doc = '000001'
          this.formData.correlativo = null
        }
      })
    },

    moverSolicitados() {
      this.$router.push('/tramite/papeleta/solicitarPapeleta')
    }
  }
}
</script>
