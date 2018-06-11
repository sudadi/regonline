<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="<?=base_url('reservasi');?>">
            <i class="fa fa-dashboard"></i> <span>Reservasi</span>
          </a>
        </li>
        <li>
          <a href="<?=base_url('informasi');?>">
            <i class="fa fa-info-circle"></i>
            <span>Info Ortopedi</span>
          </a>
        </li>
		<li>
          <a href="<?=base_url('help');?>">
            <i class="fa fa-support"></i>
            <span>Bantuan</span>
          </a>
        </li>
        <li>
          <a href="<?=base_url('ketentuan');?>">
            <i class="fa fa-exclamation-triangle"></i> <span>Syarat & Ketentuan</span>
            <!-- <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span> -->
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<script>
  var url = window.location;
  // for sidebar menu entirely but not cover treeview
  $('ul.sidebar-menu a').filter(function() {
     return this.href == url;
  }).parent().addClass('active');
  //Top bar
  $('ul.navbar-nav a').filter(function() {
     return this.href == url;
  }).parent().addClass('active');
  // for treeview
  $('ul.treeview-menu a').filter(function() {
     return this.href == url;
  }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
</script>