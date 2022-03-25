<template>
  <div>
    <nav class="navbar navbar-gorehco navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navegacion-fm">
            <span class="sr-only">Desplegar / Ocultar Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a :href="routes['principal'].route" class="img">
            <img src="/img/logo1.png" alt="" />
          </a>
        </div>
        <div id="navegacion-fm" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Fecha : {{ currentDateFormat }} - {{ currentTime }}
              </a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            <li v-if="auth['guest']"><a :href="routes['login']">Login</a></li>
            <li v-else class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ userName }} <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a :href="routes['logout'].route"><i class="fa fa-btn fa-sign-out"></i>Cerrar Session</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="Dashboard u-wrapper">
      <!-- <div style="position: absolute; bottom: 5px;right:5px;">
        <div
          class="btn btn-warning"
          :disabled="!(assistance.assistances.length > 0)"
          @click="openFormPapeleta"
        >
          <span class="icon icon-list fs-40" aria-hidden="true"></span>
          <div class="h4">Solicitar Papeleta de Permiso</div>
        </div> 
        
        <div
          v-if="activeAssistance === undefined"
          class="btn btn-primary float-letf"
          type="submit"
          :disabled="saving || !isMatutinal || assistance.ips.length === 0"
          @click="assistanceOpen"
        >
          <span class="icon icon-hour-glass fs-40" aria-hidden="true"></span>
          <div class="h4">Abrir Asistencia</div>
        </div> 
        
        <div
          v-else
          class="btn btn-danger"
          type="submit"
          :disabled="saving || activeAssistance === undefined || activeAssistance.outputInSeconds>nowInSeconds || assistance.ips.length === 0"
          @click="assistanceClosed">
          <span class="icon icon-hour-glass fs-18" aria-hidden="true"></span>
          <div class="h4">Cerrar Asistencia</div>
          <div class="group-horizontal">
            <label for="invoice_date">Tiempo transcurrido: {{ activeAssistance.entry | moment('from', 'now') }}</label>
          </div>
        </div> 
        <div
          class="btn btn-info"
          @click="openHistory"
           >
          <span class="icon icon-list fs-40" aria-hidden="true"></span>


          <div class="h4">Historial de Asistencia</div>

        </div> 
      </div> -->

      <h2 class="page-header text-center">SISTEMA DE GESTIÓN DIGITAL</h2>


      <div class="d-flex flex-wrap">
        <div v-if="routes['administrador.administrador.administrador'].can" class="col-6 col-md-4 text-center">
          <a :href="routes['administrador.administrador.administrador'].route" class="Green">
            <span class="icon icon-cog fs-72" aria-hidden="true"></span>
            <div class="h4">Administración</div>
          </a>
        </div>
        <div v-if="routes['tramite.inicio'].can" class="col-6 col-md-4 text-center">
          <a :href="routes['tramite.inicio'].route" class="Red">
            <span class="icon icon-copy fs-72" aria-hidden="true"></span>
            <div class="h4">Trámite Documentario</div>
          </a>
        </div>
        <div v-if="false && routes['proyectoPresupuesto.inicio'].can" class="col-6 col-md-4 text-center">
          <a :href="routes['proyectoPresupuesto.inicio'].route">
            <span class="icon icon-usd fs-72" aria-hidden="true"></span>
            <div class="h4">Gestión de Proyectos y Financiera</div>
          </a>
        </div>
        <!-- <div v-if="routes['assistance.inicio'].can" class="col-6 col-md-4 text-center">
          <a :href="routes['assistance.inicio'].route" class="Green">
            <span class="icon icon-user-check fs-72" aria-hidden="true"></span>
            <div class="h4">Control de Asistencia</div>
          </a>
        </div> -->
        <div v-if="routes['mpv.view'].can" class="col-6 col-md-4 text-center">
          <a :href="routes['mpv.view'].route" class="Red">
            <span class="icon icon-enter fs-72" aria-hidden="true"></span>
            <div class="h4">Mesa de Partes Virtual</div>
          </a>
        </div>
        <div v-if="routes['interoperabilidad.view'].can" class="col-6 col-md-4 text-center">
          <a :href="routes['interoperabilidad.view'].route">
            <span class="icon icon-enter fs-72" aria-hidden="true"></span>
            <div class="h4">Interoperabilidad</div>
          </a>
        </div>
        <div class="col-6 col-md-4 text-center">
          <a href="http://goredigital.regionhuanuco.gob.pe/ticket" target="_blank">
            <span class="icon icon-alarm fs-72" aria-hidden="true"></span>	
            <p>Crea su ticket para <br>recibir atención de soporte técnico</p>
          </a>
        </div>
      </div>
      <!-- Modal historial de asistencia-->
      <div id="history" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">X</button>
              <h4 class="modal-title">Historial de asistencia</h4>
            </div>
            <div class="modal-body">
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-4">
                  <label class="control-label">Fecha:</label>
                  <input
                    ref="registro"
                    v-model="filtro.currentDate"
                    type="date"
                    name="registro"
                    class="form-control"
                    @change="openHistory"
                  />
                </div>
                <div class="col-sm-4">
                  <label>Meses</label>
                  <select
                    v-model="filtro.month_id"
                    class="form-control"
                    @change="openHistory"
                  >
                    <option :value="null">Seleccione mes</option>
                    <option v-for="(month, index) in months" :key="index" :value="month.month_id">
                      {{ month.title }}
                    </option>
                  </select>
                </div>
                <div class="col-sm-4">
                  <br />
                  <p>
                    <button class="btn btn-sm btn-success" @click="exportarExcel()">
                      <span class=""></span>Exportar excel mes
                    </button>
                  </p>
                </div>
              </div>
              <pagination
                :data="assistances"
                :limit="3"
                @pagination-change-page="openHistory"
              />
              <table class=" table table-bordered table-condensed table-hover ">
                <thead>
                  <tr class="info">
                    <th style="width:30%">CREADO POR</th>
                    <th style="width:30%">ACTUALIZADO POR</th>
                    <th style="width:10%">HORA ENTRADA</th>
                    <th style="width:10%">HORA SALIDA</th>
                    <th style="width:20%">ESTADO</th>
                    <th style="width:15%">VALIDADO</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(assistance, index) in assistances.data" :key="index">
                    <td class="registro">
                      <strong>Nombre:</strong>{{ assistance.usuario.adm_name+' '+assistance.usuario.adm_lastname
                      }}<br />
                      <strong>Fecha:</strong>{{ assistance.entry }}
                    </td>
                    <td class="registro">
                      <strong>Nombre:</strong>{{ assistance.usuario.adm_name+' '+assistance.usuario.adm_lastname
                      }}<br />
                      <strong>Fecha:</strong>{{ assistance.exit }}
                    </td>
                    <td>{{ (assistance.entry).slice(10) }}</td>
                    <td>{{ (assistance.exit)?(assistance.exit).slice(10):'' }}</td>
                    <td :style="assistance.status?'color:blue':'color:red'">{{ assistance.status == null ? '':(assistance.status?'dentro de la tolerancia':'fuera de la tolerancia') }}</td>
                    <td>{{ assistance.validate ? 'Validado':'Sin validar' }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Formulario papeleta-->
      <div id="papeleta" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">X</button>
              <h4 class="modal-title">PAPELETA DE PERMISO</h4>
            </div>
            <div class="modal-body">
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-2">
                  <label class="control-label">Nombre y Apellido:</label>
                </div>
                <div class="col-sm-10">
                  <p>{{ assistance.user.adm_name + assistance.user.adm_lastname }}</p>
                </div>
              </div>
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-2">
                  <label class="control-label">DNI:</label>
                </div>
                <div class="col-sm-10">
                  <p>{{ assistance.user.adm_dni }}</p>
                </div>
              </div>
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-2">
                  <label class="control-label">Oficina:</label>
                </div>
                <div class="col-sm-10">
                  <p>{{ assistance.user.dependencia.depe_nombre }}</p>
                </div>
              </div>
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-2">
                  <label class="control-label">Motivo de Salida:</label>
                </div>
                <div class="col-sm-2">
                  <label>
                    Comisión
                    <input
                      ref="destination"
                      v-model="ballot.departure_reason"
                      type="radio"
                      :value="1"
                      name="destination"
                      class="radio-inline"
                    /></label>
                  
                </div>
                <div class="col-sm-2">                  
                  <label>
                    Salud
                    <input
                      ref="destination"
                      v-model="ballot.departure_reason"
                      type="radio"
                      :value="2"
                      name="destination"
                      class="radio-inline"
                    />
                  </label>
                </div>
                <div class="col-sm-2">                  
                  <label>
                    Particular
                    <input
                      ref="destination"
                      v-model="ballot.departure_reason"
                      type="radio"
                      :value="3"
                      name="destination"
                      class="radio-inline"
                    />
                  </label>
                </div>
                <div class="col-sm-4">                  
                  <label>
                    Cobro de haberes 1H
                    <input
                      ref="destination"
                      v-model="ballot.departure_reason"
                      type="radio"
                      :value="4"
                      name="destination"
                      class="radio-inline"
                    />
                  </label>
                </div>
              </div>
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-2">
                  <label class="control-label">Destino:</label>
                </div>
                <div class="col-sm-10">
                  <input
                    ref="destination"
                    v-model="ballot.destination"
                    type="text"
                    name="destination"
                    class="form-control"
                    @change="ballot.destination = ballot.destination.toUpperCase()"
                  />
                </div>
              </div>
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-2">
                  <label class="control-label">Justificación:</label>
                </div>
                <div class="col-sm-10">
                  <textarea 
                    ref="justification" 
                    v-model="ballot.justification" 
                    name="justification" 
                    cols="30" 
                    rows="3"                    
                    class="form-control"
                    @change="ballot.justification = ballot.justification.toUpperCase()"
                  >
                  </textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
                :disabled="savingPapeleta"
                @click="papeletaSave()"
              >
                <span v-if="!savingPapeleta"> Guardar</span>
                <span v-else> Guardando</span>
              </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" :disabled="savingPapeleta">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal confirmación papeleta-->
      <div id="confirmacion" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">X</button>
              <h4 class="modal-title">Mensaje</h4>
            </div>
            <div class="modal-body">
              <h5>La papeleta fue registrado exitosamente</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Vuex from 'vuex'
  import Assistance from '@/js/api/tramite/assistance'

  export default {
    props: {
      routes: {
        type: [Object, String],
        default: ''
      },
      auth: {
        type: Object,
        default: () => ({})
      },
      titulo: {
        type: String,
        default: ''
      },
      userName: {
        type: String,
        default: ''
      },
      userSede: {
        type: String,
        default: '3'
      }
    },
    data () {
      return {
        saving: false,
        filtro: {
          currentDate: null,
          page: null,
          month_id: null
        },
        assistance: {
          ips: [],
          schedules: [],
          assistances: [],
          user : {
            dependencia: {
              iddependencia : null,
              depe_nombre : null,
              depe_depende : null
            }
          }
        },
        currentDateFormat: null,
        now: new Date(),
        ip: null,
        assistances: {},
        months: [
          { month_id: 1, title: 'Enero' },
          { month_id: 2, title: 'Febrero' },
          { month_id: 3, title: 'Marzo' },
          { month_id: 4, title: 'Abril' },
          { month_id: 5, title: 'Mayo' },
          { month_id: 6, title: 'Junio' },
          { month_id: 7, title: 'Julio' },
          { month_id: 8, title: 'Agosto' },
          { month_id: 9, title: 'Setiembre' },
          { month_id: 10, title: 'Octubre' },
          { month_id: 11, title: 'Noviembre' },
          { month_id: 12, title: 'Diciembre' },
        ],
        ballot: {
          destination : null,
          justification : null,
          departure_reason : null

        },
        savingPapeleta : false
      }
    },
    computed: {

      currentTime () {
        let hours = this.now.getHours(), minutes = ('00' + this.now.getMinutes()).slice(-2),
          seconds = ('00' + this.now.getSeconds()).slice(-2)
        let suffix = 'AM'
        if (hours >= 12) {
          suffix = 'PM'
          hours = hours - 12
        }
        if (hours === 0) {
          hours = 12
        }
        return hours + ':' + minutes + ':' + seconds + ' ' + suffix
      },
      nowInSeconds(){
          let hours = this.now.getHours(),
          minutes = ('00' + this.now.getMinutes()).slice(-2),
          seconds = ('00' + this.now.getSeconds()).slice(-2)
          return parseFloat(hours)*3600 + parseFloat(minutes) * 60 + parseFloat(seconds)
      },
      activeAssistance () {
        let este = this
        return this.assistance.assistances.find(
        d=>{
          let next = este.nextSchedule(d)
          if(d.exit!=null){
            return false
          }
          if(next!==undefined){
            return next.entryInSeconds>este.nowInSeconds
          }
          return true
        }
        )
      },
      isMatutinal () {
        if (this.assistance.schedules.length == 0 && this.assistance.assistances.length < 2) {
          return true
        } else if (this.assistance.schedules.length >0 && this.assistance.assistances.length < 2) {
          let hours = this.now.getHours(), minutes = ('00' + this.now.getMinutes()).slice(-2)
          let now         = hours + minutes / 60
          let estado   = false

            for (let i = 0; i < this.assistance.schedules.length; i++) {
              let entry  = this.assistance.schedules[i].entry_time.split(':')
              entry      = parseFloat(entry[0]) + parseFloat(entry[1]) / 60 + parseFloat(entry[2]) / 3600
              let output = this.assistance.schedules[i].output_time.split(':')
              output     = parseFloat(output[0]) + parseFloat(output[1]) / 60 + parseFloat(output[2]) / 3600
              if (now >= entry && now <= output) {
                estado = true
              }
            }
            return estado
        } else {
          return false
        }
      },
      existsIp () {
        if(this.assistance.ips.length > 0) {
          return this.assistance.ips.filter(d => d.ip === this.ip)[0] !== undefined
        } else {
          return false
        }
      }
    },

    created () {
      setInterval(() => {
        this.now = new Date()
      }, 1000)
    },
    mounted () {
      let date = new Date()
      let isoDate = (new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString())
      this.filtro.currentDate = isoDate.slice(0, 10)
      let fecha = this.filtro.currentDate.split('-')
      this.currentDateFormat = fecha[2] + '/' + fecha[1] + '/' + fecha[0] 
      this.getAssistanceActive()
      this.getIpLocal()
    },
    methods: {
      
      nextSchedule(assistance){
        let index = this.assistance.schedules.findIndex(d=>d.entry_time===assistance.entry_time&&d.output_time===assistance.output_time)
        if(index!==-1)
          return this.assistance.schedules[index+1]
        else
          return undefined
      },
      getAssistanceActive() {
        this.saving = true
        Assistance.assistanceActive().then(response => {
          this.assistance.user = response.data.user          
          this.assistance.ips = response.data.ips
          this.assistance.schedules = response.data.schedules
          for(let i =0; i<this.assistance.schedules.length; i++){          
            let entry_second  = this.assistance.schedules[i].entry_time.split(':')
            this.assistance.schedules[i].entryInSeconds=parseFloat(entry_second[0])*3600 + parseFloat(entry_second[1]) * 60 + parseFloat(entry_second[2])
            let ouput_second  = this.assistance.schedules[i].output_time.split(':')
            this.assistance.schedules[i].outputInSeconds=parseFloat(ouput_second[0])*3600 + parseFloat(ouput_second[1]) * 60 + parseFloat(ouput_second[2])
          }
          this.assistance.assistances = response.data.assistances
          for(let i =0; i<this.assistance.assistances.length; i++){   
            if (this.assistance.schedules.length == 0) {
              this.assistance.assistances[i].entryInSeconds = null
              this.assistance.assistances[i].outputInSeconds = null
            } else {
              let entry_second  = this.assistance.assistances[i].entry_time.split(':')
              this.assistance.assistances[i].entryInSeconds=parseFloat(entry_second[0])*3600 + parseFloat(entry_second[1]) * 60 + parseFloat(entry_second[2])
              let ouput_second  = this.assistance.assistances[i].output_time.split(':')
              this.assistance.assistances[i].outputInSeconds=parseFloat(ouput_second[0])*3600 + parseFloat(ouput_second[1]) * 60 + parseFloat(ouput_second[2])
            }
          }
          this.saving = false 
        })
      },
      getIpLocal () {
        return new Promise((resolve, reject) => {
          Assistance.ipPublicLocal().then(response => {
            this.ip = response.data.ip
            resolve(response)
          }).catch(() => {
            this.ip = '0.0.0.0'
          })
        })

      },
      assistanceOpen () {
        if (this.isMatutinal && this.assistance.ips.length > 0) {
          if (this.existsIp) {
            if (confirm('Esta seguro de la apertura su asistencia?')) {
              this.saving = true
              Assistance.assistanceSave({ ip: this.ip }).then(response => {
                this.getAssistanceActive()
                this.saving = false
              })
            }
          } else {
            alert('Usted no se encuentra en la red de su Dependencia')
          }
        }
      },
      assistanceClosed () {
       if(!( this.saving || this.activeAssistance == undefined || this.activeAssistance.outputInSeconds>this.nowInSeconds || this.assistance.ips.length === 0)){
        if ( this.assistance.ips.length > 0) {
          if(this.existsIp) {
            if (confirm('Esta seguro de la cerrar su asistencia?')) {
              this.saving = true
              Assistance.assistanceClosed(this.activeAssistance.id, { ip: this.ip }).then(response => {
                if (response.data.status) {
                  this.getAssistanceActive()
                }
              })
            }
          } else {
            alert('Usted no se encuentra en la red de su Dependencia')
          }
        }
       }
        
      },
      openHistory (page = 1) {
        $('#history').modal()
        this.filtro.page = page
        const params = {
          tipo: (this.filtro.month_id == null) ? 1 : 2,
          currentDate: this.filtro.currentDate,
          month_id: this.filtro.month_id
        }
        new Promise((resolve, reject) => {
          Assistance.getAssistances({ params: params }).then(response => {
            this.assistances = response.data
            resolve(response)
          }).catch(error => {
            reject(error)
          })
        })
      },

      exportarExcel() {
        const params = {
          tipo: 2,
          currentDate: this.filtro.currentDate,
          month_id: this.filtro.month_id,
          depe_depende: parseInt(this.userSede),
          iddependencia: null,
          user_id: null,
        }
        if (this.filtro.month_id != null) {
          new Promise((resolve, reject) => {
            Assistance.assistanceReportExcel({ params: params }).then(response => {
              if (response.data.length > 0) {
                let wscols = [
                  { wch: 50 },
                  { wch: 35 },
                  { wch: 15 },
                  { wch: 15 },
                  { wch: 15 },
                  { wch: 25 },
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
        } else {
          alert('Seleccione un mes especifico')
        }
      },

      openFormPapeleta() {
        if (this.assistance.assistances.length > 0) {
          $('#papeleta').modal()
        } else {
          alert('Antes aperture su asistencia')
        }
       
      },

      papeletaSave() {
        Assistance.ballotSave(this.ballot).then(response => {
          if (response.data.status) {
            $('#confirmacion').modal()
            this.ballot = {
                destination : null,
                justification : null,
                departure_reason : null

            }
          } else {
            alert('Rellene los datos requeridos')
          }
        })
      }
    }
  }
</script>
<style scoped>
  .registro strong {
    width: 60px;
    display: inline-block;
  }

  .table tbody tr td,
  .table thead tr th {
    font-size: 11px;
    font-family: Tahoma;
    vertical-align: middle;
    padding: 2px 0px;
  }

  .group-horizontal label {
    margin-bottom: 0;
  }

  input,
  textarea {
    text-transform: uppercase;
  }
</style>
