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
$CPFUsuario2 = "";
$palavraChaveUsuario_1 = "";
$palavraChaveUsuario_2 = "";
$monitor = 0;
$TipoUsuario = false;
$falha = "";
$link = "Cadastro.php";
$ehAluno = true;
if (isset($_GET["modalidade"])) {
    if ($_GET["modalidade"] == "administrador") {
        $link = "Cadastro.php?modalidade=administrador";
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
    $aluno->porCPF($codigo);
    if ($aluno->getRaAluno()=="") {
        $ehAluno =false;
    }else{
        $ehAluno=true;
    }

    if ($ehAluno) {
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

    if (isset($_POST["raAluno"])) {
        $ehAluno=true;
        $raAluno = $_POST["raAluno"];
        @$TipoUsuario = $_POST["TipoUsuario"];
        if ($TipoUsuario == "yep") {
            $TipoUsuario = 1;
        }else{
            $TipoUsuario = 0;
        }
    } else {
        unset($aluno);
    }

    if (isset($codigo)) {
        switch ($_POST['alteracoes']) {
            case "salvar":
                $codigo = $CPFUsuario;
                $usuario->editarUsuario($CPFUsuario, $nomeUsuario, $sobrenomeUsuario, $emailUsuario, $telefoneUsuario);
                $usuario->porCPF($CPFUsuario);
                if ($usuario->getCPFUsuario()==""){
                    $falha = "Não foi possivel alterar o usuario. '".$nomeUsuario." ".$sobrenomeUsuario."', pois foi removido da base de dados";
                }else if ($ehAluno) {
                    $aluno->editarAluno($CPFUsuario, $raAluno, $TipoUsuario);
                    $aluno->porCPF($CPFUsuario);
                    if ($aluno->getRaAluno()=="$raAluno"){
                        $sucesso = "Dados alterados com sucesso";
                    }else{
                        $falha = "Não foi possivel alterar o R.A. '".$raAluno."', pois Já esta sendo usado por em outro cadastro";
                        $raAluno=$aluno->getRaAluno();
                    }
                }else{
                    $sucesso = "Dados alterados com sucesso";
                }
                $link = "Cadastro.php?codigo=$codigo";
                break;
            case "pssd":
                $codigo = $CPFUsuario;
                if ($palavraChaveUsuario_1 != "") {
                    if ($palavraChaveUsuario_1 == $palavraChaveUsuario_2) {
                        $usuario->AlterarSenhaUsuario($CPFUsuario, $palavraChaveUsuario_1);
                        $link = "Cadastro.php?codigo=$codigo";
                        $sucesso = "Senha alterada com sucesso";
                    } else {
                        $falha = "A senha e a confirmação da senha são divergentes";
                    }
                } else {
                    $falha = "A senha não pode estar em branco";
                }


                $link = "Cadastro.php?codigo=$codigo";
                break;

            case "excluir" :
                if ($ehAluno) $aluno->excluirAluno($CPFUsuario);
                $usuario->excluirusuario($CPFUsuario);
                $falha = "Usuário excluido";
                $link = "index.php";
                break;
        }

    } else {
        if ($palavraChaveUsuario_1 != "") {
            // Consulta os dados no banco de dados para evitar duplicidade
            $usuario->porCPF($CPFUsuario);

            if ($usuario->getCPFUsuario()==$CPFUsuario){
                $falha = "Não foi possivel cadastrar. o CPF já é utilizado em outro cadastro";
                $CPFUsuario="";
            }

            if ($palavraChaveUsuario_1 == $palavraChaveUsuario_2) {

            } else {
                $falha = "A senha e a confirmação da senha são divergentes";
                $CPFUsuario2=$CPFUsuario;
                $CPFUsuario="";
            }

            // Caso nao encontre nenhuma falha realiza o cadastro
            if ($falha==""){
                $codigo = $CPFUsuario;
                $usuario->novoUsuario($CPFUsuario, $nomeUsuario, $sobrenomeUsuario, $emailUsuario, $telefoneUsuario, $palavraChaveUsuario_1);
                if ($ehAluno) {
                    $aluno->novoAluno($CPFUsuario, $raAluno, $TipoUsuario);
                    $aluno->porCPF($CPFUsuario);
                    if ($aluno->getRaAluno()==""){
                        $falha = "Não foi possivel cadastrar. o R.A. já é utilizado em outro cadastro";
                        $usuario->excluirusuario($CPFUsuario);
                        $CPFUsuario2=$CPFUsuario;
                        $CPFUsuario="";
                        $raAluno="";
                        unset($codigo);
                    }
                }


                if ($falha=="") {
                    $sucesso = "Cadastro realizado com sucesso";
                    $link = "Cadastro.php?codigo=$codigo";
                }
            }

        } else {
            $falha = "A senha não pode estar em branco";
        }

    }
}


$uiux = new Interfaces("Cadastro", 2, false);
$uiux->addItemMenu("javascript:window.close(\"#\")' onclick='window.close(\"#\");", "Para sair do cadastro feche a guia", false);
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
$formulario = new formulario($link, "");
if ($falha != "") {
    $formulario->falha(strtoupper($falha));
}
if (isset($sucesso)) {
    $formulario->sucesso(strtoupper($sucesso));
}
$formulario->inicioConjunto("badge","Dados básicos");
    $formulario->adcionarCampo("nomeUsuario", "emoji_people", "Nome", $nomeUsuario, 50,"requerido");
    $formulario->adcionarCampo("sobrenomeUsuario", "family_restroom", "Sobrenome", $sobrenomeUsuario, 10, "requerido");
    if ($ehAluno) {
        $formulario->adcionarCampo("raAluno", "local_offer", "R.A.", $raAluno, 20, "requerido");
    }
    if ($CPFUsuario == "") {
        $formulario->adcionarCampo("CPFUsuario", "badge", "CPF (somente numeros)", $CPFUsuario.$CPFUsuario2, 11, "requerido");
    }else{
        $formulario->adcionarCampo("CPFUsuario", "badge", "CPF", $CPFUsuario, 12, "desabilitado");
    }
$formulario->fimConjunto();


$formulario->inicioConjunto("play_arrow","Contato");
    $formulario->adcionarCampo("telefoneUsuario", "call", "Telefone", $telefoneUsuario, 12, "nao-requerido");
    $formulario->adcionarCampo("emailUsuario", "mail", "E-mail", $emailUsuario, 320, "email-requerido");
$formulario->fimConjunto();

$formulario->inicioConjunto("admin_panel_settings","Nivel de acesso");
    if ($CPFUsuario == "") {
        $formulario->adcionarCampo("palavraChaveUsuario_1", "password", "Senha", "", 100, "senha-requerido");
        $formulario->adcionarCampo("palavraChaveUsuario_2", "check", "Confirme a senha", "", 100, "senha-requerido");
    } else {
        $formulario->adcionarCampo("palavraChaveUsuario_1", "password", "Senha", "", 100, "senha");
        $formulario->adcionarCampo("palavraChaveUsuario_2", "check", "Confirme a senha", "", 100, "senha");
    }
    if ($ehAluno) {
        $formulario->inicioCheck("verified", "O aluno é monitor?");
        $formulario->adcionarCheck("TipoUsuario", "", "Sim, ele é monitor", "yep", 10, $TipoUsuario);

    }
$formulario->fimCheck();

$formulario->inicioConjunto("tune","Opções de alteração");
if (isset($codigo)) {
    $formulario->inicioRadioButtom("", "Deseja");
    $formulario->adcionarRadioButton("alteracoes", "save", "Salvar sem modificar a senha", "salvar", true);
    $formulario->adcionarRadioButton("alteracoes", "vpn_key", "Somente mudar a senha", "pssd", false);
    $formulario->adcionarRadioButton("alteracoes", "delete", "Excluir", "excluir", false);
    $formulario->fimRadioButtom();
}
$formulario->fimCheck();
unset($formulario);
unset($uiux);
?>




