<?php
  $summary = $summary->result_array()[0];
//   var_dump($summary['Hour8']);
?>
<div class="box box-primary">
    <div class="box-header with-border">
    <i class="fa fa-line-chart"></i>
    <h3 class="box-title">Line Chart PO Summary <?=$summary['Year']?></h3>
    <!-- <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div> -->
    </div>
    <div class="box-body">
        <canvas id="chart3" style="width:100%;height:300px"></canvas>
    </div>
</div>

<script>
    var data_line = {
    labels: ["Hours8", "Hours9", "Hours10", "Hours11", "Hours12", "Hours13", "Hours14", "Hours15", "Hours16", "Hours17", "Hours18", "Hours19", "Hours20", "Hours21", "Hours22", "Hours23"],
    datasets: [{
    label: "My First dataset",
    fillColor: "rgba(220,220,220,0.2)",
    strokeColor: "rgba(220,220,220,1)",
    pointColor: "rgba(220,220,220,1)",
    pointStrokeColor: "#fff",
    pointHighlightFill: "#fff",
    pointHighlightStroke: "rgba(220,220,220,1)",
    data: [<?=$summary['Hour8']?>,
            <?=$summary['Hour9']?>,
            <?=$summary['Hour10']?>,
            <?=$summary['Hour11']?>,
            <?=$summary['Hour12']?>,
            <?=$summary['Hour13']?>,
            <?=$summary['Hour14']?>,
            <?=$summary['Hour15']?>,
            <?=$summary['Hour16']?>,
            <?=$summary['Hour17']?>,
            <?=$summary['Hour18']?>,
            <?=$summary['Hour19']?>,
            <?=$summary['Hour20']?>,
            <?=$summary['Hour21']?>,
            <?=$summary['Hour22']?>,
            <?=$summary['Hour23']?>,
        ]
  }]
};


var options = {
  tooltipTemplate: "<%= value %>",
  showTooltips: true,
  onAnimationComplete: function() {
    this.showTooltip(this.datasets[0].points, true);
  },
  tooltipEvents: []
}

var context = $('#chart3').get(0).getContext('2d');
var chart = new Chart(context).Line(data_line, options);
</script>