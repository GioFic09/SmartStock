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
        <div class="login">
          <h1 class="login-title">Cadastro</h1>

          <form action="" method="POST" class="login-form">
            <input type="text" name="username" placeholder="Nome" required />
            <input type="email" name="email" placeholder="E-mail" required />
            <input type="password" name="password" placeholder="Senha" required />

            <?php if (isset($error)) : ?>
              <div class="error-message">
                <p><?php echo $error; ?></p>
              </div>
            <?php endif; ?>

            <?php if (isset($success)) : ?>
              <div class="error-message">
                <p><?php echo $success; ?></p>
              </div>
            <?php endif; ?>

            <div class="login-actions">
              <button type="submit">Cadastrar</button>
              <a href="login.php"><button type="button">Já tenho conta</button></a>
            </div>
          </form>
        </div>
      </div>

      <!-- Imagem ao lado direito -->
      <div class="container-right">
        <img src="./imagens/Caixa login.png" alt="" />
      </div>
    </main>
  </body>
</html>
