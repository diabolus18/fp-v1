
	//read href attr in a tag
	function readHref(){
		var mypath = arguments[0].replace("index.php/","");
		var baseurl	=	CS.QuickView.BASE_URL;
		var newpath	=	mypath.replace(baseurl,"");
		newpath		=	newpath.replace(/\//gi,"_!_");
		return newpath;
	}

	//string trim
	function strTrim(){
		return arguments[0].replace(/^\s+|\s+$/g,"");
	}

	function _csJnit(IS,n){
		if(n>0)
		{
			var _qsHref = "<a id=\"cs_quickview_handler\" href=\"#\" style=\"visibility:hidden;position:absolute;top:0;left:0;z-index:9999\"><img  alt=\"quickshop\" src=\""+CS.QuickView.QS_IMG+"\" /></a>";
			$(document.body).append(_qsHref);
			for(var i=0;i<n;i++)
			{
				
				var selectorObj = IS[i];
					//selector chon tat ca cac li chua san pham tren luoi
				var listprod = $(selectorObj.itemClass);
				var qsImg;
				var mypath = 'index.php?fc=module&module=csquickview&controller=csproduct';
				if(CS.QuickView.BASE_URL.indexOf('index.php') == -1){
					mypath = '?fc=module&module=csquickview&controller=csproduct';
				}
				var baseUrl = CS.QuickView.BASE_URL + mypath;
				
				var qsHandlerImg = $('#cs_quickview_handler img');

				$.each(listprod, function(index, value) { 
					var reloadurl = baseUrl;
					//get reload url
				var myhref;	
					myhref = $(value);
				if(myhref.attr('href').indexOf(".html")>0)
				{
					if (!myhref || myhref.length == 0) return;
					var prodHref = readHref(myhref.attr('href'));
					var arrProdHref=prodHref.split('_!_');
					var n=arrProdHref.length;
						prodHref=arrProdHref[n-1];
					var arrProdHref=prodHref.split('-');
					var product_id=arrProdHref[0];
					reloadurl=reloadurl+"&id_product="+product_id;
				}
				else
				{
				
					if (!myhref || myhref.length == 0) return;
					var prodHref = readHref(myhref.attr('href'));
					prodHref[0] == "\/" ? prodHref = prodHref.substring(1,prodHref.length) : prodHref;
					prodHref=strTrim(prodHref);
					var prodHref	=	prodHref.replace("index.php","");			
					var prodHref	=	prodHref.replace("&controller=product","");			
					var prodHref	=	prodHref.replace("?id_product","&id_product");			
					prodHref=strTrim(prodHref);
					reloadurl=reloadurl+prodHref;
					
				}
					//end reload url
					
					$('img', this).bind('mouseover', function() {
						var o = $(this).offset();
						$('#cs_quickview_handler').attr('href',reloadurl).show()
							.css({
								'top': o.top+($(this).height() - qsHandlerImg.height())/2+'px',
								'left': o.left+($(this).width() - qsHandlerImg.width())/2+'px',
								'visibility': 'visible'
							});
					});
					$(value).bind('mouseout', function() {
						$('#cs_quickview_handler').hide();
					});
				});

				//fix bug image disapper when hover
				$('#cs_quickview_handler')
					.bind('mouseover', function() {
						$(this).show();
					})
					.bind('click', function() {
						$(this).hide();
					});
				//insert quickshop popup
				
				$('#cs_quickview_handler').fancybox({
						'width'				: CS.QuickView.QS_FRM_WIDTH,
						'height'			: CS.QuickView.QS_FRM_HEIGHT,
						'autoScale'			: false,
						'padding'			: 0,
						'margin'			: 0,
						'type'				: 'iframe',
						onComplete: function() { 
							$.fancybox.showActivity();
							$('#fancybox-frame').unbind('load');
							$('#fancybox-frame').bind('load', function() {
								$.fancybox.hideActivity();
							});
						}
				});
			}
		}
	}
	//end base function
	function updateBlockCart()
	{
		setTimeout(function () {
			$('#shopping_cart a').css('border-radius', '3px');
			$("#cart_block").stop(true, true).slideDown(100);
			$("html, body").animate({ scrollTop: 0 },300);		
        },500);
		setTimeout(function () {
			$("#cart_block").stop(true, true).slideUp(500);
        },5000);
		
	}
$(window).ready(function(){
	_csJnit(IS,n);
	}
);



