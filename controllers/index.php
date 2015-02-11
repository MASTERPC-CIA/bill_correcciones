<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Index extends MX_Controller {
               
	function __construct()
	{
 		parent::__construct();
                $this->user->check_session();
	}	
        
        function index()
        {
            $res['view'] = $this->load->view('correcciones','',TRUE);
            $res['slidebar'] = $this->load->view('slidebar','',TRUE);
            $this->load->view('templates/dashboard',$res);
        }
        
        function corregir_cxc_saldos() {
            $this->load->library('common/cuentasxcobrar');
            /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
            $cxc_saldo_ultimo = $this->generic_model->get_data( 'bill_cxc', array( 'id >' => 0 ), $fields = 'client_id, saldo_ultimo', null, 0, 'client_id' );
            
            foreach ( $cxc_saldo_ultimo as $value ) {
                $this->cuentasxcobrar->update_cxc_saldos($value->client_id, $value->saldo_ultimo);
            }
            echo success_msg('Correccion Finalizada');
        }
        
        function corregir_anticipocliente_saldos() {
            $this->load->library('cliente_anticipo');
            /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
            $cxc_saldo_ultimo = $this->generic_model->get_data( 'bill_cliente_anticipo', array( 'id >' => 0 ), $fields = 'client_id, saldo_ultimo', null, 0, 'client_id' );
            
            foreach ( $cxc_saldo_ultimo as $value ) {
                $this->cliente_anticipo->update_anticipo_saldos($value->client_id, $value->saldo_ultimo);
            }
            echo success_msg('Correccion Finalizada');
        }
        
        
        function corregir_anticipoproveedor_saldos() {
            $this->load->library('proveedor_anticipo');
            /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
            $cxc_saldo_ultimo = $this->generic_model->get_data( 'bill_cliente_anticipo', array( 'id >' => 0 ), $fields = 'proveedor_id, saldo_ultimo', null, 0, 'proveedor_id' );
            
            foreach ( $cxc_saldo_ultimo as $value ) {
                $this->proveedor_anticipo->update_anticipo_saldos($value->proveedor_id, $value->saldo_ultimo);
            }
            echo success_msg('Correccion Finalizada');
        }
        
        
        function corregir_costo_inventario_xproducto() {
            $this->load->library('common/product');
            /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
            $cxc_saldo_ultimo = $this->generic_model->get_data( 'bill_kardex', array( 'id >' => 0 ), $fields = 'producto_id, costo_inv_product_ultimo', null, 0, 'producto_id' );
            
            foreach ( $cxc_saldo_ultimo as $value ) {
                $this->product->update_costo_inventario( $value->producto_id, $value->costo_inventario_product );
            }
            echo success_msg('Correccion Finalizada');
        }
        
        
        function corregir_costo_inventario_total() {
            $this->load->library('common/empresaindice');
            /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
            $res = $this->generic_model->get_data( 'bill_kardex', array( 'estado' => 1 ), $fields = 'costo_inventario_ultimo', null, 1 );
            
            $this->empresaindice->update_indice('COSTO_INVENTARIO', $res->costo_inventario_ultimo);
            
            echo success_msg('Correccion Finalizada');
        }

}