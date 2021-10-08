var $ = jQuery;
var currentTab = 0; // Current tab is set to be the first tab (0)

$(function() {   
    showTab(currentTab); // Display the current tab   
    $("#numrows").val($("#tabla_colectivos tr").length); 
});

function validateForm(){
    // this is the id of the form
		$("#idForm").validate({
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
            var x = $(".tab");
            if (currentTab >= (x.length - 1)) {
				$.ajax({
					url: form.action,
					type: form.method,
					data: $(form).serialize(),
					success: function(data)
					{
							console.log('Submission was successful.');
                            alert(data);				
					},
					error: function (data) {
							console.log('An error occurred.');
                            alert(data);
				    }
                });	
            }
        }	
    });	
    return $("#idForm").valid();
}

       
function nextPrev(n) {
    if(validateForm()){   
        var x = $(".tab");	
        // Hide the current tab:        
        $(x[currentTab]).css("display","none");
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form... :
        if (currentTab >= (x.length - 1) ) {
        //...the form gets submitted:
        getColectivosAndServicios();      
        $("#idForm").submit();
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }
}

       

function showTab(n) {
    // This function will display the specified tab of the form ...
    var x = $(".tab");
    $(x[n]).css("display","block");
    // ... and fix the Previous/Next buttons:
    if (n == 0) {
        $("#prevBtn").css("display","none");
    } else {
        $("#prevBtn").css("display","inline");
    }
    if (n == (x.length - 2)) {
        $("#nextBtn").html("Submit");
    } else {
        $("#nextBtn").html("Next");
    }
    if( n == (x.length - 1) ){
        $("#nextBtn").css("display","none");
    } else {
        $("#nextBtn").css("display","inline");
    }
    // ... and run a function that displays the correct step indicator:
    fixStepIndicator(n);
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = $(".step");
    for (i = 0; i < x.length; i++) {
        $(x[i]).removeClass( "active" ).addClass( "" );         
    }
    //... and adds the "active" class to the current step:
    $(x[n]).addClass( "active" );
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

