<template>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel-group">
        <div class="panel panel-primary">
          <div class="panel-heading">TIPOS DE PRIORIDADES</div>
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
                    <tr v-for="(prioridad, index) in prioridades" :key="index">
                      <td>{{ prioridad.idprioridad }}</td>
                      <td>{{ prioridad.prio_descripcion }}</td>
                      <td>{{ prioridad.prio_abreviado }}</td>
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
          routePrioridad:{
              type: String,
              default: ''
            }
        },
  
  data() {
    return {
      prioridades: {}
    }
  },

  mounted() {
    this.obtenerPrioridad()
  },

  methods: {
    obtenerPrioridad() {
      axios.get(this.routePrioridad).then(response => {
        this.prioridades = response.data
      })
    }
  }
}
</script>
