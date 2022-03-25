const mix                   = require('laravel-mix')
const CKEditorWebpackPlugin = require('@ckeditor/ckeditor5-dev-webpack-plugin')
const {styles}              = require('@ckeditor/ckeditor5-dev-utils')
const CKERegex              = {
  svg: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,
  css: /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css/,
  js : /ckeditor5-[^/\\]+[/\\]build[/\\].+\.js$/,
}
Mix.listen('configReady', webpackConfig => {
  const rules      = webpackConfig.module.rules
  const targetSVG  = /(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/
  const targetFont = /(\.(woff2?|ttf|eot|otf)$|font.*\.svg$)/
  const targetCSS  = /\.css$/
  const targerJS   = /\.jsx?$/
  // exclude CKE regex from mix's default rules
  for (let rule of rules) {
    if (rule.test.toString() === targetSVG.toString()) {
      rule.exclude = CKERegex.svg
    } else {
      if (rule.test.toString() === targetFont.toString()) {
        rule.exclude = CKERegex.svg
      } else {
        if (rule.test.toString() === targetCSS.toString()) {
          rule.exclude = CKERegex.css
        } else {
          if (rule.test.toString() === targerJS.toString()) {
            rule.exclude = /(node_modules|bower_components|ckeditor5-[^/\\]+[/\\]build[/\\].+\.js$)/
          }
        }
      }
    }
  }
})

let config = {
  resolve: {
    extensions: ['.js', '.vue'],
    alias     : {
      '@': __dirname + '/resources'
    }
  },
  plugins: [
    new CKEditorWebpackPlugin({
                                language: 'en',
                              }),],
  module : {
    rules: [ {
        test: CKERegex.svg,
        use : ['raw-loader'],
      }, {
        test: CKERegex.css,
        use : [
          {
            loader : 'style-loader',
            options: {
              injectType: 'singletonStyleTag',
              attributes: {
                'data-cke': true
              }
            },
          }, {
            loader : 'postcss-loader',
            options: styles.getPostCssConfig({
                                               themeImporter: {
                                                 themePath: require.resolve('@ckeditor/ckeditor5-theme-lark'),
                                               },
                                               minify       : true,
                                             }),
          },],
      },],
  },
}
mix.webpackConfig(config)

mix.options({
              processCssUrls: false
            })
mix
.sass('resources/sass/proyectos.scss', 'public/css')
.stylus('resources/stylus/app.styl', 'public/css/stylus.css', {
  use: [require('nib')()]
})
.styles(['public/css/proyectos.css', 'public/css/stylus.css'], 'public/css/styles.css')

mix
.sass('resources/sass/app.scss', 'public/css')
.sass('resources/sass/gastos.scss', 'public/css')
.js('resources/js/tramite/navbar.js', 'public/js')
.js('resources/js/tramite/expediente.js', 'public/js')
.js('resources/js/tramite/inicio/inicio.js', 'public/js')
.js('resources/js/tramite/documentos/enproceso.js', 'public/js')
.js('resources/js/tramite/documentos/editor.js', 'public/js')
.js('resources/js/tramite/documentos/makePlantilla.js', 'public/js')
.js('resources/js/tramite/documentos/porrecibir.js', 'public/js')
.js('resources/js/tramite/documentos/archivados.js', 'public/js')
.js('resources/js/tramite/reportes/reporte.js', 'public/js')
.js('resources/js/tramite/administracion/entidad.js', 'public/js')
.js('resources/js/tramite/administracion/unidad.js', 'public/js')
.js('resources/js/tramite/administracion/usuarios.js', 'public/js')
.js('resources/js/tramite/administracion/correlativos.js', 'public/js')
.js('resources/js/tramite/administracion/dependencias.js', 'public/js')
.js('resources/js/tramite/catalogo/archivadores.js', 'public/js')
.js('resources/js/tramite/catalogo/tipoDocumento.js', 'public/js')
.js('resources/js/tramite/catalogo/prioridades.js', 'public/js')
.js('resources/js/tramite/buscar/buscar.js', 'public/js')
  .js('resources/js/tramite/assistances/assistances.js', 'public/js')
.js('resources/js/tramite/administrador.js', 'public/js')
.js('resources/js/tramite/administrador/admin.js', 'public/js')
.js('resources/js/tramite/administrador/logeo.js', 'public/js')
.js('resources/js/tramite/tramite-varios/recepcion.js', 'public/js')
.js('resources/js/tramite/tramite-varios/papeleta.js', 'public/js')
.js('resources/js/tramite/tramite-varios/supervisarPapeleta.js', 'public/js')
.js('resources/js/proyectos/contratos/contratos.js', 'public/js')
.js('resources/js/proyectos/actividades/actividades.js', 'public/js')
.js('resources/js/proyectos/informes/informes.js', 'public/js')
.js('resources/js/proyectos.js', 'public/js')
.extract(['vue', 'vuex', 'vue-router', 'chart.js', 'vue-chartjs'])
.version()
.sourceMaps()
