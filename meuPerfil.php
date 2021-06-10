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
 *  Carrega os dados
 *
 * */

$usuario->verificaLogado();


$nomeUsuario = $usuario->getNomeUsuario();
$sobrenomeUsuario = $usuario->getSobrenomeUsuario();
$telefoneUsuario = $usuario->getTelefoneUsuario();
$emailUsuario = $usuario->getEmailUsuario();
$CPFUsuario = $usuario->getCPFUsuario();
$aluno->porCPF($CPFUsuario);
$ehAluno=false;
if ($aluno->getRaAluno()!="") $ehAluno=true;
$falha = "";
if ($ehAluno) {

    $raAluno = $aluno->getRaAluno();
    $monitor = $aluno->getMonitorAluno();
}


if (isset($_POST["telefoneUsuario"])) {
    $telefoneUsuario = $_POST["telefoneUsuario"];
    $emailUsuario = $_POST["emailUsuario"];
    $palavraChaveUsuario_1 = $_POST["palavraChaveUsuario_1"];
    $palavraChaveUsuario_2 = $_POST["palavraChaveUsuario_2"];

    switch ($_POST['alteracoes']) {
        case "salvar":
            $usuario->editarUsuario($CPFUsuario, $nomeUsuario, $sobrenomeUsuario, $emailUsuario, $telefoneUsuario);
            break;

        case "pssd":
            if ($palavraChaveUsuario_1 != "") {
                if ($palavraChaveUsuario_1 == $palavraChaveUsuario_2) {
                    $usuario->editarUsuario($CPFUsuario, $nomeUsuario, $sobrenomeUsuario, $emailUsuario, $telefoneUsuario);
                    $usuario->AlterarSenhaUsuario($CPFUsuario, $palavraChaveUsuario_1);
                    $falha = "Senha alterada com sucesso";
                } else {
                    $falha = "A senha e a confirmação da senha são divergentes";
                }
            } else {
                $falha = "A senha não pode estar em branco";
            }
            break;
    }
}


$uiux = new Interfaces("Meu Perfil", 1, false);
// Itens do menu
$uiux->addItemMenu("index.php","Inicio",false);
// Se o usuario for administrador
$uiux->addItemMenu('usuario.php',"Usuários",true);

$uiux->addItemMenu("meuPerfil.php","Meu Perfil",false);
$uiux->addItemMenu("Login.php","Logoff",false);
$uiux->fecharmenu();


/**
 *
 *  Cria o formulario
 *
 * */


$formulario = new formulario("meuPerfil.php", "");
if ($falha != "") {
    $formulario->falha(strtoupper($falha));
}
$formulario->inicioConjunto("badge","Dados básicos");
$formulario->adcionarCampo("nomeUsuario", "emoji_people", " Nome", $nomeUsuario . " " . $sobrenomeUsuario, "desabilitado");
if ($ehAluno) {
    $formulario->adcionarCampo("raAluno", "local_offer", " R.A.", $raAluno, "desabilitado");
}
$formulario->adcionarCampo("CPFUsuario", "badge", " CPF", $CPFUsuario, "desabilitado");
$formulario->fimSelect();

$formulario->inicioConjunto("play_arrow","Contato");
$formulario->adcionarCampo("telefoneUsuario", "call", " Telefone", $telefoneUsuario, "requerido");
$formulario->adcionarCampo("emailUsuario", "mail", " E-mail", $emailUsuario, "email-requerido");
$formulario->fimSelect();

$formulario->inicioConjunto("admin_panel_settings","Senha");
$formulario->adcionarCampo("palavraChaveUsuario_1", "password", " Senha", "", "senha");
$formulario->adcionarCampo("palavraChaveUsuario_2", "check", "Confirme a senha", "", "senha");
$formulario->fimSelect();

$formulario->inicioConjunto("tune","Opções de alteração");
$formulario->inicioRadioButtom("", "Tipos de alteração");
$formulario->adcionarRadioButton("alteracoes", "save", "Salvar sem modificar a senha", "salvar", true);
$formulario->adcionarRadioButton("alteracoes", "vpn_key", "Salvar e modificar a senha", "pssd", false);
$formulario->fimRadioButtom();
$formulario->fimSelect();

unset($formulario);
unset($uiux);
?>




