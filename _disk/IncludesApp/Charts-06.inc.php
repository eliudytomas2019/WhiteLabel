<script>
    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-completion-tasks-9'), {
            chart: {
                type: "bar",
                fontFamily: 'inherit',
                height: 240,
                parentHeightOffset: 0,
                toolbar: {
                    show: false,
                },
                animations: {
                    enabled: false
                },
                stacked: true,
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%',
                }
            },
            dataLabels: {
                enabled: false,
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: "Nota de Crédito",
                data: <?= json_encode($F06); ?>
            },{
                name: "Facturas",
                data: <?= json_encode($F03); ?>
            },{
                name: "Factura/Recibo",
                data: <?= json_encode($F02); ?>
            },{
                name: "Proforma",
                data: <?= json_encode($F01); ?>
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
                axisBorder: {
                    show: false,
                },
                type: 'date',
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            labels: <?= json_encode($CharMeses003); ?>,
            colors: ["#cd201f","#376e20", "#176b7c", "#206bc4"],
            legend: {
                show: false,
            },
        })).render();
    });
</script>