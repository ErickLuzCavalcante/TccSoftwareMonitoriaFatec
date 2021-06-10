<?php

/**
 * Classe responsavel por criar os componentes do Quill Editor
 */

namespace tcc\monitoria;


class formulario
{
    public $visivelPublicar = false;
    public $visivelTirarDoAr = false;
    public $visivelExcluir = false;
    private $maisopcoes = false;

    function __construct($link, $Titulo)
    {
        echo "
        <script src='./formulario/js/jquery-2.1.1.js'></script>
        <link rel='stylesheet' href='./formulario/css/style.css'>
        <script src='./formulario/js/modernizr.js'></script>
        <form class='cd-form floating-labels' method='post' action='$link'>
        <h2> $Titulo</h2><br>
       ";
    }

    public function falha($textofalha)
    {
        echo "<br><br><br><div class='error-message'><p><i class='material-icons'>error_outline</i>$textofalha</p></div><br><br><br>";
    }

    public function inicioConjunto($icone, $titulo)
    {
        echo "<fieldset><legend><i class='material-icons'>$icone</i> $titulo</legend>";
    }

    public function fimConjunto()
    {
        echo "</fieldset>";
    }

    public function adcionarCampo($nome, $icone, $etiqueta, $valor, $tipo)
    {
        switch ($tipo) {
            case "requerido":
                $requerido = "required";
                $type = "text";
                break;
            case "email":
                $requerido = "";
                $type = "email";
                break;
            case "email-requerido":
                $requerido = "required";
                $type = "email";
                break;
            case "senha":
                $requerido = "";
                $type = "password";
                break;
            case "senha-requerido":
                $requerido = "required";
                $type = "password";
                break;
            case "desabilitado":
                $requerido = "disabled";
                $type = "text";
                break;
            default:
                $requerido = "";
                $type = "text";
                break;
        }

        echo "<h4>
                <i class='material-icons'>$icone</i>$etiqueta
              </h4>
                <input class='$nome' type='$type' value='$valor' name='$nome' id='$nome' $requerido>
               <br>";
    }

    public function inicioRadioButtom($icone, $etiqueta)
    {
        $etiqueta = ucfirst($etiqueta) . ":";
        echo "<br><label><i class='material-icons'>$icone</i> $etiqueta</label><br><ul class='cd-form-list'>";
    }

    public function adcionarRadioButton($nome, $icone, $etiqueta, $valor, $selecionado)
    {

        if ($selecionado) {
            $selecionado = "checked";
        } else {
            $selecionado = "";
        }

        echo "     <li>
                        <input type='radio' name='$nome' id='cd-radio-$valor' value='$valor' $selecionado>
                        <label for='cd-radio-$valor'>
                        <i class='material-icons'>$icone</i> $etiqueta</label>
                   </li>
                ";
    }

    public function fimRadioButtom()
    {
        echo "</ul>";
    }


    public function inicioCheck($icone, $etiqueta)
    {
        $etiqueta = ucfirst($etiqueta) . ":";
        echo "<br><label><i class='material-icons'>$icone</i> $etiqueta</label><br><ul class='cd-form-list'>";
    }

    public function adcionarCheck($nome, $icone, $etiqueta, $valor, $selecionado)
    {

        if ($selecionado) {
            $selecionado = "checked";
        } else {
            $selecionado = "";
        }

        echo "
					<li>
						<input type='checkbox' name='$nome' value='$valor' id='cd-checkbox-$nome' $selecionado>
						<label for='cd-checkbox-$nome'>$etiqueta</label>
					</li>
                ";
    }

    public function fimCheck()
    {
        echo "</ul>";
    }

    public function inicioSelect($icone, $etiqueta, $nome)
    {
        echo "<h4><i class='material-icons'>$icone</i> $etiqueta</h4>
				<p class='cd-select icon'>
					<select class='$nome'>";
    }

    public function addSelect($valor, $etiqueta)
    {
        echo "<option value='$valor'>$etiqueta</option>";
    }

    public function fimSelect()
    {
        echo "					</select>
				</p><br>";
    }


    function __destruct()
    {
        echo "<div><input type='submit' value='Enviar'></div></form>";
    }
}

?>
