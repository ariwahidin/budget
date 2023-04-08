<section class="content">
<div class="box-body">
		<script>
		window.onload = function () {

		var chart = new CanvasJS.Chart("chartContainer", {
			title:{
				// text: "Customer Complaints"
			},
			axisY: {
				// title: "Number of Reviews",
				lineColor: "#4F81BC",
				tickColor: "#4F81BC",
				labelFontColor: "#4F81BC",
				gridThickness: 0
			},
			axisY2: {
				title: "Percent",
				suffix: "%",
				gridThickness: 0,
				lineColor: "#C0504E",
				tickColor: "#C0504E",
				labelFontColor: "#C0504E"
			},
			data: [{
					type: "column",
					dataPoints: [
						{ label: "YTD Total Netto", y: 11603652293.32},
						{ label: "YTD Total Netto", y: 10395483354.234},
						{ label: "YTD Total Netto", y: 9160307958},
						{ label: "YTD Total Netto", y: 9139716358.12},
						{ label: "YTD Total Netto", y: 9072838939.3144},
						{ label: "YTD Total Netto", y: 6547819631.9225},
						{ label: "YTD Total Netto", y: 6440694080}
					]
				},{
					type: "column",
					dataPoints: [
						{ label: "YTD Gross Profit", y: 7609429334.7288},
						{ label: "YTD Gross Profit", y: 8241169064.1831},
						{ label: "YTD Gross Profit", y: 5942265478.0538},
						{ label: "YTD Gross Profit", y: 7166331895.9992},
						{ label: "YTD Gross Profit", y: 5852792195.9502},
						{ label: "YTD Gross Profit", y: 4658781162.1342},
						{ label: "YTD Gross Profit", y: 3572165040.7935}
					]
				}
			]
		});
		chart.render();
		createPareto();

		function createPareto(){
			var dps = [];
			var yValue, yTotal = 0, yPercent = 0;
			var percent = [65.5778,79.2764,64.8697,78.4086,64.5089,71.1501,55.4624];
			var label = [
				"JERINDO JAYA ABADI PT (RETAIL)",
				"CV BEFA SUKSES BERKAH",
				"HANDAL INTI BOGA PT",
				"BUMI BERKAH BOGA PT (KOPI KENANGAN)",
				"LION SUPERINDO GD INDUK DRY",
				"CULINA GEMILANG INDONESIA PT",
				"GRAND LUCKY SCBD"
			];

			for(var i = 0; i < chart.data[0].dataPoints.length; i++)
				yTotal += chart.data[0].dataPoints[i].y;
				console.log(yTotal);
			for(var i = 0; i < percent.length; i++) {
				// yValue = chart.data[0].dataPoints[i].y;
				// yPercent += (yValue / yTotal * 100);
				dps.push({label: label[i], y: percent[i] });
			}
			chart.addTo("data", {type:"line", axisYType: "secondary", yValueFormatString: "0.##\"%\"", indexLabel: "{y}", indexLabelFontColor: "#C24642", dataPoints: dps});
			chart.axisY[0].set("maximum", 15000000000, false);
			chart.axisY2[0].set("maximum", 105, false );
			chart.axisY2[0].set("interval", 25 );
		}

		}
		</script>
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<?php $this->view('dashboard/canvas') ?>
		<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
</div>
</section>