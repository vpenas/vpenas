<?php
   
    //establish connection
    $con = mysqli_connect("localhost","root","root","ONG_db");
    if(!$con) 
        die('Could not connect: '.mysqli_error($con));
    
    // Get search term 
    $searchTerm = $_GET['term']; 
        // Fetch matched data from the database 
    $sql = "SELECT * FROM tiposervicio WHERE nombre LIKE '%".$searchTerm."%' ";     
    $result = mysqli_query($con,$sql);     
    

    if((int)mysqli_num_rows($result)  > 0){ 
        while($row = mysqli_fetch_array($result)){ 
            $skillData[] = array("value"=>$row['idTipoServicio'],"label"=>utf8_encode($row['Nombre']));
        } 
    }     
      
    // Return results as json encoded array 
    echo json_encode($skillData); 
?>


