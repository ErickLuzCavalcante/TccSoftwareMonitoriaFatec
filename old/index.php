<?php

namespace tcc\monitoria;

include "php/interfaces.php";
if (isset ($_GET["pesquisa"])) $pesquisa = $_GET["pesquisa"]; else $pesquisa = "";


$uiux = new Interfaces("Materias", 1);
$uiux->cabecalho($pesquisa);


?>
