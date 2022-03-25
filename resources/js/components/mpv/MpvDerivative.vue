<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">SOLICITUDES DE MESA DE PARTES VIRTUAL</div>
      <div class="panel-body">
        <form @submit.prevent="buscarRegistro">
          <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-4">
              <label></label>
              <input
                ref="registro"
                v-model="filtro.id"
                type="text"
                name="registro"
                placeholder="Nombre, DNI, RUC"
                class="form-control"
              />
            </div>
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
              <br />
              <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-search"></span> Buscar
              </button>
            </div>
          </div>
        </form>

        <div class="box">
          <div class="box-body">
            <pagination :data="documentos" :limit="3" @pagination-change-page="buscarRegistro" />
            <table class=" table table-bordered table-condensed table-hover ">
              <thead>
                <tr class="info">
                  <th style="width:7%">REGISTRO/EXPEDIENTE</th>
                  <th style="width:15%">FECHA</th>
                  <th style="width:40%">DOCUMENTO</th>
                  <th style="width:10%">REMITENTE</th>
                  <th style="width:10%">DESTINO</th>
                  <th style="width:10%">ARCHIVO</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td v-if="documentos.data.length === 0" colspan="21" class="text-center">
                    No hay documentos, pruebe cambiando los filtros
                  </td>
                </tr>
                <tr
                  v-for="(documento, index) in documentos.data"
                  :key="index"
                  :set="(dias = moment().diff(moment(documento.created_at), 'days'))"
                >
                  <td>
                    <span
                      :class="{
                        badge: true,
                        'badge-danger': dias > 20,
                        'badge-warning': dias > 10 && dias <= 20,
                        'badge-success': dias <= 10
                      }"
                    >{{ dias }} días</span><br />
                    <strong>Reg.</strong>
                    <a
                      href="#"
                      target="_blank"
                      @click.prevent="recargar(documento.iddocumento)"
                    >{{ ' ' + ('00000000' + documento.iddocumento).slice(-8) }}</a><br />
                    <strong>Exp.</strong>{{ documento.docu_idexma }}<br />
                    <span
                      :class="documento.docu_estado === 2? 'badge badge-info': 'badge badge-warning'"
                    >
                      {{ documento.docu_estado === 2?'Derivado':'' }}
                    </span>
                  </td>
                  <td class="registro">
                    <strong>Fecha:</strong>{{ documento.created_at }}<br />
                    <strong>Folios:</strong>{{ documento.docu_folios }}
                  </td>
                  <td class="documento">
                    <strong :class="$mq">Doc:</strong>
                    <div :class="$mq">
                      {{ documento.tipo_documento.tdoc_descripcion+' ' }}
                      {{ documento.docu_numero_doc != null?(' '+'000000' +documento.docu_numero_doc).slice(-6):'' }}
                      {{ '-'+documento.docu_fecha_doc.substr(0, 4)
                      }}{{ documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : '' }}
                    </div>
                    <strong :class="$mq">Entidad:</strong>
                    <div :class="$mq">{{ documento.docu_detalle }}</div>
                    <strong :class="$mq">Firma:</strong>
                    <div :class="$mq">{{ documento.docu_firma }}</div>
                    <strong :class="$mq">Cargo:</strong>
                    <div :class="$mq">{{ documento.docu_cargo }}<br /></div>
                    <strong :class="$mq">Asunto:</strong>
                    <div :class="$mq">{{ documento.docu_asunto }}</div>
                  </td>
                  <td>
                    <div>
                      <strong :class="$mq">DNI:</strong>{{ documento.docu_dni }}<br />
                    </div>
                    <div>
                      <strong :class="$mq">RUC:</strong>{{ documento.docu_ruc }}<br />
                    </div>
                    <div><strong :class="$mq">Celular:</strong>{{ documento.docu_telef }}</div>
                    <div><strong :class="$mq">eMail:</strong>{{ documento.docu_emailorigen }}</div>
                  </td>

                  <td>
                    <div v-if="documento.operacion.length>0">
                      <strong :class="$mq">Destino:</strong>{{ documento.operacion[0].dependencia_destino.depe_nombre }}<br />
                    </div>
                    <div v-if="documento.operacion.length>0&&documento.operacion[0].oper_usuid_d">
                      <strong :class="$mq">Para:</strong>{{ getUsuariosActivoNombre(documento.operacion[0].oper_usuid_d) }}<br />
                    </div>
                  </td>

                  <td>
                    <div v-if="documento.docu_archivo.length>0">
                      <table>
                        <tbody>
                          <tr
                            v-for="(archivo, indexArchivo) in documento.docu_archivo.filter(d => d.file_mostrar)"
                            :key="indexArchivo"
                          >
                            <td>
                              <button
                                type="button"
                                class="btn btn-xs btn-link doc-link"
                                @click.stop="imprimirDocumentoPdf({id:archivo.id, id_documento_externo:archivo.id_documento_externo, file_tipo: archivo.file_tipo, file_name: archivo.file_name, tipo:2})"
                              >
                                <span style="color:blue;font-size:80%">{{ getFormatBytes(archivo.file_size) }}</span>
                                <span
                                  v-if="archivo.file_principal != null"
                                  :class="
                                    archivo.file_principal
                                      ? 'badge badge-danger'
                                      : 'badge badge-warning'
                                  "
                                >
                                  {{ archivo.file_principal?'P':'A' }}
                                </span>
                                <span
                                  :class="
                                    archivo.file_tipo.indexOf('image') === 0
                                      ? 'glyphicon glyphicon-picture'
                                      : 'glyphicon glyphicon-file'
                                  "
                                ></span>
                                {{ archivo.file_name }}
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="documentos" :limit="3" @pagination-change-page="buscarRegistro" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Vuex from 'vuex'
  import Mpv from '@/js/store/models/mpv'
  import moment from 'moment'
  export default {
    name: 'MpvDerivative',
    props: {
      routes: {
        type: [Object, String],
        default: ''
      },
      routeDocumento:{
        type: String,
        default: ''
      },
    },

    data(){
      return {
        filtro: {
          id: null,
          fecha_desde: null,
          fecha_hasta: null,
          page: null
        },
        documentos: {
          current_page: null,
          data: [],
          from: null,
          last_page: null,
          next_page_url: null,
          path: null,
          per_page: null,
          prev_page_url: null,
          to: null,
          total: null
        },
      }
    },
    computed:{
      ...Vuex.mapGetters([
        'getDependenciaNombre',
        'getUsuariosActivoNombre',
        'getFormatBytes'
      ])
    },

    mounted () {
      let date = new Date() // Or the date you'd like converted.
      let isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
      this.filtro.fecha_hasta = isoDate.slice(0, 10)
      this.filtro.fecha_desde = isoDate.slice(0, 10)

      this.buscarRegistro()
      this.obtenerRutas(this.routes)
      this.obtenerJsonAll()
    },

    methods:{
      ...Vuex.mapActions([
        'imprimirDocumentoPdf',
        'obtenerJsonAll',
        'obtenerRutas',
        'buscarByDocumento'
      ]),

      moment (a) {
        return moment(a)
      },

      putHasta() {
        this.filtro.fecha_hasta = this.filtro.fecha_desde
      },

      buscarRegistro( page = 1) {
        this.filtro.page = page
        Mpv.registrosDerivados({ params: this.filtro}).then( response => {
          this.documentos = response.data
        })
      },

      recargar(iddocumento) {
        window.open(this.routeDocumento.replace(/%s/g, iddocumento), 'visorExp', 'width=1000, height=750')
      }
    }
  }
</script>

<style scoped>
  .registro strong {
    width: 60px;
    display: inline-block;
  }

  .documento strong {
    display: inline-block;
    float: left;
  }

  .documento strong.mobile {
    width: 100%;
  }

  .documento strong.tablet {
    width: 100%;
  }

  .documento strong.laptop {
    width: 30%;
  }

  .documento strong.desktop {
    width: 20%;
  }

  .documento div {
    float: left;
  }

  .documento div.mobile {
    width: 100%;
  }

  .documento div.tablet {
    width: 100%;
  }

  .documento div.laptop {
    width: 70%;
  }

  .documento div.desktop {
    width: 80%;
  }

  .table tbody tr td,
  .table thead tr th {
    font-size: 11px;
    font-family: Tahoma;
    vertical-align: middle;
    padding: 2px 0px;
  }

  input,
  textarea {
    text-transform: uppercase;
  }

  .doc-link {
    width: 280px;
    text-overflow: ellipsis;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    margin-bottom: 0;
  }
</style>
