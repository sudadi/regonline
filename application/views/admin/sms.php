<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            SMS
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">SMS</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-3">
                <?=form_button('tulissms', '<span class="fa fa-plus"></span> Tulis Pesan', 'class="btn btn-primary btn-block margin-bottom" data-toggle="modal" data-target="#modal-sms"') ;?>
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">No. Telp</h3>
                        
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <div class="table-responsive mailbox-messages">
                            <table id="tnotelp" class="table">
                                <?php //var_dump($datanotelp);
                                foreach ($datanotelp as $notelp) {?>
                                <tr style="cursor: pointer;">
                                    <?=($notelp->stat == 'false' && $notelp->Type == 'inbox') ? '<td class="text-bold">':'<td>';
                                        echo $notelp->Number;?>
                                    </td>
                                </tr>
                                <?php }?>
                            </table>
                        </div>
                    </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                       <?php echo $this->pagination->create_links();?>
                  </div>
                </div>
                <!-- /. box -->
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filter</h3>
                            <div class="box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#"><i class="fa fa-circle-o text-red"></i> Belum Baca</a></li>
                                <li><a href="#"><i class="fa fa-circle-o text-green"></i> Sudah Baca</a></li>
                            </ul>
                        </div>
                      <!-- /.box-body -->
                    </div>
                <!-- /.box -->
            </div>
            <div class="col-sm-9 hidden-xs">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pesan</h3>
                        <div class="box-tools pull-right">
                            <div class="has-feedback">
<!--                                <input type="text" class="form-control input-sm" placeholder="Search Mail">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>-->
                            </div>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                            <div class="pull-right">
                                
                            </div>
                            <!-- /.pull-right -->
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped" id="tsms">
                                <tr>
                                    <td>
                                        Data Kosong. Klik/pilih nomer telp di samping. 
                                    </td>
                                </tr>
                            </table>
                            <!-- /.table -->
                        </div>
                      <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-padding">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
<!--                            <div class="pull-right">
                                 <?php echo $this->pagination->create_links();?>
                            </div>-->
                            <!-- /.pull-right -->
                        </div>
                    </div>
                </div>
              <!-- /. box -->
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-sms">
    <?=form_open($action, 'id="formsms" class="form-horizontal form-label-left"'); ?>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Kirim Pesan</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-2">No. Telp </label>
                    <div class="col-sm-4">
                        <?=form_input(array('name'=>'notelp'), '', 'class="form-control" required');?>
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Pesan</label>
                    <div class="col-sm-10">
                        <?= form_textarea(array('name'=>'pesan','rows'=>'3'), '', ' class="form-control" required');?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Kirim</button>
            </div>
        </div>
    </div>
    <?=form_close();?>
</div>
<div class='device-check visible-xs' data-device='xs'></div>
<div class='device-check visible-sm' data-device='sm'></div>
<div class='device-check visible-md' data-device='md'></div>
<div class='device-check visible-lg' data-device='lg'></div>
<script>
    function get_current(){
    return $('.device-check:visible').attr('data-device')
    };
    
    $(document).ready(function(){
    $("#tnotelp tr").click(function(){
        $("#tnotelp tr").removeClass("aktif");
        $(this).toggleClass("aktif");
        var notelp = $(this).find("td").eq(0).html().trim(); 
         $.ajax({
                url : "<?php echo site_url('admin/ajaxsms/')?>",
                type: "POST",
                data: {notelp : notelp},
                dataType: "JSON",
                success: function(data)
                {
                    $("#tsms").empty();
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].Type === 'outbox') {
                            $("#tsms").append('<tr class="text-blue"><td style="width:20px"><input type="checkbox" name="cek" value=""  /></td>'+
                                    '<td class="mailbox-subject"><span class="fa fa-reply text-blue"></span>&nbsp;&nbsp;'+data[i].TextDecoded+'</td>'+
                                    '<td class="mailbox-date text-right">'+data[i].UpdatedInDB+'</td></tr>');
                        } else {
                            $("#tsms").append('<tr>'+
                                '<td style="width:10px"><input type="checkbox" name="cek" value=""  /></td>'+
                                '<td class="mailbox-subject"><span class="fa fa-inbox"></span>&nbsp;&nbsp;'+data[i].TextDecoded+'</td>'+
                                '<td class="mailbox-date text-right">'+data[i].UpdatedInDB+'</td></tr>');
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error : Data tidak ditemukan..!');
                }
            });
    });
});
</script>