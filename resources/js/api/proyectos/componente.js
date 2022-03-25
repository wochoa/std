export default {
    requestComponentesTareas(id_proyecto) {
        const params = {
            id_proyecto: id_proyecto
        }
        return axios.get('/app/proyectos/componentesTareas', {params:params});
    },
    saveComponenteTarea(formComponente){
        const params ={
            id : formComponente.id,
            comp_programa               : formComponente.comp_programa,
            comp_prod_proy              : formComponente.comp_prod_proy,
            comp_act_al_obra            : formComponente.comp_act_al_obra,
            comp_funcion                : formComponente.comp_funcion,
            comp_division_funcional     : formComponente.comp_division_funcional,
            comp_grupo_funcional        : formComponente.comp_grupo_funcional,
            comp_meta                   : formComponente.comp_meta,
            comp_finalidad              : formComponente.comp_finalidad,
            comp_nombre                 : formComponente.comp_nombre,
            comp_monto                  : formComponente.comp_monto
        }
        return axios.post('/app/proyectos/componentesTareas/store', params);
    },
    deleteComponenteTarea(id){
        const params ={
            id: id
        }
        return axios.post('/app/proyectos/componentesTareas/destroy', params);
    },
    
}