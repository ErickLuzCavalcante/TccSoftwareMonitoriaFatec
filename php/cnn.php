<?php

namespace tcc\monitoria;

/**
 * Classe controladora de banco de dados
 * Desenvolvido por: Erick Luz Cavalcante
 * Versão 1.2
 *
 *s
 */

class Banco
{

    // Dados de conexão
    protected $Dados;
    private $servername = "localhost";
    private $database = "SoftwareDeMonitoria";
    private $username = "root";
    private $password = "";
    // Atributos de controle não mexer

    private $registro = 1;
    private $tamanho = 0;


    public function ponteiro($indice)
    {
        if ($indice < $this->tamanho) {
            return true;
        } else {
            return false;
        }
    }

    public function getTamanho()
    {
        return $this->tamanho;
    }

    public function getRegistro()
    {
        return $this->registro;
    }

    // Captura o proximo dado
    public function proximoDados()
    {
        if ($this->registro < $this->tamanho) {
            $this->registro = $this->registro + 1;
            return true;
        } else {
            return false;
        }
    }

    // Captura o dado anterior
    public function anteriorDados()
    {
        if ($this->registro > 1) {
            $this->registro = $this->registro - 1;
            return true;
        } else {
            return false;
        }
    }

    //Volta o ponteiro para o inicio
    public function primeiroDados()
    {
        $this->registro = 1;
    }

    // Realiza comandos de insersão no banco de dados
    protected function execultaSQL($sql)
    {
        $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            $BancoDeDados = array();
            $conn->query($sql);
            $sql = $conn->query("SELECT LAST_INSERT_ID()");
            if ($sql) {
                while ($exibe = $sql->fetch_assoc()) {
                    $indice = 0;
                    foreach ($exibe as $key => $value) {
                        $indice = $indice + 1;
                        $BancoDeDados[$indice] = $value;
                    }
                    return $BancoDeDados[1];
                }
            }
        }
        $conn->close();
    }


    // Realiza comandos de pesquisa no banco de dados
    protected function pesquisa($query)
    {
        $localizou = false;
        $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            $sql = $conn->query($query);
            $registro = 0;
            if ($sql) {
                while ($exibe = $sql->fetch_assoc()) {
                    $indice = 0;
                    $registro = $registro + 1;
                    foreach ($exibe as $key => $value) {
                        $indice = $indice + 1;
                        $this->Dados[$registro][$indice] = $value;
                    }
                    $this->tamanho = $registro;
                    $localizou = true;
                }
            }
        }
        $conn->close();
        return $localizou;
    }
}
?>