<?php


class rascunhos extends banco
{

    /*
        Atriutos da tabela no banco de dados
    */
    private $codigoRascunho;
    private $tituloRascunho;
    private $conteudoRascunho;
    private $codigoDisciplina;
    private $CPFUsuario;

    /* 
        Atributos de configuração com a tabela
    */
    private $camposSQL = '`codigoRascunho`,  `tituloRascunho`, `conteudoRascunho`,`dataCriacaoRascunho`,`codigoDisciplina`,`CPFUsuario';
    private $tabela = "`rascunhos`";

    /*
        Classe de atribuição da recepção dos dados do banco
    */

    private function atribuir()
    {
        $this->codigoRascunho = $this->Dados[$this->getRegistro()][1];
        $this->tituloRascunho = $this->Dados[$this->getRegistro()][2];
        $this->conteudoRascunho = $this->Dados[$this->getRegistro()][3];
        $this->dataCriacaoRascunho = $this->Dados[$this->getRegistro()][4];
        $this->codigoDisciplina = $this->Dados[$this->getRegistro()][5];
        $this->CPFUsuario = $this->Dados[$this->getRegistro()][6];
    }

    /*
        Getters
     */

    public function getCodigoRascunho()
    {
        return $this->codigoRascunho;
    }

    public function getTituloRascunho()
    {
        return $this->tituloRascunho;
    }

    public function getConteudoRascunho()
    {
        return $this->conteudoRascunho;
    }

    public function getCodigoDisciplina()
    {
        return $this->codigoDisciplina;
    }

    public function getCPFUsuario()
    {
        return $this->CPFUsuario;
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

    private function Get($query)
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

    public function novo($tituloRascunho, $conteudoRascunho, $codigoDisciplina, $CPFUsuario)
    {

        $dataCriacaoRascunho = "";

        $sql =

            "INSERT INTO " . $this->tabela . "
                  (
                  `tituloRascunho`,
                  `conteudoRascunho`,
                  `codigoDisciplina`,
                  `CPFUsuario`
                  )
                  ";

        $sql = $sql .
            " VALUES ('"
            . $tituloRascunho . "', '"
            . $conteudoRascunho . "', '"
            . $codigoDisciplina . "', '"
            . $CPFUsuario . "');";

        echo $sql;

        $this->ExecultaSQL($sql);
    }
}