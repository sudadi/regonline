<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Admin
            <small>Setting</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Setting <small> Data Users</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12 no-padding">
                            <div class="form-group col-xs-6 col-sm-2">
                                <?=form_button('tambahuser', '<span class="fa fa-user-plus"></span> Tambah User', 'class="btn btn-info" onclick="return tambahuser();"') ;?>
                            </div>
                            <div class="from-group col-xs-6 col-sm-2">
                                <?=form_button('tambahgroup', '<span class="fa fa-users"></span> Tambah Group', 'class="btn btn-info" onclick="return tambahgroup();"') ;?>
                            </div>
                        </div>
                        <div class="clearfix"></div><p/>
                        <div class="box box-info">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Depan</th>
                                            <th>Nama Belakang</th>
                                            <th>Nama Pengguna</th>
                                            <th>Email</th>
                                            <th class="nowrap">Member Of</th>
                                            <th>Status</th>
                                            <th>Opsi</th>
                                        </tr>
                                        <?php 
                                        //$no = $this->uri->segment('3') + 1;
                                        foreach($users as $user){ 
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user->id,ENT_QUOTES,'UTF-8');?></td>
                                            <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                                            <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                                            <td><?php echo htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');?></td>
                                            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                                            <td>
                                                <?php foreach ($user->groups as $group):?>
                                                <div style="padding: 3px 3px 0px 0px;">
                                                    <?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8'),'title="Edit Goup" class="editgroup btn btn-xs btn-success"') ;?><br />
                                                </div>
                                                <?php endforeach?>
                                                </td>
                                                <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'),'title="Deactivate" class="deactivate btn btn-xs btn-info"') : anchor("auth/activate/". $user->id, lang('index_inactive_link'),'title="Activate" class="activate btn btn-xs btn-default"');?></td>
                                                <td><?php echo anchor("auth/edit_user/".$user->id, '<i class="fa fa-edit "></i> Edit', 'title="Edit User" class="edituser btn btn-xs btn-warning"') ;?></td>
                                        </tr>                                            
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <?php //echo $this->pagination->create_links();?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-users"></div>
<script>
function tambahuser(){
    $.ajax({
        url: "<?php echo base_url('auth/create_user')?>",
        type: "GET",
        datatype: "HTML",
        success: function(data){
            $("#modal-users").html(data);
            $("#modal-users").modal();
        }
    });
};
function tambahgroup(){
    $.ajax({
        url: "<?php echo base_url('auth/create_group')?>",
        type: "GET",
        datatype: "HTML",
        success: function(data){
            $("#modal-users").html(data);
            $("#modal-users").modal();
        }
    });
};
$(document).ready(function() {
    $(".deactivate").click(function() {
        url=$(this).attr("href");
        $.ajax({
            url: url,
            type: "GET",
            dataType: "HTML",
            success: function(data){
                $("#modal-users").html(data);
                $("#modal-users").modal();
            }
        });
        return false;
    });
    $(".editgroup").click(function() {
        url=$(this).attr("href");
        $.ajax({
            url: url,
            type: "GET",
            dataType: "HTML",
            success: function(data){
                $("#modal-users").html(data);
                $("#modal-users").modal();
            }
        });
        return false;
    });
    $(".edituser").click(function() {
        url=$(this).attr("href");
        $.ajax({
            url: url,
            type: "GET",
            dataType: "HTML",
            success: function(data){
                $("#modal-users").html(data);
                $("#modal-users").modal();
           }
        });
        return false;
    });
});
</script>