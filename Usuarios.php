<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <link href="assets/css/dashboard.css" rel="stylesheet">
    <link href="css/lista.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    

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
  </head>
  <body>
  
    <?php include "cabecalho.php"?>   


    <!--  corpo -->
    <main class="col-md-9 ms-sm-auto col-lg-12 px-md-4">
        <br>  
            <div class="container">
                <h2>Lista De Usuarios</h2>
                <input class="form-control" id="myInput" type="text" placeholder="Search..">
                <div class="main-box clearfix">
                    <div class="table-responsive" id="myInput">
                        <table class="table user-list">
                            <thead>
                                <tr>
                                    <th><span>Usuario</span></th>
                                    <th><span>Tipo</span></th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <trx>
                                    <td>
                                        <img src="img/user.png" alt="">
                                        <p class="h5 mb-3 font-weight-normal">Paula Vieira</p>	
                                    </td>
                                    <td><p class="h6 mb-3 font-weight-normal">Admin</p></td>
                                    <td>
                                    </td>
                                    <td style="width: 20%;">
                                        <a href="#" class="table-link">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span></a>
                                            <a href="" data-toggle="modal" data-target="#excluir_usuario" class="table-link danger">
                                              <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="img/user.png" alt="">
                                        <p class="h5 mb-3 font-weight-normal">Erick Luz</p>	
                                    </td>
                                    <td><p class="h6 mb-3 font-weight-normal">Admin</p></td>
                                    <td>
                                    </td>
                                    <td style="width: 20%;">
                                        <a href="#" class="table-link">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span></a>
                                            <a href="" data-toggle="modal" data-target="#excluir_usuario" class="table-link danger">
                                              <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="img/user.png" alt="">
                                        <p class="h5 mb-3 font-weight-normal">Darlyne Bernardo</p>	
                                    </td>
                                    <td><p class="h6 mb-3 font-weight-normal">Monitor</p></td>
                                    <td>
                                    </td>
                                    <td style="width: 20%;">
                                        <a href="#" class="table-link">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span></a>
                                        <a href="" data-toggle="modal" data-target="#excluir_usuario" class="table-link danger">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="img/user.png" alt="">
                                        <p class="h5 mb-3 font-weight-normal">Samuel Sales</p>	
                                    </td>
                                    <td><p class="h6 mb-3 font-weight-normal">Usuario</p></td>
                                    <td>
                                    </td>
                                    <td style="width: 20%;">
                                        <a href="#" class="table-link">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span></a>
                                            <a href="" data-toggle="modal" data-target="#excluir_usuario" class="table-link danger">
                                              <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
            </div>
    </div>
    <!--------------------------------------Modal excluir usuario ------------------------------------------------>   
      <div class="modal fade" id="excluir_usuario"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Atenção</h5>
                <button type="text" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Voce gostaria de realmente excluir esse Usuario?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger">Sim Salvar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
            </div>
          </div>
        </div>
      </div>
    <!---------------------------------------------------------------------------------------------->
    </main>
    </div>
    </div>
</body>
<script src="js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>

   <!-- Modal JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
</html>
