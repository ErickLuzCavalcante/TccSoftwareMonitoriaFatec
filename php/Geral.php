<?php
/**
* Todas as Classes que mexem com o banco de dados teem que
*
*/
class banco
{

  private $servername = "localhost";

  private $database = "tcc_banco_fatec";
  private $username = "tcc_banco_fatec";
  private $password = "tcc_banco_fatec";
  protected $Dados;
  private $registro=1;
  private $tamanho=0;


  public function ponteiro($indice){
    if ($indice<$this->tamanho){

      return true;
    }else {
      return false;
    }
  }

  public function getTamanho(){
    return $this->tamanho;
  }

  public function getRegistro(){
    return $this->registro;
  }

  public function proximoDados(){
    if ($this->registro<$this->tamanho){
      $this->registro=$this->registro+1;
      return true;
    }else {
      return false;
    }
  }
  public function anteriorDados(){
    if ($this->registro>1){
      $this->registro=$this->registro-1;
      return true;
    }else {
      return false;
    }
  }
  public function primeiroDados(){
    $this->registro=1;
  }

  protected function ExecultaSQL($sql) {
    $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }else {
      $BancoDeDados = array();
      $conn->query($sql);
      $sql = $conn->query("SELECT LAST_INSERT_ID()");
      if($sql){
        while($exibe = $sql->fetch_assoc()){
          $indice = 0;
          foreach($exibe as $key => $value){
            $indice = $indice + 1;
            $BancoDeDados[$indice] = $value;
          }
          return $BancoDeDados[1];
        }
      }
    }
    $conn->close();
  }

  protected function Pesquisa($query){
    $localizou=false;
    $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }else {
      $sql = $conn->query($query);
      $registro=0;
      if($sql){
        while($exibe = $sql->fetch_assoc()){
          $indice = 0;
          $registro=$registro+1;
          foreach($exibe as $key => $value){
            $indice = $indice + 1;
            $this->Dados[$registro][$indice]=$value;
          }
          $this ->tamanho=$registro;
          $localizou=true;
        }
      }
    }
    $conn->close();
    return $localizou;
  }
}


?>
