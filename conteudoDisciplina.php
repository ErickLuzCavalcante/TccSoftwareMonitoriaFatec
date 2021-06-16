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


$uiux->padraoMenu();


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
echo
$lista->add("history_edu", $disciplina->getNomeDisciplina(),
    "<i class='material-icons'>school</i> Professor(a): " . $disciplina->getProfessorDisciplina() . " <br>
              <i class='material-icons'>info</i> Informações: <br><br><div class='ql-editor'>" .
    $disciplina->getSobreDisciplina()
    ."</div>"
);


$lista->home = "#";


unset($lista);
unset($uiux)
?>
