<?php
$css = array(
    base_url('resources/bootstrap-3.2.0/css/bootstrap.min.css'),
    base_url('resources/sb_admin/css/plugins/metisMenu/metisMenu.min.css'),
    base_url('resources/sb_admin/css/sb-admin-2.css'),
    base_url('resources/sb_admin/font-awesome-4.1.0/css/font-awesome.min.css'),    
    base_url('resources/bootstrap-3.2.0/css/bootstrap-theme.css'),
    base_url('resources/js/libs/combobox/css/bootstrap-combobox.css'),    
    base_url('assets/grocery_crud/css/ui/simple/jquery-ui-1.10.1.custom.min.css'),   
    base_url('assets/grocery_crud/themes/datatables/css/demo_table_jui.css'),
    base_url('assets/grocery_crud/themes/datatables/css/datatables.css'),
    base_url('assets/grocery_crud/themes/datatables/css/jquery.dataTables.css'),
    base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'),
    base_url('resources/css/datepicker.css'),
    base_url('resources/js/libs/sco.js/css/scojs.css'),
    base_url('resources/js/libs/sco.js/css/sco.message.css'),
    base_url('resources/js/libs/jsPanel-bootstrap/source/jsPanel.css'),
    base_url('resources/js/libs/autosuggest/css/style.css')
);
echo csslink($css);

$js = array(
//    base_url('resources/sb_admin/js/jquery.js'),
    base_url('assets/grocery_crud/js/jquery-1.10.2.min.js'),
    base_url('assets/grocery_crud/js/jquery_plugins/jquery.noty.js'),
    base_url('assets/grocery_crud/js/jquery_plugins/config/jquery.noty.config.js'),
    base_url('assets/grocery_crud/js/common/lazyload-min.js'),
    base_url('assets/grocery_crud/js/common/list.js'),
    base_url('assets/grocery_crud/themes/datatables/js/jquery.dataTables.min.js'),
    base_url('assets/grocery_crud/themes/datatables/js/datatables-extras.js'),
    base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js'),
    base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.min.js'),
    base_url('assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js'),    
    base_url('resources/bootstrap-3.2.0/js/bootstrap.min.js'),
    base_url('resources/js/comunes/printThis.js'),
    base_url('resources/js/libs/sco.js/js/sco.valid.js'),
    base_url('resources/js/libs/sco.js/js/sco.modal.js'),
    base_url('resources/js/libs/sco.js/js/sco.message.js'),
    base_url('resources/js/libs/sco.js/js/sco.ajax.js'),
    base_url('resources/js/libs/jform/jquery.form.js'),
    base_url('resources/js/bootstrap-datepicker.js'),
    base_url('resources/js/bootstrap-datepicker.es.js'),
    base_url('resources/js/libs/autosuggest/bootstrap-typeahead.js'),
    base_url('resources/js/libs/autosuggest/hogan-2.0.0.js'),
    base_url('resources/js/libs/jsPanel/source/AC_RunActiveContent.js'),
    base_url('resources/js/libs/jsPanel-bootstrap/source/jquery.jspanel.bs-1.4.0.min.js'),              
    base_url('resources/js/libs/combobox/js/bootstrap-combobox.js'),
    base_url('resources/js/modules/comunes.js'),
    base_url('resources/sb_admin/js/plugins/metisMenu/metisMenu.min.js'),
    base_url('resources/sb_admin/js/sb-admin-2.js'),
);
echo jsload($js);

$res['module_title'] = 'Inventario';
$this->load->view('templates/navigation.php',$res);    

echo Open('body',array('style'=>'padding-top:60px'));  
    echo Open('div', array('id'=>'page-wrapper'));
        $title_page = 'Billingsof v1.01';

        if(!empty($title)){
            $title_page = $title;
        }
        echo Open('div', array('class'=>'row'));
            echo tagcontent('div', tagcontent('strong', $title_page, array('class'=>'page-header')), array('class'=>'col-md-12','style'=>'font-size:18px; margin-bottom:25px'));
        echo Close('div'); //cierra div .row
    //    echo LineBreak2(1, array('class'=>'clr'));
        echo Open('div', array('class'=>'row','id'=>'container-fluid'));
                echo $view;   
        echo Close('div'); //cierra div .row
    echo Close('div'); //cierra page-wrapper
echo Close('div');    

?>
<script>    
     var main_path = "<?= base_url()?>";
    $(function() {
        printelem();
        $.loadAjaxPanel();
        loadFormAjax();   
        $.load_datepicker();
//        $.loadAjaxPanel();
        $.loadAjaxPanel('#ajaxpanelbtnstock_bod',{ width: 320, height: 220 }, {top: 150, left: 300});
        $.loadAjaxPanel('#ajaxpanelbtnproductget',{ width: '98%', height: 450 }, {top: 150, left: 10});
    });

</script>