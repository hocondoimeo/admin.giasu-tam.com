$(document).ready(function() {
    $('#tutors-modal').live('click', function(){
        var url = '/tutors/ajax-show-tutors';
        //$('.lastest-news-content').append('<div class="loading-news"><img src="/images/preloading.gif"/><div>');
        var tutors = $('#ClassTutors').val();
        if($.trim(tutors) != '')  url += '/ctutors/'+tutors;
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
        var subjects = $('#ClassSubjects').attr('subs');
        if($.trim(subjects) != '')  url += '/csubjects/'+subjects;
        $.ajax({
            url : url,
            method: 'get',
            success : function(data){
                loadModal(data);
            }
        });
    });
    
    $("form#frmClass").submit( function(eventObj) {
		var tutors = $.trim($('#ClassTutors').val());
		var subjects = $.trim($('#ClassSubjects').attr('subs'));
		var subjectsText = $.trim($('#ClassSubjects').val());
		
	      $('<input />').attr('type', 'hidden')
	          .attr('name', "ClassTutors")
	          .attr('value', tutors)
	          .appendTo('form#frmClass');
	      
	      $('<input />').attr('type', 'hidden')
          .attr('name', "ClassSubjects")
          .attr('value', subjects)
          .appendTo('form#frmClass');
	      
	      $('<input />').attr('type', 'hidden')
          .attr('name', "ClassSubjectsText")
          .attr('value', subjectsText)
          .appendTo('form#frmClass');
	      
	      return true;
	  });
});

function loadPage(url, page){
    $('.load-content').html('<img src="/images/icons/preloading.gif"/>');
    $.ajax({
        url : url,
        method: 'get',
        success : function(data){
            $('.load-content').html(data);
            //if(!$('div.lastest-news-content').hasClass('active-read-more-news'))
               // $('div.lastest-news-content').addClass('active-read-more-news');
            //makeTwoDivSameHeight();

            if(typeof page != 'undefined' && $.isNumeric(page)){
                var currentPage = page;
                $('div.paginationControl').attr('current-page',currentPage);
            }
        }
    });
}