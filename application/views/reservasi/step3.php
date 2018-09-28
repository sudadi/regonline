<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Kelengkapan Data <small>(step-3)</small></h3>
    </div>
    <?=form_open($action, 'name="formstep3" id="formstep3" class="form-horizontal form-label-left" onsubmit="return Validasi();"'); ?>
    <div class="box-body">
        <div class="form-group">
            <label for="norm" class="col-sm-2 control-label">Pasien</label>
            <div class="col-sm-4 col-md-2">
                <?php
                echo form_input('norm', $norm, 'class="form-control" id="norm" readonly');
                ?>
            </div>
            <div class="col-sm-6 col-md-6">
                <?php
                echo form_input('namapas', $namapas, 'class="form-control" id="namapas" readonly');
                ?>
            </div>
        </div>
        <div class="form-group">
           <label for="alamat" class="col-sm-2 control-label">Alamat</label>
           <div class="col-sm-8 col-md-8">
               <?php
               echo form_input('alamat', $alamat, 'class="form-control" id="alamat" readonly');
               ?>
           </div>
        </div>
        <div class="form-group">
           <label for="notelp" class="col-sm-2 control-label">No. HP *</label>
           <div class="col-sm-4 col-md-4">
               <?php
               echo form_input('notelp', $notelp, 'class="form-control" id="notelp" placeholder="081xxxxxxxxx" required');
               ?>
           </div>
        </div>
<!--        <div class="form-group">
            <label for="sebab" class="col-sm-2 control-label">Sebab Sakit *</label>
            <div class="col-sm-4 col-md-4">
                <?php 
                $option[''] = '-Pilih Sebab Sakit-';
                $ssakit= $this->mod_reservasi->getsebabsakit();
                foreach ($ssakit as $key => $value){
                    $option[$value['id_sebab']] = $value['sebab'];
                } 
                echo form_dropdown('sebab', $option, '', 'class="form-control" id="sebab" required');
                ?>
            </div>
        </div>-->
        <input type="hidden" name="sebab" value="9"/>
        <!-- /.box-body -->
      <div class="box-footer">
          <div class="form-group">
              <div class="col-xs-6 col-sm-2 col-sm-offset-2">
                  <button type="button" name="back" id="back" class="btn btn-warning"><i class="fa fa-reply"></i> Kembali</button>
              </div>
              <div class="col-xs-6 col-sm-2">
                  <button type="submit" name="reserv" value="trus" id="reserv" class="btn btn-info pull-right"><i class="fa fa-send-o"></i> Reservasi</button>
              </div>
          </div>
      </div>
      <!-- /.box-footer -->
</div>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Review Data Reservasi</h3>
    </div>
    <div class="box-body">
        <div class="form-group">
            <label for="jenispas" class="col-sm-1 control-label">Penjamin</label>
            <div class="col-sm-4 col-md-3">
                <?php echo form_input('jnsjaminan', $jnsjaminan, 'class="form-control" readonly');?>
            </div>
            <label for="nmklinik" class="col-sm-1 control-label">Klinik</label>
            <div class="col-sm-4 col-md-4">
                <?php echo form_input('nmklinik', $nmklinik, 'class="form-control" readonly');?>
            </div>
            <label for="tglcekin" class="col-sm-1 control-label">Tanggal</label>
            <div class="col-sm-4 col-md-2">
                <?php echo form_input('tglcekin', $tglcekin, 'class="form-control" readonly');?>
            </div>
        </div>
        <div class="form-group">
            <label for="layanan" class="col-sm-1 control-label">Layanan</label>
            <div class="col-sm-4 col-md-3">
                <?php echo form_input('layanan', $layanan, 'class="form-control" readonly');?>
            </div>
            <label for="nmdokter" class="col-sm-1 control-label">Dokter</label>
            <div class="col-sm-4 col-md-4">
                <?php echo form_input('nmdokter', $nmdokter, 'class="form-control" readonly');?>
            </div>
            <label for="jamcekin" class="col-sm-1 control-label">Jam</label>
            <div class="col-sm-4 col-md-2">
                <?php echo form_input('jamcekin', $jamcekin, 'class="form-control" readonly');?>
            </div>
        </div>
        <div class="form-group">
        </div>
    </div>
</div>    
    
<?php 
    echo form_hidden('tgllahir', $tgllahir);
    echo form_hidden('idjadwal', $idjadwal);
    echo form_hidden('idklinik', $idklinik);
    echo form_hidden('iddokter', $iddokter);
    echo form_hidden('idjaminan', $idjaminan);
echo form_close();
?>
<script type="text/javascript">
    $('#back').click(function(){
        window.location = "<?=base_url('reservasi/step2');?>";
//        $('form[name=formstep3]').attr('action','<?php echo site_url("reservasi/step2");?>');
//        $('form[name=formstep3]').submit();
    });

    function Validasi(){
        var angka = "0123456789";
        var x = 0;
        var notelepon=document.getElementById('notelp').value;
        if (notelepon ==""){
          alert("Ada form yang belum terisi");
        }
        if (notelepon.length<10 || notelepon.length>15) {
            alert("Mohon masukkan no telepon dengan benar");
            return false;
        }
        for (var i=0; i <notelepon.length; i++) {
            digitb = "" + notelepon.substring(i, i+1);
            if (angka.indexOf(digitb) == "-1") {
                window.alert("Karakter pada No Telepon yang dimasukkan salah (harus angka semua)");
                return false;
            }
        }
        return true;
    }
</script>