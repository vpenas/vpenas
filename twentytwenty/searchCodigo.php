<?php
   
    //establish connection
    $localidad = $_GET['localidad_name']; 

    if( $localidad != ''){
        $con = mysqli_connect("localhost","root","root","ONG_db");
        if(!$con) 
            die('Could not connect: '.mysqli_error($con));


        //get id provincia
        $sql = "SELECT * FROM localidad WHERE nombre LIKE '%".$localidad."%'";     
        $result = mysqli_query($con,$sql); 
        $row = mysqli_fetch_assoc($result);
        $idLocalidad = (int)$row['idLocalidad']; 


        // Get search term 
        $searchTerm = $_GET['term']; 
            // Fetch matched data from the database 
        $sql = "SELECT * FROM codigopostal WHERE nombre LIKE '%".$searchTerm."%' AND  idLocalidad LIKE '".$idLocalidad."'ORDER BY nombre ASC LIMIT 5";     
        $result = mysqli_query($con,$sql);     
        
        // Generate array with skills data 
        $skillData = array();   

        if((int)mysqli_num_rows($result)  > 0){ 
            while($row = mysqli_fetch_assoc($result)){ 
                $skillData[] = array("value"=>$row['idCP'],"label"=>utf8_encode($row['Nombre']));
            } 
        }     
        
        // Return results as json encoded array 
        echo json_encode($skillData);
    } 
?>
