<div class="box box-primary">
    <div class="box-header with-border">
    <i class="fa fa-line-chart"></i>
    <h3 class="box-title">Bar Chart</h3>
    </div>
    <div class="box-body">
        <canvas id="bar_chart_" style=""></canvas>
    </div>
</div>

<script>
var data = {
    labels: ["ToDay", "LastDay", "ThisWeek", "LastWeek", "ThisMonth", "LastMonth", "ThisYear", "LastYear"],
    datasets: [
        {
            label: "PO",
            fillColor: "blue",
            data: [90,0,95,1503,338,5919,35964,73405]
        },
        {
            label: "SJ",
            fillColor: "red",
            data: [0,0,0,1404,194,5223,29849,62716]
        },
    ]
};
var options = {
    responsive:true,
    showTooltips: false,
    onAnimationComplete: function () {

        var ctx = this.chart.ctx;
        ctx.font = this.scale.font;
        ctx.fillStyle = this.scale.textColor
        ctx.textAlign = "center";
        ctx.textBaseline = "bottom";

        this.datasets.forEach(function (dataset) {
            dataset.bars.forEach(function (bar) {
                ctx.fillText(bar.value, bar.x, bar.y);
            });
        })
    }
}
var ctx = document.getElementById("bar_chart_").getContext("2d");
var myBarChart = new Chart(ctx).Bar(data,options);
</script>