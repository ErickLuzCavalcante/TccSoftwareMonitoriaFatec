<?php


namespace tcc\monitoria;


class lista
{
    public $next;
    public $prev;
    public $home;

    function __construct()
    {
        $this->next = "#";
        $this->next = "#";
        $this->home = "#";
        echo "<ul class='cd-main-list'><br>";
    }

    function __destruct()
    {
        /*
        echo '</div></div><div class="content"><span class="loading"></span></div></section><script src="./grid/grid3d.js"></script><script src="./grid/classie-grid.js"></script><script src="./grid/helper-grid.js"></script><script>new grid3D( document.getElementById( "grid3d" ) );</script>';
        echo '<div class="cd-nav"><p>';
        if ($this->prev != false) {
            echo '<a href="' . $this->prev . '"><i class="material-icons">arrow_back_ios</i><i class="material-icons">more_horiz</i></a>';
        }
        echo '<a href="' . $this->home . '"><i class="material-icons">healing</i></a>';
        if ($this->next != false) {
            echo '<a href="' . $this->next . '"><i class="material-icons">more_horiz</i><i class="material-icons">arrow_forward_ios</i></a>';
        }
        echo "</p></div>";
        */
    }

    public function add($icone,$titulo,$conteudo)
    {
        echo "<li class='cd-main-list-item cd-main-list-item_first'><i class='material-icons'>$icone</i></li>";
        echo "<li class='cd-main-list-item cd-main-list-item_second'>
                <h1>$titulo</h1>
                <hr/><p>$conteudo</p></li><br><br>";
    }

}

