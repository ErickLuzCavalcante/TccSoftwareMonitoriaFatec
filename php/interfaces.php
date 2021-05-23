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
    public $filtro=[];
    public $filtroPadrao;

    /**
     * interfaces constructor.
     */

    /*
        Nivel de acesso:
        False - nao necessita de autenticacao para acessar a pagina
        1 - Só precisa estar logado (Aluno)
        2 - Precisa ser administrador
    */


    public function __construct($titulo, $nivelDeAcesso)
    {

        if (isset($_GET['pesquisa'])){
            $this->pesquisa=$_GET['pesquisa'];
        }else{
            $this->pesquisa="";
        }
        if (isset($_GET['pagina'])){
            $this->pagina=$_GET['pagina'];
        }else{
            $this->pagina=1;
        }

        if (isset($_GET['filtro'])){
            header('Location: '.$_GET['filtro'].'?pesquisa='.$this->pesquisa.'&pagina='.$this->pagina);
        }

        // Instancia o objeto com a classe usuario
        $usuario = new Usuario();
        $MensagemNivelTeste = '';
        if ($usuario->verificaLogado() && $nivelDeAcesso == 1) {
            // Precisa estar logado para acessar
        } else if ($usuario->verificaAdministrador() && $nivelDeAcesso == 2) {
            // Precisa estar logado para acessar e tem que ser adm
        } else if ($nivelDeAcesso == false) {
            // nao possui restricao
        } else {
            header('Location: Login.php');
        }

        echo "
               <!doctype html>
                <html lang='en' class='no-js'>
                
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1'>
                
                    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
                    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
                    <link rel = 'stylesheet' href = 'css/reset.css' > <!--CSS reset-->
                    <link rel = 'stylesheet' href = 'css/style.css' > <!--Estilos do pagina-->
                    <script src = 'js/modernizr.js' ></script > <!--Modernizr -->
                
                    <title > Home | Fatec monitor </title >
                </head >
                
                <body >
                    <header class='cd-main-header animate-search' >
                        <div class='cd-logo' ><a href = '#0' ><img src = 'img/cd-logo.svg' alt = 'Logo' ></a ></div >
                
                        <nav class='cd-main-nav-wrapper' >
                            <a href = '#search' class='cd-search-trigger cd-text-replace' > Pesquisa</a >
                
                            <ul class='cd-main-nav' >
                                <li ><a href = '#0' > Inicio</a ></li >
                                <li ><a href = '#0' > Perfil</a ></li >
                                <li ><a href = '#0' > Trocar senha </a ></li >
                                <li ><a href = 'login.php' > Sair</a ></li >
                            </ul > <!-- .cd - main - nav-->
                        </nav > <!-- .cd - main - nav - wrapper-->
                
                        <a href = '#0' class='cd-nav-trigger cd-text-replace' > Menu<span ></span ></a >
                    </header >
                
                    <main class='cd-main-content' >
                        <div class='content-center' >
    ";

    }//end __construct()


    public function filtroDePesquisa($descricao,$link,$selecionado){

        $linha='<option value="'.$link.'"';
        
        if ($selecionado){
            $linha= $linha . " selected";
            $this->filtroPadrao=$descricao;
        }
        $linha =$linha.'>'.$descricao.'</option>';

        $this->filtro[] = $linha;
    }

    // Destrutor
    public function __destruct()
    {
        if (!isset($this->filtroPadrao)){
            $this->filtroDePesquisa("Disciplinas","index.php",true);
        }

        echo '
                        </div>
                    </main>
                
                    <div id="search" class="cd-main-search">
                        <form>
                            <input type="search" name="pesquisa" placeholder="Pesquisa..." value="'.$this->pesquisa.'">
                
                            <div class="cd-select">
                                <span>em</span>
                                <select name="filtro">';
        foreach ($this->filtro as $i => $value) {
            echo($this->filtro[$i]);
        }
    echo '
                                </select>
                                <span class="selected-value">'.$this->filtroPadrao.'</span>
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


}//end class
