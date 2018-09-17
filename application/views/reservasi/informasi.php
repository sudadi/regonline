<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <img src="<?=base_url('assets/dist/img/banner-res.png');?>" class="img-rounded img-responsive center-block">
    <div class="box-footer text-center">
        <strong>Untuk mulai Reservasi silahkan klik </strong>
        <button class="btn btn-warning" id="btnreservasi" name="btnreservasi"  onclick="location.href='<?=base_url('reservasi/respas');?>';">Reservasi</button>
    </div>
</div>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Informasi <small></small></h3>
    </div>
    <div class="box-body">
        
    </div>
    <div class="box-footer">
<!--        <div class="col-sm-12 col-md-6">
            <button type="submit" class="btn btn-info pull-right">Validasi</button>
        </div>-->
    </div>
    </form>
</div>
<script>
    $('#btnreservasi').click(function() {
    
})
</script>
