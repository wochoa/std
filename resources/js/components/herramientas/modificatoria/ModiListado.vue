<template>
  <div class="panel-body">
    <div class="row Filtros m-1 mb-2">
      <div class="col-12 col-sm-4 FiltrosGrupo">
        <label>Modificatorias</label>
      </div>
      <div class="col-12 col-sm-2 FiltrosGrupo">
        <label>Año</label>
        <v-select
          v-model="filtro.anio"
          :items="getAniosReporte"
          :hide-details="true"
          flat
          class="FiltrosInput max-w-100"
          @change="getModificatorias(filtro.anio)"
        />
      </div>
      <div class="col-12 col-sm-6 FiltrosGrupo">
        <label>Modificatoria</label>
        <v-text-field
          v-model="filtro.dessertFilterValue"
          class="FiltrosInput"
          :hide-details="true"
        />
      </div>
    </div>

    <!-- Modal nueva modificatoria-->
    <v-dialog v-model="dialog" max-width="1000px">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="cerrarModal()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title v-if="modoEdit">Editar Modificatoria</v-toolbar-title>
          <v-toolbar-title v-else>Crear nueva Modificatoria</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn :disabled="puedeGuardar" dark text @click="guardarModificatoria()">Guardar</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-list three-line subheader>
          <div class="d-flex flex-wrap">
            <div class="col-12 ProyectosFormulario">
              <v-text-field
                v-model="formModificatoria.modif_titulo"
                v-validate="'required'"
                :type="'text'"
                label="Titulo"
                :error-messages="errors.collect('titulo')"
                data-vv-name="titulo"
                solo
                @change="formModificatoria.modif_titulo = formModificatoria.modif_titulo.toUpperCase()"
              />
            </div>
            <div class="col-12 col-sm-6  ProyectosFormulario">
              <v-label>Fecha</v-label>
              <v-text-field
                v-model="formModificatoria.modif_fecha_aprovacion"
                type="date"
                solo
              />
            </div>
          </div>
        </v-list>
        <v-divider />
        <v-list three-line subheader />
      </v-card>
    </v-dialog>
    <!--fin modal-->

    <proy-table
      width="100%"
      class="ListadoTabla estatico"
      :items="modificatoriasFilter"
      tag="fichaCert"
      :page-length="30"
      @enter="goToAdministrar">
      <template slot="actions" slot-scope="data">
        <v-btn
          small
          color="#1976d2"
          class="white--text"
          @click="nuevaModificatoria()"
        >
          Nuevo
          <v-icon right>mdi-plus</v-icon>
        </v-btn>
        <div v-if="data.selected.index !== null" class="d-flex">
          <v-btn
            small
            color="#1976d2"
            class="white--text"
            @click="editModificatoria(data.selected.item.id)"
          >
            Editar
            <v-icon right>mdi-pencil</v-icon>
          </v-btn>
          <v-btn
            small
            color="#1976d2"
            class="white--text"
            @click="deleteModificatoria(data.selected.item.id)"
          >
            Eliminar
            <v-icon right>mdi-delete</v-icon>
          </v-btn>
          <v-btn small @click="goToAdministrar(data.selected)">
            Listar
            <v-icon right>mdi-format-list-bulleted</v-icon>
          </v-btn>
        </div>
      </template>
      <template slot="header">
        <tr>
          <th class="text-left" width="80%">Modificatoria</th>
          <th class="text-left" width="20%">Fecha</th>
        </tr>
      </template>
      <template slot="body" slot-scope="row">
        <td width="80%">{{ row.item.modif_titulo }}</td>
        <td width="20%">{{ row.item.modif_fecha_aprovacion }}</td>
      </template>
    </proy-table>
  </div>
</template>
<script>
  import Vuex from 'vuex'
  import ProyTable from '@/js/components/proyectos/ProyTable'

  export default {

    components: {
      ProyTable
    },

    data () {
      return {
        formModificatoria: {
          modif_titulo: null,
          modif_anio: null,
          modif_fecha_aprovacion: null
        },
        defaultFormModificatoria: {},
        filtro: {
          anio: curryear,
          dessertFilterValue: ''
        },
        dialog: false,
        puedeGuardar: false,
        modoEdit: false,
        toggle_exclusive: 3
      }
    },

    computed: {
      ...Vuex.mapGetters(['getAniosReporte',
        'showModificatorias',
        'getOneModificatoria']),

      modificatoriasFilter () {
        let filtrado = this.showModificatorias
        if (this.filtro.dessertFilterValue != null && this.filtro.dessertFilterValue !== '') {
          filtrado = filtrado.filter(d => d.modif_titulo === this.filtro.dessertFilterValue)
        }
        return filtrado
      }
    },

    created: function () {
      this.defaultFormModificatoria = Object.assign({}, this.formModificatoria)
      this.getModificatorias(this.filtro.anio)
    },

    updated: function () {
      this.$nextTick(function () {
        if (this.formModificatoria.modif_anio === null) {
          this.formModificatoria.modif_anio = this.filtro.anio
        }
      })
    },

    methods: {
      ...Vuex.mapActions(['getModificatorias', 'saveModificatoria', 'deleteModificatoria']),

      nuevaModificatoria () {
        this.$validator.reset()
        this.dialog = true
        this.modoEdit = false
        this.puedeGuardar = false
      },

      cerrarModal () {
        this.formModificatoria = Object.assign({}, this.defaultFormModificatoria)
        this.dialog = false
      },

      guardarModificatoria () {
        if (!this.puedeGuardar) {
          this.$validator.validate().then(result => {
            if (result) {
              this.puedeGuardar = true
              this.saveModificatoria(this.formModificatoria)
              this.cerrarModal()
            } else {
              console.log('incompleto')
            }
          })
        }
      },

      editModificatoria (item) {
        this.$validator.reset()
        this.puedeGuardar = false
        this.dialog = true
        this.modoEdit = true
        this.formModificatoria = JSON.parse(JSON.stringify(this.getOneModificatoria(item)))
        this.formModificatoria.modif_anio = this.filtro.anio
      },

      goToAdministrar (data) {
        this.$router.push({
          name: 'ModiDetalle',
          params: { anio: this.filtro.anio, id: data.item.id }
        })
      }
    }
  }
</script>
