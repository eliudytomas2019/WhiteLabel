<?php
require_once("../../Config.inc.php");

$Read = new Read();
$Read->ExeRead("db_settings");

$EmailsCustomers = " ";
$database_name = "Backup_de_emails";

if ($Read->getResult()):
    foreach ($Read->getResult() as $key):
        if ($key['email'] != null || $key['email'] != ''):
            $EmailsCustomers .= $key['email'] . ";\n";
        endif;
    endforeach;
endif;

if (!empty($EmailsCustomers)) {
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
    flush();
    readfile($backup_file_name);
    exec('rm ' . $backup_file_name);
}