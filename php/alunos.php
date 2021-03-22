<?php


class alunos extends banco
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
    public function primeiro()
    {
        $this->primeiroDados();
        $this->atribuir();
    }

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

    /* Altera conforme a tabela*/
    /*Deve ser padronizado, colocando na ordem que aparece na variavel $camposSQL
      -- Este metodo coleta o resultados das consultas SQL
         a classe banco retorna, um array do tipo matriz com sendo o primeiro indice a linha da tabela e o segundo
         indice a coluna da tabela

         Por isso devemos usar o padrao $this->atributo=$this->Dados[$this->getRegistro()][1];

         Respeitando a ordem da variavel $campoSQL

         att, Erick Cavalcante
    */

    private function atribuir()
    {

        $this->CPFUsuario = $this->Dados[$this->getRegistro()][1];
        $this->raAluno = $this->Dados[$this->getRegistro()][2];
        $this->monitorAluno = $this->Dados[$this->getRegistro()][3];

    }

    /*Fim dos metodos padrao */


    /* Cria um novo aluno no banco de dados */
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
            . $raAluno . "', '"
            . $monitorAluno . "');";

        $this->ExecultaSQL($sql);

    }

    /* Edita um aluno */
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
            " WHERE  `CPFUsuario`='" . $CPFUsuario . "';";
        $this->ExecultaSQL($sql);
    }


    /* Excluir um aluno*/
    public function excluirAluno($CPFUsuario)
    {
        $sql = "
                DELETE FROM " . $this->tabela . " WHERE
                  `CPFUsuario`='" . $CPFUsuario . "';";
        $this->ExecultaSQL($sql);
    }


    public function porCPF($CPFUsuario)
    {


        $query = "SELECT " . $this->camposSQL . "
              
              FROM " . $this->tabela . " WHERE
              `CPFUsuario` = '" . strtoupper($CPFUsuario) . "'";
        return $this->Get($query);
    }


    public function porRa($raAluno)
    {
        $query = "SELECT " . $this->camposSQL . "
              FROM " . $this->tabela . " WHERE
              `raAluno` = '" . strtoupper($raAluno) . "'";
        return $this->Get($query);
    }

    public function porNome($nomeCompletoUsuario)
    {
        $nomeCompletoUsuario = str_replace(" ","%",$nomeCompletoUsuario);
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
               CONCAT (usuarios.nomeUsuario,' ',usuarios.sobrenomeUsuario) LIKE '%".$nomeCompletoUsuario."%'";
        return $this->Get($query);
    }


}

?>
