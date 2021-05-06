 <script>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
</script>
<style>
.perfil    {
    border-radius: 50%;
}
  </style>
 
 <!-- Custom styles for this template -->
   <link href="assets/css/dashboard.css" rel="stylesheet">
   <link href="/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-danger flex-md-nowrap p-0 ">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="home.php">Fatec Monitor</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-light w-50 shadow " type="text" placeholder="Search" aria-label="Search">
  
  <button class="perfi-principal btn btn-danger nav-item dropdown">
            <img class="perfil" src="img/logo.png" width="60px" height="35px" id="navbardrop" data-toggle="dropdown">
            <div class="dropdown-menu sm-menu">
              <a class="dropdown-item" href="#">Nome_Perfil</a>
              <a class="dropdown-item" href="trocasenha.html">Trocar Senha</a>
              <a class="dropdown-item" href="login.php">Sair</a>

            </div>
            <a >
  </button>
</header>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
$('.perfil-principal .navbar-light .dmenu').hover(function () {
        $(this).find('.sm-menu').first().stop(true, true).slideDown(150);
    }, function () {
        $(this).find('.sm-menu').first().stop(true, true).slideUp(105)
    });
});
</script>

