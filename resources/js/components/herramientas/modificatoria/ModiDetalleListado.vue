<template>
  <div>
    <v-simple-table fixed-header :dense="true" :set="(m = showModificatoriaDetalle)">
      <template v-slot:default>
        <thead>
          <tr>
            <th width="35%">Proyecto /Componente / Especifica</th>
            <th width="12%">PIM</th>
            <th width="8%">DE</th>
            <th width="8%">A</th>
            <th width="8%">Nuevo PIM</th>
            <th width="12%">Certificado</th>
            <th width="17%">Justificacion</th>
          </tr>
        </thead>
        <!--Total-->
        <tbody>
          <tr class="red lighten-3 text-right">
            <td>Total</td>
            <td class="border-right">{{ formatDecimal(m.total.pim) }}</td>
            <td>{{ formatDecimal(m.total.de) }}</td>
            <td class="border-right">{{ formatDecimal(m.total.a) }}</td>
            <td></td>
            <td>{{ formatDecimal(m.total.cert) }}</td>
            <td></td>
          </tr>
        </tbody>
        <!--fin de Total-->
        <!--Proyecto-->
        <tbody v-for="(proyecto, index) in m.proyectos" :key="index" class="proyecto">
          <tr></tr>
          <tr class="separador_top">
            <td colspan="8"></td>
          </tr>
          <tr class="green lighten-3">
            <td>{{ proyecto.nombre }}</td>
            <td class="border-right">
              <modi-detalle-resumen
                :dato="{
                  limite: proyecto.limite,
                  acumulado: proyecto.acumulado,
                  otras_ejecutoras: proyecto.otras_ejecutoras,
                  pim: proyecto.pim1
                }"
              />
            </td>
            <td class="text-right">{{ formatDecimal(proyecto.de) }}</td>
            <td class="text-right border-right">{{ formatDecimal(proyecto.a) }}</td>
            <td></td>
            <td class="text-right">{{ formatDecimal(proyecto.a) }}</td>
            <td></td>
          </tr>

          <tr
            v-for="(d, index1) in proyecto.contenido"
            :key="index1"
            :class="{ cyan: d.id === -1, amber: d.id !== -1, 'lighten-4': true, 'font-weight-bold': d.id === -1 }"
            :set="(max = d.pim1 - d.certificado >= 0 ? d.pim1 - d.certificado : 0)"
          >
            <td>
              <div v-if="d.id === -1">
                {{ d.comp_nombre }}<br />
                <strong v-if="d.sec_func !== null" class="sec_func">SEC FUNC (META) - {{ d.sec_func }}</strong>
              </div>
              <div v-else>
                2.6.2.3.2.4 - INFRAESTRUCTURA VIAL &gt; ADMINISTRACION DIRECTA - PERSONAL<br />
                <a href="#" data-id="4917" class="delete"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
              </div>
            </td>
            <td class="border-right">
              <modi-detalle-resumen
                :dato="{
                  limite: 0,
                  acumulado: d.acumulado,
                  otras_ejecutoras: 0,
                  pim: d.pim1
                }"
              />
            </td>
            <td class="text-right">
              <div v-if="d.id === -1">{{ formatDecimal(d.de) }}</div>
              <div v-else>
                <v-text-field
                  label="De"
                  :rules="[
                    value => parseInt(value) >= 0 || 'El valor debe de ser un numero positivo',
                    value => parseInt(value) <= max || 'Máximo ' + formatDecimal(max)
                  ]"
                  :hide-details="false"
                  :hint="'max: ' + formatDecimal(max)"
                  :value="formatDecimal(d.de)"
                />
              </div>
            </td>
            <td class="text-right border-right">
              <div v-if="d.id === -1">{{ formatDecimal(d.a) }}</div>
              <div v-else>
                <v-text-field
                  label="A"
                  :rules="[value => parseInt(value) >= 0 || 'El valor debe de ser un numero positivo']"
                  :hide-details="false"
                  :value="formatDecimal(d.a)"
                />
              </div>
            </td>
            <td class="text-right">{{ formatDecimal(d.pim) }}</td>
            <td class="text-right">
              <div v-if="d.id === -1">{{ formatDecimal(d.certificado) }}</div>
              <div v-else>
                {{ formatDecimal(d.certificado) }}<br /><strong>{{ d.certificados }}</strong>
              </div>
            </td>
            <td>
              <div v-if="d.id === -1">
                <a href="#"><i class="glyphicon glyphicon-plus"></i> Agregar Especifica</a>
              </div>
              <div v-else>
                <textarea rows="2">ASIGNACION PRESUPUESTAL POR PRIORIZACION DE PLANILLA DE PERSONAL OBRERO.</textarea>
              </div>
            </td>
          </tr>
          <tr class="separador_bottom">
            <td colspan="8"></td>
          </tr>
        </tbody>
        <!--fin de Proyecto-->
      </template>
    </v-simple-table>
  </div>
</template>

<script>
import Vuex from 'vuex'
import ModiDetalleResumen from './ModiDetalleResumen'
export default {
  name: 'ModiDetalleListado',

  components: {
    ModiDetalleResumen
  },

  computed: {
    ...Vuex.mapGetters(['showModificatoriaDetalle', 'formatDecimal'])
  },
}
</script>

<style lang="scss" scoped>
$input-text-align: right;
.separador_top td {
  padding: 0px;
  height: 10px;
  border-right: hidden !important;
  border-left: hidden !important;
  border-bottom: solid 2px #9e9c9c !important;
}
.separador_bottom td {
  padding: 0px;
  height: 10px;
  border-right: hidden !important;
  border-left: hidden !important;
  border-top: solid 2px grey !important;
}
.border-right {
  border-right: solid grey 2px;
}
.proyecto > tr > td:last-child {
  border-right: solid grey 2px;
}
.proyecto > tr > td:first-child {
  border-left: solid grey 2px;
}
.proyecto > tr > td {
  vertical-align: top;
}
.sec_func {
  text-decoration: underline;
  background-color: #f5baba;
}
</style>
