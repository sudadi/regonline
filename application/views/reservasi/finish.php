<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Reservasi Berhasil <small>(finish)</small></h3>
    </div>
    <div class="box-body" id="printableArea">
        <div class="col-sm-5 col-sm-offset-3">
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green-gradient">
              <div class="widget-user-image">
                <img class="img-circle" src="<?=base_url('assets/dist/img/rso.jpg');?>" alt="RSO">
              </div>
              <!-- /.widget-user-image -->
              <h5 class="widget-user-desc"><?php echo $namapas;?></h5>
              <h5 class="widget-user-desc"><?php echo "Klinik ".$nmklinik;?></h5>
            </div>
            <div class="box-body no-padding bg-gray">
                <div class="form-group col-xs-12"></div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-5 text-bold">No. RM </div>
                    <div class="col-xs-7 text-bold"><?php echo "<img src='".base_url()."barcode/?&size=30&text=".$norm."&print=true'>";?></div>
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-5 text-bold">ID. REG</div>
                    <div class="col-xs-7 text-bold"><?php echo "<img src='".base_url()."barcode/?&size=30&text=".$nores."&print=true'>";?></div>
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-5 text-bold">JADWAL</div>
                    <div class="col-xs-7 text-bold"><?php echo date('Y-m-d', strtotime($waktures));?></div>
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-5 text-bold">JAM </div>
                    <div class="col-xs-7 text-bold"><?php echo date('H:i:s', strtotime($waktures));?></div>
                    
                </div>
<!--                <div class="form-group col-xs-12">
                    <div class="col-xs-5 text-bold">No. URUT </div>
                    <div class="col-xs-7 text-bold"> </div>
                </div>-->
            </div>
            <div class="box-footer no-padding bg-blue-active">
                <div class="form-group col-xs-12">
                <h4>Info!</h4>
                <p class="text-justify">Mohon datang tepat waktu sesuai jadwal yang sudah ditentukan atau 30 menit sebelumnya.</p>
                </div>
            </div>
            <div class="form-group col-xs-12"></div>
            <div class="pull-right">
                <a href="<?=base_url();?>"><button class="btn btn-success" value="Selesai">Selesai</button></a>
            </div>
          </div>
        </div>
    </div> 
    <!--<input type="button" onclick="printDiv('printableArea')" value="print a div!" />-->
    <div class="form-group">
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-info"></i> Perhatian!</h4>
            <p class="text-justify">Tunjukkan tampilan halaman ini saat check-in kepada petugas pendaftaran.
            Untuk menampilkan halaman ini lagi, lakukan seperti step-1 (verifikasi norm & tgl lahir),
            akan langsung tertampil halaman ini.</p>
        </div>
    </div>
</div>
<script>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>