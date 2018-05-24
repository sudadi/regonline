<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Pilih Jadwal & Poliklinik Tujuan <small>(step-2)</small></h3>
    </div>
    <?=form_open($action, 'id="formreserv" class="form-horizontal form-label-left"'); ?>
    <div class="box-body">
        <div class="form-group">
            <label for="jnspasien" class="col-sm-2 control-label">Jenis Pasien</label>
            <div class="col-sm-6 col-md-4">
                <?php 
                    $option[''] = '-Pilih Jenis Pasien-';
                    $option[2] = 'Pasien Umum';
                    $option[5] = 'Pasien BPJS';
                    echo form_dropdown('jnspasien', $option, '', 'class="form-control" id="jnspasien" required');
                ?>
            </div>
        </div>
        <div class="form-group jnslayan">
            <label for="jnslayan" class="col-sm-2 control-label">Jenis Layanan</label>
            <div class="col-sm-6 col-md-4">
                <?php 
                    $option='';
                    $option[''] = '-Pilih Jenis Layanan-';
                    $option[1] = 'Reguler';
                    $option[2] = 'Eksekutif';
                    echo form_dropdown('jnslayan', $option, '', 'class="form-control" id="jnslayan" required');
                ?>
            </div>
        </div>
        <div class="form-group dokter">
            <label for="dokter" class="col-sm-2 control-label">Dokter</label>
            <div class="col-sm-6 col-md-4">
                <?php 
                    $option='';
                    $option[''] = '-Pilih Dokter-';                        
                    echo form_dropdown('dokter', $option, '', 'class="form-control" id="dokter" required');
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="poliklinik" class="col-sm-2 control-label">Poliklinik</label>
            <div class="col-sm-6 col-md-4">
                <?php 
                    $option='';
                    $option[''] = '-Pilih Poliklinik-';                        
                    echo form_dropdown('poliklinik', $option, '', 'class="form-control" id="poliklinik" required');
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="tglcekin" class="col-sm-2 control-label">Tgl. Pelayanan</label>
            <div class="col-sm-6 col-md-4">
                <?php 
                    $option[''] = '-Pilih Tanggal-';
                    echo form_dropdown('tglcekin', $option, '', 'class="form-control" id="tglcekin" required');
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="jamcekin" class="col-sm-2 control-label">Jam Pelayanan</label>
            <div class="col-sm-6 col-md-4">
                <?php 
                    $option[''] = '-Pilih Waktu-';
                    echo form_dropdown('jamcekin', $option, '', 'class="form-control" id="jamcekin" required');
                ?>
            </div>
        </div>
      </div>
      <?php 
        echo form_hidden('norm', $norm);
        echo form_hidden('tgllahir', $tgllahir);
      ?>
      <!-- /.box-body -->
      <div class="box-footer">
          <div class="col-sm-12 col-md-6">
            <button type="submit" class="btn btn-info pull-right">Lanjut</button>
          </div>
      </div>
      <!-- /.box-footer -->
    </form>
</div>
<script>
    $("#jnspasien").change(function() {
        var jnspasien=$(this).val();
        if (jnspasien==5){ //jika bpjs
            $('#jnslayan').val(1).change();
            $(".jnslayan").fadeOut(800, function(){ 
                $(".jnslayan").hide();
            });
            $(".dokter").fadeOut(800, function(){ 
                $(".dokter").hide();
            });
            
        } else {
            $(".jnslayan").fadeIn(800, function(){ 
                $(".jnslayan").show();
            });
            $('#jnslayan').val('');
            $(".dokter").fadeIn(800, function(){ 
                $(".dokter").show();
            });
        }
    });
    $("#jnslayan").change(function(){
        var val=$(this).val();
        var dokter = $('#dokter');
        if (val != ''){            
            if (val == 2) {  
                $(".dokter").fadeIn(800, function(){ 
                    $(".dokter").show();
                });  
            } else {
                $('#dokter').val('');
                $(".dokter").fadeOut(800, function(){ 
                    $(".dokter").hide();
                });
            }
            $.ajax({
                url : "<?php echo site_url('reservasi/ajax_getdokter/')?>"+val,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    dokter.empty();
                    dokter.append('<option value="">-Pilih Dokter-</option>');
                    for (var i = 0; i < data.length; i++) {
                        dokter.append('<option value="' + data[i].id_dokter + '">' + data[i].nama_dokter + '</option>');
                    }
                    //dokter.change();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error : Masukkan data secara urut..!');
                }
            }); 
            var klinik=$('#poliklinik');
            $.ajax({
                url : "<?php echo site_url('reservasi/ajax_klinik/')?>0/" + val,
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
                    alert('Error : Masukkan data secara urut..!');
                }
            });
        }
    });
    
    $("#dokter").change(function(){
        var iddokter=$(this).val();
        var jenis=$('#jnslayan').val();
        var klinik=$('#poliklinik');
        if (jenis==1){
            var url = "<?php echo site_url('reservasi/ajax_klinik/')?>0/"+jenis;
        } else {
            var url ="<?php echo site_url('reservasi/ajax_klinik/')?>"+iddokter+"/"+jenis;
        }
        if (iddokter != ''){
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
                    alert('Error : Masukkan data secara urut..!');
                }
            });
        }   
    });
    
    $("#poliklinik").change(function() {
        var klinik=$(this).val();
        var jenis=$('#jnslayan').val();
        var tglcekin=$('#tglcekin');      
        var iddokter=$('#dokter').val();
        if (klinik !=''){
            $.ajax({
                url : url = "<?php echo site_url('reservasi/ajax_jadwal/')?>"+klinik+"/0/"+jenis,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    tglcekin.empty();
                    tglcekin.append('<option value="">-Pilih Tanggal-</option>');
                    for (var i = 0; i < data.length; i++) {
                        tglcekin.append('<option value="'+data[i].idjadwal+'|'+data[i].iddokter+'|'+data[i].jadwaltgl+'">'+data[i].hari+', &nbsp;&nbsp;'+data[i].jadwaltgl+'&nbsp;&nbsp;&nbsp;&nbsp;(kuota :'+data[i].sisa+')</option>');
                    console.log(data[i].idjadwal);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error : Masukkan data secara urut..!');
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
        console.log(url);
        $.ajax({
            url : url,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                jamcekin.empty();
                jamcekin.append('<option value="">-Pilih Waktu Kunjungan-</option>');
                for (var i = 0; i < data.length; i++) {
                    jamcekin.append('<option value="'+data[i].jsm+'">'+data[i].jam+'&nbsp;&nbsp;&nbsp;&nbsp;(kuota :'+data[i].sisa+')</option>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error : Masukkan data secara urut..!');
            } 
        });       
    });
    
</script>