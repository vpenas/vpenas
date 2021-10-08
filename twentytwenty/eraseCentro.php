<?php

$asociacion = $_GET['centro'];
$direccion = $_GET['direccion'];

   error_reporting(0); //abv
//establish connection
$con = mysqli_connect("localhost","root","","wordpress_pruebas1");
mysqli_set_charset( $con,"UTF8");
if(!$con) 
    die('Could not connect: '.mysqli_error($con));

$idCentro = getIdCentro($asociacion,$direccion, $con);
eraseCentroServicio($idCentro,$con);
eraseCentro($idCentro,$con);



// get id from any variable
function eraseCentro($idCentro,$con){
$sql = "DELETE FROM centro WHERE  idCentro='". $idCentro."'";     
$result = mysqli_query($con,$sql); 
}


   // get id from any variable
function eraseCentroServicio($idCentro,$con){
    $sql = "DELETE FROM centro_servicio WHERE  idCentro='". $idCentro."'";     
    $result = mysqli_query($con,$sql); 
}

function getIdCentro($variable,$direccion,$con){
    $sql = "SELECT * FROM centro WHERE nombre LIKE '%".$variable."%' AND direccion LIKE '%".$direccion."%' LIMIT 1 ";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    return  (int)$row["idCentro"];

}

    
?>
