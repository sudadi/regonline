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
            <li class="active">Klinik</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Setting <small> Data Klinik</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <?=form_button('tambah', '<span class="fa fa-plus"></span> Tambah', 'class="btn btn-info" onclick="return tambahklinik();"') ;?>
                            </div>
                        </div>
                        <div class="clearfix"></div><p/>
                        <div class="box box-info">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Klinik</th>
                                            <th>Kuota per Jam</th>
                                            <th>Status</th>
                                            <th>Opsi</th>
                                        </tr>
                                        <?php 
                                        //$no = $this->uri->segment('3') + 1;
                                        foreach($dataklinik as $klinik){ 
                                        ?>
                                        <tr onclick="isidata(this);">
                                            <td><?=$klinik->id_klinik;?></td>
                                            <td><?=$klinik->nama_klinik;?></td>
                                            <td><?=$klinik->kuota;?></td>
                                            <td><?=$klinik->status ? '<span class="btn-xs btn-success">Aktif</span>':'<span class="btn-xs btn-default">Non Aktif</span>';?></td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#modal-klinik"><span class="btn btn-xs btn-warning"><i class="fa fa-edit "></i> Edit</span></a>
                                                <a href="<?=base_url('admin/dataklinik/?hapus='.$klinik->id_klinik);?>" onclick="return confirm('Yakin menghapus data ini ?')">
                                                    <span class="btn btn-xs btn-danger"><i class="fa fa-trash "></i> Hapus</span></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <?php echo $this->pagination->create_links();?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-klinik">
    <?=form_open($action, 'id="formreserv" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Clinic</h4>
            </div>
            <div class="modal-body">
                <p><?php echo "Please enter the clinic's information below.";?></p>
                <div class="form-group">
                    <label class="control-label col-sm-3">ID</label>
                    <div class="col-sm-4">
                        <?=form_input(array('name'=>'idklinik','id'=>'idklinik'), '', 'class="form-control" required');?>
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Clinic Name</label>
                    <div class="col-sm-8">
                        <?=form_input(array('name'=>'nmklinik','id'=>'nmklinik'), '', 'class="form-control" required');?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Quota</label>
                    <div class="col-sm-8">
                        <?=form_input(array('name'=>'kuota','id'=>'kuota'), '', 'class="form-control" required');?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Status</label>
                    <div class="col-sm-4">
                        <?php
                        echo form_dropdown(array('name'=>'status','id'=>'status'), array('1'=>'Aktif','0'=>'Non Aktif'),'1', 'class="form-control" required');?>
                    </div>
                </div>
                <?=form_input(array('name'=>'edit','id'=>'edit','type'=>'hidden'),false);?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
    <?=form_close();?>
</div>
<script>
    function isidata(row){
        var x=row.cells;
        var status=x[3].innerHTML;
        if (status === 'Aktif') {
            status = 1;
        }else{
            status = 0;
        }
        $('#idklinik').val(x[0].innerHTML);
        $('#nmklinik').val(x[1].innerHTML);
        $('#kuota').val(x[2].innerHTML);
        $('#status select').val(status);
        $('#edit').val(true);
        $(".modal-title").text("Edit Clinic Data");
    }
    function tambahklinik(){
        $('#idklinik').val('');
        $('#nmklinik').val('');
        $('#kuota').val('');
        $('#status').val(1);
        $('#edit').val('');
        $(".modal-title").text("Add New Clinic");
        $('#modal-klinik').modal();
    }
</script>