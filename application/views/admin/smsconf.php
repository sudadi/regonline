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
            <div class="col-sm-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">[Auto] SMS Konfirmasi</h3>
                    </div>
                    <div class="box-body">
                        <p> 
                            <strong>FORMAT : </strong>Format sms konfirmasi dapat berisi type specifier (%).<br/>
                            <strong>ARGUMENT : </strong>nores, waktu_rsv, nourut, kode_cekin, norm, nama, nama_dokter, nama_klinik, jns_layan.
                        </p>
                        <?=form_open('admin/smsconf', array('role'=>'form')) ;?>
                        <div class="form-group col-sm-6">
                            <label for="fmtkonfim">Format</label>
                            <div class="">
                                <?=form_textarea(array('name'=>'fmtkonfim','id'=>'fmtkonfim', 'rows'=>'2'), $fmtkonfim=NULL, 'class="form-control" required');?>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="" for="argkonfirm">Argument</label>
                            <div class="">
                                <?=form_input(array('name'=>'argkonfirm','id'=>'argkonfirm'), $arg=NULL, 'class="form-control" required');?>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="smtkonfirm" class="col-xs-12">&nbsp;</label>
                            <button type="submit" name="smtkonfirm" id="smtkonfirm" class="btn btn-default"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                        <?=form_close();?>
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
                        <?=form_open('admin/smsconf', array('role'=>'form')) ;?>
                        <div class="form-group col-sm-7">
                            <label for="premodem">Prefix</label>
                            <div class="">
                                <?=form_input(array('name'=>'premodem','id'=>'premodem',), $premask=NULL, 'class="form-control" required');?>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="" for="modem">Modem</label>
                            <div class="">
                                <?=form_dropdown('modem', $option=NULL, '', 'class="form-control" required');?>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="sbtmodem" class="col-xs-12">&nbsp;</label>
                            <button type="submit" id="smtmodem" class="btn btn-default"><i class="fa fa-save"></i> Simpan</button>
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
                        <h3 class="box-title">[Auto-Reply] SMS Masking</h3>
                    </div>
                    <div class="box-body">
                        <p> 
                            <strong>PREFIX : </strong>Awalan sms (Reg / Info dsb)<br/>
                            <strong>ARGUMENT : </strong>norm, id_dokter, id_klinik, id_jns_layan.
                        </p>
                        <?=form_open('admin/smsconf', array('role'=>'form')) ;?>
                        <div class="form-group col-sm-3">
                            <label for="premask">Prefix</label>
                            <div class="">
                                <?=form_input(array('name'=>'premask','id'=>'premask',), $premask=NULL, 'class="form-control" required');?>
                            </div>
                        </div>
                        <div class="form-group col-sm-7">
                            <label class="" for="format">Argument</label>
                            <div class="">
                                <?=form_input(array('name'=>'argmask','id'=>'argmask'), $argmask=NULL, 'class="form-control" required');?>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="submit" class="col-xs-12">&nbsp;</label>
                            <button type="submit" id="smtmask" class="btn btn-default"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                        <?=form_close();?>
                    </div>
                </div>
            </div>                        
        </div>
    </section>
</div>
