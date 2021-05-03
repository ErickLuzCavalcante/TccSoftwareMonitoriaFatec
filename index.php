<?php

namespace tcc\monitoria;

include 'php\cnn.php';
include 'php\usuarios.php';
include 'php\alunos.php';
include 'php\disciplinas.php';
include 'php\rascunhos.php';

$classeUsuaario = new usuario();
$classeUsuaario->novoUsuario(
    '1111',
    'Erick',
    'Cavalcante',
    'Email',
    '123',
    'Senha'
);

$classeUsuaario->editarUsuario("1111","Paula","Rodriguez","emaildapaula","123");


$classeUsuaario->login('1111', 'Senha');

echo 'Desconectar ' . $classeUsuaario->logoff();
echo '<br>Verificar se esta logado ' . $classeUsuaario->verificaLogado();
echo '<br>Logar ' . $classeUsuaario->login('1111', 'Senha');
echo '<br>Verificar se esta logado ' . $classeUsuaario->verificaLogado();

// Teste Classes Alunos

$classeAluno = new alunos();

$classeAluno->novoAluno('1111', '66698', 0);
$classeAluno->editarAluno('1111', '77777', 1);

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

$ClasseDisciplina = new disciplinas();
$codigoDisciplina=$ClasseDisciplina->novaDisciplina("Gestao de pastel", "imagem", "é uma bosta", "Xinguiling");
echo "<br>Codigo ".$codigoDisciplina;

$classeRascunho = new Rascunhos();
$codigoRascunho=$classeRascunho->novo("Titulo".$codigoDisciplina,"conteudo".$codigoDisciplina,$codigoDisciplina,"1111");
$classeRascunho->editar($codigoRascunho,"Titulo","conteudo",$codigoDisciplina,"1111");


$classeUsuaario->excluirusuario("1111");
$classeAluno->excluirAluno('1111');









/*
*/