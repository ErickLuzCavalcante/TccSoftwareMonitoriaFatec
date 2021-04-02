<?php
@ini_set('session.gc_maxlifetime', 604800);
@session_set_cookie_params(604800);
@session_start();
include ("artigo.php");
/**
*  Classe referente ao cadastro do
*  dos postagens ao banco de Dados
*  Autor: Erick Luz Cavalcante
*  email: erick@makendo.com.br
*/
class postagem extends banco
{

  private $titulo_postagem;
  private $conteudo_postagem;
  private $imagem_postagem;
  private $dataCriacao_postagem;
  private $dataAlteracao_postagem;
  private $codigo_artigo;

  /**
  * GETS and SETS
  **/

  public function getTitulo_postagem(){
    return $this->titulo_postagem;
  }

  public function getConteudo_postagem(){
    return $this->conteudo_postagem;
  }

  public function getImagem_postagem(){
    return $this->imagem_postagem;
  }

  public function getDataCriacao_postagem(){
    return $this->dataCriacao_postagem;
  }

  public function getDataAlteracao_postagem(){
    return $this->dataAlteracao_postagem;
  }
  public function getCodigo_artigo(){
    return $this->codigo_artigo;
  }

  /*
  * Metoddos de orientacao da pesquisa
  */

  private function atribuir(){

    $this->titulo_postagem=$this->Dados[$this->getRegistro()][1];
    $this->conteudo_postagem=$this->Dados[$this->getRegistro()][2];
    $this->imagem_postagem=$this->Dados[$this->getRegistro()][3];
    $this->dataCriacao_postagem=$this->Dados[$this->getRegistro()][4];
    $this->dataAlteracao_postagem=$this->Dados[$this->getRegistro()][5];
    $this->codigo_artigo=$this->Dados[$this->getRegistro()][6];

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

  /*
  * Metodos de pesquisa de dados
  */

  public function listar($pagina,$quantidade,$pesquisa){
    $pagina=$pagina-1;
    $pagina=$pagina*$quantidade;
    $query = "SELECT
    `titulo_postagem`,
    `conteudo_postagem`,
    `imagem_postagem`,
    `dataAlteracao_postagem`,
    `dataCriacao_postagem`,
    `codigo_artigo`

    FROM `postagens`
    WHERE ( `titulo_postagem` LIKE '%$pesquisa%' OR `conteudo_postagem` LIKE '%$pesquisa%')
    ORDER BY `codigo_artigo` DESC
    LIMIT $pagina,$quantidade";
    return $this->Get($query);
  }

  public function PorUser($pagina,$quantidade,$Usuario,$pesquisa){
    $pagina=$pagina-1;
    $pagina=$pagina*$quantidade;
    $query="SELECT
    postagens.titulo_postagem,
    postagens.conteudo_postagem,
    postagens.imagem_postagem,
    postagens.dataAlteracao_postagem,
    postagens.dataCriacao_postagem,
    postagens.codigo_artigo
    FROM postagens
    JOIN artigo ON  artigo.codigo_artigo LIKE postagens.codigo_artigo
    WHERE artigo.UserUsuario LIKE '$Usuario' AND
    ( postagens.titulo_postagem LIKE '%$pesquisa%' OR postagens.conteudo_postagem LIKE '%$pesquisa%')
    ORDER BY `codigo_artigo` DESC
    LIMIT $pagina,$quantidade";
    return $this->Get($query);
  }

  public function porCodigoDono($codigo,$Usuario){

    $query="SELECT
    postagens.titulo_postagem,
    postagens.conteudo_postagem,
    postagens.imagem_postagem,
    postagens.dataAlteracao_postagem,
    postagens.dataCriacao_postagem,
    postagens.codigo_artigo
    FROM postagens
    JOIN artigo ON  artigo.codigo_artigo LIKE postagens.codigo_artigo
    WHERE artigo.UserUsuario LIKE '$Usuario' AND
    artigo.codigo_artigo LIKE '$codigo'
    ";
    return $this->Get($query);
  }

  public function porCodigo($codigo){

    $query = "SELECT
    `titulo_postagem`,
    `conteudo_postagem`,
    `imagem_postagem`,
    `dataAlteracao_postagem`,
    `dataCriacao_postagem`,
    `codigo_artigo`

    FROM `postagens`
    WHERE `codigo_artigo` LIKE '$codigo'";

    return $this->Get($query);
  }

  /*
  * Metodos de insersão de dados
  */

  public function offline($codigo){
    $usuario=new usuario();
    $artigo=new artigo();
    $retorno=false;
    if ($usuario->ValidaSessao()){
      $artigo->porCodigo($codigo);
      if ($artigo->getuserUsuario()==$usuario->getuserUsuario()) {
        $sql =
        "DELETE FROM `postagens`
        WHERE   `codigo_artigo`=".$codigo.";"
        ;
        $this->ExecultaSQL($sql);
        $retorno=true;
      }
    }
    return $retorno;
  }

  public function online($codigo){
    $retorno=false;
    $usuario=new usuario();
    $artigo=new artigo();
    if ($this->offline($codigo)){
      $artigo->porCodigo($codigo);
      $this->titulo_postagem=$artigo->getTitulo_artigo();
      $this->conteudo_postagem=$artigo->getConteudo_artigo();
      $this->imagem_postagem=$artigo->getImagem_artigo();
      $this->dataAlteracao_postagem=$artigo->getDataCriacao_artigo();
      $this->dataCriacao_postagem=date('Y-m-d');
      $this->codigo_artigo=$artigo->getCodigo_artigo();
      $sql =
      "INSERT INTO `postagens`
      (
        `titulo_postagem`,
        `conteudo_postagem`,
        `imagem_postagem`,
        `dataAlteracao_postagem`,
        `dataCriacao_postagem`,
        `codigo_artigo`
      )VALUES (
        '$this->titulo_postagem',
        '$this->conteudo_postagem',
        '$this->imagem_postagem',
        '$this->dataAlteracao_postagem',
        '$this->dataCriacao_postagem',
        '$this->codigo_artigo'
      )
      ";
      $this->ExecultaSQL($sql);
      $retorno=true;
    }
    return $retorno;
  }
}

?>
