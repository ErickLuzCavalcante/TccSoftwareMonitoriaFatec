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
    private $dataCriacaoRascunho;

    // Atributos de configuração com a tabela

    private $camposSQLRascunho = '`codigoRascunho`,  `tituloRascunho`, `conteudoRascunho`,`dataCriacaoRascunho`,`codigoDisciplina`';
    private $tabelaRascunho = "`rascunhos`";

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

    public function getDataCriacaoRascunho()
    {
        return $this->dataCriacaoRascunho;
    }

    public function proximo()
    {
        $this->proximoDados();
        $this->atribuirRascunhos();
    }



    /*
        Classes padrao de conexao com o banco de dados
    */

    /*Metodos padrões do banco de dados */

    /*Não altera */

    private function atribuirRascunhos()
    {
        if (isset($this->Dados[$this->getRegistro()][1])) {
            $this->codigoRascunho = $this->Dados[$this->getRegistro()][1];
            $this->tituloRascunho = $this->Dados[$this->getRegistro()][2];
            $this->conteudoRascunho = $this->Dados[$this->getRegistro()][3];
            $this->dataCriacaoRascunho = $this->Dados[$this->getRegistro()][4];
            $this->codigoDisciplina = $this->Dados[$this->getRegistro()][5];
        } else {
            $this->codigoRascunho = "";
            $this->tituloRascunho = "";
            $this->conteudoRascunho = "";
            $this->dataCriacaoRascunho = "";
            $this->codigoDisciplina = "";
        }
    }

    public function anterior()
    {
        $this->anteriorDados();
        $this->atribuirRascunhos();
    }

    public function novo($tituloRascunho, $conteudoRascunho, $codigoDisciplina, $CPFUsuario)
    {

        $classeUsuario = new usuario();
        $classeUsuario->porCPF($CPFUsuario);

        $dataCriacaoRascunho = date('Y-m-d');

        $sql =

            "INSERT INTO " . $this->tabelaRascunho . "
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

    public function excluir($codigoRascunho)
    {
        $sql = "DELETE FROM `atualizacoes` WHERE  `codigoRascunho`=$codigoRascunho";
        $this->ExecultaSQL($sql);
        $sql = "DELETE FROM `softwaredemonitoria`.`rascunhos` WHERE  `codigoRascunho`=$codigoRascunho";
        $this->ExecultaSQL($sql);
        $sql = "DELETE FROM `softwaredemonitoria`.`materiais` WHERE  `codigoMaterial`=$codigoRascunho";
        $this->ExecultaSQL($sql);
    }


    private function getRascunhos($query)
    {
        $retorno = $this->Pesquisa($query);
        $this->primeiroRascunhos();
        return $retorno;
    }

    public function primeiroRascunhos()
    {
        $this->primeiroDados();
        $this->atribuirRascunhos();
    }

    public function rascunhoPorCodigo($porCodigo)
    {
        $query = "SELECT " . $this->camposSQLRascunho . "
              FROM " . $this->tabelaRascunho . " WHERE
              `codigoRascunho` = " . $porCodigo . "";
        return $this->getRascunhos($query);
    }

    public function rascunhoPorDiciplina($codigoDiciplina,$descricao,$pagina,$quantidade)
    {
        $query = "SELECT  $this->camposSQLRascunho 
              FROM  $this->tabelaRascunho 
              WHERE WHERE codigoDisciplina = $codigoDiciplina
              LIMIT $pagina,$quantidade";

        return $this->getRascunhos($query);
    }
}

?>