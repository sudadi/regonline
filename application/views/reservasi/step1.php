<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Verifikasi Rekam Medis Pasien <small>(step-1)</small></h3>
	</div>
	<?=form_open($action, 'id="formreserv" class="form-horizontal form-label-left"'); ?>
	<div class="box-body">
		<div class="form-group">
		  <label for="norm" class="col-sm-2 control-label">No. RM</label>
		  <div class="col-sm-6">
			<input type="text" class="form-control" id="norm" name="norm" placeholder="Masukkan Nomer RM">
		  </div>
		</div>
		<div class="form-group">
		  <label for="tgllahir" class="col-sm-2 control-label">Tgl. Lahir</label>
		  <div class="col-sm-6">
			<input type="date" class="form-control" id="tgllahir" name="tgllahir" placeholder="">
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
              <div class="col-sm-12 col-md-6">
		<button type="submit" class="btn btn-info pull-right">Validasi</button>
              </div>
	  </div>
	  <!-- /.box-footer -->
	</form>
</div>