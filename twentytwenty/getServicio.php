<?php
    //$message = "Entró en getServicio.php";
    //echo "<script type='text/javascript'>alert('$message');</script>";
    error_reporting(0); //abv
    $colectivo = $_GET['colectivo'];
    if ($colectivo == null){
            echo "<span='warning'><br><center><i><b>No se ha seleccionado ningún colectivo.</b></i></center></span>";
        }
    $con = mysqli_connect("localhost","root","","wordpress_pruebas1");
    mysqli_set_charset( $con,"UTF8");
    if(!$con) 
        die('Could not connect: '.mysqli_error($con));

   
    //get id colectivo
    $idColectivo = getId('tiposervicio','nombre',$colectivo,'idTipoServicio',$con);


    //get servicios
    $sql = "SELECT DISTINCT idServicio FROM centro_Servicio where idTipoServicio LIKE '".$idColectivo."'";     
    $result = mysqli_query($con,$sql); 


    $result_servicio = [];   
    while($row = mysqli_fetch_assoc($result)){ 
         array_push( $result_servicio,$row['idServicio'] );
    } 
     

    if(count($result_servicio)>0){
            echo "<a href=\"insertar-informacion/?categoria=servicio\"><button class='button-option' id='add-button'><div id='divAddButton';'>+</div></button></a>";
            //echo "<button class='button-option' id='add-button' onclick=\"addColectivo()\"><div id='divAddButton';'>+</div></button>";
        foreach($result_servicio as $value){
            $sql = "SELECT Nombre FROM servicio where idServicio LIKE '".$value."'";     
            $result = mysqli_query($con,$sql);
            echo "<form id='group-ser' method=get action=".get_template_directory_uri()."></form>";
            while($row = mysqli_fetch_assoc($result)){ 
                echo "<div class='button-options' id='button-".$row['Nombre']."'><center>";
                echo "<a href=\"centros/?colectivo=".$colectivo."&servicio=".$row['Nombre']."\"><button type='button'\" >".$row['Nombre']." </button></a>";
                echo "<br><button class='button-option' id='edit-button'  onclick=\"loadEditServicio('".$row['Nombre']."') \" >Editar </button>";
                //echo "<button class='button-option'id='erase-button' onclick=\"eraseServicio('".$row['Nombre']."') \" >Borrar </button>";
                echo "</center></div>";        
            }      
        }
    }elseif (count($result_servicio)==0 && $colectivo != null){
        echo "<span='warning'><br><center><i><b>No hay servicios asociados a este colectivo.</b></i></center></span>";
    }
    echo"<input type='hidden' id='currentColectivo' name='currentColectivo' value='".$colectivo."'><br>";

    mysqli_close($con);
    
    
    // Consulta SQL para revertir el borrar servicios de "Personas mayores"
    //INSERT INTO `centro_Servicio` (idCentroServicio, idCentro, idServicio, idTipoServicio) VALUES (158,21,2,1);
    //INSERT INTO `centro_Servicio` (idCentroServicio, idCentro, idServicio, idTipoServicio) VALUES (181,19,2,1);
    
    // Consulta SQL para revertir el borrar servicios de "Menores"
    //INSERT INTO `centro_Servicio` (idCentroServicio, idCentro, idServicio, idTipoServicio) VALUES (159,21,2,9);
    //INSERT INTO `centro_Servicio` (idCentroServicio, idCentro, idServicio, idTipoServicio) VALUES (183,19,2,9);
?>
