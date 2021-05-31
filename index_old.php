<?php

namespace tcc\monitoria;


// Area de teste

include 'php\cnn.php';
include 'php\usuarios.php';
include 'php\alunos.php';
include 'php\disciplinas.php';
include "php\publicacoes.php";


$classeUsuaario = new usuario();
$classeUsuaario->novoUsuario(
    '1111',
    'Erick',
    'Cavalcante',
    'Email',
    '123',
    'Senha'
);

$classeUsuaario->editarUsuario("1111", "Paula", "Rodriguez", "emaildapaula", "123");


$classeUsuaario->login('1111', 'Senha');

//echo 'Desconectar ' . $classeUsuaario->logoff();

// Teste Classes Alunos

$classeAluno = new alunos();

$classeAluno->novoAluno('1111', '66698', 0);
$classeAluno->editarAluno('1111', '77777', 0);

echo '<br>Verificar se esta logado ' . $classeUsuaario->verificaLogado();
echo '<br>Logar ' . $classeUsuaario->login('1111', 'Senha');
echo '<br>Verificar se esta logado ' . $classeUsuaario->verificaLogado();
echo '<br>Verificar se é administrador ' . $classeUsuaario->verificaAdministrador();

$classeAluno->porCPF('1111');
$classeAluno->porNome('Erick Cavalcante');

$classeAluno->porRa('77777');
echo "<br><br>";
echo "CPF ALUNO";
echo $classeAluno->getCPFUsuario();
echo "<br><br>";
echo "CPF RA";
echo $classeAluno->getRaAluno();
echo "<br><br>";
echo "CPF MONITOR";
echo $classeAluno->getMonitorAluno();
echo "<br><br>";

//$ClasseDisciplinas = new Disciplinas();
//$codigoDisciplina = $ClasseDisciplinas->novaDisciplina("Gestao de pastel", '<img src="img/banco-dados.png">', "é uma bosta", "Xinguiling");
//echo "<br>Codigo " . $codigoDisciplina;

//$classePostagens = new Publicacoes();
//$codigoPostagem = $classePostagens->novo("Titulo" . $codigoDisciplina, "conteudo" . $codigoDisciplina, $codigoDisciplina, "1111");
//$classePostagens->editar($codigoPostagem, "Titulo", "conteudo", $codigoDisciplina, "1111", "Teste de rascunho");
//$classePostagens->publicar($codigoPostagem, "Titulo", "conteudo", $codigoDisciplina, "1111", "Teste de rascunho");


//$classeUsuaario->excluirusuario("1111");
//$classeAluno->excluirAluno('1111');


$classeUsuaario = new usuario();
/*
$classeUsuaario->novoUsuario(
    '1111',
    'Erick',
    'Cavalcante',
    'Email',
    '123',
    'Senha'
);

$classeAluno = new alunos();

$classeAluno->novoAluno('1111', '66698', 0);
*/


?>


<a href="old/Login.php">Entrar</a>
