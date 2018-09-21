<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<aside class="main-sidebar fixed">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="<?=base_url('admin');?>">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?=base_url('admin/reservasi');?>">
                    <i class="fa fa-business-time"></i> <span>Reservasi</span>
                </a>
<!--                <ul class="treeview-menu">
                    <li><a href="<?=base_url('admin/reservasi');?>"><i class="fa fa-circle-o"></i> Reg. SMS/WA</a></li>
                    <li><a href="<?=base_url('admin/datares');?>"><i class="fa fa-circle-o"></i> Data Registrasi</a></li>
                </ul>-->
            </li>
            <li>
                <a href="<?=base_url('admin/sms');?>">
                   <i class="far fa-comments"></i> <span>SMS</span>
                </a>
            </li>
            <li class="treeview">
            	<a href="#0">
                    <i class="fas fa-chart-line"></i> <span>Laporan</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('admin/datatable');?>"><i class="fas fa-caret-right"></i> <span>Data Tabel</span></a></li>
                    <li><a href="<?=base_url('admin/datagraph');?>"><i class="fas fa-caret-right"></i> <span>Data Grafik</span></a></li>
                </ul>
            </li>
            <li>
                <a href="<?=base_url('admin/postinfo');?>">
                    <i class="fas fa-file-signature"></i> <span>Posting Info</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#1">
                    <i class="fas fa-cogs"></i> <span>Setting</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('admin/datadok');?>"><i class="fas fa-caret-right"></i> Data Dokter</a></li>
                    <li><a href="<?=base_url('admin/dataklinik');?>"><i class="fas fa-caret-right"></i> Data Klinik</a></li>
                    <li><a href="<?=base_url('admin/jadwal');?>"><i class="fas fa-caret-right"></i> Data Jadwal</a></li>
                    <li><a href="<?=base_url('admin/libur');?>"><i class="fas fa-caret-right"></i> Data Libur</a></li>
                    <li><a href="<?=base_url('auth');?>"><i class="fas fa-caret-right"></i> Data User</a></li>
                    <li><a href="<?=base_url('admin/genset');?>"><i class="fas fa-caret-right"></i> General Setting</a></li>
                </ul>
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
    