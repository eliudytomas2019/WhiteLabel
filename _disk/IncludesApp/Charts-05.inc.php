<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-line-stroke'), {
            chart: {
                type: "line",
                fontFamily: 'inherit',
                height: 300,
                parentHeightOffset: 0,
                toolbar: {
                    show: false,
                },
                animations: {
                    enabled: false
                },
            },
            fill: {
                opacity: 1,
            },
            stroke: {
                width: 2,
                lineCap: "round",
                curve: "straight",
            },
            series: [{
                name: "Factura",
                data: <?= json_encode($aAnfo); ?>
            },{
                name: "Factura/Recibo",
                data: <?= json_encode($iAnfo); ?>
            },{
                name: "Nota de credito",
                data: <?= json_encode($eAnfo); ?>
            },{
                name: "Recibo",
                data:  <?= json_encode($nAnfo); ?>
            }],
            grid: {
                padding: {
                    top: -20,
                    right: 0,
                    left: -4,
                    bottom: -4
                },
                strokeDashArray: 4,
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false
                },
                categories: <?= json_encode($Ch2mound); ?>,
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            colors:  ["#3b5998", "#1da1f2", "#ea4c89", "#4a8e21"],
            legend: {
                show: false,
            },
        })).render();
    });
    // @formatter:on
</script>