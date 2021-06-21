<?php

namespace tcc\monitoria;
include "atualizacoes.php";

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

    private $camposSQLRascunho = 'rascunhos.codigoRascunho,  `tituloRascunho`, `conteudoRascunho`,`dataCriacaoRascunho`,`codigoDisciplina`';
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

    public function novo($tituloRascunho, $conteudoRascunho, $codigoDisciplina)
    {


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
        $dataDeHoje = date('Y-m-d');


        $atualizacao = new atualizacoes();
        $atualizacao->inserirAtualizacao($codigo, "Criado material", "fiber_new");

        return $codigo;

    }

    public function editar($codigoRascunho, $tituloRascunho, $conteudoRascunho, $descricaoAlteracao)
    {


        $sql = "
            UPDATE `rascunhos` 
            SET                  
                `tituloRascunho` ='" . $tituloRascunho . "', 
                `conteudoRascunho`='" . $conteudoRascunho . "'          
            WHERE  `codigoRascunho`=" . $codigoRascunho . ";";

        $this->ExecultaSQL($sql);

        $atualizacao = new atualizacoes();
        $atualizacao->inserirAtualizacao($codigoRascunho, "Documento modificado - " . $descricaoAlteracao, "auto_fix_high");
        $validacao = new Rascunhos();
        $validacao->rascunhoPorCodigo($codigoRascunho);
        if ($validacao->getConteudoRascunho()==$conteudoRascunho&&$validacao->getTituloRascunho()==$tituloRascunho){
            return $codigoRascunho;
        }else{
            return false;
        }



    }

    public function excluir($codigoRascunho)
    {
        $sql = "DELETE FROM `atualizacoes` WHERE  `codigoRascunho`=$codigoRascunho";
        $this->ExecultaSQL($sql);
        $sql = "DELETE FROM `softwaredemonitoria`.`rascunhos` WHERE  `codigoRascunho`=$codigoRascunho";
        $this->ExecultaSQL($sql);
        $sql = "DELETE FROM `softwaredemonitoria`.`materiais` WHERE  `codigoMaterial`=$codigoRascunho";
        $this->ExecultaSQL($sql);

        $validacao = new Rascunhos();
        $validacao->rascunhoPorCodigo($codigoRascunho);
        if ($validacao->getTituloRascunho()==""){
            return true;
        }else{
            return false;
        }
    }

    public function rascunhoPorCodigo($porCodigo)
    {
        $query = "SELECT " . $this->camposSQLRascunho . "
              FROM " . $this->tabelaRascunho . " WHERE
              `codigoRascunho` = " . $porCodigo . "";
        return $this->getRascunhos($query);
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

    public function rascunhoPostagensPorDiciplina($codigoDiciplina, $descricao, $pagina, $quantidade)
    {
        $pagina = $pagina - 1;
        $pagina = $pagina * $quantidade;

        $query = "SELECT  $this->camposSQLRascunho 
              FROM  $this->tabelaRascunho 
              WHERE codigoDisciplina = $codigoDiciplina    
              AND CONCAT (tituloRascunho, ' ', conteudoRascunho) LIKE '%$descricao%' 
              ORDER BY `codigoRascunho` DESC
              LIMIT $pagina,$quantidade";
        return $this->getRascunhos($query);
    }

    public function rascunhoPorDiciplina($codigoDiciplina, $descricao, $pagina, $quantidade)
    {
        $pagina = $pagina - 1;
        $pagina = $pagina * $quantidade;

        $query = "SELECT DISTINCT $this->camposSQLRascunho 
              FROM  $this->tabelaRascunho 
              JOIN atualizacoes on codigoMaterial IS NULL AND atualizacoes.codigoRascunho = rascunhos.codigoRascunho
              AND rascunhos.codigoDisciplina = $codigoDiciplina
              AND CONCAT(tituloRascunho, conteudoRascunho) LIKE '%$descricao%'
              ORDER BY `codigoRascunho` DESC
              LIMIT $pagina,$quantidade";
        return $this->getRascunhos($query);
    }

    public function offlinePorDiciplina($codigoDiciplina, $descricao, $pagina, $quantidade)
    {
        $pagina = $pagina - 1;
        $pagina = $pagina * $quantidade;

        $query = "SELECT DISTINCT $this->camposSQLRascunho 
              FROM  $this->tabelaRascunho 
              JOIN atualizacoes on codigoMaterial IS NULL AND atualizacoes.codigoRascunho = rascunhos.codigoRascunho
              AND rascunhos.codigoDisciplina = $codigoDiciplina
              AND CONCAT(tituloRascunho, conteudoRascunho) LIKE '%$descricao%'
              AND rascunhos.codigoRascunho NOT IN (
                SELECT rascunhos.codigoRascunho FROM
                `materiais` 
                JOIN rascunhos 
                ON rascunhos.codigoDisciplina = $codigoDiciplina 
                AND codigoMaterial = codigoRascunho 
              )
              ORDER BY `codigoRascunho` DESC
              LIMIT $pagina,$quantidade";
        return $this->getRascunhos($query);
    }
}

?>