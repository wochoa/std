<template>
  <div>
    <nav class="navbar navbar-gorehco navbar-static-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navegacion-fm">
            <span class="sr-only">Desplegar / Ocultar Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!--<a :href="getRuta('tramite.inicio')" class="navbar-brand">{{ titulo }}</a>-->
          <a :href="getRuta('tramite.inicio')" class="img">
            <img src="/img/logo1.png" alt="" />
          </a>
        </div>
        <!-- Inicia Menu -->
        <div id="navegacion-fm" class="navbar-collapse collapse">
          <ul v-if="!auth['guest']" class="nav navbar-nav">
            <li class="dropdown">
              <a class="dropdown-toggle" :href="getRuta('tramite.inicio')">Inicio</a>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" :href="getRuta('tramite.buscador')">Buscar Documentos</a>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" :href="getRuta('tramite.reporte.index')">Reportes</a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                Documentos <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a tabindex="-1" :href="getRuta('tramite.enproceso.index')">En Proceso</a></li>
                <li><a tabindex="-1" :href="getRuta('tramite.view.docs.generados')">Docs. Generados</a></li>
                <li><a tabindex="-1" :href="getRuta('tramite.view.plantilla')">Plantillas</a></li>
                <li class="divider"></li>
                <li><a tabindex="-1" :href="getRuta('tramite.recibir.index')">Por Recibir</a></li>
                <li><a tabindex="-1" :href="getRuta('tramite.archivado.index')">Archivados</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                Catálogos <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a tabindex="-1" :href="getRuta('tramite.catalogo.archivador')">Archivadores</a></li>
                <li class="divider"></li>
                <li v-if="canRuta('tramite.catalogo.tipoDocumento')">
                  <a tabindex="-1" :href="getRuta('tramite.catalogo.tipoDocumento')">Tipos de Documentos</a>
                </li>
                <li v-if="canRuta('tramite.catalogo.recepcion')">
                  <a tabindex="-1" :href="getRuta('tramite.catalogo.recepcion')">Formas de Recepción</a>
                </li>
                <li v-if="canRuta('tramite.catalogo.prioridades')">
                  <a tabindex="-1" :href="getRuta('tramite.catalogo.prioridades')">Tipos de Prioridades</a>
                </li>
              </ul>
            </li>
            <li v-if="canRuta('tramite.recepcion.recepcionDocumento')" class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                Trámite <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li v-if="canRuta('tramite.recepcion.recepcionDocumento')">
                  <a tabindex="-1" :href="getRuta('tramite.recepcion.recepcionDocumento')">Recepción Documentos</a>
                </li>
                <li v-if="canRuta('tramite.liberar.liberarDocCas')">
                  <a tabindex="-1" :href="getRuta('tramite.liberar.liberarDocCas')">Liberar Doc. por CAS</a>
                </li>
                <li class="divider"></li>
              </ul>
            </li>
            <li
              v-if="canRuta('tramite.administrador.usuario') || canRuta('tramite.administrador.entidades') || canRuta('administrador.usuarios.rrhh')"
              class="dropdown"
            >
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                Administración<span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li v-if="canRuta('tramite.administrador.entidades')">
                  <a tabindex="-1" :href="getRuta('tramite.administrador.entidades')">Entidades Externas</a>
                </li>
                <li v-if="canRuta('tramite.administrador.unidades')">
                  <a tabindex="-1" :href="getRuta('tramite.administrador.unidades')">Unidades Orgánicas</a>
                </li>
                <li v-if="canRuta('tramite.administrador.unidadesSedes')">
                  <a tabindex="-1" :href="getRuta('tramite.administrador.unidadesSedes')">
                    Unidades Orgánicas x Dependencia
                  </a>
                </li>
                <li class="divider"></li>
                <li v-if="canRuta('tramite.administrador.usuario')">
                  <a tabindex="-1" :href="getRuta('tramite.administrador.usuario')">Usuarios</a>
                </li>
                <li v-if="canRuta('tramite.administrador.correlativos')">
                  <a tabindex="-1" :href="getRuta('tramite.administrador.correlativos')">Correlativos</a>
                </li>
                <li v-if="canRuta('tramite.administrador.correlativosDependencia')">
                  <a tabindex="-1" :href="getRuta('tramite.administrador.correlativosDependencia')">
                    Correlativos Dependencia
                  </a>
                </li>
                <!--<li><a tabindex="-1" href="bloques">Bloques</a></li>-->
                <li v-if="canRuta('tramite.administrador.dependencias')">
                  <a tabindex="-1" :href="getRuta('tramite.administrador.dependencias')">Dependencias</a>
                </li>
                <li v-if="canRuta('tramite.administrador.editDependenciasSedes')">
                  <a tabindex="-1" :href="getRuta('tramite.administrador.editDependenciasSedes')">Editar Dependencia</a>
                </li>
                <li v-if="canRuta('administrador.usuarios.rrhh')">
                  <a tabindex="-1" :href="getRuta('administrador.usuarios.rrhh')">Usuarios x RRHH</a>
                </li>
                <li>
                  <span class="icon icon-file-play fs-10" aria-hidden="true" style="font-size: 15px; margin-top: 10px">
                    <a tabindex="-1" href="https://drive.google.com/file/d/1MfzLByygkgx3t7A0MZgCeC0uYVJPqlA6/view?usp=sharing" target="_blank" style="font-size: 15px; margin-top: 15px">Manual de administrador de dependencia</a>
                  </span>
                </li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            <li v-if="auth['guest']"><a :href="getRuta('login')">Login</a></li>
            <li v-else class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ user.adm_name }} <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a :href="getRuta('principal')">
                    <span class="icon icon-home "></span>
                    Menu principal
                  </a>
                </li>
                <li>
                  <a href="/tramite/cambiarContrasenia">
                    <span class="icon icon-key2"></span>
                    Cambiar Contraseña
                  </a>
                </li>
                <li>
                  <a :href="getRuta('logout')">
                    <span class="icon icon-exit"></span>
                    Cerrar Session
                  </a>
                </li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-right" @submit.prevent="buscarDocumento()">
            <input
              type="text"
              :value="getCodigoBusqueda"
              class="form-control"
              placeholder="Buscar Documento"
              @input="actualizarCodigoBusqueda($event.target.value)"
            />
            <button type="button" class="btn btn-sm btn-success" @click="buscarDocumentoPopup()">
              Buscar Reg.
            </button>
            <button type="button" class="btn btn-sm btn-warning" @click="buscarExpedientePopup()">
              Buscar Exp.
            </button>
          </form>
        </div>
      </div>
    </nav>
    <!-- Modal buscar-->
    <div id="comunicacion" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <slider />
          <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="cerrarNoticia">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal buscar-->
    <div id="buscar" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <buscar-modal ref="mod" :form-data="formData" :auth="auth" />
        </div>
      </div>
    </div>
    <!-- Modal buscar expediente-->
    <div id="expediente" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <buscar-expediente ref="exp" :form-data="formData" :route-expediente="getRuta('tramite.expediente.index')" />

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal buscar-->
    <div id="login" class="modal fade" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h3 class="modal-title">Iniciar Session</h3>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form" @submit.prevent="login">
              <div :class="'form-group' + (errorLogin.adm_email != undefined ? ' has-error' : '')">
                <label class="col-md-4 control-label">Usuario</label>

                <div class="col-md-8">
                  {{ user.adm_email }}
                  <span v-if="errorLogin.adm_email != undefined" class="help-block">
                    <strong>{{ errorLogin.adm_email }}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Contraseña</label>

                <div class="col-md-8">
                  <input v-model="password" type="password" class="form-control" />
                  <span v-if="errorLogin.password != undefined" class="help-block">
                    <strong>{{ errorLogin.password }}</strong>
                  </span>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <div class="checkbox">
                    <label> <input type="checkbox" name="remember" /> Recordarme </label>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click.prevent="login">Iniciar Sesión</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
          </div>
        </div>
      </div>
    </div>
    <!--FIN MODAL -->
  </div>
</template>
<script>
  import Vuex        from 'vuex'
  import {Documento} from "@/js/store/models/documento"
export default {
  props:{
          titulo:{
              type: String,
              default: ''
            },
          routes:{
              type: Object,
              default: () => ({})
            },
          user:{
              type: Object,
              default: () => ({})
            },
          auth:{
              type: Object,
              default: () => ({})
            }
        },
  data() {
    return {
      formData: {
        iddocumento: null,
        modal: false
      },
      password: null,
      errorLogin: {},
      idModalLogin: '#login'
    }
  },
  computed: {
    ...Vuex.mapGetters(['getRuta', 'canRuta', 'getCodigoBusqueda'])
  },
  mounted() {
    this.obtenerRutas(this.routes)
    this.obtenerUsuario(this.user)
    this.obtenerJsonAll()
  },
  methods: {
    ...Vuex.mapActions([
      'obtenerRutas',
      'actualizarCodigoBusqueda',
      'buscarByDocumento',
      'obtenerJsonAll',
      'obtenerUsuario'
    ]),
    cerrarNoticia() {
      var f = new Date()
      document.act = f.getTime()
      document.modal = false
      $('#comunicacion').modal('hide')
    },
    login() {
      axios.get(this.getRuta('login')).then(response => {
        var este = this
        axios
          .post(this.getRuta('login'), { adm_email: this.user.adm_email, password: this.password, modal: true })
          .then(response => {
            $(este.idModalLogin).modal('hide')
          })
          .catch(function(error) {
            console.log(error)
            if (error.response.status === 422) {
              este.errorLogin = error.response.data
            }
          })
      })
    },
    buscarDocumento() {
      if (this.getCodigoBusqueda > 0) this.buscarByDocumento({ iddocumento: this.getCodigoBusqueda, modal: true })
      else alert('Digite bien el Registro')
    },

    buscarExpediente() {
      this.formData.iddocumento = this.getCodigoBusqueda
      if (this.formData.iddocumento > 0) {
        this.$refs.exp.buscarExpediente()
      } else {
        alert('Digite bien el registro')
      }
    },

    graficar() {
      this.$refs.mod.graficar()
    },

    buscarDocumentoPopup() {
      this.formData.iddocumento = this.getCodigoBusqueda
      if (this.formData.iddocumento > 0) {
        this.formData.modal = false
        Documento.buscarDocumento(this.formData).then(response => {
          if (response.data.operaciones.length > 0) {
            var route = this.getRuta('tramite.buscar.buscarModal')
            route = route.replace(/%s/g, this.formData.iddocumento)
            window.open(route, 'Visor', 'width=1000,height=750')
            //console.log(this.operaciones[0].oper_detalledestino.length);
          } else {
            alert('No hay datos que mostrar, el registro no existe')
          }
        })
      } else {
        alert('Digite bien el Registro')
      }
    },

    buscarExpedientePopup() {
      this.formData.iddocumento = this.getCodigoBusqueda
      if (this.formData.iddocumento > 0) {
        axios.get(this.getRuta('tramite.expediente.index'), { params: this.formData }).then(response => {
          if (response.data.length > 0) {
            var route = this.getRuta('tramite.buscar.buscarExpedienteModal')
            route = route.replace(/%s/g, this.formData.iddocumento)
            window.open(route, 'VisorExpe', 'width=1000, height=750')
          } else {
            alert('No hay datos que mostrar, el expediente no existe')
          }
        })
      } else {
        alert('Digite bien el expediente')
      }
    },

    imprimirDocumento() {
      this.$refs.mod.imprimirDocumento()
    }
  }
}
</script>
