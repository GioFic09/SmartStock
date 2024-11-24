<?php
require_once("db_connect.php");
session_start();

// Verifica se a conexão com o banco foi feita corretamente

// Verificação do envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn_bd_sim, $_POST['email']);
    $username = mysqli_real_escape_string($conn_bd_sim, $_POST['username']);
    $password = $_POST['password'];

    // // Criptografa a senha antes de armazená-la no banco
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Verifica se o e-mail ou nome de usuário já existe no banco
    $check_user = "SELECT * FROM Usuarios WHERE Email = '{$email}' OR Nome = '{$username}'";
    $rs_check_user = mysqli_query($conn_bd_sim, $check_user);
    
    if (mysqli_num_rows($rs_check_user) > 0) {
        $error = 'Usuário ou e-mail já cadastrados!';
    } else {
        // Insere o novo usuário no banco de dados
        $insert_user = "INSERT INTO Usuarios (Email, Nome, Senha) VALUES ('{$email}', '{$username}', '{$password}')";
        
        if (mysqli_query($conn_bd_sim, $insert_user)) {
            $_SESSION['Email'] = $email;
            $_SESSION['Nome'] = $username;
            $_SESSION['Senha'] = $password;
            $success = 'Usuário cadastrado com sucesso!';
            header('Location: cadastroSucesso.php'); // Redireciona para a página de login após cadastro
            exit;
        } else {
            $error = 'Erro ao cadastrar usuário. Tente novamente mais tarde.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro - Smart Stock</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <main class="container">
      <div class="container-left">
        <div class="logo">
          <img src="./imagens/Logo Login.png" alt="" />
        </div>
        <div class="login">
          <h1 class="login-title">Usuario Cadastrado</h1>

         <a style='padding: 5px; border-radius: 10px; background-color: #c0a6e1; border: none; text-decoration: none; font-size: 20px; color: white;' class="login-actions" href="login.php">Ir para tela de Login</a> 
        </div>
      </div>

      <!-- Imagem ao lado direito -->
      <div class="container-right">
        <img src="./imagens/Caixa login.png" alt="" />
      </div>
    </main>
  </body>
</html>
