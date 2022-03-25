<template>
  <div class="document-editor">
    <div ref="toolbar" class="document-editor__toolbar"></div>
    <div class="document-editor__editable-container">
      <div class="document-editor__editable">
        <ckeditor
          :value="value"
          :editor="editor"
          :config="editorConfig"
          @ready="onReady"
          @input="$emit('input', $event)"
        />
      </div>
    </div>
  </div>
</template>

<script>
  //import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
  import CKEditor   from '@ckeditor/ckeditor5-vue'
  import FullEditor from '../../ckeditor5-build'
  //import '@ckeditor/ckeditor5-build-decoupled-document/build/translations/es'

  export default {
    name      : 'CKEditorDocument',
    components: {
      ckeditor: CKEditor.component
    },
    props     : ['value'],
    data() {
      return {
        editor      : FullEditor,
        editorConfig: {
          language: 'es'
        }
      }
    },
    watch     : {},
    mounted() {
    },
    methods   : {
      onReady(editor) {
        // Insert the toolbar before the editable area.
        /*let f = editor.ui
        .getEditableElement()
        .parentElement.insertBefore(editor.ui.view.toolbar.element, editor.ui.getEditableElement())*/
        this.$refs.toolbar.appendChild(editor.ui.view.toolbar.element)
      }
    }
  }
</script>

<style scoped>

</style>
