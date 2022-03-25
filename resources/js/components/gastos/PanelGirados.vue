<template>
    <div>
      <proy-table
        width="100%"
        class="ListadoTabla estatico"
        :items="showGirados"
        tag="dev"
        :page-length="10"
      >
        <template slot="header">
          <tr>
            <th style="width: 20%">Especifica</th>
            <th style="width: 15%">Oficina</th>
            <th style="width: 35%">Concepto</th>
            <th style="width: 10%">Expediente</th>
            <th style="width: 10%">Monto</th>
            <th style="width: 10%">Fecha</th>
          </tr>
        </template>
        <template slot="body" slot-scope="row">
          <td style="width: 20%">{{ showEspecificaDescripcion(row.item.id_clasificador) }}</td>
          <td style="width: 15%">{{ showOficinaSecfunc({ ano_eje: row.item.ano_eje, sec_func: row.item.sec_func }) }}</td>
          <td style="width: 50%">{{ row.item.notas }}</td>
          <td style="width: 10%">{{ row.item.expediente }}</td>
          <td style="width: 10%">{{ 'S/. ' +formatDecimal(row.item.monto) }}</td>
          <td style="width: 10%">{{ row.item.fecha_autorizacion | moment('from', 'now')  }}</td>
        </template>
      </proy-table>
    </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import proyTable      from "@/js/components/proyectos/ProyTable"
  export default {
    name: 'PanelGirados',
    components:{
      proyTable
    },
    computed:{
      ...mapGetters(['showGirados',
        'showEspecificaDescripcion',
        'formatDecimal',
        'showOficinaSecfunc'])
    }
  }
</script>

<style scoped>

</style>
