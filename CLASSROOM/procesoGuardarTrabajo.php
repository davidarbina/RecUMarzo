<?php
session_start();
require_once('funciones.php');
if (!isset($_FILES['trabajo']['tmp_name'])) {
    header("Location:login.php");
}


$ruta_temp=$_FILES['trabajo']['tmp_name'];

//Aqui lo que hace esta variable es convertir ese archivo que ha pasasdo a .tmp convertirlo en su extension original
$extension=pathinfo($_FILES['trabajo']['name'], PATHINFO_EXTENSION);

$codEnunciado=$_POST['codEnunciado'];
$codAsignatura=$_POST['codAsignatura'];
$codCiclo=$_POST['codCiclo'];
$trabajo=$_SESSION['nombre']."-$codAsignatura-$codCiclo.$extension";



try{
   //Aqui lo que se hara es que en la tabla en EntregaTrabajo poner en el Doc el nombre y el codAsignatura para saber quien lo ha entregado
   $res=f_anadirTrabajo($codEnunciado, $_SESSION['codUsuario'], $codAsignatura,$codCiclo, $trabajo);
   $ruta_trabajo=__DIR__."//..//ENTREGAS//ASIGNATURAS//".$codAsignatura.'-'.$codCiclo."//".$codEnunciado.'-'.$codAsignatura.'-'.$codCiclo;
   $ruta_final=$ruta_trabajo."//$trabajo";
   if(!file_exists($ruta_final)){
       mkdir($ruta_trabajo,0777,true);
    }
    //Despues de que esto se ha echo cogiendo ese documento que se ha subido que hemos pasado a docx lo mandamos a la carpeta que querramos
    move_uploaded_file($ruta_temp,$ruta_final);
    
}catch(Exception $e){
    //En caso de que ocurra un error en este caso que se vuelva a subir saldra este mensaje
    if($e->getCode()===1062){
        echo "<script>alert('El trabajo ya ha sido entregado!')</script>";
    }else{
        echo $e->getMessage();
    }
}finally{//De una manera o otra despues de hacer todo volvera a asignaturas.php mediante un header
     header("Refresh:1;url=asignatura.php?codEnunciado=$codAsignatura&codAsignatura=$codAsignatura&codCiclo=$codCiclo"); 
}
/* if (is_uploaded_file($_FILES['trabajo']['tmp_name'])) {
    $trabajo = file_get_contents($_FILES['trabajo']['tmp_name']);
    */ 
//}
//echo $res;
?>