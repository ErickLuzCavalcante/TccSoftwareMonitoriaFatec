<?php

namespace tcc\monitoria;

class Publicacoes extends banco
{

    /*
        Atriutos da tabela no banco de dados
    */
    private $codigoMaterial;
    private $tituloMaterial;
    private $conteudoMaterial;
    private $dataCriacaoMaterial;

    // Atributos de configuração com a tabela

    private $camposSQL = '`codigoMaterial`,  `tituloMaterial`, `conteudoRascunho`,`dataCriacaoMaterial`';
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


    private function atribuir()
    {
        $this->codigoMaterial = $this->Dados[$this->getRegistro()][1];
        $this->tituloMaterial = $this->Dados[$this->getRegistro()][2];
        $this->conteudoMaterial = $this->Dados[$this->getRegistro()][3];
        $this->dataCriacaoMaterial = $this->Dados[$this->getRegistro()][4];
    }


    /*
        Classes padrao de conexao com o banco de dados
    */

    /*Metodos padrões do banco de dados */

    /*Não altera */

    public function proximo()
    {
        $this->proximoDados();
        $this->atribuir();
    }

    public function anterior()
    {
        $this->anteriorDados();
        $this->atribuir();
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