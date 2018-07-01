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
            <li><a href="<?=base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Dokter</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Setting <small> Data Dokter</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <?=form_button('tambah', '<span class="fa fa-plus"></span> Tambah', 'class="btn btn-info" onclick="return tambahdr();"') ;?>
                            </div>
                        </div>
                        <div class="clearfix"></div><p/>
                        <div class="box box-info">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Opsi</th>
                                        </tr>
                                        <?php 
                                        //$no = $this->uri->segment('3') + 1;
                                        foreach($datadr as $dokter){ 
                                        ?>
                                        <tr onclick="isidata(this);">
                                            <td><?=$dokter->id_dokter;?></td>
                                            <td><?=$dokter->nama_dokter;?></td>
                                            <td><?=$dokter->status ? '<span class="btn-xs btn-success">Aktif</span>':'<span class="btn-xs btn-default">Non Aktif</span>';?></td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#modal-dokter"><span class="btn btn-xs btn-warning"><i class="fa fa-edit "></i> Edit</span></a>
                                                <a href="<?=base_url('admin/datadok/?hapus='.$dokter->id_dokter);?>" onclick="return confirm('Yakin menghapus data ini ?')">
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
<div class="modal fade" id="modal-dokter">
    <?=form_open($action, 'id="formreserv" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Data Dokter</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-2">ID</label>
                    <div class="col-sm-4">
                        <?=form_input(array('name'=>'iddr','id'=>'iddr'), '', 'class="form-control" required');?>
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Nama</label>
                    <div class="col-sm-10">
                        <?=form_input(array('name'=>'namadr','id'=>'namadr'), '', 'class="form-control" required');?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Status</label>
                    <div class="col-sm-4">
                        <?php
                        echo form_dropdown(array('name'=>'status','id'=>'status'), array('1'=>'Aktif','0'=>'Non Aktif'),'1', 'class="form-control" required');?>
                    </div>
                </div>
                <?=form_input(array('name'=>'edit','id'=>'edit'),true);?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
    <?=form_close();?>
</div>
<script>
    function isidata(row){
        var x=row.cells;
        var status=x[2].innerHTML;
        if (status === 'Aktif') {
            status = 1;
        }else{
            status = 0;
        }
        $('#iddr').val(x[0].innerHTML);
        $('#namadr').val(x[1].innerHTML);
        $('#status select').val(status);
    }
    function tambahdr(){
        $('#iddr').val('');
        $('#namadr').val('');
        $('#status').val(1);
        $('#edit').val('');
        $('#modal-dokter').modal();
    }
</script>