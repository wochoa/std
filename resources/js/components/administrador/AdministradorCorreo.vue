<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Roles</div>
      <div class="panel-body">
        <form action="" @submit.prevent="buscarCorreos">
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-3">
              <br />
              <input v-model="filtro.dni" type="text" placeholder="DNI" class="form-control" />
            </div>
            <div class="col-sm-3">
              <br />
              <button type="submit" class="btn btn-sm btn-primary">
                <span class="glyphicon glyphicon-search"></span>Buscar
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="box">
        <pagination :data="correos" :limit="3" @pagination-change-page="buscarCorreos" />
        <table class="table table-bordered table-condensed table-hover">
          <thead>
            <tr class="info">
              <th style="font-size:13px; font-family: Tahoma" nowrap>ID</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>Nombre</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>DNI</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>RUC</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>CORREO</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>Estado</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>Editar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(correo, index) in correos.data" :key="index">
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ correo.id }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ correo.persona_dni != null? (correo.persona.prenombres+" "+correo.persona.apPrimer+" "+correo.persona.apSegundo):(correo.ruc.ddp_nombre) }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ correo.persona_dni }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ correo.persona_ruc }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ correo.correo }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ correo.estado === 1?'ACTIVO':'INACTIVO' }}</td>
              <td>
                <button class="btn btn-warning" type="button" @click="editCorreo(correo)">
                  <span class="icon icon-undo2 fs-18"> Editar</span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <pagination :data="correos" :limit="3" @pagination-change-page="buscarCorreos" />
      </div>
      <!-- Modal editar-->
      <div id="editar" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Editar Correo</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Correo a Editar</label>
                <p v-if="formCorreo.persona_dni != null"><strong>DNI: </strong>{{ formCorreo.persona_dni }}</p>
                <p v-else><strong>RUC: </strong>{{ formCorreo.persona_ruc }}</p>
              </div>
              <div class="form-group">
                <label>Correo Electrónico</label>
                <input
                  v-model="formCorreo.correo"
                  type="email"
                  class="form-control"
                />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal" @click="editar">
                Guardar
              </button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'AdministradorCorreo',

    data () {
      return {
        correos: {},
        formCorreo:{
          id: null,
          persona_dni: null,
          persona_ruc: null,
          correo: null,
        },
        filtro:{
          dni: null,
          page: null
        }
      }
    },

    mounted () {
      this.buscarCorreos()
    },

    methods: {
      buscarCorreos (page = 1) {
        this.filtro.page = page
        axios.get('/tramite/persona/correos', { params: this.filtro }).then(response => {
          this.correos = response.data
        })
      },
      editCorreo (item) {
        $('#editar').modal()
        this.formCorreo = JSON.parse(JSON.stringify(item))
      },

      editar(){
        axios.post('/tramite/persona/correos/store', this.formCorreo).then( response => {
          console.log('guardado')
          this.buscarCorreos()
        })
      }
    }
  }
</script>

<style scoped>

</style>
