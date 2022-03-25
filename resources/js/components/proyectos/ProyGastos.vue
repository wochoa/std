<template>
  <div>
    <v-row dense>
      <v-col cols="12" sm="4" md="4">
        <v-select
          v-model="formGasto.formato"
          :items="formato"
          label="Modalidad de ejecución"
          @change="establecerFormGastos(JSON.parse(JSON.stringify(formGasto)))"
        />
      </v-col>
      <v-col cols="12" sm="4" md="2">
        <v-select
          v-model="formGasto.anio"
          :items="[{ text: 'Todos los años', value: 'all' }].concat(getAniosReporte)"
          label="Año"
          :hide-details="true"
          @change="
            abierto = [formGasto.anio.toString() + '-']
            establecerFormGastos(JSON.parse(JSON.stringify(formGasto)))
            getProyectoGastos()
          "
        />
      </v-col>
      <v-col cols="12" sm="4" md="4">
        <v-btn outlined color="primary" @click="excel">
          <v-icon left>mdi-printer</v-icon>
          Exportar Excel
        </v-btn>
        <v-btn outlined color="primary" @click="excelAll">
          <v-icon left>mdi-printer</v-icon>
          Exportar Excel Completo
        </v-btn>
      </v-col>
    </v-row>
    <div
      class="table-scroll"
      :style="tableDrag.tableStyle"
      @mousedown="
        tableDrag.tableStyle.cursor = '-webkit-grabbing'
        tableDrag.xPosition = $event.pageX
        tableDrag.clicked = true
      "
      @mouseup="
        tableDrag.tableStyle.cursor = '-webkit-grab'
        tableDrag.clicked = false
      "
      @mouseleave="
        tableDrag.tableStyle.cursor = '-webkit-grab'
        tableDrag.clicked = false
      "
      @mousemove="mousemove"
    >
      <table cellpadding="0" cellspacing="0" border="0" width="2200" style="width: 2100px">
        <thead class="thead-light">
          <tr class="cyan lighten-4">
            <th width="40" rowspan="2">
              <center />
            </th>
            <th width="60" rowspan="2">Año</th>
            <th width="60" rowspan="2">
              {{ formGasto.formato == 1 ? 'Fto' : 'Meta' }}
            </th>
            <th width="60" rowspan="2">
              {{ formGasto.formato == 1 ? 'Meta' : formGasto.formato == 2 ? 'Fto' : 'Especifica' }}
            </th>
            <th width="60" rowspan="2">Especifica</th>
            <th width="60" rowspan="2">Cert.</th>
            <th width="60" rowspan="2">Comp.</th>
            <th width="90" rowspan="2">EXP_SIAF</th>
            <th width="80" rowspan="2">PIM</th>
            <th width="80" rowspan="2">Programado</th>
            <th colspan="3" style="border-left: solid #000 2px">
              <center>CERTIFICADO</center>
            </th>
            <th colspan="3" style="border-left: solid #000 2px">
              <center>COMPROMISO</center>
            </th>
            <th colspan="3" style="border-left: solid #000 2px; border-right: solid #000 2px">
              <center>DEVENGADO</center>
            </th>
            <th colspan="12">
              <center>DEVENGADO MENSUALIZADO</center>
            </th>
          </tr>
          <tr class="cyan lighten-4">
            <th width="100" style="border-left: solid #000 2px">MONTO.</th>
            <th width="100">SALDO</th>
            <th width="50">%</th>
            <th width="100" style="border-left: solid #000 2px">MONTO.</th>
            <th width="100">SALDO</th>
            <th width="50">%</th>
            <th width="100" style="border-left: solid #000 2px">MONTO.</th>
            <th width="100">SALDO</th>
            <th width="50" style="border-right: solid #000 2px">%</th>
            <th width="100">
              <center>Ene</center>
            </th>
            <th width="100">
              <center>Feb</center>
            </th>
            <th width="100">
              <center>Mar</center>
            </th>
            <th width="100">
              <center>Abr</center>
            </th>
            <th width="100">
              <center>May</center>
            </th>
            <th width="100">
              <center>Jun</center>
            </th>
            <th width="100">
              <center>Jul</center>
            </th>
            <th width="100">
              <center>Ago</center>
            </th>
            <th width="100">
              <center>Set</center>
            </th>
            <th width="100">
              <center>Oct</center>
            </th>
            <th width="100">
              <center>Nov</center>
            </th>
            <th width="100">
              <center>Dic</center>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(a, index) in getProyectoGastos2"
            v-show="(a.lvl == 0 || abierto.indexOf(a.parent) != -1) && (a.monto_pim > 0 || a.lvl >= 4)"
            :key="index"
            :set="(denominador = a.lvl < 4 ? a.monto_pim : a.lvl === 4 ? a.monto_cert : a.monto_comp)"
            :class="{
              caption: true,
              grey: true,
              'darken-2': a.lvl === 0,
              'white--text': a.lvl <= 1,
              'darken-1': a.lvl === 1,
              'lighten-1': a.lvl === 2,
              'lighten-2': a.lvl === 3,
              'lighten-3': a.lvl === 4,
              'lighten-4': a.lvl === 5,
              'lighten-5': a.lvl === 6,
            }"
          >
            <td v-for="n in a.lvl" :key="n"></td>
            <td>
              <v-btn
                v-if="
                  abierto.indexOf(a.key) === -1 &&
                  a.lvl < 6 &&
                  (a.lvl < 3 ||
                    (a.lvl === 3 && a.monto_cert > 0) ||
                    (a.lvl === 4 && a.monto_comp > 0) ||
                    (a.lvl === 5 && a.monto_dev > 0))
                "
                text
                icon
                dark
                color="primary"
                @click="
                  abierto.push(a.key)
                  ;(a.lvl == 3 || a.lvl == 4 || a.lvl == 5) && loaded.indexOf(a.key) === -1
                    ? addGastos(a.key, a.lvl)
                    : ''
                "
              >
                <v-icon>mdi-plus</v-icon>
              </v-btn>
              <v-btn
                v-else-if="!(abierto.indexOf(a.key) == -1) && a.lvl < 6"
                text
                icon
                dark
                color="primary"
                @click="abierto = abierto.filter((d) => !d.startsWith(a.key))"
              >
                <v-icon>mdi-minus</v-icon>
              </v-btn>
            </td>
            <td v-if="a.lvl <= 3 && formGasto.formato[a.lvl] !== 'id_clasificador'" :colspan="7 - a.lvl">
              <strong>{{ a.key.split('-')[a.lvl] }}</strong>
              {{
                ' ' +
                showNameLvl({
                  data: a.key.split('-')[a.lvl],
                  caso: formGasto.formato[a.lvl],
                  componente: a.componente,
                })
              }}
            </td>
            <td v-else-if="formGasto.formato[a.lvl] === 'id_clasificador'" :colspan="7 - a.lvl">
              <strong>{{ showNameLvl3(a.key.split('-')[a.lvl]) }}</strong>
              {{
                ' ' +
                showNameLvl({
                  data: a.key.split('-')[a.lvl],
                  caso: formGasto.formato[a.lvl],
                })
              }}
            </td>
            <td v-else-if="a.lvl === 4" :colspan="12 - a.lvl">
              <strong>Certificado:</strong> {{ a.key.split('-')[a.lvl] }}<br />
              <strong>Monto:</strong> {{ formatDecimal(a.monto_cert) }}<br />
              <strong>Dispositivo Legal:</strong> {{ a.dispositivo }}<br />
              <strong>Concepto:</strong> {{ a.concepto }}
            </td>
            <td v-else-if="a.lvl === 5" :colspan="15 - a.lvl">
              <strong>Compromiso:</strong> {{ a.contrato }}<br />
              <strong>Monto:</strong> {{ formatDecimal(a.monto_comp) }}<br />
              <strong>Concepto:</strong> {{ a.concepto }}
            </td>
            <td v-else-if="a.lvl === 6" :colspan="18 - a.lvl">
              <strong>Expediente SIAF:</strong>{{ a.expediente }} <strong>Fecha:</strong> {{ a.fecha }}
              <strong>Monto:</strong> {{ formatDecimal(a.monto_dev) }}<br />
              <strong>Proveedor:</strong> {{ a.proveedor }}<br />
              <strong>Cp's:</strong> {{ a.cps }}<br />
              <strong>Concepto:</strong> {{ a.nota_c }}<br />
              <a v-if="showNota.indexOf(a.key) == -1" class="s_more" data-status="0" @click="showNota.push(a.key)"
                >Ver nota completa...</a
              >
              <a v-else class="s_more" data-status="0" @click="showNota = showNota.filter((d) => !d.startsWith(a.key))"
                >Ocultar notas...</a
              >
              <div v-show="!(showNota.indexOf(a.key) == -1)" class="hidden">
                <br />
                <strong>Notas del Devengado -</strong>{{ a.nota_d }}<br /><br />
                <strong>Notas del Girado -</strong>{{ a.nota_g }}
              </div>
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.monto_pim) }}
            </td>
            <td v-if="a.lvl < 4"></td>
            <td v-if="a.lvl < 4" class="text-right border-left">
              {{ formatDecimal(a.monto_cert) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ (denominador - a.monto_cert).toFixed(2) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ ((a.monto_cert / denominador) * 100).toFixed(2) + '%' }}
            </td>
            <td v-if="a.lvl < 5" class="text-right border-left">
              {{ formatDecimal(a.monto_comp) }}
            </td>
            <td v-if="a.lvl < 5" class="text-right">
              {{ (denominador - a.monto_comp).toFixed(2) }}
            </td>
            <td v-if="a.lvl < 5" class="text-right">
              {{ ((a.monto_comp / denominador) * 100).toFixed(2) + '%' }}
            </td>
            <td v-if="a.lvl < 6" class="text-right border-left">
              {{ formatDecimal(a.monto_dev) }}
            </td>
            <td v-if="a.lvl < 6" class="text-right">
              {{ (denominador - a.monto_dev).toFixed(2) }}
            </td>
            <td v-if="a.lvl < 6" class="text-right">
              {{ ((a.monto_dev / denominador) * 100).toFixed(2) + '%' }}
            </td>
            <td v-if="a.lvl < 4" class="text-right border-left">
              {{ formatDecimal(a.g_1) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_2) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_3) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_4) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_5) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_6) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_7) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_8) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_9) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_10) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_11) }}
            </td>
            <td v-if="a.lvl < 4" class="text-right">
              {{ formatDecimal(a.g_12) }}
            </td>
            <td v-if="a.lvl >= 4" :colspan="12" class="border-left"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import Vuex from 'vuex'
import Proyectos from '@/js/api/proyectos/proyectos'

export default {
  props: {
    // Comprobación de tipo básico (`null` coincide con cualquier tipo)

    formGasto: {
      type: Object, // Los valores predeterminados del objeto o matriz deben devolverse desde
      // una función de fábrica
      default: () => {
        return {
          formato: ['ano_eje', 'fuente_financ', 'sec_func', 'id_clasificador', 'cert', 'compromiso', 'expediente'],
          anio: curryear,
          user_id: null,
          sec_func: null,
        }
      },
    },
  },

  data() {
    return {
      formato: [
        {
          value: ['ano_eje', 'fuente_financ', 'sec_func', 'id_clasificador', 'cert', 'compromiso', 'expediente'],
          text: 'año > Fto > sec_func > especifica',
        },
        {
          value: ['ano_eje', 'sec_func', 'fuente_financ', 'id_clasificador', 'cert', 'compromiso', 'expediente'],
          text: 'año > sec_func > Fto > especifica',
        },
        {
          value: ['ano_eje', 'sec_func', 'id_clasificador', 'fuente_financ', 'cert', 'compromiso', 'expediente'],
          text: 'año > sec_func > especifica > Fto',
        },
      ],

      abierto: [curryear.toString() + '-'],
      loaded: [],
      showNota: [],
      tableDrag: {
        tableStyle: {
          cursor: '-webkit-grab',
        },
        clicked: false,
        xPosition: null,
      },
    }
  },

  computed: {
    ...Vuex.mapGetters(['getAniosReporte', 'getProyectoGastos2', 'formatDecimal', 'showNameLvl', 'showNameLvl3', 'mostrarProyectoSelected']),
  },

  mounted: function () {
    this.newGastosCalculado()
    this.establecerFormGastos(JSON.parse(JSON.stringify(this.formGasto)))
    this.getProyectoGastos()
  },

  methods: {
    ...Vuex.mapActions([
      'getProyectoGastos',
      'getComponente',
      'getProyectoGastosCertificado',
      'establecerFormGastos',
      'newGastosCalculado',
    ]),

    mousemove(e) {
      if (this.tableDrag.clicked) {
        let table = document.querySelector('.table-scroll')
        let max_scroll = table.scrollWidth - table.clientWidth
        let sLeft = table.scrollLeft + this.tableDrag.xPosition - e.pageX
        sLeft = sLeft < 0 ? 0 : sLeft > max_scroll ? max_scroll : sLeft
        table.scrollLeft = sLeft
        this.tableDrag.xPosition = e.pageX
      }
    },
    addGastos(key, lvl) {
      let keys = key.split('-')
      const params = {
        ano_eje: keys[this.formGasto.formato.findIndex((d) => d === 'ano_eje')],
        fuente_financ: keys[this.formGasto.formato.findIndex((d) => d === 'fuente_financ')],
        sec_func: keys[this.formGasto.formato.findIndex((d) => d === 'sec_func')],
        id_clasificador: keys[this.formGasto.formato.findIndex((d) => d === 'id_clasificador')],
        cert: keys[this.formGasto.formato.findIndex((d) => d === 'cert')],
        secuencia_c: keys[this.formGasto.formato.findIndex((d) => d === 'compromiso')],
        lvl: lvl,
      }
      this.getProyectoGastosCertificado(params)
      this.loaded.push(key)
    },
    forceFileDownload(response,  title) {
      const url = window.URL.createObjectURL(new Blob([response.data]))
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', title) //or any other extension
      document.body.appendChild(link)
      link.click()
    },
    excel() {
      Proyectos.excel(this.$route.params.idproyecto, 'excel').then((response) => {
        this.forceFileDownload(response, this.mostrarProyectoSelected.proy_cod_siaf+' - '+this.mostrarProyectoSelected.proy_nombre+' gastos.xlsx')
      })
    },
    excelAll() {
      Proyectos.excel(this.$route.params.idproyecto, 'excelall').then((response) => {
        this.forceFileDownload(response, this.mostrarProyectoSelected.proy_cod_siaf+' - all - '+this.mostrarProyectoSelected.proy_nombre+' gastos.xlsx')
      })
    },
  },
}
</script>

<style scoped>
.table-scroll {
  overflow-x: auto;
  padding-bottom: 50px;
}

.border-left {
  border-left: 2px solid rgb(0, 0, 0);
}

td {
  padding: 0px 5px;
}
</style>
