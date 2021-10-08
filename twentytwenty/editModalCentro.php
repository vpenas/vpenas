<?php
   
   $centro = $_GET['centro'];
   $direccion = $_GET['direccion'];
   $localUrl = $_GET['url'];
   $con = mysqli_connect("localhost","root","root","ONG_db");
   if(!$con) 
       die('Could not connect: '.mysqli_error($con));

  
   //get id centros
   $sql = "SELECT * FROM centro where nombre LIKE '".$centro."' AND direccion LIKE '".$direccion."'";     
   $result = mysqli_query($con,$sql); 
  

   while($row = mysqli_fetch_assoc($result)){ 
   $provincia = getValue('provincia','nombre','idProvincia', $row['Provincia'],$con);
   $localidad = getValue('localidad','nombre','idLocalidad', $row['Localidad'],$con);
   $codigoPostal =getValue('codigopostal','nombre','idCP', $row['CodigoPostal'],$con);



   // id del centro
   $idCentro = getIdCentro($centro,$direccion, $con);
   $colectivos = getColectivos($idCentro,$con);
 

   echo "<p>1. Edita Información general</p>";
   echo" <label for='centro'>Centro:</label><br>";
   echo" <input type='text' id='centro' name='centro' value='".$centro."'><br>";
   echo" <input type='hidden' id='oldcentro' name='oldcentro' value='".$centro."'><br>";
   echo" <label for='direccion'>Descripcion:</label><br>";
   echo" <textarea  id='descripcion' name='descripcion' rows='4' maxlength='200'cols='50' placeholder='Describa brevemente el centro' >".utf8_encode($row['Descripcion'])."</textarea><br>";
   echo "<label for='direccion'>Dirección:</label><br>";
   echo "<input type='text' id='direccion' name='direccion'value='".$direccion."'><br>";
   echo "<input type='hidden' id='olddireccion' name='olddireccion'value='".$direccion."'><br>";
   echo "<label  for='provincia'>Provincia:</label><br>";
   echo "<input  type='text' id='provincia' formaction='".$localUrl."/searchProvincia.php' name='provincia' value='".$provincia."' ><br>";
   echo "<label for='localidad'>Localidad:</label><br>";
   echo "<input type='text' id='localidad' formaction='".$localUrl."/searchLocalidad.php' name='localidad'  value='".$localidad."' ><br>";
   echo "<label for='codigoPostal'>Código Postal:</label><br>";
   echo "<input type='number' id='codigoPostal'  formaction='".$localUrl."/searchCodigo.php' name='codigoPostal' value='".$codigoPostal."'><br>";
   echo "<label for='paginaWeb'>Página web:</label><br>";
   echo "<input type='url' id='paginaWeb' name='paginaWeb' value='".$row['PaginaWeb']."'><br>";
   echo "<label for='email'>Email:</label><br>";
   echo "<input type='email' id='email' name='email' value='".$row['Email']."'><br>";
   echo "</p>2. Edita colectivos</p><br>";
   echo "<table id='tabla_colectivos'>";
   echo "<input type='hidden' id='namescolectivo' name='namescolectivo'formaction='".$localUrl."/searchColectivo.php'>";
   echo "<input type='hidden' id='namesservicio' name='namesservicio'formaction='".$localUrl."/searchServicio.php'>";
   $rows = 0;
   foreach($colectivos as $colectivo){   
        $servicios = getServicios($idCentro,$colectivo['idTipoServicio'],$con);
        $rows++;
        echo"<tr id='row".$rows."'>";
            echo"<input type='hidden' id='namesservicio".$rows."' name='namesservicio".$rows."'>";
            echo"<td><input type='text' id='colectivo".$rows."' value='".$colectivo['colectivo']."' name='colectivo".$rows."' onkeyup=\"autoColective('#colectivo".$rows."')\" formaction='".$localUrl."/searchColectivo.php'></td>";
            echo"<td><ul id='servicio".$rows."-multi-tag' class='tagit'>";
            $rowsService=0;
            foreach($servicios as $servicio){
                    $rowsService++;
                    echo"<li class='tagit-choice' id='tag".$rowsService."'>";
                    echo"<span class='tag-label'>".$servicio['servicio']."</span> <a class='tagit-close'><span class='text-icon' onclick=\"delete_service(this)\">×</span></a> ";									
                    echo"</li>";                        
            }
            echo"<li class='tagit-new'>";
                echo"<input type='text' id='servicio". $rows."'  name='servicio". $rows."' placeholder='añade recursos' onkeyup=\"autoService('#servicio". $rows."')\" formaction='".$localUrl."/searchServicio.php'>";									
            echo"</li>";
            echo"</ul></td>";
            echo"<td><input type='button' value='DELETE' onclick=delete_row('row". $rows."')></td>								
            </tr>";
    }
       echo "</table>";
       echo"<input type='button' onclick='add_row();' value='Añade colectivo'>";
        
       
   } 
  
   mysqli_close($con);


// get id from any variable


function getIdCentro($variable,$direccion,$con){
    $sql = "SELECT * FROM centro WHERE nombre LIKE '".$variable."' AND direccion LIKE '".$direccion."' ";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    return  (int)$row["idCentro"];
}
function getId($tabla,$columna,$variable,$id,$con){
    $sql = "SELECT * FROM ".$tabla." WHERE ".$columna." LIKE '".$variable."' LIMIT 1 ";     
    $result = mysqli_query($con,$sql); 
    $row = mysqli_fetch_assoc($result);
    return  (int)$row[$id]; 
 
}

function getColectivos($idCentro,$con){
    $sql = "SELECT DISTINCT idTipoServicio FROM centro_servicio WHERE idCentro LIKE '".$idCentro."'";     
    $result = mysqli_query($con,$sql); 
    $colectivos= array();
    if((int)mysqli_num_rows($result)  > 0){ 
        while($row = mysqli_fetch_assoc($result)){ 
            $colectivo = getValue('tiposervicio','nombre','idTipoServicio',$row['idTipoServicio'],$con);
            $colectivos[] = array("idTipoServicio"=>$row['idTipoServicio'],"colectivo"=>utf8_encode($colectivo));
        } 
    }     
    return $colectivos;
}


function getServicios($idCentro,$idTipoServicio,$con){
    $sql = "SELECT idServicio FROM centro_servicio WHERE idCentro LIKE '$idCentro' AND idTipoServicio LIKE '$idTipoServicio' ";     
    $result = mysqli_query($con,$sql); 
    $servicios= array();
    if((int)mysqli_num_rows($result)  > 0){ 
        while($row = mysqli_fetch_assoc($result)){ 
            $servicio = getValue('servicio','nombre','idServicio',$row['idServicio'],$con);
            $servicios[] = array("idServicio"=>$row['idServicio'],"servicio"=>utf8_encode($servicio));
        } 
    }     
    return $servicios;
}

function getValue($table,$column,$id,$idValue,$con){
    $sql = "SELECT ".$column."  FROM ".$table." WHERE ".$id." LIKE '".$idValue."'";     
    $result = mysqli_query($con,$sql); 
    $row = mysqli_fetch_assoc($result);
    return  $row[$column]; 
}


?>
