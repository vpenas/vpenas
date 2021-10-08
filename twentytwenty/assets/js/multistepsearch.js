//console.log("Entró en ms-search");
var $ = jQuery;
var currentTab = 0; // Current tab is set to be the first tab (0)

$(document).ready(function(){ //abv: good practice
    $(function() {   
        showTab(currentTab); // Display the current tab
        $(".Modal").hide();   
        showColectivo();
        $("#numrows").val($("#tabla_colectivos tr").length); 

    });
}); //abv

function validateForm(){
    // this is the id of the form
		$("#idEdit").validate({
			rules: {
				// simple rule, converted to {required:true}
				centro: {
					required: true,
                },
                // compound rule
				direccion: {
					required: true,
					
				},
				// compound rule
				email: {
					required: true,
					email: true
				}
			},
			messages: {
				centro: {
					required: "Agrega un centro",				
                },
                direccion: {
					required: "Agrega una direccion",				
				},
				email: {
					required: "Es necesario agregar un email",				
				}
			},
			submitHandler: function(form) {	
				$.ajax({
					url: form.action,
					type: form.method,
					data: $(form).serialize(),
					success: function(data)
					{
							console.log('Edición satisfactoria');
                            alert(data);
                            showCenter($("#currentColectivo").val(),$("#currentServicio").val(),0);
                            $("#modal-edit").hide();	
                            					
					},
					error: function (data) {
							console.log('An error occurred.');
							alert(data);
				    }
                });	
            
        }	
    });	
    return $("#idEdit").valid();
}



function editForm(){
    getColectivosAndServicios();
    if(validateForm()){  
        $("#idEdit").submit();
    }
}


function showColectivo(){
//function showColectivo(event){ //abv
   //event.preventDefault(); // <---- Add this line
   //console.log("Entró en ms-search.js showColectivo()");
    //$("#group-aso").empty();
    $.ajax({    //create an ajax request to display.php
        type: "GET",
        url: $('#group-aso').attr("action"),             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $("#group-aso").append(response);         
        }
    });
}

function showServicio(colectivo,$index){
    //event.preventDefault(); // <---- Add this line
    console.log("Entró en ms-search.js showServicio()");
    nextPrev($index);   
    $("#group-ser").empty(); 
    $.ajax({    //create an ajax request to display.php
        type: "GET",
        data:{"colectivo":colectivo},
        //url: $('#group-ser').attr("action"),             
        url: getThemePath("#group-ser")+"/getServicio.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $("#group-ser").append(response); 
            $("#title-servicios h4").html("Servicios de"+" "+ colectivo);        
        }
    }); 
}

function showCenter(colectivo,servicio,$index){
    event.preventDefault(); // <---- Add this line
    $("#group-centro").empty();
    nextPrev($index);
    $.ajax({    //create an ajax request to display.php
        type: "GET",
        data:{"servicio":servicio,
        "colectivo":colectivo, "url":getThemePath()
        },
        url: $('#group-centro').attr("action"),             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $("#group-centro").append(response);
            $("#title-centros h4").html("Centros de "+servicio +"-"+colectivo);
        }
    });
}


function showTab(n) {
    var x = $(".tab");  
    $(x).css("display","none");
    $(x[n]).css("display","block");    
}


function nextPrev(n) {  
        var x = $(".tab");	
        currentTab = currentTab + n;
        showTab(currentTab);
}




// Modals managers

function eraseModal(centro,direccion,idbutton){
   event.preventDefault();
  $("#modal-erase").show();
  $("#accept-erase").attr("onClick", "eraseCentro('"+centro+"','"+direccion+"','"+idbutton+"')");

}

function loadEditModal(centro,direccion,idbutton){  
   $("#modal-edit").show();
   $(".tabEdit").empty();
   event.preventDefault(); // <---- Add this line      
    $.ajax({    //create an ajax request to display.php
        type: "GET",
        data:{"centro":centro,"direccion":direccion,"url":getThemePath()},
        url: getThemePath()+"/editModalCentro.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){  
            $(".tabEdit").prepend(response); 
            autoComplete();                 
            
        }
    });
   // $("#accept-edit").attr("onClick", "eraseCentro('"+centro+"','"+direccion+"','"+idbutton+"')");
 
 }


//add or remove  colectivo and servicio rows
function add_row()
{
  $rowno=$("#tabla_colectivos tr").length;
  $rowno=$rowno+1;
  if($rowno == 1){
      $("#tabla_colectivos").append("<tr id='row"+$rowno+"'><input type='hidden' id='namesservicio"+$rowno+"' name='namesservicio"+$rowno+"'><td><input type='text' id='colectivo"+ $rowno+"' onkeyup=\"autoColective('#colectivo" +$rowno+"')\"  name='colectivo"+ $rowno+"' formaction=\""+$("#namescolectivo").attr('formaction')+"\" placeholder='Añade Colectivos'></td><td><ul id='servicio"+$rowno+"-multi-tag' class='tagit'><li class='tagit-new'><input type='text' id='servicio"+$rowno+"'  name='servicio"+ $rowno+"' onkeyup=\"autoService('#servicio" +$rowno+"')\" formaction=\""+$("#namesservicio").attr('formaction')+"\"  placeholder='Añade Servicios'></td></li></ul></td><td><input type='button' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
  }else{
      $("#tabla_colectivos tr:last").after("<tr id='row"+$rowno+"'><input type='hidden' id='namesservicio"+$rowno+"' name='namesservicio"+$rowno+"'><td><input type='text' id='colectivo"+ $rowno+"' onkeyup=\"autoColective('#colectivo" +$rowno+"')\"  name='colectivo"+ $rowno+"' formaction=\""+$("#namescolectivo").attr('formaction')+"\" placeholder='Añade Colectivos'></td><td><ul id='servicio"+$rowno+"-multi-tag' class='tagit'><li class='tagit-new'><input type='text' id='servicio"+$rowno+"'  name='servicio"+ $rowno+"' onkeyup=\"autoService('#servicio" +$rowno+"')\" formaction=\""+$("#namesservicio").attr('formaction')+"\"  placeholder='Añade Servicios'></td></li></ul></td><td><input type='button' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
  }
}

function delete_row(rowno)
{
  $('#'+rowno).remove();
 
}






//close modals
function closeModal(id){
    $('#'+id).hide();
}

// get theme file datapath
//function getThemePath(){
function getThemePath(formID){
    //var s = $('#group-ser').attr("action");
    var s = $(formID).attr("action");
    console.log(s);
    //s = s.substring(0, s.lastIndexOf('/'));
    return s;
}



function getColectivosAndServicios(){
    var $numColectivos = $("#tabla_colectivos tr").length;
    var $colectivos=''; 
     
    for ($i = 1; $i <= $numColectivos; $i++){
        $valColectivo = $("#colectivo"+$i).val();
        //add colectivos values
        if( $valColectivo != ''){
            $colectivos+=$valColectivo+",";
             //add servicios values
            var $servicios='';  
            var $numServicios = $("#servicio"+$i+"-multi-tag .tagit-choice").length;
            for ($j = 1; $j <= $numServicios; $j++){
                $valServicio = $("#servicio"+$i+"-multi-tag #tag"+$j+" .tag-label").text();
                $servicios+=  $valServicio+",";  
            }
            $("#namesservicio"+ $i).val($servicios);
           // alert( "hola"+ $servicios +"index"+$i +"numero ser"+ $numServicios);
           
        }
    }
    $("#namescolectivo").val($colectivos);
    
}



// erase colectivos
function eraseColectivo(colectivo){
    event.preventDefault(); // <---- Add this line 
    $.ajax({    //create an ajax request to display.php
        type: "GET",
        data:{"colectivo":colectivo},
        url: getThemePath("#group-col")+"/eraseColectivos.php",                       
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $("#button-"+colectivo).hide();
            showColectivo();
            alert(response); 
        }
    });

}

function eraseServicio(servicio){
    event.preventDefault(); // <---- Add this line 
    $.ajax({    //create an ajax request to display.php
        type: "GET",
        data:{"servicio":servicio},
        url: getThemePath("#group-ser")+"/eraseServicio.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $("#button-"+servicio).hide();
            showServicio($("#currentColectivo").val(),0);
            alert(response); 
           
        }
    });

}

// Erase centro from database
function eraseCentro(centro,direccion,idbutton){
    event.preventDefault(); // <---- Add this line 
    $.ajax({    //create an ajax request to display.php
        type: "GET",
        data:{"centro":centro,"direccion":direccion},
        url: getThemePath("#group-cen")+"/eraseCentro.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $('#'+idbutton).closest('tr').remove(); 
            $("#modal-erase").hide(); 
            alert(response); 
        }
    });

}


function loadEditColectivo(colectivo){
    $("#modal-edit-content").show();
    $(".tabEditCS").empty();
    event.preventDefault(); // <---- Add this line      
     $.ajax({    //create an ajax request to display.php
         type: "GET",
         data:{"colectivo":colectivo},
         url: getThemePath()+"/editModalColectivoServicio.php",             
         dataType: "html",   //expect html to be returned                
         success: function(response){ 
            $(".tabEditCS").prepend(response);  
            $("#idEditCS #accept-edit").attr('onclick', 'editFormColectivo()');            
             
         }
     });

}

function loadEditServicio(servicio){
    $("#modal-edit-content").show();
    $(".tabEditCS").empty();
    event.preventDefault(); // <---- Add this line      
     $.ajax({    //create an ajax request to display.php
         type: "GET",
         data:{"servicio":servicio},
         url: getThemePath()+"/editModalColectivoServicio.php",             
         dataType: "html",   //expect html to be returned                
         success: function(response){
            $(".tabEditCS").prepend(response); 
            $("#idEditCS #accept-edit").attr('onclick', 'editFormServicio()');                
             
         }
     });

}



function validateColectivo(){
    // this is the id of the form
		$("#idEditCS").validate({
			rules: {
				// simple rule, converted to {required:true}
				colectivo: {
					required: true,
                }
			},
			messages: {
				colectivo: {
					required: "Agrega un colectivo",				
                }
			},
			submitHandler: function(form) {	
				$.ajax({
					url: form.action,
					type: form.method,
					data: $(form).serialize(),
					success: function(data)
					{
                            location.reload();
							console.log('Edición satisfactoria');
							alert(data);
						
					},
					error: function (data) {
							console.log('An error occurred.');
							alert(data);
				    }
                });	
            
        }	
    });	
   
    return $("#idEditCS").valid();
}


function validateServicio(){
    // this is the id of the form
		$("#idEditCS").validate({
			rules: {
				// simple rule, converted to {required:true}
				servicio: {
					required: true,
                }
			},
			messages: {
				servicio: {
					required: "Agrega un servicio",				
                }
			},
			submitHandler: function(form) {	
				$.ajax({
					url: form.action,
					type: form.method,
					data: $(form).serialize(),
					success: function(data)
					{
							console.log('Edición satisfactoria');
                            alert(data);
                            showServicio($("#currentColectivo").val(),0);
                            $("#modal-edit-content").hide();
						
					},
					error: function (data) {
							console.log('An error occurred.');
							alert(data);
				    }
                });	
            
        }	
    });	
   
    return $("#idEditCS").valid();
}


function editFormColectivo(){
    if(validateColectivo()){   
        $("#idEditCS").submit();
    }
}

function editFormServicio(){
    if(validateServicio()){   
        $("#idEditCS").submit();
    }
}
