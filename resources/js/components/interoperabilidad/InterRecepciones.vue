<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Documentos Recibidos</div>
      <div class="panel-body">
        <form action="">

        </form>
        <div class="box">
          <div class="box-body">
            <pagination :data="documentos" :limit="3" @pagination-change-page="buscarRecibidos" />
            <table class=" table table-bordered table-condensed table-hover ">
              <thead>
                <tr class="info">
                  <th style="width:7%">REGISTRO</th>
                  <th style="width:15%">FECHA</th>
                  <th style="width:40%">DOCUMENTO</th>
                  <th style="width:10%">REMITENTE</th>
                  <th style="width:10%">ARCHIVO</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td v-if="documentos.data.length == 0" colspan="21" class="text-center">
                    No hay documentos, pruebe cambiando los filtros
                  </td>
                </tr>
                <tr
                  v-for="(documento, index) in documentos.data"
                  :key="index"
                >
                  <td>

                  </td>
                  <td class="registro">
                    <strong>Fecha:</strong>{{ documento.created_at }}<br />
                    <strong>Folios:</strong>{{ documento.docu_folios }}
                  </td>
                  <td class="documento">
                    <strong :class="$mq">Ruc:</strong>
                    <div :class="$mq">{{ documento.vrucentrem }}</div>
                    <strong :class="$mq">Entidad:</strong>
                    <div :class="$mq">{{ documento.docu_detalle }}</div>
                    <strong :class="$mq">Firma:</strong>
                    <div :class="$mq">{{ documento.docu_firma }}</div>
                    <strong :class="$mq">Cargo:</strong>
                    <div :class="$mq">{{ documento.docu_cargo }}</div>
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

                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="documentos" :limit="3" @pagination-change-page="buscarRecibidos" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { Interoperabilidad } from '@/js/store/models/interoperabilidad'
  export default {
    name: 'InterRecepciones',
    data(){
      return {
        formFiltro: {
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
        operSelected: [],
        docIndexes: [],
      }
    },

    mounted () {
      this.buscarRecibidos()
    },

    methods:{
      buscarRecibidos(page =1) {
        this.formFiltro.page = page
        Interoperabilidad.getRecepcionados({ params: this.formFiltro }).then( response => {
          this.documentos = response.data
        })
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
