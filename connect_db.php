<?php
try {
    $host = 'junction.proxy.rlwy.net';
    $dbname = 'railway';
    $username = 'root';
    $password = 'rMUMgzGyPlmPrLcHdLHnBQctnnFjwNPm';
    $port = '37985';
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>