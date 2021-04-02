<?php
include 'php\usuarios.php';
include 'php\alunos.php';

class interfaces
{

    /**
     * interfaces constructor.
     */

    /* Nivel de acesso:
    0 - nao necessita de autenticacao para acessar a pagina 
    1 - Só precisa estar logado (Aluno)
    2 - Precisa ser administrador
    */


    public function __construct($titulo, $nivelDeAcesso)
    {
        // Instancia o objeto com a classe usuario
        $usuario = new usuario();

        if ($usuario->verificaLogado() && $nivelDeAcesso == 1) {
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
                                </head>>
                               <body>
                    ';
    }

    /**
     * interfaces constructor.
     */

    public function __destruct()
    {
        echo '</body></html>';
    }
}