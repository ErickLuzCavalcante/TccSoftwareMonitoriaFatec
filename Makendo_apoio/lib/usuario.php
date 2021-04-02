<?php
include ("Geral.php");
@ini_set('session.gc_maxlifetime', 604800);
@session_set_cookie_params(604800);
@session_start();


class usuario extends banco{

  private $UserUsuario;
  private $nomeUsuario;
  private $sobrenomeUsuario;
  private $emailUsuario;
  private $palavraChaveUsuario;
  private $superUsuario;


  public function primeiro(){
    $this->primeiroDados();
    $this->atribuir();
  }
  public function proximo(){
    $this->proximoDados();
    $this->atribuir();
  }
  public function anterior(){
    $this->anteriorDados();
    $this->atribuir();
  }

  public function getuserUsuario(){
    return $this->UserUsuario;
  }
  public function getnomeUsuario(){
    return $this->nomeUsuario;
  }
  public function getsobrenomeUsuario(){
    return $this->sobrenomeUsuario;
  }
  public function getemailUsuario(){
    return $this->emailUsuario;
  }



  /* Metodos de insersao de dados e alterção */
  public function novoUsuario($UserUsuario,$nomeUsuario,$sobrenomeUsuario,$emailUsuario,$palavraChaveUsuario){

    $sql =

    // Não usar aspas duplas

    "INSERT INTO `usuarios`
    (
      `UserUsuario`,
      `nomeUsuario`,
      `sobrenomeUsuario`,
      `emailUsuario`,
      `palavraChaveUsuario`
    )";

    //  Valores onde serão inseriedos
    $sql =$sql .
    " VALUES ('"

    . strtoupper ($UserUsuario) ."', '"
    . $nomeUsuario ."', '"
    . $sobrenomeUsuario ."', '"
    . strtoupper ($emailUsuario) ."', '"
    . MD5($palavraChaveUsuario) ."');";

    $this->ExecultaSQL($sql);

  }

  private function alteraUsuario($UserUsuario,$nomeUsuario,$sobrenomeUsuario,$emailUsuario,$palavraChaveUsuario){

    $sql =

    "UPDATE `usuarios` SET

    `nomeUsuario`='".$nomeUsuario."',
    `sobrenomeUsuario`='".$sobrenomeUsuario."',
    `emailUsuario`='".$emailUsuario."',
    `palavraChaveUsuario`='".MD5($palavraChaveUsuario)."'
    ";

    //  Valores onde serão inseriedos
    $sql =$sql .
    " WHERE  `UserUsuario`='".strtoupper ($UserUsuario)."';";
    $this->ExecultaSQL($sql);

  }



  public function Todos(){
    $query = "SELECT * FROM `usuarios`";
    return $this->Get($query);
  }
  public function porUser($usuario){
    $query = "SELECT

    `UserUsuario`,
    `nomeUsuario`,
    `sobrenomeUsuario`,
    `emailUsuario`,
    `palavraChaveUsuario`,
    `superUsuario`

    FROM `usuarios` WHERE
    `UserUsuario` = '".strtoupper ($usuario)."'"
    ;
    return $this->Get($query);
  }

  public function Moderador(){
    $passou=false;
    if (isset ($_SESSION['login'])){
      $usuario = $_SESSION['login'];
      $palavrachave = $_SESSION['senha'];
      if ($this->porUser($usuario)){
        if (strtoupper ($this->Username_usuario[1])==strtoupper ($usuario)&&$this->Especie_usuario[1]==2&&$palavrachave==$this->Palavrachave_usuario[1]){
          $passou=true;
        }
      }
    }
    return $passou;
  }
  public function IniciarSecao($usuario,$senha){
    $this->CancelaSecao();
    $usuario=strtoupper ( $usuario );

    $this->porUser($usuario);

    if (strtoupper ($this->UserUsuario)==$usuario && $this->palavraChaveUsuario==MD5($senha)){
      $_SESSION['login'] = strtoupper ($usuario);
      $_SESSION['senha'] = MD5($senha);
      return true;
    }else{
      return false;
    }
  }


  public function ValidaSessao(){
    if (isset($_SESSION['login'])&&isset($_SESSION['senha'])){
      $usuario=$_SESSION['login'];
      $senha=$_SESSION['senha'];
      $this->CancelaSecao();
      $usuario=strtoupper ( $usuario );
      $this->porUser($usuario);
      if (strtoupper ($this->UserUsuario)==$usuario && $this->palavraChaveUsuario==$senha){
        $_SESSION['login'] = strtoupper ($usuario);
        $_SESSION['senha'] = $senha;
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  public function CancelaSecao(){
    unset ($_SESSION['login']);
    unset ($_SESSION['senha']);
  }

  private function Get($query){
    $retorno=$this->Pesquisa($query);
    $this->primeiro();
    return $retorno;
  }

  private function atribuir(){
    $this->UserUsuario=$this->Dados[$this->getRegistro()][1];
    $this->nomeUsuario=$this->Dados[$this->getRegistro()][2];
    $this->sobrenomeUsuario=$this->Dados[$this->getRegistro()][3];
    $this->emailUsuario=$this->Dados[$this->getRegistro()][4];
    $this->palavraChaveUsuario=$this->Dados[$this->getRegistro()][5];
    $this->superUsuario=$this->Dados[$this->getRegistro()][6];

  }

}
?>
