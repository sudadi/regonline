<!DOCTYPE html>
<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RSO | Reservasi Online</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <!-- datatables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/css/dataTables.bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/v4-shims.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.4.1/css/ionicons.min.css" />
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.8/css/AdminLTE.min.css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?=base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.8/css/skins/skin-black.min.css" />
    <!-- Date Picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/daterangepicker.min.css" />
    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/blue.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
        table tr.aktif {background: #ddd;}
        
        .sidebar-toggle:before {
            content: none !important;
        }
    </style>
    <!-- jQuery 2.2.4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <!-- Bootstrap WYSIHTML5 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wysihtml5/0.3.0/wysihtml5.min.js"></script> -->
    <script src="<?=base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>
</head>
<body class="hold-transition skin-black fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <header class="main-header">
        <a href="<?=base_url();?>" class="logo">
            <span class="logo-mini"><b>R</b>SO</span>
            <span class="logo-lg"><b>Reservasi</b>Online</span>
        </a>
        <nav class="navbar navbar-fixed-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <i class="fas fa-bars"></i>
<!--                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>-->
            </a>
            <?php if($this->ion_auth->logged_in()) { 
                $jmlmsg=count($this->mod_sms->getsms("TransTime",FALSE,"Type='inbox' AND stat='false'"));
                $msgs=$this->mod_sms->getsms("TransTime",TRUE,"Type='inbox' AND stat='false'");
                ?>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="far fa-comments"></i>
                            <span class="label label-success"><?=$jmlmsg;?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have <?=$jmlmsg;?> messages</li>
                            <li>
                                <?php foreach($msgs as $msg) { ?> 
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="<?=base_url('assets/dist/img/user.png');?>" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                <?=$msg->Number;?>
                                                <small><i class="far fa-clock"></i><?=$msg->TransTime;?></small>
                                            </h4>
                                        </a>
                                    </li>
                                </ul>
                                <?php }; ?>
                            </li>
                            <li class="footer"><a href="<?=base_url('admin/sms');?>">See All Messages</a></li>
                      </ul>
                    </li>
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="far fa-bell"></i>
<!--                            <span class="label label-warning">0</span>-->
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 0 notifications</li>
                            <li>
                                <ul class="menu">
                                  <li>
                                    <a href="#">
<!--                                      <i class="fa fa-users text-aqua"></i> 5 new members joined today-->
                                    </a>
                                  </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#"><!--View all--></a></li>
                        </ul>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?=base_url('assets/dist/img/user.png');?>" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?=$this->session->userdata('identity');?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                              <img src="<?=base_url('assets/dist/img/user.png');?>" class="img-circle" alt="User Image">
                              <p>
                                <?php 
                                    echo $this->session->userdata('email');
                                    echo "<small>Member of Groups</small>";
                                    foreach ($this->ion_auth->get_users_groups($this->session->userdata('user_id'))->result() as $group) {
                                        echo "{ ".htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')." } ";
                                    };
                                ?>
                              </p>
                            </li>
                            <li class="user-body">
                                
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?=base_url('auth/logout');?>" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php }; ?>
        </nav>
    </header>

    <?php $this->load->view('admin/sidebar') ;?>
    <?php $this->load->view($page, $content); ?>
      
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 0.0.1b
        </div>
            <strong>Copyright &copy; 2018 <a href="https://rso.go.id">SIRS-RSO</a>.</strong> All rights
            reserved.
    </footer>
</div>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/daterangepicker.min.js"></script>

<!-- Bootstrap Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"></script>
<!-- Datatables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.bootstrap.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.8/js/adminlte.min.js"></script>
<script>
    $(document).ready(function() {
        <?php if($this->session->flashdata('success')){ ?>
            toastr.success("<?php echo $this->session->flashdata('success'); ?>");
        <?php }else if($this->session->flashdata('error')){  ?>
            toastr.error("<?php echo $this->session->flashdata('error'); ?>");
        <?php }else if($this->session->flashdata('warning')){  ?>
            toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
        <?php }else if($this->session->flashdata('info')){  ?>
            toastr.info("<?php echo $this->session->flashdata('info'); ?>");
        <?php } else if($this->session->flashdata('message')){ ?>
            toastr.warning("<?=$this->session->flashdata('message');?>");
        <?php } ?>
    
    });
</script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();
  });
</script>
<!-- iCheck -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });
    $(function () {
     $('#dttable').DataTable();
    });
</script>
</body>
</html>
