loadJsOrCssFile('/scripts/upload/fileuploader.js', 'js');
loadJsOrCssFile('/scripts/upload/fileuploader.css', 'css');

function createUploader(){
    var uploader = new qq.FileUploader({
    	maxConnections: 1,
    	multiple: false,
        element: document.getElementById('file-uploader'),
        listElement: document.getElementById('separate-list'),
        action: '/news/ajax-upload'
    });
};
window.onload = createUploader;

function uploaderCallback(file, item, fileName, result) {
    var aLink = $('#image-thumb a');
    aLink.attr('filename', fileName);
    var image = $('#image-thumb a img');
    aLink.attr('url', '');
    image.attr('src', aLink.attr('tmpUrl')+fileName);
    
    var size = file._find(item, 'size').innerHTML;
    //$('#image-size').text(size);
    $('#image-name').text(fileName);
    /*var d = new Date();
    var ampm = 'AM';
    var hour = d.getHours();
    if(hour > 12) ampm = 'PM';
    hour = ((''+hour).length<2 ? '0' :'') + hour ;
    var minute = d.getMinutes();
    minute = ((''+minute).length<2 ? '0' :'') + minute;
    var date = $('#image-upload-date').attr('date') + hour + ':' + minute + ' ' + ampm;
    $('#image-upload-date').text(date);
    $('#progress-img').hide();
    $('#image-size').text(size);*/
    $('#Save').attr('disabled', false);
    /*var img = new Image();
    img.src = aLink.attr('tmpUrl')+fileName;
    img.onload = function(){
    	$('#image-dimension').text(img.width + ' x ' + img.height + ' px');
    }*/
}

$(document).ready(function() {
	$('.image-in-modal').click(function(){
		var url = $.trim($(this).attr('url'));
		var tmpUrl = $.trim($(this).attr('tmpUrl'));
		var imageName = $.trim($('#image-name').text());
		if(url.length <= 0) url = tmpUrl;
		var content = '<img src="'+url+imageName+'"/>'; 
		loadModal(content);
	})
	
	$("form#frmImage").submit( function(eventObj) {
		var oldImageName = $.trim($('#image-name').attr('old-image-name'));
		var imageName = $.trim($('#image-name').text());
		
	      $('<input />').attr('type', 'hidden')
	          .attr('name', "OldImageName")
	          .attr('value', oldImageName)
	          .appendTo('form#frmImage');
	      
	      $('<input />').attr('type', 'hidden')
          .attr('name', "ImageUrl")
          .attr('value', imageName)
          .appendTo('form#frmImage');
	      return true;
	  });	
});
