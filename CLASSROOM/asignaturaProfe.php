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
<h1>Trabajos</h1>
<?php
session_start();
if(!isset($_GET['codAsignatura']) || !isset($_GET['codCiclo']) || !isset($_SESSION['nombre'])){
  header('Location: paginabienvenida.php');
}
$codAsignatura=$_GET['codAsignatura'];
$codCiclo=$_GET['codCiclo'];
$enunciados= f_sacardatosTrabajos($codAsignatura,$codCiclo);



foreach($enunciados as $enunciado){
    ?>
    <div class="center-text">
        
        <div class="casilla">
             <h1 class="titulo">
                <a href="enunciadoProfe.php?codAsignatura=<?=$codAsignatura?>&codEnunciado=<?=$enunciado["codEnunciado"]?>&codCiclo=<?=$codCiclo?>">
                <?=$enunciado['nombreenunciado'] ?>
                </a>
            </h1>
          <h1>Descripcion:</h1>
          <p>
          <a href="../ENUNCIADOS\ASIGNATURAS\<?=$codAsignatura?>-<?=$codCiclo?>\ENUNCIADO\<?=$enunciado["codEnunciado"]?>-<?=$codAsignatura?>-<?=$codCiclo?>\<?=$enunciado["codEnunciado"]?>-<?=$codAsignatura?>-<?=$codCiclo?>.<?=$enunciado['extension']?>"><?=$enunciado['descripcion'] ?></a>
          
        </p>
          <h2></h2>
          <h2 class="contenido">Fecha Entrega:<?=$enunciado['fechaEntrega'] ?></h2>
          <h2 class="contenido"><?=$enunciado['nombreasignaturas'] ?>-<?=$enunciado['nombreciclo'] ?></h2>
        </div>
    <?php
    }
    ?> 
    <h1>Crear Enunciado</h1>
    <form action="procesoCrearEnunciado.php" enctype="multipart/form-data" method="post">
      <label for="">Codigo Enunciado:</label> <input type="text" name="CodigoEnunciado" id="CodigoEnunciado"><br>
      <label for="">Codigo Asignatura:</label> <input type="hidden" name="CodigoAsignatura" id="CodigoAsignatura" value="<?=$codAsignatura?>"><br>
      <label for="">Codigo Ciclo:</label> <input type="hidden" name="CodigoCiclo" id="CodigoCiclo" value="<?=$codCiclo?>"><br>
      <label for="">Nombre Enunciado:</label> <input type="text" name="NombreEnunciado" id="NombreEnunciado"><br>
      <label for=""> Descripcion:</label> <input type="text" name="Descripcion" id="Descripcion"><br>
      <label for=""> TrabajoProfe:</label> <input type="file" name="TrabajoProfe" id="TrabajoProfe"><br>
      <label for=""> FechaEntrega:</label> <input type="text" name="FechaEntrega" id="FechaEntrega"><br>
      <input type="submit" value="Crear">
    </form>



</body>
</html>