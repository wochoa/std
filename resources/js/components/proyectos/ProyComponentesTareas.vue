<template>
  <div class="panel-body">
    <v-card>
      <v-card-title>
        Componentes Tareas
        <v-spacer />
        <!-- Modal nuevo documento certificación-->
        <v-dialog v-model="dialog" persistent max-width="1300px">
          <v-card>
            <v-toolbar dark color="primary">
              <v-btn icon dark @click="cerrarModal()">
                <v-icon>mdi-close</v-icon>
              </v-btn>
              <v-toolbar-title v-if="modoEdit && formComponente.id != -1">Editar componente tarea</v-toolbar-title>
              <v-toolbar-title v-else>Crear nuevo componente tarea</v-toolbar-title>
              <v-spacer />
              <v-toolbar-items>
                <v-btn :disabled="puedeGuardar" dark text @click="guardarComponenteTarea()">Guardar</v-btn>
              </v-toolbar-items>
            </v-toolbar>
            <v-list three-line subheader>
              <div class="d-flex flex-wrap">
                <div class="col-12 col-sm-12  ProyectosFormulario">
                  <v-label>Programa</v-label>
                  <v-autocomplete
                    v-model="formComponente.comp_programa"
                    :items="componentes.concat(showProgramasComponente)"
                    :item-text="item => item.programa_ppto + ' - ' + item.nombre"
                    item-value="programa_ppto"
                    solo
                  />
                </div>
                <div class="col-12 col-sm-6  ProyectosFormulario">
                  <v-label>Prod/Proy</v-label>
                  <v-text-field
                    v-model="formComponente.comp_prod_proy"
                    v-validate="'required|numeric'"
                    type="text"
                    disabled
                    :error-messages="errors.collect('cod_proyecto')"
                    data-vv-name="cod_proyecto"
                    solo
                  />
                </div>
                <div class="col-12 col-sm-6  ProyectosFormulario">
                  <v-label>Act / Al / Obra</v-label>
                  <v-text-field
                    v-model="formComponente.comp_act_al_obra"
                    v-validate="'required|numeric'"
                    type="text"
                    :error-messages="errors.collect('cod_obra')"
                    data-vv-name="cod_obra"
                    solo
                  />
                </div>
                <div class="col-12 col-sm-6  ProyectosFormulario">
                  <v-label>Función</v-label>
                  <v-autocomplete
                    v-model="formComponente.comp_funcion"
                    :items="mostrarFunciones"
                    :item-text="item => item.funcion + ' - ' + item.nombre"
                    item-value="funcion"
                    solo
                  />
                </div>
                <div class="col-12 col-sm-6  ProyectosFormulario">
                  <v-label>División Funcional</v-label>
                  <v-autocomplete
                    v-model="formComponente.comp_division_funcional"
                    :items="showDivisionesFuncionales"
                    :item-text="item => item.programa + ' - ' + item.nombre"
                    item-value="programa"
                    solo
                  />
                </div>
                <div class="col-12 col-sm-6  ProyectosFormulario">
                  <v-label>Grupo Funcional</v-label>
                  <v-autocomplete
                    v-model="formComponente.comp_grupo_funcional"
                    :items="showGrupoFuncionales"
                    :item-text="item => item.sub_programa + ' - ' + item.nombre"
                    item-value="sub_programa"
                    solo
                  />
                </div>
                <div class="col-12 col-sm-6  ProyectosFormulario">
                  <v-label>Meta</v-label>
                  <v-text-field
                    v-model="formComponente.comp_meta"
                    type="numeric"
                    solo />
                </div>
                <div class="col-12 col-sm-6  ProyectosFormulario">
                  <v-label>Finalidad</v-label>
                  <v-text-field
                    v-model="formComponente.comp_finalidad"
                    type="text"
                    solo />
                </div>
                <div class="col-12 col-sm-6  ProyectosFormulario">
                  <v-label>Monto Total</v-label>
                  <v-text-field
                    v-model="formComponente.comp_monto"
                    v-validate="'decimal'"
                    type="text"
                    :error-messages="errors.collect('total')"
                    data-vv-name="total"
                    solo
                  />
                </div>
                <div class="col-12 col-sm-12  ProyectosFormulario">
                  <v-label>Descripción</v-label>
                  <v-textarea
                    v-model="formComponente.comp_nombre"
                    v-validate="'required'"
                    :error-messages="errors.collect('descripcion')"
                    data-vv-name="descripcion"
                    solo
                    @change="formComponente.comp_nombre = formComponente.comp_nombre.toUpperCase()"
                  />
                </div>
              </div>
            </v-list>
            <v-divider />
            <v-list three-line subheader />
          </v-card>
        </v-dialog>
        <!--fin modal-->
      </v-card-title>
      <proy-table
        width="100%"
        class="ListadoTabla estatico"
        :items="showComponentesTareas"
        tag="tarea"
        :page-length="10"
      >
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
        </template>
        <template slot="header">
          <tr>
            <th style="width: 15%">Componente</th>
            <th style="width: 65%">CFP</th>
            <th style="width: 15%">Año/Secuencia Func.</th>
            <th style="width: 10%">Acciones</th>
          </tr>
        </template>
        <template slot="body" slot-scope="row">
          <td style="width: 15%">{{ row.item.comp_nombre }}</td>
          <td style="width: 60%">{{ row.item.cadena }}</td>
          <td style="width: 15%">
              <span
                v-for="(anio, index2) in row.item.ejec"
                :key="index2"
              >
                  {{ anio.anio + ' / ' }}<strong>{{ anio.sec_func }}</strong><br />
                </span>
          </td>
          <td style="width: 10%">
            <v-btn-toggle v-model="toggle_exclusive" color="primary" dense group>
              <v-btn fab small @click="obtenerUnCompoenenteTarea(row.item)">
                <v-tooltip v-if="row.item.id != -1" bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon color="primary" dark v-on="on">mdi-pencil</v-icon>
                  </template>
                  <span>Editar</span>
                </v-tooltip>
                <v-tooltip v-else bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon color="success" dark v-on="on">mdi-plus</v-icon>
                  </template>
                  <span>Guardar</span>
                </v-tooltip>
              </v-btn>
              <v-btn v-if="row.item.ejec == undefined" fab small @click="deleteComponente(row.item.id)">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon color="primary" dark v-on="on">mdi-delete</v-icon>
                  </template>
                  <span>Eliminar</span>
                </v-tooltip>
              </v-btn>
            </v-btn-toggle>
          </td>
        </template>
      </proy-table>
    </v-card>
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
        formComponente: {
          id: null,
          comp_programa: null,
          comp_prod_proy: null,
          comp_act_al_obra: null,
          comp_funcion: null,
          comp_division_funcional: null,
          comp_grupo_funcional: null,
          comp_meta: null,
          comp_finalidad: null,
          comp_monto: null,
          comp_nombre: null
        },
        defaultFormComponente: {},
        dialog: false,
        puedeGuardar: false,
        modoEdit: false,
        toggle_exclusive: 2,
        componentes: []
      }
    },

    computed: {
      ...Vuex.mapGetters([
        'showProgramasComponente',
        'mostrarFunciones',
        'showDivisionesFuncionales',
        'showGrupoFuncionales',
        'mostrarCodigoSiafProyectoSelect',
        'showComponentesTareas',
        'getOneComponenteTarea'
      ])
    },

    mounted () {
      this.defaultFormComponente = Object.assign({}, this.formComponente)
      this.getProgramasComponente()
      this.getDivisionesFuncionales()
      this.getGruposFuncionales()
    },

    updated: function () {
      this.$nextTick(function () {
        if (this.formComponente.comp_prod_proy === null) {
          this.formComponente.comp_prod_proy = JSON.parse(JSON.stringify(this.mostrarCodigoSiafProyectoSelect))
          this.getComponentesTareas(this.formComponente.comp_prod_proy)
        }
      })
    },

    methods: {
      ...Vuex.mapActions([
        'getProgramasComponente',
        'getDivisionesFuncionales',
        'getGruposFuncionales',
        'getComponentesTareas',
        'saveComponenteTarea',
        'deleteComponente'
      ]),

      nuevoComponenteTarea () {
        this.$validator.reset()
        this.dialog = true
        this.modoEdit = false
        this.puedeGuardar = false
      },

      cerrarModal () {
        this.formComponente = Object.assign({}, this.defaultFormComponente)
        this.formComponente.comp_prod_proy = JSON.parse(JSON.stringify(this.mostrarCodigoSiafProyectoSelect))
        this.dialog = false
        this.componentes = []
      },

      guardarComponenteTarea () {
        if (!this.puedeGuardar) {
          this.$validator.validate().then(result => {
            if (result) {
              this.puedeGuardar = true
              this.saveComponenteTarea(this.formComponente)
              this.cerrarModal()
            } else {
              console.log('incompleto')
            }
          })
        }
      },

      obtenerUnCompoenenteTarea (componente) {
        let c = this.showProgramasComponente.filter(d => d.programa_ppto === componente.comp_programa)[0]
        console.log(c)
        if (c == undefined) {
          this.componentes.push({
            programa_ppto: componente.comp_programa,
            nombre: 'PROGRAMA DESCONOCIDO'
          })
        }
        this.$validator.reset()
        this.puedeGuardar = false
        this.dialog = true
        this.modoEdit = true
        this.formComponente = JSON.parse(JSON.stringify(this.getOneComponenteTarea(componente.id)))
      }
    }
  }
</script>
