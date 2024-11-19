
<?php require_once "dependencias.php" ?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>

  <!-- Begin Navbar -->
  <div id="nav">
    <div class="navbar navbar-inverse navbar-fixed-top" data-spy="affix" data-offset-top="100">
      <div  class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
           
          </button>
          <a class="navbar-brand" href="inicio.php"><img class="baner"   style="
background-color: white;  border-bottom-right-radius: 50px; border-bottom-left-radius: 50px; border-top-right-radius: 50px; border: none; border-top-left-radius: 50px; background-image:" src="../img/logo1.png" alt="" width="100px"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">

          <ul class="nav navbar-nav navbar-right">

            <li ><a  href="inicio.php"><span class="glyphicon glyphicon-home"></span> Inicio</a>
            </li>

            
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-folder-open"></span> Administrar personal<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="personal.php">Personal</a></li>
               <li><a href="expediente.php">Expediente</a></li>
            </ul>
          </li>

            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-time"></span> Administrar Horarios<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="horarios/Historias.php">Historias medicas</a></li>
              <li><a href="Odontologia">Odontologia</a></li>
              <li><a href="Laboratorio">Laboratorio</a></li>
              <li><a href="Rayos X">Rayos X</a></li>
              <li><a href="Administracion">Administracion</a></li> 
            </ul>
          </li>




<li><a href="formatos.php"><span class="glyphicon glyphicon-file"></span>Formatos</a>
          </li>







          <li><a href="nomina.php"><span class="glyphicon glyphicon-usd"></span>Nomina</a>
          </li>

             <?php
        if($_SESSION['usuario']=="admin"):
         ?>
           <li><a href="usuarios.php"><span class="glyphicon glyphicon-user"></span> Administrar Usuarios</a>
            </li>
         <?php 
       endif;
          ?>
          
          <li class="dropdown" >
            <a href="#" style="color: red"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Usuario: <?php echo $_SESSION['usuario']; ?>  <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li> <a style="color: red" href="../procesos/salir.php"><span class="glyphicon glyphicon-off"></span> Salir</a></li>
              
            </ul>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
    <!--/.contatiner -->
  </div>
</div>
<!-- Main jumbotron for a primary marketing message or call to action -->





<!-- /container -->        


</body>
</html>

<script type="text/javascript">
  $(window).scroll(function() {
    if ($(document).scrollTop() > 150) {
      $('.logo').height(200);

    }
    else {
      $('.logo').height(100);
    }
  }
  );
</script>