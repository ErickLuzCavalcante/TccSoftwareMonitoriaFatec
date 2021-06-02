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


$aluno->getCPFUsuario($usuario->getCPFUsuario());
$postagens = new Publicacoes();
$rascunho=true;
if (isset($_GET["rascunho"])){
    $rascunho =$_GET["rascunho"];
}

if (isset($_GET["codigo"])&&$rascunho==false) {
    $codigo = $_GET["codigo"];
    $postagens->publicadoPorCodigo($codigo);

}else if (isset($_GET["codigo"])&&$rascunho==true){
    $codigo = $_GET["codigo"];
    $postagens->rascunhoPorCodigo($codigo);
}

if ($postagens->getCodigoMaterial()==""){
    unset($codigo);
}

$uiux = new Interfaces($postagens->getTituloMaterial(), 1, isset($codigo));

// Carrega os dados confome o codgio da url, se houver o código na URL
$link = "disciplina.php?";

if (isset($_GET["controlepostagem"])) {
    $link = $link . "controlepostagem=" . $_GET["controlepostagem"] . "&";
}

if (isset($_GET["codigo"])) {
    // Gera o filtro para a pesquisa na materia
    //$uiux->filtroDePesquisa($disciplina->getNomeDisciplina(), $link . "codigo=$codigo", true);

} else {
    unset ($codigo);
}


// Filtros padrão

$uiux->filtroDePesquisa("Disciplinas", "index.php?", false);


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


// Casso não tenha o codigo da disciplina declarada, o sistema mostra a mensagem de erro e finaliza a pagina
if (!isset($codigo)) {
    $lista->add("error", "Conteudo não encontrado!!!", "<a href='index.php'><i class='material-icons'>restart_alt</i>Volte para o incio </a>");
    $lista->next = false;
    $lista->prev = false;
    $lista->home = "index.php";
    exit();
}


// Administrador tem as permicoes de monitor
if ($administrador) $monitor = true;


// informacoes da disciplinas

// Cria a string de que conterá as açoes e informacoes da diciplina conforme oo nivel de acesso do usuario
$infodisciplina = "";

// Se o usuario for monitor
if ($monitor) {
    $infodisciplina = $infodisciplina .
        "
        
        <i class='material-icons'>auto_awesome</i> Controles adcionais:<br>
        
        <!-- Link para a visualizacao de todos os materiais -->
        <a href='disciplina.php?codigo=$codigo&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>view_list</i> Mostrar todos materiais 
        </a><br>
        <!-- Fim Link para a visualizacao de todos os materiais -->
        
         
         <!-- Link para a visualizacao somente dos que estao postados -->
        <a href='disciplina.php?codigo=$codigo&controlepostagem=postados&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>visibility</i> Mostrar os que estão postado 
        </a><br>
        <!-- Fim Link para a visualizacao somente dos que estao postados -->
        
        <!-- Link para a visualizacao somente dos que NAO estao postados -->
        <a href='disciplina.php?codigo=$codigo&controlepostagem=rascunhos&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>visibility_off</i> Mostrar os que não esta postado 
        </a><br>
         <!-- Fim Link para a visualizacao somente dos que NAO estao postados -->
         

        <!-- Link para criar um novo material na disciplina -->
        <a href='editorConteudo.php?codigoDisciplina=$codigo'  target='_blank'>
            <i class='material-icons'>post_add</i> Novo material
        </a><br>
        <!-- Fim Link para criar um novo material na disciplina --> 
    ";

}
// Se o usuario for aadministrador
if ($administrador) {
    $infodisciplina = $infodisciplina . "
    <!-- Link para editar a disciplina -->
    <a href='editorMateria.php?codigoDisciplina=$codigo'  target='_blank'>
        <i class='material-icons'>folder_open</i> Editar disciplina
     </a><br>
    <!-- Fim Link para editar a disciplina -->
    ";
}


// para todos
$infodisciplina = $infodisciplina . "
    <hr/>
    <i class='material-icons'>school</i> Professor(a): " . $disciplina->getProfessorDisciplina() . " <br>
    
    <!-- Link para mostrar mais informacoes  -->
    <a href='#  target='_blank'>
        <i class='material-icons'>info</i> Mais informações  
     </a><br>
    <!-- Fim Link para mostrar mais informacoes  -->
";


$lista->add("history_edu", $disciplina->getNomeDisciplina(), $infodisciplina);

unset($infodisciplina);

$tipoDeListagem = "todos";
if (isset($_POST["controlepostagem"])) {
    $tipoDeListagem = $_POST["controlepostagem"];
}
// pesquisa
$postagens->rascunhoPostagensPorDiciplina($codigo, $uiux->pesquisa, $uiux->pagina, 20);
if ($postagens->getTamanho() > 0) {


}

unset($lista);
unset($uiux)
?>
