<?php

/*Importações*/
include ("cnn.php");


/*Configurações e ajustes de sessão e cookies */
@ini_set('session.gc_maxlifetime', 604800);
@session_set_cookie_params(604800);
@session_start();
/*--------------------------------------------*/


class usuario extends banco{

  private $CPFUsuario;
  private $nomeUsuario;
  private $sobrenomeUsuario;
  private $emailUsuario;
  private $telefoneUsuario;
  private $palavraChaveUsuario;


  public function getCPFUsuario()
  {
    return $this->CPFUsuario;
  }

  public function getNomeUsuario()
  {
    return $this->nomeUsuario;
  }

  public function getSobrenomeUsuario()
  {
    return $this->sobrenomeUsuario;
  }

  public function getEmailUsuario()
  {
    return $this->emailUsuario;
  }


  public function getPalavraChaveUsuario()
  {
    return $this->palavraChaveUsuario;
  }





  /*Metodos padrões do banco de dados */


  /*Não altera */
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

  private function Get($query){
    $retorno=$this->Pesquisa($query);
    $this->primeiro();
    return $retorno;
  }

  /* Altera conforme a tabela*/

  private function atribuir(){


    /*
    $this->UserUsuario=$this->Dados[$this->getRegistro()][1];
    $this->nomeUsuario=$this->Dados[$this->getRegistro()][2];
    $this->sobrenomeUsuario=$this->Dados[$this->getRegistro()][3];
    $this->emailUsuario=$this->Dados[$this->getRegistro()][4];
    $this->palavraChaveUsuario=$this->Dados[$this->getRegistro()][5];
    $this->superUsuario=$this->Dados[$this->getRegistro()][6];
    */
  }

  /*Fim dos metodos padrao */


  /* Cria um novo usuário no banco de dados */
  public function novoUsuario($CPFUsuario, $nomeUsuario, $sobrenomeUsuario, $emailUsuario,$telefoneUsuario,$palavraChaveUsuario){

    // Inicio da string de SQL
    // Campos do banco de dados

    $sql =

    "INSERT INTO `usuarios`
        (
        `CPFUsuario`,
        `nomeUsuario`,
        `sobrenomeUsuario`,
        `telefoneUsuario`,
        `emailUsuario`,
        `palavraChaveUsuario`
        )
        ";

    //  Valores onde serão inseriedos
    $sql =$sql .
        " VALUES ('"
        . $CPFUsuario."', '"
        . $nomeUsuario."', '"
        . $sobrenomeUsuario."', '"
        .$telefoneUsuario."', '"
        .$emailUsuario."', '"
        . MD5($palavraChaveUsuario) ."');";


    $this->ExecultaSQL($sql);


  }






}
?>
