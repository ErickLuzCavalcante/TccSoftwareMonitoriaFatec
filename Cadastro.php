<?php
include("php/interfaces.php");

$SenhasIguais = true;
$CadastradoComSucesso = false;
$objeto_interface = new interfaces("Cadastro", 0);
if (isset($_POST["CPFUsuario"])) {
    $classeUsuario = new usuario();
    $CPFUsuario = $_POST["CPFUsuario"];
    $nomeUsuario = $_POST["nomeUsuario"];
    $sobrenomeUsuario = $_POST["sobrenomeUsuario"];
    $emailUsuario = $_POST["emailUsuario"];
    $telefoneUsuario = $_POST["telefoneUsuario"];
    $palavraChaveUsuario = $_POST["palavraChaveUsuario_1"];
    if ($_POST["palavraChaveUsuario_1"] == $_POST["palavraChaveUsuario_2"]) {
        $CadastradoComSucesso = true;

        $classeUsuario->novoUsuario(
            $CPFUsuario,
            $nomeUsuario,
            $sobrenomeUsuario,
            $emailUsuario,
            $telefoneUsuario,
            $palavraChaveUsuario
        );
    } else {
        $SenhasIguais = false;
    }
}

?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/cadastro.css" rel="stylesheet">

<div class="container">
    <div class="text-center">
        <img class="mb-4 " src="img/logofatec.png" alt="text-center">
    </div>
    <h1 class="h3 mb-3 font-weight-normal text-center">Cadastrar </h1>
    <!-- Formulario  Cadastro -->
    <?php
    if ($SenhasIguais == false) {
        echo '<div class="alert  alert-danger" role="alert">
        <center>As Senhas não são iguais!</center>
      </div>';
    }
    if ($CadastradoComSucesso) {
        echo '<div class="alert center alert-success" role="alert">
        <center>Usuario Cadastrado com Sucesso!<center>
      </div>';
    }
    ?>
    <form method="POST" action="Cadastro.php">

        <div class="row">
            <div class="col-4, centralizado">
                <br><input type="text" class="form-control" name="nomeUsuario" placeholder="Nome" required>
            </div>

            <div class="col-4, centralizado">
                <br><input type="text" class="form-control" name="sobrenomeUsuario" placeholder="Sobrenome" required>
            </div>

            <div class="col-4, centralizado">
                <br><input type="email" class="form-control" name="emailUsuario" placeholder="E-mail" required>
            </div>

            <div class="col-4, centralizado">
                <br><input type="tel" class="form-control" name="telefoneUsuario" placeholder="Telefone" required>
            </div>

            <div class="col-4, centralizado">
                <br><input type="text" class="form-control" name="raAluno" placeholder="R.A" required>
            </div>

            <div class="col-4, centralizado">
                <br><input type="text" class="form-control" name="CPFUsuario" placeholder="CPF" required>
            </div>

            <div class="col-6, centralizado">
                <br><input type="password" id="inputPassword" name="palavraChaveUsuario_1" class="form-control"
                    placeholder="Senha" required>
            </div>

            <div class="col-6, centralizado">
                <br><input type="password" id="inputPassword" name="palavraChaveUsuario_2" class="form-control"
                    placeholder="Confirme senha" required>
            </div>
        </div>
        <br>
        <div class="botao1">
            <button class="btn btn-lg btn-danger btn-block" type="submit">Cadastrar</button>
            <a href="Login.html" class="btn btn-lg btn-danger btn-block" type="button">Logar</button></a>
        </div>
</div>
</form>
</div>
</div>


<?php
unset($objeto_interface);
?>