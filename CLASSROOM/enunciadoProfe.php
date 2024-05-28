<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once('funciones.php');
if(!isset($_GET['codAsignatura']) || !isset($_GET['codCiclo']) || !isset($_GET['codEnunciado']) || !isset($_SESSION['nombre'])  ){
    header('Location: paginabienvenida.php');
  }
$codEnunciado=$_GET['codEnunciado'];
$codAsignatura=$_GET['codAsignatura'];
$codCiclo=$_GET['codCiclo'];


$trabajos_entregados= obtener_trabajos_entregados($codEnunciado,$codAsignatura,$codCiclo);

    if(count($trabajos_entregados)===0){
        echo "No hay trabajos entregados";
    }else{?>
        <table>
                <thead>
                    <th>NombreAlumno</th>
                    <th>CodigoAsignatura</th>
                </thead>
        <?php foreach ($trabajos_entregados as $key => $value) {
            ?>
            
                <tr>
                    <td><?=$value['nombre_alumno']?></td>
                    <td><?=$value['codAsignatura']?></td>

                </tr>

                
                <?php
        }?>
        </table>
        
    <?php }
    ?>
    

</body>
</html>