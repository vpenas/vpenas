<?php

$colectivo = $_GET['colectivo'];

   error_reporting(0); //abv

//establish connection
$con = mysqli_connect("localhost","root","","wordpress_pruebas1");
mysqli_set_charset( $con,"UTF8"); 
if(!$con) 
    die('Could not connect: '.mysqli_error($con));

$idColectivo = getId('tiposervicio','nombre',$colectivo,'idTipoServicio',$con);
eraseCentroServicio($idColectivo,$con);
eraseColectivo($idColectivo,$con);
echo "Colectivo ".$colectivo." borrado.";



// get id from any variable
function eraseColectivo($idColectivo,$con){
    $sql = "DELETE FROM tiposervicio WHERE  idTipoServicio='".$idColectivo."'";     
    $result = mysqli_query($con,$sql); 
}


   // get id from any variable
function eraseCentroServicio($idColectivo,$con){
    $sql = "DELETE FROM centro_servicio WHERE  idTipoServicio='".$idColectivo."'";     
    $result = mysqli_query($con,$sql); 
}

// get id from any variable
function getId($tabla,$columna,$variable,$id,$con){
    $sql = "SELECT * FROM ".$tabla." WHERE ".$columna." LIKE '".$variable."'";     
    $result = mysqli_query($con,$sql); 
    $row = mysqli_fetch_assoc($result);
    return  (int)$row[$id]; 
 
}

?>
