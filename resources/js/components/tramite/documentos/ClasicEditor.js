/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

// The editor creator to use.
import ClassicEditorBase from "@ckeditor/ckeditor5-editor-classic/src/classiceditor";

import EssentialsPlugin    from '@ckeditor/ckeditor5-essentials/src/essentials'

export default class ClassicEditor extends ClassicEditorBase {}

// Plugins to include in the build.
ClassicEditor.builtinPlugins = [
  EssentialsPlugin,
];

// Editor configuration.
ClassicEditor.defaultConfig = {
  toolbar: {
    items: [
      "removeFormat",
      "|",
      "heading",
      "|",
      "fontSize",
      "fontFamily",
      "fontColor",
      "fontBackgroundColor",
      "|",
      "bold",
      "italic",
      "underline",
      "strikethrough",
      "code",
      "subscript",
      "superscript",
      "|",
      "bulletedList",
      "numberedList",
      "|",
      "alignment",
      "indent",
      "outdent",
      "|",
      "link",
      "insertTable",
      "specialCharacters",
      "imageUpload",
      "mediaEmbed",
      "|",
      "highlight",
      "blockQuote",
      "horizontalLine",
      "pageBreak",
      "|",
      "restrictedEditingException",
      "|",
      "undo",
      "redo"
    ]
  },
  blockToolbar: [
    "heading",
    "fontSize",
    "fontColor",
    "fontBackgroundColor",
    "alignment",
    "|",
    "bulletedList",
    "numberedList",
    "|",
    "blockQuote",
    "imageUpload"
  ],
  fontSize: {
    options: [8, 9, 10, 11, 12, 14, 16, 18, 20, 22, 24, 26, 28]
  },
  image: {
    toolbar: [
      "imageStyle:alignLeft",
      "imageStyle:full",
      "imageStyle:alignRight",
      "|",
      "imageTextAlternative"
    ],
    styles: ["full", "side", "alignLeft", "alignCenter", "alignRight"]
  },
  table: {
    contentToolbar: [
      "tableColumn",
      "tableRow",
      "mergeTableCells",
      "tableProperties",
      "tableCellProperties"
    ]
  },
  // This value must be kept in sync with the language defined in webpack.config.js.
  language: "en"
};