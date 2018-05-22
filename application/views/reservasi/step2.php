<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Pilih Jadwal & Poliklinik Tujuan <small>(step-2)</small></h3>
    </div>
    <?=form_open($action, 'id="formreserv" class="form-horizontal form-label-left"'); ?>
    <div class="box-body">
        <div class="form-group">
            <label for="jnslayan" class="col-sm-2 control-label">Jenis Layanan</label>
                <div class="col-sm-6 col-md-4">
                    <?php 
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
      <!-- /.box-body -->
      <div class="box-footer">
          <div class="col-sm-12 col-md-6">
            <button type="submit" class="btn btn-info pull-right">Simpan</button>
          </div>
      </div>
      <!-- /.box-footer -->
    </form>
</div>
<script>
    $("#jnslayan").change(function(){
    var val=$(this).val();
    var dokter = $('#dokter');
    if (val == 2) {  
        $(".dokter").fadeIn(800, function(){ 
            $(".dokter").show();
	});
        $.ajax({
            url : "<?php echo site_url('reservasi/ajax_getdokter')?>",
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
                alert('Error data dokter tidak di temukan');
            }
        });              
    } else {
        dokter.empty();
        dokter.append('<option value="">-Pilih Dokter-</option>');
        $(".dokter").fadeOut(800, function(){ 
            $(".dokter").hide();
	});
    }
    });
    
    $("#dokter").change(function(){
        var iddokter=$(this).val();
        var jenis=$('#jnslayan').val();
        var klinik=$('#poliklinik');
        $.ajax({
            url : "<?php echo site_url('reservasi/ajax_klinik/')?>" + iddokter + "/" + jenis,
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
                alert('Error data dokter tidak di temukan');
            }
        });
    });
    
    $("#poliklinik").change(function() {
        var klinik=$(this).val();
        var iddokter=$('#dokter').val();
        var jenis=$('#jnslayan').val();
        var tglcekin=$('#tglcekin');
        var jamcekin=$('#jamcekin');
        $.ajax({
            url : "<?php echo site_url('reservasi/ajax_jadwal/')?>"+klinik+"/"+iddokter+"/"+jenis,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                tglcekin.empty();
                tglcekin.append('<option value="">-Pilih Tanggal-</option>');
            for (var i = 0; i < data.length; i++) {
                    tglcekin.append('<option value='+data[i].jadwaltgl+'>'+data[i].hari+', &nbsp;&nbsp;'+data[i].jadwaltgl+'&nbsp;&nbsp;&nbsp;&nbsp;(kuota :'+data[i].sisa+')</option>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error data tidak di temukan');
            }    
        });
    });
</script>