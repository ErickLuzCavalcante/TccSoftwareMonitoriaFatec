<?php

namespace tcc\monitoria;

include "php/interfaces.php";
include "php/lista.php";


$disciplina = new Disciplinas();
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];
    $disciplina->porCodigo($codigo);
}


// inicilizo a interface
$uiux = new Interfaces($disciplina->getNomeDisciplina(), 1, false);


// Itens do menu
$uiux->addItemMenu("index.php", "Inicio", false);
// Se o usuario for administrador
$uiux->addItemMenu('index.php', "Editar Usuários", true);

$uiux->addItemMenu("index.php", "Trocar Senha", false);
$uiux->addItemMenu("Login.php", "Logoff", false);
$uiux->fecharmenu();


// inicializa a lista
$lista = new lista();
$lista->next = false;
$lista->prev = false;

// Casso não tenha o codigo da  declarada, o sistema mostra a mensagem de erro e finaliza a pagina
if (!isset($codigo) || $disciplina->getNomeDisciplina() == "") {
    $lista->add("error", "Conteudo não encontrado!!!", "
        <a href='index.php'>
            <i class='material-icons'>restart_alt</i>Volte para o incio 
        </a>");
    $lista->home = "index.php";
    exit();
}

$lista->add("history_edu", $disciplina->getNomeDisciplina(),
    "<i class='material-icons'>school</i> Professor(a): " . $disciplina->getProfessorDisciplina() . " <br>
              <i class='material-icons'>info</i> Informações: <br><br>" .
    $disciplina->getSobreDisciplina()
);


$lista->home = "#";


unset($lista);
unset($uiux)
?>
