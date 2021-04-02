<?php
/**
* Esta classe cria grids
*/
class grid
{
  public $next;
  public $prev;
  public $home;

  function __construct()
  {
    $this->next="#";
    $this->next="#";
    $this->home="#";
    echo '<link rel="stylesheet" href="./grid/grid.css"><section class="grid3d vertical" id="grid3d"><div class="grid-wrap"><div class="grid">';
  }

  function __destruct()
  {
    echo '</div></div><div class="content"><span class="loading"></span></div></section><script src="./grid/grid3d.js"></script><script src="./grid/classie-grid.js"></script><script src="./grid/helper-grid.js"></script><script>new grid3D( document.getElementById( "grid3d" ) );</script>';
    echo '<div class="cd-nav"><p>';
    if ($this->prev!=false){
      echo '<a href="'.$this->prev.'"><i class="material-icons">arrow_back_ios</i><i class="material-icons">more_horiz</i></a>';
    }
    echo '<a href="'.$this->home.'"><i class="material-icons">healing</i></a>';
    if ($this->next!=false){
      echo '<a href="'.$this->next.'"><i class="material-icons">more_horiz</i><i class="material-icons">arrow_forward_ios</i></a>';
    }
    echo "</p></div>";
  }

  public function add($link,$imagem){
    echo "<figure><a onclick='window.setTimeout(function() { location.href=\"$link\"}, 2000)'>$imagem</figure>";
  }

}
?>
