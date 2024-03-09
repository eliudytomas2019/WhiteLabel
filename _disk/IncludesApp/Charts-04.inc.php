<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-completion-tasks-6'), {
            chart: {
                type: "bar",
                fontFamily: 'inherit',
                height: 201,
                parentHeightOffset: 0,
                toolbar: {
                    show: false,
                },
                animations: {
                    enabled: false
                },
            },
            plotOptions: {
                bar: {
                    barHeight: '50%',
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false,
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: <?= json_encode($Counting02_2); ?>,
                data: <?= json_encode($Counting02); ?>
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
            labels:  <?= json_encode($Counting02_2); ?>,
            colors: ["#c91478", "#a620c4", "#8e56b4", "#ad2391", "#563246"],
            legend: {
                show: false,
            },
        })).render();
    });
    // @formatter:on
</script>