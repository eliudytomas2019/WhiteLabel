<?php
$postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_INT);
require_once("../../Config.inc.php");

$Read = new Read();
$Read->ExeRead("cv_customer", "WHERE id_db_settings=:i", "i={$postId}");

$EmailsCustomers = " ";
$database_name   = "Exportação de Dados";

if($Read->getResult()):
    foreach($Read->getResult() as $key):
        $EmailsCustomers .= $key['nome']."; ".$key['nif']."; ".$key["endereco"]."; ".$key["telefone"]."; ".$key['email']."; \n";
    endforeach;
endif;

if(!empty($EmailsCustomers)) {
    // Salvar o Sql do backup
    $backup_file_name = $database_name . '_backup_' . time() . '.txt';
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $EmailsCustomers);
    fclose($fileHandler);

    // Download pelo navegador
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file_name));
    ob_clean();
    flush();
    readfile($backup_file_name);
    exec('rm ' . $backup_file_name);
}