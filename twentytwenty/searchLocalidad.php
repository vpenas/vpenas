<?php
   
   //check localidad
    $provincia = $_GET['provincia_name']; 

    if( $provincia != ''){
        //establish connection
        $con = mysqli_connect("localhost","root","root","ONG_db");
        if(!$con) 
            die('Could not connect: '.mysqli_error($con));
        
   
        //get id provincia
        $sql = "SELECT * FROM provincia WHERE nombre LIKE '%".$provincia."%'";     
        $result = mysqli_query($con,$sql); 
        $row = mysqli_fetch_assoc($result);
        $idProvincia = (int)$row['idProvincia']; 


        // Get search term 
        $searchTerm = $_GET['term']; 
            // Fetch matched data from the database 
        $sql = "SELECT * FROM localidad WHERE nombre LIKE '%".$searchTerm."%' AND  idProvincia LIKE '".$idProvincia."' ORDER BY nombre ASC LIMIT 5";       
        $result = mysqli_query($con,$sql);     
        
        // Generate array with skills data 
        $skillData = array();   

        if((int)mysqli_num_rows($result)  > 0){ 
            while($row = mysqli_fetch_assoc($result)){ 
                $skillData[] = array("value"=>$row['idLocalidad'],"label"=>utf8_encode($row['Nombre']));
            } 
        }     
        
        // Return results as json encoded array 
        echo json_encode($skillData); 
    
    }
?>
