<template>
  <div class="d-flex flex-wrap">
    <div class="col-12 ProyectosFormulario">
      <v-textarea
        v-model="formProyecto.proy_nombre"
        v-validate="'required'"
        filled
        auto-grow
        rows="3"
        name="input-7-4"
        label="Nombre de proyecto"
        :error-messages="errors.collect('nombre')"
        data-vv-name="nombre"
        solo
        @change="formProyecto.proy_nombre = formProyecto.proy_nombre.toUpperCase()"
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Código SNIP</v-label>
      <v-text-field
        v-model="formProyecto.proy_cod_snip"
        v-validate="'required|numeric|unique:proy_cod_snip'"
        :error-messages="errors.collect('snip')"
        data-vv-name="snip"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Código SIAF</v-label>
      <v-text-field
        v-model="formProyecto.proy_cod_siaf"
        v-validate="'required|numeric|unique:proy_cod_siaf'"
        :error-messages="errors.collect('cod_siaf')"
        data-vv-name="cod_siaf"
        solo
      >
        <template v-slot:append>
          <v-menu style="top: -2px" offset-y>
            <template v-slot:activator="{ on }">
              <v-btn @click="buscarSiaf()">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <span class="icon icon-logosiaf fs-26"></span>
                  </template>
                  <span>Descargar</span>
                </v-tooltip>
              </v-btn>
            </template>
          </v-menu>
        </template>
      </v-text-field>
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Funcion</v-label>
      <v-select
        v-model="formProyecto.funcion_id"
        :items="mostrarFunciones"
        item-text="nombre"
        item-value="funcion"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Fuente de Financiamiento</v-label>
      <v-text-field
        v-model="formProyecto.proy_fte_fto"
        solo
        @change="formProyecto.proy_fte_fto = formProyecto.proy_fte_fto.toUpperCase()"
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Beneficiarios</v-label>
      <v-text-field
        v-model="formProyecto.proy_beneficiarios"
        v-validate="'numeric'"
        :error-messages="errors.collect('beneficiarios')"
        data-vv-name="beneficiarios"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Distrito</v-label>
      <v-select v-model="formProyecto.ubigeo_id" :items="mostratUbigeo2" solo />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Localidad</v-label>
      <v-text-field
        v-model="formProyecto.proy_localidad"
        solo
        @change="formProyecto.proy_localidad = formProyecto.proy_localidad.toUpperCase()"
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Perfil viable</v-label>
      <v-text-field
        v-model="formProyecto.proy_perfil_viable"
        v-validate="'decimal'"
        :error-messages="errors.collect('perfil_viable')"
        data-vv-name="perfil_viable"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>ET FR SNIP 15</v-label>
      <v-text-field
        v-model="formProyecto.proy_snip15"
        v-validate="'decimal'"
        type="number"
        :error-messages="errors.collect('snip15')"
        data-vv-name="snip15"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Modificaciones SNIP 16</v-label>
      <v-text-field
        v-model="formProyecto.proy_snip16"
        v-validate="'decimal'"
        type="number"
        :error-messages="errors.collect('snip16')"
        data-vv-name="snip16"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Verificacion de Viabilidad</v-label>
      <v-text-field
        v-model="formProyecto.proy_verificacion_viabilidad"
        type="date"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Modificaciones sin evaluacion</v-label>
      <v-text-field
        v-model="formProyecto.proy_modificaciones_sin_evaluacion"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Fecha de Registro del Perfil (*)</v-label>
      <v-text-field
        v-model="formProyecto.proy_fech_registro_perfil"
        type="date"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Estado de la obra</v-label>
      <v-select
        v-model="formProyecto.proy_estado"
        :items="mostrarEstados"
        item-text="descripcion"
        item-value="id"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Monto PIP Act</v-label>
      <v-text-field
        v-model="formProyecto.proy_pip_actualizado"
        v-validate="'decimal'"
        type="number"
        :error-messages="errors.collect('pip_act')"
        data-vv-name="pip_act"
        solo
      />
    </div>
    <div class="col-12 col-sm-6  ProyectosFormulario">
      <v-label>Inc. Carta Fianza</v-label>
      <v-text-field v-model="formProyecto.proy_pres_inc_cf" label="" solo />
    </div>
  </div>
</template>

<script>
import Vuex from 'vuex'

export default {
  name: 'ProyFormulario',
  props: {
    formProyecto: Object
  },
  data: () => ({
    loading: false
  }),

  computed: {
    ...Vuex.mapGetters(['mostrarFunciones', 'mostrarEstados', 'mostratUbigeo2'])
  },

  methods:{
    buscarSiaf() {
      this.$emit('buscarSiaf')
    }
  }
}
</script>

<style scoped></style>
