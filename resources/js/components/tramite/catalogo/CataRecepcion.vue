<template>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel-group">
        <div class="panel panel-primary">
          <div class="panel-heading">FORMAS DE RECEPCION</div>
          <div class="panel-body">
            <div class="box">
              <div class="box-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="info">
                      <th>ID</th>
                      <th>DESCRIPCION</th>
                      <th>ABREVIATURA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(recepcion, index) in recepciones" :key="index">
                      <td>{{ recepcion.idrecepcion }}</td>
                      <td>{{ recepcion.rece_descripcion }}</td>
                      <td>{{ recepcion.rece_abreviado }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {

  props:{
          routeRecepcion:{
              type: String,
              default: ''
            }
        },
  
  data() {
    return {
      recepciones: {}
    }
  },

  mounted() {
    this.obtenerRecepciones()
  },

  methods: {
    obtenerRecepciones() {
      axios.get(this.routeRecepcion).then(response => {
        this.recepciones = response.data
      })
    }
  }
}
</script>
