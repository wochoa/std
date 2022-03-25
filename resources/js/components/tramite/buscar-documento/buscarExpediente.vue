<template>
  <div>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><strong>Expediente: </strong>{{ formData.iddocumento }}</h4>
      <span class="modal-title"><strong>Registros del expediente:</strong></span>
    </div>
    <div class="modal-body">
      <div class="panel panel-primary">
        <div class="panel-body">
          <table class="table table-bordered table-condensed table-hover">
            <thead>
              <tr class="info">
                <th style="width:7%">Registro</th>
                <th style="width:8%">Fecha</th>
                <th style="width:20%">Documento</th>
                <th style="width:30%">Asunto</th>
                <th style="width:15%">Firma</th>
                <th style="width:30%">Unidad Org.</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(exp, index) in expediente" :key="index">
                <td>
                  <a href="#" @click.prevent="recargar(exp.iddocumento)">{{ ('00000000' + exp.iddocumento).slice(-8) }}</a>
                </td>
                <td>{{ exp.docu_fecha_doc }}</td>
                <td>
                  {{
                    exp.tdoc_descripcion +
                      ' ' +
                      ('000000' + exp.docu_numero_doc).slice(-6) +
                      (exp.docu_origen == 1 ? '-' + exp.docu_fecha_doc.substr(0, 4) : '') +
                      (exp.docu_siglas_doc != null ? '-' + exp.docu_siglas_doc : '')
                  }}
                </td>
                <td>{{ exp.docu_asunto }}</td>
                <td>{{ exp.docu_firma }}</td>
                <td>{{ exp.depe_nombre }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" @click="imprimirExpediente()">Imprimir</button>
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
            }, 
          formData:{ 
              type: Object,
              default: () => ({})
            }
        },
  
  data() {
    return {
      expediente: {}
    }
  },

  mounted() {
    if (this.formData.iddocumento != null) this.buscarExpediente()
  },

  methods: {
    buscarExpediente() {
      axios.get(this.routeExpediente, { params: this.formData }).then(response => {
        if (response.data.length > 0) {
          this.expediente = response.data
          //$("#expediente").modal();
        } else {
          alert('No hay datos que mostrar, el registro no existe')
        }
      })
    },

    imprimirExpediente() {
      window.print()
    },

    recargar(iddocumento) {
      window.location.assign(this.routeDocumento.replace(/%s/g, iddocumento))
    }
  }
}
</script>
<style scoped>
.table tbody tr td,
.table thead tr th {
  font-size: 10px;
  font-family: Tahoma;
  vertical-align: middle;
}
</style>
