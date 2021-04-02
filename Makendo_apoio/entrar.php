<?php
Include("lib/padrao.php");
Include("lib/usuario.php");
$padrao=new master(false);
// Variaveis que seram usadas para mostrar alguma falha
// se houver
$falha=false;
$textofalha="Falha:";
// carrega dados do usuario atualmente logado
$usr=new usuario();
if (isset($_POST["cd-usuario"])){
  $usuario=$_POST["cd-usuario"];
  $senha=$_POST["cd-senha"];;
  $usr->IniciarSecao($usuario,$senha);
  $secao=$usr->ValidaSessao();
  if ($secao) {
    header('Location: index.php');
  }else{
    $falha=true;
    $textofalha="Usuário ou senha invalidos";
  }
}else{
  $secao=$usr->CancelaSecao();
}
?>
<link rel="stylesheet" href="formulario/css/style.css"><form class="cd-form floating-labels" method="post" action="" onSubmit="Localizar()"><br><h2>Entrar</h2>
  <?php
  // mostra mensagem de falha
  if ($falha){
    echo '<div class="error-message"><p>'.$textofalha.'</p></div>';
  }
  ?>
  <br><h4><i class="material-icons">person</i>Usuário</h4><input class="usuario" type="text" value="" name="cd-usuario" id="cd-usuario" required><br><h4><i class="material-icons">lock</i>Senha</h4><input class="senha" type="password" value="" name="cd-senha" id="cd-senha" required><br><input type="submit" value="Entrar"></form>
  <?php
  unset($padrao);
  ?>
