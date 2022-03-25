<template>
  <div>
    <cert-navbar
      v-if="$route.name == 'CertFicha' || $route.name == 'CertControl'"
    />

    <cert-ficha v-if="$route.name == 'CertFicha'" />
    <cert-control v-if="$route.name == 'CertControl'" />

    <modi-navbar
      v-if="$route.name == 'ModiListado' || $route.name == 'ModiDetalle'"
    />
    <modi-listado v-if="$route.name == 'ModiListado'" />
    <modi-detalle v-if="$route.name == 'ModiDetalle'" />
  </div>
</template>
<script>
import CertNavbar from '@/js/components/herramientas/certificacion/CertNavbar'
import CertFicha from '@/js/components/herramientas/certificacion/CertFicha'
import CertControl from '@/js/components/herramientas/certificacion/CertControl'

import ModiNavbar from '@/js/components/herramientas/modificatoria/ModiNavbar'
import ModiListado from '@/js/components/herramientas/modificatoria/ModiListado'
import ModiDetalle from '@/js/components/herramientas/modificatoria/ModiDetalle'

export default {

  components: {
    CertNavbar,
    CertFicha,
    CertControl,
    ModiNavbar,
    ModiListado,
    ModiDetalle
  }
}
</script>
