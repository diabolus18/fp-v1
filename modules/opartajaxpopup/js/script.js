function loadContent(popId,contentId,contentType) {
	$('#'+popId).append('<div id="opartajaxpopuploading"><img src="/modules/opartajaxpopup/img/ajax-loader.gif" alt="" /></div>').show('slow'); 
    $.ajax({ 
    	type : 'POST', 
        url : baseDir+'modules/opartajaxpopup/loadcontent.php',
        data: 'id='+contentId+'&type='+contentType,
        success : function(data){ 
        	$('#opartajaxpopuploading').hide(); 
            $('#'+popId).append(data); 
        }, error : function(XMLHttpRequest, textStatus, errorThrown) { 
            $('#opartajaxpopuploading').hide(); 
            $('#'+popId).append('Une erreur est survenue !'); 
        }
    });
}

function showOpartAjaxPopup(contentId,popWidth,popHeight,contentType,percent) {
	$('body').append('<div id="opartajaxpopup"></div>');
	var popId="opartajaxpopup";
	opartAjaxPopupOpen=true;
	var unit=(percent==1)?'%':'px';
	contentType=(contentType=="undefined")?null:contentType;
	$('#' + popId).addClass("opartajaxpopup_block");
	$('#' + popId).fadeIn().css({
		'width': Number(popWidth)+unit,
		'height': Number(popHeight)+unit
	})
	.html('<a href="#" class="opartajaxpopup_close"><img src="'+baseDir+'modules/opartajaxpopup/img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a><div id="opartajaxpopupcontent"></div>');

	var popTop = ($(window).height()-$('#' + popId).outerHeight())/2
	var popLeft = ($(window).width()-$('#' + popId).outerWidth())/2
	
	$('#' + popId).css({
		'top' : popTop+"px",
		'left' : popLeft+"px"
	});
	
	$('body').append('<div id="opartajaxpopup_fade"></div>');
	$('#opartajaxpopup_fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
	
	$('body').append('');	
	$('opartajaxpopup_fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();

	loadContent("opartajaxpopupcontent",contentId,contentType);
	
	return false;
}

function setOpartAjaxPopupPos(popId) {
	var popTop = ($(window).height()-$('#' + popId).outerHeight())/2
	var popLeft = ($(window).width()-$('#' + popId).outerWidth())/2
	
	$('#' + popId).css({
		'top' : popTop+"px",
		'left' : popLeft+"px"
	});
}

opartAjaxPopupOpen=false;

$('a.opartajaxpopup_close, #opartajaxpopup_fade').live('click', function() {
	$('#opartajaxpopup_fade , .opartajaxpopup_block').fadeOut(function() {
		$('#opartajaxpopup_fade, a.opartajaxpopup_close, #opartajaxpopup').remove();
		opartAjaxPopupOpen=false;
	});
	$('#opartajaxpopup').html('');
	return false;
});
$(window).resize(function() {	
	if(opartAjaxPopupOpen==true) 
		setOpartAjaxPopupPos("opartajaxpopupcontent");
	
});