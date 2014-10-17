$(document).ready(function() {		
	$("form#frmConfigs").submit( function(eventObj) {
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