<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  
<?php
require_once 'funciones.php';
?>
<h1>Trabajo Entrega</h1>
<?php
if(!isset($_GET['codAsignatura']) || !isset($_GET['codCiclo']) || !isset($_GET['codEnunciado']) || !isset($_SESSION['nombre'])  ){
  header('Location: paginabienvenida.php');
}
$codAsignatura=$_GET['codAsignatura'];
$codCiclo=$_GET['codCiclo'];
$codEnunciado=$_GET['codEnunciado'];
$enunciados= f_sacarTrabajoEstudiante($codAsignatura,$codCiclo,$codEnunciado);


foreach($enunciados as $enunciado){
    ?>
    <div class="center-text">
        
        <div class="casilla">
             <h1 class="titulo">
                    <h1>Trabajo Estudiante</h1>
            </h1>
          <form enctype="multipart/form-data" action="procesoGuardarTrabajo.php" method="POST">
            <input type="hidden" name="codEnunciado" value="<?=$codEnunciado ?>">
            <input type="hidden" name="codAsignatura" value="<?=$codAsignatura ?>">
            <input type="hidden" name="codCiclo" value="<?=$codCiclo ?>">
            <input type="file" name="trabajo" id="trabajo">
            <input type="submit" value="Entregar">

          </form>
          <h2><?=$enunciado['descripcion'] ?></h2>
        </div>
    <?php
    }
    ?> 




</body>
</html>