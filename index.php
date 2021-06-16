<?php
// Para o banco de dados é necessario mudar a linha max_allowed_packet, para:
// max_allowed_packet=16GB
// no arquivo My.ini



namespace tcc\monitoria;

include "php/interfaces.php";
include "php/grid.php";



$uiux = new Interfaces("Inicio", 1,true);
// Filtros da barra de pesquisa
$uiux->filtroDePesquisa("Disciplinas","index.php?",true);

$uiux->padraoMenu();


$grid=new grid("grid");



$disciplinas=new Disciplinas();

$disciplinas->porDescricao($uiux->pagina,6,$uiux->pesquisa);
if ($disciplinas->getTamanho()>0){
    for ($i=0; $disciplinas->ponteiro($i); $i++) {
        $grid->add("disciplina.php?codigo=".$disciplinas->getCodigoDisciplina(),$disciplinas->getImagemDisciplina());
        $disciplinas->proximo();
    }
    $grid->home="index.php?pesquisa=$uiux->pesquisa";
    $proximaPagina=$uiux->pagina+1;
    if ($uiux->pagina<=1){
        $grid->prev=false;
    }else{
        $anteriorPagina=$uiux->pagina-1;
        $grid->prev="index.php?pesquisa=$uiux->pesquisa&pagina=$anteriorPagina";
    }
    $grid->next="index.php?pesquisa=$uiux->pesquisa&pagina=$proximaPagina";
}else{
    echo "<h2> <i class='material-icons'>find_in_page</i>Não encontramos nada </h2>";
    $grid->home="index.php?pesquisa=$uiux->pesquisa";
    if ($uiux->pagina<=1){
        $grid->prev=false;
    }else{
        $anteriorPagina=$uiux->pagina-1;
        $grid->prev="index.php?pesquisa=$uiux->pesquisa&pagina=$anteriorPagina";
    }
    $grid->next=false;
}

//$grid->add("login.php","<img src='img/banco-dados.png'>");


unset($grid);
unset($uiux)
?>
