<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Index extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->user->check_session();
        set_time_limit(0);
    }

    function index() {
        $res['view'] = $this->load->view('correcciones', '', TRUE);
        $res['slidebar'] = $this->load->view('slidebar', '', TRUE);
        $this->load->view('templates/dashboard', $res);
    }

    function corregir_cxc_saldos() {
        $this->load->library('common/cuentasxcobrar');
        /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
        $cxc_saldo_ultimo = $this->generic_model->get_data('bill_cxc', array('id >' => 0), $fields = 'client_id, saldo_ultimo', null, 0, 'client_id');

        foreach ($cxc_saldo_ultimo as $value) {
            $this->cuentasxcobrar->update_cxc_saldos($value->client_id, $value->saldo_ultimo);
        }
        echo success_msg('Correccion Finalizada');
    }

    function corregir_cxp_saldos() {
        $this->load->library('common/cuentasxpagar');
        /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
        $cxp_saldo_ultimo = $this->generic_model->get_data('bill_cxp', array('id >' => 0), $fields = 'proveedor_id, saldo_ultimo', null, 0, 'proveedor_id');

        foreach ($cxp_saldo_ultimo as $value) {
            $this->cuentasxpagar->update_cxp_saldos($value->proveedor_id, $value->saldo_ultimo);
        }
        echo success_msg('Correccion Finalizada');
    }

    function corregir_anticipocliente_saldos() {
        $this->load->library('common/cliente_anticipo');
        /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
        $cxc_saldo_ultimo = $this->generic_model->get_data('bill_cliente_anticipo', array('id >' => 0), $fields = 'client_id, saldo_ultimo', null, 0, 'client_id');

        foreach ($cxc_saldo_ultimo as $value) {
            $this->cliente_anticipo->update_anticipo_saldos($value->client_id, $value->saldo_ultimo);
        }
        echo success_msg('Correccion Finalizada');
    }

    function corregir_anticipoproveedor_saldos() {
        $this->load->library('proveedor_anticipo');
        /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
        $cxc_saldo_ultimo = $this->generic_model->get_data('bill_proveedor_anticipo', array('id >' => 0), $fields = 'proveedor_id, saldo_ultimo', null, 0, 'proveedor_id');

        foreach ($cxc_saldo_ultimo as $value) {
            $this->proveedor_anticipo->update_anticipo_saldos($value->proveedor_id, $value->saldo_ultimo);
        }
        echo success_msg('Correccion Finalizada');
    }

    function corregir_costo_inventario_xproducto() {
        $this->load->library('common/product');
        /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
        $cxc_saldo_ultimo = $this->generic_model->get_data('bill_kardex', array('id >' => 0), $fields = 'producto_id, costo_inv_product_ultimo', null, 0, 'producto_id');

        foreach ($cxc_saldo_ultimo as $value) {
            $this->product->update_costo_inventario($value->producto_id, $value->costo_inv_product_ultimo);
        }
        echo success_msg('Correccion Finalizada');
    }

    function corregir_costo_inventario_total() {
        $this->load->library('common/empresaindice');
        /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
        $res = $this->generic_model->get_data('bill_kardex', array('estado' => 1), $fields = 'costo_inventario_ultimo', null, 1);

        $this->empresaindice->update_indice('COSTO_INVENTARIO', $res->costo_inventario_ultimo);

        echo success_msg('Correccion Finalizada');
    }

    function corregir_utilidad_venta_bienes() {
        $this->load->library('common/ventautilidad');
        /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
        $utilidad = $this->generic_model->get_data(
                'bill_kardex', array('transaccion_cod' => '01', 'doc_id_ajuste' => null, 'estado >' => 0), $fields = 'docid,costo_prom_total, precio_venta_total, utilidad_venta', null, 0
        );

        foreach ($utilidad as $value) {
            $this->ventautilidad->save_utilidad_venta($value->docid, $value->costo_prom_total, $value->precio_venta_total, 0, '01');
        }

        echo success_msg('Correccion Finalizada');
    }

    function corregir_utilidad_venta_servicios() {
        $this->load->library('common/ventautilidad');
        /* Obtenemos saldo_ultimo por cliente para actualizarlos en la nueva tabal bill_cxc_saldos */
        $utilidad = $this->generic_model->get_data(
                'billing_facturaventa', array('estado >' => 0, 'subtnetoservicios >' => 0), $fields = 'codigofactventa, subtnetoservicios', null, 0
        );

        foreach ($utilidad as $value) {
            $this->ventautilidad->save_utilidad_venta($value->codigofactventa, 0, 0, $value->subtnetoservicios, '01');
        }

        echo success_msg('Correccion Finalizada');
    }

    public function corregir_costo_venta() {
        $this->load->library('common/facturaventa_data');
        $this->load->library('common/asientocontable');
        $this->load->library('common/contaconfigcuentas');
        $this->load->library('common/product');
        $this->load->library('common/ventautilidad');
        $this->load->library('common/kardex');

        /* eliminamos los asientos contables de costo de venta que estan */
        $this->generic_model->delete('bill_asiento_contable_det', array('tipotransaccion_cod' => '25'));
        $this->generic_model->delete('bill_asiento_contable', array('tipotransaccion_cod' => '25'));
        $this->generic_model->delete('bill_venta_utilidad', array('tipotransaccion_cod' => '01'));

        $facturas = $this->generic_model->get_data(
                'billing_facturaventa', array('estado' => '2', 'puntoventaempleado_tiposcomprobante_cod' => '01'), 'codigofactventa'
        );

        foreach ($facturas as $venta) {
            $res = $this->save_ac_costo_venta($venta->codigofactventa);
        }

        if ($res > 0) {
            echo success_info_msg(' Correccion de Costo de Venta Completado');
        }
    }

    /* Registrar el asiento ocntable de costo de venta */

    private function save_ac_costo_venta($venta_id) {
        $detalle_venta = $this->facturaventa_data->obtener_detalle_factura($venta_id);

        $tot_costo_venta = 0;
        $tot_pvp_bienes = 0;
        $tot_pvp_servicios = 0;
        foreach ($detalle_venta as $val) {
            $product_data = $this->product->get_product_data($val->Producto_codigo);

            /* El costo de venta es solo para inventario no para servicios */
            if ($product_data->esServicio == 0) {
                $costo_prom_total = $this->kardex->get_costo_prom_total($val->Producto_codigo, '01', $venta_id);
//                $tot_costo_venta += $product_data->costopromediokardex * $val->itemcantidad;
                $tot_costo_venta += $costo_prom_total;
                $tot_pvp_bienes += $val->itemprecioxcantidadneto;
            } elseif ($product_data->esServicio == 1) {
                $tot_pvp_servicios += $val->itemprecioxcantidadneto;
            }
        }

        if ($tot_costo_venta > 0) {
            /* 25 = Costo Venta */
            $ac_id = $this->asientocontable->save_ac('25', $venta_id, 'COSTO VENTA');

            $cta_costo_venta = $this->contaconfigcuentas->get_setting_account('037');
            $cta_inventario = $this->contaconfigcuentas->get_setting_account('021');
            /*
             * entra costo de venta, sale inventario
             */
            $asiento_det_data = array(
                'asiento_contable_id' => $ac_id,
                'cuenta_cont_id' => $cta_costo_venta,
                'debito' => $tot_costo_venta,
                'credito' => 0,
                'tipotransaccion_cod' => '25',
                'doc_id' => $venta_id,
                'detalle' => 'COSTO VENTA, ENTRA C.V.',
            );
            $ac_det_id = $this->generic_model->save($asiento_det_data, 'bill_asiento_contable_det');

            $asiento_det_data = array(
                'asiento_contable_id' => $ac_id,
                'cuenta_cont_id' => $cta_inventario,
                'debito' => 0,
                'credito' => $tot_costo_venta,
                'tipotransaccion_cod' => '25',
                'doc_id' => $venta_id,
                'detalle' => 'COSTO VENTA, SALE INVENTARIO',
            );
            $ac_det_id = $this->generic_model->save($asiento_det_data, 'bill_asiento_contable_det');
        }

        $res = $this->ventautilidad->save_utilidad_venta($venta_id, $tot_costo_venta, $tot_pvp_bienes, $tot_pvp_servicios, '01'); /* Tipo transaccion 01 = venta */
        return $res;
    }

    function reset_cuentas() {
        /*
         * DELETE FROM bill_cuentabancaria WHERE tipo_id!=4;
         */
        $where_clause = array('tipo_id !=' => '4');
        $this->generic_model->delete('bill_cuentabancaria', $where_clause);
        echo '<br>Eliminados movimientos bancarios, excepto saldos iniciales';
        $this->update_saldos();
    }

    /* Funcion para actualizar los saldos en bill_cuentabancaria_saldos a saldo inicial */

    function update_saldos() {
        /*
         * UPDATE bill_cuentabancaria_saldos cs
          SET saldo =
          (
          SELECT cta.saldo
          FROM bill_cuentabancaria cta
          WHERE cta.tipo_id = 4 AND  cta.banco_id = cs.banco_id
          )
         */



        $saldo = $this->generic_model->get_val_where('bill_cuentabancaria cta', array('cta.banco_id' => 'cs.banco_id'), 'saldo');
        
        $where_data = null;
        $table_name = 'bill_cuentabancaria_saldos cs';
        $data_set = array('saldo1 ' => $saldo);
        $this->generic_model->update($table_name, $data_set, $where_data);

        echo '<br>Saldos de cuentas actualizados a saldos iniciales';
    }

}
