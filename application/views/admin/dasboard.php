<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>Version 2.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-light-blue"><i class="fa fa-firefox"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Web</span>
                        <span class="info-box-number"><?=$jmlweb;?><small> Pasien</small></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-whatsapp"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Whatsapp</span>
                        <span class="info-box-number"><?=$jmlwa;?><small> Pasien</small></span>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-envelope-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">SMS</span>
                        <span class="info-box-number"><?=$jmlsms;?><small> Pasien</small></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">ALL</span>
                        <span class="info-box-number"><?=$jmlwa+$jmlsms+$jmlweb;?><small> Pasien</small></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monthly Recap Report</h3>
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
                                    <strong>Reservasi <?=date("F Y");?></strong>
                                </p>
                                <div class="chart">
                                    <canvas id="reservasiChart" style="height: 180px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                              <div class="description-block border-right">
                                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                                <h5 class="description-header">$35,210.43</h5>
                                <span class="description-text">TOTAL REVENUE</span>
                              </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                              <div class="description-block border-right">
                                <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                                <h5 class="description-header">$10,390.90</h5>
                                <span class="description-text">TOTAL COST</span>
                              </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                              <div class="description-block border-right">
                                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                                <h5 class="description-header">$24,813.53</h5>
                                <span class="description-text">TOTAL PROFIT</span>
                              </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block">
                                  <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                                  <h5 class="description-header">1200</h5>
                                  <span class="description-text">GOAL COMPLETIONS</span>
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

      for(var i in data) {
        tgl.push(data[i].tgl);
        SMS.push(data[i].SMS);
        WA.push(data[i].WA);
        WEB.push(data[i].WEB);
      }

      var chartdata = {
            type: 'line',
            data:{
                labels: tgl,
                datasets: [ {
                    label: "SMS",
                    fill: false,
                    lineTension: 0.3,
                    backgroundColor: "rgba(204, 0, 0, 0.75)",
                    borderColor: "rgba(204, 0, 0, 0.6)",
                    pointHoverBackgroundColor: "rgba(204, 0, 0, 1)",
                    pointHoverBorderColor: "rgba(204, 0, 0, 1)",
                    data: SMS
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
                    label: "WEB",
                    fill: false,
                    lineTension: 0.3,
                    backgroundColor: "rgb(0, 85, 128, 0.75)",
                    borderColor: "rgba(0, 85, 128, 0.6)",
                    pointHoverBackgroundColor: "rgba(0, 85, 128, 0.75)",
                    pointHoverBorderColor: "rgba(0, 85, 128, 0.75)",
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
    error : function(data) {

    }
  });
});		
</script>