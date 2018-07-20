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
            <li class="active"><a href="<?=base_url('admin/sms');?>">SMS</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div id="dvnotelp" class="col-sm-3 col-xs-12">
                <?=form_button('tulissms', '<span class="fa fa-plus"></span> Tulis Pesan', 'class="btn btn-primary btn-block margin-bottom" data-toggle="modal" data-target="#modal-sms"') ;?>
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">No. Telp</h3>
                        
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <ul class="nav nav-pills nav-stacked ulnotelp">
                            <?php foreach ($datanotelp as $notelp) {?>
                            <li class="linotelp"><a href="#"><i class="<?=($notelp->stat == 'false' && $notelp->Type == 'inbox') ? 'fa fa-circle text-red':'fa fa-circle-o text-green';?>"></i>
                                    <span class="spnotelp text-bold"><?=$notelp->Number;?></span></a></li>   
                            <?php } ?>
                        </ul>
<!--                        <div class="table-responsive mailbox-messages">
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
                        </div>-->
                    </div>
                  <!-- /.box-body -->
                  <div class="box-footer text-center">
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
                        <div class="box-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#"><i class="fa fa-circle text-red"></i> Belum Baca</a></li>
                                <li><a href="#"><i class="fa fa-circle-o text-green"></i> Sudah Baca</a></li>
                            </ul>
                        </div>
                      <!-- /.box-body -->
                    </div>
                <!-- /.box -->
            </div>
            <div id="msgbox" class="col-sm-9 col-xs-12 hidden-xs">
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
                            <button type="button" id="btnbackxs" class="btn btn-primary btn-sm visible-xs text-bold">Back</button>
                            <!-- Check all button -->
<!--                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                            </div>
                             /.btn-group 
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                            <div class="pull-right">
                                
                            </div>-->
                            <!-- /.pull-right -->
                        </div>
                        <div class="mailbox-messages">
                            <table class="table table-hover table-striped" id="tsms">
                                <tr>
                                    <td style="word-wrap: break-word;">
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
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle" id="checkAll"><i class="fa fa-square-o"></i></button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" id="btn_hapus" title="Hapus"><i class="fa fa-trash-o"></i></button>
                                <button type="button" class="btn btn-default btn-sm" id="btn_balas" title="Balas"><i class="fa fa-reply"></i></button>
                                <button type="button" class="btn btn-default btn-sm" id="btn_terus" title="Teruskan"><i class="fa fa-share"></i></button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm" id="btn_refresh" title="Penyegaran"><i class="fa fa-refresh"></i></button>
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
                        <?=form_input(array('name'=>'notelp', 'id'=>'notelp', 'placeholder'=>'08xxxxxxxx'), '', 'class="form-control" required');?>
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Pesan</label>
                    <div class="col-sm-10">
                        <?= form_textarea(array('name'=>'pesan','rows'=>'3','id'=>'pesan','placeholder'=>'Tulis pesan disini..'), '', ' class="form-control" required');?>
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
$(document).ready(function(){
function get_currdev(){
    return $('.device-check:visible').attr('data-device')
};
    
    var notelp;
//    $("#tnotelp tr").click(function(){
//        $("#tnotelp tr").removeClass("aktif");
//        $(this).toggleClass("aktif");
//        notelp = $(this).find("td").eq(0).html().trim(); 
    $(".linotelp").click(function() {
        notelp = $(this).find('span.spnotelp').text().trim(); 
        $.ajax({
            url : "<?php echo site_url('admin/ajaxsms/')?>",
            type: "POST",
            data: {notelp : notelp},
            dataType: "JSON",
            success: function(data)
            {
                $("#tsms").empty();
                for (var i = 0; i < data.length; i++) {
                    var obstat;
                    if (data[i].Type === 'outbox') {
                        if (data[i].stat == 1) {
                            obstat='text-green';
                        } else {
                            obstat='text-red';
                        }
                        $('<tr class="text-blue" id="'+i+'"><td style="width:20px"><input type="checkbox" name="cek[]" value="'+i+'|'+data[i].ID+'|'+data[i].Type+'" /></td>'+
                                '<td class="mailbox-subject" style="word-wrap: break-word;"><span class="fa fa-reply text-blue"></span>&nbsp;&nbsp;'+data[i].TextDecoded+
                                '<div class="text-sm text-right '+obstat+'">'+data[i].UpdatedInDB+'</div></td></tr>').hide().appendTo("#tsms").fadeIn(1000);
                    } else {
                        $('<tr id="'+i+'">'+
                            '<td style="width:10px"><input type="checkbox" name="cek" value="'+i+'|'+data[i].ID+'|'+data[i].Type+'" /></td>'+
                            '<td class="mailbox-subject" style="word-wrap: break-word;"><span class="fa fa-inbox"></span>&nbsp;&nbsp;'+data[i].TextDecoded+
                            '<div class="text-sm text-right text-green">'+data[i].UpdatedInDB+'</div></td></tr>').hide().appendTo("#tsms").fadeIn(1000);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error : Data tidak ditemukan..!');
            }
        });
        if (get_currdev()=='xs'){
            $("#msgbox").removeClass('hidden-xs').addClass('.visible-xs').show();
            $("#dvnotelp").removeClass('visible-xs').addClass('.hidden-xs').hide();
            $("#btnbackxs").html('<i class="fa fa-backward"></i> '+notelp);
        } else {
            $("#dvnotelp").removeClass('hidden-xs').addClass('.visible-xs').show();
            $("#msgbox").removeClass('visible-xs').addClass('.hidden-xs');
        }
        $(this).find('i.fa').removeClass('fa-circle text-red').addClass('fa-circle-o text-green');
    });
    
    $('#btn_hapus').click(function(){
        if(confirm("Anda yakin akan menghapus data ini?")) {
            var hasil; 
            var nobar = [];
            var id = [];
            var type = [];
            $(':checkbox:checked').each(function(i){
                hasil = $(this).val().split('|');
                nobar[i] = hasil[0];
                id[i] = hasil[1];
                type[i] = hasil[2];
            });
            if(nobar.length === 0) {
                alert("Mohon pilih setidaknya satu checkbox");
            } else {
                $.ajax({
                    url:"<?=base_url('admin/ajaxdelsms');?>",
                    method: "POST",
                    dataType: 'JSON',
                    data: {id:id, type:type} ,
                    success:function(data) {
                        for(var i=0; i<nobar.length; i++) {
                            $('tr#'+nobar[i]+'').css('background-color', '#ccc');
                            $('tr#'+nobar[i]+'').fadeOut('slow');
                        }
                    }     
                });
            }   
        } else {
            return false;
        }
    });
    $('#btn_balas').click(function(){
        $("#notelp").val(notelp);
        $("#modal-sms").modal();
    });
    $("#btn_terus").click(function() {
        $("#pesan").val('');
        $("#modal-sms").modal();
    });
    $("#checkAll").click(function(){
        var cb = $('input:checkbox');
        cb.prop('checked', !cb.prop('checked'));
    });
    $("#btn_refresh").click(function() {
        $("#tnotelp tr").click();
    });
    $("#btnbackxs").click(function () {
        $("#dvnotelp").removeClass('hidden-xs').addClass('.visible-xs').show();
        $("#msgbox").removeClass('visible-xs').addClass('.hidden-xs').hide;
    });
    if (get_currdev() !== 'xs'){
        $(".ulnotelp li:first-child").click();
    }
    
});
</script>