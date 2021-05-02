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
        0 - nao necessita de autenticacao para acessar a pagina
        1 - Só precisa estar logado (Aluno)
        2 - Precisa ser administrador
    */


    public function __construct($titulo, $nivelDeAcesso)
    {
        // Instancia o objeto com a classe usuario
        $usuario            = new Usuario();
        $MensagemNivelTeste = '';
        if ($usuario->verificaLogado() && $nivelDeAcesso == 1) {
            // Precisa estar logado para acessar
        } else if ($usuario->verificaAdministrador() && $nivelDeAcesso == 2) {
            // Precisa estar logado para acessar e tem que ser adm
        } else if ($nivelDeAcesso) {
            // nao possui restricao
        } else {
            // Tentativa de acesso sem permissao
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
                                <title>'.$titulo.' - Software Monitoria</title>
                                <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
                                <!-- Bootstrap core CSS -->
                                <link href="assets/css/bootstrap.min.css" rel="stylesheet">
                                </head>>
                               <body>
                    ';

    }//end __construct()


    /**
     * interfaces constructor.
     */


    public function __destruct()
    {
        echo '</body></html>';

    }//end __destruct()


}//end class
