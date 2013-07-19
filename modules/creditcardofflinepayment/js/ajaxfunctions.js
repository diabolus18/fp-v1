//when document is loaded...
$(document).ready(function(){
	/*if (typeof baseUri === "undefined" && typeof baseDir !== "undefined")
	baseUri = baseDir;*/
	//Function to delete credit card data from order
	$('#deleteInfo').click(function(){
		$.ajax({
			type: 'POST',
			url: 'http://test.idnovate.com/jose/ps1531/modules/creditcardofflinepayment/creditcardofflinepaymentfunctions.php',
			async: true,
			cache: false,
			dataType : "json",
			data: 'id_order=' + $("input[name=id_order]").val() + '&ajax=true',
			success: function() {alert('Great!');},
			error: function() {alert('ERROR: unable to delete the info');}
		})
	})
});