<?php

session_start();
require_once('funciones.php');
if (!isset($_FILES['TrabajoProfe']['tmp_name'])) {
    header("Location:login.php");
}
$ruta_temp=$_FILES['TrabajoProfe']['tmp_name'];

//Aqui lo que hace esta variable es convertir ese archivo que ha pasasdo a .tmp convertirlo en su extension original
$extension=pathinfo($_FILES['TrabajoProfe']['name'], PATHINFO_EXTENSION);

$codEnunciado=$_POST['CodigoEnunciado'];
$codAsignatura=$_POST['CodigoAsignatura'];
$codCiclo=$_POST['CodigoCiclo'];
$nombreEnunciado=$_POST['NombreEnunciado'];
$descripcion=$_POST['Descripcion'];
$FechaEntrega=$_POST['FechaEntrega'];
$enunciado=$codEnunciado.'-'.$codAsignatura.'-'.$codCiclo.'.'.$extension;
//var_dump($enunciado);
try{
    $asignatura=$codAsignatura.'-'.$codCiclo;
    $carpeta=$codEnunciado.'-'.$codAsignatura.'-'.$codCiclo;
    //Aqui lo que se hara es que en la tabla en EntregaTrabajo poner en el Doc el nombre y el codAsignatura para saber quien lo ha entregado
    $ruta =__DIR__."\\..\\ENUNCIADOS\\ASIGNATURAS\\$asignatura\\ENUNCIADO\\";;
    $RUTA_carpeta=$ruta.$carpeta;
    //$RUTA_carpeta=$ruta.$carpeta."\\$enunciado";
    $res=f_anadirEnunciado($codEnunciado,$codAsignatura, $codCiclo,$nombreEnunciado, $descripcion,$enunciado,$FechaEntrega, $extension);
    //debuguear($ruta);
    if (!in_array($carpeta,scandir($ruta))) {
    
    //debuguear($ruta);

        //Aqui crearemos solo direccion o carpetas no se puede agregar ficheros
        mkdir($RUTA_carpeta,0777,true);
       // debuguear("mkdir()");
    }
    //Despues de que esto se ha echo cogiendo ese documento que se ha subido que hemos pasado a docx lo mandamos a la carpeta que querramos con el fichero que hemos subido
    move_uploaded_file($ruta_temp,$RUTA_carpeta."\\".$enunciado);
    debuguear($enunciado);
}catch(Exception $e){
    debuguear($e);
    //En caso de que ocurra un error en este caso que se vuelva a subir saldra este mensaje
    if($e->getCode()===1062){
        echo "<script>alert('El trabajo ya ha sido entregado!')</script>";
    }else{
        echo $e->getMessage();
    }
}finally{//De una manera o otra despues de hacer todo volvera a asignaturas.php mediante un header
    //header("Refresh:1;url=asignaturaProfe.php?codAsignatura=$codAsignatura&codCiclo=$codCiclo");
}
/* if (is_uploaded_file($_FILES['trabajo']['tmp_name'])) {
    $trabajo = file_get_contents($_FILES['trabajo']['tmp_name']);
    */ 
//}
//echo $res;
?>