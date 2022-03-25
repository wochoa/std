<template>
  <div class="overflow-hidden">
    <div class="text-center mb-2">
      <v-btn text color="deep-purple" />
    </div>

    <v-bottom-navigation color="indigo">
      <v-btn :to="{ name: 'ModiListado' }">
        <span>Modificatorias</span>
        <v-icon>mdi-clipboard-list</v-icon>
      </v-btn>

      <v-btn
        v-if="$route.params.id != undefined && $route.params.anio != undefined"
        :to="{ name: 'ModiDetalle', params: { anio: $route.params.anio, id: $route.params.id } }"
      >
        <span>Detalle</span>
        <v-icon>mdi-currency-usd</v-icon>
      </v-btn>
    </v-bottom-navigation>
  </div>
</template>
<script>
export default {
  data() {
    return {}
  }
}
</script>
