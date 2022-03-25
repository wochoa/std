import certificacion from '@/js/api/herramientas/certificacion';
import certificados from '@/js/api/herramientas/certificados';
import modificatoria from '@/js/api/herramientas/modificatoria';

const state = {
    certificaciones         : [],
    certificados            : [],
    detalleCertificado      : [],
    detalle                 : [],
    modificatorias          : [],
    modificatoriaDetalle    : {
        total: {
            de: 0,
            a: 0,
            pim: 0,
            cert: 0,
        },
        proyectos:[]
    }
};

const getters = {
    mostrarCertificaciones: (state) => {
        return state.certificaciones;
    },
    getOneCertificacion: (state) => (id) => {
        return state.certificaciones.filter(d => d.id == id)[0];
    },
    showCertificados: (state) => {
        return state.certificados;
    },
    getOneCertificado: (state) => (id) => {
        return state.certificados.filter(d => d.id == id)[0];
    },
    showDetalleCertificado: (state, getters) => {
        var arr = state.detalleCertificado;
        var arr2 = state.detalle;
        var arr1 = [];
        var arr3 = [];
        if(arr2.length>0){
            var soli = arr2[0].solicitud_id;
        }else{
            var soli = null
        }
        for(var i = 0; i<arr.length; i++){
            var g = arr2.filter(d => d.det_anio == arr[i].ano_eje && d.det_sec_func == arr[i].sec_func && d.det_fuente_financiamiento == arr[i].fuente_financ && d.det_id_clasif === arr[i].id_clasificador && d.det_secuencia == arr[i].secuencia &&  d.det_correlativ == arr[i].correlativo);
            let monto_cert = (arr[i].monto_cert>arr[i].monto)?(arr[i].monto_cert-arr[i].monto):0;
            arr1[i]={
                'sec'               :arr[i].secuencia+"-"+("000000"+arr[i].correlativo).slice(-4),
                'estado_registro'        :arr[i].estado_registro,
                'sec_func'          :arr[i].sec_func,
                'especifica'        :getters.showNameLvl3(arr[i].id_clasificador),
                'num_doc'           :arr[i].num_doc,
                'fecha_doc'             :arr[i].fecha_doc,
                'monto_cert'        :monto_cert,
                'monto_solicitado'  :arr[i].pim-monto_cert,
                'monto'             :arr[i].monto,
                'ano_eje'           :arr[i].ano_eje,
                'fuente_financ'        :arr[i].fuente_financ,
                'id_clasificador'        :arr[i].id_clasificador,
                'secuencia'         :arr[i].secuencia,
                'correlativo'        :arr[i].correlativo,
                'key'               :(g.length==1)?g[0].id:arr[i].id,
                'solicitud_id'      :soli,
                'pim'               :arr[i].pim
            }
        }
        for(var i = 0; i<arr2.length; i++){
            var g = arr.filter((d => d.ano_eje == arr2[i].det_anio && d.sec_func == arr2[i].det_sec_func && d.fuente_financ == arr2[i].det_fuente_financiamiento && d.id_clasificador === arr2[i].det_id_clasif && d.secuencia == arr2[i].det_secuencia &&  d.correlativo == arr2[i].det_correlativ));
            if(g.length==0){
                let monto_cert = (arr2[i].det_certificacion>arr2[i].det_monto_solicitado)?(arr2[i].det_certificacion-arr2[i].det_monto_solicitado):0;
                arr3[i]={
                    'sec'               :arr2[i].det_secuencia+"-"+("000000"+arr2[i].det_correlativ).slice(-4),
                    'estado_registro'        :'',
                    'sec_func'          :arr2[i].det_sec_func,
                    'especifica'        :getters.showNameLvl3(arr2[i].det_id_clasif),
                    'num_doc'           :'',
                    'fecha_doc'             :'',
                    'monto_cert'        :monto_cert,
                    'monto_solicitado'  :arr2[i].det_pim-monto_cert,
                    'monto'             :arr2[i].det_monto_solicitado,
                    'ano_eje'           :arr2[i].det_anio,
                    'fuente_financ'        :arr2[i].det_fuente_financiamiento,
                    'id_clasificador'        :arr2[i].det_id_clasif,
                    'secuencia'         :arr2[i].det_secuencia,
                    'correlativo'        :arr2[i].det_correlativ,
                    'key'               :arr2[i].id,
                    'solicitud_id'      :arr2[i].solicitud_id,
                    'pim'               :arr2[i].det_pim
                }
            }

        }
        var array = arr3.concat(arr1);
        return array;
    },
    showModificatorias:(state) =>{
        return state.modificatorias;
    },
    getOneModificatoria:(state) => (id) => {
        return state.modificatorias.filter(d => d.id == id)[0];
    },
    showModificatoriaDetalle:(state) => {
        return state.modificatoriaDetalle;
    }
};
const actions = {

    getCertificaciones({commit}, anio){
        return new Promise((resolve, reject) =>{
            certificacion.requestCertificaciones(anio).then(response =>{
                commit('setCertificaciones', response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    saveDocCertificacion({commit}, formCertificacion){
        certificacion.saveDocCertificacion(formCertificacion);
    },

    getCertificados({commit}, certificacion){
        return new Promise((resolve, reject) =>{
            certificados.requestCertificados(certificacion).then(response=>{
                commit('setCertificados', response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    getDetalleCertificado({commit}, id){
        return new Promise((resolve, reject) =>{
            certificados.requestCertificadoDetalle(id).then(response=>{
                commit('setDetalleCertificado', response.data);
                resolve(response);
            }).catch(error =>{
                reject(error);
            });
        });
    },

    saveCertificado({commit}, formCertificado){
        certificados.saveCertificados(formCertificado);
    },

    deleteOneCertificado({commit}, id){
        certificados.deleteCertificado(id);
    },

    newDetalleCertificado({commit}){
        commit('setNewDetalleCertificado', []);
        commit('setNewDetalle', []);
    },

    saveDetalleCertificado({commit}, item){
        if(confirm("Esta seguro de agregar el detalle de certificado?")){
            return new Promise((resolve, reject) => {
                certificados.saveDetalleCertificado(item).then(response => {
                    commit('addDetalleCertificado', response.data);
                }).catch(error => {
                    reject(error);
                });
            });
        }
    },
    deleteCertificadoDetalle({commit}, key){
        if(confirm("Esta seguro de eliminar el detalle de certificado?")){
            return new Promise((resolve, reject) => {
                certificados.deleteCertificadoDetalle(key).then(response => {
                    commit('deleteOneDetalleCertificado', response.data);
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        }
    },

    getModificatorias({commit}, anio){
        return new Promise((resolve, reject) =>{
            modificatoria.requestModificatorias(anio).then(response =>{
                commit('setModificatorias', response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    saveModificatoria({commit}, formModificatoria){
        return new Promise((resolve, reject) => {
            modificatoria.saveModificatoria(formModificatoria).then(response => {
                commit('addOneModificatoria', response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    },

    deleteModificatoria({commit}, id){
        if(confirm("Esta seguro de eliminar la modificatoria?")){
            return new Promise((resolve, reject) => {
                modificatoria.deleteModificatoria(id).then(response => {
                    commit('deleteOneModificatoria', response.data);
                    resolve(response);
                }).catch(error => {
                    reject(error);
                });
            });
        }
    },

    getModificatoriaDetalle({commit}, form){
        return new Promise((resolve, reject) =>{
            modificatoria.requestModificatoriaDetalle(form).then(response =>{
                commit('setModificatoriaDetalle', response.data);
                resolve(response);
            }).catch(error => {
                reject(error);
            });
        });
    }
};
const mutations = {
    setCertificaciones(state, u){
        state.certificaciones = u;
    },
    setCertificados(state, u){
        state.certificados = u;
    },
    setDetalleCertificado(state, u){
        state.detalleCertificado    = u.certificado;
        state.detalle               = u.detalle;
    },
    setNewDetalleCertificado(state, u){
        state.detalleCertificado = u;
    },
    setNewDetalle(state, u){
        state.detalle = u;
    },
    addDetalleCertificado(state, u){
        state.detalle.push(u);
    },
    deleteOneDetalleCertificado(state, u){
        let index = state.detalle.findIndex((d) => d.id == u.key);
        state.detalle.splice(index,1);
    },
    setModificatorias(state, u){
        state.modificatorias = u;
    },
    deleteOneModificatoria(state, u){
        let index = state.modificatorias.findIndex((d) => d.id == u.id);
        state.modificatorias.splice(index,1);
    },
    addOneModificatoria(state, u){
        state.modificatorias.push(u);
    },
    setModificatoriaDetalle(state, u){
        state.modificatoriaDetalle = Object.assign(state.modificatoriaDetalle,u);
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
