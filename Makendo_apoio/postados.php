<?php
/*
*  Pagina inicial do site makendo.com.br
* 	By Érick Luz Cavalcante
*/
// Icluir layout da pagina
include ("lib/padrao.php");
include ("lib/postagens.php");
include ("lib/grid.php");
// Cria pagina

// ** Conteudo da pagina sem_acquir!!!
$usuario=new usuario();
/*Verifica se o usuario esta logado*/
$secao=$usuario->ValidaSessao();
if (!$secao) header('Location: entrar.php');
$padrao=new master($secao);

$grid=new grid("grid");

$postagem=new postagem();
$postagem->porUser($padrao->pagina,6,$usuario->getUserUsuario(),$padrao->pesquisa);
echo "<p><i class='material-icons'>help</i>Postados: Estes são os seus artigos visiveis a todos</p>";
if ($postagem->getTamanho()>0){
	for ($i=0; $postagem->ponteiro($i); $i++) {
		$grid->add("publicacao.php?codigo=".$postagem->getCodigo_artigo(),$postagem->getImagem_postagem());
		$postagem->proximo();
	}

	$grid->home="postados.php?pesquisa=$padrao->pesquisa";
	$proximaPagina=$padrao->pagina+1;
	if ($padrao->pagina<=1){
		$grid->prev=false;
	}else{
		$anteriorPagina=$padrao->pagina-1;
		$grid->prev="postados.php?pesquisa=$padrao->pesquisa&pagina=$anteriorPagina";
	}
	$grid->next="postados.php?pesquisa=$padrao->pesquisa&pagina=$proximaPagina";
}else{
	echo "<h2> <i class='material-icons'>find_in_page</i>Não encontramos nada </h2>";
	$grid->home="postados.php?pesquisa=$padrao->pesquisa";
	if ($padrao->pagina<=1){
		$grid->prev=false;
	}else{
		$anteriorPagina=$padrao->pagina-1;
		$grid->prev="postados.php?pesquisa=$padrao->pesquisa&pagina=$anteriorPagina";
	}
	$grid->next=false;
}


unset($grid);
// ** Fim do conteudo da pagina

unset($padrao);
?>
