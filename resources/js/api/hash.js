
import {md5} from 'pure-md5';
export default {
    verificarHash(key, operation) {
        if((hashMd5[key]===undefined&&!!localStorage.getItem(key)))
            operation();
        if(!!localStorage.getItem(key)&&hashMd5[key ]!==md5(localStorage.getItem(key)))
            operation();

    },

}