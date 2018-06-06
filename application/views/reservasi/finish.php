<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Reservasi Berhasil <small>(finish)</small></h3>
    </div>
    <div class="box-body">
        <div class="col-sm-6 col-md-offset-3">
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green-gradient">
              <div class="widget-user-image">
                <img class="img-circle" src="<?=base_url('assets/dist/img/rso.jpg');?>" alt="Pasien">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?php echo $namapas."bla bla bla bla bla bla";?></h3>
              <h5 class="widget-user-desc"><?php echo "nmklinik";?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">No. RM <span class="pull-right badge bg-blue"><?php echo "<img src='.base_url().'barcode/bikin_barcode/'.$norm'>";?></span></a></li>
                <li><a href="#">ID. REG <span class="pull-right badge bg-aqua">5</span></a></li>
                <li><a href="#">JADWAL <span class="pull-right badge bg-green">12</span></a></li>
                <li><a href="#">JAM <span class="pull-right badge bg-red">842</span></a></li>
                <li><a href="#">No. URUT <span class="pull-right badge bg-red">842</span></a></li>
              </ul>
            </div>
          </div>
        </div>
    </div>    
</div>
