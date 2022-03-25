<template>
  <div class="panel-body">
    <v-app>
      <v-content>
        <v-btn
          small
          color="#1976d2"
          class="white--text"
          @click="generarInformeProyecto()"
        >
          Nuevo
          <v-icon right>mdi-plus</v-icon>
        </v-btn>
        <div class="d-flex justify-content-end">
          <div class="Filtros min-w-500 m-1 mb-2">
            <div class="col-12 col-sm-12 FiltrosGrupo">
              <label>Nombre</label>
              <v-text-field
                v-model="inf_descripcion"
                class="FiltrosInput"
                :hide-details="true"
              />
            </div>
          </div>
        </div>

        <!--Modal para crear un nuevo informe para un proyecto-->
        <v-dialog v-model="dialogInforme" max-width="1500px">
          <v-card>
            <v-toolbar dark color="primary">
              <v-btn icon dark @click="cerrarModalInforme()">
                <v-icon>mdi-close</v-icon>
              </v-btn>
              <v-toolbar-title>Crear un nuevo Informe para el proyecto</v-toolbar-title>
              <v-spacer />
              <v-toolbar-items>
                <v-btn dark text :disabled="puedeGuardar" @click="saveInforme()">Guardar</v-btn>
              </v-toolbar-items>
            </v-toolbar>
            <proy-informe-nuevo :form-informe="formInforme" />
          </v-card>
        </v-dialog>
        <!--fin modal-->
        <!--Modal Visor Imagen-->
        <v-row justify="center">
          <v-dialog v-model="dialog" persistent max-width="1000px">
            <v-card>
              <v-card-title>
                <span class="headline">Imagen</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row justify="space-around">
                    <span v-for="(item, index) in srcModal" :key="index" v-if="index == indexCarousels">
                      <strong>{{ item.file_name }}</strong>
                    </span>
                  </v-row>
                  <v-carousel v-model="indexCarousels">
                    <v-carousel-item
                      v-for="(item, i) in srcModal"
                      :key="i"
                      :src="item.src"
                      reverse-transition="fade-transition"
                      transition="fade-transition"
                    >
                      <v-row
                        v-if="item.file_tipo.indexOf('application') === 0"
                        class="fill-height"
                        align="center"
                        justify="center"
                      >
                        <div class="display-3"><small>Ver el PDF</small>
                          <v-btn @click="openPdf(i)">Abrir</v-btn>
                        </div>
                      </v-row>
                    </v-carousel-item>
                  </v-carousel>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn color="blue darken-1" text @click="cerrarModalImagenes()">Cerrar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-row>
        <!--FIn Modal-->

        <v-timeline :align-top="alignTop" :dense="dense" :reverse="reverse">
          <v-timeline-item
            v-for="(informe, index1) in informesFilter"
            :key="index1"
            :fill-dot="fillDot"
            :hide-dot="hideDot"
            :icon="icon ? 'mdi-star' : ''"
            :icon-color="iconColor ? 'deep-orange' : ''"
            :left="left"
            :right="right"
            :small="small"
          >
            <template v-slot:icon>
              <v-avatar v-if="avatar">
                <img src="http://i.pravatar.cc/64" />
              </v-avatar>
            </template>
            <span slot="opposite">{{ informe.created_at }}</span>
            <v-card class="elevation-2">
              <v-card-title class="headline">{{ getUsuariosNameById(informe.id_admin) }}
                <v-btn-toggle v-model="toggle_exclusive" color="primary" dense group>
                  <v-row v-if="!informe.edit" class="fill-height ma-2">
                    <v-btn
                      fab
                      small
                      @click="
                        setInformeForEditComponet(informe.id, true)
                        formInformeEdit = JSON.parse(JSON.stringify(informe))
                      "
                    >
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                          <v-icon color="primary" dark v-on="on">mdi-pencil</v-icon>
                        </template>
                        <span>Editar</span>
                      </v-tooltip>
                    </v-btn>
                  </v-row>
                  <v-row v-if="informe.edit" class="fill-height ma-2">
                    <v-btn fab small :disabled="puedeGuardar" @click="actualizar()">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                          <v-icon color="primary" dark v-on="on">mdi-check</v-icon>
                        </template>
                        <span>Guardar</span>
                      </v-tooltip>
                    </v-btn>
                  </v-row>
                  <v-row v-if="informe.edit && mostrarRestaurar" class="fill-height ma-2">
                    <v-btn fab small @click="restaurar()">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                          <v-icon color="success" dark v-on="on">mdi-restore</v-icon>
                        </template>
                        <span>restaurar</span>
                      </v-tooltip>
                    </v-btn>
                  </v-row>
                  <v-row v-if="informe.edit" class="fill-height ma-2">
                    <v-btn fab small @click="setInformeForEditComponet(informe.id, false)">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                          <v-icon color="primary" dark v-on="on">mdi-close</v-icon>
                        </template>
                        <span>Cancelar</span>
                      </v-tooltip>
                    </v-btn>
                  </v-row>
                </v-btn-toggle>
              </v-card-title>
              <v-card-text>
                <v-row v-if="informe.edit" class="fill-height ma-0">
                  <v-text-field
                    v-model="formInformeEdit.inf_descripcion"
                    :dense="denseTex"
                    @change="formInformeEdit.inf_descripcion = formInformeEdit.inf_descripcion.toUpperCase()"
                  />
                </v-row>
                <v-row v-else class="fill-height ma-0">
                  {{ informe.inf_descripcion }}
                </v-row>
              </v-card-text>
              <v-row>
                <v-col cols="12" sm="12" offset-sm="12">
                  <v-card>
                    <v-container fluid>
                      <v-row dense>
                        <v-col
                          v-for="(archivo, index1) in getInf_FilesTrue({ id: informe.id, edit: informe.edit })"
                          :key="index1"
                          :set="(total = getTotalFilesTrue(informe.id))"
                          class="d-flex child-flex"
                          cols="4"
                        >
                          <v-card flat tile class="d-flex">
                            <v-row dense>
                              <v-col cols="12" sm="12" offset-sm="12">
                                <div class="body-1">
                                  <v-row class="fill-height ma-0">
                                    <v-text-field
                                      v-if="informe.edit"
                                      :dense="denseTex"
                                      :value="
                                        formInformeEdit.inf_archivos[informe.inf_archivos.indexOf(archivo)].file_name
                                      "
                                      @change="
                                        formInformeEdit.inf_archivos[
                                          informe.inf_archivos.indexOf(archivo)
                                        ].file_name = $event.toUpperCase()
                                      "
                                    />
                                    <h5 v-else>{{ archivo.file_name }}</h5>
                                    <v-btn
                                      v-if="informe.edit"
                                      icon
                                      @click="
                                        formInformeEdit.inf_archivos[
                                          informe.inf_archivos.indexOf(archivo)
                                        ].file_mostrar = 0
                                        actualizar()
                                      "
                                    >
                                      <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                  </v-row>
                                </div>
                              </v-col>
                              <v-col cols="12" sm="12" offset-sm="12">
                                <v-img
                                  :src="publicarImagenes(archivo)"
                                  aspect-ratio="1"
                                  class="grey lighten-2"
                                  @click="abrirModal(informe.id, archivo)"
                                >
                                  <v-row
                                    v-if="index1 == 5 && !informe.edit"
                                    align="center"
                                    justify="center"
                                    class="lightbox white--text pa-2 fill-height"
                                  >
                                    <v-col>
                                      <h1>{{ '+ ' }}{{ total - (index1 + 1) }}</h1>
                                    </v-col>
                                  </v-row>
                                </v-img>
                              </v-col>
                              <v-col cols="12" sm="12" offset-sm="12">
                                <small>
                                  <strong>{{ 'Fecha: ' + archivo.fecha }}</strong>
                                </small>
                              </v-col>
                            </v-row>
                          </v-card>
                        </v-col>
                        <v-col
                          v-for="(imagen, index2) in mostrarArchivos"
                          v-if="informe.edit"
                          :key="index2"
                          class="d-flex child-flex"
                          cols="4"
                        >
                          <v-card flat tile class="d-flex">
                            <v-row>
                              <v-col cols="12" sm="12" offset-sm="12">
                                <div class="body-1">
                                  <v-row class="fill-height ma-0">
                                    <v-text-field
                                      :dense="denseTex"
                                      label="Descripción (opcional)"
                                      :value="imagen.file_name"
                                      @change="updateDescripcion(imagen.md5, $event)"
                                    />
                                    <v-btn icon @click="ocultarArchivo(imagen.md5)">
                                      <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                  </v-row>
                                </div>
                              </v-col>
                              <v-col cols="12" sm="12" offset-sm="12">
                                <v-img
                                  v-if="imagen.file_tipo.indexOf('image') === 0"
                                  :lazy-src="imagen.base64"
                                  aspect-ratio="1"
                                  class="grey lighten-2"
                                  style="width: 248px;"
                                />

                                <div v-else class="body-1">
                                  <v-row align="center" justify="space-around">
                                    <v-icon x-large>mdi-pdf-box</v-icon>
                                  </v-row>
                                </div>
                              </v-col>
                            </v-row>
                          </v-card>
                        </v-col>
                        <v-col class="d-flex child-flex" cols="4">
                          <v-card flat tile class="d-flex" v-if="informe.edit">
                            <v-file-input
                              v-model="formInforme.inf_archivos.arch_archivo"
                              prepend-icon="mdi-plus"
                              multiple
                              small-chips
                              accept=".JPG,.PNG,.pdf"
                              label="Subir archivo"
                              @change="convertirImagen()"
                            />
                          </v-card>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card>
                </v-col>
              </v-row>
            </v-card>
          </v-timeline-item>
        </v-timeline>
      </v-content>
    </v-app>
  </div>
</template>
<script>
  import Vuex from 'vuex'
  import proyectos from '@/js/api/proyectos/proyectos'
  import ProyInformeNuevo from '@/js/components/proyectos/ProyInformeNuevo'

  export default {

    components: {
      ProyInformeNuevo
    },

    data () {
      return {
        formInforme: {
          id_proyecto: this.$route.params.idproyecto,
          inf_descripcion: null,
          inf_cordenadas: null,
          inf_archivos: {
            arch_archivo: null
          }
        },
        formInformeEdit: {},
        defaultFormInforme: {},
        inf_descripcion: null,

        dialogInforme: false,
        dialog: false,
        toggle_exclusive: 2,

        alignTop: false,
        avatar: false,
        dense: false,
        fillDot: false,
        hideDot: false,
        icon: false,
        iconColor: false,
        left: false,
        reverse: false,
        right: false,
        small: false,
        denseTex: true,

        tumbAncho: 248,
        tumbAlto: 248,
        srcModal: [],
        fileSrcPopupPdf: [],
        indexCarousels: 0,
        puedeGuardar: false,
        mostrarRestaurar: false
      }
    },

    computed: {
      ...Vuex.mapGetters([
        'getInformes',
        'getInf_FilesTrue',
        'mostrarArchivos',
        'getUsuariosNameById',
        'getTotalFilesTrue'
      ]),

      informesFilter () {
        let filtrado = this.getInformes
        if (this.inf_descripcion != null && this.inf_descripcion !== '') {
          let words = this.inf_descripcion.split(' ')
          for (let i = 0; i < words.length; i++)
            filtrado = filtrado.filter(el => el.inf_descripcion != null && el.inf_descripcion.toLowerCase().indexOf(words[i].toLowerCase()) > -1)
        }
        return filtrado
      }
    },

    created: function () {
      this.defaultFormInforme = Object.assign({}, this.formInforme)
      this.obtenerInformesByProyecto(this.$route.params.idproyecto)
      this.newInforme()
      this.getUsuarios()
    },

    methods: {
      ...Vuex.mapActions([
        'guardarInforme',
        'ejecutarRecursivamente',
        'obtenerInformesByProyecto',
        'newInforme',
        'setInformeForEdit',
        'actualizarInforme',
        'agregarFile',
        'updateArchivoDescripcion',
        'ocultarArchivo',
        'getUsuarios',
      ]),

      cerrarModalInforme () {
        this.dialogInforme = false
        this.formInforme = Object.assign({}, this.defaultFormInforme)
        this.newInforme()
      },

      cerrarModalImagenes () {
        this.dialog = false
        this.srcModal = []
        this.fileSrcPopupPdf = []
      },

      setInformeForEditComponet (id, condicional) {
        this.puedeGuardar = false
        this.setInformeForEdit({ id: id, edit: condicional }).then(response => {
          let i = 0
          while (i < this.formInformeEdit.inf_archivos.length) {
            if (!this.formInformeEdit.inf_archivos[i].file_mostrar) {
              this.mostrarRestaurar = true
            }
            i++
          }
        })
      },
      actualizar () {
        if (!this.puedeGuardar) {
          this.puedeGuardar = true
          this.actualizarInforme({ c: this, f: this.formInformeEdit })
          this.formInforme = Object.assign({}, this.defaultFormInforme)
          this.newInforme()
        }
      },
      restaurar () {
        if (!this.puedeGuardar) {
          this.puedeGuardar = true
          for (var i = 0; i < this.formInformeEdit.inf_archivos.length; i++) {
            if (!this.formInformeEdit.inf_archivos[i].file_mostrar) this.formInformeEdit.inf_archivos[i].file_mostrar = 1
          }
          this.actualizarInforme({ c: this, f: this.formInformeEdit })
          this.formInforme = Object.assign({}, this.defaultFormInforme)
          this.newInforme()
          this.mostrarRestaurar = false
        }
      },
      saveInforme () {
        if (!this.puedeGuardar) {
          this.puedeGuardar = true
          var este = this

          if (typeof navigator.geolocation == 'object') {
            navigator.geolocation.getCurrentPosition(function (position) {
              este.formInforme.inf_cordenadas = position.coords.latitude + ',' + position.coords.longitude
              if (este.formInforme.inf_cordenadas != null) {
                este.guardarInforme(este.formInforme)
                este.cerrarModalInforme()
                este.obtenerInformesByProyecto(este.formInforme.id_proyecto)
              }
            })
          }
        }
      },

      generarInformeProyecto () {
        this.dialogInforme = true
        this.puedeGuardar = false
        this.formInforme = Object.assign({}, this.defaultFormInforme)
        this.ejecutarRecursivamente({
          context: this,
          after: function (context) {
            if (context.$validator != undefined) context.$validator.reset()
          }
        })
      },
      log (i) {
        console.log(i)
      },

      abrirModal (id, archivo) {
        this.srcModal = this.publicarImagenGrande(id, archivo)
        this.dialog = true
      },

      publicarImagenes (archivo) {
        if (archivo.file_tipo.indexOf('image') === 0) {
          let f = ''
          f += 'id=' + archivo.id
          f += '&id_proy_informe=' + archivo.id_proy_informe
          f += '&tumbAncho=' + this.tumbAncho
          f += '&tumbAlto=' + this.tumbAlto

          return '/app/proyectos/informe/print?' + f
        } else {
          return '/images/tmb_248x248_imagenpdf.jpg'
        }
      },

      publicarImagenGrande (id, archivo) {
        let arrayImagenes = this.getInf_FilesTrue({ id: id, edit: true })
        let j = 0
        while (archivo.file_url != arrayImagenes[j].file_url) {
          j++
        }
        this.indexCarousels = j
        let k = ''
        let retu = []
        for (let i = 0; i < arrayImagenes.length; i++) {
          if (arrayImagenes[i].file_tipo.indexOf('image') === 0) {
            k += 'id=' + arrayImagenes[i].id
            k += '&id_proy_informe=' + arrayImagenes[i].id_proy_informe
            retu.push({
              src: '/app/proyectos/informe/print?' + k,
              file_tipo: arrayImagenes[i].file_tipo,
              file_name: arrayImagenes[i].file_name
            })
            k = ''
          } else {
            retu.push({
              src: '/images/imagenpdf.jpg',
              file_tipo: arrayImagenes[i].file_tipo,
              file_name: arrayImagenes[i].file_name
            })
            k = ''
            //this.fileSrcPopupPdf ={'file':arrayImagenes[i].file, 'id_info':id, 'tipo':arrayImagenes[i].tipo};
            this.fileSrcPopupPdf.push({
              file_url: arrayImagenes[i].file_url,
              id_info: arrayImagenes[i].id,
              id_proy_informe: arrayImagenes[i].id_proy_informe,
              file_tipo: arrayImagenes[i].file_tipo
            })
          }
        }
        return retu
        /*let final = [];
              var d=0;
              for(var g = 0; g<arrayImagenes.length; g++){
                  if(j!=0){
                      while(j<arrayImagenes.length){
                          final[g] = retu[j];
                          g++;
                          j++;
                      }
                  }else if (j!=0 && arrayImagenes.length ==2){
                      final[g] = retu[j];
                      g++;
                      d++;
                  }
                  final[g] = retu[d];
                  d++;
              }
              return final;*/
      },

      openPdf (index) {
        let ind = []
        for (var i = 0; i < this.srcModal.length; i++) {
          if (this.srcModal[i].file_tipo.indexOf('application') === 0) {
            ind.push({ index: i })
          }
        }

        let j = 0
        while (index != ind[j].index) {
          j++
        }
        return this.publicarPdf(this.fileSrcPopupPdf[j].id_info, this.fileSrcPopupPdf[j])
      },

      publicarPdf (id, archivo) {
        if (archivo.file_tipo.indexOf('image') !== 0) {
          let f = ''
          f += 'id=' + id
          f += '&id_proy_informe=' + archivo.id_proy_informe
          let route = '/app/proyectos/informe/print?' + f
          window.open(route, 'Visor', 'width=1000,height=750')
        }
      },

      convertirImagen () {
        for (var i = 0; i < this.formInforme.inf_archivos.arch_archivo.length; i++) {
          this.agregarFile(this.formInforme.inf_archivos.arch_archivo[i])
        }
        this.formInforme.inf_archivos.arch_archivo = []
      },

      updateDescripcion (md5, value) {
        this.updateArchivoDescripcion({ md5: md5, file_name: value.toUpperCase() })
      }
    }
  }
</script>
<style scoped></style>
