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

}