<template>
    <div class="panel-body">
        <h4>EXPEDIENTES</h4>
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
           <div class="col-sm-3">
                <label>Desde</label>
                <input type="date" name="" class="form-control">
           </div>
           <div class="col-sm-3">
                <label>Hasta</label>
                <input type="date" name="" class="form-control">
           </div>
           <div class="col-sm-3">
                <label>Tipo</label>
                <select name="" class="form-control">
                    <option value="">Seleccione</option>
                    <option value="">Procesos Judiciales</option>
                </select>
           </div>
           <div class="col-sm-3">
                <label>Encargado</label>
                <select name="" class="form-control">
                    <option value="">Seleccione</option>
                    <option value="">Juanito</option>
                </select>
           </div>          
        </div>
        <div class="row form-group" style="width: 100%;margin-left: -0px;">
            <div class="col-sm-9">
                <label>Buscador</label>
                <input type="text" name="" class="form-control">
            </div>
            <div class="col-sm-3">
                <label>Estado</label>
                    <select name="" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="">Solicitud</option>
                    </select>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                        <tr class="info">
                            <th width="8%" rowspan="3">N° Expediente</th>
                            <th width="6%" rowspan="3">Tipo</th>
                            <th width="10%" rowspan="3">Juzgado Centro de Conciliacion y/o Arbitraje</th>
                            <th width="8%" rowspan="3">Encargado</th>
                            <th width="10%" rowspan="3">Partes</th>
                            <th width="10%" rowspan="3">Pretenciones monto</th>
                            <th width="6%" rowspan="3">Fecha</th>
                            <th width="6%" rowspan="3">Acciones</th>
                            <th width="6%" rowspan="3">Importante</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PROCESO JUDICIAL</td>
                            <td>Juzgado Mixto - HUACRACHUCO</td>
                            <td>2014-122-ACA</td>
                            <td>JULIO CARLOS, PEDROSO CALDERON</td>
                            <td>FLORES FRANCISCO, GENARA <br> GOREHCO</td>
                            <td> <br> S/0.00</td>
                            <td>2015-05-08</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>        
    </div>
</template>
<script>
export default {
    data(){
        return{

        }
    }
}
</script>