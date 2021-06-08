<?php

namespace tcc\monitoria;

include "php/interfaces.php";
include "php/lista.php";
require "php/publicacoes.php";

// inicilizo a interface
$uiux = new Interfaces("Usuários", 2, true);

// Carrega os dados confome o codgio da url, se houver o código na URL
$link = "usuario.php?";

// Filtro da pagina
$uiux->filtroDePesquisa("Usuários", "usuario.php?", true);

// Filtros padrão
$uiux->filtroDePesquisa("Disciplinas", "index.php?", false);


// Itens do menu
$uiux->addItemMenu("index.php", "Inicio", false);

$uiux->addItemMenu("troca_senha.php", "Meu perfil", false);
$uiux->addItemMenu("Login.php", "Logoff", false);
$uiux->fecharmenu();

// inicializa a lista
$lista = new lista();
echo "<br><br>";


// Cria o cabecalho da lista com o filtro da listagem de usuarios
$lista->add("manage_accounts", "Usuários", "
        <!-- Label filtro -->
        <i class='material-icons'>filter_alt</i> Filtros: <br>
        <!-- Fim Label -->

        <!-- Link para a visualizacao de todos os usuarios -->
        <a href='usuario.php?pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>people</i> Todos 
        </a><br>
        
         <!-- Link para a visualizacao somente os alunos -->
        <a href='usuario.php?filtro=Alunos&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>face</i> Alunos 
        </a><br>
        <!-- Fim Link para a visualizacao somente os alunos -->
        
        <!-- Link para a visualizacao somente os monitores -->
        <a href='usuario.php?filtro=Monitores&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>emoji_people</i> Monitores
        </a><br>
        <!-- Fim Link para a visualizacao somente os monitores -->
        
        <!-- Link para a visualizacao somente os monitores -->
        <a href='usuario.php?filtro=Administradores&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>assignment_ind</i> Administradores 
        </a><br>
        <!-- Fim Link para a visualizacao somente os monitores -->
        
        <hr/>
        <i class='material-icons'>add_circle</i> Novo: <br>
        
        <!-- Link para a visualizacao somente os monitores -->
        <a href='usuario.php?filtro=Administradores&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>person </i> Aluno ou Monitor
        </a><br>
        <!-- Fim Link para a visualizacao somente os monitores -->
        
        <!-- Link para a visualizacao somente os monitores -->
        <a href='usuario.php?filtro=Administradores&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>assignment_ind</i> Administrador
        </a><br>
        <!-- Fim Link para a visualizacao somente os monitores -->
");


// Variavel pelo controle do tipo de pesquisa
$tipoDeListagem = "todos"; // define um valor padrao
if (isset($_GET["filtro"])) {
    $tipoDeListagem = $_GET["filtro"]; // caso tenha um get na url, troca o valor padrao pelo valor do get
}


// Filtra conforme o a variavel $tipoDeListagem
switch ($tipoDeListagem) {
    case "Alunos":
        // Pesquisa somente pelos alunos

        break;
    case "Administradores":
        // Pesquisa somente pelos administradores

        break;
    default: // pesquisa padrao
        // Pesquisa todos os usuarios

        break;
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
