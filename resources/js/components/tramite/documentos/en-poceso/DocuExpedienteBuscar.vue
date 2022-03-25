<template>
  <div :class="'panel ' + (viewer ? 'panel-info' : 'panel-primary')">
    <div class="panel-body">
      <form action="" @submit.prevent="buscarExpediente">
        <div class="col-xs-2 col-sm-2 col-lg-2">Expediente</div>
        <div class="col-xs-2 col-sm-2 col-lg-2 text-center">
          <input
            v-model="expediente.iddocumentomain"
            class="form-control text-center"
            type="text"
            placeholder="N°"
            name="exma_id"
            :disabled="$route.name === 'DocuResponse'"
            @change="buscarExpediente"
          />
        </div>
        <div class="col-xs-8 col-sm-8 col-lg-8">
          <div v-if="expediente.created_at != null">expediente creado el {{ expediente.created_at }}</div>
          <div v-if="expediente.doc.length >0">
            <strong>{{
              getTipoDocumentoNombre(expediente.doc[0].docu_idtipodocumento) +
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
  import Vuex from 'vuex'
export default {
  
  name: 'DocuExpediente',

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
            },
          viewer:{
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
    ...Vuex.mapGetters(['getRuta', 'getTipoDocumentoNombre'])
  },

  mounted() {
    //console.log("buscador montado")
  },

  updated: function() {
    this.$nextTick(function() {
      if (this.expediente.iddocumentomain != null && this.origenFirst) {
        this.buscarExpediente()
      }
    })
  },
  
  methods: {
    setIddocumento(id) {
      this.expediente.iddocumentomain = id
    },
    buscarExpediente() {
      const params = {
        id: this.expediente.iddocumentomain
      }
      axios.post(this.getRuta('tramite.expediente.buscar'), params).then(response => {
        if (response.data.length != '') {
          const expediente = response.data
          this.$emit('find', expediente)
          this.expediente.iddocumentomain = ('00000000' + this.expediente.iddocumentomain).slice(-8)
        } else {
          toastr.error('el expediente no existe!')
          this.iddocumentomain = null
          this.$emit('find', {
            iddocumentomain: null,
            doc            : []
          })
        }
      })
    }
  }
}
</script>

<style scoped></style>
