<?php

namespace tcc\monitoria;

include "php/interfaces.php";
include "php/grid.php";


$uiux = new Interfaces("Inicio", 1, true);
// Filtros da barra de pesquisa
$uiux->filtroDePesquisa("Gestao de tecnologia", "disciplina.php?codigo=8", true);
$uiux->filtroDePesquisa("Disciplinas", "index.php", false);


// Itens do menu
$uiux->addItemMenu("index.php", "Inicio", false);
// Se o usuario for administrador
$uiux->addItemMenu("editorMateria.php' target='_blank'", "item", true);
$uiux->addItemMenu('index.php', "Editar Usuários", true);

$uiux->addItemMenu("index.php", "Meu Perfil", false);
$uiux->addItemMenu("index.php", "Trocar Senha", false);
$uiux->addItemMenu("Login.php", "Logoff", false);
$uiux->fecharmenu();


// Cabecalho da disciplina
echo "<ul class='cd-main-list'><br>";

$usuario = new Usuario();
$aluno = new Alunos();
$monitor = false;
$administrador = $usuario->verificaAdministrador();
if ($administrador) {
    $monitor = true;
} else {
    $aluno->getCPFUsuario($usuario->getCPFUsuario());
    if ($aluno->getMonitorAluno() == 1) {
        $monitor = true;
    }
}
$aluno->getCPFUsuario($usuario->getCPFUsuario());
$disciplina = new Disciplinas();

if (isset($_GET["codigo"])) {
    $codigo = $_GET["codigo"];
    $disciplina->porCodigo($codigo);
    $codigo=$disciplina->getCodigoDisciplina();

} else {
    $codigo = "";
}
if ($codigo!="") {
    echo "<li class='cd-main-list-item cd-main-list-item_first'><i class='material-icons'>history_edu</i></li>";

} else {
    echo "<li class='cd-main-list-item cd-main-list-item_first'><i class='material-icons'>error</i></li>";
    echo "<li class='cd-main-list-item cd-main-list-item_second'><a href='index.php'>  <h1>Conteudo não encontrado!!!
    </h1></a>
    <hr/>
    <a href='index.php'><i class='material-icons'>restart_alt</i>Volte para o incio </a></li>";
    exit();
}
?>


<li class='cd-main-list-item cd-main-list-item_second'>
    <h1>
        <?php echo $disciplina->getNomeDisciplina() ?>
    </h1>
    <br>

    <?php
    if ($monitor) {
        echo "
            <hr/>
            <p>
                Controles de postagem:
                <a href='disciplina.php?codigo=$codigo'><i class='material-icons'>edit_note</i> Todos </a>/
            <a href='disciplina.php?codigo=$codigo&controlepostagem=postados'><i class='material-icons'>publish</i> Somente os postados</a>
            </p>
        ";
    }

    if ($administrador) {
        echo "
            <hr/>
                <a href='editorMateria.php?codigoDisciplina=$codigo'  target='_blank'><i class='material-icons'>apps</i> Editar disciplina
        ";
    }
    ?>


    <hr/>
    <i class='material-icons'>school</i> Professor(a): Pastel<br>
    <i class='material-icons'>info</i> Mais informações
</li>
<br>

<br>
<li class='cd-main-list-item cd-main-list-item_first'>
        <i class='material-icons'>text_snippet</i>
</li>
<li class='cd-main-list-item cd-main-list-item_second'><a href='#'>
        <h1>Titulo do material</h1>
        <hr/>
        <p>
            <i class='material-icons'>tips_and_updates</i>
            Atualizado: 22/22/2201<br>
            <i class='material-icons'>face</i>
            Por: Erick Cavalcante<br>
            <i class='material-icons'>create</i>
            Criado em: 22/22/2201
    </a></li>
<br>

<br>
<li class='cd-main-list-item cd-main-list-item_first'><a href='#'>
        <i class='material-icons'>text_snippet</i>
    </a>
</li>
<li class='cd-main-list-item cd-main-list-item_second'>
    <a href='#'>
        <h1>Titulo do material</h1>
    </a>
        <hr/>
        <p>
            <i class='material-icons'>tips_and_updates</i>
            Atualizado: 22/22/2201<br>
            <i class='material-icons'>face</i>
            <b>Por: Erick Cavalcante<br></b>
            <i class='material-icons'>create</i>
            Criado em: 22/22/2201
    </li>
<br>

</ul>
<br>

<?php

unset($uiux)
?>
