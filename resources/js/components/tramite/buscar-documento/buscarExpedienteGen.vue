<template>
  <div>
    <form action="" class="NavbarSearch" @submit.prevent="buscarExpedientePopup()">
      <input  v-model="formData.iddocumento" type="text" class="form-control" placeholder="Buscar Expediente" />
      <button type="submit" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-search"></span></button>
    </form>
    <!-- Modal buscar expediente-->
    <div id="expediente" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <buscar-expediente ref="exp" :form-data="formData" :route-expediente="routeExpediente" />
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  
  props:{
          routeExpediente:{
              type: String,
              default: ''
            }, 
          routeDocumento:{
              type: String,
              default: ''
            }
        },
  
  data() {
    return {
      formData: {
        iddocumento: null
      }
    }
  },

  methods: {
    buscarExpediente() {
      if (this.formData.iddocumento > 0) {
        this.$refs.exp.buscarExpediente()
      } else {
        alert('Digite bien el registro')
      }
    },

    buscarExpedientePopup() {
      if (this.formData.iddocumento > 0) {
        axios.get(this.routeExpediente, { params: this.formData }).then(response => {
          if (response.data.length > 0) {
            var route = this.routeDocumento
            route = route.replace(/%s/g, this.formData.iddocumento)
            window.open(route, 'visorExp', 'width=1000, height=750')
          } else {
            alert('No hay datos que mostrar, el expediente no existe')
          }
        })
      } else {
        alert('Digite bien el expediente')
      }
    },

    imprimirExpediente() {
      this.$refs.exp.imprimirExpediente()
    }
  }
}
</script>
