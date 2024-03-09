<?php
// Conexão com o banco de dados
$mysqli = new mysqli('localhost', 'root', '', 'prosmart');

if ($mysqli->connect_error) {
    die('Erro na conexão (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Obtenha o menor número de fatura disponível
$result = $mysqli->query("SELECT MIN(fatura_numero) AS min_fatura_numero FROM faturas WHERE fatura_data > '2024-01-31'");
$row = $result->fetch_assoc();
$min_fatura_numero = $row['min_fatura_numero'];

// Decrementa o número da fatura para obter um número de fatura não utilizado
$novo_numero_fatura = $min_fatura_numero - 1;

// Insira a nova fatura com o número de fatura e a data desejada
$stmt = $mysqli->prepare("INSERT INTO faturas (fatura_numero, fatura_data, ...) VALUES (?, '2024-01-31', ...)");
$stmt->bind_param("i", $novo_numero_fatura);

if ($stmt->execute()) {
    echo "Fatura inserida com sucesso!";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
