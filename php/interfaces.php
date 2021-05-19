<?php

namespace tcc\monitoria;

require 'php\cnn.php';
require 'php\usuarios.php';
require 'php\alunos.php';


class Interfaces
{

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

        echo '
                        <!doctype html>
                            <html lang="pt-br">
                              <head>
                                <meta charset="utf-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1">
                                <meta name="description" content="">
                                <meta name="author" content="Erick Luz Cavalcante, Samuel Sales, Paula Vieira, Darlyne">
                                <meta name="generator" content="">
                                <title>' . $titulo . ' - Software Monitoria</title>
                                <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
                                <!-- Bootstrap core CSS -->
                                <link href="assets/css/bootstrap.min.css" rel="stylesheet">
                                </head>
                               <body>
                    ';

    }//end __construct()


    /**
     * interfaces constructor.
     */

    public function cabecalho($pesquisa)
    {

        echo " 
        <script>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
         }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
              font-size: 3.5rem;
            }
        }
        .perfil {
            border-radius: 50%;
        }
        </script>
        
        <link href='assets/css/dashboard.css' rel='stylesheet'>
        <link href='/css/bootstrap.min.css' rel='stylesheet'>
        
 



    
<header class='navbar navbar-dark sticky-top bg-danger flex-md-nowrap p-0 '>
  <a class='navbar-brand col-md-3 col-lg-2 me-0 px-3' href='home.php'>Fatec Monitor</a>

  <input class='form-control form-control-light w-50 shadow ' type='text' placeholder='Search' aria-label='Search' value='".$pesquisa."'>
  
  <button class='perfi-principal btn btn-danger nav-item dropdown'>
            <img class='perfil' src='img/logo.png' width='60px' height='35px' id='navbardrop' data-toggle='dropdown'>
            <div class='dropdown-menu sm-menu'>
              <a class='dropdown-item' href='#'>Nome_Perfil</a>
              <a class='dropdown-item' href='trocasenha.html'>Trocar Senha</a>
              <a class='dropdown-item' href='login.php'>Sair</a>

            </div>
            <a >
  </button>
</header>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'></script>
<script type='text/javascript'>
$(document).ready(function () {
$('.perfil-principal .navbar-light .dmenu').hover(function () {
        $(this).find('.sm-menu').first().stop(true, true).slideDown(150);
    }, function () {
        $(this).find('.sm-menu').first().stop(true, true).slideUp(105)
    });
});
</script>
        
        
        ";

    }

    // Destrutor
    public function __destruct()
    {
        echo '</body></html>';

    }


}//end class
