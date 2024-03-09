<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 05/06/2020
 * Time: 13:54
 */
?>
<script>
    var
        multipleLineChart = document.getElementById('multipleLineChart').getContext('2d'),
        htmlLegendsChart = document.getElementById('htmlLegendsChart').getContext('2d');

    // Chart with HTML Legends

    var gradientStroke = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, '#177dff');
    gradientStroke.addColorStop(1, '#80b6f4');

    var gradientFill = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientFill.addColorStop(0, "rgba(23, 125, 255, 0.7)");
    gradientFill.addColorStop(1, "rgba(128, 182, 244, 0.3)");

    var gradientStroke2 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientStroke2.addColorStop(0, '#f3545d');
    gradientStroke2.addColorStop(1, '#ff8990');

    var gradientFill2 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientFill2.addColorStop(0, "rgba(243, 84, 93, 0.7)");
    gradientFill2.addColorStop(1, "rgba(255, 137, 144, 0.3)");

    var gradientStroke3 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientStroke3.addColorStop(0, '#fdaf4b');
    gradientStroke3.addColorStop(1, '#ffc478');

    var gradientFill3 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientFill3.addColorStop(0, "rgba(253, 175, 75, 0.7)");
    gradientFill3.addColorStop(1, "rgba(255, 196, 120, 0.3)");

    var gradientStroke4 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientStroke4.addColorStop(0, '#ffcef6');
    gradientStroke4.addColorStop(1, '#ffabcf');

    var gradientFill4 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientFill4.addColorStop(0, "#177dff");
    gradientFill4.addColorStop(1, "#177dff");

    var gradientStroke5 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientStroke5.addColorStop(0, "#ffabcf");
    gradientStroke5.addColorStop(1, "#ffabcf");

    var gradientStroke6 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientStroke6.addColorStop(0, "#add381");
    gradientStroke6.addColorStop(1, "#add381");

    var gradientStroke7 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientStroke7.addColorStop(0, "#d35190");
    gradientStroke7.addColorStop(1, "#d35190");

    var gradientStroke8 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
    gradientStroke8.addColorStop(0, "#88d31e");
    gradientStroke8.addColorStop(1, "#88d31e");

    var myHtmlLegendsChart = new Chart(htmlLegendsChart, {
        type: 'line',
        data: {
            labels: <?= json_encode($Ch1mound); ?>,
            datasets: [ {
                label: "Facturas",
                borderColor: gradientStroke2,
                pointBackgroundColor: gradientStroke2,
                pointRadius: 0,
                backgroundColor: gradientFill2,
                legendColor: '#f3545d',
                fill: true,
                borderWidth: 1,
                data: <?= json_encode($aInfo); ?>
            }, {
                label: "Nota de credito",
                borderColor: gradientStroke3,
                pointBackgroundColor: gradientStroke3,
                pointRadius: 0,
                backgroundColor: gradientFill3,
                legendColor: '#fdaf4b',
                fill: true,
                borderWidth: 1,
                data: <?= json_encode($eInfo); ?>
            }, {
                label: "Factura/Recibo",
                borderColor: gradientStroke4,
                pointBackgroundColor: gradientStroke4,
                pointRadius: 0,
                backgroundColor: gradientFill4,
                legendColor: '#177dff',
                fill: true,
                borderWidth: 1,
                data: <?= json_encode($iInfo); ?>
            }, {
                label: "Nota de debito",
                borderColor: gradientStroke5,
                pointBackgroundColor: gradientStroke5,
                pointRadius: 0,
                backgroundColor: gradientStroke5,
                legendColor: '#ffabcf',
                fill: true,
                borderWidth: 1,
                data: <?= json_encode($oInfo); ?>
            }, {
                label: "Recibo (antigo)",
                borderColor: gradientStroke6,
                pointBackgroundColor: gradientStroke6,
                pointRadius: 0,
                backgroundColor: gradientStroke6,
                legendColor: '#add381',
                fill: true,
                borderWidth: 1,
                data: <?= json_encode($uInfo); ?>
            }, {
                label: "Recibo (atualizado)",
                borderColor: gradientStroke7,
                pointBackgroundColor: gradientStroke7,
                pointRadius: 0,
                backgroundColor: gradientStroke7,
                legendColor: '#d35190',
                fill: true,
                borderWidth: 1,
                data: <?= json_encode($xInfo); ?>
            }, {
                label: "Recibo (+atualizado)",
                borderColor: gradientStroke7,
                pointBackgroundColor: gradientStroke8,
                pointRadius: 0,
                backgroundColor: gradientStroke8,
                legendColor: '#88d31e',
                fill: true,
                borderWidth: 1,
                data: <?= json_encode($nInfo); ?>
            }]
        },
        options : {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltips: {
                bodySpacing: 4,
                mode:"nearest",
                intersect: 0,
                position:"nearest",
                xPadding:10,
                yPadding:10,
                caretPadding:10
            },
            layout:{
                padding:{left:15,right:15,top:15,bottom:15}
            },
            scales: {
                yAxes: [{
                    ticks: {
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "500",
                        beginAtZero: false,
                        maxTicksLimit: 5,
                        padding: 20
                    },
                    gridLines: {
                        drawTicks: false,
                        display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        zeroLineColor: "transparent"
                    },
                    ticks: {
                        padding: 20,
                        fontColor: "rgba(0,0,0,0.5)",
                        fontStyle: "500"
                    }
                }]
            },
            legendCallback: function(chart) {
                var text = [];
                text.push('<ul class="' + chart.id + '-legend html-legend">');
                for (var i = 0; i < chart.data.datasets.length; i++) {
                    text.push('<li><span style="background-color:' + chart.data.datasets[i].legendColor + '"></span>');
                    if (chart.data.datasets[i].label) {
                        text.push(chart.data.datasets[i].label);
                    }
                    text.push('</li>');
                }
                text.push('</ul>');
                return text.join('');
            }
        }
    });

    var myLegendContainer = document.getElementById("myChartLegend");

    // generate HTML legend
    myLegendContainer.innerHTML = myHtmlLegendsChart.generateLegend();

    // bind onClick event to all LI-tags of the legend
    var legendItems = myLegendContainer.getElementsByTagName('li');
    for (var i = 0; i < legendItems.length; i += 1) {
        legendItems[i].addEventListener("click", legendClickCallback, false);
    }
</script>
