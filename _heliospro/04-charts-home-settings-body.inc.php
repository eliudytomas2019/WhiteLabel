<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 21/06/2020
 * Time: 00:00
 */
?>
<script>
    var multipleBarChart = document.getElementById('multipleBarChart').getContext('2d');

    var myMultipleBarChart = new Chart(multipleBarChart, {
        type: 'bar',
        data: {
            labels: <?= json_encode($CharMeses003); ?>,
            datasets : [{
                label: "Nota de Crédito",
                backgroundColor: '#9da49d',
                borderColor: '#9da49d',
                data: <?= json_encode($F06); ?>,
            },{
                label: "Nota de Débito",
                backgroundColor: '#71bad0',
                borderColor: '#71bad0',
                data: <?= json_encode($F05); ?>,
            },{
                label: "Recibo (antigo)",
                backgroundColor: '#59d05d',
                borderColor: '#59d05d',
                data: <?= json_encode($F04); ?>,
            },{
                label: "Recibo (atualizado)",
                backgroundColor: '#d027bc',
                borderColor: '#d027bc',
                data: <?= json_encode($F07); ?>,
            },{
                label: "Facturas",
                backgroundColor: '#fdaf4b',
                borderColor: '#fdaf4b',
                data: <?= json_encode($F03); ?>,
            }, {
                label: "Factura/Recibo",
                backgroundColor: '#177dff',
                borderColor: '#177dff',
                data: <?= json_encode($F02); ?>,
            }, {
                label: "Proforma",
                backgroundColor: '#fd215c',
                borderColor: '#fd215c',
                data: <?= json_encode($F01); ?>,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position : 'bottom'
            },
            title: {
                display: true,
                text: 'Dados comercial'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });
</script>
