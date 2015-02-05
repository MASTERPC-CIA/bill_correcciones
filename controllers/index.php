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
                $this->load->library('kardex_bodega');
	}	
        
        function index()
        {
            $res['view'] = $this->load->view('correcciones','',TRUE);
            $res['slidebar'] = $this->load->view('slidebar','',TRUE);
            $this->load->view('dashboard',$res);
        }
             
        
        function corregir_cxc_saldos() {
            $this->load->library('cuentasxcobrar');
            /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
            $cxc_saldo_ultimo = $this->generic_model->get_data( 'bill_cxc', array( 'id >' => 0 ), $fields = 'client_id, saldo_ultimo', null, 0, 'client_id' );
            
            foreach ( $cxc_saldo_ultimo as $value ) {
                $this->cuentasxcobrar->update_cxc_saldos($value->client_id, $value->saldo_ultimo);
            }
            echo success_msg('Correccion Finalizada');
        }
        
        /* Se daño el kardex por bodega, debido a un error 
         * al hacer anulaciones de compra y de venta
         * Fecha: 7 enero 2015
         */
        function corregir_kardex_bodega()
        {
            set_time_limit(0);
            /* Obtenemos las transacciones que no sean una anulacion x compra o por venta*/
            
            $this->db->trans_begin();
                /* Aparentemente un bug de codeigniter no permite poner <> en ambos casos*/
                $where_not_in = array( 'tipotransaccion_cod' => array('09','10'), );
                $kardex_bodega_aux = $this->generic_model->get_in(
                        'bill_kardex_bodega_aux', 
                        $where_in = null,
                        $where_not_in
                );            

    //            print_r($kardex_bodega_aux);

                $this->update_kardex_bodega($kardex_bodega_aux);
                /* Obtenemos todas las transacciones en la bodega que sean anulacion de compra y de venta */

                $where_in = array( 'tipotransaccion_cod' => array('10','09'), );
                $kardex_bodega_aux_anulaciones = $this->generic_model->get_in(
                        'bill_kardex_bodega_aux', 
                        $where_in,
                        $where_not_in = null, 
                        $fields = '', 
                        $group_by = array('producto_id','bodega_id','doc_id','tipotransaccion_cod')
                );

    //            print_r($kardex_bodega_aux_anulaciones);
                $this->update_kardex_bodega($kardex_bodega_aux_anulaciones);
                
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo info_msg(' Ocurrio un problema con la correccion');                
            }
            else
            {
                $this->db->trans_commit();
                echo info_msg(' El proceso de correccion ha finalizado');
            }                
        }
        

        public function update_kardex_bodega($kardex_bodega_aux) {
            $this->db->trans_begin();
                if($kardex_bodega_aux){
                    foreach ($kardex_bodega_aux as $value) {
                        $kardex_ultimo = $this->generic_model->get_val_where(
                                'bill_kardex_bodega', 
                                array('producto_id'=>$value->producto_id, 'bodega_id'=>$value->bodega_id), 
                                'kardex_ultimo', 
                                $alias_val = null, 
                                $empty_val = 0
                         );
                        
                        $new_k_ultimo = $kardex_ultimo + $value->kardex;
                        $new_kardex_bod = array(
                            'producto_id' => $value->producto_id,
                            'bodega_id' => $value->bodega_id,
                            'kardex' => $value->kardex,
                            'kardex_total' => $value->kardex_total,
                            'doc_id' => $value->doc_id,
                            'tipotransaccion_cod' => $value->tipotransaccion_cod,
                            'detalle' => $value->detalle.' CORRECCION ANULACIONES',
                            'fecha' => $value->fecha,
                            'hora' => $value->hora,
                            'estado' => $value->estado,
                        );

                        $this->generic_model->save($new_kardex_bod,'bill_kardex_bodega');

                        /* actualizamos kardex ultimo x bodega */
                        $this->generic_model->update( 
                                    'bill_kardex_bodega', 
                                    array('kardex_ultimo'=>$new_k_ultimo), 
                                    array('producto_id' => $value->producto_id,'bodega_id' => $value->bodega_id)
                                );                                        
                        $this->kardex_bodega->update_stock_bodega($value->producto_id, $value->bodega_id, $new_k_ultimo);
                    }
                }
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo info_msg(' Ocurrio un problema con la correccion');                
            }
            else
            {
                $this->db->trans_commit();
                echo info_msg(' El proceso de correccion ha finalizado');
            } 
            
        }
        
        
        

        
        public function cambiar_secuencia_anuladas(){
            $this->db->trans_begin();
                $facturas = $this->generic_model->get(
                        'billing_facturaventa', 
                        array('estado <'=>'0','puntoventaempleado_establecimiento'=>'001','puntoventaempleado_puntoemision'=>'006'), 
                        'codigofactventa', 
                        $order_by = array('codigofactventa'=>'asc'), 
                        $rows_num = 0, 
                        $or_like_data = null, 
                        $and_like_data = null, 
                        $group_by = null, 
                        $or_where = null 
                );

                print_r($facturas);

                $time = time();
                $secuencia = 1;
                $secuencia = $time.'.'.$secuencia;
                foreach ($facturas as $value) {
                    $this->generic_model->update( 'billing_facturaventa', array('secuenciafactventa'=>$secuencia), array('codigofactventa'=>$value->codigofactventa) );
                    $secuencia++;        
                }
                
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                echo info_msg(' Ocurrio un problema con la correccion');                
            }
            else
            {
                $this->db->trans_commit();
                echo info_msg(' El proceso de correccion ha finalizado');
            }
            
        }
        
        
        public function corregir_secuencia(){
            $facturas = $this->generic_model->get(
                    'billing_facturaventa', 
                    array('estado'=>'2','puntoventaempleado_establecimiento'=>'001','puntoventaempleado_puntoemision'=>'006'), 
                    'codigofactventa', 
                    $order_by = array('codigofactventa'=>'asc'), 
                    $rows_num = 0, 
                    $or_like_data = null, 
                    $and_like_data = null, 
                    $group_by = null, 
                    $or_where = null 
            );
            
            print_r($facturas);
            
            $secuencia = 1;
            foreach ($facturas as $value) {
                $this->generic_model->update( 'billing_facturaventa', array('secuenciafactventa'=>$secuencia), array('codigofactventa'=>$value->codigofactventa) );
                $secuencia++;        
            }
            
        }
}