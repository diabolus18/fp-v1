function url_decode(str) {
     return unescape(str.replace(/\+/g, " "));
}
Encoder = {

	/* When encoding do we convert characters into html or numerical entities */
	EncodeType : "entity",  /* entity OR numerical*/

	isEmpty : function(val){
		if(val){
			return ((val===null) || val.length==0 || /^\s+$/.test(val));
		}else{
			return true;
		}
	},
	/* Convert HTML entities into numerical entities */
	HTML2Numerical : function(s){
		var arr1 = new Array('&nbsp;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&agrave;','&aacute;','&acirc;','&atilde;','&Auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&Ouml;','&times;','&oslash;','&ugrave;','&uacute;','&ucirc;','&Uuml;','&yacute;','&thorn;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&quot;','&amp;','&lt;','&gt;','&oelig;','&oelig;','&scaron;','&scaron;','&yuml;','&circ;','&tilde;','&ensp;','&emsp;','&thinsp;','&zwnj;','&zwj;','&lrm;','&rlm;','&ndash;','&mdash;','&lsquo;','&rsquo;','&sbquo;','&ldquo;','&rdquo;','&bdquo;','&dagger;','&dagger;','&permil;','&lsaquo;','&rsaquo;','&euro;','&fnof;','&alpha;','&beta;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&theta;','&iota;','&kappa;','&lambda;','&mu;','&nu;','&xi;','&omicron;','&pi;','&rho;','&sigma;','&tau;','&upsilon;','&phi;','&chi;','&psi;','&omega;','&alpha;','&beta;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&theta;','&iota;','&kappa;','&lambda;','&mu;','&nu;','&xi;','&omicron;','&pi;','&rho;','&sigmaf;','&sigma;','&tau;','&upsilon;','&phi;','&chi;','&psi;','&omega;','&thetasym;','&upsih;','&piv;','&bull;','&hellip;','&prime;','&prime;','&oline;','&frasl;','&weierp;','&image;','&real;','&trade;','&alefsym;','&larr;','&uarr;','&rarr;','&darr;','&harr;','&crarr;','&larr;','&uarr;','&rarr;','&darr;','&harr;','&forall;','&part;','&exist;','&empty;','&nabla;','&isin;','&notin;','&ni;','&prod;','&sum;','&minus;','&lowast;','&radic;','&prop;','&infin;','&ang;','&and;','&or;','&cap;','&cup;','&int;','&there4;','&sim;','&cong;','&asymp;','&ne;','&equiv;','&le;','&ge;','&sub;','&sup;','&nsub;','&sube;','&supe;','&oplus;','&otimes;','&perp;','&sdot;','&lceil;','&rceil;','&lfloor;','&rfloor;','&lang;','&rang;','&loz;','&spades;','&clubs;','&hearts;','&diams;');
		var arr2 = new Array('&#160;','&#161;','&#162;','&#163;','&#164;','&#165;','&#166;','&#167;','&#168;','&#169;','&#170;','&#171;','&#172;','&#173;','&#174;','&#175;','&#176;','&#177;','&#178;','&#179;','&#180;','&#181;','&#182;','&#183;','&#184;','&#185;','&#186;','&#187;','&#188;','&#189;','&#190;','&#191;','&#192;','&#193;','&#194;','&#195;','&#196;','&#197;','&#198;','&#199;','&#200;','&#201;','&#202;','&#203;','&#204;','&#205;','&#206;','&#207;','&#208;','&#209;','&#210;','&#211;','&#212;','&#213;','&#214;','&#215;','&#216;','&#217;','&#218;','&#219;','&#220;','&#221;','&#222;','&#223;','&#224;','&#225;','&#226;','&#227;','&#228;','&#229;','&#230;','&#231;','&#232;','&#233;','&#234;','&#235;','&#236;','&#237;','&#238;','&#239;','&#240;','&#241;','&#242;','&#243;','&#244;','&#245;','&#246;','&#247;','&#248;','&#249;','&#250;','&#251;','&#252;','&#253;','&#254;','&#255;','&#34;','&#38;','&#60;','&#62;','&#338;','&#339;','&#352;','&#353;','&#376;','&#710;','&#732;','&#8194;','&#8195;','&#8201;','&#8204;','&#8205;','&#8206;','&#8207;','&#8211;','&#8212;','&#8216;','&#8217;','&#8218;','&#8220;','&#8221;','&#8222;','&#8224;','&#8225;','&#8240;','&#8249;','&#8250;','&#8364;','&#402;','&#913;','&#914;','&#915;','&#916;','&#917;','&#918;','&#919;','&#920;','&#921;','&#922;','&#923;','&#924;','&#925;','&#926;','&#927;','&#928;','&#929;','&#931;','&#932;','&#933;','&#934;','&#935;','&#936;','&#937;','&#945;','&#946;','&#947;','&#948;','&#949;','&#950;','&#951;','&#952;','&#953;','&#954;','&#955;','&#956;','&#957;','&#958;','&#959;','&#960;','&#961;','&#962;','&#963;','&#964;','&#965;','&#966;','&#967;','&#968;','&#969;','&#977;','&#978;','&#982;','&#8226;','&#8230;','&#8242;','&#8243;','&#8254;','&#8260;','&#8472;','&#8465;','&#8476;','&#8482;','&#8501;','&#8592;','&#8593;','&#8594;','&#8595;','&#8596;','&#8629;','&#8656;','&#8657;','&#8658;','&#8659;','&#8660;','&#8704;','&#8706;','&#8707;','&#8709;','&#8711;','&#8712;','&#8713;','&#8715;','&#8719;','&#8721;','&#8722;','&#8727;','&#8730;','&#8733;','&#8734;','&#8736;','&#8743;','&#8744;','&#8745;','&#8746;','&#8747;','&#8756;','&#8764;','&#8773;','&#8776;','&#8800;','&#8801;','&#8804;','&#8805;','&#8834;','&#8835;','&#8836;','&#8838;','&#8839;','&#8853;','&#8855;','&#8869;','&#8901;','&#8968;','&#8969;','&#8970;','&#8971;','&#9001;','&#9002;','&#9674;','&#9824;','&#9827;','&#9829;','&#9830;');
		return this.swapArrayVals(s,arr1,arr2);
	},	

	/* Convert Numerical entities into HTML entities */
	NumericalToHTML : function(s){
		var arr1 = new Array('&#160;','&#161;','&#162;','&#163;','&#164;','&#165;','&#166;','&#167;','&#168;','&#169;','&#170;','&#171;','&#172;','&#173;','&#174;','&#175;','&#176;','&#177;','&#178;','&#179;','&#180;','&#181;','&#182;','&#183;','&#184;','&#185;','&#186;','&#187;','&#188;','&#189;','&#190;','&#191;','&#192;','&#193;','&#194;','&#195;','&#196;','&#197;','&#198;','&#199;','&#200;','&#201;','&#202;','&#203;','&#204;','&#205;','&#206;','&#207;','&#208;','&#209;','&#210;','&#211;','&#212;','&#213;','&#214;','&#215;','&#216;','&#217;','&#218;','&#219;','&#220;','&#221;','&#222;','&#223;','&#224;','&#225;','&#226;','&#227;','&#228;','&#229;','&#230;','&#231;','&#232;','&#233;','&#234;','&#235;','&#236;','&#237;','&#238;','&#239;','&#240;','&#241;','&#242;','&#243;','&#244;','&#245;','&#246;','&#247;','&#248;','&#249;','&#250;','&#251;','&#252;','&#253;','&#254;','&#255;','&#34;','&#38;','&#60;','&#62;','&#338;','&#339;','&#352;','&#353;','&#376;','&#710;','&#732;','&#8194;','&#8195;','&#8201;','&#8204;','&#8205;','&#8206;','&#8207;','&#8211;','&#8212;','&#8216;','&#8217;','&#8218;','&#8220;','&#8221;','&#8222;','&#8224;','&#8225;','&#8240;','&#8249;','&#8250;','&#8364;','&#402;','&#913;','&#914;','&#915;','&#916;','&#917;','&#918;','&#919;','&#920;','&#921;','&#922;','&#923;','&#924;','&#925;','&#926;','&#927;','&#928;','&#929;','&#931;','&#932;','&#933;','&#934;','&#935;','&#936;','&#937;','&#945;','&#946;','&#947;','&#948;','&#949;','&#950;','&#951;','&#952;','&#953;','&#954;','&#955;','&#956;','&#957;','&#958;','&#959;','&#960;','&#961;','&#962;','&#963;','&#964;','&#965;','&#966;','&#967;','&#968;','&#969;','&#977;','&#978;','&#982;','&#8226;','&#8230;','&#8242;','&#8243;','&#8254;','&#8260;','&#8472;','&#8465;','&#8476;','&#8482;','&#8501;','&#8592;','&#8593;','&#8594;','&#8595;','&#8596;','&#8629;','&#8656;','&#8657;','&#8658;','&#8659;','&#8660;','&#8704;','&#8706;','&#8707;','&#8709;','&#8711;','&#8712;','&#8713;','&#8715;','&#8719;','&#8721;','&#8722;','&#8727;','&#8730;','&#8733;','&#8734;','&#8736;','&#8743;','&#8744;','&#8745;','&#8746;','&#8747;','&#8756;','&#8764;','&#8773;','&#8776;','&#8800;','&#8801;','&#8804;','&#8805;','&#8834;','&#8835;','&#8836;','&#8838;','&#8839;','&#8853;','&#8855;','&#8869;','&#8901;','&#8968;','&#8969;','&#8970;','&#8971;','&#9001;','&#9002;','&#9674;','&#9824;','&#9827;','&#9829;','&#9830;');
		var arr2 = new Array('&nbsp;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&agrave;','&aacute;','&acirc;','&atilde;','&Auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&Ouml;','&times;','&oslash;','&ugrave;','&uacute;','&ucirc;','&Uuml;','&yacute;','&thorn;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&quot;','&amp;','&lt;','&gt;','&oelig;','&oelig;','&scaron;','&scaron;','&yuml;','&circ;','&tilde;','&ensp;','&emsp;','&thinsp;','&zwnj;','&zwj;','&lrm;','&rlm;','&ndash;','&mdash;','&lsquo;','&rsquo;','&sbquo;','&ldquo;','&rdquo;','&bdquo;','&dagger;','&dagger;','&permil;','&lsaquo;','&rsaquo;','&euro;','&fnof;','&alpha;','&beta;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&theta;','&iota;','&kappa;','&lambda;','&mu;','&nu;','&xi;','&omicron;','&pi;','&rho;','&sigma;','&tau;','&upsilon;','&phi;','&chi;','&psi;','&omega;','&alpha;','&beta;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&theta;','&iota;','&kappa;','&lambda;','&mu;','&nu;','&xi;','&omicron;','&pi;','&rho;','&sigmaf;','&sigma;','&tau;','&upsilon;','&phi;','&chi;','&psi;','&omega;','&thetasym;','&upsih;','&piv;','&bull;','&hellip;','&prime;','&prime;','&oline;','&frasl;','&weierp;','&image;','&real;','&trade;','&alefsym;','&larr;','&uarr;','&rarr;','&darr;','&harr;','&crarr;','&larr;','&uarr;','&rarr;','&darr;','&harr;','&forall;','&part;','&exist;','&empty;','&nabla;','&isin;','&notin;','&ni;','&prod;','&sum;','&minus;','&lowast;','&radic;','&prop;','&infin;','&ang;','&and;','&or;','&cap;','&cup;','&int;','&there4;','&sim;','&cong;','&asymp;','&ne;','&equiv;','&le;','&ge;','&sub;','&sup;','&nsub;','&sube;','&supe;','&oplus;','&otimes;','&perp;','&sdot;','&lceil;','&rceil;','&lfloor;','&rfloor;','&lang;','&rang;','&loz;','&spades;','&clubs;','&hearts;','&diams;');
		return this.swapArrayVals(s,arr1,arr2);
	},


	/* Numerically encodes all unicode characters */
	numEncode : function(s){
		
		if(this.isEmpty(s)) return "";

		var e = "";
		for (var i = 0; i < s.length; i++)
		{
			var c = s.charAt(i);
			if (c < " " || c > "~")
			{
				c = "&#" + c.charCodeAt() + ";";
			}
			e += c;
		}
		return e;
	},
	
	/* HTML Decode numerical and HTML entities back to original values */
	htmlDecode : function(s){

		var c,m,d = s;
		
		if(this.isEmpty(d)) return "";

		/* convert HTML entites back to numerical entites first */
		d = this.HTML2Numerical(d);
		
		/* look for numerical entities &#34; */
		arr=d.match(/&#[0-9]{1,5};/g);
		
		/* if no matches found in string then skip */
		if(arr!=null){
			for(var x=0;x<arr.length;x++){
				m = arr[x];
				c = m.substring(2,m.length-1); /*get numeric part which is refernce to unicode character */
				/* if its a valid number we can decode */
				if(c >= -32768 && c <= 65535){
					/* decode every single match within string */
					d = d.replace(m, String.fromCharCode(c));
				}else{
					d = d.replace(m, ""); /*invalid so replace with nada */
				}
			}			
		}

		return d;
	},		

	/* encode an input string into either numerical or HTML entities */
	htmlEncode : function(s,dbl){
			
		if(this.isEmpty(s)) return "";

		/* do we allow double encoding? E.g will &amp; be turned into &amp;amp; */
		dbl = dbl | false; //default to prevent double encoding
		
		/* if allowing double encoding we do ampersands first */
		if(dbl){
			if(this.EncodeType=="numerical"){
				s = s.replace(/&/g, "&#38;");
			}else{
				s = s.replace(/&/g, "&amp;");
			}
		}

		/* convert the xss chars to numerical entities ' " < > */
		s = this.XSSEncode(s,false);
		
		if(this.EncodeType=="numerical" || !dbl){
			/* Now call function that will convert any HTML entities to numerical codes */
			s = this.HTML2Numerical(s);
		}

		/* Now encode all chars above 127 e.g unicode */
		s = this.numEncode(s);

		/* now we know anything that needs to be encoded has been converted to numerical entities we
		// can encode any ampersands & that are not part of encoded entities
		// to handle the fact that I need to do a negative check and handle multiple ampersands &&&
		// I am going to use a placeholder

		// if we don't want double encoded entities we ignore the & in existing entities */
		if(!dbl){
			s = s.replace(/&#/g,"##AMPHASH##");
		
			if(this.EncodeType=="numerical"){
				s = s.replace(/&/g, "&#38;");
			}else{
				s = s.replace(/&/g, "&amp;");
			}

			s = s.replace(/##AMPHASH##/g,"&#");
		}
		
		/* replace any malformed entities */
		s = s.replace(/&#\d*([^\d;]|$)/g, "$1");

		if(!dbl){
			/* safety check to correct any double encoded &amp; */
			s = this.correctEncoding(s);
		}

		/* now do we need to convert our numerical encoded string into entities */
		if(this.EncodeType=="entity"){
			s = this.NumericalToHTML(s);
		}

		return s;					
	},

	/* Encodes the basic 4 characters used to malform HTML in XSS hacks */
	XSSEncode : function(s,en){
		if(!this.isEmpty(s)){
			en = en || true;
			/* do we convert to numerical or html entity? */
			if(en){
				s = s.replace(/\'/g,"&#39;"); /* no HTML equivalent as &apos is not cross browser supported */
				s = s.replace(/\"/g,"&quot;");
				s = s.replace(/</g,"&lt;");
				s = s.replace(/>/g,"&gt;");
			}else{
				s = s.replace(/\'/g,"&#39;"); /* no HTML equivalent as &apos is not cross browser supported */
				s = s.replace(/\"/g,"&#34;");
				s = s.replace(/</g,"&#60;");
				s = s.replace(/>/g,"&#62;");
			}
			return s;
		}else{
			return "";
		}
	},

	/* returns true if a string contains html or numerical encoded entities */
	hasEncoded : function(s){
		if(/&#[0-9]{1,5};/g.test(s)){
			return true;
		}else if(/&[A-Z]{2,6};/gi.test(s)){
			return true;
		}else{
			return false;
		}
	},

	/* will remove any unicode characters */
	stripUnicode : function(s){
		return s.replace(/[^\x20-\x7E]/g,"");
		
	},

	/* corrects any double encoded &amp; entities e.g &amp;amp; */
	correctEncoding : function(s){
		return s.replace(/(&amp;)(amp;)+/,"$1");
	},


	/* Function to loop through an array swaping each item with the value from another array e.g swap HTML entities with Numericals */
	swapArrayVals : function(s,arr1,arr2){
		if(this.isEmpty(s)) return "";
		var re;
		if(arr1 && arr2){
			/*ShowDebug("in swapArrayVals arr1.length = " + arr1.length + " arr2.length = " + arr2.length)
			// array lengths must match */
			if(arr1.length == arr2.length){
				for(var x=0,i=arr1.length;x<i;x++){
					re = new RegExp(arr1[x], 'g');
					s = s.replace(re,arr2[x]); /*swap arr1 item with matching item from arr2 */	
				}
			}
		}
		return s;
	},

	inArray : function( item, arr ) {
		for ( var i = 0, x = arr.length; i < x; i++ ){
			if ( arr[i] === item ){
				return i;
			}
		}
		return -1;
	}

}

var awp_quantity = 0;
var awp_curr_prices = null;


function awp_select(group,attribute, currency, first)
{
	/*if (first) 
	//return false;
	alert("awp_select("+group+","+attribute+","+first);*/
	if (awp_group_type[group] == "file" && attribute != parseInt(attribute))
	{
		var awp_file_arr = attribute.split('_');
		attribute = awp_file_arr[1];
	}
	/*alert(group + " - "+ attribute + " = "+awp_selected_groups.toString())
	 //if (awp_no_tax_impact) 
		// displayPrice = 1;
	// Get Current price based on all selected attributes //
	First time the page loads, only get the prices one time */
	if (awp_curr_prices == null || !first)
	{
		awp_curr_prices = awp_price_update();
	}
	/* alert(awp_curr_prices['priceProduct']); */
	var curr_price = awp_curr_prices['priceProduct'];
	/* alert(group + " - "+ attribute + " = "+curr_price)
	// Change product image based on attribute, and change "Customize" to add to cart// */
	if (!first)
	{
		awp_select_image(attribute);
		if ($('#awp_add_to_cart input').val() != awp_add_cart)
		{
			$('#awp_add_to_cart input').val(awp_add_cart);
			$('#awp_add_to_cart input').unbind('click').click(function(){
				awp_add_to_cart();
				return false;
			});
		}
	}
	/* alert(group+", "+attribute+", "+currency+", "+first); */
	var name = document.awp_wizard;
	var default_impact = parseFloat($("#pi_default_"+group).val());
	var current_impact = parseFloat(typeof awp_impact_list[attribute] != 'undefined'?awp_impact_list[attribute]:0);
	/* alert("1) " + awp_selected_groups[group]); */
	awp_selected_groups[group] = attribute;
	$("#pi_default_"+group).val(current_impact);
	$(".awp_group_class_"+group).each( function() {
		if ($(this).attr('checked') && $(this).val() != attribute && typeof awp_impact_list[$(this).val()] != 'undefined')
			current_impact += parseFloat(awp_impact_list[$(this).val()]);
	});
	if (awp_pi_display != "")
	{
		for (var id_attribute in awp_impact_list)
		{
			var id_group = awp_attr_to_group[id_attribute];
			var group_type = awp_group_type[id_group];
			/* No price impact for the group, can skip // */
			if (typeof awp_selected_groups[id_group] == 'undefined' || (awp_pi_display == "total" && awp_group_impact[id_group] != 1))//parseFloat(awp_impact_list[id_attribute]) == 0))
			{
				/* alert(id_group+" --------> "+id_attribute); */
				continue;
			}
			var tmp_attr = 0;
			/* alert(awp_selected_groups[id_group]); */
			if (awp_pi_display == "total" || (group_type != "checkbox" && awp_selected_groups[id_group] != 0))
			{
				/* alert("tmp_attr = " + awp_selected_groups[id_group] + " - "+id_group); */
				tmp_attr = awp_selected_groups[id_group];
			}
			else
			{
				/* alert("tmp_attr2 = " + id_attribute + " - "+id_group); */
				tmp_attr = id_attribute;
			}
			/* alert("tmp_attr = " + tmp_attr + awp_impact_list.toSource()); */
			current_impact = parseFloat(awp_impact_list[tmp_attr]);
			/* if (group_type == "file" && typeof awp_impact_list[tmp_attr] == 'undefined')
				//alert(current_impact + " == " + tmp_attr + " == " + id_attribute + " == " + awp_selected_groups[id_group]); */
			if (group_type == "calculation")
				current_impact = parseFloat(awp_impact_list[id_attribute]) * awp_selected_groups[id_group] / 1000000;
			/* alert(id_attribute + ") " + tmp_attr + " - " + current_impact)
			//alert(is_checkbox + " | " +id_group + " --->>> " + id_attribute + " = " + tmp_attr + " == " +current_impact);
			
			// Only change the price impact for the current group
			// except when running for the first time, of when price impact is set to total
			//alert(awp_group_impact[id_group] + " == 1 && " + id_group + "  ==  "+group); */
			if ((awp_group_impact[id_group] == 1 && id_group == group && (awp_pi_display != "total" || first))
					||
				(awp_pi_display == "total" && (!first || awp_group_impact[id_group] == 1)))
			{
				var selected = document.getElementById("awp_group_"+id_group)?document.getElementById("awp_group_"+id_group).selectedIndex:0;
				var select_group = false;
				/* if (!first)
					//alert(group +" - "+ id_attribute); */
				var html = " ";
				/* if ($("#awp_group_per_row_"+id_group).val() > 1 && $("#awp_group_layout_"+id_group).val() == 1 && awp_hin[id_group] != 1)
					//html = "<br />";
				// Displaying price difference */
				if (awp_pi_display == "diff")
				{
					var itr_impact = awp_impact_list[id_attribute];
					/*if (group_type == "file")
						//alert(id_attribute+" === "+awp_impact_list[id_attribute] +" == " + current_impact);
					//alert(id_attribute + " - " + tmp_attr + " - " + current_impact + " <> " +itr_impact); */
					var awp_new_price = 0;
					/* Current impact smaller, Show Add */
					if (current_impact < itr_impact)
					{
						awp_new_price = (Math.ceil(Math.abs(current_impact - itr_impact)) == Math.abs(current_impact - itr_impact)?Math.abs(current_impact - itr_impact):Math.abs(current_impact - itr_impact));
						if (typeof displayPrice != 'undefined' && displayPrice == 1 && !awp_no_tax_impact && awp_psv < 1.4)
							awp_new_price = Math.ceil((awp_new_price / (1 + (taxRate / 100))) *100)/100
						else if (typeof displayPrice != 'undefined' && displayPrice != 1 && (awp_no_tax_impact || awp_psv >= 1.4))
							awp_new_price *= 1 + (taxRate / 100);
						awp_new_price *= ((100 - reduction_percent) / 100);
						/* alert(awp_new_price + " = " + currencyRate); */
						html += "["+awp_add+" "+ formatCurrency(awp_new_price * group_reduction * currencyRate, currencyFormat, currencySign, currencyBlank)+"]";
					}
					/* Current impact larger, Show Subtract  */
					else if (current_impact > itr_impact)
					{
						awp_new_price = (Math.ceil(Math.abs(itr_impact - current_impact)) == Math.abs(itr_impact - current_impact)?Math.abs(itr_impact - current_impact):Math.abs(itr_impact - current_impact));
						if (typeof displayPrice != 'undefined' && displayPrice == 1 && !awp_no_tax_impact && awp_psv < 1.4)
							awp_new_price = Math.ceil((awp_new_price / (1 + (taxRate / 100))) *100)/100
						else if (typeof displayPrice != 'undefined' && displayPrice != 1 && (awp_no_tax_impact || awp_psv >= 1.4))
							awp_new_price *= 1 + (taxRate / 100);
						awp_new_price *= ((100 - reduction_percent) / 100);
						/* alert(awp_new_price + " == " + currencyRate); */
						html += "["+awp_sub+" "+ formatCurrency(awp_new_price * group_reduction * currencyRate, currencyFormat, currencySign, currencyBlank)+"]";
					}
					/* Impact is the same, update price with tax + currency  */
					else if (current_impact != 0 && first && (current_impact != itr_impact || group_type == "checkbox" || group_type == "textarea" || group_type == "textbox" || group_type == "file"))// && id_attribute != attribute)
					{
						awp_new_price = Math.abs(current_impact);
						if (typeof displayPrice != 'undefined' && displayPrice == 1 && !awp_no_tax_impact && awp_psv < 1.4)
							awp_new_price = Math.ceil((awp_new_price / (1 + (taxRate / 100))) *100)/100
						else if (typeof displayPrice != 'undefined' && displayPrice != 1 && (awp_no_tax_impact || awp_psv >= 1.4))
							awp_new_price *= 1 + (taxRate / 100);
						awp_new_price *= ((100 - reduction_percent) / 100);
						/* alert(awp_new_price + " === " + currencyRate); */
						if (current_impact < 0)
							html += "["+awp_sub+" "+ formatCurrency(awp_new_price * group_reduction * currencyRate, currencyFormat, currencySign, currencyBlank)+"]";
						else
							html += "["+awp_add+" "+ formatCurrency(awp_new_price * group_reduction * currencyRate, currencyFormat, currencySign, currencyBlank)+"]";
						/* alert(html); */
					}
					else
					{
						/* alert(id_attribute+" = "+current_impact); */
					}
					/* alert(current_impact + " - " + itr_impact + " = " + html); */
				}
				/* Displaying Total price */
				else
				{
					var itr_impact = parseFloat(awp_impact_list[id_attribute]) * currencyRate;
					
					var att_selected = false;
					if (awp_selected_groups[id_group] == id_attribute)
						att_selected = true;
					/* if (!first)
						//alert(id_group+" --------> "+id_attribute+")  --- "+current_impact +" - "+ itr_impact + " == " +att_selected);
					//if ((group_type == "checkbox" && !$("#awp_checkbox_group_"+id_attribute).attr('checked')) || (true))
					//{ */
					if (itr_impact != 0 || awp_group_impact[id_group] == 1)
					{
						/* alert("awp_get_total_prices ("+id_group+","+id_attribute+") == "+curr_price+" === " + current_impact+ " - " + itr_impact); */
						var tmp_arr = new Array();
						var awp_new_price = 0;
						/* The following group types allow multiple selection, and require special calculation */
						if (group_type == "checkbox" || group_type == "file" || group_type == "textbox" || group_type == "textarea")
						{
							/* alert(curr_price + ") " + itr_impact + " + " +current_impact + " ("+id_attribute+" , "+attribute); */
							if (group_type == "checkbox" && !$("#awp_checkbox_group_"+id_attribute).attr('checked'))
								awp_new_price = itr_impact;
							else if (group_type == "textbox" && !$("#awp_textbox_group_"+id_attribute).val() != '')
								awp_new_price = itr_impact;
							else if (group_type == "file" && !$("#awp_file_group_"+id_attribute).val() != '')
								awp_new_price = itr_impact;
							else if (group_type == "textarea" && !$("#awp_textarea_group_"+id_attribute).val() != '')
								awp_new_price = itr_impact;
						/* alert("1.1) "+awp_new_price); */
						}
						else if (group_type == "quantity")
							awp_new_price = itr_impact;
						else if (current_impact < itr_impact)
						{
							awp_new_price = (itr_impact - current_impact);
						/* alert("1.2) "+awp_new_price); */
						}
						else if (current_impact > itr_impact)
						{
							awp_new_price =  (0 - current_impact + itr_impact);
						/* alert("1.3) "+awp_new_price); */
						}
						if (typeof displayPrice != 'undefined' && displayPrice == 1 && !awp_no_tax_impact && awp_psv < 1.4)
						{
							awp_new_price = Math.ceil((awp_new_price / (1 + (taxRate / 100))) *100)/100
						/* alert("1.4)"+displayPrice+" =  "+awp_new_price + " / " + taxRate); */
						}
						else if (typeof displayPrice != 'undefined' && displayPrice != 1 && (awp_no_tax_impact || awp_psv >= 1.4))
						{
							awp_new_price *= 1 + (taxRate / 100);
						/* alert("1.5) "+displayPrice+" =  "+awp_new_price + " / " + taxRate); */
						}
						awp_new_price *= ((100 - reduction_percent) / 100);
						awp_new_price *= group_reduction;
						/* alert("2) "+awp_new_price + " - " + curr_price); */
						awp_new_price += curr_price;
						awp_new_price = Math.max(awp_new_price,0);
						html += "["+formatCurrency(awp_new_price, currencyFormat, currencySign, currencyBlank)+"]";
					}
				}
				/* alert($("#price_change_"+id_attribute).length + " = " + id_attribute + " ->"+html); */
				if ($("#price_change_"+id_attribute).length != 0)
				{
					/*if (!first)
						//alert(id_group+" -> "+id_attribute+") "+current_impact +" ("+$("#awp_radio_group_"+id_attribute).attr('checked')+") - "+ itr_impact + " == " +html);
					//alert(id_attribute+ " - " + html); */
					if (first || awp_pi_display == "total" || (group_type != "checkbox" && group_type != "file" && group_type != "textbox" && group_type != "textarea"))
						$("#price_change_"+id_attribute).html(html.replace(" ","&nbsp;"));
				}
				else if (document.getElementById("awp_group_"+id_group) && document.getElementById("awp_group_"+id_group).options)
				{
					var currentSB = document.getElementById("awp_group_"+id_group);
					var sb_index = 0;
					var tmp_index = 0;
					var cur_class = "";
					$("#awp_group_"+id_group+" option").each(function() {
						if (id_attribute == $(this).val())
						{
							sb_index = tmp_index;
							cur_class = $(this).attr('class');
						}
						tmp_index++;
					});
					var current = document.getElementById("awp_group_"+id_group).options[sb_index].text;
					/* if (!first)
					//	alert(id_group+" -> "+id_attribute+" ["+sb_index+"]>> "+current_impact +" - "+ itr_impact + " ("+current+") == " +html);
					//alert(id_attribute + " = " + sb_index + " = " + current + " | "+ html); */
					if (current.indexOf("[") > 0)
						current = current.substring(0,current.indexOf("["));
					/* document.getElementById("awp_group_"+id_group).options[sb_index]=new Option(current+html, id_attribute) */
					$("#awp_group_"+id_group+" option:eq("+sb_index+")").text(current+html);
					document.getElementById("awp_group_"+id_group).selectedIndex = selected;
					/* alert("Select box " + split[4] + " -- " + current+html); */
					select_group = true;
				}
			}
		}
	}
	if (awp_group_type[group] != "dropdown")
		awp_center_images(group);
	else
		$(".awp_cell_cont_"+group).css('width','100%');
	if (document.getElementById('awp_price'))
		$("#awp_price").html($("#our_price_display").html())
	if (document.getElementById('awp_second_price'))
		$("#awp_second_price").html($("#our_price_display").html())
}

function awp_get_total_prices(awp_extra,tmp_productPriceWithoutReduction)
{
	var doa = false;
	productPriceWithoutReduction = tmp_productPriceWithoutReduction;
	awp_extra = parseFloat(awp_extra);
	var name = document.awp_wizard;
	var awp_total_impact = 0;
	var awp_total_weight = 0;
	var awp_total_impact_quantity = new Array();
	var awp_total_weight_quantity = new Array();
	var awp_total_quantity_quantity = new Array();
	var awp_quantity = 0;
	var awp_quantity_default = 0;
	var awp_min_quantity = 1;
	var awp_min_quantity_default = 1;
	var awp_first_default = true;
	var awp_first = true;
	/* alert ("start awp_get_total_prices"); */
	var loop = 0;
	$('.awp_box .awp_attribute_selected').each(function()
	{
		if (($(this).attr('type') != 'radio' || $(this).attr('checked')) &&
			($(this).attr('type') != 'checkbox' || $(this).attr('checked')) &&
			($(this).attr('type') != 'text' || $(this).val() != "0") &&
				$(this).val() != "")
		{
			var awp_arr = $(this).attr('name').split('_');
			var found = false;
			if ($(this).attr('type') != 'text' && $(this).attr('type') != 'textarea')
				for (key in awp_impact_list)
					if (key == $(this).val())
						found = true;
			/* alert($(this).attr('name') + " % " +$(this).attr('id') +" ("+awp_arr.length+" , "+found+") == " + $(this).val());*/
			if (found)
			{
				if (!awp_arr[2] || awp_group_type[awp_arr[2]] != "quantity") 
				{
					awp_total_impact += parseFloat(awp_impact_list[$(this).val()]);
					awp_total_weight += parseFloat(awp_weight_list[$(this).val()]);
				}
				if (awp_first || awp_quantity > parseInt(awp_qty_list[$(this).val()]))
				{
					/* alert(awp_quantity+" = "+parseInt(awp_qty_list[$(this).val()])+" --- "+$(this).val());*/
					awp_quantity = parseInt(awp_qty_list[$(this).val()]);
				}
				if (awp_first || awp_min_quantity < parseInt(awp_min_qty[$(this).val()]))
					awp_min_quantity = parseInt(awp_min_qty[$(this).val()]);
				awp_first = false;
				awp_selected_groups[awp_arr[2]] = $(this).val();
			}
			else 
			{
				if ($(this).val() != "" && awp_arr.length == 4)
				{	
					if (awp_group_type[awp_arr[2]] == "calculation")
					{
						alert("calc = "+awp_impact_list[awp_arr[3]]+" * " + $(this).val() + " * "+awp_multiply_list[awp_arr[3]]);
						awp_total_impact += parseFloat((awp_impact_list[awp_arr[3]] * $(this).val() * awp_multiply_list[awp_arr[3]])/1000000);
						awp_total_weight += parseFloat(awp_weight_list[awp_arr[3]]);
					}
					else if ((!awp_arr[2] || awp_group_type[awp_arr[2]] != "quantity")  && awp_impact_list[awp_arr[3]]) 
					{
						/* alert(awp_impact_list[awp_arr[3]]); */ 
						awp_total_impact += parseFloat(awp_impact_list[awp_arr[3]]);
						awp_total_weight += parseFloat(awp_weight_list[awp_arr[3]]);
					}
					if (awp_first || awp_quantity > parseInt(awp_qty_list[awp_arr[3]]))
					{
					/* alert(awp_quantity+" == "+parseInt(awp_qty_list[awp_arr[3]])+" --- "+awp_arr[3]); */
						awp_quantity = parseInt(awp_qty_list[awp_arr[3]]);
					}
					if (awp_first || awp_min_quantity < parseInt(awp_min_qty[awp_arr[3]]))
						awp_min_quantity = parseInt(awp_min_qty[awp_arr[3]]);
					awp_first = false;
					awp_selected_groups[awp_arr[2]] = awp_arr[3];
				}
			}
			awp_first_default = false;
		}
		else if (($(this).attr('type') != 'text' && $(this).attr('type') != 'textarea') || $(this).val() != "")
		{
			var awp_arr = $(this).attr('name').split('_');
			if (awp_first_default && awp_arr.length == 4)
			{
				/* alert(awp_quantity+" === "+parseInt(awp_qty_list[awp_arr[3]])+" --- "+awp_arr[3]); */
				awp_quantity = parseInt(awp_qty_list[awp_arr[3]]);
			}
			if (awp_first_default && awp_arr.length == 4)
				awp_min_quantity = parseInt(awp_min_qty[awp_arr[3]]);
			awp_first_default = false;
		}
		else if ($(this).attr('type') == 'text' || $(this).attr('type') == 'textarea')
		{
			var awp_arr = $(this).attr('name').split('_');
			if (awp_arr.length == 4)
			{
					/*alert(awp_quantity+" === "+parseInt(awp_qty_list[awp_arr[3]])+" --- "+awp_arr[3]);*/
				awp_quantity_default = parseInt(awp_qty_list[awp_arr[3]]);
			}
			if (awp_arr.length == 4)
				awp_min_quantity_default = parseInt(awp_min_qty[awp_arr[3]]);
		}
	});
	if (awp_first_default)
	{
		awp_quantity = awp_quantity_default;
		awp_min_quantity = awp_min_quantity_default;
	}
	var attribut_price_tmp = awp_total_impact;
	img_offset = $('#'+awp_layered_img_id).offset();
	/*
	* Change Attribute Layered Images
	*/
	if (awp_layered_image_list.length > 0)	
	{
		for (key in awp_selected_groups)
		{
			awp_layer_filename = awp_layered_image_list[awp_selected_groups[key]] != ''?awp_layered_image_list[awp_selected_groups[key]]:false;
			awp_layer_pos = awp_group_order[key];
			if (awp_layer_filename)
			{
				/*
				* If checkbox, need to show all the checked boxes's images.
				*/
				if (awp_group_type[key] == "checkbox")
				{
					$('.awp_group_class_'+key).each(function() {
						var awp_csli = false;
						tmp_attr_id = $(this).attr('id').substr($(this).attr('id').length - 1);
						/* Check for filename again based on each checkbox element */
						awp_layer_filename = awp_layered_image_list[tmp_attr_id] != ''?awp_layered_image_list[tmp_attr_id]:false;
						/* alert(tmp_attr_id+' -----------> '+awp_layer_filename); */
						if (awp_layer_filename)
						{
							if ($('.awp_liga_'+tmp_attr_id).length)
							{
								/* alert(tmp_attr_id+' --> ' +$(this).attr('checked') + ' --- '+$('.awp_liga_'+tmp_attr_id).hasClass('awp_liga_'+tmp_attr_id)); */
								/* If selected attribute and not hidden, show it */
								if ($(this).attr('checked') && ($('.awp_liga_'+tmp_attr_id).attr('display') == 'none' || !$('.awp_liga_'+tmp_attr_id).attr('display')))
									$('.awp_liga_'+tmp_attr_id).fadeIn('fast');
								/* If not selected attribute and not hidden, hide it */
								else if (!$(this).attr('checked') && ($('.awp_liga_'+tmp_attr_id).attr('display') != 'none' || !$('.awp_liga_'+tmp_attr_id).attr('display')))
									$('.awp_liga_'+tmp_attr_id).fadeOut('fast');
								/* if a layer exists and marked, set to true to avoid creating it again */
								if ($('.awp_liga_'+tmp_attr_id).attr('display') != 'none')
									awp_csli = true;
							}
							/* Layered Image was not created yet, create it now */
							/* alert($(this).attr('id') + " ==== " + $(this).attr('checked')+' ('+awp_csli+')'); */
							if ($(this).attr('checked') && !awp_csli)
							{
								/* alert('creating ' + tmp_attr_id); */
								if ($('#awp_product_image').length)
									$('#awp_product_image').prepend('<div class="awp_layered_images awp_lig_'+key+' awp_liga_'+tmp_attr_id+'" id="awp_attr_img_'+tmp_attr_id+'" style="position: absolute;z-index:'+(1000+awp_layer_pos)+';"><img src="'+awp_layer_filename+'" border="0" /></div>');
								else if ($('#image-block').length)
									$('#image-block').prepend('<div class="awp_layered_images awp_lig_'+key+' awp_liga_'+tmp_attr_id+'" id="awp_attr_img_'+tmp_attr_id+'" style="position: absolute;z-index:'+(1000+awp_layer_pos)+';"><img src="'+awp_layer_filename+'" border="0" /></div>');
								else
									$('body').append('<div class="awp_layered_images awp_lig_'+key+' awp_liga_'+tmp_attr_id+'" id="awp_attr_img_'+tmp_attr_id+'" style="position: absolute; top:'+img_offset.top+'px;left:'+img_offset.left+'px;z-index:'+(1000+awp_layer_pos)+';"><img src="'+awp_layer_filename+'" border="0" /></div>');
							}
						}
					});
				}
				else
				{
					var awp_csli = false;
					$('.awp_lig_'+key).each(function() {
						/* If selected attribute and not hidden, show it */
						if ($(this).hasClass('awp_liga_'+awp_selected_groups[key]) && ($(this).attr('display') == 'none' || !$(this).attr('display')))
							$(this).fadeIn('fast');
						/* If not selected attribute and not hidden, hide it */
						else if (!$(this).hasClass('awp_liga_'+awp_selected_groups[key]) && ($(this).attr('display') != 'none' || !$(this).attr('display')))
							$(this).fadeOut('fast');
						/* if a layer exists and marked, set to true to avoid creating it again */
						if ($(this).hasClass('awp_liga_'+awp_selected_groups[key]) && $(this).attr('display') != 'none')
							awp_csli = true;
					});
					/* Layered Image was not created yet, create it now */
					if (!awp_csli)
					{
						if ($('#awp_product_image').length)
							$('#awp_product_image').prepend('<div class="awp_layered_images awp_lig_'+key+' awp_liga_'+awp_selected_groups[key]+'" id="awp_attr_img_'+awp_selected_groups[key]+'" style="position: absolute;z-index:'+(1000+awp_layer_pos)+';"><img src="'+awp_layer_filename+'" border="0" /></div>');
						else if ($('#image-block').length)
							$('#image-block').prepend('<div class="awp_layered_images awp_lig_'+key+' awp_liga_'+awp_selected_groups[key]+'" id="awp_attr_img_'+awp_selected_groups[key]+'" style="position: absolute;z-index:'+(1000+awp_layer_pos)+';"><img src="'+awp_layer_filename+'" border="0" /></div>');
						else
							$('body').append('<div class="awp_layered_images awp_lig_'+key+' awp_liga_'+awp_selected_groups[key]+'" id="awp_attr_img_'+awp_selected_groups[key]+'" style="position: absolute; top:'+img_offset.top+'px;left:'+img_offset.left+'px;z-index:'+(1000+awp_layer_pos)+';"><img src="'+awp_layer_filename+'" border="0" /></div>');
					}
				}
			}
		}
	}
	if (doa)
		alert("price 1 "+attribut_price_tmp);
	var tax = noTaxForThisProduct ? 1:((taxRate / 100) + 1);
	var attr_tax = noTaxForThisProduct || (awp_no_tax_impact && !noTaxForThisProduct) ? ((taxRate / 100) + 1):1;
	if (awp_psv >= 1.4)
		attr_tax = 1;
	if (doa)
	alert(tax + " -" + attr_tax);
	
	if (noTaxForThisProduct)
	{
		attribut_price_tmp /= attr_tax;
		if (doa)
			alert("price 2 "+attribut_price_tmp +" attr_tax = "+attr_tax);
		/* awp_total_impact /= attr_tax; */
	}
	else if (typeof displayPrice != 'undefined' && displayPrice != 1 && awp_no_tax_impact)
	{
		attribut_price_tmp *= attr_tax;
	}

	if (typeof productReference != 'undefined' && productReference != '')
	{
		$('#product_reference').show();
		/* $('#product_reference span').text(selectedCombination['reference']);
		//$('#product_reference:hidden').show(); */
	}
	/* $('#product_reference:visible').hide('slow');
	//alert("awp_extra "+awp_extra+" , attribut_price_tmp + "+ attribut_price_tmp + " + productPriceWithoutReduction " + productPriceWithoutReduction) */
	if (awp_psv < 1.4 || typeof specific_price == 'undefined')
	{
		var awp_converted_impact = ((awp_extra + attribut_price_tmp) * (awp_converted_price?1:currencyRate));
		var productPriceWithoutReduction2 = productPriceWithoutReduction + awp_converted_impact;
		if (doa)
			alert("productPriceWithoutReduction2 = "+ productPriceWithoutReduction2 + " ("+attribut_price_tmp+" + "+productPriceWithoutReduction+" * "+currencyRate+")");
		
		if (typeof reduction_from != 'undefined' && reduction_from != reduction_to && (currentDate > reduction_to || currentDate < reduction_from))
			var priceReduct = 0;
		else
			var priceReduct = (productPriceWithoutReduction * (awp_converted_price?1:currencyRate)) / 100 * parseFloat(reduction_percent) + (reduction_price * currencyRate);
		var priceProduct = productPriceWithoutReduction2 - priceReduct;
		if (doa)
		alert("priceProduct = "+ priceProduct + " ("+productPriceWithoutReduction2+" - "+priceReduct+")");
		var productPricePretaxed = 0;
		/* alert(productPriceWithoutReduction+"-->"+productPriceWithoutReduction2+" - "+priceReduct+" - ("+awp_extra+" + "+attribut_price_tmp+")) / "+tax+") + "+awp_extra+" + "+attribut_price_tmp+")"); */
		if (awp_no_tax_impact)
			productPricePretaxed = ((productPriceWithoutReduction - priceReduct) / tax) + (awp_converted_impact - (awp_converted_impact / 100 * parseFloat(reduction_percent) + (reduction_price * currencyRate)) );
		else
			productPricePretaxed = (productPriceWithoutReduction2 - priceReduct) / tax;
	
		if (typeof displayPrice != 'undefined' && displayPrice == 1)
		{
			priceProduct = productPricePretaxed;
			/* alert("productPriceWithoutReduction2 = " + productPriceWithoutReduction2); */
			if (awp_no_tax_impact)
				productPriceWithoutReduction2 = (productPriceWithoutReduction2- awp_converted_impact) /tax + awp_converted_impact;
			else
				productPriceWithoutReduction2 /= tax;
		}
		if (typeof group_reduction != 'undefined' && group_reduction)
			priceProduct *= group_reduction;
		if (doa)
			alert("priceProduct = " + priceProduct);
		/* alert("priceProduct = "+ priceProduct + " ("+productPricePretaxed+" - "+productPriceWithoutReduction2+")"); */
	}
	else if (awp_psv < 1.5)
	{
		var tax = (taxRate / 100) + 1;
		var taxExclPrice = 0;
		if (specific_price)
		{
			if (specific_currency)
				taxExclPrice = specific_price;
			else
				taxExclPrice = specific_price * currencyRate;
		}
		else
		{
			taxExclPrice =  productPriceTaxExcluded + (attribut_price_tmp * group_reduction) * currencyRate;
		}
		/* alert("specific_price " + specific_price + " - " + specific_currency + " --> " +taxExclPrice); */
		if (specific_price)
			var productPriceWithoutReduction = productPriceTaxExcluded + (attribut_price_tmp * currencyRate);

		if (!displayPrice && !noTaxForThisProduct)
		{

			var productPrice = ps_round(taxExclPrice * tax, 2);
			if (specific_price)
				productPriceWithoutReduction = ps_round(productPriceWithoutReduction * tax, 2);
		}
		else
		{
			var productPrice = ps_round(taxExclPrice, 2);
			if (specific_price)
				productPriceWithoutReduction = ps_round(productPriceWithoutReduction, 2);
		}

		var reduction = 0;
		if (reduction_price || reduction_percent)
		{
			reduction = productPrice * (parseFloat(reduction_percent) / 100) + reduction_price;
			if (reduction_price && (displayPrice || noTaxForThisProduct))
				reduction = reduction / tax;
		}

		if (!specific_price)
			productPriceWithoutReduction = productPrice;
		productPrice -= reduction;
		/* alert("productPrice = ps_round("+productPrice+" * "+group_reduction); */		

		if ((awp_psv3 == '1.4.0' || awp_psv3 == '1.4.7' || awp_psv3 == '1.4.8') && group_reduction)
			productPrice *= group_reduction;
		/* var ecotaxAmount = !displayPrice ? ps_round(selectedCombination['ecotax'] * (1 + ecotaxTax_rate / 100), 2) : selectedCombination['ecotax'];
		//productPrice += ecotaxAmount;
		//productPriceWithoutReduction += ecotaxAmount;

		//productPrice = ps_round(productPrice * currencyRate, 2); */

		/* Special feature: "Display product price tax excluded on product page" */
		if (!noTaxForThisProduct)
			var productPricePretaxed = productPrice / tax;
		else
			var productPricePretaxed = productPrice;
		var priceProduct = productPrice;
		var productPriceWithoutReduction2 = productPriceWithoutReduction;
		/* alert("price = "+ priceProduct); */
	}
	else /* PS 1.5 + */
	{
		/* retrieve price without group_reduction in order to compute the group reduction after
		// the specific price discount (done in the JS in order to keep backward compatibility) */
		if (!displayPrice && !noTaxForThisProduct)
		{
			var priceTaxExclWithoutGroupReduction = ps_round(productPriceTaxExcluded, 6) * (1 / group_reduction);
		} else {
			var priceTaxExclWithoutGroupReduction = ps_round(productPriceTaxExcluded, 6) * (1 / group_reduction);
		}

		var tax = (taxRate / 100) + 1;

		var display_specific_price;
		if (false && selectedCombination.specific_price)
		{
			display_specific_price = selectedCombination.specific_price['price'];
			if (selectedCombination['specific_price'].reduction_type == 'percentage')
			{
				$('#reduction_amount').hide();
				$('#reduction_percent_display').html('-' + parseFloat(selectedCombination['specific_price'].reduction_percent) + '%');
				$('#reduction_percent').show();
			} else if (selectedCombination['specific_price'].reduction_type == 'amount' && selectedCombination['specific_price'].reduction_price != 0) {
				$('#reduction_amount_display').html('-' + formatCurrency(selectedCombination['specific_price'].reduction_price, currencyFormat, currencySign, currencyBlank));
				$('#reduction_percent').hide();
				$('#reduction_amount').show();
			} else {
				$('#reduction_percent').hide();
				$('#reduction_amount').hide();
			}
		}
		else
		{
			display_specific_price = product_specific_price['price'];
			if (product_specific_price['reduction_type'] == 'percentage')
				$('#reduction_percent_display').html((product_specific_price.reduction*100) + '%');
		}
		/* alert("display_specific_price -> " + display_specific_price); */
		if (product_specific_price['reduction_type'] != '')/* || selectedCombination['specific_price'].reduction_type != '')*/
			$('#discount_reduced_price,#old_price').show();
		else
			$('#discount_reduced_price,#old_price').hide();
		
		if (product_specific_price['reduction_type'] == 'percentage')/* || selectedCombination['specific_price'].reduction_type == 'percentage')*/
			$('#reduction_percent').show();
		else
			$('#reduction_percent').hide();
		if (display_specific_price)
			$('#not_impacted_by_discount').show();
		else
			$('#not_impacted_by_discount').hide();

		var taxExclPrice = 0;
		if (display_specific_price && display_specific_price >= 0)
		{
			if (specific_currency)
				taxExclPrice = display_specific_price;
			else
				taxExclPrice = display_specific_price * currencyRate;
		}
		else
			taxExclPrice = priceTaxExclWithoutGroupReduction + attribut_price_tmp * currencyRate;
		/* alert("specific_price " + display_specific_price + " - " + specific_currency + " --> " +taxExclPrice); */
		if (display_specific_price)
			productPriceWithoutReduction = priceTaxExclWithoutGroupReduction + selectedCombination['price'] * currencyRate; /* Need to be global => no var*/

		if (!displayPrice && !noTaxForThisProduct)
		{
			productPrice = taxExclPrice * tax; /* Need to be global => no var */
			if (display_specific_price)
				productPriceWithoutReduction = ps_round(productPriceWithoutReduction * tax, 2);
		}
		else
		{
			productPrice = ps_round(taxExclPrice, 2); /* Need to be global => no var */
			if (display_specific_price)
				productPriceWithoutReduction = ps_round(productPriceWithoutReduction, 2);
		}

		var reduction = 0;
		/* alert("11 -> " + product_specific_price.reduction); */
		if (false && (selectedCombination['specific_price'].reduction_price || selectedCombination['specific_price'].reduction_percent))
		{
			selectedCombination['specific_price'].reduction_price = (specific_currency ? selectedCombination['specific_price'].reduction_price : selectedCombination['specific_price'].reduction_price * currencyRate);
			reduction = productPrice * (parseFloat(selectedCombination['specific_price'].reduction_percent) / 100) + selectedCombination['specific_price'].reduction_price;
			if (selectedCombination['specific_price'].reduction_price && (displayPrice || noTaxForThisProduct))
				reduction = ps_round(reduction / tax, 6);
		}
		else if (product_specific_price.reduction)
		{
			if (product_specific_price.reduction_type == 'amount')
			{
				product_specific_price.reduction = (specific_currency ? product_specific_price.reduction : product_specific_price.reduction * currencyRate);
				reduction = product_specific_price.reduction;
				if (displayPrice || noTaxForThisProduct)
					reduction = ps_round(reduction / tax, 6);
			}
			else
				reduction = productPrice * (parseFloat(product_specific_price.reduction));
		}
		productPriceWithoutReduction = productPrice * group_reduction;
		/* alert("reduction = " + reduction); */
		productPrice -= reduction;
		var tmp = productPrice * group_reduction;
		/* alert("productPrice = ps_round("+productPrice+" * "+group_reduction); */		
		productPrice = ps_round(productPrice * group_reduction, 2);
		/* alert("productPrice = " +productPrice);
		//productPrice = ps_round(productPrice * currencyRate, 2);  */
		var our_price = '';
		if (productPrice > 0) {
			our_price = formatCurrency(productPrice, currencyFormat, currencySign, currencyBlank);
		} else {
			our_price = formatCurrency(0, currencyFormat, currencySign, currencyBlank);
		}
		/*$('#our_price_display').text(our_price);*/
		$('#old_price_display').text(formatCurrency(productPriceWithoutReduction, currencyFormat, currencySign, currencyBlank));
		if (productPriceWithoutReduction > productPrice)
			$('#old_price,#old_price_display,#old_price_display_taxes').show();
		else
			$('#old_price,#old_price_display,#old_price_display_taxes').hide();




		if (!noTaxForThisProduct)
			var productPricePretaxed = productPrice / tax;
		else
			var productPricePretaxed = productPrice;
		var priceProduct = productPrice;
		var productPriceWithoutReduction2 = productPriceWithoutReduction;
		/* alert("price = "+ priceProduct); */
	}
	var arr = new Array();
	arr['priceProduct'] = Math.max(priceProduct,0);
	arr['productPricePretaxed'] = Math.max(productPricePretaxed,0);
	arr['productPriceWithoutReduction2'] = Math.max(productPriceWithoutReduction2,0);
	arr['awp_quantity'] = awp_quantity;
	arr['awp_min_quantity'] = awp_min_quantity;
	arr['awp_total_impact'] = awp_total_impact;
	arr['awp_total_weight'] = awp_total_weight;
	/* alert(priceProduct + " : " + productPricePretaxed + " : " + productPriceWithoutReduction2 + " : " + awp_total_impact); */
	return arr;
}

function awp_price_update()
{
	var prices = awp_get_total_prices(0, awp_psv < 1.4?productPriceWithoutReduction:0);
	/* alert(prices.toSource()); */
	var priceProduct = prices['priceProduct'];
	var productPricePretaxed = prices['productPricePretaxed'];
	var productPriceWithoutReduction2 = prices['productPriceWithoutReduction2'];
	awp_quantity = prices['awp_quantity'];
	var awp_total_impact = prices['awp_total_impact'];
	var awp_total_weight = prices['awp_total_weight'];
	var awp_min_quantity = prices['awp_min_quantity'];
	/* alert(awp_min_quantity+ " | " + $("#quantity_wanted").val()); */
	if ($("#quantity_wanted").val() < awp_min_quantity)
	{
		$("#quantity_wanted").val(awp_min_quantity);
		if ($("#awp_q1").length)
			$("#awp_q1").val(awp_min_quantity);
		if ($("#awp_q2").length)
			$("#awp_q2").val(awp_min_quantity);
	}
	var awp_minimal_text = '';
	if (awp_min_quantity > 1)
		awp_minimal_text = awp_minimal_1 + ' ' + awp_min_quantity + awp_minimal_2;
	/* alert(awp_min_quantity); */
	$('.awp_minimal_text').text(awp_minimal_text);
	$('#our_price_display').text(formatCurrency(priceProduct, currencyFormat, currencySign, currencyBlank));
	$('#pretaxe_price_display').text(formatCurrency(productPricePretaxed, currencyFormat, currencySign, currencyBlank));
	$('#old_price_display').text(formatCurrency(productPriceWithoutReduction2, currencyFormat, currencySign, currencyBlank));
	if (awp_quantity == 0)
		$('#availability_value').html(availableLaterValue);
	else
		$('#availability_value').html(availableNowValue);
	
	$('#quantityAvailable').html(awp_quantity+" ");
	if (awp_quantity == 1)
	{
		$("#quantityAvailableTxt").css('display','');
		$("#quantityAvailableTxtMultiple").css('display','none');
	}
	else
	{
		$("#quantityAvailableTxtMultiple").css('display','');
		$("#quantityAvailableTxt").css('display','none');
	}
	if (availableNowValue || availableLaterValue)
		$('#availability_statut').fadeIn('slow');
	else
		$('#availability_statut').hide();
	if (awp_stock)
	{
		if (awp_psv >= 1.4)
			$('#pQuantityAvailable').fadeIn('slow');
		$('#quantityAvailable').fadeIn('slow');
		$('#awp_in_stock').html((availableNowValue||availableLaterValue?$('#availability_statut').html():'') + (awp_display_qty?" " +awp_quantity+" " +(awp_quantity == 1?$("#quantityAvailableTxt").html():$("#quantityAvailableTxtMultiple").html()):''));
		if (document.getElementById('awp_second_price'))
			$('#awp_in_stock_second').html((availableNowValue||availableLaterValue?$('#availability_statut').html():'') + (awp_display_qty?" " +awp_quantity + " " +(awp_quantity == 1?$("#quantityAvailableTxt").html():$("#quantityAvailableTxtMultiple").html()):''));
	
	
	}
	$('#awp_p_impact').val(awp_total_impact);
	$('#awp_p_weight').val(awp_total_weight);
	if (document.getElementById('awp_price'))
		$("#awp_price").html($("#our_price_display").html())
	if (document.getElementById('awp_second_price'))
		$("#awp_second_price").html($("#our_price_display").html())
	return prices;
}

function awp_add_to_cart(is_edit)
{
	vars = awp_get_attributes();
	if (vars == -1)
		return;
	if (awp_adc_no_attribute && !vars)
	{
		alert(awp_select_attributes);
		return;
	}
	else if(!vars)
	{
		vars = new Object();
	}
	prices = awp_price_update();
	vars["price"] = $('#awp_p_impact').val();
	vars["weight"] = $('#awp_p_weight').val();
	vars["quantity"] = $('#quantity_wanted').val();
	vars["quantity_available"] = $('#quantityAvailable').length?$('#quantityAvailable').html():awp_quantity;
	vars["id_product"] = $('#product_page_product_id').val();
	vars["awp_isie"] = ($.browser.msie?"1":"0");
	vars["allow_oos"] = allowBuyWhenOutOfStock?"1":"";
	if (is_edit)
	{
		vars["awp_ins"] = $('#awp_ins').val();
		vars["awp_ipa"] = $('#awp_ipa').val();
	}
	else
		$('.awp_edit').hide();
	/* check for quantity
	//alert(vars["quantity_available"] + awp_quantity);
	//alert(allowBuyWhenOutOfStock); */
	if (vars["quantity_available"] == 0 && !allowBuyWhenOutOfStock)
	{
		alert(awp_oos_alert);
		return;
	}
	var quantity_group = "";
	/* alert(typeof awp_is_quantity_group); */
	if (awp_is_quantity_group.length > 0)
		for (var qty in awp_is_quantity_group)
		{
			quantity_group = quantity_group + (quantity_group!=""?",":"")+awp_is_quantity_group[qty];
			for (id_att in awp_attr_to_group)
			{
				if (awp_attr_to_group[id_att] == awp_is_quantity_group[qty])
				{
					if ($('#awp_quantity_group_'+id_att).val() > 0 && $('#awp_quantity_group_'+id_att).val() < prices['awp_min_quantity'])
					{
						alert(awp_min_qty_text+' '+prices['awp_min_quantity']);
						return false;
					}
				}
			}
		}
	vars["awp_is_quantity"] = quantity_group;
	$('html, body').animate({ scrollTop: 0 }, "slow");
	if ($('#cart_block #cart_block_list').hasClass('collapsed') && awp_ajax)
			ajaxCart.expand();
	$.ajax({
		type: 'POST',
		url: baseDir + 'modules/attributewizardpro/combination_json.php',
		async: false,
		cache: false,
		dataType : "json",
		data: vars,
		success:function(feed) { 
			if (feed.error != "")
			{
				alert(feed.error);
				return;
			}
            if (awp_ajax)
			{
				/* apply 'transfert' effect */
				if (awp_psv < 1.4)
				{
					var elementToTransfert = null;
					elementToTransfert = $('div#image-block');
					elementToTransfert.TransferTo({
							to: $('#cart_block').get(0),
							className:'transferProduct',
							duration: 800,
							complete: function () {
							}
				
					});
				}
				else
				{
					/* add the picture to the cart */
					var $element = $('#bigpic');
					var $picture = $element.clone();
					var pictureOffsetOriginal = $element.offset();

					if ($picture.size())
						$picture.css({'position': 'absolute', 'top': pictureOffsetOriginal.top, 'left': pictureOffsetOriginal.left});

					var pictureOffset = $picture.offset();
					if ($('#cart_block').length && $('#cart_block').offset().top && $('#cart_block').offset().left)
						var cartBlockOffset = $('#cart_block').offset();
					else
						var cartBlockOffset = $('#shopping_cart').offset();

					// Check if the block cart is activated for the animation
					if (cartBlockOffset != undefined && $picture.size())
					{
						$picture.appendTo('body');
						$picture.css({ 'position': 'absolute', 'top': $picture.css('top'), 'left': $picture.css('left'), 'z-index': 4242 })
						.animate({ 'width': $element.attr('width')*0.66, 'height': $element.attr('height')*0.66, 'opacity': 0.2, 'top': cartBlockOffset.top + 30, 'left': cartBlockOffset.left + 15 }, 1000)
						.fadeOut(100, function() {
						});
					}
				}

				
				$.ajax({
					type: 'GET',
					url: (awp_psv < 1.5?baseDir + 'cart.php':baseUri),
					async: true,
					cache: false,
					dataType : "json",
					data: 'controller=cart&ajax=true&token=' + static_token,
					success: function(jsonData)
					{
						ajaxCart.updateCart(jsonData)
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert("TECHNICAL ERROR: unable to refresh the cart.\n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
					}
				});
				awp_reset_text();
				awp_price_update();
				if (awp_popup)
				{
					$("#awp_container").fadeOut(1000);
					$("#awp_background").fadeOut(1000);
				}
				return;
	      	}
	      	else
	      	{
	      		if (awp_reload_page == 1)
	      			location.reload();
	      		else
	      			location.href =  baseDir + 'order.php';
	      	}
		}
  	});
	return false;
}

function awp_customize_func()
{
	$('#awp_add_to_cart input').val(awp_customize);
	$('#awp_add_to_cart input').unbind('click').click(function(){
		$("#awp_background").fadeIn(1000);
		$("#awp_container").fadeIn(1000);
		$('#awp_add_to_cart input').val(awp_add_cart);
		$('#awp_add_to_cart input').unbind('click').click(function(){
			awp_add_to_cart();
			awp_customize_func();
			return false;
		});
	return false;
	});
}

function awp_add_to_cart_func()
{
	if ($('#awp_add_to_cart input').val() != awp_add_cart)
	{
		$('#awp_add_to_cart input').val(awp_add_cart);
		$('#awp_add_to_cart input').unbind('click').click(function(){
			awp_add_to_cart();
			return false;
		});
	}
}


function in_array2(arr, obj)
{
	for(var i=0; i<arr.length; i++)
	{
		if (arr[i] == obj)
		{
			return true;
		}
	}
}

function awp_get_attributes()
{
	var name = document.awp_wizard;
	var vars = new Object();
	var added = false;
	for(i=0; i<name.elements.length; i++)
		if (name.elements[i].name.substring(0,10) == "awp_group_" &&
			(name.elements[i].type != "radio" || name.elements[i].checked) &&
			(name.elements[i].type != "checkbox" || name.elements[i].checked) &&
			name.elements[i].name != "")
		{
			var tmp_arr = name.elements[i].name.substring(4).split("_");
			if (tmp_arr.length == 3)
			{
				var found = false;
				for (key in awp_required_list)
				{
					if (key == tmp_arr[2] && awp_required_list[key] == 1)
						found = true;
				}
				if (found && name.elements[i].value == "")
				{
					alert(Encoder.htmlDecode(awp_required_list_name[tmp_arr[2]])+" "+awp_is_required);
					name.elements[i].focus();
					return -1;
				}
				else if (name.elements[i].value == "")
					continue;
				if (in_array2(awp_is_quantity_group,tmp_arr[1]) && name.elements[i].value == 0)
					continue;
			}
			if (vars[name.elements[i].name.substring(4)])
				vars[encodeURI(name.elements[i].name.substring(4)+"_"+i)] = encodeURIComponent(name.elements[i].value);
			else
				vars[encodeURI(name.elements[i].name.substring(4))] = encodeURIComponent(name.elements[i].value);
			added = true;
		}
	return added?vars:false;
}

$(document).ready(function () {
	if ((awp_add_to_cart_display == "both" || awp_add_to_cart_display == "bottom") && document.getElementById('awp_price'))
	{
		$("#awp_price").html($("#our_price_display").html())
		$("#awp_second_price").html($("#our_price_display").html());
	}
	if (awp_add_to_cart_display == "both" || awp_add_to_cart_display == "scroll")
	{
		$('#buy_block').css('position','absolute');
		$('#buy_block').css('z-index','100');
			var $scrollingDiv = $("#buy_block");
	 
			$(window).scroll(function(){			
				$scrollingDiv
					.stop()
					.animate({"marginTop": (Math.max(0,$(window).scrollTop()-250)) + "px","marginLeft": "75px"}, "slow" );			
			});
    }
	for (var n = 0 ; n < awp_file_list.length ; n++)
	{
		var i = awp_file_list[n];
		new AjaxUpload('#upload_button_'+i, i, awp_file_ext[n], {
			action: baseDir + 'modules/attributewizardpro/file_upload.php',
			name: 'userfile',
			data: {	id_product :  $('#product_page_product_id').val(), id_attribute: i},
		  	/* Submit file after selection */
  			autoSubmit: true,
			responseType: false,
  			onSubmit: function(file, ext, i, allowed_ext)
  			{
				if (! (ext && allowed_ext.test(ext)))
				{
           			alert(awp_ext_err + " " + allowed_ext.source.substring(2,allowed_ext.source.length-2).replace(/\|/g,", "));
					return false;
		        }
        		$('#awp_image_cell_'+i).html('<img src="'+baseDir+'modules/attributewizardpro/img/loading.gif" /><br /><b>Please wait</b>');
  			},
  			onComplete: function(file, ext, response, i)
  			{
  				if (response.indexOf('|||') == -1)
				{
					alert(response);
					$('#awp_image_cell_'+i).html('');
  					$('#awp_image_delete_cell_'+i).css('display','none');
  					$('#awp_file_group_'+i).val('');
  					awp_price_update();
					return;
				}
  				var response_arr = response.split("|||",2);
  				var no_thumb = false;
  				if (response_arr[1].substring(0,1) == '|')
  				{
					response_arr[1] = response_arr[1].substring(1);
					no_thumb = true;
  				}
  				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext)) || no_thumb)
  					$('#awp_image_cell_'+i).html(response_arr[1]);
  				else
  				{
  					var thumb = response_arr[0].substr(0, response_arr[0].length - ext.length - 3)+"_small.jpg";
  					$('#awp_image_cell_'+i).html('<img src="'+baseDir+'modules/attributewizardpro/file_uploads/'+thumb+'" />');
  					$('#awp_image_cell_'+i).css('display','block');
  				}
        		$('#awp_image_delete_cell_'+i).css('display','block');
           		$('#awp_file_group_'+i).val(response.replace('||||','|||'));
           	 	awp_price_update();
  			}
		});
	}
	for (var id_attribute in awp_impact_list)
	{
		var tmp_impact = parseFloat(awp_impact_list[id_attribute]);
		/* alert("tmp_impact = "+tmp_impact + " == " +id_attribute+ " -> "+awp_attr_to_group[id_attribute]); */
		if (!awp_attr_to_group[id_attribute])
			continue;
		var tmp_group = awp_attr_to_group[id_attribute];
		if (tmp_impact != 0)
			awp_group_impact[tmp_group] = 1;
		else if(awp_group_impact[tmp_group] != 1)
			awp_group_impact[tmp_group] = 0;
	}
	/* alert(awp_impact_list.toString());
	//alert(awp_group_impact.toString()); */
});

function awp_select_image(selected)
{
	var choice = new Array();
	/* alert(selected.toSource()); */
	$('div#attributes select').each(function(){
		choice.push($(this).val());
	});
	var nbAttributesEquals = 0;
	/* testing every combination to find the conbination's attributes' case of the user */
	
	for (combination in combinations)
	{
		/* verify if this combinaison is the same that the user's choice */
		nbAttributesEquals = 0;
		for (idAttribute in combinations[combination]['idsAttributes'])
		{
			/* ie6 bug fix */
			if (idAttribute != 'indexOf'){
				/* if this attribute has been choose by user */
				if (combinations[combination]['idsAttributes'][idAttribute] ==  selected)
				{
					/* we are in a good way to find the good combination ! */
					awpRefreshProductImages(combinations[combination]['idCombination']);
					displayImage( $('#thumb_'+combinations[combination]['image']).parent() );
					return;
				}
			}
		}
	}
}

function awpRefreshProductImages(id_product_attribute)
{
	if (typeof(refreshProductImages) != 'function')
		return;
	if (typeof(combinationImages) == 'undefined' || typeof(combinationImages[id_product_attribute]) == 'undefined')
		return;
	$('#thumbs_list_frame').scrollTo('li:eq(0)', 700, {axis:'x'});
	$('#thumbs_list li').hide();
	id_product_attribute = parseInt(id_product_attribute);
	var i = 0;
	if (typeof(combinationImages) != 'undefined' && typeof(combinationImages[id_product_attribute]) != 'undefined')
	{
		for (i = 0; i < combinationImages[id_product_attribute].length; i++)
			$('#thumbnail_' + parseInt(combinationImages[id_product_attribute][i])).show();
	}
	$('#thumbs_list_frame').width((parseInt(($('#thumbs_list_frame li').width())* i) + 3) + 'px'); /*  Bug IE6, needs 3 pixels more ? */
	$('#thumbs_list').trigger('goto', 0);
	$('#wrapResetImages').show();
	if (typeof serialScrollFixLock == 'function')
		serialScrollFixLock('', '', '', '', 0);/* SerialScroll Bug on goto 0 ?*/
}

function awp_reset_text()
{
	var name = document.awp_wizard;
	for(i=0; i<name.elements.length; i++)
		if (name.elements[i].name.substring(0,10) == "awp_group_" && 
			(name.elements[i].type == "text" || name.elements[i].type == "textarea" || name.elements[i].type == "hidden"))
			{
				if (name.elements[i].type == "hidden")
				{
					var img_arr = name.elements[i].value.split("_");
					$("#awp_image_cell_"+img_arr[1]).css('display','none');
					$("#awp_image_delete_cell_"+img_arr[1]).css('display','none');
					name.elements[i].value = "";
				}
				else
				{
					var group_arr = name.elements[i].name.split("_");
					if (awp_group_type[group_arr[2]] == "quantity")
						var foo = "do_nothing";/*name.elements[i].value = "0"; */
					else if (awp_group_type[group_arr[2]] == "calculation")
						name.elements[i].value = $('#awp_calc_group_'+group_arr[3]).attr('default');
					else
						name.elements[i].value = "";
				}
			}
	$('.awp_max_limit').each(function () {
		$(this).html($(this).attr('awp_limit'));
	});
}

function awp_max_limit_check(id_attribute, max_limit)
{
	var obj_id = $('#awp_textbox_group_'+id_attribute).length?'#awp_textbox_group_'+id_attribute:'#awp_textarea_group_'+id_attribute;
	var chars_left = max_limit - $(obj_id).val().length;
	$('#awp_max_limit_'+id_attribute).html(Math.max(chars_left,0).toString());
	if (chars_left <= 0)
		$(obj_id).val($(obj_id).val().substring(0,max_limit));
}

function awp_toggle_img(awp_group, awp_att)
{
	$(".awp_gi_"+awp_group).each(function() {
		var awp_cur_att = $(this).attr('id').substring(7);
		if ($('#awp_radio_group_'+awp_cur_att).attr('checked') == 'checked' || $('#awp_radio_group_'+awp_cur_att).attr('checked') == true)
		{
			$('#awp_tc_'+awp_cur_att).addClass('awp_image_sel');
			$('#awp_tc_'+awp_cur_att).removeClass('awp_image_nosel');
		}
		else
		{
			$('#awp_tc_'+awp_cur_att).addClass('awp_image_nosel');
			$('#awp_tc_'+awp_cur_att).removeClass('awp_image_sel');
		}
	});
}

function awp_center_images(id_group)
{
	awp_mcw = 0;
	awp_pop_display = $('#awp_container').css('display');
	if (awp_popup && awp_pop_display == 'none')
		$('#awp_container').show();
	$(".awp_cell_cont_"+id_group).css('width','');
	$(".awp_cell_cont_"+id_group).each(function () {
		awp_mcw = Math.max(awp_mcw,$(this).width());
	});
	$(".awp_cell_cont_"+id_group).width(awp_mcw);
	if (awp_popup && awp_pop_display == 'none')
		$('#awp_container').hide();
}
