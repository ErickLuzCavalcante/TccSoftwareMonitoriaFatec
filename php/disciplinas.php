<?php
class disciplinas extends banco
{
    private $codigoDisciplina;
    private $nomeDisciplina;
    private $imagemDisciplina;
    private $sobreDisciplina;
    private $professorDisciplina;

    // Variavel que deve ser usada na composição de todas as requisições SQL
    // Para que possamos manter a organização e a ordem no retorno dos campos
    // e assim não quebrar o código no metodo atribuir()
    private $camposSQL = '`codigoDisciplina`,  `nomeDisciplina`, `imagemDisciplina`,`sobreDisciplina`,`professorDisciplina`';
    private $tabela = "`disciplinas`";

    /**
     * Gets 
     */
    public function getProfessorDisciplina()
    {
        return $this->professorDisciplina;
    }

    public function getSobreDisciplina()
    {
        return $this->sobreDisciplina;
    }

    public function getImagemDisciplina()
    {
        return $this->imagemDisciplina;
    }


    public function getNomeDisciplina()
    {
        return $this->nomeDisciplina;
    }

    public function getCodigoDisciplina()
    {
        return $this->codigoDisciplina;
    }

    /*Metodos padrões do banco de dados */

    /*Não altera */

    public function proximo()
    {
        $this->proximoDados();
        $this->atribuir();
    }

    private function atribuir()
    {
        $this->codigoDisciplina = $this->Dados[$this->getRegistro()][1];
        $this->nomeDisciplina = $this->Dados[$this->getRegistro()][2];
        $this->imagemDisciplina = $this->Dados[$this->getRegistro()][3];
        $this->sobreDisciplina = $this->Dados[$this->getRegistro()][4];
        $this->professorDisciplina = $this->Dados[$this->getRegistro()][5];
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

    public function novaDisciplina($nomeDisciplina, $imagemDisciplina, $sobreDisciplina, $professorDisciplina)
    {
        // Inicio da string de SQL
        // Campos do banco de dados
        $sql =

            "INSERT INTO " . $this->tabela . "
                  (
                  `nomeDisciplina`,
                  `imagemDisciplina`,
                  `sobreDisciplina`,
                  `professorDisciplina`
                  )
                  ";
        $sql = $sql .
            " VALUES ('"
            . $nomeDisciplina . "', '"
            . $imagemDisciplina . "', '"
            . $sobreDisciplina . "', '"
            . $professorDisciplina . "');";

        $this->ExecultaSQL($sql);
    }


    public function editarDisciplina($codigoDisciplina, $nomeDisciplina, $imagemDisciplina, $sobreDisciplina, $professorDisciplina)
    {
        // Primeira parte da string de comando SQL
        // Atributos
        $sql =

            "UPDATE " . $this->tabela . " SET
              `nomeDisciplina`='" . $nomeDisciplina . "',
              `imagemDisciplina`='" . $imagemDisciplina . "',
              `sobreDisciplina`='" . $sobreDisciplina . "',
              `professorDisciplina`='" . $professorDisciplina . "'
              ";

        //  Valores onde serão inseridos
        $sql = $sql .
            " WHERE  `codigoDisciplina`='" . $codigoDisciplina . "';";
        $this->ExecultaSQL($sql);
    }


    public function excluirDisciplina($codigoDisciplina)
    {
        $sql = "
                DELETE FROM " . $this->tabela . " WHERE
                  `codigoDisciplina`='" . $codigoDisciplina . "';";
        $this->ExecultaSQL($sql);
    }

    public function porCodigo($codigoDisciplina)
    {
        $query = "SELECT " . $this->camposSQL . "
              FROM " . $this->tabela . " WHERE
              `codigoDisciplina` = '" . $codigoDisciplina . "'";

        return $this->Get($query);
    }
}