<?php

namespace tcc\monitoria;

include "php/interfaces.php";
include "php/lista.php";
require "php/publicacoes.php";

// Back-end
// Coleta de dados para alimentar a interface


$usuario = new Usuario();
$aluno = new Alunos();
$administrador = $usuario->verificaAdministrador();
$monitor = $aluno->verificaLogadoMonitor();
if ($administrador) $monitor=$administrador;

$aluno->getCPFUsuario($usuario->getCPFUsuario());
$postagens = new Publicacoes();
$rascunho=false;

if (isset($_GET["controlepostagem"])&&$monitor){
    switch ($_GET["controlepostagem"]){
        case "rascunho" :
            $rascunho=true;
            break;
        default:
            $rascunho=false;
            break;
    }
}


// Carrega os dados confome o codgio da url, se houver o código na URL

if (isset($_GET["codigo"])) {
    $codigo = $_GET["codigo"];
    if ($rascunho){
        $postagens->rascunhoPorCodigo($codigo);
    }else{
        $postagens->publicadoPorCodigo($codigo);
    }
}
// inicilizo a interface
$uiux = new Interfaces($postagens->getTituloMaterial(), 1, false);




// Itens do menu
$uiux->addItemMenu("index.php", "Inicio", false);
// Se o usuario for administrador
$uiux->addItemMenu('index.php', "Editar Usuários", true);

$uiux->addItemMenu("index.php", "Meu Perfil", false);
$uiux->addItemMenu("index.php", "Trocar Senha", false);
$uiux->addItemMenu("Login.php", "Logoff", false);
$uiux->fecharmenu();


// inicializa a lista
$lista = new lista();

$lista->next = false;
$lista->prev = false;

// Casso não tenha o codigo da  declarada, o sistema mostra a mensagem de erro e finaliza a pagina
if (!isset($codigo)||($postagens->getTituloMaterial()==""&&!$monitor)) {
    $lista->add("error", "Conteudo não encontrado!!!", "<a href='index.php'><i class='material-icons'>restart_alt</i>Volte para o incio </a>");
    $lista->home = "index.php";
    exit();
}else if($postagens->getTituloMaterial()==""&&$monitor){
    $lista->add("error", "Atenção", "<p>Este conteudo não foi publicado, há apenas o rascunho</p>");
    $postagens->rascunhoPorCodigo($codigo);
    $rascunho=true;
    $codigo = $postagens->getCodigoMaterial();
}

if($monitor){
    $controle="
                <a href='editorConteudo.php?codigo=$codigo' target='_blank'>
                    <i class='material-icons'>edit</i>Editar 
                </a>
                <br>
    ";
    if ($rascunho){
        $controle=$controle."
            <a href='Conteudo.php?codigo=$codigo'>
                <i class='material-icons'>visibility</i>
                Visualizar publicado  
            </a>
            <br>
        ";
    }else{
        $controle=$controle."
            <a href='Conteudo.php?codigo=$codigo&controlepostagem=rascunho'>
                <i class='material-icons'>edit_note</i>Visualizar rascunho 
            </a>
            <br>        
        ";
    }
    $lista->add("assistant", "Controle", $controle);
}
if ($rascunho){
    $titulo="[RASCUNHO] ".$postagens->getTituloMaterial();
}else{
    $titulo=$postagens->getTituloMaterial();
}
$lista->add("text_snippet", $titulo, $postagens->getConteudoMaterial());
// Atualizacoes
$atualizacoes = new atualizacoes();
if ($monitor){
    $atualizacoes->listarTodasAsAtualizacoes($codigo);
}else{
    $atualizacoes->listarAtualizacoesPublicadas($codigo);
}

// IF que Verifica se ha algum resultado da pesquisa
if ($atualizacoes->getTamanho() > 0) {
    $logAtualizacoes="";
// Loop que percorre por todo o resultado da pesquisa
    for ($i = 0; $atualizacoes->ponteiro($i); $i++) {
        $logAtualizacoes=$logAtualizacoes.
                                            "<i class='material-icons'>"
                                                .$atualizacoes->getIconeAtualizacoes().
                                            "</i> "
                                            .$atualizacoes->getDescricaoAtualizacoes()." 
                                            por ".$atualizacoes->getPersonaAtualizacoes()
                                            ." em ". $atualizacoes->getDataAtualizacoes()
                                            ."<br>";
        $atualizacoes->proximo();
    }

    $lista->add("update", "Atualizações", $logAtualizacoes);
}

$lista->home = "#";


// Administrador tem as permicoes de monitor
if ($administrador) $monitor = true;


unset($lista);
unset($uiux)
?>
