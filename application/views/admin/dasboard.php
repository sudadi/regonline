<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>Reservasi :: RSO</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="info-box">
                    <span class="info-box-icon bg-light-blue"><i class="fab fa-telegram-plane"></i></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Telegram</span>
                        <span class="info-box-number"><?=$jmltele;?><small> Pasien</small></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fab fa-whatsapp"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Whatsapp</span>
                        <span class="info-box-number"><?=$jmlwa;?><small> Pasien</small></span>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="far fa-comments"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">SMS</span>
                        <span class="info-box-number"><?=$jmlsms;?><small> Pasien</small></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fab fa-chrome"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">WEB</span>
                        <span class="info-box-number"><?=$jmlweb;?><small> Pasien</small></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Weekly Recap Report</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-wrench"></i></button>
                            </div>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center">
                                    <strong>Reservation Entry</strong>
                                </p>
                                <div class="chart">
                                    <canvas id="entryChart" style="height: 180px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <h5 class="box-title">Weekday Comparison</h5>
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                              <div class="description-block border-right">
                                <span id="spantele" class="description-percentage"></span>
                                <h5 class="description-header"><?=$percenttele;?> %</h5>
                                <span class="description-text text-light-blue">Reservasi TG</span>
                              </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                              <div class="description-block border-right">
                                <span id="spanwa" class="description-percentage"></span>
                                <h5 class="description-header"><?=$percentwa;?> %</h5>
                                <span class="description-text text-green">Reservasi WA</span>
                              </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                              <div class="description-block border-right">
                                <span id="spansms" class="description-percentage"></i></span>
                                <h5 class="description-header"><?=$percentsms;?> %</h5>
                                <span class="description-text text-yellow">Reservasi SMS</span>
                              </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block">
                                  <span id="spanweb" class="description-percentage"></span>
                                  <h5 class="description-header"><?=$percentweb;?> %</h5>
                                  <span class="description-text text-red">Reservasi WEB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">2 Weekly Recap Report</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-wrench"></i></button>
                            </div>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center">
                                    <strong>Reservation Destination</strong>
                                </p>
                                <div class="chart">
                                    <canvas id="reservasiChart" style="height: 180px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </section>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>  
<script>
$(document).ready(function(){
    $.ajax({
        url : "<?=base_url('admin/ajaxdashres');?>",
        type : "GET",
        dataType: "JSON",
        success : function(data){
            console.log(data);
            var tgl = [];
            var SMS = [];
            var WA = [];
            var WEB = [];
            var TG = [];
            for(var i in data) {
                tgl.push(data[i].tgl);
                SMS.push(data[i].SMS);
                WA.push(data[i].WA);
                WEB.push(data[i].WEB);
                TG.push(data[i].TG);
            }
            var chartdata = {
                type: 'line',
                data:{
                    labels: tgl,
                    datasets: [ {
                        label: "TG",
                        fill: false,
                        lineTension: 0.3,
                        backgroundColor: "rgb(60, 141, 188, 0.75)",
                        borderColor: "rgba(60, 141, 188, 0.6)",
                        pointHoverBackgroundColor: "rgba(60, 141, 188, 0.75)",
                        pointHoverBorderColor: "rgba(60, 141, 188, 0.75)",
                        data: TG
                      }, {
                        label: "WA",
                        fill: false,
                        lineTension: 0.3,
                        backgroundColor: "rgb(0, 153, 51, 0.75)",
                        borderColor: "rgb(0, 153, 51, 0.6)",
                        pointHoverBackgroundColor: "rgba(0, 153, 51, 0.5)",
                        pointHoverBorderColor: "rgba(0, 153, 51, 0.5)",
                        data: WA
                      }, {
                        label: "SMS",
                        fill: false,
                        lineTension: 0.3,
                        backgroundColor: "rgba(255, 133, 27, 0.75)",
                        borderColor: "rgba(255, 133, 27, 0.6)",
                        pointHoverBackgroundColor: "rgba(255, 133, 27, 1)",
                        pointHoverBorderColor: "rgba(255, 133, 27, 1)",
                        data: SMS
                      }, {
                        label: "WEB",
                        fill: false,
                        lineTension: 0.3,
                        backgroundColor: "rgb(204, 0, 0, 0.75)",
                        borderColor: "rgba(204, 0, 0, 0.6)",
                        pointHoverBackgroundColor: "rgba(204, 0, 0, 0.75)",
                        pointHoverBorderColor: "rgba(204, 0, 0, 0.75)",
                        data: WEB
                      }
                    ]
                }, 
                options: {
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }
                }
            };
            var ctx = document.getElementById('entryChart').getContext('2d');
            var LineGraph = new Chart(ctx, chartdata);
        },
        error : function(data) { }
    });
    var wa = <?=$percentwa;?>;
    var web = <?=$percentweb;?>;
    var sms = <?=$percentsms;?>;
    var tele = <?=$percenttele;?>;
    function getClass(value){
        if (value > 0) {
            var cls='text-green fa fa-caret-up';
        } else if (value < 0) {
            var cls='text-red fa fa-caret-down';
        } else {
            var cls='text-orange fa fa-caret-left';
        }
        return cls;
    }
    $("#spanwa").addClass(getClass(wa));
    $("#spanweb").addClass(getClass(web));
    $("#spansms").addClass(getClass(sms));
    $("#spantele").addClass(getClass(tele));
    
    $.ajax({
        url : "<?=base_url('admin/ajaxdashres2');?>",
        type : "GET",
        dataType: "JSON",
        success : function(data){
            console.log(data);
            var tgl = [];
            var SMS = [];
            var WA = [];
            var WEB = [];
            var TG = [];
            for(var i in data) {
                tgl.push(data[i].tgl);
                SMS.push(data[i].SMS);
                WA.push(data[i].WA);
                WEB.push(data[i].WEB);
                TG.push(data[i].TG);
            }
            var chartdata = {
                type: 'line',
                data:{
                    labels: tgl,
                    datasets: [ {
                        label: "TG",
                        fill: false,
                        lineTension: 0.3,
                        backgroundColor: "rgb(60, 141, 188, 0.75)",
                        borderColor: "rgba(60, 141, 188, 0.6)",
                        pointHoverBackgroundColor: "rgba(60, 141, 188, 0.75)",
                        pointHoverBorderColor: "rgba(60, 141, 188, 0.75)",
                        data: TG
                      }, {
                        label: "WA",
                        fill: false,
                        lineTension: 0.3,
                        backgroundColor: "rgb(0, 153, 51, 0.75)",
                        borderColor: "rgb(0, 153, 51, 0.6)",
                        pointHoverBackgroundColor: "rgba(0, 153, 51, 0.5)",
                        pointHoverBorderColor: "rgba(0, 153, 51, 0.5)",
                        data: WA
                      }, {
                        label: "SMS",
                        fill: false,
                        lineTension: 0.3,
                        backgroundColor: "rgba(255, 133, 27, 0.75)",
                        borderColor: "rgba(255, 133, 27, 0.6)",
                        pointHoverBackgroundColor: "rgba(255, 133, 27, 1)",
                        pointHoverBorderColor: "rgba(255, 133, 27, 1)",
                        data: SMS
                      }, {
                        label: "WEB",
                        fill: false,
                        lineTension: 0.3,
                        backgroundColor: "rgb(204, 0, 0, 0.75)",
                        borderColor: "rgba(204, 0, 0, 0.6)",
                        pointHoverBackgroundColor: "rgba(204, 0, 0, 0.75)",
                        pointHoverBorderColor: "rgba(204, 0, 0, 0.75)",
                        data: WEB
                      }
                    ]
                }, 
                options: {
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }
                }
            };
            var ctx = document.getElementById('reservasiChart').getContext('2d');
            var LineGraph = new Chart(ctx, chartdata);
        },
        error : function(data) { }
    });
});		
</script>