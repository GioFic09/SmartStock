<?php

define('DB_HOST', 'junction.proxy.rlwy.net');
define('DB_NAME', 'railway'); // Nome do banco de dados
define('DB_USER', 'root');        // Usuário
define('DB_PASS', 'rMUMgzGyPlmPrLcHdLHnBQctnnFjwNPm');        // Senha
define('DB_PORT', '37985');        // Senha

// Conexão inicial sem especificar o banco de dados
$conn_bd_sim = new mysqli(DB_HOST, DB_USER, DB_PASS, "", DB_PORT);

// Verifica se houve erro na conexão inicial
if ($conn_bd_sim->connect_error) {
    die("Erro ao conectar com o servidor MySQL: " . $conn_bd_sim->connect_error);
}

// Criação do banco de dados caso ele não exista
$sql_create_db = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if (!$conn_bd_sim->query($sql_create_db)) {
    die("Erro ao criar o banco de dados: " . $conn_bd_sim->error);
}

// Conecta ao banco de dados específico após garantir que ele existe
$conn_bd_sim->select_db(DB_NAME);

// Define o charset para evitar problemas com acentos
$conn_bd_sim->set_charset("utf8");

?>