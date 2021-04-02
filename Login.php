<?php
include 'php\usuarios.php';
$login = $_POST['login'];
$entrar = $_POST['entrar'];
$senha = md5($_POST['senha']);
$connect = mysql_connect('nome_do_servidor', 'nome_de_usuario', 'senha');
$db = mysql_select_db('nome_do_banco_de_dados');
if (isset($entrar)) {

  $verifica = mysql_query("SELECT * FROM usuarios WHERE login =
    '$login' AND senha = '$senha'") or die("erro ao selecionar");
  if (mysql_num_rows($verifica) <= 0) {
    echo "<script language='javascript' type='text/javascript'>
        alert('Login e/ou senha incorretos');window.location
        .href='login.html';</script>";
    die();
  } else {
    setcookie("login", $login);
    header("Location:index.php");
  }
}
?>

?>

<!doctype html>
<html lang="pt-br">

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
  <form class="form-signin">
    <img class="mb-4" src="img/logofatec.png" alt="">
    <h1 class="h3 mb-3 font-weight-normal">Login </h1>
    <label class="sr-only">CPF:</label>
    <input type="text" id="Login_CPF" class="form-control" placeholder="CPF" required autofocus><br>
    <label for="inputPassword" class="sr-only">Senha:</label>
    <input type="password" id="Login_Senha" class="form-control" placeholder="Senha" required>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Lembrar Senha
      </label>
    </div>
    <!-- botoes -->
    <button class="btn btn-lg btn-danger btn-block" type="submit">Logar</button><br>
    <a href="cadastro.html" class="btn btn-lg btn-danger btn-block" type="button">Cadastrar</button>

  </form>
</body>

</html>