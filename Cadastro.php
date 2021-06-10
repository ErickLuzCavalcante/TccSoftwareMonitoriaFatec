<?php

namespace tcc\monitoria;

include "php/interfaces.php";
include "php/formulario.php";

/**
 *
 *  Objetos
 *
 * */

$usuario = new Usuario();
$aluno = new Alunos();

/**
 *
 *  Tratativa de entrada de dados
 *
 * */

$nomeUsuario = "";
$sobrenomeUsuario = "";
$telefoneUsuario = "";
$emailUsuario = "";
$raAluno = "";
$CPFUsuario = "";
$palavraChaveUsuario_1 = "";
$palavraChaveUsuario_2 = "";
$monitor = 0;
$TipoUsuario = false;
$falha = "";
$link = "Cadastro.php";
$ehAluno = true;
if (isset($_GET["modalidade"])) {
    if ($_GET["modalidade"] == "administrador") {
        $ehAluno = false;
        unset($aluno);
    }
}

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];
    $usuario->porCPF($codigo);

    $nomeUsuario = $usuario->getNomeUsuario();
    $sobrenomeUsuario = $usuario->getSobrenomeUsuario();
    $telefoneUsuario = $usuario->getTelefoneUsuario();
    $emailUsuario = $usuario->getEmailUsuario();
    $CPFUsuario = $usuario->getCPFUsuario();

    $ehAluno = !$usuario->verificaAdministrador();
    if ($ehAluno) {
        $aluno->porCPF($codigo);
        $raAluno = $aluno->getRaAluno();
        $TipoUsuario = $aluno->getMonitorAluno();
    } else {
        unset($aluno);
    }

    $link = "Cadastro.php?codigo=$codigo";
}


if (isset($_POST["nomeUsuario"])) {
    $ehAluno = isset($_POST["raAluno"]);
    $nomeUsuario = $_POST["nomeUsuario"];
    $sobrenomeUsuario = $_POST["sobrenomeUsuario"];
    $telefoneUsuario = $_POST["telefoneUsuario"];
    $emailUsuario = $_POST["emailUsuario"];
    if (isset($_GET['codigo'])) {
        $CPFUsuario = $codigo;
    } else {
        $CPFUsuario = $_POST["CPFUsuario"];
    }
    $palavraChaveUsuario_1 = $_POST["palavraChaveUsuario_1"];
    $palavraChaveUsuario_2 = $_POST["palavraChaveUsuario_2"];

    if ($ehAluno) {
        $raAluno = $_POST["raAluno"];
        @$TipoUsuario = $_POST["TipoUsuario"];
        if ($TipoUsuario == "yep") $TipoUsuario = 1;
    } else {
        unset($aluno);
    }

    if (isset($codigo)) {
        switch ($_POST['alteracoes']) {
            case "salvar":
                $codigo = $CPFUsuario;
                $usuario->editarUsuario($CPFUsuario, $nomeUsuario, $sobrenomeUsuario, $emailUsuario, $telefoneUsuario);
                if ($ehAluno) $aluno->editarAluno($CPFUsuario, $raAluno, $TipoUsuario);
                $link = "Cadastro.php?codigo=$codigo";
                break;
            case "pssd":
                $codigo = $CPFUsuario;
                if ($palavraChaveUsuario_1 == $palavraChaveUsuario_2) {
                    $usuario->AlterarSenhaUsuario($CPFUsuario, $palavraChaveUsuario_1);
                    $link = "Cadastro.php?codigo=$codigo";
                    $falha = "Senha alterada com sucesso";
                } else {
                    $falha = "A senha e a confirmação da senha são divergentes";
                }

                $link = "Cadastro.php?codigo=$codigo";
                break;

            case "excluir" :
                if ($ehAluno) $aluno->excluirAluno($CPFUsuario);
                $usuario->excluirusuario($CPFUsuario);
                $falha = "usuário excluido";
                $link = "index.php";
                break;
        }

    } else {
        if ($palavraChaveUsuario_1 == $palavraChaveUsuario_2) {
            $codigo = $CPFUsuario;
            $usuario->novoUsuario($CPFUsuario, $nomeUsuario, $sobrenomeUsuario, $emailUsuario, $telefoneUsuario, $palavraChaveUsuario_1);
            if ($ehAluno) $aluno->novoAluno($CPFUsuario, $raAluno, $TipoUsuario);
            $link = "Cadastro.php?codigo=$codigo";
        } else {
            $falha = "A senha e a confirmação da senha são divergentes";
        }

    }
}


$uiux = new Interfaces("Cadastro", 2, false);
$uiux->addItemMenu("javascript:close();", "Para sair do cadastro feche a guia", false);
$uiux->fecharmenu();


/**
 *
 *  Cria o formulario
 *
 * */
if ($TipoUsuario == 1) {
    $TipoUsuario = true;
} else {
    $TipoUsuario = false;
}
$formulario = new formulario($link, "Cadastro Usuario");
if ($falha != "") {
    $formulario->falha(strtoupper($falha));
}
$formulario->adcionarCampo("nomeUsuario", "emoji_people", "Nome", $nomeUsuario, "requerido");
$formulario->adcionarCampo("sobrenomeUsuario", "family_restroom", "Sobrenome", $sobrenomeUsuario, "requerido");
$formulario->adcionarCampo("telefoneUsuario", "call", "Telefone", $telefoneUsuario, "requerido");
$formulario->adcionarCampo("emailUsuario", "mail", "E-mail", $emailUsuario, "email-requerido");
if ($ehAluno) {
    $formulario->adcionarCampo("raAluno", "local_offer", "R.A.", $raAluno, "requerido");
}
if ($CPFUsuario == "") {
    $formulario->adcionarCampo("CPFUsuario", "badge", "CPF", $CPFUsuario, "requerido");
    $formulario->adcionarCampo("palavraChaveUsuario_1", "password", "Senha", "", "senha-requerido");
    $formulario->adcionarCampo("palavraChaveUsuario_2", "check", "Confirme a senha", "", "senha-requerido");
} else {
    $formulario->adcionarCampo("CPFUsuario", "badge", "CPF", $CPFUsuario, "desabilitado");
    $formulario->adcionarCampo("palavraChaveUsuario_1", "password", "Senha", "", "senha");
    $formulario->adcionarCampo("palavraChaveUsuario_2", "check", "Confirme a senha", "", "senha");
}
if ($ehAluno) {
    $formulario->inicioCheck("verified", "O aluno é monitor?");
    $formulario->adcionarCheck("TipoUsuario", "", "Sim, ele é monitor", "yep", $TipoUsuario);
    $formulario->fimCheck();
}

if (isset($codigo)) {
    $formulario->inicioRadioButtom("", "Tipos de alteração");
    $formulario->adcionarRadioButton("alteracoes", "save", "Salvar sem modificar a senha", "salvar", true);
    $formulario->adcionarRadioButton("alteracoes", "vpn_key", "Somente mudar a senha", "pssd", false);
    $formulario->adcionarRadioButton("alteracoes", "delete", "Excluir", "excluir", false);
    $formulario->fimRadioButtom();
}

unset($formulario);
unset($uiux);
?>




