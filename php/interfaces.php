<?php

namespace tcc\monitoria;

require 'php\cnn.php';
require 'php\usuarios.php';
require 'php\alunos.php';
require 'php\disciplinas.php';


class Interfaces
{

    public $pesquisa;
    public $pagina;
    private $filtro = [];
    private $filtroPadrao;
    private $nivelUsuarioLogado = 0;
    private $itensMenu = [];


    /*
    Nivel de acesso:
    False - nao necessita de autenticacao para acessar a pagina
    1 - Só precisa estar logado (Aluno)
    2 - Precisa ser administrador
    */

    /**
     * interfaces constructor.
     */


    public function __construct($titulo, $nivelDeAcesso)
    {

        if (isset($_GET['pesquisa'])) {
            $this->pesquisa = $_GET['pesquisa'];
        } else {
            $this->pesquisa = "";
        }
        if (isset($_GET['pagina'])) {
            $this->pagina = $_GET['pagina'];
        } else {
            $this->pagina = 1;
        }

        if (isset($_GET['filtro'])) {
            header('Location: ' . $_GET['filtro'] . '?pesquisa=' . $this->pesquisa . '&pagina=' . $this->pagina);
        }

        // Instancia o objeto com a classe usuario
        $usuario = new Usuario();
        $MensagemNivelTeste = '';
        if ($usuario->verificaLogado() && $nivelDeAcesso == 1) {
            // Precisa estar logado para acessar
            $this->nivelUsuarioLogado = 1;
        } else if ($usuario->verificaAdministrador() && $nivelDeAcesso == 2) {
            // Precisa estar logado para acessar e tem que ser adm
            $this->nivelUsuarioLogado = 2;
        } else if ($nivelDeAcesso == false) {
            // nao possui restricao
            $this->nivelUsuarioLogado = 0;
        } else {
            $this->nivelUsuarioLogado = 0;
            header('Location: Login.php');
        }

        echo "
               <!doctype html>
                <html lang='pt-br' class='no-js'>
                
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1'>
                
                    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
                    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
                    <link rel = 'stylesheet' href = 'css/reset.css' > <!--CSS reset-->
                    <link rel = 'stylesheet' href = 'css/style.css' > <!--Estilos do pagina-->
                    <script src = 'js/modernizr.js' ></script > <!--Modernizr -->
                
                    <title > $titulo | Fatec monitor </title >
                </head >
                
                <body >
                    <header class='cd-main-header animate-search' >
                        <div class='cd-logo' ><a href = '#0' ><img src = 'img/cd-logo.svg' alt = 'Logo' ></a ></div >
                
                        <nav class='cd-main-nav-wrapper' >
                            <a href = '#search' class='cd-search-trigger cd-text-replace' > Pesquisa</a >
                
                            <ul class='cd-main-nav' >
    ";

    }    //end __construct()

    public function addItemMenu($link, $Texto,$administrador){
        $usuario = new Usuario();
        if ($administrador==false||($administrador==true&&$usuario->verificaAdministrador())){
            echo "                                <li ><a href = '$link' > $Texto</a ></li >";
        }

    }
    public function fecharmenu(){
        echo"
                                    </ul > <!-- .cd - main - nav-->
                        </nav > <!-- .cd - main - nav - wrapper-->
                
                        <a href = '#0' class='cd-nav-trigger cd-text-replace' > Menu<span ></span ></a >
                    </header >
                
                    <main class='cd-main-content' >
                        <div class='content-center' >
    ";

    }
    // Destrutor
    public function __destruct()
    {
        if (!isset($this->filtroPadrao)) {
            $this->filtroDePesquisa("Disciplinas", "index.php", true);
        }

        echo '
                        </div>
                    </main>
                
                    <div id="search" class="cd-main-search">
                        <form>
                            <input type="search" name="pesquisa" placeholder="Pesquisa..." value="' . $this->pesquisa . '">
                
                            <div class="cd-select">
                                <span>em</span>
                                <select name="filtro">';
        foreach ($this->filtro as $i => $value) {
            echo($this->filtro[$i]);
        }
        echo '
                                </select>
                                <span class="selected-value">' . $this->filtroPadrao . '</span>
                            </div>
                        </form>
                
                
                
                        <a href="#0" class="close cd-text-replace">Close Form</a>
                    </div> <!-- .cd-main-search -->
                
                    <div class="cd-cover-layer"></div>
                    <!-- cobrir o conteúdo principal quando o formulário de pesquisa estiver aberto -->
                    <script src="js/jquery-2.1.4.js"></script>
                    <script src="js/main.js"></script> <!-- Resource jQuery -->
                </body>
                
                </html>';

    }

    public function getNivelUsuario()
    {
        return $this->nivelUsuarioLogado;
    }

    public function filtroDePesquisa($descricao, $link, $selecionado)
    {

        $linha = '<option value="' . $link . '"';

        if ($selecionado) {
            $linha = $linha . " selected";
            $this->filtroPadrao = $descricao;
        }
        $linha = $linha . '>' . $descricao . '</option>';

        $this->filtro[] = $linha;
    }





}//end class
