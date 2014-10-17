$(document).ready(function() {
    var press = 0; var p = false; var keycode = 0;
	$('body').live('keydown', function(e){
        keycode =  e.keyCode ? e.keyCode : e.which;
		if ($('input#MultiConfigName:focus').length !== 0 ) {
	        var names = $.trim($(this).val());
	        var values = $.trim($('#MultiConfigVaue').val());
			$('input#MultiConfigName').live('keypress', function(ev){	
				if(press < 1){
					var key =  ev.keyCode ? ev.keyCode : ev.which;
			        var myString = String.fromCharCode(key);
			        var evt = e || window.event;
			        if (evt.shiftKey) {
			    		shiftKeyDown = true;
			        } else {
			        	shiftKeyDown = false;
			        }
			        
			        if(names === values && names === myString)
			        	$('#MultiConfigVaue').val(names);
			        else{
			        	$('#MultiConfigVaue').val(values+myString);
			        }        	

					press++;
					p = true;
				}
			});
	        console.log(keycode);
	        if(keycode == 8)
	        	$('#MultiConfigVaue').val(values.slice(0, -1));
	    }
		 press = 0;
		 p = false;
	});
	
	$('#multi-configs').live('click', function(){
        var url = '/configs/ajax-add-multi-configs';
        $.ajax({
            url : url,
            method: 'get',
            success : function(data){
                loadModal(data);
            }
        });
    });
	
	$("form#frmMultiConfigs").submit( function(eventObj) {
    	if($('#Section').length){
    		  var section = $.trim($('#Section').val());
		      $('<input />').attr('type', 'hidden')
	          .attr('name', "ConfigValue")
	          .attr('value', section)
	          .appendTo('form#frmConfigs');	    	
    	}
	    return true;
	  });		
});
