<?php

/**
 * Classe responsavel por criar os componentes do Quill Editor
 */

namespace tcc\monitoria;


class quill
{
    private $maisopcoes = false;
    public $visivelPublicar = false;
    public $visivelTirarDoAr = false;
    public $visivelExcluir = false;


    function __construct($link, $Titulo, $maisopcoes)
    {
        $this->maisopcoes = $maisopcoes;
        echo "
        <link href='https://cdn.quilljs.com/1.3.6/quill.snow.css' rel='stylesheet'>
        <script src='https://cdn.quilljs.com/1.3.6/quill.js'></script>
        <script src='./formulario/js/jquery-2.1.1.js'></script>
        <link rel='stylesheet' href='./formulario/css/style.css'>
        <script src='./formulario/js/modernizr.js'></script>
        <script src='./quill/toolbar.js'></script>
        <form class='cd-form floating-labels' method='post' action='$link' onSubmit='Localizar()'>
        <h2>Editor $Titulo</h2>
        <a onclick='puxaCookie()'><i class='material-icons'>settings_backup_restore</i> Usar o Check point - Tive um problema ao tentar salvar da última vez </a>
        ";

    }

    public function falha($textofalha)
    {
        echo "<br><br><br><div class='error-message'><p><i class='material-icons'>error_outline</i>$textofalha</p></div><br><br><br>";
    }

    public function sucesso($texto)
    {
        $texto=" ".$texto;
        echo "<br><br><br><div class='error-message sucess'><p><i class='material-icons'>thumb_up_off_alt</i>$texto</p></div><br><br><br>";
    }

    public function adcionarCampo($nome, $icone, $etiqueta, $valor)
    {
        echo "<h4>
                <i class='material-icons'>$icone</i>$etiqueta
              </h4>
                <input class='$nome' type='text' value='$valor' name='$nome' id='$nome' required>
               <br>";
    }

    public function Editor($conteudo)
    {

        echo "                
               
                <h4>Açoes no servidor</h4>
                <ul class='cd-form-list'>
                <li>
                    <input type='radio' name='radio-button' id='cd-radio-1' value='1' checked>
                    <label for='cd-radio-1'>
                        <i class='material-icons'>save</i> Salvar</label>
                    </li>";

            if ($this->visivelPublicar){
                echo "
                    <li>
                        <input type='radio' name='radio-button' id='cd-radio-2' value='2'>
                        <label for='cd-radio-3'>
                        <i class='material-icons'>cloud_done</i> Salvar&Publicar</label>
                   </li>
                ";
            }
            if ($this->visivelTirarDoAr){
                echo "
                    <li>
                       <input type='radio' name='radio-button' id='cd-radio-3' value='3'>
                       <label for='cd-radio-4'>
                        <i class='material-icons'>cloud_off</i> 
                            Tirar do ar
                        </label>
                    </li>
                ";
            }
            if ($this->visivelExcluir){
                echo "
                  <li>
                        <input type='radio' name='radio-button' id='cd-radio-4' value='4'>
                     <label for='cd-radio-5'>
                        <i class='material-icons'>delete_forever</i>
                            Excluir
                        </label>
                  </li>";
            }
        echo "</ul><input type='submit' value='Enviar'></p><br><br><br><br><br>";
        echo "                
                <h4><i class='material-icons'>article</i>
                Conteudo </h4><p class='btn-expandir'>
                <i class='material-icons'>
                photo_size_select_small</i></p><hr>            
                <div id='editor-container'>$conteudo</div>";

    }

    function __destruct()
    {
        echo "<div class='debug'><textarea class='Delta' name='delta' autocomplete='off' ></textarea><textarea id='DeltaIMG' class='Delta' name='deltaIMG' autocomplete='off'></textarea></div></form><script  src='.\quill\quill-conf.js'></script><link rel='stylesheet' href='./quill/quill.css'>";
    }
}

?>
