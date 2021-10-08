<?php

if(isset($_POST['colectivo'])){
    $colectivo = $_POST['colectivo'];
    $oldcolectivo = $_POST['oldcolectivo'];
    echo"nombre colectivo". $colectivo;
}
if(isset($_POST['servicio'])){
    $servicio  = $_POST['servicio'];
    $oldservicio = $_POST['oldservicio'];
    echo"nombre servicio".$servicio;
}


//establish connection
$con = mysqli_connect("localhost","root","root","ONG_db");
mysqli_set_charset( $con,"UTF8");
if(!$con) 
    die('Could not connect: '.mysqli_error($con));


if(isset($colectivo)){
    $idColectivo = getId('tiposervicio','nombre',$oldcolectivo,'idTipoServicio',$con);
    $idColectivoNew = getId('tiposervicio','nombre',$colectivo,'idTipoServicio',$con);
    if( $idColectivoNew == 0){
        $idColectivo = getId('tiposervicio','nombre',$oldcolectivo,'idTipoServicio',$con);
        editName( $idColectivo,$colectivo,'TipoServicio',$con);
        echo"nombre colectivo editado";

    }else{
        echo"nombre colectivo duplicado";
    }
    
   
}
if(isset($servicio)){
    $idServicio = getId('servicio','nombre',$oldservicio,'idServicio',$con);
    $idServicioNew = getId('servicio','nombre',$servicio,'idServicio',$con);
    if( $idServicioNew == 0){
        editName( $idServicio,$servicio,'Servicio',$con);
        echo"nombre servicio editado";
    }else{
        echo"nombre servicio duplicado";
    }
  
}

function getId($tabla,$columna,$variable,$id,$con){
    $sql = "SELECT * FROM ".$tabla." WHERE ".$columna." LIKE '".$variable."'";     
    $result = mysqli_query($con,$sql); 
    $row = mysqli_fetch_assoc($result);
    return  (int)$row[$id]; 
 
}

function editName( $id,$nombre,$tabla,$con){
    $sql="UPDATE ".$tabla." SET  Nombre ='".$nombre."' WHERE id".$tabla."='".$id."'";
    $result = mysqli_query($con,$sql);       
}




    
?>
