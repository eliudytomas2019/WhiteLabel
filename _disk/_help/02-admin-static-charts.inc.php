<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('02-admin-static-charts'), {
            chart: {
                type: "area",
                fontFamily: 'inherit',
                height: 240,
                parentHeightOffset: 0,
                toolbar: {
                    show: false,
                },
                animations: {
                    enabled: false
                },
            },
            dataLabels: {
                enabled: false,
            },
            fill: {
                opacity: .16,
                type: 'solid'
            },
            stroke: {
                width: 2,
                lineCap: "round",
                curve: "smooth",
            },
            series: [{
                name: "Usuários activos",
                data: <?= json_encode($users_actives); ?>
            },{
                name: "Empresas Registradas",
                data: <?= json_encode($empresas_novasz); ?>
            },{
                name: "Empresas que Acederam",
                data: <?= json_encode($empresas_actives); ?>
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
            labels: <?= json_encode($mess); ?>,
            colors: ["#3b5998", "#1da1f2", "#105e38"],
            legend: {
                show: false,
            },
        })).render();
    });
    // @formatter:on
</script>