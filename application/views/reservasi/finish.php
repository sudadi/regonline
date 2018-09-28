<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Reservasi Berhasil <small>(finish)</small></h3>
    </div>
    <div class="box-body" id="printableArea">
        <div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4 col-xs-12 no-padding">
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green-gradient">
              <div class="widget-user-image">
                <img class="img-circle" src="<?=base_url('assets/dist/img/rso.jpg');?>" alt="RSO">
              </div>
              <!-- /.widget-user-image -->
              <h5 class="widget-user-desc"><?php echo $namapas;?></h5>
              <h5 class="widget-user-desc"><?php echo "No.RM ".$norm;?></h5>
            </div>
            <div class="box-body no-padding bg-gray">
                <div class="form-group col-xs-12"></div>
                <div class="form-group col-xs-12 text-center">
                    <img style="width: 200px;" src="<?php echo base_url().'qrcode/'.$qrcode;?>">
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-4 text-bold">Klinik</div>
                    <div class="col-xs-8 text-bold">: <?=$nmklinik;?></div>
                   <!-- <div class="col-xs-7 text-bold"><?php echo "<img src='".base_url()."barcode/?&size=30&text=".$norm."&print=true'>";?></div> -->
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-4 text-bold">Dokter</div>
                    <div class="col-xs-8 text-bold">: <?=$nmdokter;?></div>                    
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-4 text-bold">Layanan</div>
                    <div class="col-xs-8 text-bold">: <?=$layanan;?></div>                    
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-4 text-bold no">Jaminan</div>
                    <div class="col-xs-8 text-bold">: <?=$jnsjaminan;?></div>                    
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-4 text-bold">Jadwal</div>
                    <div class="col-xs-8 text-bold">: <?php echo date('Y-m-d', strtotime($waktures));?></div>
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-xs-4 text-bold">Jam</div>
                    <div class="col-xs-8 text-bold">: <?php echo date('H:i:s', strtotime($waktures));?></div>
                    
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
            <?=form_open($action, ['id'=>"formfinish"]);?>
            <div class="form-group">
                <div class="pull-left">
                    <button class="btn btn-danger" name="batal" onclick="return $('#modal-batalres').modal();"><i class="fa fa-history"></i> Batalkan Reservasi</button>
                </div>
                <div class="pull-right">
                    <button class="btn btn-success" name="finish" value="selesai"><i class="fa fa-sign-out"></i> Selesai</button>
                </div>
            </div>
            <?=form_close(); ?>
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
<div class="modal fade" id="modal-batalres">
    <?=form_open($action, 'id="formbatalres"'); ?>
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Batal Reservasi</h4>
            </div>
            <div class="modal-body">
                <p>Yakin membatalkan Reservasi ini..?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tidak</button>
                <button type="submit" name="batalres" value="true" class="btn btn-primary"><i class="fa fa-check-square-o"></i> YA Yakin</button>
            </div>
        </div>
    </div>
    <?=form_close(); ?>
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