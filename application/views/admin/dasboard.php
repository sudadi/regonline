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

<script src="<?=base_url('assets/bower_components/chart.js/Chart.js');?>"></script>  
<script>
$(document).ready(function() {
    
    
    
  'use strict';
  var reservasiChartCanvas = $('#reservasiChart').get(0).getContext('2d');
  var reservasiChart  = new Chart(reservasiChartCanvas);
  var reservasiChartData = {
    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [
      {
        label               : 'Web',
        fillColor           : 'rgb(60,141,188)',
        strokeColor         : 'rgb(60,141,188)',
        pointColor          : 'rgb(60,141,188)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgb(60,141,188)',
        data                : [65, 59, 80, 81, 56, 55, 40]
      },
      {
        label               : 'WA',
        fillColor           : 'rgba(0,166,90,0.7)',
        strokeColor         : 'rgba(0,166,90,0.7)',
        pointColor          : 'rgba(0,166,90,0.7)',
        pointStrokeColor    : 'rgba(0,166,90,0.7)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(0,166,90,0.7)',
        data                : [28, 48, 40, 19, 86, 27, 90]
      },
      {
        label               : 'SMS',
        fillColor           : 'rgba(221,75,57,0.7)',
        strokeColor         : 'rgba(221,75,57,0.7)',
        pointColor          : 'rgba(221,75,57,0.7)',
        pointStrokeColor    : 'rgba(221,75,57,0.7)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(221,75,57,0.7)',
        data                : [28, 30, 50, 35, 70, 60, 90]
      }
    ]
  };

  var reservasiChartOptions = {
    showScale               : true,
    scaleShowGridLines      : false,
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    scaleGridLineWidth      : 1,
    scaleShowHorizontalLines: true,
    scaleShowVerticalLines  : true,
    bezierCurve             : true,
    bezierCurveTension      : 0.3,
    pointDot                : false,
    pointDotRadius          : 4,
    pointDotStrokeWidth     : 1,
    pointHitDetectionRadius : 20,
    datasetStroke           : true,
    datasetStrokeWidth      : 2,
    datasetFill             : false,
    legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
    maintainAspectRatio     : true,
    responsive              : true
  };
  reservasiChart.Line(reservasiChartData, reservasiChartOptions);
 });      
  
</script>