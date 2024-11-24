<?php
require_once("connect_db.php");
session_start();

// Tratamento de formulário para atualizar status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_solicitacao'], $_POST['status'])) {
    $idSolicitacao = $_POST['id_solicitacao'];
    $status = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE Solicitacoes_Pedidos SET Status_Separacao = ? WHERE Id_Solicitacao = ?");
        $stmt->execute([$status, $idSolicitacao]);

    } catch (PDOException $e) {
        $mensagem = "Erro no banco de dados: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Smart Stock</title>
    <link rel="stylesheet" href="stylepedidos.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
      rel="stylesheet"
    />
</head>
<body>
    <main>
        <nav>
            <img src="imagens/Logo Login.png" alt="logo" class="logo" />
            <ul class="nav-list">
                <li><a href="pedidos.php">Pedidos</a></li>
                <li><a href="estoque.php">Estoque</a></li>
            </ul>
            <div></div>
        </nav>
        <section class="container">
            <?php if (isset($mensagem)): ?>
                <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
            <?php endif; ?>
            <?php
            $statuses = [
                "ABERTOS" => "Abertos",
                "SEPARANDO" => "Em andamento",
                "CONCLUÍDO" => "Entregue"
            ];

            foreach ($statuses as $columnTitle => $dbStatus) : ?>
                <div class="column">
                    <p class="column-title"><?= $columnTitle ?></p>
                    <?php
                    try {
                        $lista = $pdo->prepare("SELECT * FROM Solicitacoes_Pedidos WHERE Status_Separacao = ?");
                        $lista->execute([$dbStatus]);
                        
                        while ($linha = $lista->fetch(PDO::FETCH_ASSOC)) {
                            $idSolicitacao = $linha['Id_Solicitacao'];
                            $produto = $linha['Produto'];
                            $id_usuario = $linha['Id_Usuario'];
                            $user = $pdo->query("SELECT Nome FROM Usuarios WHERE id = $id_usuario")->fetch(PDO::FETCH_ASSOC)['Nome'];
                            $qtd = $linha['Quantidade_Produto'];
                            $tipo_caixa = $linha['Tipo_caixa'];
                            $qtd_caixa = $linha['Quantidade_Caixa'];
                            $prazo = $linha['Prazo'];

                            echo "<div class='card'>
                                <form method='POST'>
                                    <input type='hidden' name='id_solicitacao' value='$idSolicitacao'>
                                    <p>$idSolicitacao</p>
                                    <p>$user</p>
                                    <p>$produto | $qtd</p>
                                    <p>$qtd_caixa | $tipo_caixa</p>
                                    <p>$prazo</p>";

                            // Botões baseados no status atual
                            if ($dbStatus === "Abertos") {
                                echo "<button class='btn-column' name='status' value='Em andamento'>Separando</button>";
                            } elseif ($dbStatus === "Em andamento") {
                                echo "<button class='btn-column' name='status' value='Entregue'>Concluído</button>";
                            }

                            echo "</form>
                            </div>";
                        }
                    } catch (PDOException $e) {
                        echo "Erro ao buscar solicitações: " . $e->getMessage();
                    }
                    ?>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
