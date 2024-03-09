<?php
$Read = new Read();
$Read->ExeRead("cv_customer_arquivo", "WHERE id_paciente=:i AND id_db_settings=:ip ", "i={$postid}&ip={$id_db_settings}");

if($Read->getResult()):
    foreach ($Read->getResult() as $key):

        $files = explode(".", $key['files']);

        if($files[1] == "jpg" || $files[1] == "png" || $files[1] == "jpeg"):
            $arq = '<!-- Download SVG icon from http://tabler-icons.io/i/photo -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="15" y1="8" x2="15.01" y2="8" /><rect x="4" y="4" width="16" height="16" rx="3" /><path d="M4 15l4 -4a3 5 0 0 1 3 0l5 5" /><path d="M14 14l1 -1a3 5 0 0 1 3 0l2 2" /></svg>';
            $arq .= " (imagem.{$files[1]})";
        else:
            $arq = '<!-- Download SVG icon from http://tabler-icons.io/i/file-invoice -->
	<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="9" y1="7" x2="10" y2="7" /><line x1="9" y1="13" x2="15" y2="13" /><line x1="13" y1="17" x2="15" y2="17" /></svg>';
            $arq .= " (ficheiro.{$files[1]})";
        endif;
        ?>
        <tr>
            <td><?= $key['id']; ?></td>
            <td><?= $arq; ?></td>
            <td><?= $key['data']; ?></td>
            <td><?= $key['hora']; ?></td>
            <td>
                <a href="down.php?postid=<?= $key['files']; ?>" target="_blank" class="btn btn-default btn-sm"><!-- Download SVG icon from http://tabler-icons.io/i/paperclip -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5" /></svg> Baixar</a>

                <a href="javascript:void" onclick="DeleteArquivo(<?= $postid; ?>, <?= $key['id']; ?>)" class="btn btn-danger btn-sm"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg> Apagar</a>
            </td>
        </tr>
    <?php
    endforeach;
endif;
?>