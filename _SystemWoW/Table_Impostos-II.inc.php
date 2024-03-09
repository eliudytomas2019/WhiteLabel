<h2>Tax Summary</h2>
<table>
    <thead>
    <tr>
        <th>Description</th>
        <th>Rate%</th>
        <th>Incidence</th>
        <th>Total Tax</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($Array0002 as $Itachi):
        ?>
        <tr>
            <td><?= '<small style="color: #000">('.$Itachi['count'].') '.$Itachi["type"].'</small>'; ?></td>
            <td><?= str_replace(",", ".", number_format($Itachi['taxa'], 2)); ?></td>
            <td><?= str_replace(",", ".", number_format($Itachi['valor'], 2)); ?></td>
            <td><?= str_replace(",", ".", number_format($Itachi['iva'], 2)); ?></td>
        </tr>
    <?php
    endforeach;
    ?>
    </tbody>
</table>

<table>
    <thead>
    <tr>
        <th>VAT regime</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?= $k['config_regimeIVA']; ?></td>
    </tr>
    </tbody>
</table>