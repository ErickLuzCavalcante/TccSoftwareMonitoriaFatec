<?php
include ("lib/pagina.php");
include ("lib/postagens.php");
include ("lib/quill.php");
$pagina =new pagina_layout();
$usuario=new usuario();
/*Confirmação do usuário*/
$secao=$usuario->ValidaSessao();
if (!$secao) {
  $falha="
  Você nao esta logado <br>
  e por isso nenhuma ação foi executada<br>
  Mas click no link abaixo para abrir a tela de login e enquanto isso eu vou puxando os dados do seu checkpoint
  <br><a href='entrar.php' onclick='puxaCookie()' target='_blank'>Link [Clique Aqui]</a>";
};
/* FIM Confirmação do usuário */

/*Inicialização das variaveis e Objetos */
$artigo=new artigo();
$postagem=new postagem();
$titulo="";
$conteudo="";
$dataAlteracao="";
$dataCriacao="";
$autor=$usuario->getUserUsuario();
$link="editor.php";
/*FIM - Inicialização das variaveis e Objetos */

/* Inicialização de Dados do banco  */
if (isset($_GET["artigo"])){
  $codigo=$_GET["artigo"];
  $artigo->porCodigo($codigo);
  $autor=$artigo->getUserUsuario();
  $link="editor.php?artigo=$codigo";
  if ($autor!=$usuario->getUserUsuario()){
    $falha=$falha."<br>Você nao possui permissão de alterar este artigo";
  }else{
    $titulo=$artigo->getTitulo_artigo();
    $conteudo=$artigo->getConteudo_artigo();

  }
}else if (isset($_GET["postagem"])){
  $codigo=$_GET["postagem"];
  $postagem->porCodigoDono($codigo,$autor);
  $link="editor.php?artigo=$codigo";
  if ($postagem->getTamanho()<=0){
    $falha=$falha."<br>Dados artigo não foram postados para a visualização de todos.<br> E por isso nao foi possivel carregar.<br> Acesse o link abaixo para continuar a edição: <br><br>
    <a href='editor.php?artigo=$codigo'> <i class='material-icons'>link</i>CLICK AQUI :D</a><BR><BR>";
  }else{
    $titulo=$postagem->getTitulo_postagem();
    $conteudo=$postagem->getConteudo_postagem();
  }
}
/* FIM - Inicialização de Dados do banco  */

/* Ações de gravação de Dados */
if (isset($_POST["cd-titulo"])&&!isset($falha)){
  if ($autor!=$usuario->getUserUsuario()){
    $falha=$falha."<br>Você nao possui permissão de alterar este artigo";
  }else{
    $titulo=$_POST["cd-titulo"];
    $conteudo=$_POST["delta"];
    $imagem=$_POST["deltaIMG"];
    $operacao=$_POST["radio-button"];
    if ($imagem==""){
      $falha="Tem que haver ao menos uma imagem no artigo antes de salvar";
    }else{
      switch ($operacao) {
        case '1'://grava artigo
        if (isset($codigo)){
          $artigo->editarArtigo($codigo,$titulo,$conteudo,$imagem);
          $link="editor.php?artigo=$codigo";
        }else{
          $codigo=$artigo->novoArtigo($titulo,$conteudo,$imagem);
          $link="editor.php?artigo=$codigo";
        }
        break;
        case '2'://grava postagem
        $artigo->editarArtigo($codigo,$titulo,$conteudo,$imagem);
        $postagem->online($codigo);
        break;
        case '3'://tira do ar
        $postagem->offline($codigo);
        break;
        case '4'://deleta
        $postagem->offline($codigo);
        $artigo->deletarArtigo($codigo);
        break;
      }
    }
  }
}
/* FIM - Ações de gravação de Dados */




$editor=new quill($link);
if (isset($falha)){
  $editor->falha($falha);
}
if (isset($codigo)){
  $editor->campos($titulo,$conteudo,$codigo);
}else{
  $editor->campos($titulo,$conteudo,false);
}



unset($editor);
unset($pagina);

?>
