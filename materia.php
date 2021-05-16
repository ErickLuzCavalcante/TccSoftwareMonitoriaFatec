<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

    

    <!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      
    </style>

    
    <!-- Custom styles for this template -->
    <link href="assets/css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    
  <?php include "cabecalho.php"?>   

<?php include "menu_lateral.php"?> 

    <!-- corpo -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="p-3 mb-2 bg-light text-dark"><h1>Gestao Financeira</h1>
          
            <button type="button" class="btn btn-outline-danger">Aulas</button>
             <!--<button type="button" class="btn btn-outline-danger">Sobre  </button>-->
            <!-- Campo do monitor de edição do conteudo  -->
            <button type="button" class="btn btn-outline-danger">Rascunhos    </button>
            <a href="editor.php" class="btn btn-outline-danger">Novo  </a>
            <!---------------------------------------------->

        </div>
        <!--   conteudo -->
        <div class="container">
            <div class="row">
              <div class="col-6 bg-light">
                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <a href="conteudo.php" class="list-group-item btn-outline-danger">O que é Gestão Financeira</a>
                                <a href="conteudo.php" class="list-group-item btn-outline-danger">Juros Simples e Composto</a>
                                <a href="conteudo.php" class="list-group-item btn-outline-danger"> Tabela Price </a>
                                <a href="conteudo.php" class="list-group-item btn-outline-danger">Tabela SAC</a>
                                <a href="conteudo.php" class="list-group-item btn-outline-danger">Tabela AME</a>
                              </ul>
                        </div>
                      </div>
                    </div>
                      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <a href="ww.google.com" class="list-group-item btn-outline-danger">O que é Gestão Financeira</a>
                                <a href="ww.google.com" class="list-group-item btn-outline-danger">conteudo</a>
                                <a href="ww.google.com" class="list-group-item btn-outline-danger">conteudo</a>
                                <a href="ww.google.com" class="list-group-item btn-outline-danger">conteudo</a>
                                <a href="ww.google.com" class="list-group-item btn-outline-danger">conteudo</a>
                              </ul>
                        </div>
                      </div>
                   
         
              <div class="col-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Progresso</h5>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                        </div>
                        <br>
                      <h6 class="card-subtitle mb-2 text-muted">Monitor</h6>
                      <p class="card-text">Samuel Sales</p>
                      <a href="#" class="card-link">Continuar</a>
                      <a href="#" class="card-link">Inicio</a>
                    </div>
                  </div>
              </div>
        

</body>
<script src="js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>

</html>
