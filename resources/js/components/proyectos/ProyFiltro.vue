<template>
  <div class="ListadoFiltros">
    <div class="d-flex justify-content-end">
      <div class="row Filtros m-1 mb-2">
        <div class="col-12 col-sm-6 FiltrosGrupo">
          <label>Nombre</label>
          <v-text-field
            v-model="formData.proy_nombre"
            class="FiltrosInput"
            :hide-details="true"
          />
        </div>

        <div class="col-12 col-sm-3 FiltrosGrupo">
          <label>Cod. SIAF</label>
          <v-text-field
            v-model="formData.proy_cod_siaf"
            class="FiltrosInput"
            :hide-details="true"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Vuex from 'vuex'

  export default {
    name: 'ProyFiltro',
    props: {
      formData: Object,
    },
  }
</script>

<style scoped>

</style>
