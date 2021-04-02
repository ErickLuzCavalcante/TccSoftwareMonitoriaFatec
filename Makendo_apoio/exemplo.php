<?php
session_start();
echo "<h1>Teste de Dados</h1><p><br>";


include ("lib/postagens.php");

$usuario = new usuario();
$artigo =new artigo();
$postagem =new postagem();

//$usuario->IniciarSecao("ERICK","493286299erick");


$usuario->novoUsuario("SAMUEL","Samuel","Sales","Sales@makendo.com.br","ErickTop123");
/*
$usuario->Todos();

for ($i=0;$usuario->ponteiro($i);$i++){
  echo "<br>";
  echo "Usuario: ".$usuario->getuserUsuario();
  echo "<br><br>";
  $usuario->proximo();
}





//$usuario->CancelaSecao();



//-----------------


//$codigo_artigo=$artigo->novoArtigo("Mais","outro","calçã"); /*se tiver falha retorna false false*/
//$artigo->editarArtigo($codigo_artigo,"teste","testa","imaga"); //se  for verdadeiro retorna null




//$artigo->listar(1,6,"");
/*
for ($i=0;$artigo->ponteiro($i);$i++){
  echo "<br>";
  echo "Titulo: ".$artigo->getTitulo_artigo();
  echo "<br><br>";
  $artigo->proximo();
}

//$artigo->deletarArtigo($codigo_artigo);
echo "<br>>>Puxar artigo por cod:
<br>---------------------------------------<br>";
$artigo->porCodigo(6);
echo "Titulo artigo: ";
echo $artigo->getTitulo_artigo();
echo "<br>";

$postagem->online(4);
$postagem->online(5);
$postagem->online(6);
$postagem->online(13);
$postagem->online(14);

$postagem->listar("1","2","");


for ($i=0;$postagem->ponteiro($i);$i++){
  echo "<br><br>>>Posagens online:
  <br>---------------------------------------<br>";
  echo "Titulo: ";
  echo $postagem->getTitulo_postagem();
  echo "<br>Conteudo: ";
  echo $postagem->getConteudo_postagem();
  echo "<br>Imagem: ";
  echo $postagem->getImagem_postagem();
  echo "<br>Codigo: ";
  echo $postagem->getCodigo_artigo();
  $postagem->proximo();

}


echo "</p>";

*/
?>
