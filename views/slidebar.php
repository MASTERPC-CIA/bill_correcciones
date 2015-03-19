        <div class="navbar-defaults sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <?php
//                            echo $this->load->view('login/user_logo','',TRUE);
                        ?>
                    </li>

                    <li>
                        <a class="active" href="<?= base_url('inventario/index')?>"><i class="glyphicon glyphicon-th fa-fw"></i> Inventarios</a>
                    </li>
                    <li>
                        <a href="<?= base_url('inventario/inventario')?>"><i class="glyphicon glyphicon-list-alt fa-fw"></i> Reporte Inventario</a>
                    </li>
                    <li>
                        <a href="<?= base_url('inventario/inventario_bod')?>"><i class="glyphicon glyphicon-list-alt fa-fw"></i> Inventario Bodega</a>
                    </li>
                    <li>
                        <a href="<?= base_url('inventario/kardex')?>"><i class="glyphicon glyphicon-list fa-fw"></i> Kardex</a>
                    </li>
                    <li>
                        <a href="<?= base_url('inventario/kardex_bod')?>"><i class="glyphicon glyphicon-list fa-fw"></i> Kardex Bodega</a>
                    </li>
                    <li>
                        <a class="active" href="<?= base_url('ajustentrada/ajustentrada/view')?>"><i class="glyphicon glyphicon-retweet fa-fw"></i> Aj. Entrada</a>
                    </li>
                    <li>
                        <a class="active" href="<?= base_url('ajustesalida/index')?>"><i class="glyphicon glyphicon-new-window fa-fw"></i> Aj. Salida</a>
                    </li>

                </ul>
            </div>
                        <!-- /.sidebar-collapse -->
        </div>
            <!-- /.navbar-static-side -->