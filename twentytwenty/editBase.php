<?php
    $asociacion = $_POST['centro'];
    $oldasociacion = $_POST['oldcentro'];
    $direccion = $_POST['direccion'];
    $olddireccion = $_POST['olddireccion'];
    $descripcion =  $_POST['descripcion'];
    $provincia = $_POST['provincia'];
    $localidad = $_POST['localidad'];
    $codigoPostal = $_POST['codigoPostal'];
    $paginaWeb = $_POST['paginaWeb'];
    $email = $_POST['email'];    
    $servicios = array();
    $array_colectivo = array();
    $array_servicios = array();
    $numcolectivos =0;
    $colectivos = $_POST['namescolectivo'];
    $activo = 'check';
    $centroValid = false;


     
    //collect info colectivos and servicios
    if(isset($colectivos)){
        //Array colectivos
        $array_colectivo = explode(",",$colectivos ); 
        //Array gloabal servicios 
        $numcolectivos = count($array_colectivo);

        for($i =1; $i < $numcolectivos ; $i++){
            if(isset($_POST['namesservicio'.$i])){
                 $servicios[] =  $_POST['namesservicio'.$i];
            }else{
                $servicios[]='';
            }
        }
    }


    //establish connection
    $con = mysqli_connect("localhost","root","root","ONG_db");
    mysqli_set_charset( $con,"UTF8");
    if(!$con) 
        die('Could not connect: '.mysqli_error($con));


    $idCentro = getIdCentro($oldasociacion,$olddireccion, $con);
    $idCentroNew = getIdCentro($asociacion,$direccion, $con);
    $idLocalidad = getId('localidad','nombre',$localidad,'idLocalidad',$con);
    $idCodigoPostal = getId('codigopostal','nombre',$codigoPostal,'idCP',$con);
    $idProvincia = getId('provincia','nombre',$provincia,'idProvincia',$con);
    

    if( $idCentroNew == 0 || $idCentroNew == $idCentro){
        $centroValid = true;
    }else{
        $centroValid = false;
    }


    if($centroValid){    
    //Not null search id localidad
        if($idProvincia !=0 ){
            if($idLocalidad !=0){
                if ($idCodigoPostal!=0){
                    editCentro( $idCentro,$asociacion,$direccion,$descripcion,$idProvincia ,$idLocalidad,$idCodigoPostal,$paginaWeb,$email,$activo,$con);
                    echo "Edicion Exitosa".$idLocalidad, $idCodigoPostal,$idProvincia ;
                }else{
                    addCodigoPostal($codigoPostal,$idLocalidad,$con);
                    $idCodigoPostal = getId('codigopostal','nombre',$codigoPostal,'idCP',$con);
                    editCentro( $idCentro,$asociacion,$direccion,$descripcion,$idProvincia ,$idLocalidad,$idCodigoPostal,$paginaWeb,$email,$activo,$con);
                    echo "Registro de nuevo codigo postal" ;
                }

            }else{
                addLocalidad($localidad,$idProvincia, $con);
                $idLocalidad = getId('localidad','nombre',$localidad,'idLocalidad',$con);
                addCodigoPostal($codigoPostal,$idLocalidad,$con);
                $idCodigoPostal = getId('codigopostal','nombre',$codigoPostal,'idCP',$con);
                editCentro( $idCentro,$asociacion,$direccion,$descripcion,$idProvincia ,$idLocalidad,$idCodigoPostal,$paginaWeb,$email,$activo,$con);
                echo "Registro de nueva localidad" ;

            }

        }else{
            addProvincia($provincia,$con);
            $idProvincia = getId('provincia','nombre',$provincia,'idProvincia',$con);
            addLocalidad($localidad,$idProvincia, $con);
            $idLocalidad = getId('localidad','nombre',$localidad,'idLocalidad',$con);
            addCodigoPostal($codigoPostal,$idLocalidad,$con);
            $idCodigoPostal = getId('codigopostal','nombre',$codigoPostal,'idCP',$con);
            editCentro( $idCentro,$asociacion,$direccion,$descripcion,$idProvincia ,$idLocalidad,$idCodigoPostal,$paginaWeb,$email,$activo,$con);
            echo "Registro de nueva provincia" ;

        }


        
        //Eliminate old servicio , centro TiposServicio relations
        eraseCentroServicio($idCentro,$con);
    

        //Update  new servicio , centro TiposServicio relations
        for($i =0; $i <  $numcolectivos-1 ; $i++){
            //info colectivo
            $colectivo = $array_colectivo[$i];
            $idColectivo = getId('tiposervicio','nombre',$colectivo,'idTipoServicio',$con);
            //info servicios 
            $array_servicios = getArray($servicios[$i] );            
            $numservicios = count($array_servicios);
            echo"array servicios".$servicios[$i]. "num servicios".$numservicios."colectivo". $colectivo;
                if ($idColectivo !=0){   
                    for($j =0; $j <  $numservicios-1 ; $j++){
                        $servicio = $array_servicios[$j];
                        $idServicio = getId('servicio','nombre',$servicio,'idServicio',$con);
                        if ($idServicio !=0){
                            addCentroServicio($idCentro, $idServicio, $idColectivo, $con);
                            echo "Registro exitoso de".$idCentro, $idColectivo,$idServicio ;
                        }else{
                            addServicio($servicio, $con);
                            $idServicio = getId('servicio','nombre',$servicio,'idServicio',$con);
                            addCentroServicio($idCentro, $idServicio, $idColectivo, $con);
                            echo "Registro exitoso de".$idCentro, $idColectivo,$idServicio ;
                        }
                    
                    }                
                
                }else{
                    addColectivo($colectivo, $con);
                    $idColectivo = getId('tiposervicio','nombre',$colectivo,'idTipoServicio',$con);
                    for($j =0; $j <  $numservicios-1 ; $j++){
                        $servicio = $array_servicios[$j];
                        $idServicio = getId('servicio','nombre',$servicio,'idServicio',$con);
                        if ($idServicio !=0){
                            addCentroServicio($idCentro, $idServicio, $idColectivo, $con);
                            echo "Registro exitoso de".$idCentro, $idColectivo,$idServicio ;
                        }else{
                            addServicio($servicio, $con);
                            $idServicio = getId('servicio','nombre',$servicio,'idServicio',$con);
                            addCentroServicio($idCentro, $idServicio, $idColectivo, $con);
                            echo "Registro exitoso de".$idCentro, $idColectivo,$idServicio ;
                        }
                    }
                }
        }
}else{

    echo "Usuario duplicado en la base de datos.";
}



     
   

// get id from any variable
function eraseCentroServicio($idCentro,$con){
    $sql = "DELETE FROM centro_servicio WHERE  idCentro='". $idCentro."'";     
    $result = mysqli_query($con,$sql); 
}


function getArray($string){
    return  explode(",",$string );
}

// get id from any variable
function getId($tabla,$columna,$variable,$id,$con){
    $sql = "SELECT * FROM ".$tabla." WHERE ".$columna." LIKE '".$variable."' LIMIT 1 ";     
    $result = mysqli_query($con,$sql); 
    $row = mysqli_fetch_assoc($result);
    return  (int)$row[$id]; 
 
}
function getIdCentro($variable,$direccion,$con){
    $sql = "SELECT * FROM centro WHERE nombre LIKE '".$variable."' AND direccion LIKE '".$direccion."' ";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    return  (int)$row["idCentro"];

}

//Add data functions
function addProvincia($asociacion,$con){
    $sql="INSERT INTO provincia ( Nombre) VALUES ( '".$asociacion."')"; 
    $result = mysqli_query($con,$sql);   
}

function addLocalidad($localidad,$idProvincia, $con){
    $sql="INSERT INTO localidad ( Nombre, idProvincia) VALUES ( '".$localidad."','".$idProvincia."')";
    $result = mysqli_query($con,$sql);       
}
function addCodigoPostal($codigoPostal,$idLocalidad,$con){
    $sql="INSERT INTO codigopostal ( Nombre,idLocalidad) VALUES ( '".$codigoPostal."','".$idLocalidad."')";
    $result = mysqli_query($con,$sql);       
}
function editCentro( $idCentro,$nombre,$direccion,$descripcion,$provincia,$localidad,$codigoPostal,$paginaWeb,$email,$activo,$con){
    $sql="UPDATE centro SET  Nombre = '".$nombre."',Direccion='".$direccion."',Descripcion='".$descripcion."',
    Provincia = '".$provincia."',Localidad= '".$localidad."',CodigoPostal= '".$codigoPostal."',
    PaginaWeb='".$paginaWeb."',Email= '".$email."',Activo= '".$activo."' WHERE idCentro='". $idCentro."'";
    $result = mysqli_query($con,$sql);       
}

    
function addColectivo($colectivo, $con){
        $sql="INSERT INTO tiposervicio ( Nombre) VALUES ( '".$colectivo."')";
        $result = mysqli_query($con,$sql);
    }

    function addServicio($servicio, $con){
        $sql="INSERT INTO servicio ( Nombre) VALUES ( '".$servicio."')";
        $result = mysqli_query($con,$sql);
    }
    function addCentroServicio($idCentro,$idServicio,$idColectivo,$con){
        $sql="INSERT INTO centro_servicio( idCentro, idServicio,idTipoServicio) VALUES
        ( '".$idCentro."','".$idServicio."','".$idColectivo."')";
        $result = mysqli_query($con,$sql);
    }



?>
