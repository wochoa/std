<template>
  <table
    id="tabla"
    class="table table-striped table-bordered table-condensed table-hover"
    style="overflow-x:scroll; margin: 0px;"
  >
    <tbody class="success">
      <tr v-for="(ref, index) in referencias" :key="index">
        <td colspan="2">
          <input
            v-model="referencias[index]"
            type="text"
            placeholder="Referencia"
            class="form-control"
          />
        </td>
        <td width="35px">
          <button
            title="Eliminar"
            @click="referencias.splice(index, 1)"
          >
            <span class="glyphicon glyphicon-trash"></span>
          </button>
        </td>
      </tr>
      <tr>
        <td width="185px">
          <input
            v-model="regDocumento"
            type="text"
            placeholder="Buscar Reg. documento"
            class="form-control"
          /></td>
        <td colspan="2" class="text-center" @click="addReferencia">
          <span class="glyphicon glyphicon-plus"></span>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
  import {Documento} from "@/js/store/models/documento"

  export default {
    name   : "DocuGeenradoReferencias",
    props  : {
      referencias: {
        type   : Array,
        default: () => []
      },
      viewer     : {
        type   : Boolean,
        default: false
      },
    },
    data() {
      return {
        regDocumento: null
      }
    },
    methods: {
      addReferencia() {
        if (this.regDocumento === null) {
          this.referencias.push('')
        } else {
          Documento.buscarDocumento({iddocumento:this.regDocumento,only_document:true}).then(response=>{
            if(response.data!=='') {
              let documento     = response.data
              let numero        = documento.tdoc_descripcion + ' ' + ('000000' + documento.docu_numero_doc).slice(-6)
              numero += documento.docu_origen == 1 ? '-' + documento.docu_fecha_doc.substr(0, 4) : ''
              numero += documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : ''
              this.regDocumento = null
              this.referencias.push(numero)
            }else{
              alert('documento de referencia no encontrado')
            }
          })
        }
      }
    }
  }
</script>

<style scoped>

</style>
