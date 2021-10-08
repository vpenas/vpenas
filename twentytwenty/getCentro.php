<?php
   //$message = "Entró en getCentro.php";
   //echo "<script type='text/javascript'>alert('$message');</script>";
   
   error_reporting(0); //abv
   $servicio = $_GET['servicio'];
   $colectivo = $_GET['colectivo'];
   //$localUrl = $_GET['url'];
   
   //if ($servicio == null || $colectivo == null || $localUrl == null){
   if ($servicio == null || $colectivo == null){
            echo "<span='warning'><br><center><i><b>No se ha seleccionado ningún colectivo o servicio.</b></i></center></span>";
   }
   
   $con = mysqli_connect("localhost","root","","wordpress_pruebas1");
   mysqli_set_charset( $con,"UTF8");
   if(!$con) 
       die('Could not connect: '.mysqli_error($con));

  
   //get ids
   $idServicio = getId('servicio','nombre',$servicio,'idServicio',$con);
   $idColectivo = getId('tiposervicio','nombre',$colectivo,'idTipoServicio',$con);

   //get id centros
   $sql = "SELECT idCentro FROM centro_Servicio where idTipoServicio LIKE '".$idColectivo."' AND idServicio LIKE '".$idServicio."'";     
   $result = mysqli_query($con,$sql); 
  


   $result_centro = [];   
   while($row = mysqli_fetch_assoc($result)){ 
        array_push( $result_centro,$row['idCentro'] );
       
   } 

   if(count($result_centro)>0){
        echo "<a href=\"insertar-informacion/?categoria=centro\"><button class='button-option' id='add-button'><div id='divAddButton';'>+</div></button></a>";
        //echo "<button class='button-option' id='add-button' onclick=\"addColectivo()\"><div id='divAddButton';'>+</div></button>";
        echo "<form id='group-col' type='hidden' method=get action=".get_template_directory_uri()."></form>";
        echo "<table>
        <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Localidad</th>
        <th>Dirección</th>
        <th>Código Postal</th>
        <th>Email</th>
        <th colspan=2 style='text-align:center'>Acciones</th>
        </tr>";
       $num_result =0;
       foreach($result_centro as $value){
           $sql = "SELECT * FROM centro where idCentro LIKE '".$value."'";     
           $result = mysqli_query($con,$sql);
           $num_result ++;           
           while($row = mysqli_fetch_assoc($result)){
            $numCodigoPostal = getCodigoPostal( $row['CodigoPostal'],$con);
            $nameLocalidad = getLocalidad(  $row['Localidad'] ,$con);
            echo "<tr id='centroRow".$num_result."'>";
            echo "<td>" . $row['Nombre'] . "</td>";
            echo "<td>" . $row['Descripcion']. "</td>";
            echo "<td>" .$nameLocalidad . "</td>";
            echo "<td>" . $row['Direccion'] . "</td>";
            echo "<td>" . $numCodigoPostal. "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . "<button id=\"edit".$num_result."\"  onclick=\"loadEditModal('". $row['Nombre']."','".$row['Direccion']."','edit".$num_result."') \" > Editar </button> ". "</td>";
            echo "<td>" ." <button id=\"erase".$num_result."\" onclick=\"eraseModal('".$row['Nombre']."','".$row['Direccion']."','erase".$num_result."') \" > Borrar</button>". "</td>";
            echo "</tr>"; 
           } 
          
       }
       echo "</table>";     
        echo"<input type='hidden' id='currentColectivo' name='currentColectivo' value='".$colectivo."'><br>";
        echo"<input type='hidden' id='currentServicio' name='currentServicio' value='".$servicio."'><br>";
   }elseif (count($result_centro)==0 && $colectivo != null && $servicio != null){
       echo "<span='warning'><br><center><i><b>No hay centros asociados a este servicio.</b></i></center></span>";
   }

   mysqli_close($con);

    function getCodigoPostal($idCP,$con){
        $sql = "SELECT nombre  FROM codigopostal WHERE idCp LIKE '".$idCP."'";     
        $result = mysqli_query($con,$sql); 
        $row = mysqli_fetch_assoc($result);
        return  $row["nombre"];
    }

    function getLocalidad($idLocalidad,$con){
        $sql = "SELECT nombre  FROM localidad WHERE idLocalidad LIKE '".$idLocalidad."'";     
        $result = mysqli_query($con,$sql); 
        $row = mysqli_fetch_assoc($result);
        return  $row["nombre"];
    }
?>
