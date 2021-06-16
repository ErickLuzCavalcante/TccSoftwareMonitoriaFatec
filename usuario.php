<?php

namespace tcc\monitoria;

include "php/interfaces.php";
include "php/lista.php";


// inicilizo a interface
$uiux = new Interfaces("Usuários", 2, true);

// Carrega os dados confome o codgio da url, se houver o código na URL
$link = "usuario.php?";

// Filtro da pagina
$uiux->filtroDePesquisa("Usuários", "usuario.php?", true);

// Filtros padrão
$uiux->filtroDePesquisa("Disciplinas", "index.php?", false);


$uiux->padraoMenu();

// inicializa a lista
$lista = new lista();
echo "<br><br>";

$controleusuario = "
        <!-- Label filtro -->
        <i class='material-icons'>filter_alt</i> Filtros: <br>
        <!-- Fim Label -->

        <!-- Link para a visualizacao de todos os usuarios -->
        <a href='usuario.php?pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>people</i> Todos 
        </a><br>
        
         <!-- Link para a visualizacao somente os alunos -->
        <a href='usuario.php?listagem=Alunos&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>face</i> Alunos 
        </a><br>
        <!-- Fim Link para a visualizacao somente os alunos -->
        
        <!-- Link para a visualizacao somente os monitores -->
        <a href='usuario.php?listagem=Monitores&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>escalator_warning</i> Monitores 
        </a><br>
        <!-- Fim Link para a visualizacao somente os monitores -->
        
        <!-- Link para a visualizacao somente os monitores -->
        <a href='usuario.php?listagem=naoAdministradores&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>emoji_people</i> Alunos e monitores 
        </a><br>
        <!-- Fim Link para a visualizacao somente os monitores -->
        
        <!-- Link para a visualizacao somente os monitores -->
        <a href='usuario.php?listagem=Administradores&pesquisa=$uiux->pesquisa&pagina=1'>
            <i class='material-icons'>assignment_ind</i> Administradores 
        </a><br>
        <!-- Fim Link para a visualizacao somente os monitores -->
        
        <hr/>
        <i class='material-icons'>add_circle</i> Novo: <br>
        
        <!-- Link para a visualizacao somente os monitores -->
        <a href='Cadastro.php' target='_blank'>
            <i class='material-icons'>person</i> Aluno ou Monitor
        </a><br>
        <!-- Fim Link para a visualizacao somente os monitores -->
        
        <!-- Link para a visualizacao somente os monitores -->
        <a href='Cadastro.php?modalidade=administrador' target='_blank'>
            <i class='material-icons'>assignment_ind</i> Administrador
        </a><br>
        <!-- Fim Link para a visualizacao somente os monitores -->
";
if ($uiux->pesquisa != "") {
    $controleusuario = $controleusuario . "
    <hr/><i class='material-icons'>search</i> Resultados da pesquisa por: " . $uiux->pesquisa;
}

// Cria o cabecalho da lista com o filtro da listagem de usuarios
$lista->add("manage_accounts", "Usuários", $controleusuario);


// Variavel pelo controle do tipo de pesquisa
$tipoDeListagem = "todos"; // define um valor padrao
if (isset($_GET["listagem"])) {
    $tipoDeListagem = $_GET["listagem"]; // caso tenha um get na url, troca o valor padrao pelo valor do get
}

$usuario = new Usuario();
$aluno = new Alunos();

// Filtra conforme o a variavel $tipoDeListagem
switch ($tipoDeListagem) {
    case "Alunos":
        // Pesquisa somente pelos alunos
        $usuario->ListarUsuarioAlunos($uiux->pesquisa, $uiux->pagina, 6);
        break;
    case "Monitores":
        // Pesquisa somente pelos monitores
        $usuario->ListarUsuarioMonitores($uiux->pesquisa, $uiux->pagina, 6);
        break;
    case "Administradores":
        // Pesquisa somente pelos administradores
        $usuario->ListarUsuarioAdministradores($uiux->pesquisa, $uiux->pagina, 6);
        break;
    case "naoAdministradores":
        // Pesquisa somente pelos alunos e monitores
        $usuario->ListarUsuarioAlunosEMonitores($uiux->pesquisa, $uiux->pagina, 6);
        break;
    default: // pesquisa padrao
        // Pesquisa todos os usuarios
        $usuario->Listar($uiux->pesquisa, $uiux->pagina, 6);
        break;
}




// IF que Verifica se ha algum resultado da pesquisa
if ($usuario->getTamanho() > 0) {
    // Loop que percorre por todo o resultado da pesquisa
    for ($i = 0; $usuario->ponteiro($i); $i++) {

        $conteudousuario="
            <i class='material-icons'>call</i> Telefone: ".$usuario->getTelefoneUsuario()."  <br> 
            <i class='material-icons'>mail</i> e-mail: ".$usuario->getEmailUsuario()."  <br>  
        ";
        $aluno->porCPF($usuario->getCPFUsuario());

        /* Valida o tipo de usuario e cria uma consulta personalizada para este tipo
            tambem define o caminho do editor reponsavel por alterar o determinado tipo de usuario
        */
        $linkcadastro="cadastro.php?codigo=".$usuario->getCPFUsuario(); // Se for um aluno o link do cadastro
        if ($aluno->getRaAluno()!=""){
            if ($aluno->getMonitorAluno()==1){
                $conteudousuario=$conteudousuario."
                 <i class='material-icons'>escalator_warning</i> Tipo: Monitor<br>";

            }else{
                $conteudousuario=$conteudousuario."
                <i class='material-icons'>face</i> Tipo: Aluno<br>";
            }
            $conteudousuario=$conteudousuario."
             <i class='material-icons'>local_offer</i> RA: ".$aluno->getRaAluno()."  <br> 
        ";
        }else {
            $conteudousuario=$conteudousuario."
                <i class='material-icons'>assignment_ind</i> Tipo: Administrador<br> ";
        }
        $conteudousuario=$conteudousuario."
            <i class='material-icons'>badge</i> CPF: ".$usuario->getCPFUsuario()."  <br></a>
        ";

        $lista->add("account_circle", "<a href='$linkcadastro' target='_blank'f>".$usuario->getNomeUsuario()." ".$usuario->getSobrenomeUsuario(), $conteudousuario);


        $usuario->proximo();
    } // Fim do Loop que percorre por todo o resultado da pesquisa
    $lista->home = "usuario.php?pesquisa=$uiux->pesquisa";
    $proximaPagina = $uiux->pagina + 1;
    if ($uiux->pagina <= 1) {
        $lista->prev = false;
    } else {
        $anteriorPagina = $uiux->pagina - 1;
        $lista->prev = "usuario.php?pesquisa=$uiux->pesquisa&pagina=$anteriorPagina";
    }
    $lista->next = "usuario.php?pesquisa=$uiux->pesquisa&pagina=$proximaPagina";
} else { // Fim do IF que Verifica se ha algum resultado da pesquisa
    echo "<br><br><h2> <i class='material-icons'>find_in_page</i>Não encontramos nada </h2>";
    $lista->home = "usuario.php?pesquisa=$uiux->pesquisa";
    if ($uiux->pagina <= 1) {
        $lista->prev = false;
    } else {
        $anteriorPagina = $uiux->pagina - 1;
        $lista->prev = "usuario.php?pesquisa=$uiux->pesquisa&pagina=$anteriorPagina";
    }
    $lista->next = false;
}
unset($lista);
unset($uiux)
?>
