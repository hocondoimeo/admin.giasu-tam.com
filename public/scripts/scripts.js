var CommonV2 = {
        /**
        * Page: Show all
        * Filter value by field (Use in list page)
        * Redirect when create link finished
        */    
        filter: function (val, field){
            
            var _href = window.location.href;    

            var _tab ='';
            
            indexOf = _href.indexOf("#");
            if(indexOf != -1){
                _tab = _href.substring(indexOf);
                _href = _href.substring(0,indexOf);                
            }
            
            _href = _href.replace(/(\/$)/,"") + "/";
            _href = _href.replace(new RegExp(field + '/[^/]+/', 'gi'),"");
        
            if ($.trim(val) != ''){
                _href = _href + field + '/' + val;
            }
            

            window.location = _href + _tab;
        },
        search: function (val, field){
            var _href = window.location.href;
            var _tab ='';
            
            indexOf = _href.indexOf("#");
            if(indexOf != -1){
                _tab = _href.substring(indexOf);
                _href = _href.substring(0,indexOf);                
            }
            
            _href = _href.replace(/(\/$)/,"") + "/";
            _href = _href.replace(/(keywords\/[^\/]*\/)|(fieldsearch\/[^\/]+\/)/ig,"");
            _href = _href + 'keywords/'+ encodeURIComponent(val) + '/fieldsearch/'+ field;
            
             window.location = _href + _tab;
        },
        /**
         * Page: Show all
         * Quick update 01 field
         */    
        quickUpadte: function (controller, id, field, obj) {
            if(CurrentElement.valueBefore != obj.value){
                newValue = (obj.value == 'NaN') ? null : obj.value;        
                $.post( "/" + controller + "/update-field" , { field: field, id: id, value: newValue },    function(data){
                    if(!$('.quick-update-box').html()){
                        $('body').append('<div class="quick-update-box"></div>');
                    }                
                    if(data.error){ 
                        $('<div class="quick-update-box-sub error">'+data.message+'</div>').appendTo('.quick-update-box').animate({ opacity : 1.0 }, 3000).fadeOut();;
                        $(obj).css('background', '#FBC2C4');
                    }else {
                        $('<div class="quick-update-box-sub success">'+data.message+'</div>').appendTo('.quick-update-box').animate({ opacity : 1.0 }, 3000).fadeOut();;
                        $(obj).css('background', '#C6D880');
                    }
                    
                },'json');
            }
        }    
     }



$(function(){
	/* Search */	
    $('form.quick-search-v2').submit(function() {
        $kw = $(this).find('input[name="keywords"]');
        if( "" == $.trim($kw.val())){
            $kw.css({border:"2px solid red"}).focus();
        } else {
            CommonV2.search($.trim($(this).find('input[name="keywords"]').val()), $(this).find('select[name="fieldsearch"]').val());
        }
        return false;
    });
    
});

/**
 * @desc load javascript or css file
 * @param string filename: file name, string filetype: 'js' or 'css'
 * eg: loadJsOrCssFile("myscript.js", "js") //dynamically load and add this .js file
 * eg: loadJsOrCssFile("javascript.php", "js") //dynamically load "javascript.php" as a JavaScript file
 * eg: loadJsOrCssFile("mystyle.css", "css") ////dynamically load and add this .css file
 * @author duy.ngo
 */
function loadJsOrCssFile(filename, filetype){
    if (filetype=="js"){ //if filename is a external JavaScript file
        var fileref=document.createElement('script')
        fileref.setAttribute("type","text/javascript")
        fileref.setAttribute("src", filename)
    }
    else if (filetype=="css"){ //if filename is an external CSS file
        var fileref=document.createElement("link")
        fileref.setAttribute("rel", "stylesheet")
        fileref.setAttribute("type", "text/css")
        fileref.setAttribute("href", filename)
    }
    if (typeof fileref!="undefined")
        document.getElementsByTagName("head")[0].appendChild(fileref)
}

/**
 * @desc load modal 
 * @param string content
 * @author duy.ngo
 */
function loadModal(content){
	var html = '<div id="loadModal" class="modal fade" role="dialog">';
	html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="close">x</button>';
	html += '<center style="padding: 10px;">'+content+'</center></div>'; 
	$('#loadModal').remove();
	$('body').append(html);
	$('#loadModal').modal();
}
