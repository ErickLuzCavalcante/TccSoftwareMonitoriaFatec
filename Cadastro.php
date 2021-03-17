<?php
include ("php/interfaces.php");

$objeto_interface = new interfaces("Cadastro");
if (isset($_POST["cd-usuario"])){
    
}
?>
<link href="css/cadastro.css" rel="stylesheet">

    <div class="container">
      <div class="text-center">
      <img class="mb-4 " src="img/logofatec.png" alt="text-center">
      </div>
      <h1 class="h3 mb-3 font-weight-normal text-center">Cadastrar </h1>
        <form>
          <div class="row">
            <div class="col-4">
              <input type="text" class="form-control" placeholder="Nome" required>
            </div>
            <div class="col-4">
              <input type="text" class="form-control" placeholder="Sobrenome" required>
            </div>
            <div class="col-4">
              <input type="email" class="form-control" placeholder="E-mail" required >
            </div>
            
            <div class="col-4">
              <br><input type="tel" class="form-control" placeholder="Telefone" required>
            </div><div class="col-4">
              <br><input type="text" class="form-control" placeholder="R.A" required>
            </div><div class="col-4">
              <br><input type="text" class="form-control" placeholder="CPF" required>
            </div>
            <div class="col-6">
              <br><input type="password" id="inputPassword" class="form-control" placeholder="Senha" required>
            </div><div class="col-6">
              <br><input type="password" id="inputPassword" class="form-control" placeholder="Confirme senha" required>
            </div>
          </div>
          <br>
          <div class="botao1">
            <button class="btn btn-lg btn-danger btn-block" type="submit">Cadastrar</button>
            <a href="Login.html"  class="btn btn-lg btn-danger btn-block"  type="button">Logar</button></a>
          </div>
        </div>
        </form> 
      </div>
    </div>


<?php
    unset($objeto_interface);
?>
