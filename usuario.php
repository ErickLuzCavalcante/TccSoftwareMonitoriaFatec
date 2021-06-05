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



$aluno->getCPFUsuario($usuario->getCPFUsuario());
$disciplina = new Disciplinas();
$postagens = new Publicacoes();


// inicilizo a interface
$uiux = new Interfaces($disciplina->getNomeDisciplina(), 1, true);

// Carrega os dados confome o codgio da url, se houver o código na URL
$link = "usuario.php?";



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
if (!$administrador) {
    $lista->add("error", "Conteudo não encontrado!!!", "<a href='index.php'><i class='material-icons'>restart_alt</i>Volte para o incio </a>");
    $lista->next = false;
    $lista->prev = false;
    $lista->home = "index.php";
    exit();
}



// informacoes da disciplinas

// Cria a string de que conterá as açoes e informacoes da diciplina conforme oo nivel de acesso do usuario
$infodisciplina = "";


// Se o usuario for aadministrador
if ($administrador) {
    $infodisciplina = $infodisciplina . "
    <!-- Link para editar a disciplina -->
    <a href='editorMateria.php?codigoDisciplina=$codigo'  target='_blank'>
        <i class='material-icons'>folder_open</i> Editar disciplina
     </a><br><hr/>
    <!-- Fim Link para editar a disciplina -->
    ";
}


// para todos
$infodisciplina = $infodisciplina . "
    <i class='material-icons'>school</i> Professor(a): " . $disciplina->getProfessorDisciplina() . " <br>
    
    <!-- Link para mostrar mais informacoes  -->
    <a href='#  target='_blank'>
        <i class='material-icons'>info</i> Detalhes  
     </a><br>
    <!-- Fim Link para mostrar mais informacoes  -->
";

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
            $postagens->rascunhoPostagensPorDiciplina($codigo, $uiux->pesquisa, $uiux->pagina, 20);
            break;
        case "rascunhos":
            // Pesquisa somente os publicados
            $postagens->rascunhoPorDiciplina($codigo, $uiux->pesquisa, $uiux->pagina, 20);
            break;
        default: // pesquisa padrao
            // Pesquisa somente os que estão postados
            $postagens->publicadoPorDiciplina($codigo, $uiux->pesquisa, $uiux->pagina, 20);
            break;
    }

} else {
    // Se for um aluno padrão ele ira pesquisar apenas pelos conteudos postados
    $postagens->publicadoPorDiciplina($codigo, $uiux->pesquisa, $uiux->pagina, 20);
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
    $lista->home="disciplina.php?codigo=$codigo&pesquisa=$uiux->pesquisa";
    if ($uiux->pagina<=1){
        $lista->prev=false;
    }else{
        $anteriorPagina=$uiux->pagina-1;
        $lista->prev="disciplina.php?codigo=$codigo&pesquisa=$uiux->pesquisa&pagina=$anteriorPagina";
    }
    $lista->next=false;
}
unset($lista);
unset($uiux)
?>
