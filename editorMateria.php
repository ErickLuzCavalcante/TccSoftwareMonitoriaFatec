<?php

namespace tcc\monitoria;

include "php/interfaces.php";
include "php/quill.php";



$usuario = new Usuario();
$secao = $usuario->verificaAdministrador();
if (!$secao) {
    $falha = "
  Você nao possui permissão, ou sua sessão foi finalizada. Nenhuma ação foi executada no servidor<br><br>
  Para resolver click no link abaixo e efetue o login, enquanto isso eu irei recuperar os dados apartir do checkpoint salvo neste computador
  <br><br><a href='login.php' onclick='puxaCookie()' target='_blank'>Link [Clique Aqui]</a><br>";
}

$disciplinas = new Disciplinas();

/*Inicialização das variaveis e Objetos */

$nomeDisciplina = "";
$imagemDisciplina = "";
$sobreDisciplina = "";
$professorDisciplina = "";
$link = "editorMateria.php";
/*FIM - Inicialização das variaveis e Objetos */
if (isset($_GET["codigoDisciplina"])) {
    $codigo = $_GET["codigoDisciplina"];
    $disciplinas->porCodigo($codigo);
    $nomeDisciplina = $disciplinas->getNomeDisciplina();
    $imagemDisciplina = $disciplinas->getImagemDisciplina();
    $sobreDisciplina = $disciplinas->getSobreDisciplina();
    $professorDisciplina = $disciplinas->getProfessorDisciplina();
    $link = "editorMateria.php?codigoDisciplina=$codigo";

}
if (isset($_POST["nomeDisciplina"])) {

    $nomeDisciplina = $_POST["nomeDisciplina"];
    $imagemDisciplina = $_POST["deltaIMG"];
    $sobreDisciplina = $_POST["delta"];
    $professorDisciplina = $_POST["professorDisciplina"];

    if ($imagemDisciplina == "") {
        $falha = $falha . "<br><br>Falta adcionar uma imagem para capa da matéria, esta irá identificar a disciplina dentre as demais<br>";
    }
    if ($professorDisciplina == "") {
        $falha = $falha . "<br><br>Qual o professor responsavel pela matéria<br>";
    }
    if (isset($falha)==false) {
        if (isset($_GET["codigoDisciplina"])){
            $disciplinas->editarDisciplina($_GET["codigoDisciplina"],$nomeDisciplina, $imagemDisciplina, $sobreDisciplina, $professorDisciplina);
        }else{
            $codigo=$disciplinas->novaDisciplina($nomeDisciplina, $imagemDisciplina, $sobreDisciplina, $professorDisciplina);
        }
        $link = "editorMateria.php?codigoDisciplina=$codigo";
    }
}

$uiux = new Interfaces("Editor de disciplina", 0, false);
// Filtros da barra de pesquisa


// Itens do menu
$uiux->addItemMenu("javascript:close();", "Fechar", false);

$uiux->fecharmenu();

$editor = new quill($link, "de disciplina", false);
if (isset($falha)) {
    $editor->falha($falha);
}

$editor->adcionarCampo("nomeDisciplina", "drive_file_rename_outline", "Nome da disciplina", $nomeDisciplina);
$editor->adcionarCampo("professorDisciplina", "assignment_ind", "Professor da materia", $professorDisciplina);

$editor->Editor($sobreDisciplina);
unset($uiux)
?>
