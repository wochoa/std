import Vue       from "vue"
import VueRouter from 'vue-router'

import example from './components/ExampleComponent'

import ProyectoPresupuestoInicio from './components/ProyectoPresupuestoInicio'
import ProyListado          from './components/proyectos/ProyListado'

import PresuMetas    from './components/presupuesto/PresuMetas'
import PresuGastosCorriente from './components/presupuesto/PresuGastosCorriente'

import PanelGeneral from './components/gastos/PanelGeneral'

import ProyAdmin from './components/proyectos/ProyAdmin'
import ActiAdmin   from './components/proyectos/actividades/ActiAdmin'
import HerramientaAdmin from './components/herramientas/HerramientaAdmin'

Vue.use(VueRouter)
export const routes = [

  {
    path     : '/unauthorized',
    name     : 'unauthorized',
    component: example
  }, {
    path     : '/proyecto-presupuesto',
    name     : 'ProyectoPresupuestoInicio',
    component: ProyectoPresupuestoInicio
  }, {
    path     : '/proyectos',
    name     : 'ProyListado',
    component: ProyListado
  }, {
    path     : '/proyectos/:idproyecto/analitico',
    name     : 'ProyAnalitico',
    component: ProyAdmin
  }, {
    path     : '/proyectos/:idproyecto/gastos',
    name     : 'ProyGastos',
    component: ProyAdmin
  }, {
    path     : '/proyectos/:idproyecto/componentes',
    name     : 'ProyComponentesTareas',
    component: ProyAdmin
  }, {
    path     : '/proyectos/:idproyecto/programar',
    name     : 'ProyLineaTiempo',
    component: ProyAdmin
  }, {
    path     : '/proyectos/:idproyecto/informes',
    name     : 'ProyInformes',
    component: ProyAdmin
  }, {
    path     : '/proyectos/:idproyecto/contratos',
    name     : 'ProyContratos',
    component: ProyAdmin
  }, {
    path     : '/proyectos/:idproyecto/contratos/:idcontrato/actividades',
    name     : 'ActiControl',
    component: ActiAdmin
  }, {
    path     : '/proyectos/:idproyecto/contratos/:idcontrato/valorizaciones',
    name     : 'ActiValorizaciones',
    component: ActiAdmin
  }, {
    path     : '/proyectos/:idproyecto/contratos/:idcontrato/controlPlazo',
    name     : 'ActiPlazo',
    component: ActiAdmin,
    props    : {tipo: 3}
  }, {
    path     : '/proyectos/:idproyecto/contratos/:idcontrato/controlAlcance',
    name     : 'ActiAlcance',
    component: ActiAdmin,
    props    : {tipo: 4}
  }, {
    path     : '/gastos',
    name     : 'PanelGeneral',
    component: PanelGeneral,
    meta     : {
      requiresAuth: true,
      can         : 'gastos.show'
    }
  }, {
    path     : '/presupuesto/listadoMetas',
    name     : 'PresuMetas',
    component: PresuMetas
  }, {
    path     : '/presupuesto/gastosCorriente',
    name     : 'PresuGastosCorriente',
    component: PresuGastosCorriente
  }, {
    path     : '/fichaCertificacion',
    name     : 'CertFicha',
    component: HerramientaAdmin
  }, {
    path     : '/fichaCertificacion/:anio/:idcertificacion/certificados',
    name     : 'CertControl',
    component: HerramientaAdmin
  }, {
    path     : '/herramientas/modificatorias',
    name     : 'ModiListado',
    component: HerramientaAdmin
  }, {
    path     : '/herramientas/modificatorias/:anio/:id/detalle',
    name     : 'ModiDetalle',
    component: HerramientaAdmin
  }, {
    path     : '/example',
    name     : 'example',
    component: example
  }]

export const router = new VueRouter({
                                      mode                : 'history',
                                      base                : __dirname,
                                      linkActiveClass     : "",
                                      linkExactActiveClass: "active",
                                      routes,
                                    })
