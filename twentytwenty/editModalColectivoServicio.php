<?php

if(isset($_GET['colectivo'])){
    $colectivo = $_GET['colectivo'];
}
if(isset($_GET['servicio'])){
    $servicio = $_GET['servicio'];
}


//establish connection
$con = mysqli_connect("localhost","root","root","ONG_db");
mysqli_set_charset( $con,"UTF8");
if(!$con) 
    die('Could not connect: '.mysqli_error($con));


if(isset($colectivo)){
    echo "<p> Edita el nombre del colectivo</p>";
    echo" <label for='colectivo'>Colectivo:</label><br>";
    echo" <input type='text' id='colectivo' name='colectivo' value='".$colectivo."'><br>";
    echo" <input type='hidden' id='oldcolectivo' name='oldcolectivo' value='".$colectivo."'><br>";   
}
if(isset($servicio)){
    echo "<p> Edita el nombre del servicio</p>";
    echo" <label for='servicio'>Servicio:</label><br>";
    echo" <input type='text' id='servicio' name='servicio' value='".$servicio."'><br>";
    echo" <input type='hidden' id='oldservicio' name='oldservicio' value='".$servicio."'><br>";   
}




    
?>
