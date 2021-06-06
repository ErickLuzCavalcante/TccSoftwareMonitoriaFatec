<?php

namespace tcc\monitoria;

include "php/interfaces.php";
require "php/publicacoes.php";


// Back-end
// Coleta de dados para alimentar a interface

$usuario = new Usuario();
$aluno = new Alunos();
$administrador = $usuario->verificaAdministrador();
$monitor = $aluno->verificaLogadoMonitor();
if ($administrador) $monitor = $administrador;

$aluno->getCPFUsuario($usuario->getCPFUsuario());
$postagens = new Publicacoes();
$rascunho = false;

if (isset($_GET["controlepostagem"]) && $monitor) {
    switch ($_GET["controlepostagem"]) {
        case "rascunho" :
            $rascunho = true;
            break;
        default:
            $rascunho = false;
            break;
    }
}


// Carrega os dados confome o codgio da url, se houver o código na URL

if (isset($_GET["codigo"])) {
    $codigo = $_GET["codigo"];
    if ($rascunho) {
        $postagens->rascunhoPorCodigo($codigo);
    } else {
        $postagens->publicadoPorCodigo($codigo);
    }
}

// inicilizo a interface

$uiux = new Interfaces($postagens->getTituloMaterial(), 1, false);


// Itens do menu
$uiux->addItemMenu("index.php", "Inicio", false);
// Se o usuario for administrador
$uiux->addItemMenu('index.php', "Editar Usuários", true);

$uiux->addItemMenu("index.php", "Trocar Senha", false);
$uiux->addItemMenu("Login.php", "Logoff", false);
$uiux->fecharmenu();



// Tratativa de erros e falhas
// Variaveis de controle
$SenhasIguais = true;
$CadastradoComSucesso = false;
$esqueceTipoAlunos = false;




// Se ele receber algum valor para gravar no banco de dados
if (isset($_POST["CPFUsuario"])) {
    $classeUsuario = new usuario();
    $CPFUsuario = $_POST["CPFUsuario"];
    $nomeUsuario = $_POST["nomeUsuario"];
    $sobrenomeUsuario = $_POST["sobrenomeUsuario"];
    $emailUsuario = $_POST["emailUsuario"];
    $telefoneUsuario = $_POST["telefoneUsuario"];
    $palavraChaveUsuario = $_POST["palavraChaveUsuario_1"];
    $raAluno = $_POST["raAluno"];
            
    if (isset($_POST["TipoUsuario"])) {
        $TipoUsuario = $_POST["TipoUsuario"];
    }
    if ($_POST["palavraChaveUsuario_1"] == $_POST["palavraChaveUsuario_2"]) {
        $CadastradoComSucesso = true;

        switch ($TipoUsuario) {
            case '2':
                // Aluno
                    $classeUsuario->novoUsuario(
                        $CPFUsuario,
                        $nomeUsuario,
                        $sobrenomeUsuario,
                        $emailUsuario,
                        $telefoneUsuario,
                        $palavraChaveUsuario
                    );
                    // cadastrando  o aluno
                    $monitorAluno = 0;
                    $classealuno = new alunos();
                    $classealuno->novoAluno(
                    $CPFUsuario,
                    $raAluno,
                    $monitorAluno
                );
                break;
                
            case '1':
                // Monitor
                $classeUsuario->novoUsuario(
                    $CPFUsuario,
                    $nomeUsuario,
                    $sobrenomeUsuario,
                    $emailUsuario,
                    $telefoneUsuario,
                    $palavraChaveUsuario
                );
                // cadastrando  o aluno
                $monitorAluno = 1;// setando como 1 o aluno sera monitor
                $classealuno = new alunos();
                $classealuno->novoAluno(
                $CPFUsuario,
                $raAluno,
                $monitorAluno
            );
                break;

            case '3':
                // Professor
                $classeUsuario->novoUsuario(
                    $CPFUsuario,
                    $nomeUsuario,
                    $sobrenomeUsuario,
                    $emailUsuario,
                    $telefoneUsuario,
                    $palavraChaveUsuario
                );
                break;

            default:
                // Esqueceu de selcionar o tipo de usuário
                $esqueceTipoAlunos = false;
        }


        
    } else {
        $SenhasIguais = false;
    }
}

?>
<link href="formulario/css/style.css" rel="stylesheet">
<script src='./formulario/js/jquery-2.1.1.js'></script>
        <link rel='stylesheet' href='./formulario/css/style.css'>
        <script src='./formulario/js/modernizr.js'></script>




        <br>
        <div class="title_form">
            <img  src="img/logofatec.png" alt="text-center">
        </div><br>
        <h1 class="title_form">Cadastrar </h1>
        <!-- Formulario  Cadastro -->
    <?php
    if ($SenhasIguais == false) {
        echo '<div class="alert  alert-danger" role="alert">
        <center>As Senhas não são iguais!</center>
      </div>';
    }
    if ($CadastradoComSucesso) {
        echo '<div class="alert center alert-success" role="alert">
        <center>Usuario Cadastrado com Sucesso!<center>
      </div>';
    }
    ?>
    <form class="cd-form floating-labels"method="POST" action="Cadastro.php">

        <div class="row">

        
        <div class="col-4">
                <br><input type="text"  name="nomeUsuario" placeholder="Nome" required>
            </div>

            <div class="col-4">
                <br><input type="text"  name="sobrenomeUsuario" placeholder="Sobrenome" required>
            </div>

            <div class="col-4">
                <br><input type="email"  name="emailUsuario" placeholder="E-mail" required>
            </div>

            <div class="col-4">
                <br><input type="text"  name="telefoneUsuario" placeholder="Telefone" required>
            </div>

            <div class="col-4">
                <br><input type="text"  name="raAluno" placeholder="R.A">
            </div>

            <div class="col-4">
                <br><input type="text"  name="CPFUsuario" placeholder="CPF" required>
            </div>

            <div class="col-4">
                <br><input type="password" id="inputPassword" name="palavraChaveUsuario_1" 
                    placeholder="Senha" required>
            </div>

            <div class="col-4">
                <br><input type="password" id="inputPassword" name="palavraChaveUsuario_2" 
                    placeholder="Confirme senha" required>
            </div>
            <div class="col-4">
                <br>
                <select class="form-control" name="TipoUsuario" required>
                    <option value="0" selected disabled>Tipo De Usuario</option>
                    <option value="2">Aluno</option>
                    <option value="1">Monitor</option>
                    <option value="3">Professor</option>
                </select>
            </div>
        </div>
        <br>
        <div class="botao1">
        <input type='submit' value='Enviar' >
        </div>
</div>
</form>
</div>
</div>


