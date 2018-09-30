<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Report
            <small>Registrasi Online</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/');?>"><i class="fas fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Data Chart</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Reservasi <small> Grafik</small></h3>
                    </div>
                    <div class="box-body">
                        <?=form_open('admin/reservasi', 'method="GET" class="form-horizontal'); ?>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Res. Date</label>
                            <div class="col-sm-3">
                                <?=form_input(array('name'=>'filtglres','type'=>'text'),'','class="form-control"');?>
                            </div>
                            <div class="col-sm-2">                                        
                                <?=form_button(array('name'=>'view','type'=>'submit'), '<span class="fa fa-eye"></span> View', 'class="btn btn-primary"');?>
                            </div>
                            <?php echo form_input(['name'=>'start','id'=>'start','type'=>'hidden']);
                                echo form_input(['name'=>'stop', 'id'=>'stop','type'=>'hidden']);
                            ?>
                        </div>
                        <?=form_close();?>
                        <div class="clearfix"></div><p/>
                        <div class="box box-info">
                            <div class="box-header with-border"></div>
                            
                            
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function() {
        $('input[name="filtglres"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            $("#start").val(start.format('YYYY-MM-DD'));
            $("#stop").val(end.format('YYYY-MM-DD'));
        });
    });
</script>