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
             <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reservasi <small> SMS/WA</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <?=form_button(array('name'=>'wa'), '<span class="fa fa-whatsapp"></span> Reservasi WA', 'class="btn btn-success reservasi" onclick="showmodal(this);"');?>
                            </div>
                            <div class="col-sm-2 col-sm-offset-1">
                                <?=form_button('sms', '<span class="fa fa-envelope-o"></span> Reservasi SMS', 'class="btn btn-primary reservasi" onclick="showmodal(this);"') ;?>
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
                                                <a href="#" onclick="editdata(<?=$res->id_rsv;?>)"><span class="btn btn-xs btn-warning"><i class="fa fa-edit "></i> Edit</span></a>
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
<div class="modal fade" id="modal-reservasi">
    <?=form_open($action, 'id="formreserv" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reservasi</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-2">No. RM</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <?=form_input(array('name'=>'norm','id'=>'norm'), '', 'class="form-control" required');?>
                            <div class="input-group-btn">
                                <button id="shownorm" class="btn btn-default"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <label class="control-label col-sm-1">Nama</label>
                    <div class="col-sm-6">
                        <?=form_input('nama', '', 'class="form-control" readonly required');?>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="jnspasien" class="col-sm-2 control-label">Jenis Pasien</label>
                    <div class="col-sm-4">
                        <?php 
                            $option[''] = '-Pilih Jenis Pasien-';
                            $option[2] = 'Pasien Umum';
                            $option[5] = 'Pasien BPJS';
                            echo form_dropdown('jnspasien', $option, '', 'class="form-control" id="jnspasien" required');
                        ?>
                    </div>
                    <label for="jnslayan" class="col-sm-2 control-label">Jenis Layanan</label>
                    <div class="col-sm-4">
                        <?php 
                            unset($option);
                            $option[''] = "-Pilih Jenis Layanan-";
                            $option[1] = 'Reguler';
                            $option[2] = 'Eksekutif';
                            echo form_dropdown('jnslayan', $option, '', 'class="form-control" id="jnslayan" required');
                        ?>
                    </div>
                </div>
                <div class="form-group dokter">
                    <label for="dokter" class="col-sm-2 control-label">Dokter</label>
                    <div class="col-sm-4">
                        <?php
                        unset($option);
                        $option[''] = 'Pilih Dokter';
                        foreach ($dokter as $dok) {
                            $option[$dok->id_dokter] = $dok->nama_dokter;
                        }
                        echo form_dropdown('dokter', $option, '', 'class="form-control" required');?>
                    </div>
                    <label for="poliklinik" class="col-sm-2 control-label">Poliklinik</label>
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
                    <label for="tglcekin" class="col-sm-2 control-label">Tgl. Pelayanan</label>
                    <div class="col-sm-4 tglcekin">
                        <?php 
                            unset($option);
                            $option[''] = '-Pilih Tanggal-';
                            echo form_dropdown('tglcekin', $option, '', 'class="form-control" id="tglcekin" required');
                        ?>
                    </div>
                    <label for="jamcekin" class="col-sm-2 control-label">Jam Pelayanan</label>
                    <div class="col-sm-4 jamcekin">
                        <?php 
                            unset($option);
                            $option[''] = '-Pilih Waktu-';
                            echo form_dropdown('jamcekin', $option, '', 'class="form-control" id="jamcekin" required');
                        ?>
                    </div>
                </div>
                <?=form_input(array('name'=>'jenisres','type'=>'hidden'));
                    echo form_input(array('name'=>'edit','type'=>'hidden'));?>
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
    function showmodal(elm){
        var jenisres=$(elm).attr('name');
        if (jenisres === 'wa'){
            $('.modal-title').html('Reservasi WA');
            $("input[name*='jenisres']").val("WA");
        } else {
            $('.modal-title').html('Reservasi SMS');
            $("input[name*='jenisres']").val("SMS");
        }
        $('#modal-reservasi').modal();
    }
    $('#norm').keypress(function(e) {
        if(e.which === 13) {
            if ($('#norm').val().length >= 6){
                $('#shownorm').click();
                return false;  
            }
        }
    });
    $('#shownorm').click(function(){
        var norm=$('#norm').val();
        console.log(norm);
        if (norm.length < 6){
            alert('No. RM SALAH, minimal 6 digit angka.');
            return false;
        } else {
            $.ajax({
                url : "<?php echo site_url('admin/ajaxpasien/')?>"+norm,
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $("input*[name='nama']").val(data.nama);
                    console.log($("input*[name='nama']").val(data.nama));
                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert('Error : Data tidak ditemukan..!');
                }
            }); 
            //return false;
        }
        //$(location).attr('href','http://localhost/regonline/admin')
    });
    function editdata(idrsv){
        $.ajax({
            url : "<?php echo site_url('admin/ajaxresv/')?>"+idrsv,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var d = new Date(data.waktu_rsv);
                var tglresv = d.format("yyyy-mm-dd");
                var jamresv = d.format("HH:MM");
                $('.tglcekin').html('<input type="date" name="tglcekin" required />');
                $('.jamcekin').html('<input type="time" name="jamcekin" required />');
                $('#norm').val(data.norm);
                $('input[name*=nama]').val(data.nama);
                $('input[name*=jnspasien]').val(data.cara_bayar);
                $('select[name=dokter]').val(data.id_dokter);
                $('select[name=klinik]').val(data.id_klinik);
                $('select[name=jnslayan]').val(data.jnslayan);
                $('select[name=tglcekin]').val(tglresv);
                $('select[name=jamcekin]').val(jamresv);
                $('input[name*=jenisres]').val(data.jenisresv);
                $('#edit').val(idresv);
                $("#modal-jadwal").modal();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error : Data tidak ditemukan..!');
            }
        });
    }
</script>