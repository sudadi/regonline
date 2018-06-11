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
        <li class="active">Libur</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Setting <small> Hari Libur</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <?=form_button('tambah', '<span class="fa fa-plus"></span> Tambah', 'class="btn btn-info" data-toggle="modal" data-target="#modal-addlibur"') ;?>
                            </div>
                        </div>
                        <div class="clearfix"></div><p/>
                        <div class="box box-info">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Opsi</th>
                                        </tr>
                                        <?php 
                                        //$no = $this->uri->segment('3') + 1;
                                        foreach($dtlibur as $libur){ 
                                        ?>
                                        <tr>
                                            <td><?=$libur->id_libur;?></td>
                                            <td><?=$libur->tanggal;?></td>
                                            <td><?= $libur->status ? '<span class="btn btn-xs btn-success">Aktif</span>':'<span class="btn btn-xs btn-default">Non Aktif</span>';?></td>
                                            <td><?=$libur->ket;?></td>
                                            <td>
                                                <a href="<?=base_url('admin/libur/?edit='.$libur->id_libur);?>"><span class="btn btn-xs btn-warning"><i class="fa fa-edit "></i> Edit</span></a>
                                                <a href="<?=base_url('admin/libur/?hapus='.$libur->id_libur);?>" onclick="return confirm('Yakin menghapus data ini ?')">
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
<div class="modal modal-info fade" id="modal-addlibur">
    <?=form_open($action, 'id="formreserv" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Tanggal Libur</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-2">Tgl.</label>
                    <div class="col-sm-4">
                        <?=form_input(array('name'=>'tgl','type'=>'date'), '', 'class="form-control" required');?>
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Ket.</label>
                    <div class="col-sm-10">
                        <?=form_input('ket', '', 'class="form-control" required');?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    <?=form_close();?>
</div>