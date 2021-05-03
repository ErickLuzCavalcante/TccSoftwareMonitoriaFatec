<?php

namespace tcc\monitoria;

class Alunos extends banco
{
    private $CPFUsuario;
    private $raAluno;
    private $monitorAluno;

    // Variavel que deve ser usada na composição de todas as requisições SQL
    // Para que possamos manter a organização e a ordem no retorno dos campos
    // e assim não quebrar o código no metodo atribuir()
    private $camposSQL = "`CPFUsuario`,  `raAluno`, `monitorAluno` ";
    private $tabela = "`alunos`";


    /*Metodos padrões do banco de dados */


    /*Não altera */

    public function proximo()
    {
        $this->proximoDados();
        $this->atribuir();
    }

    private function atribuir()
    {
        $this->CPFUsuario = $this->Dados[$this->getRegistro()][1];
        $this->raAluno = $this->Dados[$this->getRegistro()][2];
        $this->monitorAluno = $this->Dados[$this->getRegistro()][3];
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
        Metodos de inserção de alteracao de dados
     */


    public function novoAluno($CPFUsuario, $raAluno, $monitorAluno)
    {

        // Inicio da string de SQL
        // Campos do banco de dados


        $sql =

            "INSERT INTO " . $this->tabela . "
                  (
                  `CPFUsuario`,
                  `raAluno`,
                  `monitorAluno`
                  )
                  ";

        //  Valores onde serão inseriedos
        $sql = $sql .
            " VALUES ('"
            . $CPFUsuario . "', '"
            . $raAluno . "', "
            . $monitorAluno . ");";

        return $this->ExecultaSQL($sql);
    }


    public function editarAluno($CPFUsuario, $raAluno, $monitorAluno)
    {


        // Primeira parte da string de comando SQL
        // Atributos
        $sql =

            "UPDATE " . $this->tabela . " SET
              `raAluno`='" . $raAluno . "',
              `monitorAluno`='" . $monitorAluno . "'
              ";

        //  Valores onde serão inseridos
        $sql = $sql .
            " WHERE  `CPFUsuario`=" . $CPFUsuario . ";";
        return $this->ExecultaSQL($sql);
    }

    public function excluirAluno($CPFUsuario)
    {
        $sql = "
                DELETE FROM " . $this->tabela . " WHERE
                  `CPFUsuario`=" . $CPFUsuario . ";";
                  echo $sql;
        return $this->ExecultaSQL($sql);
    }



    /*
    Metodos de pesquisa
     */



    public function porRa($raAluno)
    {
        $query = "SELECT " . $this->camposSQL . "
              FROM " . $this->tabela . " WHERE
              `raAluno` = " . strtoupper($raAluno) . "";
        return $this->Get($query);
    }


    public function porCPF($CPFUsuario)
    {
        $query = "SELECT " . $this->camposSQL . "
              
              FROM " . $this->tabela . " WHERE
              `CPFUsuario` = " . strtoupper($CPFUsuario) ;
        return $this->Get($query);
    }


    public function porNome($nomeCompletoUsuario)
    {
        $nomeCompletoUsuario = str_replace(" ", "%", $nomeCompletoUsuario);
        $query = "
            SELECT
                alunos.CPFUsuario,
                alunos.raAluno,
                alunos.monitorAluno
            FROM
                alunos
            JOIN
                usuarios ON usuarios.CPFUsuario LIKE alunos.CPFUsuario
            WHERE
               CONCAT (usuarios.nomeUsuario,' ',usuarios.sobrenomeUsuario) LIKE '%" . $nomeCompletoUsuario . "%'";
        return $this->Get($query);
    }

    /**
     * Get dos atributos
     */ 

    public function getCPFUsuario()
    {
        return $this->CPFUsuario;
    }
 
    public function getRaAluno()
    {
        return $this->raAluno;
    }
 
    public function getMonitorAluno()
    {
        return $this->monitorAluno;
    }
}
