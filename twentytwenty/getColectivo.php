<?php
   //$message = "Entró en getColectivo.php";
   //echo "<script type='text/javascript'>alert('$message');</script>";

    $con = mysqli_connect("localhost","root","","wordpress_pruebas1");

    if(!$con){
        //echo "<script type='text/javascript'>alert('Entró en if(!con)');</script>";
        die('Could not connect: '.mysqli_error($con));
    }
    //get id provincia
    $sql = "SELECT * FROM tiposervicio";     
    $result = mysqli_query($con,$sql); 
    
//echo "<script type='text/javascript' href=\"http//localhost/wordpress/wp-content/themes/twentytwenty/assets/js/multistepsearch.js\"></script>";
//echo "<script type='text/javascript' href=\"/assets/js/multistepsearch.js\"></script>";

    if((int)mysqli_num_rows($result)  > 0){ 
        //$newrow = true;
        echo "<a href=\"insertar-informacion/?categoria=colectivo\"><button class='button-option' id='add-button'><div id='divAddButton';'>+</div></button></a>";
        //echo "<button class='button-option' id='add-button' onclick=\"addColectivo()\"><div id='divAddButton';'>+</div></button>";
        echo "<form id='group-col' type='hidden' method=get action=".get_template_directory_uri()."></form>";
        echo "<div class='grid-results-container'>";
        while($row = mysqli_fetch_assoc($result)){ 
            //if ($newrow == true) echo "<tr>";
            echo "<div class='grid-item'><div class='button-options' id='button-".$row['Nombre']."'><center>";
            echo "<a href=\"servicios/?colectivo=".$row['Nombre']."\"> <button type='button'>".$row['Nombre']." </button></a>";
            //echo "<br><button class='button-option'id='erase-button' onclick=\"eraseColectivo('".$row['Nombre']."') \" style='width:15%'>Borrar </button>";
            echo "<br>";
            echo "<button class='button-option' id='edit-button'  onclick=\"loadEditColectivo('".$row['Nombre']."') \">Editar </button>";
            echo "</center></div></div>";
            
        }
        echo "</div>";
    }
    mysqli_close($con);
    
    
    
    
    
    
    
    
    
    
    
    
    
    // Consulta SQL para revertir el borrar colectivo "Menores"
    //INSERT INTO `tiposervicio` (idTipoServicio,Nombre) VALUES (9,'Menores');

?>