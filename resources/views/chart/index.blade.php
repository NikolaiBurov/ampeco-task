<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</head>
<body class="antialiased">
<div>
    <div style="width: 75%">
        <canvas id="canvas"></canvas>
    </div>
</div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartDataHours = {!! $chartData['hours'] !!};

    let chartDataValues = {!! $chartData['values'] !!};

    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(231,233,237)'
    };

    var ctx = document.getElementById("canvas").getContext("2d");

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartDataHours,
            datasets: [{
                label: '',
                borderColor: window.chartColors.blue,
                borderWidth: 2,
                fill: true,
                data: chartDataValues//[22_000,13_000,26_000]
            }]
        }
    });
</script>
