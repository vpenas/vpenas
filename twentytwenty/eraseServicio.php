<?php

$servicio = $_GET['servicio'];

   error_reporting(0); //abv
//establish connection
$con = mysqli_connect("localhost","root","","wordpress_pruebas1");
mysqli_set_charset( $con,"UTF8");
if(!$con) 
    die('Could not connect: '.mysqli_error($con));

$idServicio = getId('servicio','nombre',$servicio,'idServicio',$con);
eraseCentroServicio($idServicio,$con);
eraseServicio($idServicio,$con);
echo "Servicio ".$servicio." borrado.";



// get id from any variable
function eraseServicio($idServicio,$con){
$sql = "DELETE FROM servicio WHERE  idServicio='". $idServicio."'";     
$result = mysqli_query($con,$sql); 
}


   // get id from any variable
   //
function eraseCentroServicio($idServicio,$con){
    $sql = "DELETE FROM centro_servicio WHERE  idServicio='". $idServicio."'";     
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
