<template>
  <div class="panel panel-info">
    <div class="panel-heading">EXPEDIENTE</div>
    <div class="panel-body">
      <form action="" @submit.prevent="buscarExpediente">
        <div class="col-xs-4 col-sm-4 col-lg-4"></div>
        <div class="col-xs-4 col-sm-4 col-lg-4 text-center">
          <label>Expediente</label>
          <input
            v-model="expediente.iddocumentomain"
            class="form-control text-center"
            type="text"
            placeholder="N°"
            name="exma_id"
            @change="buscarExpediente"
          />
        </div>
        <div class="col-xs-4 col-sm-4 col-lg-4"></div>
        <div class="col-xs-12 col-sm-12 col-lg-12 text-center">
          <div v-if="expediente.created_at != null">expediente creado el {{ expediente.created_at}}</div>
          <div v-if="expediente.doc.length >0">
            <strong>{{
              getDocumentoNombre(expediente.doc[0].docu_idtipodocumento) +
              ' ' +
              (expediente.doc[0].docu_numero_doc != null
              ? ('000000' + expediente.doc[0].docu_numero_doc).slice(-6)
              : '____') +
              ' ' +
              expediente.doc[0].docu_siglas_doc
              }}</strong>
            -> {{ expediente.doc[0].docu_asunto }}
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'ExterExpedienteBuscar',
    props:{
      expediente:{
        type: Object,
        default: () => ({
          created_at: value,
          doc: value,
        })
      },
      origenFirst:{
        type: Boolean,
        default: false
      }
    },

    data() {
      return {
        iddocumentomain: null
      }
    },

    computed: {
      ...Vuex.mapGetters(['getDocumentoNombre'])
    },

    mounted () {
      this.obtenerDocumentos()
    },

    updated: function() {
      this.$nextTick(function() {
        if (this.expediente.iddocumentomain != null && this.origenFirst) {
          this.buscarExpediente()
        }
      })
    },

    methods: {
      ...Vuex.mapActions(['obtenerDocumentos']),

      setIddocumento(id) {
        this.expediente.iddocumentomain = id
      },
      buscarExpediente() {
        const params = {
          id: this.expediente.iddocumentomain
        }
        axios.post('/tramite/expediente/buscar', params).then(response => {
          if (response.data.length != '') {
            const expediente = response.data
            this.$emit('find', expediente)
            this.expediente.iddocumentomain = ('00000000' + this.expediente.iddocumentomain).slice(-8)
          } else {
            toastr.error('el expediente no existe!')
            this.iddocumentomain = null
            this.$emit('find', {})
          }
        })
      }
    }
  }
</script>

<style scoped>

</style>
