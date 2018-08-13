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
            <li><a href="<?= base_url('admin/');?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Laporan</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reservasi <small> SMS/WA</small></h3>
                    </div>
                    <div class="box-body">
                        <?=form_open('admin/reservasi', 'method="GET" class="form-horizontal'); ?>
                        <div class="form-group">
                            <label class="control-label col-sm-1">Tgl. Res.</label>
                            <div class="col-sm-2">
                                <?=form_input(array('name'=>'filtglres','type'=>'date'),'','class="form-control"');?>
                            </div>
                            <div class="col-sm-2">                                        
                                <?=form_button(array('name'=>'view','type'=>'submit'), '<span class="fa fa-eye"></span> View', 'class="btn btn-primary"');?>
                            </div>
                        </div>
                        <?=form_close();?>
                        <div class="clearfix"></div><p/>
                        <div class="box box-info">
                            <div class="box-header with-border"></div>
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover" id="dttable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>No. RM</th>
                                            <th>Nama</th>
                                            <th>No. Telp</th>
                                            <th>TL</th>
                                            <th>Klinik</th>
                                            <th>Dokter</th>
                                            <th>Jaminan</th>
                                            <th>Layanan</th>
                                            <th>Reservasi</th>
                                            <th>Kode</th>
                                            <th>Urut</th>
                                            <th>Update</th>
                                            <th>Status</th>
                                            <th>Sync</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        //$no = $this->uri->segment('3') + 1;
                                        foreach($datares as $res){ 
                                        ?>
                                        <tr>
                                            <td><?=$res->id_rsv;?></td>
                                            <td><?=$res->norm;?></td>
                                            <td class="text-nowrap"><?=$res->nama;?></td>
                                            <td><?=$res->tgl_lahir;?></td>
                                            <td><?=$res->nama_klinik;?></td>
                                            <td><?=$res->notelp;?></td>
                                            <td class="text-nowrap"><?=$res->nama_dokter;?></td>
                                            <td><?=$res->nama_jaminan;?></td>
                                            <td><?=$res->jns_layan;?></td>
                                            <td><?=$res->waktu_rsv;?></td>
                                            <td><?=$res->nores;?></td>
                                            <td><?=$res->nourut;?></td>
                                            <td><?=$res->first_update;?></td>
                                            <td><?php
                                                $status=array(0=>'Disable',1=>'Active',2=>'Checkin',3=>'Cancel By System',4=>'Cancel By User'); ?>
                                                <span class="btn btn-xs <?=($res->status==1) ? 'btn-success':'btn-default';?> status" title="Update Status"><?=$status[$res->status];?></span>
                                            </td>
                                            <td><span class="btn btn-xs btn-info"><?=$res->sync?'True':'False';?></span></td>
                                            <td class="text-nowrap">
                                                <a href="#" onclick="editdata(<?=$res->id_rsv;?>)"><span class="btn btn-xs btn-warning"><i class="fa fa-edit "></i> Edit</span></a>
                                                <a href="<?=base_url('admin/reservasi/?hapus='.$res->id_rsv);?>" onclick="return confirm('Yakin menghapus data ini ?')">
                                                    <span class="btn btn-xs btn-danger"><i class="fa fa-trash "></i> Delete</span></a>
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