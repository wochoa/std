<template>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Documentos Enviados</div>
      <div class="panel-body">
        <form action="">

        </form>
        <div class="box">
          <div class="box-body">
            <pagination :data="documentos" :limit="3" @pagination-change-page="buscarDespachados" />
            <table class=" table table-bordered table-condensed table-hover ">
              <thead>
                <tr class="info">
                  <th style="width:7%">REGISTRO</th>
                  <th style="width:15%">REMITENTE</th>
                  <th style="width:40%">ENTIDAD RECEPTORA</th>
                  <th style="width:10%">OPERACIÓN</th>
                  <th style="width:10%">ESTADO</th>
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
                    {{ ('00000000'+ documento.vnumregstd).slice(-8) }}
                  </td>
                  <td>
                    <strong>DNI:</strong>{{ documento.vnumdociderem }}<br />
                    <strong :class="$mq">UNIDAD ORGANICA: </strong>{{ documento.vuniorgrem }}
                  </td>
                  <td class="documento">
                    <strong :class="$mq">RUC:</strong>
                    <div :class="$mq">{{ documento.vrucentrec }}</div>
                    <strong :class="$mq">NOMBRE:</strong>
                    <div :class="$mq">{{ documento.vnomentrec }}</div>
                  </td>
                  <td>
                    <div>
                      <strong :class="$mq">CODIGO:</strong>{{ documento.vcuo }}<br />
                    </div>
                  </td>
                  <td>
                    {{ documento.cflgest==='P'?'Pendiente':(documento.cflgest==='E'?'Enviado':(documento.cflgest==='R'?'Recibido':(documento.cflgest==='O'?'Observado':(documento.cflgest==='S'?'Subsanado':'No presentado')))) }}
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination :data="documentos" :limit="3" @pagination-change-page="buscarDespachados" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { Interoperabilidad } from '@/js/store/models/interoperabilidad'
  export default {
    name: 'InterDespachos',

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
      this.buscarDespachados()
    },

    methods:{
      buscarDespachados(page = 1) {
        this.formFiltro.page = page
        Interoperabilidad.getDespachos({ params: this.formFiltro }).then( response => {
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
