<?php


namespace tcc\monitoria;


class atualizacoes extends Banco
{
    private $codigoRascunho;
    private $codigoMaterial;
    private $descricaoAtualizacoes;
    private $personaAtualizacoes;
    private $dataAtualizacoes;
    private $iconeAtualizacoes;

    // Getters

    public function codigoRascunho()
    {
        return $this->codigoRascunho;
    }

    public function getCodigoMaterial()
    {
        return $this->codigoMaterial;
    }

    public function getDescricaoAtualizacoes()
    {
        return $this->descricaoAtualizacoes;
    }

    public function getPersonaAtualizacoes()
    {
        return $this->personaAtualizacoes;
    }

    public function getDataAtualizacoes()
    {
        return $this->dataAtualizacoes;
    }

    public function getIconeAtualizacoes()
    {
        return $this->iconeAtualizacoes;
    }

    public function listarAtualizacoesPublicadas($codigo)
    {
        $query = "
            SELECT 
                codigoRascunho,
                codigoMaterial,
                descricaoAtualizacoes,
                personaAtualizacoes,
                dataAtualizacoes,
                iconeAtualizacoes
            FROM 
                atualizacoes
            WHERE
                codigoRascunho = $codigo
                AND codigoRascunho=codigoMaterial
        ";
        return $this->get($query);
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

    private function atribuir()
    {
        if (isset($this->Dados[$this->getRegistro()][1])) {
            $this->codigoRascunho = $this->Dados[$this->getRegistro()][1];
            $this->codigoMaterial = $this->Dados[$this->getRegistro()][2];
            $this->descricaoAtualizacoes = $this->Dados[$this->getRegistro()][3];
            $this->personaAtualizacoes = $this->Dados[$this->getRegistro()][4];
            $this->dataAtualizacoes = $this->Dados[$this->getRegistro()][5];
            $this->iconeAtualizacoes = $this->Dados[$this->getRegistro()][6];
        } else {
            $this->codigoRascunho = "";
            $this->codigoMaterial = "";
            $this->descricaoAtualizacoes = "";
            $this->personaAtualizacoes = "";
            $this->dataAtualizacoes = "";
            $this->iconeAtualizacoes = "";
        }
    }

    public function listarTodasAsAtualizacoes($codigo)
    {
        $query = "
            SELECT 
                codigoRascunho,
                codigoMaterial,
                descricaoAtualizacoes,
                personaAtualizacoes,
                dataAtualizacoes,
                iconeAtualizacoes
            FROM 
                atualizacoes
            WHERE
                codigoRascunho = $codigo
        ";
        return $this->get($query);
    }

    public function inserirAtualizacao($codigo, $descricao, $icone)
    {
        $classeUsuario = new usuario();
        $classeUsuario->verificaLogado();
        $persona = $classeUsuario->getNomeUsuario() . " " . $classeUsuario->getSobrenomeUsuario();

        $dataDeHoje = date('Y-m-d');

        $sql =
            "INSERT INTO 
           `atualizacoes` (
               `codigoRascunho`,
               `descricaoAtualizacoes`,
               `personaAtualizacoes`,
               `dataAtualizacoes`,
               `iconeAtualizacoes`
           ) VALUES (
               '$codigo',
               '$descricao',
               '$persona',
               '$dataDeHoje',
               '$icone'
               );
        ";

        $this->ExecultaSQL($sql);

    }

    public function publicar($codigo){
        $this->inserirAtualizacao($codigo,"Material publicado","visibility");
        $sqlAtualizcao = "UPDATE `atualizacoes` SET `codigoMaterial` = '" . $codigo . "' WHERE  `codigoRascunho` = " . $codigo;
        $this->ExecultaSQL($sqlAtualizcao);
    }

    public function tirarDoAr($codigo){
        $this->inserirAtualizacao($codigo,"Visibilidade modificada ","visibility_off");
        $sql="UPDATE `atualizacoes` SET `codigoMaterial`=null WHERE  `codigoRascunho`=$codigo";
        $this->ExecultaSQL($sql);
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

}