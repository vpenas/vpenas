<?php
   
   $con = mysqli_connect("localhost","root","","wordpress_pruebas1");
    if(!$con) 
        die('Could not connect: '.mysqli_error($con));


    //get id provincia
    $sql = "SELECT * FROM tiposervicio";     
    $result = mysqli_query($con,$sql); 

  
    if((int)mysqli_num_rows($result)  > 0){ 
        while($row = mysqli_fetch_assoc($result)){ 
            echo "<div class='button-options' id='button-".utf8_encode($row['Nombre']) ."'>";
            echo "<button  onclick=\"showServicio('".utf8_encode($row['Nombre']) ."',1) \" >". utf8_encode($row['Nombre']) . " </button>";
            echo "<button class='button-option' id='edit-button'  onclick=\"loadEditColectivo('".utf8_encode($row['Nombre']) ."') \" >Editar </button>";
            echo "<button class='button-option'id='erase-button' onclick=\"eraseColectivo('".utf8_encode($row['Nombre']) ."') \" >Borrar </button>";
            echo "</div>";
        } 
    }     
    mysqli_close($con);
    
?>
