<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="d-flex flex-wrap align-items-end">
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 text-center">
          <a :href="routes['tramite.enproceso.index'].route">
            <h4>Documentos en Proceso de la Oficina</h4>
            <radial-progress-bar
              :diameter="250"
              :completed-steps="getInicio.derivadosProceso"
              :total-steps="getInicio.totalProceso == 0 ? 1 : getInicio.totalProceso"
              :strokeWidth="30"
              startColor="#5cb85c"
              stopColor="#5cb85c"
              innerStrokeColor="#d3d3d3"
            >
              <p><strong>Total: </strong>{{ getInicio.totalProceso }}</p>
              <p><strong>Derivados: </strong>{{ getInicio.derivadosProceso }}</p>
              <p><strong>Pendientes: </strong>{{ getInicio.totalProceso - getInicio.derivadosProceso }}</p>
            </radial-progress-bar>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 text-center">
          <a :href="routes['tramite.enproceso.index'].route">
            <h4>Documentos en Proceso del Personal</h4>
            <radial-progress-bar
              :diameter="250"
              :completed-steps="getInicio.usuarioDerivadosProceso"
              :total-steps="getInicio.usuarioProceso == 0 ? 1 : getInicio.usuarioProceso"
              :strokeWidth="30"
              startColor="#be334f"
              stopColor="#be334f"
              innerStrokeColor="#d3d3d3"
            >
              <p><strong>Total: </strong> {{ getInicio.usuarioProceso }}</p>
              <p><strong>Derivados: </strong>{{ getInicio.usuarioDerivadosProceso }}</p>
              <a :href="routes['tramite.enproceso.index'].route + '#pendiente'">
                <strong>Pendientes: </strong>{{ getInicio.usuarioProceso - getInicio.usuarioDerivadosProceso }}
              </a>
            </radial-progress-bar>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 text-center">
          <a :href="routes['tramite.recibir.index'].route">
            <h4>Documentos por Recibir</h4>
            <radial-progress-bar
              :diameter="250"
              :completed-steps="getInicio.usuarioRecibir"
              :total-steps="getInicio.totalRecibir == 0 ? 1 : getInicio.totalRecibir"
              :strokeWidth="30"
              startColor="#5cb85c"
              stopColor="#5cb85c"
              innerStrokeColor="#d3d3d3"
            >
              <p><strong>Total: </strong>{{ getInicio.totalRecibir }}</p>
              <p><strong>Personal: </strong>{{ getInicio.usuarioRecibir }}</p>
            </radial-progress-bar>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 text-center">
          <a :href="routes['tramite.archivado.index'].route">
            <h4>Documentos Archivados</h4>
            <radial-progress-bar
              :diameter="250"
              :completed-steps="getInicio.usuarioArchivados"
              :total-steps="getInicio.totalArchivado == 0 ? 1 : getInicio.totalArchivado"
              :strokeWidth="30"
              startColor="#FB275D"
              stopColor="#804040"
              innerStrokeColor="#d3d3d3"
            >
              <p><strong>Total: </strong>{{ getInicio.totalArchivado }}</p>
              <p><strong>Personal: </strong>{{ getInicio.usuarioArchivados }}</p>
              <a :href="routes['tramite.archivado.index'].route + '#temporal'">
                <strong>Temporal: </strong>{{ getInicio.usuariosArchivadosTemporal }}
              </a>
            </radial-progress-bar>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 text-center">
          <a :href="routes['tramite.view.docs.generados'].route">
            <h4>Documentos Generados</h4>
            <radial-progress-bar
              :diameter="250"
              :completed-steps="getInicio.usuarioDocGenerados"
              :total-steps="getInicio.totalDocGenerados == 0 ? 1 : getInicio.totalDocGenerados"
              :strokeWidth="30"
              startColor="#be334f"
              stopColor="#be334f"
              innerStrokeColor="#d3d3d3"
            >
              <p><strong>Total: </strong>{{ getInicio.totalDocGenerados }}</p>
              <p><strong>Personal: </strong>{{ getInicio.usuarioDocGenerados }}</p>
            </radial-progress-bar>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 text-center">
          <a :href="routes['tramite.view.plantilla'].route">
            <h4>Plantillas</h4>
            <radial-progress-bar
              :diameter="250"
              :completed-steps="getInicio.usuarioPlantilla"
              :total-steps="getInicio.totalPlantilla == 0 ? 1 : getInicio.totalPlantilla"
              :strokeWidth="30"
              startColor="#5cb85c"
              stopColor="#5cb85c"
              innerStrokeColor="#d3d3d3"
            >
              <p><strong>Total: </strong>{{ getInicio.totalPlantilla }}</p>
              <p><strong>Personal: </strong>{{ getInicio.usuarioPlantilla }}</p>
            </radial-progress-bar>
          </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 text-center align-self-center">
          <a href="http://data.regionhuanuco.gob.pe/regulations/?reg=89998&tomo=0" target="_blank">
            <h4>Directiva SGD</h4>
            <span class="icon icon-file-play fs-50" aria-hidden="true"style="font-size: 115px; margin-top: 50px"></span>
          </a>
          <a href="http://www.regionhuanuco.gob.pe/oficial/videosDGP.php" target="_blank" style="color:#be334f    ;">
            <h4>Videos Tutoriales</h4>
          </a>
          <a href="https://drive.google.com/file/d/1WWkMr7UFP5Du_8pbjXFd55nBx1ekE4hq/view?usp=sharing" target="_blank">
            <h4>Manual de usuario</h4>
          </a>
          <span class="text-muted"></span>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 text-center align-self-center">
          <span class="badge badge-info">Total Documento ingresado MPV: {{ getInicio.totalMpv }}</span>
          <span class="badge badge-warning">Documento ingresado MPV para el Usuario: {{ getInicio.usuariosMpv }}</span>
          <span class="text-muted"></span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import RadialProgressBar from 'vue-radial-progress'
  import Vuex from 'vuex'

  export default {
    components: {
      RadialProgressBar
    },

    props: {
      routes: {
        type: Object,
        default: () => ({})
      }
    },

    data () {
      return {

      }
    },

    computed: {
      ...Vuex.mapGetters(['getInicio']),
    },

    mounted () {
      this.obtenerTotal()
    },

    methods: {
      ...Vuex.mapActions(['obtenerTotal'])
    }
  }
</script>
<style scoped>

</style>
