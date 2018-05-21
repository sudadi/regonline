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
                        $option[''] = '-Pilih Dokter-';
                        
                        echo form_dropdown('dokter', $option, '', 'class="form-control" id="dokter" required');
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="poliklinik" class="col-sm-2 control-label">Poliklinik</label>
                <div class="col-sm-6 col-md-4">
                    <?php 
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
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                     <!--  <label>
                            <input type="checkbox"> Remember me
                      </label> -->
                    </div>
              </div>
            </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
            <button type="submit" class="btn btn-info pull-right">Simpan</button>
      </div>
      <!-- /.box-footer -->
    </form>
</div>
<script>
    $("#jnslayan").change(function(){
    var val=this.value;
    console.log(val);
    if (val == 1) {
        $(".dokter").fadeOut(800, function(){ 
            $(".dokter").hide();
	});        
    } else {
        $(".dokter").fadeIn(800, function(){ 
            $(".dokter").show();
	});
    }
});
</script>