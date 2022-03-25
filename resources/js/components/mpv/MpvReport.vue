<template>
  <div>
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading">REPORTE MESA DE PARTES VIRTUAL</div>
        <div class="panel-body">
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-3">
              <div class="input-group date">
                <label>Fecha Desde:</label>
                <input v-model="filtro.fecha_desde" type="date" class="form-control" @change="putHasta" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="input-group date">
                <label>Fecha Hasta:</label>
                <input v-model="filtro.fecha_hasta" type="date" class="form-control" />
              </div>
            </div>
            <div class="col-sm-2">
              <label>Estado registro</label>
              <select v-model="filtro.docu_estado" class="form-control">
                <option :value="null">Todos</option>
                <option value="0">Registrados</option>
                <option value="1">Observados</option>
                <option value="2">Derivados</option>
                <option value="3">Subsanados</option>
              </select>
            </div>
            
            <div class="col-sm-4">
              <br />
              <div class="btn-group" role="group" aria-label="Basic example">
                <p>
                  <button type="submit" class="btn btn-success" :disabled="getting" @click="exportarPdf(1)">Exportar recibidos PDF</button>
                  <button type="submit" class="btn btn-warning" :disabled="getting" @click="exportarPdf(2)">Exportar atendidos PDF</button>
                </p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
  import Mpv from '@/js/store/models/mpv'
  export default {
    name: 'MpvReport',
    props: {
      titulo:{
        type: String,
        default: ''
      },
      dependencia:{
        type: String,
        default: ''
      }
    },

    data(){
      return {
        filtro:{
          fecha_desde: null,
          fecha_hasta: null,
          docu_estado: null,
          tipo: null
        },
        getting: false
      }
    },

    mounted () {
      let date = new Date() // Or the date you'd like converted.
      let isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
      this.filtro.fecha_hasta = isoDate.slice(0, 10)
      this.filtro.fecha_desde = isoDate.slice(0, 10)
    },

    methods:{
      putHasta() {
        this.filtro.fecha_hasta = this.filtro.fecha_desde
      },
      exportarPdf(tipo){
        if (!this.getting) {
          this.getting = true
          this.filtro.tipo = tipo
          Mpv.registrosOfPdf({ params: this.filtro }).then( response => {
            if (response.data.length > 0) {
              let pdfName = 'Reporte1'
              let config = {
                orientation: 'l',
                unit: 'mm',
                format: 'a4',
                setFont: 'helvetica',
                setFontType: 'bold'
              }
              let configTable = {
                columns: null,
                columnStyles: {},
                bodyStyles: { fontSize: 7, textColor: 0, lineColor: 0 },
                headStyles: { fontSize: 7, textColor: 0, lineColor: 0, fillColor: 200, lineWidth: 0.12 },
                theme: 'grid',
                margin: { top: 25 },
                rowPageBreak: 'avoid',
                body: response.data,
              }
              let factor = 1.64
              let header = []
              let total = ''
              configTable.columns = [
                { header: "Registro /\nExpe.", dataKey: 'id' },
                { header: 'Fecha', dataKey: 'docu_fecha_doc' },
                { header: 'Documento', dataKey: 'docu_numero_doc' },
                { header: 'Firmante', dataKey: 'datos_remitente' },
                { header: 'Asunto', dataKey: 'docu_asunto' },
                { header: 'Estado', dataKey: 'docu_estado' },
                { header: 'Situación', dataKey: 'docu_situacion' },
              ]

              header = [
                { text: 'REGISTROS'+ (tipo === 1?' RECIBIDOS ':' ATENDIDOS ')+'POR MPV DE LA DEPENDENCIA: '+ this.dependencia, x: 60, y: 15 },
                {
                  text: 'Desde: ' + this.filtro.fecha_desde + '  Hasta: ' + this.filtro.fecha_hasta,
                  x: 100,
                  y: 20
                }
              ]
              configTable.columnStyles={
                id              : {cellPadding: 2, haling: "right", valign: "middle", cellWidth:15},
                docu_fecha_doc  : {cellPadding: 2, haling: "right", valign: "middle", cellWidth:20},
                docu_numero_doc : {cellPadding: 2, haling: "right", valign: "middle", cellWidth:40},
                datos_remitente : {cellPadding: 2, haling: "right", valign: "middle", cellWidth:50},
                docu_asunto     : {cellPadding: 2, haling: "right", valign: "middle", cellWidth:80},
                docu_estado     : {cellPadding: 2, haling: "right", valign: "middle", cellWidth:20},
                docu_situacion  : {cellPadding: 2, haling: "right", valign: "middle", cellWidth:50}
              }
              total = response.data.length
              let doc = new jsPDF(config)
              doc.setFontSize(10)
              doc.autoTable(configTable)
              //pagination
              let pageCount = doc.internal.getNumberOfPages()
              for (let i = 0; i < pageCount; i++) {
                doc.setPage(i)
                doc.text(doc.internal.getCurrentPageInfo().pageNumber + '/' + pageCount, 10, 10)
                doc.text(this.titulo, 23, 10)
                for (let j = 0; j < header.length; j++) {
                  doc.text(header[j].text, header[j].x, header[j].y)
                }
              }
              doc.setPage(pageCount)
              if (config.orientation === 'l') {
                doc.text('Total: ' + total.toString(), 10, 200)
              } else {
                doc.text('Total: ' + total.toString(), 10, 288)
              }

              window.open(doc.output('bloburl', { filename: pdfName + '.pdf' }), '_blank')
            }
            this.getting = false
            this.filtro.tipo = null
          })
        }
      }
    }
  }
</script>

<style scoped>

</style>
