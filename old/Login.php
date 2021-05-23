<?php

namespace tcc\monitoria;

include 'php\interfaces.php';
// Variaveis que seram usadas para mostrar alguma falha
// se houver
$falha = false;
$textofalha = "Falha:";
// carrega dados do usuario atualmente logado
$usr = new usuario();
if (isset($_POST["Login_CPF"])) {
  $usuario = $_POST["Login_CPF"];
  $senha = $_POST["Login_Senha"];;
  $usr->login($usuario, $senha);
  $secao = $usr->verificaLogado();
  if ($secao) {
    header('Location: index.php');
  } else {
    $falha = true;
    $textofalha = "Usuário ou senha invalidos";
  }
} else {
  $secao = $usr->logoff();
}
?><html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Software Monitoria</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/signin.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">

</head>

<body class="text-center">

  <form class="form-signin" method="POST" action="Login.php">
    <img class="mb-4" src="img/logofatec.png" alt="">
    <h1 class="h3 mb-3 font-weight-normal">Login </h1>
    <label class="sr-only">CPF:</label>
    <input type="text" name="Login_CPF" class="form-control" placeholder="CPF" required autofocus><br>
    <label for="inputPassword" class="sr-only">Senha:</label>
    <input type="password" name="Login_Senha" class="form-control" placeholder="Senha" required>
    <div class="checkbox mb-3">
      <?php
      if ($falha) {
        echo '<div class="alert  alert-danger" role="alert">
    <center>' . $textofalha . '</center>
    </div>';
      }
      ?>

    </div>
    <!-- botoes -->
    <button class="btn btn-lg btn-danger btn-block" type="submit">Logar</button><br>
    <a href="cadastro.php" class="btn btn-lg btn-danger btn-block" type="button">Cadastrar</a>

  </form>
</body>

</html>