<template>
  <div>
    <nav class="navbar navbar-gorehco navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navegacion-fm">
            <span class="sr-only">Desplegar / Ocultar Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a :href="getRuta('principal')" class="img">
            <img src="/img/logo1.png" alt="" />
          </a>
        </div>
        <div class="collapse navbar-collapse" id="navegacion-fm">
          <ul v-if="!auth['guest']" class="nav navbar-nav">
            <li v-if="canRuta('administrador.roles.rol')" class="dropdown">
              <a :href="getRuta('administrador.roles.rol')" class="dropdown-toggle">Roles</a>
            </li>
            <li v-if="canRuta('administrador.usuarios.usuario')" class="dropdown">
              <a :href="getRuta('administrador.usuarios.usuario')" class="dropdown-toggle">Usuarios</a>
            </li>
            <li v-if="canRuta('administrador.publicaciones.comunicacionIntena')" class="dropdown">
              <a :href="getRuta('administrador.publicaciones.comunicacionIntena')" class="dropdown-toggle">Publicaciones</a>
            </li>
            <li v-if="canRuta('administrador.correos')" class="dropdown">
              <a :href="getRuta('administrador.correos')" class="dropdown-toggle">Correos</a>
            </li>
            <li v-if="canRuta('administrador.holidays')" class="dropdown">
              <a :href="getRuta('administrador.holidays')" class="dropdown-toggle">Dias Feriado</a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            <li v-if="auth['guest']">
              <a :href="routes['login']">Login</a>
            </li>
            <li v-else class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ user.adm_name }}
                <span class="caret"></span>
              </a>

              <ul class="dropdown-menu" role="menu">
                <li>
                  <a :href="getRuta('principal')"> <i class="fa fa-btn fa-sign-out"></i>Menú principal</a>
                </li>
                <li>
                  <a :href="getRuta('logout')"> <i class="fa fa-btn fa-sign-out"></i>Cerrar Session </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>
<script>
export default {
  props: {
    routes: {
      type: [Object, String],
      default: ''
    },
    auth: {
      type: Object,
      default: () => ({})
    },
    titulo: {
      type: String,
      default: ''
    },
    user: {
      type: [Object, String],
      default: ''
    }
  },
  data() {
    return {}
  },
  computed: {
    ...Vuex.mapGetters(['getRuta', 'canRuta'])
  },
  mounted() {
    this.obtenerRutas(this.routes)
    this.obtenerUsuario(this.user)
    this.obtenerJsonAll()
  },
  methods: {
    ...Vuex.mapActions(['obtenerRutas', 'obtenerJsonAll', 'obtenerUsuario'])
  }
}
</script>
