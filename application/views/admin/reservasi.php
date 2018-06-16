<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Reservasi
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Reservasi</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reservasi <small> SMS/WA</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <?=form_button('tambah', '<span class="fa fa-plus"></span> Tambah', 'class="btn btn-info" data-toggle="modal" data-target="#modal-reservasi"') ;?>
                            </div>
                        </div>
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
                                            <th>TL</th>
                                            <th>Klinik</th>
                                            <th>Dokter</th>
                                            <th>Layanan</th>
                                            <th>Tgl. Res.</th>
                                            <th>Kode</th>
                                            <th>No. Urut</th>
                                            <th>Tgl. Entri</th>
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
                                            <td class="text-nowrap"><?=$res->nama_dokter;?></td>
                                            <td><?=$res->cara_bayar;?></td>
                                            <td><?=$res->waktu_rsv;?></td>
                                            <td><?=$res->nores;?></td>
                                            <td><?=$res->nourut;?></td>
                                            <td><?=$res->tgl_update;?></td>
                                            <td><?=$res->status ? '<span class="btn btn-xs btn-success">Aktif</span>':'<span class="btn btn-xs btn-default">Non Aktif</span>';?></td>
                                            <td><span class="btn btn-xs btn-info"><?=$res->sync?'True':'False';?></span></td>
                                            <td class="text-nowrap">
                                                <a href="#" data-toggle="modal" data-target="#modal-edit"><span class="btn btn-xs btn-warning"><i class="fa fa-edit "></i> Edit</span></a>
                                                <a href="<?=base_url('admin/reservasi/?hapus='.$res->id_rsv);?>" onclick="return confirm('Yakin menghapus data ini ?')">
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