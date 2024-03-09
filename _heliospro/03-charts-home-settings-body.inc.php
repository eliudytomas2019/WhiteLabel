<script>
    var barChart = document.getElementById('barChart').getContext('2d');

    var myBarChart = new Chart(barChart, {
        type: 'bar',
        data: {
            labels: <?= json_encode($Counting01_1); ?>,
            datasets : [{
                label: "Clientes",
                backgroundColor: 'rgb(23, 125, 255)',
                borderColor: 'rgb(23, 125, 255)',
                data: <?= json_encode($Counting01); ?>,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
        }
    });

    var barCharts2 = document.getElementById('barCharts2').getContext('2d');

    var barCharts = new Chart(barCharts2, {
        type: 'bar',
        data: {
            labels: <?= json_encode($Counting02_2); ?>,
            datasets : [{
                label: "Itens mais comercializados",
                backgroundColor: 'rgb(23, 125, 255)',
                borderColor: 'rgb(23, 125, 255)',
                data: <?= json_encode($Counting02); ?>,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
        }
    });

    var barCharts3 = document.getElementById('barCharts3').getContext('2d');

    var barCharts1 = new Chart(barCharts3, {
        type: 'bar',
        data: {
            labels: <?= json_encode($Counting03_3); ?>,
            datasets : [{
                label: "Hank dos melhores vendedores",
                backgroundColor: 'rgb(23, 125, 255)',
                borderColor: 'rgb(23, 125, 255)',
                data: <?= json_encode($Counting03); ?>,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
        }
    });
</script>