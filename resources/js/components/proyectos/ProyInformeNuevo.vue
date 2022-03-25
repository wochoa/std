<template>
  <div>
    <v-list three-line subheader>
      <div class="d-flex flex-wrap">
        <div class="col-12 ProyectosFormulario">
          <v-textarea
            v-model="formInforme.inf_descripcion"
            v-validate="'required'"
            solo
            label="Descripción del informe"
            :error-messages="errors.collect('descripcion')"
            data-vv-name="descripcion"
            @change="formInforme.inf_descripcion = formInforme.inf_descripcion.toUpperCase()"
          />
        </div>
        <v-row>
          <v-col cols="12" sm="6" offset-sm="3">
            <v-card>
              <v-col v-for="(imagen, index) in mostrarArchivos" :key="index" class="d-flex child-flex" cols="4">
                <v-card flat tile class="d-flex">
                  <v-row>
                    <v-col cols="12" sm="12" offset-sm="12">
                      <div class="body-1">
                        <v-row class="fill-height ma-0">
                          <v-text-field
                            :dense="denseTex"
                            label="Descripción (opcional)"
                            :value="imagen.file_name"
                            solo
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
                <v-card flat tile class="d-flex">
                  <v-file-input
                    v-model="formInforme.inf_archivos.arch_archivo"
                    prepend-icon="mdi-plus"
                    show-size
                    counter
                    multiple
                    small-chips
                    accept=".JPG,.PNG,.pdf"
                    label="Subir archivo"
                    solo
                    @change="convertirImagen()"
                  />
                </v-card>
              </v-col>
            </v-card>
          </v-col>
        </v-row>
      </div>
    </v-list>
    <v-divider />
    <v-list three-line subheader />
  </div>
</template>
<script>
import Vuex from 'vuex'
export default {

  name: 'ProyInformeNuevo',

  props: {
      formInforme:{
      type: Object,
      default: () => ({})
    },
  },

  data() {
    return {
      denseTex: true
    }
  },

  computed: {
    ...Vuex.mapGetters(['mostrarArchivos'])
  },

  methods: {
    ...Vuex.mapActions(['updateArchivoDescripcion', 'ocultarArchivo', 'agregarFile']),

    updateDescripcion(md5, value) {
      this.updateArchivoDescripcion({ md5: md5, file_name: value.toUpperCase() })
    },

    convertirImagen() {
      for (var i = 0; i < this.formInforme.inf_archivos.arch_archivo.length; i++) {
        this.agregarFile(this.formInforme.inf_archivos.arch_archivo[i])
      }
      this.formInforme.inf_archivos.arch_archivo = []
    }
  }
}
</script>
