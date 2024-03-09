<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-social-referrals'), {
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
                curve: "smooth",
            },
            series: [{
                name: "Facturas",
                data: <?= json_encode($aInfo); ?>
            },{
                name: "Factura/Recibo",
                data: <?= json_encode($iInfo); ?>
            },{
                name: "Nota de credito",
                data: <?= json_encode($eInfo); ?>
            },{
                name: "Recibo",
                data: <?= json_encode($nInfo); ?>
            }],
            grid: {
                padding: {
                    top: -20,
                    right: 0,
                    left: -4,
                    bottom: -4
                },
                strokeDashArray: 4,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false
                },
                type: 'date',
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            labels:  <?= json_encode($Ch1mound); ?>,
            colors: ["#3b5998", "#1da1f2", "#ea4c89", "#4a8e21"],
            legend: {
                show: true,
                position: 'bottom',
                offsetY: 12,
                markers: {
                    width: 10,
                    height: 10,
                    radius: 100,
                },
                itemMargin: {
                    horizontal: 8,
                    vertical: 8
                },
            },
        })).render();
    });
    // @formatter:on
</script>