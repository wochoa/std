<template>
  <div>
    <CKEditorDocument v-model="editorData" />
    <div class="modal-footer" style="background-color: white">
      <button type="button" class="btn btn-primary" :disabled="saving" @click="save">
        <span v-if="!saving" class="glyphicon glyphicon-floppy-saved"> Guardar</span>
        <span v-else class="glyphicon glyphicon-send"> Guardando</span>
      </button>
      <button type="button" class="btn btn-default" :disabled="saving" @click="close">Cerrar</button>
    </div>
  </div>
</template>

<script>

  import CKEditorDocument from '../CKEditorDocument'

  export default {
    name         : 'Test',
    components   : {
      CKEditorDocument
    },
    props        : {},
    data() {
      return {
        editorData  : '',
        editorConfig: {

          heading: {
            options: [
              { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
              { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
              { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
            ]
          }
        },
        saving      : false
      }
    },
    mounted      : function () {
      document.addEventListener('resetSaving', this.resetSaving, {passive: true})
      document.addEventListener('putHTML', this.putHTML, {passive: true})
    },
    beforeDestroy: function () {
      document.removeEventListener('resetSaving', this.resetSaving)
      document.removeEventListener('putHTML', this.putHTML)
      //
    },
    methods      : {
      save() {
        let event = new CustomEvent('saveIframe', {detail: this.editorData})
        window.parent.document.dispatchEvent(event)
      },
      close(){
        let event = new CustomEvent('closeIframe', {detail: this.editorData})
        window.parent.document.dispatchEvent(event)
      },
      resetSaving(){
        this.saving = false
      },
      putHTML(e){
        this.editorData=e.detail
      }
    }
  }
</script>

<style scoped>

</style>
