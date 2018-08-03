<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Admin
            <small>Setting</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">[Auto] SMS Konfirmasi</h3>
                    </div>
                    <div class="box-body">
                        <p> 
                            <strong>FORMAT : </strong>Format sms konfirmasi dapat berisi parameter ([norm], [nama], [resno], [reswaktu], [respoli], [resdokter], [reslayan], [resjamin]).
                        </p>
                        <?=form_open('admin/genset', array('role'=>'form')) ;?>
                        <div class="form-group col-sm-8">
                            <label for="fmtkonfirm">Format</label>
                            <div class="">
                                <?=form_textarea(array('name'=>'fmtkonfirm','id'=>'fmtkonfirm', 'rows'=>'2'), $smskonfirm->format, 'class="form-control" required');?>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="smtkonfirm" class="col-xs-12">&nbsp;</label>
                            <button type="submit" name="smtkonfirm" id="smtkonfirm" value="true" class="btn btn-default"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                        <?=form_close();?>
                    </div>
                </div>
            
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">[Auto-Reply] SMS Masking</h3>
                    </div>
                    <div class="box-body">
                        <p> 
                            <strong>PREFIX : </strong>Awalan sms (Reg / Info dsb)<br/>
                            <strong>ARGUMENT : </strong>norm, id_dokter, id_klinik, id_jns_layan.
                        </p>
                        <div class="col-sm-12">
                            <div class="table-responsive no-padding">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Prefix</th>
                                            <th>Argument</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>                                        
                            </div>
                        </div>
                    </div>
                </div>            
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Template SMS</h3>
                    </div>
                    <div class="box-body">
                        <?=form_open('admin/genset', array('role'=>'form')) ;?>
                        <div class="form-group col-sm-6">
                            <label for="txttpl">Text Template</label>
                            <div class="">
                                <?= form_textarea(array('name'=>'texttpl','id'=>'texttpl', 'rows'=>'2'), NULL, 'class="form-control" required');?>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="" for="nmtpl">Nama</label>
                            <div class="">
                                <?=form_input(array('name'=>'nmtpl','id'=>'nmtpl'), $nmtpl=NULL, 'class="form-control" required');?>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="submit" class="col-xs-12">&nbsp;</label>
                            <button type="submit" id="smttpl" id="smttpl" class="btn btn-default"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                        <?=form_close();?>
                        <div class="col-sm-12">
                            <div class="table-responsive no-padding">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Text Template</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>                                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Modem Routing</h3>
                    </div>
                    <div class="box-body">
                        <p> 
                            <strong>PREFIX : </strong>Awalan sms (0812, 0899, 0856, ...)<br/>
                            <strong>MODEM : </strong>Modem yang di digunakan.
                        </p>
                        <?=form_open('admin/genset', array('role'=>'form')) ;?>
                        <div class="form-group col-sm-6">
                            <label for="premodem">Prefix</label>
                            <div class="">
                                <?=form_input(array('name'=>'premodem','id'=>'premodem',), NULL, 'class="form-control" required');?>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="" for="modem">Modem</label>
                            <div class="">
                                <?php 
                                $option=array(''=>'-Pilih Modem-','Modem1'=>'Modem1','Modem2'=>'Modem2','Modem3'=>'Modem3','Modem4'=>'Modem4','Modem5'=>'Modem5');
                                echo form_dropdown('modem', $option, '', 'id="modem" class="form-control" required');?>
                            </div>
                        </div>
                        <?=form_input(array('name'=>'editmodem','type'=>'hidden','id'=>'editmodem'));?>
                        <div class="form-group col-sm-2">
                            <label for="smtmodem" class="col-xs-12">&nbsp;</label>
                            <button type="submit" name="smtmodem" id="smtmodem" value="true" class="btn btn-default"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                        <?=form_close();?>
                        <div class="col-sm-12">
                            <div class="table-responsive no-padding">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Prefix No. GSM</th>
                                            <th>Modem</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($rtmodem as $modem) { ?>
                                        <tr>
                                            <td><?=$modem->id;?></td>
                                            <td><?=$modem->prefix;?></td>
                                            <td><?=$modem->modem;?></td>
                                            <td class="text-nowrap">
                                                <button class="btn btn-xs btn-warning" value="<?=$modem->id;?>" onclick="modemedit(this);"><i class="fa fa-edit "></i> Edit</button>&nbsp;
                                                <a href="<?=base_url('admin/genset/?delmodem='.$modem->id);?>" onclick="return confirm('Yakin menghapus data ini ?')">
                                                    <span class="btn btn-xs btn-danger"><i class="fa fa-trash "></i> Hapus</span></a>
                                            </td>
                                        </tr>                                            
                                        <?php } ?>
                                    </tbody>
                                </table>                                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
function modemedit(x){
    var prefix = $(x).closest('tr').children('td:eq(1)').text();  
    var modem = $(x).closest('tr').children('td:eq(2)').text();
    var id = $(x).closest('tr').children('td:eq(0)').text();
    $("#premodem").val(prefix);
    $("#modem").val(modem).change();
    $("#editmodem").val(id);
    $("#smtmodem").html('<i class="fa fa-save"></i> Update');
    return false;
};

$(document).ready(function() {
    
});
</script>