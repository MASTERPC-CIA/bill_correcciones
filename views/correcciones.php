<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*echo Open('form', array('action'=>  base_url('correcciones/index/corregir_cxc_saldos'),'method'=>'post'));
    echo tagcontent('button', 'Correccion Saldos CxC', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-primary'));
echo Close('form');

echo Open('form', array('action'=>  base_url('correcciones/index/corregir_cxp_saldos'),'method'=>'post'));
    echo tagcontent('button', 'Correccion Saldos C x Pagar ', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-primary'));
echo Close('form');


echo Open('form', array('action'=>  base_url('correcciones/index/corregir_anticipocliente_saldos'),'method'=>'post'));
    echo tagcontent('button', 'Correccion Saldos Anticipo CLiente', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-primary'));
echo Close('form');


echo Open('form', array('action'=>  base_url('correcciones/index/corregir_anticipoproveedor_saldos'),'method'=>'post'));
    echo tagcontent('button', 'Correccion Saldos Anticipo Proveedor', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-primary'));
echo Close('form');


echo Open('form', array('action'=>  base_url('correcciones/index/corregir_costo_inventario_xproducto'),'method'=>'post'));
    echo tagcontent('button', 'Correccion Inventario x Producto', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-primary'));
echo Close('form');

echo Open('form', array('action'=>  base_url('correcciones/index/corregir_costo_inventario_total'),'method'=>'post'));
    echo tagcontent('button', 'Correccion Inventario Total', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-primary'));
echo Close('form');
*/

//echo Open('form', array('action'=>  base_url('correcciones/index/corregir_utilidad_venta_bienes'),'method'=>'post'));
//    echo tagcontent('button', 'Correccion Utilidad Venta Bienes', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-primary'));
//echo Close('form');
//
//echo Open('form', array('action'=>  base_url('correcciones/index/corregir_utilidad_venta_servicios'),'method'=>'post'));
//    echo tagcontent('button', 'Correccion Utilidad Venta Servicios', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-primary'));
//echo Close('form');



echo Open('form', array('action'=>  base_url('correcciones/index/corregir_costo_venta'),'method'=>'post'));
    echo tagcontent('button', 'Actualizar costo de venta y costo para la utilidad', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-primary'));
echo Close('form');

echo Open('form', array('action'=>  base_url('correcciones/index/asientos_transfer_all'),'method'=>'post'));
    echo tagcontent('button', 'Transferir todos los asientos antiguos', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-success'));
echo Close('form');

echo Open('form', array('action'=>  base_url('correcciones/index/reset_cuentas'),'method'=>'post'));
    echo tagcontent('button', 'Reiniciar cuentas bancarias a saldos iniciales', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-danger'));
echo Close('form');

echo tagcontent('div', '', array('id'=>'correccion_k_bod_out','class'=>'col-md-12'));