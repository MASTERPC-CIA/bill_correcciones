<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo Open('form', array('action'=>  base_url('correcciones/index/corregir_cxc_saldos'),'method'=>'post'));
    echo tagcontent('button', 'Correccion Saldos CxC', array('id'=>'ajaxformbtn','data-target'=>'correccion_k_bod_out','class'=>'btn btn-primary'));
echo Close('form');

echo tagcontent('div', '', array('id'=>'correccion_k_bod_out','class'=>'col-md-12'));