<?php

namespace tcc\monitoria;

class Rascunhos extends Banco
{

    /*
        Atriutos da tabela no banco de dados
    */
    private $codigoRascunho;
    private $tituloRascunho;
    private $conteudoRascunho;
    private $codigoDisciplina;

    // Atributos de configuração com a tabela

    private $camposSQL = '`codigoRascunho`,  `tituloRascunho`, `conteudoRascunho`,`dataCriacaoRascunho`,`codigoDisciplina`';
    private $tabela = "`rascunhos`";

    /*
        Classe de atribuição da recepção dos dados do banco
    */

    public function getCodigoRascunho()
    {
        return $this->codigoRascunho;
    }

    /*
        Getters
     */

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
        $this->codigoRascunho = $this->Dados[$this->getRegistro()][1];
        $this->tituloRascunho = $this->Dados[$this->getRegistro()][2];
        $this->conteudoRascunho = $this->Dados[$this->getRegistro()][3];
        $this->dataCriacaoRascunho = $this->Dados[$this->getRegistro()][4];
        $this->codigoDisciplina = $this->Dados[$this->getRegistro()][5];
    }

    public function anterior()
    {
        $this->anteriorDados();
        $this->atribuir();
    }

    public function novo($tituloRascunho, $conteudoRascunho, $codigoDisciplina, $CPFUsuario)
    {

        $classeUsuario = new usuario();
        $classeUsuario->porCPF($CPFUsuario);

        $dataCriacaoRascunho = date('Y-m-d');

        $sql =

            "INSERT INTO " . $this->tabela . "
                  (
                  `tituloRascunho`,
                  `conteudoRascunho`,
                  `dataCriacaoRascunho`,
                  `codigoDisciplina`
                  )
            ";

        $sql = $sql .
            " VALUES ('"
            . $tituloRascunho . "', '"
            . $conteudoRascunho . "', '"
            . $dataCriacaoRascunho . "', '"
            . $codigoDisciplina . "');";

        // Cria o rascunho
        $codigo = $this->ExecultaSQL($sql);

        $sql =
            "INSERT INTO 
                `atualizacoes` (
                    `codigoRascunho`,
                    `descricaoUpdate`,
                    `personaUpdate`,
                    `dataUpdate`
                ) VALUES (
                    '" . $codigo . "',
                    'Criado rascunho',
                    '" . $classeUsuario->getNomeUsuario() . " " . $classeUsuario->getSobrenomeUsuario() . "',
                    '" . $dataCriacaoRascunho . "'
                    );
        ";

        $this->ExecultaSQL($sql);

        return $codigo;

    }

    public function editar($codigoRascunho, $tituloRascunho, $conteudoRascunho, $codigoDisciplina, $CPFUsuario, $descricaoAlteracao)
    {


        $classeUsuario = new usuario();
        $classeUsuario->porCPF($CPFUsuario);

        $dataDeHoje = date('Y-m-d');

        $sql = "
            UPDATE `rascunhos` 
            SET                  
                `tituloRascunho` ='" . $tituloRascunho . "', 
                `conteudoRascunho`='" . $conteudoRascunho . "', 
                `codigoDisciplina`=" . $codigoDisciplina . "             
            WHERE  `codigoRascunho`=" . $codigoRascunho . ";";

        $this->ExecultaSQL($sql);

        $sql =
            "INSERT INTO 
           `atualizacoes` (
               `codigoRascunho`,
               `descricaoAtualizacoes`,
               `personaAtualizacoes`,
               `dataAtualizacoes`
           ) VALUES (
               '" . $codigoRascunho . "',
               '" . $descricaoAlteracao . "',
               '" . $classeUsuario->getNomeUsuario() . " " . $classeUsuario->getSobrenomeUsuario() . "',
               '" . $dataDeHoje . "'
               );
        ";
        $this->ExecultaSQL($sql);
        return $codigoRascunho;

    }


    /*
        Metodos de alteração
    */

    public function rascunhoPorCodigo($raAluno)
    {
        $query = "SELECT " . $this->camposSQL . "
              FROM " . $this->tabela . " WHERE
              `raAluno` = " . strtoupper($raAluno) . "";
        return $this->Get($query);
    }

    private function get($query)
    {
        $retorno = $this->Pesquisa($query);
        $this->primeiro();
        return $retorno;
    }

    /*
    Metodos de pesquisa
    */

    public function primeiro()
    {
        $this->primeiroDados();
        $this->atribuir();
    }
}

?>