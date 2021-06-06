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
            
        </div><br>
        <h1 class="title_form">Alterar Senha </h1>
        <!-- Formulario  Cadastro -->
    <?php
    if ($SenhasIguais == false) {
        echo '<div class="alert  alert-danger" role="alert">
        <center>As Senhas não são iguais!</center>
      </div>';
    }
    if ($CadastradoComSucesso) {
        echo '<div class="alert center alert-success" role="alert">
        <center>Usuario Senha alterada com Sucesso!<center>
      </div>';
    }
    ?>
    <form class="cd-form floating-labels"method="POST" action="Cadastro.php">

        <div class="row">

        
        <div class="col-4">
           
            <div class="col-4">
                <br><input type="password" id="inputPassword" name="palavraChaveUsuario_1" 
                    placeholder="Senha" required>
            </div>

            <div class="col-4">
                <br><input type="password" id="inputPassword" name="palavraChaveUsuario_2" 
                    placeholder="Confirme senha" required>
            </div>
        </div>
        <br>
        <div class="botao1">
        <input type='submit' value='Salvar' >
        </div>
</div>
</form>
</div>
</div>


