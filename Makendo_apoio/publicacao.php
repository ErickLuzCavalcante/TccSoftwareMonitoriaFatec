<?php
include ("lib/pagina.php");
include ("lib/postagens.php");
if (isset($_GET["codigo"])){

  $pagina =new pagina_layout();
  $postagem= new postagem();
  $artigo=new artigo();
  $usuario=new usuario();

  $postagem->porCodigo($_GET["codigo"]);
  $artigo->porCodigo($_GET["codigo"]);
  $usuario->porUser($artigo->getUserUsuario());
  $autor=$usuario->getnomeUsuario().' '.$usuario->getsobrenomeUsuario();



  $descricao='Criado em '.$postagem->getDataCriacao_postagem().' & Atualizado em '.$postagem->getDataAlteracao_postagem().'<br> por: '.$autor;

  // Verifica se o usuário é o Autor
  // se sim, mostra a opção do editor
  if (
    $usuario->ValidaSessao()&&
    $artigo->getUserUsuario()==$usuario->getUserUsuario()
  ){
    $descricao="$descricao <br><a href='editor.php?artigo=".$postagem->getCodigo_artigo()."' target='_blanck'> Editar </a>";
  }
  unset($usuario);
  unset($artigo);


  $pagina->conteudo($postagem->getTitulo_postagem(),$descricao,$postagem->getConteudo_postagem());

  unset($pagina);
}
?>
