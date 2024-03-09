<?php
/**
 * Created by PhpStorm.
 * User: Kwanzar Soft
 * Date: 05/06/2020
 * Time: 15:50
 */
?>
<script>
    var myMultipleLineChart = new Chart(multipleLineChart, {
        type: 'line',
        data: {
            labels: <?= json_encode($Ch2mound); ?>,
            datasets: [{
                label: "Factura/Recibo",
                borderColor: "#1d7af3",
                pointBorderColor: "#FFF",
                pointBackgroundColor: "#1d7af3",
                pointBorderWidth: 2,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 1,
                pointRadius: 4,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: <?= json_encode($iAnfo); ?>
            },{
                label: "Factura",
                borderColor: "#59d05d",
                pointBorderColor: "#FFF",
                pointBackgroundColor: "#59d05d",
                pointBorderWidth: 2,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 1,
                pointRadius: 4,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: <?= json_encode($aAnfo); ?>
            }, {
                label: "Nota de credito",
                borderColor: "#f3545d",
                pointBorderColor: "#FFF",
                pointBackgroundColor: "#f3545d",
                pointBorderWidth: 2,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 1,
                pointRadius: 4,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: <?= json_encode($eAnfo); ?>
            }, {
                label: "Nota de debito",
                borderColor: "#a972f3",
                pointBorderColor: "#FFF",
                pointBackgroundColor: "#ca56f3",
                pointBorderWidth: 2,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 1,
                pointRadius: 4,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: <?= json_encode($oAnfo); ?>
            }, {
                label: "Recibo (antigo)",
                borderColor: "#4de9fd",
                pointBorderColor: "#FFF",
                pointBackgroundColor: "#4de9fd",
                pointBorderWidth: 2,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 1,
                pointRadius: 4,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: <?= json_encode($uAnfo); ?>
            }, {
                label: "Recibo (atualizado)",
                borderColor: "#fd52c7",
                pointBorderColor: "#FFF",
                pointBackgroundColor: "#fd52c7",
                pointBorderWidth: 2,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 1,
                pointRadius: 4,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: <?= json_encode($xAnfo); ?>
            }, {
                label: "Recibo (+atualizado)",
                borderColor: "#fd0687",
                pointBorderColor: "#FFF",
                pointBackgroundColor: "#fd0687",
                pointBorderWidth: 2,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 1,
                pointRadius: 4,
                backgroundColor: 'transparent',
                fill: true,
                borderWidth: 2,
                data: <?= json_encode($nAnfo); ?>
            }]
        },
        options : {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'top',
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
            }
        }
    });
</script>
