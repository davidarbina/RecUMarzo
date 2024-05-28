<?php
//Con esta funcion conectaremos a la base de datos
function f_conectar(){
try {
    $enlace = mysqli_init();
    if (!$enlace) {
        die('Fallo mysqli_init');
    }

    if (!mysqli_real_connect($enlace,'localhost','root','','classroom')) {
        die('Error de conexion ('. mysqli_connect_errno() .')'
                . mysqli_connect_error());
    }
} catch (\Throwable $error) {
    echo $error->getMessage();
}
return $enlace;
}

function f_cerrarConexion($enlace){
    mysqli_close($enlace);
}

function f_login($usuario,$contrasena):array{
    $conexion = f_conectar();

    $cmdLogin="SELECT count(*) count,ifnull(rol,-1) rol,ifnull(codUsuario,-1) codUsuario FROM usuarios WHERE nombreusuario = '".$usuario ."' and contrasena = '".$contrasena ."' ";

    $resultado = mysqli_query($conexion,$cmdLogin);

    $datos = mysqli_fetch_assoc($resultado);

    
    $array['rol']=$datos['rol'];
    $array['codUsuario'] = $datos['codUsuario'];

    f_cerrarConexion($conexion);
    return $array;

}

function f_sacarAsignaturas($codUsuario){
    $lAsignaturas = [];

    $cmdsacarAsig= "SELECT CodAsignatura,a.CodCiclo codCiclo, a.nombreasignaturas, nombreciclo 
    FROM usuarios u 
        JOIN matriculas m 
        ON m.CodAlumno = u.CodUsuario 
        JOIN asignaturas a 
        ON a.CodAsignaturas = m.CodAsignatura AND a.CodCiclo = m.CodCiclo 
        JOIN ciclos c 
        ON c.CodCiclos=m.CodCiclo  
      WHERE CodUsuario='".$codUsuario."'";

    $conexion = f_conectar();

    $resultado = mysqli_query($conexion,$cmdsacarAsig);



    while ($Asignatura = mysqli_fetch_assoc($resultado)) {
        $lAsignaturas[] = $Asignatura;
    }
    
    f_cerrarConexion($conexion);
    return $lAsignaturas;
   
}

function f_sacardatosTrabajos($codAsignatura,$CodCiclos){
    
    $lTrabajos = [];

    $cmdsacarTrabajos= "SELECT e.codAsignatura,e.codCiclo,e.codEnunciado,e.fechaEntrega,e.nombreenunciado,a.nombreasignaturas,c.nombreciclo,descripcion,e.trabajoProfe, extension
    FROM enunciados e
    join asignaturas a
    on e.codAsignatura= a.CodAsignaturas 
    JOIN ciclos c 
    ON c.CodCiclos=e.CodCiclo 
    WHERE  e.CodAsignatura= ".$codAsignatura." AND e.CodCiclo=".$CodCiclos."";


    $conexion = f_conectar();

    $resultado = mysqli_query($conexion,$cmdsacarTrabajos);



    while ($Trabajo = mysqli_fetch_assoc($resultado)) {
        $lTrabajos[] = $Trabajo;
    }
    
    f_cerrarConexion($conexion);
    return $lTrabajos;
   
}

function f_sacarTrabajoEstudiante($codAsignatura,$CodCiclos,$codEnunciado){
    
    $lTrabajos = [];

    $cmdsacarTrabajos= "SELECT e.codAsignatura,e.codCiclo,e.codEnunciado,e.fechaEntrega,e.nombreenunciado,a.nombreasignaturas,c.nombreciclo,descripcion,e.trabajoProfe
    FROM enunciados e
    join asignaturas a
    on e.codAsignatura= a.CodAsignaturas 
    JOIN ciclos c 
    ON c.CodCiclos=e.CodCiclo 
    WHERE  e.CodAsignatura= ".$codAsignatura." AND e.CodCiclo=".$CodCiclos." AND e.codEnunciado=".$codEnunciado."";


    $conexion = f_conectar();

    $resultado = mysqli_query($conexion,$cmdsacarTrabajos);



    while ($Trabajo = mysqli_fetch_assoc($resultado)) {
        $lTrabajos[] = $Trabajo;
    }
    
    f_cerrarConexion($conexion);
    return $lTrabajos;
   
}

function f_obtenerAsigProfe($codUsuario){
    $lAsignaturasProfe = [];

    $cmdsacarAsigProfe= " SELECT CodAsignaturas, CodProfesor, CodCiclo codCiclo, nombreasignaturas FROM asignaturas WHERE CodProfesor = ".$codUsuario.
    "" ;
   

    $conexion = f_conectar();

    $resultado = mysqli_query($conexion,$cmdsacarAsigProfe);



    while ($AsignaturaProfe = mysqli_fetch_assoc($resultado)) {
        $lAsignaturasProfe[] = $AsignaturaProfe;
    }
    
    f_cerrarConexion($conexion);
    return $lAsignaturasProfe;
   
}  


function f_anadirTrabajo($codEnunciado, $codUsuario, $codAsignatura,$codCiclo, $trabajo){
        
        $conexion=f_conectar();
        
        $cmdAnadirProducto = "INSERT INTO trabajos (codEnunciado,codAlumno, CodAsignatura, codCiclo, EntregaTrabajo) VALUES (?,?,?,?,?);";
        $statement = mysqli_prepare($conexion, $cmdAnadirProducto);
        mysqli_stmt_bind_param($statement,'iiiis',$codEnunciado, $codUsuario, $codAsignatura,$codCiclo, $trabajo );
        $current_id = mysqli_stmt_execute($statement);
        if(!$current_id){
            "<b>Error:</b> Problema en la insercion de el fichero <br/>" . mysqli_connect_error();
        }
       
        if(mysqli_affected_rows($conexion)==1){
            f_cerrarConexion($conexion);
            return 1;
        }else{
            f_cerrarConexion($conexion);
            return -1;
        }
 }

function f_descargar(){
    $conexion=f_conectar();
    $query = "SELECT EntregaTrabajo FROM trabajos WHERE codEnunciado = 1 ";
				     $result = mysqli_query($conexion,$query) or die('Error, query failed');
				     list($content) = mysqli_fetch_array($result);
				 				   //echo $id . $file . $type . $size;
				 				   //echo 'sampath';
				     header("Content-length: 1037");
				     header("Content-type:   application/msword");
				     header("Content-Disposition: attachment; filename=CLASSROOM");
				     ob_clean();
				     flush();
		                     $content = stripslashes($content);
				     echo $content;
				     mysqli_close($conexion);
				     exit;
}

/* SELECT t.TrabajoProfe,t.FechaEntrega,t.EntregaTrabajo,e.nombreenunciado,a.nombreasignaturas
FROM trabajos as t
JOIN enunciados e
ON t.codEnunciado=e.codEnunciado AND t.CodAsignaturas=e.codAsignatura AND 
t.codCiclo=e.codCiclo 
join asignaturas a
on e.codAsignatura= a.CodAsignaturas 
WHERE codAlumno= "'.$codAlumno.'";
*/
 
function obtener_trabajos_entregados($codEnunciado,$codAsignatura,$codCiclo):Array{
    session_start();
    $archivos_guardados=scandir(__DIR__."//..//ENTREGAS//ASIGNATURAS//".$codAsignatura.'-'.$codCiclo."//".$codEnunciado.'-'.$codAsignatura.'-'.$codCiclo."//");
    $array_info_trabajo=array_map(function($archivo_str){
        $archivo=explode('-',$archivo_str);
        return[
            "nombre_alumno"=>$archivo[0],
            "codAsignatura"=>$archivo[1]
        ];
    },array_filter($archivos_guardados,fn($ar)=> $ar!=="." && $ar!==".."));
 return $array_info_trabajo;
}

function f_anadirEnunciado($codEnunciado,$codAsignatura, $codCiclo,$nombreEnunciado, $descripcion,$enunciado,$FechaEntrega, $extension){
    $conexion = f_conectar();
    if ($FechaEntrega=="") {
        $cmdCrearEnunciado="INSERT INTO enunciados(codEnunciado, codAsignatura, codCiclo, nombreenunciado, descripcion, trabajoProfe, extension) VALUES (?,?,?,?,?,?,?);";
    $statement = mysqli_prepare($conexion, $cmdCrearEnunciado);
    mysqli_stmt_bind_param($statement,'iiissss',$codEnunciado, $codAsignatura, $codCiclo,$nombreEnunciado, $descripcion,$enunciado, $extension );
    }else {
        $cmdCrearEnunciado="INSERT INTO enunciados(codEnunciado, codAsignatura, codCiclo, nombreenunciado, descripcion, trabajoProfe, fechaEntrega, extension) VALUES (?,?,?,?,?,?,?,?);";
        $statement = mysqli_prepare($conexion, $cmdCrearEnunciado);
        mysqli_stmt_bind_param($statement,'iiisssss',$codEnunciado, $codAsignatura, $codCiclo,$nombreEnunciado, $descripcion,$enunciado,$FechaEntrega, $extension );
        
    }
     $current_id = mysqli_stmt_execute($statement);
    if(!$current_id){
        "<b>Error:</b> Problema en la insercion de el fichero <br/>" . mysqli_connect_error();
    }
    
    if(mysqli_affected_rows($conexion)==1){
        f_cerrarConexion($conexion);
        return 1;
    }else{
        f_cerrarConexion($conexion);
        return -1;
    }
}
function debuguear($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
?>
