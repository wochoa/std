import auth from '../auth';

export default {
    formato:null,
    requestProyectoGastos(parametros) {
        const id = {
            id_proyecto: null
       };
        return axios.get('/app/proyectos/gastos', {params:Object.assign(id,parametros)});
    },
    requestGastosLvl(params){
        return axios.get('/app/proyectos/getGastosLvl', {params:params});
    },
    agregar(to, from){
        to.monto_pim  +=(from.pim!=null)?from.pim:0;
        to.monto_cert +=from.monto_cert;
        to.monto_comp +=from.monto_comp;
        to.monto_dev  +=from.monto_dev;
        to.g_1        +=from.g_1;
        to.g_2        +=from.g_2;
        to.g_3        +=from.g_3;
        to.g_4        +=from.g_4;
        to.g_5        +=from.g_5;
        to.g_6        +=from.g_6;
        to.g_7        +=from.g_7;
        to.g_8        +=from.g_8;
        to.g_9        +=from.g_9;
        to.g_10       +=from.g_10;
        to.g_11       +=from.g_11;
        to.g_12       +=from.g_12;
        return to;
    },
    groupBy(objectArray, property) {
        var gastos =this;
        gastos.formato=property;
        return gastos.sort(
            objectArray.reduce((acc, obj) => {
                var key='', parent = '';
                let fftt=false;
                let sec_func=false;
                let id_clasifi =false;
                for(let i=0;i<property.length;i++) {
                    if (property[i]==="fuente_financ")
                        fftt=true;
                    if (property[i]==="sec_func")
                        sec_func=true;
                    if (property[i]==="id_clasificador")
                        id_clasifi=true;
                    if (obj[property[i]] != null) {
                        key += obj[property[i]] + '-';
                        if (!acc[key])
                            acc[key] = {
                                'type': 'gasto',
                                'lvl': i,
                                'ano_eje': obj.ano_eje,
                                'fuente_financ': fftt?obj.fuente_financ:null,
                                'sec_func': sec_func?obj.sec_func:null,
                                'id_clasificador': id_clasifi?obj.id_clasificador:null,
                                'componente': sec_func?obj.componente:null,
                                'key': key,
                                'parent': parent,
                                'open': i === 0,
                                'monto_pim': 0,
                                'monto_cert': 0,
                                'monto_comp': 0,
                                'monto_dev': 0,
                                'g_1': 0,
                                'g_2': 0,
                                'g_3': 0,
                                'g_4': 0,
                                'g_5': 0,
                                'g_6': 0,
                                'g_7': 0,
                                'g_8': 0,
                                'g_9': 0,
                                'g_10': 0,
                                'g_11': 0,
                                'g_12': 0,
                                'g_tot': 0
                            };
                        if (obj.cert===null)
                            acc[key] = gastos.agregar(acc[key], obj);
                        else if(obj.compromiso===null&&obj.expediente_siaf===null&&i===4) {
                            acc[key] = Object.assign(acc[key], obj);
                        }
                        else if(obj.expediente_siaf===null&&i===5)
                            acc[key] = Object.assign(acc[key], obj);
                        else if(i===6)
                            acc[key] = Object.assign(acc[key], obj);
                        parent = key;
                    }
                }
              return acc;
            }, {})
        );
      },
    sort(arr){
        var gastos =this;
        var sortable = [];
        for (var d in arr) {
            sortable.push(arr[d]);
        }
        return sortable.sort(function(a, b) {
               return gastos.ordenar(a.key, b.key);
          });
    },
    ordenar (a, b){
        let a_key=a.substring(0,a.length-1).split ("-");
        let b_key=b.substring(0,b.length-1).split ("-");
        var i = 0;
        let r=0;
        if(a_key.length>b_key.length){
            r=1;
            while(a_key[i]!=undefined){
                if(a_key[i]>b_key[i]){
                    r= -1;
                    break;
                }
                if(a_key[i]<b_key[i]){
                    r = 1;
                    break;
                }
                i++
            }
            return r;
        }
        else{
            r=-1;
            while(b_key[i]!=undefined){
                if(a_key[i]>b_key[i]){
                    r= -1;
                    break;
                }
                if(a_key[i]<b_key[i]){
                    r = 1;
                   break;
                }
                i++
            }
            return r;
        }
    }
}
