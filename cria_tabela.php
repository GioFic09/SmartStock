<?php
require_once 'db_connect.php';

try {
    // Lê o arquivo SQL
    $sql = file_get_contents(__DIR__ . '/database.sql');
    if (!$sql) {
        throw new Exception("Erro ao ler o arquivo SQL.");
    }

    // Divide o script SQL em múltiplos comandos, caso existam múltiplas instruções
    $queries = explode(';', $sql);

    // Executa cada comando individualmente
    foreach ($queries as $query) {
        $query = trim($query); // Remove espaços em branco extras
        if (!empty($query)) {
            if (!$conn_bd_sim->query($query)) {
                throw new Exception("Erro ao executar a consulta: " . $conn_bd_sim->error);
            }
        }
    }

    echo "Tabelas criadas e dados inseridos com sucesso!";
} catch (Exception $e) {
    die('Erro ao criar tabelas ou inserir dados: ' . $e->getMessage());
} finally {
    $conn_bd_sim->close();
}
?>