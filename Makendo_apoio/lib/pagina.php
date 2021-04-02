<?php
include ("configuracoes-layout.php");
/**
* Craia o layout de paginas brancas
*/
class pagina_layout extends configuracoes
{
  function __construct()
  {
    echo "<!DOCTYPE html><html lang='pt-br' class='no-js'><head><meta charset='UTF-8' /><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta name='viewport' content='width=device-width, initial-scale=1'><title>$this->Titulo</title><meta name='description' content='$this->Descricao' /><meta name='keywords' content='$this->PalavraChave' /><meta name='author' content='$this->Autor' /><link rel='shortcut icon' href='$this->icone'><link rel='stylesheet' type='text/css' href='css/demo.css' /><link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'><link rel='stylesheet' type='text/css' type='text/css' href='./grid/grid.css' /></head><body><div class='container'><div class='content show'><div id='content' class=' show'>";
  }
  function __destruct(){
    echo "</div><span class='icon close-content' onClick='javascript:history.back(-1);'><i class='material-icons'>undo</i>Voltar<br>a pagina</span></div></div></body></html>";
  }
  public function conteudo($titulo,$descricao,$conteudo){
    echo "<p><br><br><h1 class='title'>$titulo</h1></p><br><p class='intro'><br>$descricao<br><br></p><br><p>$conteudo</p><br><br>";
  }
}
?>
