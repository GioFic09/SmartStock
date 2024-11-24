<?php
require_once("db_connect.php");
session_start();


// Verificação de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $login = "SELECT * FROM Usuarios where Email = '{$email}' and Senha = '{$password}'";
    $rs_login = mysqli_query($conn_bd_sim, $login) or die(mysqli_error($conn_bd_sim));
    $linha_login = mysqli_num_rows($rs_login);
    $row_rs_login = mysqli_fetch_assoc($rs_login);

    // Verificação de credenciais
    if ($linha_login == 1) {
        // $_SESSION['loggedin'] = true;
        $_SESSION['Email'] = $email;
        $_SESSION['Senha'] = $password;
        $success = 'logado!';
        
        echo '<script>alert("Logado com sucesso!");</script>';
        header('Location: pedidos.php');
        exit;
    } else {
        $error = 'Nome de usuário ou senha incorretos!';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Smart Stock</title>
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
          <h1 class="login-title">Login</h1>

          <form action="" method="POST" class="login-form">
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
              <button type="submit">Entrar</button>
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
