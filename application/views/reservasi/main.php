<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
/* 
 * The MIT License
 *
 * Copyright 2017 DotKom <sudadi.kom@yahoo.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
?>
<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('reservasi/header'); ?>
<body class="hold-transition skin-yellow fixed sidebar-mini">
<div class="wrapper">
<?php 
	$this->load->view('reservasi/navbar',$content); 
	$this->load->view('reservasi/sidebar');
?>  
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>Reservasi<small>Pasien Rawat Jalan</small>			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Reservasi</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<!-- Main row -->
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<?php $this->load->view($page, $content); ?>
				</div>
			</div>
		<!-- /.row (main row) -->
		</section>
    <!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
    <footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b>Version</b> 0.1
		</div>
		<strong>Copyright &copy; 2018 <a href="https://rso.go.id">SIRS - RSO</a>.</strong> All rights reserved.
	</footer>
</div>
<!-- ./wrapper -->
<?php $this->load->view('reservasi/footer');?>
</body>
</html>
