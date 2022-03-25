<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Publicaciones</div>
      <div class="panel-body"></div>
      <div class="box">
        <pagination :data="publicaciones" :limit="limit" @pagination-change-page="buscarPublicaciones" />
        <table class="table table-bordered table-condensed table-hover">
          <thead>
            <tr class="info">
              <th style="font-size:13px; font-family: Tahoma" nowrap>ID</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>SUSTENTO</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>IMAGEN</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>F. INICIO</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>F. FIN</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>ESTADO</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>Editar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(publi, index) in publicaciones.data" :key="index">
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ publi.id }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ publi.sustento }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>
                <img :src="publicarImagenes(publi.id)" alt="" height="80" />
              </td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ publi.fecha_inicio }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ publi.fecha_fin }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>
                {{ publi.estado == 1 ? 'Activo' : 'Inactivo' }}
              </td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>
                <router-link :to="{ name: 'editComunicacionInterna', params: { id: publi.id } }">
                  <a class="btn btn-info glyphicon glyphicon-pencil" title="Editar"></a>
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
        <pagination :data="publicaciones" :limit="limit" @pagination-change-page="buscarPublicaciones" />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      formData: {
        page: null
      },
      publicaciones: {}
    }
  },

  mounted() {
    this.buscarPublicaciones()
  },

  props:{
          limit:{
              type: Number,
              default: 3
            }, 
          routePublicacion:{
              type: String,
              default: ''
            }, 
          routePrintImagenes:{
              type: String,
              default: ''
            }
        },

  methods: {
    buscarPublicaciones(page = 1) {
      this.formData.page = page
      axios.get(this.routePublicacion, { params: this.formData }).then(response => {
        this.publicaciones = response.data
      })
    },

    publicarImagenes(id) {
      return this.routePrintImagenes.replace(/%s/g, id)
    }
  }
}
</script>
