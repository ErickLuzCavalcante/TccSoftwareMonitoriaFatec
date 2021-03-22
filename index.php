<?php
include ("php\cnn.php");
include ("php\usuarios.php");
include ("php\alunos.php");


$classeUsuaario =new usuario();
$classeUsuaario->novoUsuario("1111","Erick","Cavalcante","Email","123","Senha");

//$classeUsuaario->editarUsuario("1111","Paula","Rodriguez","emaildapaula","123");

//$classeUsuaario->excluirusuario("1111");
$classeUsuaario->login("1111","Senha");

ECHO ("Desconectar ".$classeUsuaario->logoff());
echo ("<br>Verificar se esta logado ".$classeUsuaario->verificaLogado());
ECHO ("<br>Logar ".$classeUsuaario->login("1111","Senha"));
echo ("<br>Verificar se esta logado ".$classeUsuaario->verificaLogado());


// Teste Classes Alunos

$classeAluno = new alunos();

$classeAluno->novoAluno("1111","66698",0);
$classeAluno->editarAluno("1111","77777",0);

$classeAluno->porCPF("1111");






?>



