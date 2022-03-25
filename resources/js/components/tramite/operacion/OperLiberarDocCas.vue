<template>
  <div>
    <div class="panel panel-primary">
      <div class="panel-heading">
        Liberar Documentos Registrados en el proceso CAS donde no entregaron el expediente fisico
      </div>
      <div class="panel-body">
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
          <div class="col-sm-2">
            <label>Ingrese Expediente</label>
          </div>
          <div class="col-sm-4">
            <input v-model="formData.docu_idexma" type="text" class="form-control" />
          </div>
          <div class="col-sm-2">
            <button class="btn btn-sm btn-primary" @click="obtenerDocBloqueo()">Buscar documentos</button>
          </div>
          <div class="col-sm-2">
            <button class="btn btn-sm btn-secundary" @click="liberarDocCas()">Liberar</button>
          </div>
        </div>
      </div>
    </div>
    <docu-bloqueo :doc-bloqueados="docBloqueados" />
  </div>
</template>
<script>
export default {

  props:{
          routeDocRecibir:{
              type: String,
              default: ''
            }, 
          routeLiberarCas:{
              type: String,
              default: ''
            }
        },
  
  data() {
    return {
      formData: {
        docu_idexma: null
      },
      docBloqueados: {}
    }
  },

  methods: {
    obtenerDocBloqueo() {
      axios.get(this.routeDocRecibir, { params: this.formData }).then(response => {
        this.docBloqueados = response.data
      })
    },

    liberarDocCas() {
      if (confirm('Esta seguro de liberar los documentos del proceso CAS?')) {
        if (this.formData.docu_idexma > 0) {
          const params = {
            liberarCas: this.formData
          }
          axios.post(this.routeLiberarCas, params).then(response => {
            if (response.data.length > 0) {
              this.obtenerDocBloqueo()
              alert('Documentos Liberados')
            } else {
              alert('no hay documentos que liberar con el expediente:' + ' ' + this.formData.docu_idexma)
            }
          })
        } else {
          alert('Digite bien el expediente')
        }
      }
    }
  }
}
</script>
