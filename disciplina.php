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
$disciplina = new Disciplinas();
$postagens = new Publicacoes();

if (isset($_GET["codigo"])) {
    $codigo = $_GET["codigo"];
    $disciplina->porCodigo($codigo);
    $codigo = $disciplina->getCodigoDisciplina();
}
// inicilizo a interface
$uiux = new Interfaces($disciplina->getNomeDisciplina(), 1, isset($codigo));

// Carrega os dados confome o codgio da url, se houver o código na URL
$link = "disciplina.php?";

if (isset($_GET["controlepostagem"])) {
    $link = $link . "controlepostagem=" . $_GET["controlepostagem"] . "&";
}

if (isset($_GET["codigo"])) {
    // Gera o filtro para a pesquisa na materia
    $uiux->filtroDePesquisa($disciplina->getNomeDisciplina(), $link . "codigo=$codigo&", true);

} else {
    unset ($codigo);
}


// Filtros padrão

$uiux->filtroDePesquisa("Disciplinas", "index.php?", false);

$uiux->padraoMenu();



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
        
        
        

        
        <!-- Label filtro -->
        <i class='material-icons'>filter_alt</i> Filtros: <br>
        <!-- Fim Label -->
        
        <!-- Link para a visualizacao de todos os materiais -->
        <a href='disciplina.php?codigo=$codigo&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>view_list</i> Todos 
        </a><br>
        <!-- Fim Link para a visualizacao de todos os materiais -->
         <!-- Link para a visualizacao somente dos que estao postados -->
        <a href='disciplina.php?codigo=$codigo&controlepostagem=postados&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>visibility</i> Postados 
        </a><br>
        <!-- Fim Link para a visualizacao somente dos que estao postados -->
        
        <!-- Link para a visualizacao somente dos que NAO estao com alguma alteração pendente -->
        <a href='disciplina.php?codigo=$codigo&controlepostagem=rascunhos&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>visibility_off</i> Modificação nao postado 
        </a><br>
         <!-- Fim Link para a visualizacao somente dos que NAO estao com alguma alteração pendente -->
         
        <!-- Link para a visualizacao somente os que NAO postado -->
        <a href='disciplina.php?codigo=$codigo&controlepostagem=naopostado&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>public_off</i> Não publicado 
        </a>
         <!-- Fim Link para a visualizacao somente os que NAO postado -->         

        <hr/>
        <i class='material-icons'>auto_awesome</i> Criação: <br>

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
 
    <i class='material-icons'>school</i> Professor(a): " . $disciplina->getProfessorDisciplina() . " <br>

    
    <!-- Link para mostrar mais informacoes  -->
    <a href='conteudoDisciplina.php?codigo=".$disciplina->getCodigoDisciplina()."' >
        <i class='material-icons'>info</i> Detalhes  
     </a><br>
    <!-- Fim Link para mostrar mais informacoes  -->
";
if ($uiux->pesquisa!=""){
    $infodisciplina = $infodisciplina. "
    <hr/><i class='material-icons'>search</i> Resultados da pesquisa por: " . $uiux->pesquisa . "
    ";
}

echo "<br><br>";
$lista->add("history_edu", $disciplina->getNomeDisciplina(), $infodisciplina);

unset($infodisciplina);


// Variavel pelo controle do tipo de pesquisa
$tipoDeListagem = "todos"; // define um valor padrao
if (isset($_GET["controlepostagem"])) {
    $tipoDeListagem = $_GET["controlepostagem"]; // caso tenha um get na url, troca o valor padrao pelo valor do get
}

// pesquisa
if ($monitor) {
    // Filtra conforme o a variavel $tipoDeListagem
    switch ($tipoDeListagem) {
        case "todos":
            // Pesquisa pelos rascunhos e pelos publicados
            $postagens->rascunhoPostagensPorDiciplina($codigo, $uiux->pesquisa, $uiux->pagina, 6);
            break;
        case "rascunhos":
            // Pesquisa somente os publicados
            $postagens->rascunhoPorDiciplina($codigo, $uiux->pesquisa, $uiux->pagina, 6);
            break;
        case "naopostado":
            // Pesquisa somente os publicados
            $postagens->offlinePorDiciplina($codigo, $uiux->pesquisa, $uiux->pagina, 6);
            break;
        default: // pesquisa padrao
            // Pesquisa somente os que estão postados
            $postagens->publicadoPorDiciplina($codigo, $uiux->pesquisa, $uiux->pagina, 6);
            break;
    }

} else {
    // Se for um aluno padrão ele ira pesquisar apenas pelos conteudos postados
    $postagens->publicadoPorDiciplina($codigo, $uiux->pesquisa, $uiux->pagina, 6);
}


// IF que Verifica se ha algum resultado da pesquisa
if ($postagens->getTamanho() > 0) {
    // Loop que percorre por todo o resultado da pesquisa
    for ($i = 0; $postagens->ponteiro($i); $i++) {
        // String que mostra as informacoes sobre o artigo atual
        $infopostagem = "
            <i class='material-icons'>tips_and_updates</i>
            Criado em: " . $postagens->getDataCriacaoMaterial() . "</a>";

        $PublicacaoAtual = new Publicacoes();
        $PublicacaoAtual->publicadoPorCodigo($postagens->getCodigoMaterial());

        if ($PublicacaoAtual->getCodigoMaterial() == "") {
            $infopostagem = $infopostagem . "
                <br>
                <i class='material-icons'>visibility_off</i>
                Status: Não publicado  
                <br>";
        } else {
            $infopostagem = $infopostagem . "
                <br>
                <i class='material-icons'>visibility</i>
                Status: Publicado  
                <br>";
        }

        if ($monitor) {
            $infopostagem = $infopostagem . "
            <a href='editorConteudo.php?codigo=" . $postagens->getCodigoMaterial() . "' target='_blank'><i class='material-icons'>mode_edit</i>
            Editar  </a>
            ";
        }

        $lista->add("text_snippet", "<a href='conteudo.php?codigo=" . $postagens->getCodigoMaterial() . "'>" . $postagens->getTituloMaterial(), $infopostagem);


        $postagens->proximo();
    } // Fim do Loop que percorre por todo o resultado da pesquisa
    $lista->home = "disciplina.php?codigo=$codigo&pesquisa=$uiux->pesquisa";
    $proximaPagina = $uiux->pagina + 1;
    if ($uiux->pagina <= 1) {
        $lista->prev = false;
    } else {
        $anteriorPagina = $uiux->pagina - 1;
        $lista->prev = "disciplina.php?codigo=$codigo&pesquisa=$uiux->pesquisa&pagina=$anteriorPagina";
    }
    $lista->next = "disciplina.php?codigo=$codigo&pesquisa=$uiux->pesquisa&pagina=$proximaPagina";
} else { // Fim do IF que Verifica se ha algum resultado da pesquisa
    echo "<br><br><h2> <i class='material-icons'>find_in_page</i>Não encontramos nada </h2>";
    $lista->home = "disciplina.php?codigo=$codigo&pesquisa=$uiux->pesquisa";
    if ($uiux->pagina <= 1) {
        $lista->prev = false;
    } else {
        $anteriorPagina = $uiux->pagina - 1;
        $lista->prev = "disciplina.php?codigo=$codigo&pesquisa=$uiux->pesquisa&pagina=$anteriorPagina";
    }
    $lista->next = false;
}
unset($lista);
unset($uiux)
?>
