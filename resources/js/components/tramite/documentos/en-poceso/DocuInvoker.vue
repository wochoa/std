<template>
  <div>
    <div class="invokerJWS">
      <iframe
        id="frameInvokerJWS"
        style="height:0%;width:0%; border:none;display: none;"
        :src="srcFrameInvokerJWS"
      ></iframe>
    </div>
    <div class="container infoEntity">
      <div class="col-md-12">
        <h5>
          <span v-if="entityDataName != null">
            <div class="animated fadeIn"><i class="glyphicon glyphicon-pushpin"></i>{{ entityDataName }}</div>
          </span>
        </h5>
        <span id="entity_data_app"></span>
      </div>
    </div>
    <!-- Modal -->
    <div class="row">
      <div class="col-sm-12">
        <div
          id="mdlInvoker"
          aria-hidden="true"
          aria-labelledby="myModalLabel"
          role="dialog"
          tabindex="-1"
          class="modal fade"
        >
          <div id="estadoFirma" class="modal-dialog" style="max-width:350px !important; display: none">
            <div class="modal-content">
              <div class="modal-header">
                <div class="modal-title">
                  <i class="glyphicon glyphicon-menu-right"></i>&#160;&#160; ReFirma Invoker
                </div>
              </div>
              <div class="modal-body">
                <div class="row" style="display: inherit;">
                  <div class="col-sm-12 text-center">
                    <br />
                    <img :src="img" style="border:0; margin-bottom:8px;" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 text-center">
                    <br />
                    <div id="status">{{ text }}</div>
                    <br />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="configFirma" class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <div class="modal-title"><i class="glyphicon glyphicon-menu-right"></i>&#160;&#160; Firma</div>
              </div>
              <div class="modal-body">
                <div class="row text-center">
                  <div class="doc_preview text-center" @drop="drop($event)">
                    <div class="cabecera">Cabecera</div>
                    <div class="pie-de-pagina">Pie de pagina</div>
                    <div
                      v-dragged="onDragged"
                      class="firma_preview dragzones"
                      style="margin: 50px 0px 0px 50px;"
                      onselectstart="return false;"
                    >
                      <br />Firma
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label style="color: white">Motivo de la firma</label>
                  <select v-model="motivo" class="form-control">
                    <option value="0">Soy el autor del documento</option>
                    <option value="1">En señal de conformidad</option>
                    <option value="2">Doy V° B°</option>
                    <option value="3">Por encargo</option>
                    <option value="4">Doy fé</option>
                  </select>
                </div>
              </div>
              <div data-v-20479306="" class="modal-footer">
                <button type="button" class="btn btn-success" @click="continuar">Continuar</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  var hash = window.location.hash
  export default {

    name: 'DocuInvoker',

    props: {
      routeInvokerGet : {
        type   : String,
        default: ''
      },
      routeInvokerPost: {
        type   : String,
        default: ''
      }
    },

    data() {
      return {
        frameInvoker      : null,
        imgs              : {
          s_load    : '/img/refirma/s_load.gif',
          s_download: '/img/refirma/s_download.gif',
          s_key     : '/img/refirma/s_key.gif',
          s_upload  : '/img/refirma/s_upload.gif',
          s_ok      : '/img/refirma/s_ok.png',
          s_cancel  : '/img/refirma/s_cancel.png'
        },
        img               : null,
        text              : 'Cargando el componente...',
        idWsComponent     : null,
        srcFrameInvokerJWS: null,
        entityDataName    : null,
        entityDataApp     : null,
        app               : 'jnlps://dsp.reniec.gob.pe/refirma_invoker/servlet',
        wss               : 'wss://dsp.reniec.gob.pe/refirma_invoker_wss/websocket',
        type              : null,
        webSocket         : null,
        documentName_     : null,
        argumentos        : null,
        split             : '-@@-',
        result            : null,
        idDocumento       : null,
        idFile            : null,
        configDiv         : {
          maxL: 295,
          minL: 3,
          maxT: 489,
          minT: 50
        },
        maxX              : 420,
        maxY              : 760,
        relacion          : 1.4237,
        X                 : 75,
        Y                 : 70,
        motivo            : 0
      }
    },

    mounted: function () {
      this.img = this.imgs.s_load
    },
    methods: {
      onDragged({el, deltaX, deltaY, offsetX, offsetY, clientX, clientY, first, last}) {
        if (first) {
          this.isDragging = true
          return
        }
        if (last) {
          this.isDragging = false
          return
        }
        var l               = +window.getComputedStyle(el)['margin-left'].slice(0, -2) || 0
        var t               = +window.getComputedStyle(el)['margin-top'].slice(0, -2) || 0
        var newL            = l + deltaX
        var newT            = t + deltaY
        newL                = newL > this.configDiv.minL ? (newL > this.configDiv.maxL ? this.configDiv.maxL : newL) : this.configDiv.minL
        newT                = newT > this.configDiv.minT ? (newT > this.configDiv.maxT ? this.configDiv.maxT : newT) : this.configDiv.minT
        this.X              = Math.round(newL * this.relacion)
        this.Y              = Math.round(newT * this.relacion)
        el.style.marginLeft = newL + 'px'
        el.style.marginTop  = newT + 'px'
      },
      drop(e) {
        console.log(e)
      },
      initInvoker: function (opt, documento = null) {
        var status           = document.querySelector('#estadoFirma')
        var config           = document.querySelector('#configFirma')
        status.style.display = 'none'
        config.style.display = ''
        this.img             = this.imgs.s_load
        $('#mdlInvoker').modal({
                                 backdrop: 'static',
                                 keyboard: false
                               })
        this.idDocumento = documento.id_documento
        this.idFile      = documento.id
        this.type        = opt
        /*var route = "http://127.0.0.1:8000/tramite/documento/print/%s";
                  route=route.replace(/%s/g, documento.iddocumento)+'.pdf';
                  console.log(route);
                  var loadingTask = pdfjsLib.getDocument(route);
                  loadingTask.promise.then(function(pdf) {
                      console.log(pdf);
                      // you can now use *pdf* here
                  });*/
      },
      continuar() {
        var status           = document.querySelector('#estadoFirma')
        var config           = document.querySelector('#configFirma')
        status.style.display = ''
        config.style.display = 'none'
        this.openSocket()
      },
      printMessage(message) {
        $jq('#mdlInvoker').modal({
                                   backdrop: 'static',
                                   keyboard: false
                                 })
      },
      getArguments() {
        const parameter = {
          type       : this.type,
          iddocumento: this.idDocumento,
          idFile     : this.idFile,
          posx       : this.X,
          posy       : this.Y,
          motivo     : this.motivo
        }
        axios.get(this.routeInvokerPost, {params: parameter}).then(response => {
          this.argumentos = response.data
          console.log(this.idWsComponent + this.split + this.argumentos)
          this.webSocket.send(window.btoa(this.idWsComponent + this.split + this.argumentos))
          //dispatchEventClient('sendArguments', arg);
        })
      },
      openSocket() {
        var este = this
        if (this.webSocket !== null && this.webSocket.readyState !== WebSocket.CLOSED) {
          alert('WebSocket ya estÃ¡ abierto.')
          return
        }
        this.webSocket           = new WebSocket(this.wss)
        this.webSocket.onopen    = function (event) {
          if (event.data === undefined) {
            return
          }
          if (event.data === 'expired') {
            alert('La sesiÃ³n expirÃ³.')
            //$jq('#mdlInvoker').modal('hide');
          }
        }
        this.webSocket.onmessage = function (event) {
          este.result = event.data
          console.log(event)
          if (este.result.indexOf('IdInvokerWS') >= 0) {
            este.text               = 'Obteniendo documento a firmar...'
            este.idWsComponent      = este.result.replace('IdInvokerWS', '')
            este.srcFrameInvokerJWS = null
            este.getArguments()
            //postMessageToParent('getArguments');*************************************************************
            return
          }
          else {
            if (este.result.indexOf('entity_data_name') >= 0) {
              este.entityDataName = este.result.replace('entity_data_name', '')
              return
            }
            else {
              if (este.result.indexOf('entity_data_app') >= 0) {
                este.entityDataApp = este.result.replace('entity_data_app', '')
                return
              }
              else {
                if (este.result !== 'init' && este.result !== 'getDocument' && este.result !== 'sign' && este.result !== 'upload' && este.result !== 'ok' && este.result !== 'cancel' && este.result !== 'processOk' && este.result !== 'processCancel') {
                  este.srcFrameInvokerJWS = este.app + '?id=' + este.result
                  return
                }
              }
            }
          }
          if (este.result === 'init') {
            este.text = 'Obteniendo documento a firmar...'
            return
          }
          if (este.result === 'getDocument') {
            setTimeout(function () {
              este.img  = este.imgs.s_download
              este.text = 'Obteniendo documento a firmar...'
            }, 100)
            return
          }
          if (este.result === 'sign') {
            este.img  = este.imgs.s_key
            este.text = 'Firmando digitalmente el documento...'
            return
          }
          if (este.result === 'upload') {
            este.img  = este.imgs.s_upload
            este.text = 'Subiendo documento firmado...'
            return
          }
          if (este.result === 'ok') {
            este.img = este.imgs.s_ok
            este.$emit('firmado')
            este.text = 'Proceso de firma digital terminado.'
            return
          }
          if (este.result === 'cancel') {
            este.img  = este.imgs.s_cancel
            este.text = 'Proceso de firma digital cancelado.'
            return
          }
        }
        this.webSocket.onclose   = function (event) {
          setTimeout(function () {
            //console.log(este)
            $('#mdlInvoker').modal('hide')
            //$jq('#mdlInvoker').modal('hide');********************************************
            setTimeout(function () {
              //postMessageToParent('close');********************************************
              if (este.result === 'processOk') {
                //postMessageToParent('invokerOk');************************************
              }
              if (este.result === 'processCancel') {
                //postMessageToParent('invokerCancel');********************************
              }
            }, 300)
          }, 1000)
        }

        this.webSocket.onerror = function (event) {
          //alert(event.data);
        }
      }
    }
  }
</script>

<style scoped>
  .invokerMain {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 20000;
    overflow: hidden;
    background: transparent;
    display: none;
  }

  .invokerScreen {
    position: absolute;
    width: 100% !important;
    height: 100%;
    z-index: 10000;
  }

  iframe {
    height: 100%;
    width: 100%;
    border: none;
  }

  .modal-content {
    background-color: #222222;
    color: #999;
  }

  .modal-header {
    background-color: #1c1c1c;
    color: #888;
    border-bottom: 0px !important;
  }

  .modal-footer {
    background-color: #1c1c1c;
    color: #888;
    border-top: 0px !important;
  }

  .doc_preview {
    width: 420px;
    height: 594px;
    background: white;
    display: inline-block;
  }

  .pie-de-pagina {
    border: solid 1px black;
    width: 420px;
    height: 50px;
    position: absolute;
    top: 559px;
  }

  .cabecera {
    border: solid 1px black;
    width: 420px;
    height: 50px;
    position: absolute;
  }

  .firma_preview {
    border: solid 1px black;
    width: 121px;
    height: 56px;
    background-color: #ffd6d6;
  }
</style>
