<template>
  <div class="panel-group">
    <div class="panel panel-info">
      <div class="panel-heading">CONTROL ASISTENCIA</div>
      <div class="panel-body">
        <div class="row form-group" style="width: 100%;margin-left: -0px;">           
          <div v-if="getDependenciaUser.depe_depende == 3 && tipo === 1" class="col-sm-4">
            <label for="">Dependencia</label>
            <select
              v-model="filtro.depe_depende"
              class="form-control"
              @change="resetDependencia"
            >
              <option 
                v-for="(sede, indexSede) in getSedes" 
                :key="indexSede" 
                :value="sede.iddependencia"
              >{{ sede.depe_nombre }}</option>
            </select>
          </div>
          <div v-else class="col-sm-4">
            <label>Dependencia</label>
            <p>{{ getDependenciaNombre(getDependenciaUser.depe_depende) }}</p>
          </div>
          <div class="col-sm-1">
            <br />
            <input
              ref="registro"
              v-model="filtro.iddependencia"
              type="text"
              name="registro"
              class="form-control"
              placeholder="Cod. Unidad Orgánica"
              :disabled="tipo === 2"
            />
          </div>
          <div v-if="tipo === 1" class="col-sm-4">
            <label>Unidades Orgánicas</label>
            <select
              v-model="filtro.iddependencia"
              :disabled="!(tipo === 1)"
              class="form-control"
            >
              <option :value="null">Todos</option>
              <option 
                v-for="(sede, index) in getUnidadesSede(getDependenciaUser.depe_depende)" 
                :key="index"
                :value="sede.iddependencia"
              >
                {{ sede.depe_nombre }}
              </option>
            </select>
          </div>
          <div v-else class="col-sm-4">
            <label>Unidad Orgánica</label>
            <p>{{ getDependenciaNombre(getDependenciaUser.iddependencia) }}</p>
          </div>
          <div v-if="tipo == 1" class="col-sm-3">
            <label>Estado de Usuario</label>
            <select v-model="filtro.adm_estado" class="form-control">
              <option :value="null">Todos</option>
              <option :value="1">Activo</option>
              <option :value="0">Inactivo</option>
            </select>
          </div>
          <div v-else class="col-sm-3">

          </div>
          <div class="col-sm-2">
            <label class="control-label">Fecha:</label>
            <input
              ref="registro"
              v-model="filtro.currentDate"
              type="date"
              name="registro"
              class="form-control"
              @change="putEnd()"
            />
          </div>
          <div class="col-sm-1">
            <br />
            <button type="submit" class="btn btn-danger" @click="openHistory()">
              <span></span>Buscar
            </button>
          </div>
          <div class="col-sm-4">
            <br />
            <div class="btn-group" role="group" aria-label="Basic example">
              <p>
                <button class="btn btn-sm btn-success" @click="abrirModalExcel()">
                  <span class=""></span>Exportar en formato Excel
                </button>
              </p>
            </div>
          </div>        
        </div>

        <div class="box">
          <div v-if="tipo == 1" class="box-body">
            <pagination
              :data="users"
              :limit="limit"
              @pagination-change-page="obtenerUser"
            />
            <table class="table table-bordered table-condensed table-hover">
              <thead>
                <tr class="info">
                  <th style="width: 5%">DNI</th>
                  <th style="width: 10%">USUARIO</th>
                  <th style="width: 25%">UNIDAD</th>
                  <th style="width: 30%">DETALLE ASISTENCIA</th>
                  <th style="width: 30%">DETALLE PAPELETA</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, indexUsers) in users.data" :key="indexUsers">
                  <td style="width: 5%">{{ user.adm_dni }}</td>
                  <td style="width: 10%">{{ user.adm_name }}</td>
                  <td style="width: 25%">{{ user.depe_nombre }}</td>
                  <td style="width: 30%">
                    <table class="table table-bordered table-condensed table-hover">
                      <thead>
                        <tr v-if="assistances.data.filter(d => d.user_id === user.id).length > 0">
                          <th>Hora entrada</th>
                          <th>Hora salida</th>
                          <th>Estado</th>
                          <th>Validar</th>
                        </tr>
                        <tr v-else style="color:red">No registro asistencia</tr>
                      </thead>
                      <tbody>
                        <tr v-for="(assistance, index) in assistances.data.filter(d => d.user_id === user.id)" :key="index">
                          <td>{{ (assistance.entry).slice(10) }}</td>
                          <td>{{ (assistance.exit)?(assistance.exit).slice(10):'' }}</td>
                          <td :style="assistance.status?'color:blue':'color:red'">{{ assistance.status == null ? '':(assistance.status?'dentro de la tolerancia':'fuera de la tolerancia') }}</td>
                          <td>
                            <div>
                              {{ (assistance.validate)?'Validado':'' }}
                            </div>            
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td style="width: 30%">
                    <table class="table table-bordered table-condensed table-hover">
                      <thead>
                        <tr v-if="assistances.ballots.filter(d => d.user_id === user.id).length > 0">
                          <th>Salida</th>
                          <th>Retorno</th>
                          <th>Estado</th>
                          <th>Destino/Justi.</th>
                          <th>Acciones</th>
                        </tr>
                        <tr v-else style="color:red"></tr>
                      </thead>
                      <tbody>
                        <tr v-for="(ballot, index) in assistances.ballots.filter(d => d.user_id === user.id)" :key="index">
                          <td>{{ (ballot.exit)?(ballot.exit).slice(10):'' }}</td>
                          <td>{{ (ballot.return)?(ballot.return).slice(10):'' }}</td>
                          <td :style="ballot.authorized?'color:blue':'color:red'">{{ ballot.authorized?'Autorizado':'Sin autorizar' }}</td>
                          <td>
                            {{ ballot.destination }}<br />{{ ballot.justification }}
                          </td>
                          <td>
                            <div v-if="ballot.authorized && currentDate === (ballot.created_at).slice(0, 10) && ballot.exit == null">
                              <button class="btn btn-sm btn-success" @click="ballotOpening(ballot.id)">Aperturar</button>
                            </div>
                            <div v-if="ballot.authorized && currentDate === (ballot.created_at).slice(0, 10) && ballot.exit != null && ballot.return == null">
                              <button class="btn btn-sm btn-danger" @click="ballotClosed(ballot.id)">Cerrar</button>
                            </div>                   
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>      
              </tbody>             
            </table>
            <pagination
              :data="users"
              :limit="limit"
              @pagination-change-page="obtenerUser"
            />
          </div>
          <div v-else class="box-body">
            <pagination
              :data="users"
              :limit="limit"
              @pagination-change-page="obtenerUser"
            />
            <table class="table table-bordered table-condensed table-hover">
              <thead>
                <tr class="info">
                  <th style="width: 5%">DNI</th>
                  <th style="width: 10%">USUARIO</th>
                  <th style="width: 25%">UNIDAD</th>
                  <th style="width: 30%">DETALLE ASISTENCIA</th>
                  <th style="width: 30%">DETALLE PAPELETA</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, indexUsers) in users.data" :key="indexUsers">
                  <td style="width: 5%">{{ user.adm_dni }}</td>
                  <td style="width: 10%">{{ user.adm_name }}</td>
                  <td style="width: 25%">{{ user.depe_nombre }}</td>
                  <td style="width: 30%">
                    <table class="table table-bordered table-condensed table-hover">
                      <thead>
                        <tr v-if="assistances.data.filter(d => d.user_id === user.id).length > 0">
                          <th>Hora entrada</th>
                          <th>Hora salida</th>
                          <th>Estado</th>
                          <th>Validar</th>
                        </tr>
                        <tr v-else style="color:red">No registro asistencia</tr>
                      </thead>
                      <tbody>
                        <tr v-for="(assistance, index) in assistances.data.filter(d => d.user_id === user.id)" :key="index">
                          <td>{{ (assistance.entry).slice(10) }}</td>
                          <td>{{ (assistance.exit)?(assistance.exit).slice(10):'' }}</td>
                          <td :style="assistance.status?'color:blue':'color:red'">{{ assistance.status == null ? '':(assistance.status?'dentro de la tolerancia':'fuera de la tolerancia') }}</td>
                          <td>
                            <div v-if="!assistance.validate && currentDate === (assistance.entry).slice(0, 10) && tipo === 2">
                              <button class="btn btn-sm btn-info" @click="assistanceValidate(assistance.id)">Validar</button>
                            </div>
                            <div v-if="assistance.validate && currentDate === (assistance.entry).slice(0, 10) && tipo === 2">
                              <button class="btn btn-sm btn-danger" @click="assistanceInvalidate(assistance.id)">Invalidar</button>
                            </div>                   
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td style="width: 30%">
                    <table class="table table-bordered table-condensed table-hover">
                      <thead>
                        <tr v-if="assistances.ballots.filter(d => d.user_id === user.id).length > 0">
                          <th>Salida</th>
                          <th>Retorno</th>
                          <th>Estado</th>
                          <th>Destino/Justi.</th>
                          <th>Acción</th>
                        </tr>
                        <tr v-else style="color:red"></tr>
                      </thead>
                      <tbody>
                        <tr v-for="(ballot, index) in assistances.ballots.filter(d => d.user_id === user.id)" :key="index">
                          <td>{{ (ballot.exit)?(ballot.exit).slice(10):'' }}</td>
                          <td>{{ (ballot.return)?(ballot.return).slice(10):'' }}</td>
                          <td :style="ballot.authorized?'color:blue':'color:red'">{{ ballot.authorized?'Autorizado':'Sin autorizar' }}</td>
                          <td>{{ ballot.destination }}<br />{{ ballot.justification }}</td>
                          <td>
                            <div v-if="!ballot.authorized && currentDate === (ballot.created_at).slice(0, 10) && tipo === 2">
                              <button class="btn btn-sm btn-success" @click="ballotAuthorize(ballot.id)">Autorizar</button>
                            </div>      
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination
              :data="users"
              :limit="limit"
              @pagination-change-page="obtenerUser"
            />
          </div>
        </div>
      </div>
    </div>
    <!-- Modal exportar excel-->
    <div id="excel" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" @click="cerrarModal">X</button>
            <h4 class="modal-title">Exportar a excel</h4>
          </div>
          <div class="modal-body">
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-4">
                <label class="control-label">Fecha Desde:</label>
                <input
                  ref="registro"
                  v-model="filtro.currentDateExcel"
                  type="date"
                  name="registro"
                  class="form-control"
                  @change="putEnd()"
                />
              </div>
              <div class="col-sm-4">
                <label class="control-label">Fecha Hasta:</label>
                <input
                  ref="registro"
                  v-model="filtro.currentDateEndExcel"
                  type="date"
                  name="registro"
                  class="form-control"
                />
              </div>
            </div>
            <div class="row form-group" style="width: 100%;margin-left: -0px;">
              <div class="col-sm-8">
                <br />
                <div class="btn-group" role="group" aria-label="Basic example">
                  <p>
                    <button class="btn btn-sm btn-primary" @click="exportarExcel()">
                      <span class=""></span>Exportar asistencia excel
                    </button>
                    <button v-if="tipo == 1" class="btn btn-sm btn-success" @click="exportarPapeletasExcel()">
                      <span class=""></span>Exportar papeletas excel
                    </button>
                  </p>
                </div>
              </div>          
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="cerrarModal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Assistance from '@/js/api/tramite/assistance'
  import Vuex from 'vuex'

  export default {
    name: 'Assistance',
    props: {
      tipo: {
        type: Number,
        default: 1
      },
      limit: {
        type: Number,
        default: 3
      }
    },
    data () {
      return {
        filtro: {
          currentDate: null,
          currentDateExcel: null,
          currentDateEndExcel: null,
          depe_depende : null,
          iddependencia: null,
          user_id: null,
          adm_estado : 1,
          page : null
        },
        filtroDefault :{},
        assistances: {
          data         : [],
          ballots      : [],
        },
        users: {
          current_page: null,
          data: [],
          from: null,
          last_page: null,
          next_page_url: null,
          path: null,
          per_page: null,
          prev_page_url: null,
          to: null,
          total: null
        },
        currentDate: null,
      }
    },
    computed: {
      ...Vuex.mapGetters([
        'getDependenciaUser',
        'getDependenciaNombre',
        'getUsuariosActivoNombre',
        'getUnidadesSede',
        'getSedes'
      ]),

      checkUnidad() {
        let unidades = this.getUnidadesSede(this.getDependenciaUser.depe_depende)
        let oneDependencia = unidades.filter( d => d.iddependencia == this.filtro.iddependencia)[0]
        if (oneDependencia != undefined) {
          return true
        } else {
          return false
        }
      }
    },
    mounted () {
      let date = new Date()
      let isoDate = (new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString())
      this.filtro.currentDate = isoDate.slice(0, 10)
      this.filtro.currentDateExcel = isoDate.slice(0, 10)
      this.filtro.currentDateEndExcel = isoDate.slice(0, 10)
      this.currentDate = isoDate.slice(0, 10)
      window.setTimeout(() => {
        // code to run after 5 seconds...
        this.filtro.depe_depende = this.getDependenciaUser.depe_depende
        this.filtro.iddependencia = this.getDependenciaUser.iddependencia        
        this.filtroDefault = Object.assign({}, this.filtro)
        this.obtenerUser()
        this.openHistory()
      }, 1500)    
    },
    methods: {

      putEnd() {
        this.filtro.currentDateEndExcel = this.filtro.currentDateExcel
      },
      resetDependencia () {
        this.filtro.iddependencia = null
        this.users = {}
      },
      openHistory () {
        if (this.checkUnidad || this.filtro.iddependencia == null) {
          const params = {
            tipo: 3,
            type: this.tipo,
            currentDate: this.filtro.currentDate,
            iddependencia: this.filtro.iddependencia,
            depe_depende : this.filtro.depe_depende,
            user_id: this.filtro.user_id,
          }
          new Promise((resolve, reject) => {
            Assistance.getAssistances({ params: params }).then(response => {
              if (this.filtro.iddependencia != this.filtroDefault.iddependencia || this.filtro.depe_depende != this.filtroDefault.depe_depende || this.filtro.adm_estado != this.filtroDefault.adm_estado) {
                this.obtenerUser()
                this.filtroDefault = Object.assign({}, this.filtro)
              }
              this.assistances = response.data          
              resolve(response)
            }).catch(error => {
              reject(error)
            })
          })
        } else {
          alert('Seleccione Una Unidad Organica que pertenezca a la Dependencia')
        }
        
      },
      obtenerUser ( page = 1) {
        if (this.checkUnidad || this.filtro.iddependencia == null) {
          this.filtro.page = page        
          axios.get('/tramite/usuarios/obtenerUserDependenciaActivo?tipo=7&', { params: this.filtro }).then(response => {
            this.users = response.data
          })
        } else {
          alert('Seleccione Una Unidad Organica que pertenezca a la Dependencia')
        }
       
      },
      assistanceValidate (id) {
        Assistance.assistanceValidate(id).then(response => {
          if (response.data.status) {
            let assistance = this.assistances.data.filter(d => d.id === response.data.id)[0]
            assistance.validate = true
          }
        })
      },
      assistanceInvalidate (id) {
        Assistance.assistanceInvalidate(id).then(response => {
          if (response.data.status) {
            let assistance = this.assistances.data.filter(d => d.id === response.data.id)[0]
            assistance.validate = false
          }
        })
      },
      ballotAuthorize (id) {
        if (confirm('Esta seguro de la autorizar la papeleta?')) {
          Assistance.ballotAuthorize(id).then( response => {
            if (response.data.status) {
              let ballot = this.assistances.ballots.filter( d => d.id === response.data.id)[0]
              ballot.authorized = true
            }
          })
        }
      },
      ballotOpening (id) {
        if (confirm('Esta seguro de aperturar la papeleta?')) {
          Assistance.ballotOpening(id).then( response => {
            if (response.data.status) {
              let ballot = this.assistances.ballots.filter( d => d.id === response.data.id)[0]
              ballot.exit = response.data.exit
            }
          })
        }
      },
      ballotClosed (id) {
        if (confirm('Esta seguro de cerrar la papeleta?')) {
          Assistance.ballotClosed(id).then( response => {
            if (response.data.status) {
              let ballot = this.assistances.ballots.filter( d => d.id === response.data.id)[0]
              ballot.return = response.data.return
            }
          })
        }
      },
      exportarExcel () {
        const params = {
          tipo: 1,
          currentDate: this.filtro.currentDateExcel,
          currentDateEnd: this.filtro.currentDateEndExcel,
          iddependencia: this.filtro.iddependencia,
          depe_depende : this.filtro.depe_depende,
          user_id: this.filtro.user_id,
          adm_estado: this.filtro.adm_estado
        }
          new Promise((resolve, reject) => {
            Assistance.assistanceReportExcel({ params: params }).then(response => {
              if (response.data.length > 0) {
                let wscols = [
                  { wch: 50 },
                  { wch: 35 },
                  { wch: 15 },
                  { wch: 15 },
                  { wch: 12 },
                  { wch: 12 },
                  { wch: 25 }
                ]

                let hoja = xlsx.utils.json_to_sheet(response.data)
                hoja['!cols'] = wscols
                let wb = xlsx.utils.book_new() // make Workbook of Excel
                xlsx.utils.book_append_sheet(wb, hoja, 'reporte') // sheetAName is name of Worksheet
                // export Excel file
                xlsx.writeFile(wb, 'reporte.xlsx') // name of the file is 'book.xlsx'

              } else {
                alert('No existen datos que mostar')
              }
              resolve(response)
            }).catch(error => {
              reject(error)
            })
          })
      },

      exportarPapeletasExcel() {
         const params = {
          currentDate: this.filtro.currentDateExcel,
          currentDateEnd: this.filtro.currentDateEndExcel,
          iddependencia: this.filtro.iddependencia,
          depe_depende : this.filtro.depe_depende,
          user_id: this.filtro.user_id,
          adm_estado: this.filtro.adm_estado
        }
          new Promise((resolve, reject) => {
            Assistance.ballotExcel({ params: params }).then(response => {
              console.log(response.data)
              if (response.data.length > 0) {
                let wscols = [
                  { wch: 50 },
                  { wch: 35 },
                  { wch: 15 },
                  { wch: 15 },
                  { wch: 12 },
                  { wch: 12 },
                  { wch: 25 },
                  { wch: 30 },
                  { wch: 50 }
                ]

                let hoja = xlsx.utils.json_to_sheet(response.data)
                hoja['!cols'] = wscols
                let wb = xlsx.utils.book_new() // make Workbook of Excel
                xlsx.utils.book_append_sheet(wb, hoja, 'reporte') // sheetAName is name of Worksheet
                // export Excel file
                xlsx.writeFile(wb, 'reporte.xlsx') // name of the file is 'book.xlsx'

              } else {
                alert('No existen datos que mostar')
              }
              resolve(response)
            }).catch(error => {
              reject(error)
            })
          })
      },
      abrirModalExcel() {
        $("#excel").modal()
      },
      cerrarModal() {
        let date = new Date()
        let isoDate = (new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString())
        this.filtro.currentDateExcel = isoDate.slice(0, 10)
        this.filtro.currentDateEndExcel = isoDate.slice(0, 10)
         $("#excel").modal("hide")
      }
    }
  }
</script>

<style scoped>

  .table tbody tr td,
  .table thead tr th {
    font-size: 11px;
    font-family: Tahoma;
    vertical-align: middle;
    padding: 2px 0px;
  }
  .table{
        margin-bottom: 0;
  }
</style>
