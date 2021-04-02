<?php
@ini_set('session.gc_maxlifetime', 604800);
@session_set_cookie_params(604800);
@session_start();

include ("usuario.php");
/**
*  Classe referente ao cadastro do
*  dos artigos ao banco de Dados
*  Autor: Erick Luz Cavalcante
*  email: erick@makendo.com.br
*/
class artigo extends banco
{

  private $codigo_artigo;
  private $titulo_artigo;
  private $conteudo_artigo;
  private $imagem_artigo;
  private $dataCriacao_artigo;
  private $dataAlteracao_artigo;
  private $UserUsuario;

  /**
  * GETS and SETS
  **/

  public function getCodigo_artigo(){
    return $this->codigo_artigo;
  }

  public function getTitulo_artigo(){
    return $this->titulo_artigo;
  }

  public function getConteudo_artigo(){
    return $this->conteudo_artigo;
  }

  public function getImagem_artigo(){
    return $this->imagem_artigo;
  }

  public function getDataCriacao_artigo(){
    return $this->dataCriacao_artigo;
  }

  public function getDataAlteracao_artigo(){
    return $this->dataAlteracao_artigo;
  }

  public function getUserUsuario(){
    return $this->UserUsuario;
  }

  public function novoArtigo($titulo_artigo,$conteudo_artigo,$imagem_artigo){
    $usuario=new usuario();
    if ($usuario->ValidaSessao()){
      $sql =
      "INSERT INTO `artigo`
      (
        `titulo_artigo`,
        `conteudo_artigo`,
        `imagem_artigo`,
        `dataCriacao_artigo`,
        `dataAlteracao_artigo`,
        `UserUsuario`
      )";

      //  Valores onde serão inseriedos
      $sql =$sql .
      " VALUES ('"

      . $titulo_artigo ."', '"
      . $conteudo_artigo ."', '"
      . $imagem_artigo ."', '"
      . date('Y-m-d') ."', '"  /* data da criacao do artigo */
      . date('Y-m-d') ."', '" /* data de alteracao do artigo */
      . $usuario->getuserUsuario() ."');";
      return $this->ExecultaSQL($sql);

    }else{
      return false;
    }
  }


  public function editarArtigo($codigo_artigo,$titulo_artigo,$conteudo_artigo,$imagem_artigo){
    $usuario=new usuario();
    if ($usuario->ValidaSessao()){
      $sql =
      "UPDATE `artigo` SET
      `titulo_artigo`='".$titulo_artigo."',
      `conteudo_artigo`='".$conteudo_artigo."',
      `imagem_artigo`='".$imagem_artigo."',
      `dataAlteracao_artigo`='".date('Y-m-d')."'
      WHERE  `UserUsuario`='".$usuario->getuserUsuario()."'
      AND `codigo_artigo`=".$codigo_artigo.";"
      ;
      return $this->ExecultaSQL($sql);
    }else{
      return false;
    }

  }



  public function deletarArtigo($codigo_artigo){
    $usuario=new usuario();
    if ($usuario->ValidaSessao()){
      $sql =
      "DELETE FROM `artigo`
      WHERE  `UserUsuario`='".$usuario->getuserUsuario()."'
      AND `codigo_artigo`=".$codigo_artigo.";"
      ;
      return $this->ExecultaSQL($sql);
    }else{
      return false;
    }
  }

  public function Listar($pagina,$quantidade,$pesquisa){
    $pagina=$pagina-1;
    $pagina=$pagina*$quantidade;
    $query = "SELECT
    `codigo_artigo`,
    `titulo_artigo`,
    `conteudo_artigo`,
    `imagem_artigo`,
    `dataCriacao_artigo`,
    `dataAlteracao_artigo`,
    `UserUsuario`
    FROM `artigo`
    WHERE ( `titulo_artigo` LIKE '%$pesquisa%' OR `conteudo_artigo` LIKE '%$pesquisa%')
    ORDER BY `codigo_artigo` DESC
    LIMIT $pagina,$quantidade";

    return $this->Get($query);
  }

  public function porCodigo($codigo){
    $query = "SELECT
    `codigo_artigo`,
    `titulo_artigo`,
    `conteudo_artigo`,
    `imagem_artigo`,
    `dataCriacao_artigo`,
    `dataAlteracao_artigo`,
    `UserUsuario`

    FROM `artigo`
    WHERE `codigo_artigo` LIKE '$codigo'";

    return $this->Get($query);

  }

  public function ListarUser($pagina,$quantidade,$Usuario,$pesquisa){
    $pagina=$pagina-1;
    $pagina=$pagina*$quantidade;
    $query = "SELECT
    `codigo_artigo`,
    `titulo_artigo`,
    `conteudo_artigo`,
    `imagem_artigo`,
    `dataCriacao_artigo`,
    `dataAlteracao_artigo`,
    `UserUsuario`
    FROM `artigo`
    WHERE `UserUsuario` LIKE '$Usuario'  AND
    (artigo.titulo_artigo LIKE '%$pesquisa%' OR artigo.conteudo_artigo LIKE '%$pesquisa%')
    ORDER BY `codigo_artigo` DESC
    LIMIT $pagina,$quantidade";
    return $this->Get($query);
  }


  public function rascunhosPorUsuario($pagina,$quantidade,$Usuario,$pesquisa){
    $pagina=$pagina-1;
    $pagina=$pagina*$quantidade;
    $query="SELECT
      artigo.codigo_artigo,
      artigo.titulo_artigo,
      artigo.conteudo_artigo,
      artigo.imagem_artigo,
      artigo.dataCriacao_artigo,
      artigo.dataAlteracao_artigo,
      artigo.UserUsuario
      from artigo
      where artigo.codigo_artigo not in (
        select postagens.codigo_artigo from postagens
      ) AND artigo.UserUsuario LIKE '$Usuario' AND
      (artigo.titulo_artigo LIKE '%$pesquisa%' OR artigo.conteudo_artigo LIKE '%$pesquisa%')
      ORDER BY `codigo_artigo` DESC
      LIMIT $pagina,$quantidade";
      return $this->Get($query);
    }

    /*
    * Metoddos de orientacao da pesquisa
    */

    private function atribuir(){

      $this->codigo_artigo=$this->Dados[$this->getRegistro()][1];
      $this->titulo_artigo=$this->Dados[$this->getRegistro()][2];
      $this->conteudo_artigo=$this->Dados[$this->getRegistro()][3];
      $this->imagem_artigo=$this->Dados[$this->getRegistro()][4];
      $this->dataCriacao_artigo=$this->Dados[$this->getRegistro()][5];
      $this->dataAlteracao_artigo=$this->Dados[$this->getRegistro()][6];
      $this->UserUsuario=$this->Dados[$this->getRegistro()][7];
    }

    private function Get($query){
      $retorno=$this->Pesquisa($query);
      $this->primeiro();
      return $retorno;
    }

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
  }

  ?>
