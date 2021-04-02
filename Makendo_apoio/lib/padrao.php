<?php
include ("configuracoes-layout.php");
@ini_set('session.gc_maxlifetime', 604800);
@session_set_cookie_params(604800);
@session_start();
@session_start();
/**
*  Classe de layout principal do site makendo.com.br
*   by Érick Luz Cavalcante / 12/07/2019
*/
class master extends configuracoes
{

  public $pesquisa;
  public $pagina;


  function __construct($tipo)
  {
    $this->Pesquisa="";
    $this->cabecalho();
    $this->inicializaMenu();
    switch ($tipo) {
      case true:
      $this->addItemMenu("inicio","home","index.php");
      $this->addItemMenu("novo","add_box","editor.php");
      $this->addItemMenu("Postado","cloud_done","postados.php");
      $this->addItemMenu("em edição","subject","emedicao.php");
      $this->addItemMenu("sair","exit_to_app","entrar.php");
      break;

      default:
      $this->addItemMenu("inicio","home","index.php");
      $this->addItemMenu("facebook","thumb_up","https://www.facebook.com/MakendoOficial");
      $this->addItemMenu("instagram","image","https://www.instagram.com/makendooficial/");
      $this->addItemMenu("telegram","message","https://t.me/makendo");
      break;
    }

    $this->inicializaConteudo();
  }

  function __destruct()
  {
    $this->encerraPagina();
  }

  private function cabecalho(){
    if (isset($_GET['pesquisa'])){
      $pesquisa=$_GET['pesquisa'];
    }else{
      $pesquisa="";
    }
    if (isset($_GET['pagina'])){
      $pagina=$_GET['pagina'];
    }else{
      $pagina=1;
    }
    $this->pagina=$pagina;
    $this->pesquisa=$pesquisa;
    echo "<!DOCTYPE html><html lang='pt-br' class='no-js'><head><meta charset='UTF-8' /><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta name='viewport' content='width=device-width, initial-scale=1'><title>$this->Titulo</title><meta name='description' content='$this->Descricao' /><meta name='keywords' content='$this->PalavraChave' /><meta name='author' content='$this->Autor' /><link rel='shortcut icon' href='$this->icone'><link rel='stylesheet' type='text/css' href='./css/normalize.css' /><link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'><link rel='stylesheet' type='text/css' href='./css/demo.css' /><script src='./js/modernizr.custom.js'></script><link rel='stylesheet' href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css'><link rel='stylesheet' type='text/css' href='./pesquisa/css/style.css'><script src='./pesquisa/js/prefixfree.min.js'></script><link rel='stylesheet' type='text/css' href='./menu/css/style.css'></head><body><div class='logo2'><img  src='./img/Logo2.png'></div><div id='sb-search' class='sb-search'><form><input class='sb-search-input ' onkeyup='buttonUp();' placeholder='Pesquisa...' onblur='monkey();' type='search' value='$pesquisa' name='pesquisa' id='search'><input class='sb-search-submit' type='submit'  value='$this->Pesquisa'><span class='sb-icon-search'><i class='fa fa-search'></i></span></form></div><div class='container'>";
  }

  private function inicializaMenu(){
    echo "<div class='menu menu--closed'><div class='button'><span></span><span></span><span></span></div><div class='tools tools--hidden'>";
  }

  private function addItemMenu($texto,$icone,$link){
    echo '<a class="icon" href="'.$link.'"><i class="material-icons">'.$icone.'</i><br>'.$texto.'</a>';
  }

  private function inicializaConteudo(){
    echo  "</div></div>";
  }

  private function encerraPagina(){
    echo '</div><script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script><script src="./menu/js/index.js"></script><script  src="./pesquisa/js/index.js"></script></body></html>';
  }
}

?>
