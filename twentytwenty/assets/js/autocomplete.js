
function autoComplete(){
    //autocompletar colectivo	   	 
    $("#provincia").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: $("#provincia").attr('formaction'),
                dataType: "json",
                data: {
                    term : request.term,
                    provincia_name : $("#provincia").val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        focus: function (event, ui) {
            event.preventDefault();
            $("#provincia").val(ui.item.label);
          
        },			
        select: function( event, ui ) {
        event.preventDefault();
        $("#provincia").val(ui.item.label);
        }
    });
    
    $("#localidad").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: $("#localidad").attr('formaction'),
                dataType: "json",
                data: {
                    term : request.term,
                    provincia_name : $("#provincia").val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        focus: function (event, ui) {
            event.preventDefault();
            $("#localidad").val(ui.item.label);
          
        },			
        select: function( event, ui ) {
        event.preventDefault();
        $("#localidad").val(ui.item.label);
        }
    });
    $("#codigoPostal").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: $("#codigoPostal").attr('formaction'),
                dataType: "json",
                data: {
                    term : request.term,
                    localidad_name : $("#localidad").val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        focus: function (event, ui) {
            event.preventDefault();
            $("#codigoPostal").val(ui.item.label);
          
        },
        select: function( event, ui ) {
        event.preventDefault();
        $("#codigoPostal").val(ui.item.label);
        }
    });
}


function autoColective(colectivo){
	$(colectivo).autocomplete({
			source: function(request, response) {
				$.ajax({
					url: $(colectivo).attr('formaction'),
					dataType: "json",
					data: {
						term : request.term
					},
					success: function(data) {
						response(data);
						
					}
				});
            },
            focus: function (event, ui) {
                event.preventDefault();
                $(colectivo).val(ui.item.label);
            },
			select: function( event, ui ) {
			event.preventDefault();
			$(colectivo).val(ui.item.label);
			}
		});
	}


	function autoService(servicio){
        event.preventDefault();      
        var key = event.keyCode;
        if(key == 13)  // the enter key code
        {
            var label = $(servicio).val();
            if(label != '')
            addTag(servicio, label);
           
        }    
        $(servicio).autocomplete({         
                source: function(request, response) {      
                    $.ajax({
                        url: $(servicio).attr('formaction'),
                        dataType: "json",
                        data: {
                            term : request.term
                        },
                        success: function(data) {
                            response(data);          
                        }
                    });
                },
                focus: function (event, ui) {
                    event.preventDefault();
                    $(servicio).val(ui.item.label);
                },
                select: function( event, ui ) {
                    event.preventDefault();
                    addTag(servicio, ui.item.label);
                }
            });
	}
	function delete_service(o){
        $(o).closest('li').remove();
    }
    

    function addTag(servicio, label){
        var $rowno=$("#"+$(servicio).closest('ul').attr('id')+" li").length - 1;
        $rowno=$rowno+1;
        $("#"+$(servicio).closest('ul').attr('id')+" li.tagit-new").before("<li class='tagit-choice' id='tag"+ $rowno+"'> <span class='tag-label'>"+label+"</span> <a class='tagit-close'><span class='text-icon' onclick=\"delete_service(this)\">×</span></a> </li>");
        $(servicio).val('');
    }


    