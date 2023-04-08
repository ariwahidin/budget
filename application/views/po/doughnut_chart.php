    <style>
      * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
      }
      .chartMenu {
        width: 100vw;
        height: 40px;
        background: #1A1A1A;
        color: rgba(255, 26, 104, 1);
      }
      .chartMenu p {
        padding: 10px;
        font-size: 20px;
      }
      .chartCard {
        width: 100vw;
        height: calc(100vh - 40px);
        background: rgba(255, 26, 104, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .chartBox {
        width: 700px;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(255, 26, 104, 1);
        background: white;
      }
    </style>

    <div class="chartCard">
      <div class="chartBox" >
        <canvas id="myChart"></canvas>
      </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // setup 
    const data = {
      labels: ['Hours8', 'Hours9', 'Hours10', 'Hours11', 'Hours12', 'Hours13', 'Hours14', 'Hours15', 'Hours16','Hours17','Hours18', 'Hours19', 'Hours20', 'Hours21', 'Hours22', 'Hours23'],
      datasets: [{
        label: 'Weekly Sales',
        data: [300, 200, 100, 220, 212, 321, 219, 212, 312, 213, 213, 212, 321, 212, 0, 0,],
        backgroundColor: [
          'rgba(255, 26, 104, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(0, 0, 0, 0.2)'
        ],
        borderColor: [
          'rgba(255, 26, 104, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(0, 0, 0, 1)'
        ],
        borderWidth: 1,
        cutout: '50%',
        // borderRadius:20,
      }]
    };

    //doughnutLabelsLine plugin
    const doughnutLabelsLine = {
        id: 'doughnutLabelsLine',
        afterDraw(chart, args, options){
            const { ctx, chartArea: { top, bottom, left, right, width, height } } = chart;

            chart.data.datasets.forEach((dataset, i) => {
                chart.getDatasetMeta(i).data.forEach((datapoint, index) => {
                    // console.log(chart.data.labels)
                    const { x, y } = datapoint.tooltipPosition();
                    
                    // ctx.fillStyle = dataset.borderColor[index];
                    // ctx.fill(); 
                    // ctx.fillRect(x, y, 10, 10);
                    
                    // console.log(x)

                    // draw line
                    const halfwidth = width / 2; 
                    const halfheight = height / 2;
                    
                    const xLine = x >= halfwidth ? x + 40 : x - 40;
                    const yLine = y >= halfheight ? y + 40 : y - 40;
                    const extraLine = x >= halfwidth ? 40 : -40;
                    // line
                    ctx.beginPath();
                    ctx.moveTo(x, y);
                    ctx.lineTo(xLine, yLine);
                    ctx.lineTo(xLine + extraLine, yLine);
                    ctx.strokeStyle = dataset.borderColor[index];
                    ctx.stroke();
                    
                    //text
                    const textWidth = ctx.measureText(chart.data.labels[index]).width;
                    console.log(textWidth)
                    ctx.font = '14px arial';

                    // control the position
                    const textXPosition = x >= halfwidth ? 'left' : 'right';
                    const plusFivePx = x >= halfwidth ? 5 : -5 ;
                    ctx.textAlign = textXPosition;
                    ctx.textBaseline = 'middle';
                    ctx.fillStyle = dataset.borderColor[index];
                    ctx.fillText(chart.data.labels[index], xLine + extraLine + plusFivePx, yLine);
                })
            })  
        }
    }

    // config 
    const config = {
      type: 'doughnut',
      data,
      options: {
        layout: {
            padding: 50
        },
        maintainAspectRatio: false, 
        plugins: {
            legend:{
                display: false
            }
        }
      },
      plugins: [doughnutLabelsLine]
    };

    // render init block
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
    </script>
