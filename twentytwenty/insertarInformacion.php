<?php

$categoria = $_GET['categoria'];
//$message = "Entró en insertarInformacion.php, and the category is... ".$categoria;
//echo "<script type='text/javascript'>alert('$message');</script>";
    
   error_reporting(0); //abv

//establish connection
$con = mysqli_connect("localhost","root","","wordpress_pruebas1");
mysqli_set_charset( $con,"UTF8"); 
if(!$con) 
    die('Could not connect: '.mysqli_error($con));

if ($categoria == "colectivo"){
    //$message = "Entró en insertarInformacion.php, and the category is... ".$categoria;
    //echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<form id='insertar-info-colectivo' type='hidden' method=get action=".get_template_directory_uri()."></form>";
        echo "<table style='min-width:60%'>
        <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Localidad</th>
        <th>Dirección</th>
        <th>Código Postal</th>
        <th>Email</th>
        </tr>";
        echo "<tr>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        </tr>";
        echo "</table>";
    echo "</form>";
}
elseif ($categoria == "servicio"){
    //$message = "Entró en insertarInformacion.php, and the category is... ".$categoria;
    //echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<form id='insertar-info-servicio' type='hidden' method=get action=".get_template_directory_uri()."></form>";
        echo "<table style='min-width:60%'>
        <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Localidad</th>
        <th>Dirección</th>
        <th>Código Postal</th>
        <th>Email</th>
        </tr>";
        echo "<tr>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        </tr>";
        echo "</table>";
    echo "</form>";
}
elseif ($categoria == "centro"){
    //$message = "Entró en insertarInformacion.php, and the category is... ".$categoria;
    //echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<form id='insertar-info-centro' type='hidden' method=get action=".get_template_directory_uri()."></form>";
        echo "<table style='min-width:60%'>
        <tr><th colspan=6 style='background-color:#cd2653;color:#ffffff'><center>NUEVO CENTRO</center></th></tr>
        <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Localidad</th>
        <th>Dirección</th>
        <th>Código Postal</th>
        <th>Email</th>
        </tr>";
        echo "<tr>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        <td><input></input></td>
        </tr>";
        echo "</table>";
    echo "</form>";
}


/* $idColectivo = getId('tiposervicio','nombre',$colectivo,'idTipoServicio',$con);
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
 
} */

?>
