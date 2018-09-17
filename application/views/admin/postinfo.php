<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Admin
            <small>Posting Info</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Postinfo</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12 no-padding">
                            <div class="form-group col-xs-6 col-sm-2">
                                 <?=form_button(array('name'=>'newpost'), '<span class="fa fa-send"></span> New Post', 'class="btn btn-success newpost" onclick="showmodal(this);"');?>
                            </div>
                        </div>
                        <div class="clearfix"></div><p/>
                        <div class="box box-info">
                            
                            <div class="box-header"> </div>
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover" id="dttable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Subject</th>
                                            <th>Content</th>
                                            <th>Start</th>
                                            <th>Stop</th>
                                            <th>Status</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        //$no = $this->uri->segment('3') + 1;
                                        foreach($datainfo as $info){ 
                                        ?>
                                        <tr>
                                            <td><?=$info->id_info;?></td>
                                            <td><?=$info->subject;?></td>
                                            <td><?=word_limiter($info->content, 20);?></td>
                                            <td><?=$info->start;?></td>
                                            <td><?=$info->stop;?></td>
                                            <td><?php
                                                $status=array(0=>'Disable',1=>'Active'); ?>
                                                <span id="status" onclick="updatestat(<?=$info->status;?>,<?=$info->id_info;?>);" class="btn btn-xs <?=($info->status==1) ? 'btn-success':'btn-default';?>" title="Update Status"><?=$status[$info->status];?></span>
                                            </td>
                                            <td class="text-nowrap">
                                                <a href="#" onclick="editinfo(<?=$info->id_info?>)"><span class="btn btn-xs btn-warning"><i class="fa fa-edit "></i> Edit</span></a>
                                                <a href="<?=base_url('admin/postinfo/?hapus='.$info->id_info);?>" onclick="return confirm('Yakin menghapus data ini ?')">
                                                    <span class="btn btn-xs btn-danger"><i class="fa fa-trash "></i> Delete</span></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>
             </div>
        </div>    
    </section>
</div>
<div class="modal fade" id="modal-newpost">
    <?=form_open($action, 'id="forminfo" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Post</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="alasan" class="control-label col-sm-2">Subject</label>
                    <div class="col-sm-8">
                        <?=form_input(array('name'=>'subject','type'=>'text','id'=>'subject','class'=>'form-control'));?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="content" class="control-label col-sm-2">Content</label>
                    <div class="col-sm-10">
                        <?=form_textarea(array('name'=>'content','rows'=>'2','id'=>'content'),'','class="form-control"');?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="start" class="control-label col-sm-2">Publish</label>
                    <div class="col-sm-3">
                        <?=form_input(array('name'=>'start','type'=>'date','id'=>'start','class'=>'form-control'));?>
                    </div>
                    <label for="dpstatus" class="control-label col-sm-2">Status</label>
                    <div class="col-sm-3">
                        <?php
                        unset($option);
                        $option= array(0=>'Disable',1=>'Active',4=>'Batal By User');
                        echo form_dropdown(array('name'=>'dpstatus','id'=>'dpstatus'), $option, 1, 'class="form-control"');
                        ?>
                    </div>
                </div>
                <?=form_input(['name'=>'idinfo','type'=>'hidden','id'=>'idinfo']);?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" name="saveinfo" value="simpan" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
    <?=form_close(); ?>
</div>
<script>
    function updatestat(stat, id) {
        var stat = +!stat;
        var statval = ['Disable','Active'];
        $.ajax({
            url : "<?php echo site_url('admin/ajaxStatInfo/')?>"+stat+"/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data){
               location.reload();
            }
        });
    }
    function showmodal(elm){
        $('#forminfo')[0].reset();
        $('#modal-newpost').modal();
    }
    function editinfo(idinfo) {
        $('#forminfo')[0].reset();
        
    }
</script>