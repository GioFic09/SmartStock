<?php

// Código principal
require_once("connect_db.php");
session_start();

// Processa atualização de estoque
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['quantidade'])) {
    $id = intval($_POST['id']);
    $quantidade = intval($_POST['quantidade']);

    try {
        $sql = "UPDATE Estoque_Caixas SET Quantidade = :quantidade WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['quantidade' => $quantidade, 'id' => $id]);
    } catch (PDOException $e) {
        $mensagem = "Erro ao atualizar quantidade: " . $e->getMessage();
    }
}

// Processa exclusão de prateleira
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);

    try {
        $sql = "DELETE FROM Estoque_Caixas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $delete_id]);
    } catch (PDOException $e) {
        $mensagem = "Erro ao excluir prateleira: " . $e->getMessage();
    }
}

// Realiza a consulta ao banco de dados
try {
    $sql = "SELECT id, Tipo_Caixa, Tamanho, Quantidade, Prateleira, Parte_Prateleira FROM Estoque_Caixas";
    $lista = $pdo->query($sql);
} catch (PDOException $e) {
    die("Erro ao buscar dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Stock</title>
  <link rel="stylesheet" href="styleestoque.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!-- Barra lateral -->
    <aside class="sidebar">
      <div class="logo">
        <img src="imagens/Logo Login.png" alt="Smart Stock Logo">
      </div>
      <nav>
        <a href="pedidos.php">Pedidos</a>
        <a href="estoque.php">Estoque</a>
      </nav>
      <div></div>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main-content">
      <div class="prateleiras">
        <?php if (isset($mensagem)): ?>
          <p style="color: green; font-weight: bold;"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <?php
        while ($linha = $lista->fetch(PDO::FETCH_ASSOC)) {
            $id = htmlspecialchars($linha['id']);
            $tipo_caixa = htmlspecialchars($linha['Tipo_Caixa']);
            $tamanho = htmlspecialchars($linha['Tamanho']);
            $quantidade = htmlspecialchars($linha['Quantidade']);
            $prateleira = htmlspecialchars($linha['Prateleira']);
            $parte_prateleira = htmlspecialchars($linha['Parte_Prateleira']);

            echo "<div class='prateleira'>
                    <h3>PRATELEIRA $prateleira</h3>
                    <p><strong>PARTE $parte_prateleira:</strong> Tamanho $tamanho</p>
                    <p><strong>Tipo de Caixa</strong>: $tipo_caixa</p>
                    <p>Quantidade atual: $quantidade</p>
                    <form method='POST'>
                      <input type='hidden' name='id' value='$id'>
                      <label for='quantidade-$id'>Alterar quantidade:</label>
                      <input style='padding: 5px; border-radius: 10px; border: none;' class='btn-quantidade' type='number' id='quantidade-$id' name='quantidade' min='0' value='$quantidade' required>
                      <button style='padding: 5px; border-radius: 10px; background-color: #c0a6e1; border: none;' class='btn-atualizar' type='submit'>Atualizar</button>
                    </form>
                    <form method='POST' onsubmit=\"return confirm('Tem certeza que deseja excluir esta prateleira?')\">
                      <input type='hidden' name='delete_id' value='$id'>
                      <button style='padding: 5px; border-radius: 10px; background-color: #c0a6e1; border: none;' class='btn-apagar' type='submit'>Apagar</button>
                    </form>
                  </div>";
        }
        ?>
      </div>
    </main>
  </div>
</body>
</html>
