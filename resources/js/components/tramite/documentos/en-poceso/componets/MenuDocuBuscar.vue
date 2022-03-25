<template>
  <div class="row form-group" style="width: 100%;margin-left: -0px;">
    <div class="col-sm-12">
      <div class="btn-group" role="group" aria-label="Basic example">
        <p>
          <button
            class="btn btn-sm btn-outline-primary"
            :disabled="
              !(
                docIndexes.length === 1 &&
                (userId == documentos.data[docIndexes[0]].docu_idusuario ||
                  (2 === parseInt(documentos.data[docIndexes[0]].docu_origen) &&
                    parseInt(documentos.data[docIndexes[0]].depe_origen) === getMiDependencia &&
                    1 === documentos.data[docIndexes[0]].depe_recibetramite))
              )
            "
            @click="$emit('editar')"
          >
            <span class="glyphicon glyphicon-pencil"></span> Editar
          </button>
          <button
            class="btn btn-sm btn-outline-primary"
            :disabled="!(docIndexes.length > 0)"
            @click="$emit('mostrar', 'derivar')"
          >
            Derivar
          </button>
          <button
            class="btn btn-sm btn-outline-primary"
            :disabled="!(docIndexes.length > 0)"
            @click="$emit('mostrar', 'archivar')"
          >
            Archivar
          </button>
          <button
            class="btn btn-sm btn-danger"
            :disabled="!(docIndexes.length > 0)"
            @click="$emit('eliminarDerivacion')"
          >
            Eliminar derivación
          </button>
          <button
            class="btn btn-sm btn-outline-primary"
            :disabled="!(docIndexes.length > 0)"
            @click="$emit('mostrar', 'adjuntar')"
          >
            Adjuntar
          </button>
          <button
            v-if="
              docIndexes.length === 1 &&
                2 == documentos.data[docIndexes[0]].adm_estado &&
                2 == documentos.data[docIndexes[0]].oper_idtope
            "
            class="btn btn-sm btn-warning"
            @click="$emit('mostrar', 'liberar')"
          >
            Liberar Doc.
          </button>
          <button
            v-if="
              docIndexes.length === 1 &&
                1 == documentos.data[docIndexes[0]].oper_idtope &&
                userId == documentos.data[docIndexes[0]].oper_idusuario
            "
            class="btn btn-sm btn-success"
            @click="$emit('mostrar', 'observacion')"
          >
            Observación
          </button>
          <button
            :disabled="!(docIndexes.length > 0)"
            class="btn btn-sm btn-info"
            @click="$emit('responder')"
          >
            Responder
          </button>
          <button
            v-if=" canInteroperabilidad && docIndexes.length === 1 && (1 === parseInt(documentos.data[docIndexes[0]].docu_idtipodocumento) || 5 === parseInt(documentos.data[docIndexes[0]].docu_idtipodocumento)) && documentos.data[docIndexes[0]].docu_archivo.length > 0"
            class="btn btn-sm btn-info"
            @click="$emit('mostrar', 'enviar')"
          >
            Enviar
          </button>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import Vuex                from 'vuex'
export default {
  name : "MenuDocuBuscar",
  props: {
    userId              : {
      type   : String,
      default: ''
    },
    canInteroperabilidad: {
      type   : Boolean,
      default: false
    },
    docIndexes          : {
      type   : Array,
      default: function () {
        return []
      }
    },
    documentos          : {
      type   : Object,
      default: function () {
        return {
          current_page : null,
          data         : [],
          from         : null,
          last_page    : null,
          next_page_url: null,
          path         : null,
          per_page     : null,
          prev_page_url: null,
          to           : null,
          total        : null
        }
      }
    },
  },
  computed: {
    ...Vuex.mapGetters(['getMiDependencia',])
  },
}
</script>

<style scoped>

</style>
