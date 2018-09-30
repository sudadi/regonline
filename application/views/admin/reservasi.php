<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Reservasi
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('admin');?>"><i class="fas fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Reservasi</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reservasi <small> SMS/WA</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12 no-padding">
                            <div class="form-group col-xs-6 col-sm-2">
                                 <?=form_button(array('name'=>'wa'), '<span class="fab fa-whatsapp"></span> Reservasi WA', 'class="btn btn-success reservasi" onclick="showmodal(this);"');?>
                            </div>
                            <div class="from-group col-xs-6 col-sm-2">
                                <?=form_button('sms', '<span class="far fa-comments"></span> Reservasi SMS', 'class="btn btn-primary reservasi" onclick="showmodal(this);"') ;?>
                            </div>
                        </div>
                        <div class="clearfix"></div><p/>
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <?=form_open('admin/reservasi', 'method="GET" class="form-horizontal'); ?>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">Entry Date</label>
                                    <div class="col-sm-3">
                                        <?=form_input(array('name'=>'filtglres','type'=>'text','id'=>'filtglres'),'','class="form-control"');?>
                                    </div>
                                    <div class="col-sm-2">                                        
                                        <?=form_button(array('name'=>'view','type'=>'submit'), '<span class="fa fa-eye"></span> View', 'class="btn btn-primary"');?>
                                    </div>
                                    <?php echo form_input(['name'=>'start','id'=>'start','type'=>'hidden']);
                                        echo form_input(['name'=>'stop', 'id'=>'stop','type'=>'hidden']);
                                    ?>
                                </div>
                                <?=form_close();?>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover" id="dttable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>No.RM</th>
                                            <th>Nama</th>
                                            <th>TL</th>
                                            <th>No.Telp</th>
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
                                            <td><?=$res->notelp;?></td>
                                            <td><?=$res->nama_klinik;?></td>
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
                    <label for="jnsjaminan" class="col-sm-2 control-label">Jenis Jaminan</label>
                    <div class="col-sm-4">
                        <?php 
                            $option[''] = '-Pilih Jenis Pasien-';
                            $option[2] = 'Pasien Umum';
                            $option[5] = 'Pasien BPJS';
                            echo form_dropdown('jnsjaminan', $option, '5', 'class="form-control" id="jnsjaminan" required');
                        ?>
                    </div>
                    <label for="jnslayan" class="col-sm-2 control-label">Jenis Layanan</label>
                    <div class="col-sm-4">
                        <?php 
                            unset($option);
                            $option[''] = "-Pilih Jenis Layanan-";
                            $option[1] = 'Reguler';
                            $option[2] = 'Eksekutif';
                            echo form_dropdown('jnslayan', $option, '1', 'class="form-control" id="jnslayan" required');
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
                        echo form_dropdown('dokter', $option, '', 'class="form-control" id="dokter" required');?>
                    </div>
                    <label for="poliklinik" class="col-sm-2 control-label">Poliklinik</label>
                    <div class="col-sm-4">
                        <?php
                        unset($option);
                        $option[''] = 'Pilih Klinik';
                        foreach ($klinik as $poli) {
                            $option[$poli->id_klinik] = $poli->nama_klinik;
                        }
                        echo form_dropdown('klinik', $option, '', 'class="form-control" id="klinik" required');?>
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
                <div class="form-group">
                    <label for="tglcekin" class="col-sm-2 control-label">No. Telp</label>
                    <div class="col-sm-3 tglcekin">
                        <?=form_input('notelp', '', 'class="form-control" id="notelp" required');?>
                    </div>
                    <label for="jamcekin" class="col-sm-2 col-sm-offset-1 control-label">Sebab Sakit</label>
                    <div class="col-sm-4 jamcekin">
                        <?php 
                            $option[''] = '-Pilih Sebab Sakit-';
                            $ssakit= $this->mod_reservasi->getsebabsakit();
                            foreach ($ssakit as $key => $value){
                                $option[$value['id_sebab']] = $value['sebab'];
                            } 
                            echo form_dropdown('sebab', $option, '9', 'class="form-control" id="sebab" required');
                        ?>
                    </div>
                </div>
                <?=form_input(array('name'=>'jenisres','type'=>'hidden'));
                    echo form_input(array('name'=>'edit','type'=>'hidden','id'=>'edit'));?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" name="saveres" value="true" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
    <?=form_close();?>
</div>
<div class="modal fade" id="modal-status">
    <?=form_open($action, 'id="formstatus" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Status</h4>
            </div>
            <div class="modal-body">
                    <label for="dpstatus" class="control-label">Status</label>
                    <?php
                    unset($option);
                    $option= array(0=>'Disable',1=>'Active',4=>'Batal By User');
                    echo form_dropdown(array('name'=>'dpstatus','id'=>'dpstatus'), $option, 1, 'class="form-control"');
                    ?>
                <div class="alasan">
                    <label for="alasan" class="control-label">Alasan</label>
                    <?=form_textarea(array('name'=>'alasan','rows'=>'2'),'','class="form-control"'); 
                    echo form_input(array('name'=>'idres','type'=>'hidden','id'=>'idres'));
                    echo form_input(array('name'=>'telpstat','type'=>'hidden','id'=>'notelpstat'));
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" name="savestat" value="true" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
    <?=form_close(); ?>
</div>
<script>
    $(function() {
        $('input[name="filtglres"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            $("#start").val(start.format('YYYY-MM-DD'));
            $("#stop").val(end.format('YYYY-MM-DD'));
        });
    });
    function clearform(){
        $('#norm').val('');
        $('input[name*=nama]').val('');
        $('input[name*=notelp]').val('');
        $('#jnsjaminan').val('');
        $('#dokter').val('');
        $('select[name=klinik]').val('');
        $('select[name=jnslayan]').val('');
        $('input[name*=jenisres]').val('');
    };
    function showmodal(elm){
        clearform();
        var jenisres=$(elm).attr('name');
        if (jenisres === 'wa'){
            $('.modal-title').html('Reservasi WA');
            $("input[name*='jenisres']").val("WA");
        } else if (jenisres === 'sms') {
            $('.modal-title').html('Reservasi SMS');
            $("input[name*='jenisres']").val("SMS");
        }
        $('#modal-reservasi').modal();
    }
    $('#norm').keypress(function(e) {
        if(e.which === 13) {
            if ($('#norm').val().length >= 6){
                $('#shownorm').click();
            }
        }
        return false;  
    });
    $('#shownorm').click(function(){
        var norm=$('#norm').val();
        //console.log(norm);
        if (norm.length < 6){
            alert('No. RM SALAH, minimal 6 digit angka.');
        } else {
            $.ajax({
                url : "<?php echo site_url('admin/ajaxpasien/')?>"+norm,
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    if (data.id_rsv){
                        alert("Pasien Sudah Terdaftar \n\
                        No.RM   :"+data.norm+" \n\
                        Nama    :"+data.nama+" \n\
                        Jaminan :"+data.nama_jaminan+" \n\
                        Layanan :"+data.jns_layan+" \n\
                        Klinik  :"+data.nama_klinik+" \n\
                        Dokter  :"+data.nama_dokter+" \n\
                        Jadwal  :"+data.waktu_rsv+" ");
                    } else {
                        $("input*[name='nama']").val(data.nama);
                        $("input*[name='notelp']").val(data.notelp);
                        //console.log($("input*[name='nama']").val(data.nama));
                        $("#jnsjaminan").focus();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert('Error : Data tidak ditemukan..!');
                    location.reload();
                }
            }); 
        }
        return false;
    });
    $("#dokter").change(function(){
        var iddokter=$(this).val();
        var jenis=$('#jnslayan').val();
        var klinik=$('#klinik');
        var url ="<?php echo site_url('reservasi/ajax_klinik/')?>"+iddokter+"/"+jenis;
        if (iddokter !== ''){
            $.ajax({
                url : url,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    klinik.empty();
                    klinik.append('<option value="">-Pilih Poliklinik-</option>');
                    for (var i = 0; i < data.length; i++) {
                        klinik.append('<option value='+data[i].id_klinik+'>'+data[i].nama_klinik+'</option>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error : Data tidak ditemukan..!');
                    location.reload();
                }
            });
        }   
    });
    $("#klinik").change(function() {
        var klinik=$(this).val();
        var jenis=$('#jnslayan').val();
        var tglcekin=$('#tglcekin');      
        var iddokter=$('#dokter').val();
        if (klinik !==''){
            $.ajax({
                url : url = "<?php echo site_url('reservasi/ajax_jadwal/')?>"+klinik+"/"+iddokter+"/"+jenis,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    tglcekin.empty();
                    tglcekin.append('<option value="">-Pilih Tanggal-</option>');
                    for (var i = 0; i < data.length; i++) {
                        tglcekin.append('<option value="'+data[i].idjadwal+'|'+data[i].iddokter+'|'+data[i].jadwaltgl+'">'+data[i].hari+', &nbsp;&nbsp;'+data[i].jadwaltgl+'</option>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error : Data tidak ditemukan..!');
                    location.reload();
                }    
            });
        }
    });
    $("#tglcekin").change(function() {
        var dtcekin=$(this).val();
        var cekin = dtcekin.split('|');
        var jamcekin=$("#jamcekin");
        $('#dokter').val(cekin[1]);
        var url = "<?php echo site_url('reservasi/ajax_jamcekin/')?>"+cekin[0]+"/"+cekin[2];
        //console.log(url);
        $.ajax({
            url : url,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                jamcekin.empty();
                jamcekin.append('<option value="">-Pilih Waktu Kunjungan-</option>');
                for (var i = 0; i < data.length; i++) {
                    jamcekin.append('<option value="'+data[i].jam+'">'+data[i].jam+'&nbsp;&nbsp;&nbsp;&nbsp;(kuota :'+data[i].sisa+')</option>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error : Data tidak ditemukan..!');
                location.reload();
            } 
        });       
    });
    function editdata(idrsv){
        $.ajax({
            url : "<?php echo site_url('admin/ajaxresv/')?>"+idrsv,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //$('.tglcekin').html('<input type="date" name="tglcekin" required />');
                //$('.jamcekin').html('<input type="time" name="jamcekin" required />');
                $('#norm').val(data.norm);
                $('input[name*=nama]').val(data.nama);
                $('input[name*=notelp]').val(data.notelp);
                $('#jnsjaminan').val(data.id_jaminan );
                $('#dokter').val(data.id_dokter);
                $('select[name=klinik]').val(data.id_klinik);
                $('select[name=jnslayan]').val(data.id_jnslayan);
                $('input[name*=jenisres]').val(data.jenis_rsv);
                $('#edit').val(idrsv);
                $('#modal-reservasi').modal();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error : Data tidak ditemukan..!');
                location.reload();
            }
        });
    };
    $('.status').click(function() {
        $('#idres').val($(this).closest('tr').children('td:eq(0)').text());
        $('#telpstat').val($(this).closest('tr').children('td:eq(5)').text());
        $('#modal-status').modal();
    });
//    $('#dpstatus').change(function() {
//        if ($(this).val() == 4) {  
//            $(".alasan").fadeIn(800, function(){ 
//                $(".alasan").show();
//            });  
//        } else {
//            $(".alasan").fadeOut(800, function(){ 
//                $(".alasan").hide();
//            });
//        };
//    });
//console.log("<?=$filtglres;?>");
</script>