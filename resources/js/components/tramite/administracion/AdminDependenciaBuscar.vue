<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">DEPENDENCIA</div>
      <div class="panel-body">
        <form action="" @submit.prevent="buscarDependencia()">
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-3">
              <label for="FormGroup">Código de Dependencia</label>
              <input v-model="formData.iddependencia" type="text" class="form-control" />
            </div>
            <div class="col-sm-6">
              <label for="FormGroup">Nombre</label>
              <input
                v-model="formData.depe_nombre"
                type="text"
                class="form-control"
                @change="formData.depe_nombre = formData.depe_nombre.toUpperCase()"
              />
            </div>
            <div class="col-sm-3">
              <br />
              <button type="submit" class="btn btn-sm btn-primary">
                <span class="glyphicon glyphicon-search"></span>Buscar
              </button>
            </div>
          </div>
        </form>
        <div class="box">
          <div class="box-body">
            <pagination :data="dependencias" :limit="limit" @pagination-change-page="buscarDependencia" />
            <table class="table table-bordered table-condensed table-hover">
              <thead>
                <tr class="info">
                  <th style="font-size:13px; font-family: Tahoma" nowrap>CODIGO</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>NOMBRE DE LA DEPENDENCIA</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>ABREVIADO</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>TIPO</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>RESPONSABLE MESA DE PARTES</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>RESPONSABLE RECLAMOS</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>IPs</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>Horarios MPV</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>Horarios de Asistencia</th>
                  <th style="font-size:13px; font-family: Tahoma" nowrap>Editar</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(dependencia, index) in dependencias.data" :key="index">
                  <td style="font-size:13px; font-family: Tahoma">{{ dependencia.iddependencia }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ dependencia.depe_nombre }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ dependencia.depe_abreviado }}</td>
                  <td style="font-size:13px; font-family: Tahoma">{{ (dependencia.depe_agente === 1)?'AGENTE':''}}</td>
                  <td style="font-size:13px; font-family: Tahoma">
                    {{ (dependencia.adm_name != null)?(dependencia.adm_name + ' ' + dependencia.adm_lastname):'' }}
                  </td>
                  <td style="font-size:13px; font-family: Tahoma">
                    {{ (dependencia.depe_idusuarioreclamo != null)?(dependencia.reclamo + ' ' + dependencia.reclamo1):'' }}
                  </td>
                  <td>
                    <li v-for="(ip, indexIp) in dependencia.ips" :key="indexIp">{{ ip.ip }}</li>
                  </td>
                  <td>
                    <table class="table table-bordered table-condensed table-hover">
                      <thead>
                        <tr v-if="dependencia.schedules.filter( d => d.type === 1).length > 0">
                          <th>Hora entrada</th>
                          <th>Hora salida</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(schedule, indexSchedule) in dependencia.schedules.filter( d => d.type === 1)" :key="indexSchedule">
                          <td>{{ schedule.entry_time }}</td>
                          <td>{{ schedule.output_time }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td>
                    <table class="table table-bordered table-condensed table-hover">
                      <thead>
                        <tr v-if="dependencia.schedules.filter( d => d.type === 0).length > 0">
                          <th>Hora entrada</th>
                          <th>Hora salida</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(schedule, indexSchedule) in dependencia.schedules.filter( d => d.type === 0)" :key="indexSchedule">
                          <td>{{ schedule.entry_time }}</td>
                          <td>{{ schedule.output_time }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td>
                    <!--EDITAR-->
                    <router-link :to="{ name: 'AdminDependenciaEdit', params: { id: dependencia.iddependencia } }">
                      <a class="btn btn-info glyphicon glyphicon-pencil"></a>
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="dependencias" :limit="limit" @pagination-change-page="buscarDependencia" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {

  props: {routeDependencia:{
              type: String,
              default: ''
            },
          limit:{
              type: Number,
              default: 3
            }
          },

  data() {
    return {
      formData: {
        iddependencia: null,
        depe_nombre: null,
        page: null
      },
      mostrarDependencias: false,
      dependencias: {}
    }
  },

  created: function() {
    this.buscarDependencia()
  },

  methods: {
    buscarDependencia(page = 1) {
      this.formData.page = page
      axios.get(this.routeDependencia, { params: this.formData }).then(response => {
        this.dependencias = response.data
        this.mostrarDependencias = true
      });
    }
  }
}
</script>
<style scoped>
input,
textarea {
  text-transform: uppercase;
}
</style>
