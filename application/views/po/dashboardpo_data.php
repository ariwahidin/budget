<section class="content-header">
    <h1>
    Dashboard Pandurasa Kharisma
    <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body">
            <div class="row">
              <div id="lineChart" class="col-md-12">

              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <!-- BAR CHART -->
                <div class="box box-success">
                  <div class="box-header with-border">
                    <i class="fa fa-bar-chart-o"></i>
                    <h3 class="box-title">Bar Chart PO & SJ</h3>
                  </div>
                  <div class="box-body chart-responsive">
                    <div class="chart" id="bar-chart2" style="height: 300px;"></div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
            </div>
            <!-- BAR CHART AMOUNT -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">Bar Chart PO & SJ Amount</h3>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="bar-chart-amount" style="height: 300px;"></div>
                    </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- FLOT CHARTS -->
<script src="<?=base_url()?>assets/bower_components/Flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?=base_url()?>assets/bower_components/Flot/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?=base_url()?>assets/bower_components/Flot/jquery.flot.pie.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="<?=base_url()?>assets/bower_components/Flot/jquery.flot.categories.js"></script>
<!-- Morris.js charts -->
<script src="<?=base_url()?>assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?=base_url()?>assets/bower_components/morris.js/morris.min.js"></script>
<!-- page script -->

<?php
  $data = $po_sj->result_array();
  $data2 = $amount->result_array();
    // var_dump($data2);

  $params = [];
  $params =[
      $po = $data[0]['Desc'],
      $poToDay = $data[0]['ToDay'],
      $poLastDay = $data[0]['LastDay'],
      $poThisWeek = $data[0]['ThisWeek'],
      $poLastWeek = $data[0]['LastWeek'],
      $poThisMonth = $data[0]['ThisMonth'],
      $poLastMonth = $data[0]['LastMonth'],
      $poThisYear = $data[0]['ThisYear'],
      $poLastYear = $data[0]['LastYear'],
      $sj = $data[1]['Desc'],
      $sjToDay = $data[1]['ToDay'],
      $sjLastDay = $data[1]['LastDay'],
      $sjThisWeek = $data[1]['ThisWeek'],
      $sjLastWeek = $data[1]['LastWeek'],
      $sjThisMonth = $data[1]['ThisMonth'],
      $sjLastMonth = $data[1]['LastMonth'],
      $sjThisYear = $data[1]['ThisYear'],
      $sjLastYear = $data[1]['LastYear'],
      'amountPo' => $data2,
  ];
?>
<script>
  $('#lineChart').load('<?=site_url('dashboardpo/LineChart')?>')
</script>
<script>
$(function () {
  //BAR CHART
      var bar = new Morris.Bar({
      element: 'bar-chart2',
      resize: true,
      data: [
        {y: 'ToDay', a: <?=$params[1]?>, b: <?=$params[10]?>},
        {y: 'LastDay', a: <?=$params[2]?>, b:<?=$params[11]?> },
        {y: 'ThisWeek', a: <?=$params[3]?>, b: <?=$params[12]?>},
        {y: 'LastWeek', a: <?=$params[4]?>, b: <?=$params[13]?>},
        {y: 'ThisMonth', a: <?=$params[5]?>, b:<?=$params[14]?> },
        {y: 'LastMonth', a: <?=$params[6]?>, b:<?=$params[15]?> },
        // {y: 'ThisYear', a: <?=$params[7]?>, b:<?=$params[16]?> },
        // {y: 'LastYear', a: <?=$params[8]?>, b:<?=$params[17]?> },
      ],
      barColors: ['#00a65a', '#f56954'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['<?=$params[0]?>', '<?=$params[9]?>'],
      hideHover: 'auto'
  });

   //BAR CHART AMOUNT
   var bar = new Morris.Bar({
      element: 'bar-chart-amount',
      resize: true,
      data: [
        {y: 'ToDay', a: <?=$params['amountPo'][0]['ToDay']?>, b: <?=$params['amountPo'][1]['ToDay']?>},
        {y: 'LastDay', a: <?=$params['amountPo'][0]['LastDay']?>, b:<?=$params['amountPo'][1]['LastDay']?> },
        {y: 'ThisWeek', a: <?=$params['amountPo'][0]['ThisWeek']?>, b: <?=$params['amountPo'][1]['ThisWeek']?>},
        {y: 'LastWeek', a: <?=$params['amountPo'][0]['Lastweek']?>, b: <?=$params['amountPo'][1]['Lastweek']?>},
        {y: 'ThisMonth', a: <?=$params['amountPo'][0]['ThisMonth']?>, b:<?=$params['amountPo'][1]['ThisMonth'] == null ? 0 : $params['amountPo'][1]['ThisMonth'] ?> },
        {y: 'LastMonth', a: <?=$params['amountPo'][0]['LastMonth']?>, b:<?=$params['amountPo'][1]['LastMonth']?> },
        // {y: 'ThisYear', a: <?=$params['amountPo'][0]['ThisYear']?>, b:<?=$params['amountPo'][1]['ThisYear']?> },
        // {y: 'LastYear', a: <?=$params['amountPo'][0]['LastYear']?>, b:<?=$params['amountPo'][1]['LastYear']?> },
      ],
      barColors: ['#0f0ebc', '#dd811a'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['<?=$params['amountPo'][0]['Desc']?>', '<?=$params['amountPo'][1]['Desc']?>'],
      hideHover: ''
  });

})
</script>



