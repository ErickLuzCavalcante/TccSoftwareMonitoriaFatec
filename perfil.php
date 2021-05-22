<? php
include ("php\")
?>

<!doctype html>
<html lang="ptbr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Software Monitoria</title>

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

<?php include "cabecalho.php"?>   


<main class="col-md-9 ms-sm-auto col-lg-12 px-md-4">
          <div class="album py-5 bg-light">
            <div class="container">
              
<form class="row g-3">

<div class="row">
            <div class="col-4">
		<label for="inputEmail4" class="form-label">Nome</label>
                <br><input type="text" class="form-control" name="nomeUsuario" placeholder="Nome" required>
            </div>

            <div class="col-4">
                <br><input type="text" class="form-control" name="sobrenomeUsuario" placeholder="Sobrenome" required>
            </div>

            <div class="col-4">
                <br><input type="email" class="form-control" name="emailUsuario" placeholder="E-mail" required>
            </div>

            <div class="col-4">
                <br><input type="tel" class="form-control" name="telefoneUsuario" placeholder="Telefone" required>
            </div>

            <div class="col-4">
                <br><input type="text" class="form-control" name="raAluno" placeholder="R.A">
            </div>

            <div class="col-4">
                <br><input type="text" class="form-control" name="CPFUsuario" placeholder="CPF" required>
            </div>
  	</div>
  	<div class="col-6">
    		<button type="submit" class="btn btn-danger">Salvar</button>
  	</div>
    </form>
</main>
 
    <script src="js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>

