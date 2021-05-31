<?php

namespace tcc\monitoria;

include "php/interfaces.php";
include "php/quill.php";
require "php/publicacoes.php";


$aluno = new Alunos();
$usuario = new Usuario();
$usuario->verificaLogado();
$secao = $aluno->verificaLogadoMonitor();

if (!$secao) {
    $falha = "
  Você nao possui permissão, ou sua sessão foi finalizada. Nenhuma ação foi executada no servidor<br><br>
  Para resolver click no link abaixo e efetue o login, enquanto isso eu irei recuperar os dados apartir do checkpoint salvo neste computador
  <br><br><a href='login.php' onclick='puxaCookie()' target='_blank'>Link [Clique Aqui]</a><br>";
}

$disciplinas = new Disciplinas();
$postagens = new Publicacoes();

/*Inicialização das variaveis e Objetos */

$titulo = "";
$conteudo = "";


$link = "editorConteudo.php";

/*FIM - Inicialização das variaveis e Objetos */

if (isset($_GET["codigoDisciplina"])) {
    $codigoDisciplina = $_GET["codigoDisciplina"];
    $link = "editorConteudo.php?codigoDisciplina=$codigoDisciplina";
} else {
    $codigoDisciplina = false;
    $falha = "<br><br> disciplina nao informada! <br> As alterações não serão salvas <br><br>";
}

if (isset($_GET["codigo"]) && $codigoDisciplina != false) {
    $codigo = $_GET["codigo"];
    $postagens->rascunhoPorCodigo($codigo);
    $titulo = $postagens->getTituloMaterial();
    $conteudo = $postagens->getConteudoMaterial();

    $link = "editorConteudo.php?codigo=$codigo&codigoDisciplina=$codigoDisciplina";

}
if (isset($_POST["delta"])) {


    $titulo = $_POST["titulo"];
    $conteudo = $_POST["delta"];

    if (isset($falha) == false) {
        $operacao = $_POST["radio-button"];
        if (isset($_GET["codigo"])) {
            if ($operacao == '1') {
                $postagens->editar($_GET["codigo"], $titulo, $conteudo, $codigoDisciplina, $usuario->getCPFUsuario(), $_POST["Comentario"]);
                $link = "editorConteudo.php?codigo=$codigo&codigoDisciplina=$codigoDisciplina";
            }
            if ($operacao == '2') {
                $postagens->publicar($_GET["codigo"], $titulo, $conteudo, $codigoDisciplina, $usuario->getCPFUsuario());
                $link = "editorConteudo.php?codigo=$codigo&codigoDisciplina=$codigoDisciplina";
            }
            if ($operacao == '3') {
                $postagens->tirarDoAr($codigo);
                $link = "editorConteudo.php?codigo=$codigo&codigoDisciplina=$codigoDisciplina";
            }
            if ($operacao == '4') {
                $postagens->excluir($codigo);
                $link = "index.php";
                $falha = "Conteudo excluido";
            }
        } else {
            $codigo = $postagens->novo($titulo, $conteudo, $codigoDisciplina, $usuario->getCPFUsuario());
            $link = "editorConteudo.php?codigo=$codigo&codigoDisciplina=$codigoDisciplina";
        }

    }
}

$uiux = new Interfaces("Editor de disciplina", 0, false);
// Filtros da barra de pesquisa

// Itens do menu
$uiux->addItemMenu("javascript:close();", "Para sair do editor feche a guia", false);
$uiux->fecharmenu();

$editor = new quill($link, "de conteúdo", isset($_GET['codigo']));

// Controla os controles do menu "Açoes no servidor"

if (isset($codigo)) {
    $editor->visivelExcluir = true;
    $editor->visivelTirarDoAr=true;
    $editor->visivelPublicar=true;
}


if (isset($falha)) {
    $editor->falha($falha);
}

$editor->adcionarCampo("titulo", "drive_file_rename_outline", "Titulo da disciplina", $titulo);
if (isset($codigo)) {
    $editor->adcionarCampo("Comentario", "assignment_ind", "Comentarios de alteração", "");
}
$editor->Editor($conteudo);
unset($uiux)
?>
