<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Admin
        <small> Setting</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Jadwal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Setting <small> Jadwal</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <?=form_button('tambah', '<span class="fa fa-plus"></span> Tambah', 'class="btn btn-info" data-toggle="modal" data-target="#modal-jadwal"') ;?>
                            </div>
                        </div>
                        <div class="clearfix"></div><p/>
                        <div class="box box-info">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Dokter</th>
                                            <th>Klinik</th>
                                            <th>Layanan</th>
                                            <th>Hari</th>
                                            <th>Jam Mulai</th>
                                            <th>Jam Selesai</th>
                                            <th>Kouta Perjam</th>
                                            <th>Status</th>
                                            <th>Opsi</th>
                                        </tr>
                                        <?php 
                                        foreach($jadwal as $jadwal){ 
                                        ?>
                                        <tr>
                                            <td><?=$jadwal->id_jadwal;?></td>
                                            <td><?=$jadwal->nama_dokter;?></td>
                                            <td><?= $jadwal->nama_klinik;?></td>
                                            <td><?=$jadwal->jns_layan;?></td>
                                            <td><?=date('l', strtotime("Sunday +{$jadwal->id_hari} days"));?></td>
                                            <td><?=$jadwal->jam_mulai;?></td>
                                            <td><?=$jadwal->jam_selesai;?></td>
                                            <td><?=$jadwal->kuota_perjam;?></td>
                                            <td><?=array(0=>'OFF',1=>'ON')[$jadwal->status];?></td>
                                            <td>
                                                <button class="btn btn-xs btn-warning" onclick="editdata(<?=$jadwal->id_jadwal;?>)"><i class="fa fa-edit"></i> Edit</button>
                                                <a href="<?=base_url('admin/jadwal/?hapus='.$jadwal->id_jadwal);?>" onclick="return confirm('Yakin menghapus data ini ?')">
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
<div class="modal fade" id="modal-jadwal">
    <?=form_open($action, 'id="formjadwal" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jadwal Dokter</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-2">Dokter</label>
                    <div class="col-sm-4">
                        <?php
                        $option[''] = 'Pilih Dokter';
                        foreach ($dokter as $dok) {
                            $option[$dok->id_dokter] = $dok->nama_dokter;
                        }
                        echo form_dropdown('dokter', $option, '', 'class="form-control" required');?>
                    </div>  
                    <label class="control-label col-sm-2">Klinik</label>
                    <div class="col-sm-4">
                        <?php
                        unset($option);
                        $option[''] = 'Pilih Klinik';
                        foreach ($klinik as $poli) {
                            $option[$poli->id_klinik] = $poli->nama_klinik;
                        }
                        echo form_dropdown('klinik', $option, '', 'class="form-control" required');?>
                    </div>                  
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Layanan</label>
                    <div class="col-sm-4">
                        <?php
                        unset($option);
                        $option[''] = 'Pilih Layanan';
                        foreach ($jnslayan as $layan) {
                            $option[$layan->id_jns_layan] = $layan->jns_layan;
                        }
                        echo form_dropdown('jnslayan', $option, '', 'class="form-control" required');?>
                    </div>
                    <label class="control-label col-sm-2">Hari</label>
                    <div class="col-sm-4">
                        <?php
                        unset($option);
                        $option[''] = 'Pilih Hari';
                        for($i=0;$i<7;$i++) {
                            $option[$i] = date('l', strtotime("Sunday +{$i} days"));
                        }
                        echo form_dropdown('hari', $option, '', 'class="form-control" required');?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Mulai</label>
                    <div class="col-sm-3">
                        <?= form_input(array('name'=>'mulai','type'=>'time','id'=>'mulai'), '', 'class="form-control" required')?>
                    </div>
                    <label class="control-label col-sm-2 col-sm-offset-1">Selesai</label>
                    <div class="col-sm-3">
                        <?= form_input(array('name'=>'selesai','type'=>'time','id'=>'selesai'), '', 'class="form-control" required')?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Kuota</label>
                    <div class="col-sm-3">
                        <?=form_input(array('name'=>'kuota','id'=>'kuota','type'=>'number'), '', 'class="form-control" required');?>
                    </div>
                    <label class="control-label col-sm-2 col-sm-offset-1">Status</label>
                    <div class="col-sm-3">
                        <?php
                        $option= array(''=>'Status',1=>'ON',0=>'OFF');
                        echo form_dropdown('status', $option, '', 'class="form-control" required');
                        ?>
                    </div>
                </div>
                <?=form_input(array('name'=>'edit','id'=>'edit','type'=>'hidden'), FALSE);?>
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
    function editdata(id) {
        $.ajax({
            url : "<?php echo site_url('admin/ajaxjadwal/')?>"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('select[name=dokter]').val(data.id_dokter);
                $('select[name=klinik]').val(data.id_klinik);
                $('select[name=jnslayan]').val(data.jnslayan);
                $('select[name=status]').val(data.status);
                $('select[name=hari]').val(data.id_hari);
                $('#mulai').val(data.jam_mulai);
                $('#selesai').val(data.jam_selesai);
                $('#kuota').val(data.kuota_perjam);
                $('#edit').val(data.id_jadwal);
                $("#modal-jadwal").modal();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error : Masukkan data secara urut..!');
            }
        }); 
    };
</script>