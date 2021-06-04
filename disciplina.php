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
     </a><br><hr/>
    <!-- Fim Link para editar a disciplina -->
    ";
}


// para todos
$infodisciplina = $infodisciplina . "
    <i class='material-icons'>school</i> Professor(a): " . $disciplina->getProfessorDisciplina() . " <br>
    
    <!-- Link para mostrar mais informacoes  -->
    <a href='#  target='_blank'>
        <i class='material-icons'>info</i> Mais informações  
     </a><br>
    <!-- Fim Link para mostrar mais informacoes  -->
";


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
            $estapublicado = false;
            $infopostagem = $infopostagem . "
                <br>
                <i class='material-icons'>visibility_off</i>
                Status: Não publicado  
                <br>";
        } else {
            $estapublicado = true;
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

} // Fim do IF que Verifica se ha algum resultado da pesquisa

unset($lista);
unset($uiux)
?>
