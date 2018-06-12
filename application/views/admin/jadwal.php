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
                                            <td><?=$jadwal->jnslayan;?></td>
                                            <td><?=$jadwal->id_hari;?></td>
                                            <td><?=$jadwal->jam_mulai;?></td>
                                            <td><?=$jadwal->jam_selesai;?></td>
                                            <td><?=$jadwal->kuota_perjam;?></td>
                                            <td><?=$jadwal->status;?></td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#modal-edit"><span class="btn btn-xs btn-warning"><i class="fa fa-edit "></i> Edit</span></a>
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
