<?php

class interfaces
{
    /**
     * interfaces constructor.
     */
    public function __construct($titulo)
    {
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

?>