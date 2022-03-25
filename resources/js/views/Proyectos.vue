<template>
  <v-app id="inspire" class="Proyectos">
    <div id="top-of-site-pixel-anchor"></div>

    <v-navigation-drawer v-model="drawer" temporary app class="Menu">
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            Tablero de control
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list dense>
        <template v-for="item in items">
          <v-list-group
            v-if="item.children&&(!item.can||userCan(item.can))"
            :key="item.text"
            v-model="item.model"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon=""
          >
            <template v-slot:activator>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title>
                    {{ item.text }}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>

            <template v-for="(child, i) in item.children">
              <v-list-item
                v-if="!child.can||userCan(child.can)"
                :key="i"
                link
                :to="{ name: child.route }"
              >
                <v-list-item-action v-if="child.icon">
                  <v-icon>{{ child.icon }}</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                  <v-list-item-title>{{ child.text }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
          </v-list-group>
          <v-list-item v-else-if="!item.can||userCan(item.can)" :key="item.text" :to="{ name: item.route }" link>
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      :collapse="false"
      color="blue darken-3"
      app
      dense
      dark
      class="sticky-top"
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title style="width: 500px" class="ml-0 pl-4">
        <v-list-item link :to="{ name: 'ProyectoPresupuestoInicio' }">
          <span class="hidden-sm-and-down text-uppercase h6">Gestión de Proyectos y Financiera</span>
        </v-list-item>
      </v-toolbar-title>
      <v-spacer />
      <a href="/" class="btn btn-primary text-white btn-withIcon">
        <span class="icon icon-home fs-20"></span>
      </a>
    </v-app-bar>

    <v-content>
      <div class="Proyectos-container">
        <div @click="deleteReferenceProyectGasto">
          <v-breadcrumbs :items="showBreadCrumbs" />
        </div>
        <router-view />
      </div>
    </v-content>
  </v-app>
</template>

<script>
  import Vuex, { mapGetters } from 'vuex'

  export default {
    props: {},
    data: () => ({
      drawer: false,
      items: [
        {
          icon: 'mdi-settings',
          text: 'Inicio',
          route: 'ProyectoPresupuestoInicio'
        }, {
          icon: 'mdi-settings',
          text: 'General',
          route: 'PanelGeneral',
          can: 'gastos.show'
        }, {
          icon: 'mdi-content-copy',
          text: 'Proyectos',
          route: 'ProyListado',
          can: 'proyectos.show'
        }, {
          icon: 'mdi-chevron-up',
          'icon-alt': 'mdi-chevron-down',
          text: 'Presupuesto',
          can: ['presupuesto.manage', 'gastos.manage'],
          model: false,
          children: [
            {
              icon: 'mdi-account-edit',
              text: 'Asignar Metas Oficina',
              route: 'PresuMetas',
              can: 'presupuesto.manage'
            }, {
              icon: 'mdi-backup-restore',
              text: 'Gastos Corrientes',
              route: 'PresuGastosCorriente',
              can: 'presupuesto.show'
            }]
        }, {
          icon: 'mdi-chevron-up',
          'icon-alt': 'mdi-chevron-down',
          text: 'Herramientas',
          model: false,
          children: [
            {
              icon: 'mdi-account-edit',
              text: 'Certificación',
              route: 'CertFicha'
            }, {
              icon: 'mdi-backup-restore',
              text: 'Modificatorias',
              route: 'ModiListado'
            }]
        }]
    }),
    computed: {
      ...Vuex.mapGetters(['showBreadCrumbs', 'userCan'])
    },
    mounted () {
      this.filtroScroll()
    },
    methods: {

      ...Vuex.mapActions(['deleteReferenceProyectGasto']),

      home () {
        document.location.href = '/'
      },
      filtroScroll () {
        if ('IntersectionObserver' in window && 'IntersectionObserverEntry' in window && 'intersectionRatio' in window.IntersectionObserverEntry.prototype) {
          let observer = new IntersectionObserver(entries => {
            if (entries[0].boundingClientRect.y < 0) {
              document.body.classList.add('tieneFiltros')
            } else {
              document.body.classList.remove('tieneFiltros')
            }
          })
          observer.observe(document.querySelector('#top-of-site-pixel-anchor'))
        }
      }
    }
  }
</script>

<style>
  .v-list-group__items {
    margin-left: 15px;
  }

  #top-of-site-pixel-anchor {
    position: absolute;
    width: 1px;
    height: 1px;
    top: 50px;
    left: 0;
  }
</style>
