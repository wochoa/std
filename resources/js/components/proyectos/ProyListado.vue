<template>
  <div class="Listado">
    <proy-filtro :form-data="formData" />
    <!--Modal para crear un nuevo proyecto-->
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card>
        <v-toolbar dense dark color="primary">
          <v-btn icon dark @click="cerrarModal()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title v-if="modoEdit">Editar Proyecto</v-toolbar-title>
          <v-toolbar-title v-else>Crear un nuevo Proyecto</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn dark text @click="guardarProyecto">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-container fluid class="Formulario">
          <proy-formulario
            :form-proyecto="formProyecto"
            @buscarSiaf="buscarSiaf"
          />
        </v-container>
      </v-card>
    </v-dialog>
    <!--fin modal-->

    <!--Modal para crear un nuevo informe para un proyecto-->
    <v-dialog v-model="dialogInforme" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="cerrarModalInforme()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Crear un nuevo Informe para el proyecto</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn dark text @click="saveInforme()">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <proy-informe-nuevo :form-informe="formInforme" />
      </v-card>
    </v-dialog>
    <!--fin modal-->

    <proy-table
      width="100%"
      class="ListadoTabla estatico"
      :items="proyectosFilter"
      tag="proy"
      :page-length="50"
      @enter="goToAdministrar">
      <template slot="actions" slot-scope="data">
        <v-btn
          small
          color="#1976d2"
          class="white--text"
          @click="
            dialog = true
            $validator.reset()
          "
        >
          Nuevo
          <v-icon right>mdi-plus</v-icon>
        </v-btn>
        <div v-if="data.selected.index !== null" class="d-flex">
          <v-btn
            small
            color="#1976d2"
            class="white--text"
            @click="obtenerUnProyecto(data.selected.item.idproy_proyecto)"
          >
            Editar
            <v-icon right>mdi-pencil</v-icon>
          </v-btn>
          <v-btn small @click="goToAdministrar(data.selected)">
            Administrar
            <v-icon right>mdi-format-list-bulleted</v-icon>
          </v-btn>

          <v-btn small @click.prevent="generarInformeProyecto(data.selected.item.idproy_proyecto)">
            Informe
            <v-icon right>mdi-cloud-upload</v-icon>
          </v-btn>
        </div>
      </template>
      <template slot="header">
        <tr>
          <th class="text-left" width="70%">NOMBRE DEL PROYECTO</th>
          <th class="text-left" width="8%">SIAF</th>
          <th class="text-left" width="7%">SNIP</th>
          <th class="text-left" width="9%">PIM</th>
          <th class="text-left" width="6%">EJEC</th>
        </tr>
      </template>
      <template slot="body" slot-scope="row">
        <td width="70%">{{ row.item.proy_nombre }}</td>
        <td width="8%">{{ row.item.proy_cod_siaf }}</td>
        <td width="7%">{{ row.item.proy_cod_snip }}</td>
        <td width="10%"></td>
        <td width="5%"></td>
      </template>
    </proy-table>
  </div>
</template>
<script>
  import Vuex from 'vuex'
  import proyectos from '@/js/api/proyectos/proyectos'
  import ProyInformeNuevo from '@/js/components/proyectos/ProyInformeNuevo'
  import ProyFiltro from './ProyFiltro'
  import ProyFormulario from './ProyFormulario'
  import ProyTable from './ProyTable'

  export default {
    components: {
      ProyInformeNuevo,
      ProyFiltro,
      ProyFormulario,
      ProyTable
    },

    data () {
      return {
        formData: {
          proy_cod_siaf: null,
          proy_nombre: null
        },
        formProyecto: {
          idproy_proyecto: null,
          proy_nombre: null,
          proy_cod_snip: null,
          proy_cod_siaf: null,
          funcion_id: null,
          proy_fte_fto: null,
          proy_beneficiarios: null,
          ubigeo_id: null,
          proy_localidad: null,
          proy_perfil_viable: null,
          proy_snip15: null,
          proy_snip16: null,
          proy_verificacion_viabilidad: null,
          proy_modificaciones_sin_evaluacion: null,
          proy_fech_registro_perfil: null,
          proy_estado: null,
          proy_pip_actualizado: null,
          proy_pres_inc_cf: null
        },
        formInforme: {
          id: null,
          id_proyecto: null,
          inf_descripcion: null,
          inf_cordenadas: null,
          inf_archivos: {
            arch_archivo: null
          }
        },
        defaultFormProyecto: {},
        defaultFormInforme: {},
        modoEdit: false,
        dialog: false,
        dialogInforme: false,
        toggle_exclusive: 2
      }
    },
    computed: {
      ...Vuex.mapGetters(['showProyectos', 'mostrarArchivos']),

      proyectosFilter () {
        let filtrado = this.showProyectos
        if(this.formData.proy_cod_siaf != null && this.formData.proy_cod_siaf !== '') {
          if(this.formData.proy_cod_siaf.length>6){
            filtrado = filtrado.filter( d => d.proy_cod_siaf === parseInt(this.formData.proy_cod_siaf))
          }
        }
        if(this.formData.proy_nombre != null && this.formData.proy_nombre !== '') {
          let words = this.formData.proy_nombre.split(' ')
          for (let i = 0; i < words.length; i++) {
            filtrado = filtrado.filter( d => d.proy_nombre != null && d.proy_nombre.toLowerCase().indexOf(words[i].toLowerCase()) > -1)
          }
        }
        return filtrado
      }

    },
    created: function () {
      this.defaultFormProyecto = Object.assign({}, this.formProyecto)
      this.defaultFormInforme = Object.assign({}, this.formInforme)
      this.newInforme()
    },
    mounted () {
      const isUnique = (value, { atributo } = {}) => {
        this.validating = true
        const params = {
          idproy_proyecto: this.formProyecto.idproy_proyecto,
          atributo: atributo,
          value: value
        }
        if (value.length >= 5) {
          return proyectos
            .requestUniqueProyect(params)
            .then(({ data }) => {
              this.validating = false
              return data
            })
            .catch(error => {
              return error.response.data
              this.validating = false
            })
        } else {
          return {
            valid: true,
            data: ''
          }
        }
      }
      const paramNames = ['atributo']
      this.$validator.extend('unique', isUnique, {
        paramNames,
        getMessage: (field, params, data) => data.message
      })
    },

    methods: {
      ...Vuex.mapActions([
        'getUbigeo',
        'getOficinas',
        'getFunciones',
        'getEstados',
        'getProyectos',
        'newInforme',
        'guardarInforme',
        'ejecutarRecursivamente',
        'saveProyecto',
        'moveIdForTable']),
      goToAdministrar (data) {
        this.$router.push({
          name: 'ProyAnalitico',
          params: { idproyecto: data.item.idproy_proyecto }
        })
      },
      obtenerUnProyecto (idproy) {
        this.$validator.reset()
        this.dialog = true
        this.modoEdit = true
        proyectos.requestProyecto(idproy).then(response => {
          this.formProyecto = response.data
          if (response.data.proy_fech_registro_perfil) {
            let arrayFecha = response.data.proy_fech_registro_perfil.split(['-'])
            let yymmdd = arrayFecha[0] + '-' + arrayFecha[1] + '-' + arrayFecha[2]
            this.formProyecto.proy_fech_registro_perfil = yymmdd
          }
        })
      },

      guardarProyecto () {
        this.$validator.validate().then(result => {
          if (result) {
            this.saveProyecto(this.formProyecto)
            this.cerrarModal()
          } else {
            console.log('incompleto')
          }
        })
      },

      cerrarModal () {
        this.dialog = false
        this.formProyecto = Object.assign({}, this.defaultFormProyecto)
      },

      cerrarModalInforme () {
        this.dialogInforme = false
        this.formInforme = Object.assign({}, this.defaultFormInforme)
        this.newInforme()
      },

      buscarSiaf () {
        if (this.formProyecto.proy_cod_siaf) {
          this.loading = true
          proyectos.requestSiaf(this.formProyecto)
          this.loading = false
        } else {
          alert('Digite el Codigo SIAF')
        }
      },

      redirectAdministracion (id) {
        window.location.assign('proyectos/' + id + '/edit')
      },

      generarInformeProyecto (id) {
        this.ejecutarRecursivamente({
          context: this,
          after: function (context) {
            if (context.$validator != undefined) {
              context.$validator.reset()
            }
          }
        })
        this.dialogInforme = true
        this.formInforme.id_proyecto = id
      },

      saveInforme () {
        this.guardarInforme(this.formInforme)
        this.cerrarModalInforme()
      },
      selectFila () {
        if (event.target.classList.contains('btn__content')) {
          return
        }
        alert('Alert! \n')
      }
    }
  }
</script>

<style scoped>
  .my-input input {
    text-transform: uppercase !important;
  }
</style>
