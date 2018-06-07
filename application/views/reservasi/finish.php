<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Reservasi Berhasil <small>(finish)</small></h3>
    </div>
    <div class="box-body">
        <div class="col-sm-6 col-md-offset-3 col-lg-3 col-lg-offset-4">
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green-gradient">
              <div class="widget-user-image">
                <img class="img-circle" src="<?=base_url('assets/dist/img/rso.jpg');?>" alt="Pasien">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?php echo $namapas;?></h3>
              <h5 class="widget-user-desc"><?php echo "nmklinik";?></h5>
            </div>
            <div class="box-footer no-padding">
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">No. RM </div>
                    <div class="col-sm-8"><?php echo "<img src='".base_url()."barcode.php?&size=30&text=".$norm."&print=true'>";?></div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">ID. REG</div>
                    <div class="col-sm-8"><?=$nores;?></div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">JADWAL</div>
                    <div class="col-sm-8"> </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">JAM </div>
                    <div class="col-sm-8"> </div>
                    
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">No. URUT </div>
                    <div class="col-sm-8"> </div>
                </div>
            </div>
          </div>
        </div>
    </div>    
</div>
