<template>
  <div class="panel panel-primary">
    <div class="panel-heading">Relación de documentos que bloquean</div>
    <div class="panel-body">
      <div class="row form-group" style="width: 100%;margin-left: -0px;">
        <div v-if="docBloqueados.tipo == 1" class="col-sm-8">
          <div class="alert alert-danger" role="alert">
            <strong>Alerta!</strong> tiene documentos en proceso que bloquea generar un nuevo documento
          </div>
        </div>
        <div v-if="docBloqueados.tipo == 2" class="col-sm-8">
          <div class="alert alert-danger" role="alert">
            <strong>Alerta!</strong> tiene documentos por recibir que bloquea generar un nuevo documento
          </div>
        </div>
      </div>
      <div class="box">
        <div class="box-body">
          <table class="table table-bordered table-condensed table-hover">
            <thead>
              <tr class="info">
                <th style="width:5%">Registro</th>
                <th style="width:7%">Fecha</th>
                <th style="width:20%">Documento</th>
                <th style="width:12%">Remitente</th>
                <th style="width:15%">Oficina destino</th>
                <th style="width:10%">Usuario destino</th>
                <th style="width:3%">Dias</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(documento, index) in docBloqueados.data" :key="index">
                <td>
                  {{ documento.oper_iddocumento }}<br />
                  {{ documento.docu_idexma }}
                </td>
                <td>{{ documento.created_at }}</td>
                <td>{{ documento.tdoc_descripcion }}</td>
                <td>{{ documento.remite }}</td>
                <td>{{ documento.oficina_destino }}</td>
                <td>{{ documento.usuario_destino }}</td>
                <td>{{ documento.dias }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {  

  props: {
          docBloqueados:{ 
              type: Object,
              default: () => ({})
            }
        },
  
  data() {
    return {}
  },

  mounted() {},

  methods: {}
}
</script>
<style scoped>
.table tbody tr td,
.table thead tr {
  font-size: 11px;
}
</style>
