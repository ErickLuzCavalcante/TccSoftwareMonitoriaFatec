<?php

namespace tcc\monitoria;

include "rascunhos.php";

class Publicacoes extends Rascunhos
{

    /*
        Atriutos da tabela no banco de dados
    */
    private $codigoMaterial;
    private $tituloMaterial;
    private $conteudoMaterial;
    private $dataCriacaoMaterial;

    // Atributos de configuração com a tabela

    private $camposSQLpublicado = '`codigoMaterial`, 
                         `tituloMaterial`, 
                         `conteudoMaterial`,
                         `dataCriacaoMaterial`';

    private $tabelaPublicado = "`materiais`";


    /*
        Getters

    */
    public function getCodigoMaterial()
    {
        return $this->codigoMaterial;
    }

    public function getTituloMaterial()
    {
        return $this->tituloMaterial;
    }

    public function getConteudoMaterial()
    {
        return $this->conteudoMaterial;
    }

    public function getDataCriacaoMaterial()
    {
        return $this->dataCriacaoMaterial;
    }

    public function proximo()
    {
        $this->proximoDados();
        $this->atribuir();
    }


    /*
        Classes padrao de conexao com o banco de dados
    */

    /*Metodos padrões do banco de dados */

    /*Não altera */

    private function atribuir()
    {
        if (isset($this->Dados[$this->getRegistro()][1])) {
            $this->codigoMaterial = $this->Dados[$this->getRegistro()][1];
            $this->tituloMaterial = $this->Dados[$this->getRegistro()][2];
            $this->conteudoMaterial = $this->Dados[$this->getRegistro()][3];
            $this->dataCriacaoMaterial = $this->Dados[$this->getRegistro()][4];
        } else {
            $this->codigoMaterial = "";
            $this->tituloMaterial = "";
            $this->conteudoMaterial = "";
            $this->dataCriacaoMaterial = "";
        }

    }


    public function anterior()
    {
        $this->anteriorDados();
        $this->atribuir();
    }

    public function publicar($codigoRascunho, $tituloRascunho, $conteudoRascunho,$descricaoAlteracao)
    {

        $this->editar($codigoRascunho, $tituloRascunho, $conteudoRascunho, $descricaoAlteracao);
        $this->tirarDoAr($codigoRascunho);

        $dataCriacaoMaterial = date('Y-m-d');

        $sql =

            "INSERT INTO " . $this->tabelaPublicado . "
                  (
                  `codigoMaterial`,
                  `tituloMaterial`,
                  `conteudoMaterial`,
                  `dataCriacaoMaterial`
                  )
            ";

        $sql = $sql .
            " VALUES ("
            . $codigoRascunho . ", '"
            . $tituloRascunho . "', '"
            . $conteudoRascunho . "', '"
            . $dataCriacaoMaterial . "');";


        $this->ExecultaSQL($sql);
        $atualizacao = new atualizacoes();
        $atualizacao->publicar($codigoRascunho);


    }

    public function tirarDoAr($codigo)
    {

        $atualizacao = new atualizacoes();
        $atualizacao->tirarDoAr($codigo);

        $sql = "DELETE FROM `materiais` WHERE  `codigoMaterial`=$codigo";
        $this->ExecultaSQL($sql);
    }

    private function getPublicado($query)
    {
        $retorno = $this->Pesquisa($query);
        $this->primeiroRascunhos();
        return $retorno;
    }

    public function primeiroRascunhos()
    {
        $this->primeiroDados();
        $this->atribuir();
    }


    public function publicadoPorCodigo($porCodigo)
    {
        $query = "SELECT " . $this->camposSQLpublicado . "
              FROM " . $this->tabelaPublicado . " WHERE
              `codigoMaterial` = " . $porCodigo . "";
        return $this->getPublicado($query);
    }


    public function publicadoPorDiciplina($codigoDiciplina, $descricao, $pagina, $quantidade)
    {
        $pagina = $pagina - 1;
        $pagina = $pagina * $quantidade;

        $query = "SELECT  $this->camposSQLpublicado 
              FROM  $this->tabelaPublicado 
              JOIN rascunhos	ON rascunhos.codigoDisciplina = $codigoDiciplina
              AND codigoMaterial = codigoRascunho 
              AND CONCAT (tituloMaterial, ' ', conteudoMaterial) LIKE '%$descricao%' 
              ORDER BY `codigoRascunho` DESC
              LIMIT $pagina,$quantidade";
        return $this->getPublicado($query);
    }


}

?>