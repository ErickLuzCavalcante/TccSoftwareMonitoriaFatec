<?php
/*
*  Pagina inicial do site makendo.com.br
* 	By Érick Luz Cavalcante
*/
// Icluir layout da pagina
include ("lib/padrao.php");
include ("lib/artigo.php");
include ("lib/grid.php");
// Cria pagina

// ** Conteudo da pagina sem_acquir!!!
$usuario=new usuario();
/*Verifica se o usuario esta logado*/
$secao=$usuario->ValidaSessao();
if (!$secao) header('Location: entrar.php');
$padrao=new master($secao);

$grid=new grid("grid");

$artigo=new artigo();
$artigo->ListarUser($padrao->pagina,6,$usuario->getUserUsuario(),$padrao->pesquisa);
echo "<p><i class='material-icons'>help</i>Em edição: Nesta area terá acesso a tudo que você tem produzido</p>";
if ($artigo->getTamanho()>0){
	for ($i=0; $artigo->ponteiro($i); $i++) {
		$grid->add("editor.php?artigo=".$artigo->getCodigo_artigo(),$artigo->getImagem_artigo());
		$artigo->proximo();
	}

	$grid->home="emedicao.php?pesquisa=$padrao->pesquisa";
	$proximaPagina=$padrao->pagina+1;
	if ($padrao->pagina<=1){
		$grid->prev=false;
	}else{
		$anteriorPagina=$padrao->pagina-1;
		$grid->prev="emedicao.php?pesquisa=$padrao->pesquisa&pagina=$anteriorPagina";
	}
	$grid->next="emedicao.php?pesquisa=$padrao->pesquisa&pagina=$proximaPagina";
}else{
	echo "<h2> <i class='material-icons'>find_in_page</i>Não encontramos nada </h2>";
	$grid->home="emedicao.php?pesquisa=$padrao->pesquisa";
	if ($padrao->pagina<=1){
		$grid->prev=false;
	}else{
		$anteriorPagina=$padrao->pagina-1;
		$grid->prev="emedicao.php?pesquisa=$padrao->pesquisa&pagina=$anteriorPagina";
	}
	$grid->next=false;
}


unset($grid);
// ** Fim do conteudo da pagina

unset($padrao);
?>
