<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Roles</div>
      <div class="panel-body">
        <form action=""></form>
      </div>
      <div class="box">
        <table class="table table-bordered table-condensed table-hover">
          <thead>
            <tr class="info">
              <th style="font-size:13px; font-family: Tahoma" nowrap>ID</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>Nombre</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>SLUG</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>descripción</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>SPECIAL</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>Editar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(rol, index) in roles" :key="index">
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ rol.id }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ rol.name }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ rol.slug }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ rol.description }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ rol.special }}</td>
              <td>
                <router-link :to="{ name: 'editRol', params: { id: rol.id } }">
                  <a class="btn btn-info glyphicon glyphicon-pencil"></a>
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
export default {

  props:{
            routeRoles:{
              type: String,
              default: ''
            }
        },

  data() {
    return {
      roles: {}
    }
  },

  mounted() {
    this.buscarRoles()
  },

  methods: {
    buscarRoles() {
      axios.get(this.routeRoles).then(response => {
        this.roles = response.data
      })
    }
  }
}
</script>
