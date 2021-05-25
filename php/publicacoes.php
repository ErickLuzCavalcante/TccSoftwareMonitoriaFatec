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

    private $camposSQL = '`codigoMaterial`, 
                         `tituloMaterial`, 
                         `conteudoMaterial`,
                         `dataCriacaoMaterial`';

    private $tabela = "`materiais`";


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

    public function publicar($codigoRascunho, $tituloRascunho, $conteudoRascunho, $codigoDisciplina, $CPFUsuario)
    {

        $this->editar($codigoRascunho, $tituloRascunho, $conteudoRascunho, $codigoDisciplina, $CPFUsuario, "Material Disponibilizado");


        $dataCriacaoMaterial = date('Y-m-d');

        $sql =

            "INSERT INTO " . $this->tabela . "
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

        $sqlAtualizcao = "UPDATE `atualizacoes` SET `codigoMaterial` = '" . $codigoRascunho . "' WHERE  `codigoRascunho` = " . $codigoRascunho;

        $this->ExecultaSQL($sql);
        $this->ExecultaSQL($sqlAtualizcao);


    }

    private function get($query)
    {
        $retorno = $this->Pesquisa($query);
        $this->primeiro();
        return $retorno;
    }

    public function primeiro()
    {
        $this->primeiroDados();
        $this->atribuir();
    }

    /*
        Metodos de alteração
    */


}

?>