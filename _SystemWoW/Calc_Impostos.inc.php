<?php
if(!in_array($key['taxa'], $Array0001)):
    array_push($Array0001, $key['taxa']);

    $Array0002[$key['taxa']] = [
        'count' => 1,
        'type' => $key['taxa'] == 0 ? "Isento" : $key['taxType'],
        'valor' => $valor,
        'iva' => $iva,
        'taxa' => $key['taxa']
    ];
else:
    $Array0002[$key['taxa']]['count'] += 1;
    $Array0002[$key['taxa']]['valor'] += $valor;
    $Array0002[$key['taxa']]['iva'] += $iva;
    $Array0002[$key['taxa']]['taxa'] = $key['taxa'];
endif;