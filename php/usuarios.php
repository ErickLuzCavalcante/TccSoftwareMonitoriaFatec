<?php

namespace tcc\monitoria;


//Configurações e ajustes de sessão e cookies
@ini_set('session.gc_maxlifetime', 604800);
@session_set_cookie_params(604800);
@session_start();

/*--------------------------------------------*/

class Usuario extends banco
{
    private $CPFUsuario;
    private $nomeUsuario;
    private $sobrenomeUsuario;
    private $emailUsuario;
    private $telefoneUsuario;
    private $palavraChaveUsuario;

    // Variavel que deve ser usada na composição de todas as requisições SQL
    // Para que possamos manter a organização e a ordem no retorno dos campos
    // e assim não quebrar o código no metodo atribuir()
    private $camposSQL = ' DISTINCT usuarios.CPFUsuario,  `nomeUsuario`, `sobrenomeUsuario`,`telefoneUsuario`,`emailUsuario`, `palavraChaveUsuario`';

    /**
     * Gets
     */
    public function getCPFUsuario()
    {
        return $this->CPFUsuario;
    }

    public function getNomeUsuario()
    {
        return $this->nomeUsuario;
    }

    public function getSobrenomeUsuario()
    {
        return $this->sobrenomeUsuario;
    }

    public function getEmailUsuario()
    {
        return $this->emailUsuario;
    }

    public function getTelefoneUsuario()
    {
        return $this->telefoneUsuario;
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
        if (isset($this->Dados[$this->getRegistro()][1])) {
            $this->CPFUsuario = $this->Dados[$this->getRegistro()][1];
            $this->nomeUsuario = $this->Dados[$this->getRegistro()][2];
            $this->sobrenomeUsuario = $this->Dados[$this->getRegistro()][3];
            $this->telefoneUsuario = $this->Dados[$this->getRegistro()][4];
            $this->emailUsuario = $this->Dados[$this->getRegistro()][5];
            $this->palavraChaveUsuario = $this->Dados[$this->getRegistro()][6];
        } else {
            $this->CPFUsuario = "";
            $this->nomeUsuario = "";
            $this->sobrenomeUsuario = "";
            $this->telefoneUsuario = "";
            $this->emailUsuario = "";
            $this->palavraChaveUsuario = "";
        }
    }

    public function anterior()
    {
        $this->anteriorDados();
        $this->atribuir();
    }

    public function novoUsuario(
        $CPFUsuario,
        $nomeUsuario,
        $sobrenomeUsuario,
        $emailUsuario,
        $telefoneUsuario,
        $palavraChaveUsuario
    )
    {
        // Inicio da string de SQL
        // Campos do banco de dados

        $sql = "INSERT INTO `usuarios`
          (
          `CPFUsuario`,
          `nomeUsuario`,
          `sobrenomeUsuario`,
          `telefoneUsuario`,
          `emailUsuario`,
          `palavraChaveUsuario`
          )
          ";

        //  Valores onde serão inseriedos
        $sql =
            $sql .
            " VALUES ('" .
            $CPFUsuario .
            "', '" .
            $nomeUsuario .
            "', '" .
            $sobrenomeUsuario .
            "', '" .
            $telefoneUsuario .
            "', '" .
            $emailUsuario .
            "', '" .
            MD5($palavraChaveUsuario) .
            "');";

        return $this->ExecultaSQL($sql);
    }



    public function editarUsuario(
        $CPFUsuario,
        $nomeUsuario,
        $sobrenomeUsuario,
        $emailUsuario,
        $telefoneUsuario
    )
    {
        // Primeira parte da string de comando SQL
        // Atributos
        $sql =
            "UPDATE `usuarios` SET
  
      `nomeUsuario`='" .
            $nomeUsuario .
            "',
      `sobrenomeUsuario`='" .
            $sobrenomeUsuario .
            "',
      `telefoneUsuario`='" .
            $telefoneUsuario .
            "',
      `emailUsuario`='" .
            $emailUsuario .
            "'
      ";

        //  Valores onde serão inseridos
        $sql = $sql . " WHERE  `CPFUsuario`='" . $CPFUsuario . "';";
        return $this->ExecultaSQL($sql);
    }


    public function AlterarSenhaUsuario(
        $CPFUsuario,
        $palavraChaveUsuario,
    )
    {
        // Primeira parte da string de comando SQL
        // Atributos
        $sql =
            "UPDATE `usuarios` SET
  
      `palavraChaveUsuario`='" .
            MD5($palavraChaveUsuario) .
            "'
      ";

        //  Valores onde serão inseridos
        $sql = $sql . " WHERE  `CPFUsuario`='" . $CPFUsuario . "';";
        return $this->ExecultaSQL($sql);
    }

    /*Fim dos metodos padrao */

    /* Cria um novo usuário no banco de dados */

    public function excluirusuario($CPFUsuario)
    {
        $sql =
            "
        DELETE FROM `usuarios` WHERE
          `CPFUsuario`='" .
            $CPFUsuario .
            "';";
        return $this->ExecultaSQL($sql);
    }

    /* Edita um usuario */

    public function login($CPFUsuario, $palavraChaveUsuario)
    {
        $this->logoff();
        $CPFUsuario = strtoupper($CPFUsuario);

        $this->porCPF($CPFUsuario);

        if (
            strtoupper($this->CPFUsuario) == $CPFUsuario &&
            $this->palavraChaveUsuario == MD5($palavraChaveUsuario)
        ) {
            $_SESSION['login'] = strtoupper($CPFUsuario);
            $_SESSION['senha'] = MD5($palavraChaveUsuario);
            return true;
        } else {
            return false;
        }
    }

    /* Excluir um usuario*/

    public function logoff()
    {
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
    }

    public function porCPF($CPFUsuario)
    {
        $query =
            'SELECT' .
            $this->camposSQL .
            "
      
      FROM `usuarios` WHERE
      `CPFUsuario` = '" .
            strtoupper($CPFUsuario) .
            "'";
        return $this->Get($query);
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

    public function verificaLogado()
    {
        if (isset($_SESSION['login']) && isset($_SESSION['senha'])) {
            $usuario = $_SESSION['login'];
            $senha = $_SESSION['senha'];
            $this->logoff();
            $usuario = strtoupper($usuario);
            $this->porCPF($usuario);
            if (
                strtoupper($this->CPFUsuario) == $usuario &&
                $this->palavraChaveUsuario == $senha
            ) {
                $_SESSION['login'] = strtoupper($usuario);
                $_SESSION['senha'] = $senha;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function verificaAdministrador()
    {
        if (isset($_SESSION['login']) && isset($_SESSION['senha'])) {
            $usuario = $_SESSION['login'];
            $senha = $_SESSION['senha'];
            $this->logoff();
            $usuario = strtoupper($usuario);
            $this->porCPF($usuario);
            if (
                strtoupper($this->CPFUsuario) == $usuario &&
                $this->palavraChaveUsuario == $senha
            ) {
                $_SESSION['login'] = strtoupper($usuario);
                $_SESSION['senha'] = $senha;

                $aluno = new Alunos();
                $aluno->porCPF($usuario);
                if (strtoupper($aluno->getCPFUsuario()) == $usuario) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function Listar($pesquisa, $pagina, $quantidade)
    {

        $pagina = $pagina - 1;
        $pagina = $pagina * $quantidade;

        $query =
            'SELECT ' .
            $this->camposSQL .
            "FROM `usuarios` 
              WHERE 
                CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario) LIKE '%$pesquisa%' 
                OR usuarios.CPFUsuario = '$pesquisa'
                OR usuarios.telefoneUsuario = '$pesquisa'
                OR usuarios.emailUsuario LIKE '%$pesquisa%'
                ORDER BY CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario)
                LIMIT $pagina,$quantidade";

        return $this->Get($query);
    }

    public function ListarUsuarioAlunos($pesquisa, $pagina, $quantidade)
    {

        $pagina = $pagina - 1;
        $pagina = $pagina * $quantidade;

        $query =
            'SELECT ' .
            $this->camposSQL .
            "FROM `usuarios` 
               JOIN alunos ON alunos.CPFUsuario = usuarios.CPFUsuario
               AND alunos.monitorAluno=0
                AND (
                CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario) LIKE '%$pesquisa%' 
                OR usuarios.CPFUsuario = '$pesquisa'
                OR usuarios.telefoneUsuario = '$pesquisa'
                OR usuarios.emailUsuario LIKE '%$pesquisa%')
                ORDER BY CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario)
                LIMIT $pagina,$quantidade";


        return $this->Get($query);
    }

    public function ListarUsuarioMonitores($pesquisa, $pagina, $quantidade)
    {

        $pagina = $pagina - 1;
        $pagina = $pagina * $quantidade;

        $query =
            'SELECT ' .
            $this->camposSQL .
            "FROM `usuarios` 
               JOIN alunos ON alunos.CPFUsuario = usuarios.CPFUsuario
               AND alunos.monitorAluno=1
                AND (
                CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario) LIKE '%$pesquisa%' 
                OR usuarios.CPFUsuario = '$pesquisa'
                OR usuarios.telefoneUsuario = '$pesquisa'
                OR usuarios.emailUsuario LIKE '%$pesquisa%')
                ORDER BY CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario)
                LIMIT $pagina,$quantidade";
        return $this->Get($query);
    }

    public function ListarUsuarioAlunosEMonitores($pesquisa, $pagina, $quantidade)
    {

        $pagina = $pagina - 1;
        $pagina = $pagina * $quantidade;

        $query =
            'SELECT ' .
            $this->camposSQL .
            "FROM `usuarios` 
               JOIN alunos ON alunos.CPFUsuario = usuarios.CPFUsuario
                AND (
                CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario) LIKE '%$pesquisa%' 
                OR usuarios.CPFUsuario = '$pesquisa'
                OR usuarios.telefoneUsuario = '$pesquisa'
                OR usuarios.emailUsuario LIKE '%$pesquisa%')
                ORDER BY CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario)
                LIMIT $pagina,$quantidade";
        return $this->Get($query);
    }

    public function ListarUsuarioAdministradores($pesquisa, $pagina, $quantidade)
    {

        $pagina = $pagina - 1;
        $pagina = $pagina * $quantidade;


        $query = "
                    SELECT 
                    $this->camposSQL 
                    FROM `usuarios` 
                    JOIN alunos ON 
                        usuarios.CPFUsuario NOT IN (
                            SELECT 
                                usuarios.CPFUsuario
                               FROM usuarios
                             JOIN alunos 
                             ON alunos.CPFUsuario = usuarios.CPFUsuario
                             AND ( CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario) LIKE '%$pesquisa%' OR usuarios.CPFUsuario = '$pesquisa' OR usuarios.telefoneUsuario = '$pesquisa' OR usuarios.emailUsuario LIKE '%$pesquisa%') 
                        ) AND ( CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario) LIKE '%$pesquisa%' OR usuarios.CPFUsuario = '$pesquisa' OR usuarios.telefoneUsuario = '$pesquisa' OR usuarios.emailUsuario LIKE '%$pesquisa%')                 ORDER BY CONCAT (usuarios.nomeUsuario, ' ', usuarios.sobrenomeUsuario)
                LIMIT $pagina,$quantidade";
        return $this->Get($query);
    }
}

?>