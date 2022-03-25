<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Dias Feriado</div>
      <div class="panel-body">
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
          <div class="col-sm-3">
            <button type="button" class="btn btn-sm btn-primary" @click="holidayOpen">
              <span class="glyphicon glyphicon-plus-sign"></span>Nuevo
            </button>
          </div>
        </div>
      </div>
      <div class="box">
        <table class="table table-bordered table-condensed table-hover">
          <thead>
            <tr class="info">
              <th style="font-size:13px; font-family: Tahoma" nowrap>Fecha</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>Dia</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>Estado</th>
              <th style="font-size:13px; font-family: Tahoma" nowrap>Editar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(holiday, index) in holidays" :key="index">
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ holiday.holiday }}</td>
              <td style="font-size:13px; font-family: Tahoma" nowrap>{{ holiday.holiday }}</td>
              <td v-if="!editMode" style="font-size:13px; font-family: Tahoma" nowrap>{{ holiday.status?'ACTIVO':'INACTIVO' }}</td>
              <td v-else>
                <select v-model="holiday.status" class="form-control">
                  <option :value="true">Activo</option>
                  <option :value="false">Inactivo</option>
                </select>
              </td>
              <td>
                <a
                  v-if="editMode && editId === holiday.id"
                  class="btn btn-success"
                  @click="updateHoliday(index)"
                >Guardar</a>
                <a
                  v-else
                  class="btn btn-info glyphicon glyphicon-pencil"
                  @click="editHoliday(holiday.id)"
                ></a>
                <a
                  v-if="editMode && editId === holiday.id"
                  class="btn btn-danger"
                  @click="cancelHoliday(index)"
                >x</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Modal nuevo-->
      <div id="nuevo" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Nuevo dias feriado</h4>
            </div>
            <div class="modal-body">
              <div class="row form-group" style="width: 100%;margin-left: -0px;">
                <div class="col-sm-6">
                  <label class="control-label">Dia Feriado</label>
                  <div>
                    <button
                      class="btn btn-primary"
                      @click.prevent="holidayNew"
                    >
                      <span class="glyphicon glyphicon-plus"></span>
                    </button>
                    <div v-for="(form, indexHoliday) in formHolidays" :key="indexHoliday" class="d-flex">
                      <input v-model="form.holiday" type="date" class="form-control" />
                      <button
                        class="btn btn-danger"
                        @click.prevent="holidayDelete(indexHoliday)"
                      >
                        <span class="glyphicon glyphicon-minus"></span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal" @click="holidaySend">
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
    name: 'AdministradorHolidays',

    data(){
      return {
        holidays:[],
        formHolidays:[],
        editMode: false,
        editId: null,
      }
    },

    mounted () {
      this.getHolidays()
    },

    methods:{

      getHolidays() {
        axios.get('/administrador/dias-feriado/index').then( response => {
          this.holidays = response.data
        })
      },

      holidayOpen() {
        $('#nuevo').modal();
      },

      holidaySend() {
        const params = {
          holidays: this.formHolidays
        }
        axios.post('/administrador/dias-feriado/store', params).then( response => {
          console.log(response.data)
          this.getHolidays()
        })
      },

      holidayNew() {
        this.formHolidays.push({
          id: null,
          holiday: null,
          status: true,
        })
      },

      holidayDelete(index) {
        this.formHolidays.splice(index, 1)
      },

      editHoliday(index) {
        this.editId = index
        this.editMode = true
      },

      updateHoliday(index) {
        const params = {
          id : this.editId,
          status : this.holidays[index].status
        }
        axios.post('/administrador/dias-feriado/update', params).then( response => {
          this.getHolidays()
          this.editMode = false
          this.editId = null
        })

      },

      cancelHoliday(index) {
        this.editId = null
        this.editMode = false
      }
    }
  }
</script>

<style scoped>

</style>
