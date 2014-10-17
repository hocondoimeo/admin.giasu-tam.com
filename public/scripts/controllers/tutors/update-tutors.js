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
    image.attr('alt', fileName);
    image.attr('src', aLink.attr('tmpUrl')+fileName);
    
    var size = file._find(item, 'size').innerHTML;
    //$('#image-size').text(size);
    $('#image-name').text(fileName);
    $('#Save').attr('disabled', false);
}

$(document).ready(function() {
	tinymce.init({
	    selector: "textarea",
	    theme: "modern",
	    plugins: [
	        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
	        "searchreplace wordcount visualblocks visualchars code fullscreen",
	        "insertdatetime media nonbreaking save table contextmenu directionality",
	        "emoticons template paste textcolor colorpicker textpattern"
	    ],
	    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	    toolbar2: "print preview media | forecolor backcolor emoticons",
	    image_advtab: true,
	    templates: [
	        {title: 'Test template 1', content: 'Test 1'},
	        {title: 'Test template 2', content: 'Test 2'}
	    ],

	    doctype : "<!DOCTYPE html>",

	    convert_urls : false,

	    //template_external_list_url : "gen4tinymce/lists/template_list.js",
	    //external_link_list_url : "gen4tinymce/lists/link_list.js",
	    //media_external_list_url : "gen4tinymce/lists/media_list.js",
	        
	    valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang],"
	    + "a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
	    + "name|href|target|title|class],strong/b,em/i,strike,u,-span[data-mce-type],"
	    + "#p[style],,-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
	    + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
	    + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
	    + "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
	    + "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
	    + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
	    + "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
	    + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
	    + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
	    + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
	    + "|height|src|*],map[name],area[shape|coords|href|alt|target],bdo,"
	    + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
	    + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
	    + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
	    + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
	    + "q[cite],samp,select[disabled|multiple|name|size],small,"
	    + "textarea[cols|rows|disabled|name|readonly],tt,var,big, php",

	    extended_valid_elements : "a[name|href|target|title|onclick],iframe[height|width|src],"
	    +"img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],"
	    +"hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style], ?php",
	    valid_children : "+body[style], +span[style]",
	    inline_styles : true,
	    verify_html : false
	});
	
	$('.image-in-modal').click(function(){
		var url = $.trim($(this).attr('url'));
		var tmpUrl = $.trim($(this).attr('tmpUrl'));
		var imageName = $.trim($('#image-name').text());
		if(url.length <= 0) url = tmpUrl;
		var content = '<img src="'+url+imageName+'"/>'; 
		loadModal(content);
	});
	
	$('#grades-modal').live('click', function(){
        var url = '/grades/ajax-show-grades';
        //$('.lastest-news-content').append('<div class="loading-news"><img src="/images/preloading.gif"/><div>');
        var grades = $('#TeachableInClass').attr('subs');
        if($.trim(grades) != '')  url += '/cgrades/'+grades;
        $.ajax({
            url : url,
            method: 'get',
            success : function(data){
                loadModal(data);
            }
        });
    });
    
    $('#subjects-modal').live('click', function(){
        var url = '/subjects/ajax-show-subjects';
        //$('.lastest-news-content').append('<div class="loading-news"><img src="/images/preloading.gif"/><div>');
        var subjects = $('#TeachableSubjects').attr('subs');
        if($.trim(subjects) != '')  url += '/csubjects/'+subjects;
        $.ajax({
            url : url,
            method: 'get',
            success : function(data){
                loadModal(data);
            }
        });
    });
    
    $('#districts-modal').live('click', function(){
        var url = '/districts/ajax-show-districts';
        //$('.lastest-news-content').append('<div class="loading-news"><img src="/images/preloading.gif"/><div>');
        var districts = $('#TeachableDistricts').attr('subs');
        if($.trim(districts) != '')  url += '/cdistricts/'+districts;
        $.ajax({
            url : url,
            method: 'get',
            success : function(data){
                loadModal(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    });
	
	$("form#frmImage").submit( function(eventObj) {
		var oldImageName = $.trim($('#image-name').attr('old-image-name'));
		var imageName = $.trim($('#image-name').text());
		
	      $('<input />').attr('type', 'hidden')
	          .attr('name', "OldImageName")
	          .attr('value', oldImageName)
	          .appendTo('form#frmImage');
	      
	      $('<input />').attr('type', 'hidden')
          .attr('name', "Avatar")
          .attr('value', imageName)
          .appendTo('form#frmImage');
	      
	      var grades = $.trim($('#TeachableInClass').attr('subs'));
	    	var gradesText = $.trim($('#TeachableInClass').val());
	    	
			var subjects = $.trim($('#TeachableSubjects').attr('subs'));
			var subjectsText = $.trim($('#TeachableSubjects').val());
			
			var districts = $.trim($('#TeachableDistricts').attr('subs'));
			var districtsText = $.trim($('#TeachableDistricts').val());
			
		      $('<input />').attr('type', 'hidden')
		          .attr('name', "TeachableInClass")
		          .attr('value', grades)
		          .appendTo('form#frmImage');
		      
		      $('<input />').attr('type', 'hidden')
	          .attr('name', "TeachableSubjects")
	          .attr('value', subjects)
	          .appendTo('form#frmImage');
		      
		      $('<input />').attr('type', 'hidden')
	          .attr('name', "TeachableDistricts")
	          .attr('value', districts)
	          .appendTo('form#frmImage');
		      
		      $('<input />').attr('type', 'hidden')
	          .attr('name', "TeachableInClassText")
	          .attr('value', gradesText)
	          .appendTo('form#frmImage');
		      
		      $('<input />').attr('type', 'hidden')
	          .attr('name', "TeachableSubjectsText")
	          .attr('value', subjectsText)
	          .appendTo('form#frmImage');
		      
		      $('<input />').attr('type', 'hidden')
	          .attr('name', "TeachableDistrictsText")
	          .attr('value', districtsText)
	          .appendTo('form#frmImage');
		      
	      return true;
	  });		
});
/*
 * 
 * 
 */