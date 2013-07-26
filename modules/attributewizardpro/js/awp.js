$(document).ready(function()
{	
	$('table.tableDnD').tableDnD(
	{
		onDragStart: function(table, row)
		{
			originalOrder = $.tableDnD.serialize();		
			if (awp_psv >= 1.4)
			{
				reOrder = ':even';
				if (table.tBodies[0].rows[1] && $('#' + table.tBodies[0].rows[1].id).hasClass('alt_row'))
					reOrder = ':odd';
			}
			else
				$('#'+table.id+ '#' + row.id).parent('tr').addClass('myDragClass');
		},
		dragHandle: 'dragHandle',
		onDragClass: 'myDragClass',
		onDrop: function(table, row)
		{
			if (originalOrder != $.tableDnD.serialize())
			{
		       	var way = (originalOrder.indexOf(row.id) < $.tableDnD.serialize().indexOf(row.id))? 1 : 0;
		       	var ids = row.id.split('_');
		       	var group = ids[1];
		       	var attribute = ids[2]?ids[2]:"";
				var tableDrag = $('#' + table.id);
		    	var bak = alternate;
	       		alternate = (alternate == 1 && way == 0 ? 1 : (alternate == 1 && way == 1 ? 0 : way)); // If orderWay = DESC alternate the way
		    	params = 'ajaxProductsPositions=true&id_attribute=' + attribute + '&id_group=' + group + '&' + $.tableDnD.serialize();

		       	$.ajax(
				{
					type: 'POST',
					url: baseDir + 'wizard_json.php',
					async: true,
					data: params,
					success: function(data)
					{
						if (awp_psv >= 1.4)
						{
							if (attribute != "")
							{
								tableDrag.find('tbody tr').removeClass('alt_row');
								tableDrag.find('tbody tr' + reOrder).addClass('alt_row');
							}
							tableDrag.find('tr td.dragHandle a:hidden').show();
							if (bak)
							{
								tableDrag.find('tbody td.dragHandle:last a:odd').hide();
								tableDrag.find('tbody td.dragHandle:first a:even').hide();
							}
							else
							{
								tableDrag.find('tbody td.dragHandle:last a:even').hide();
								tableDrag.find('tbody td.dragHandle:first a:odd').hide();
							}
						}
						else
						{
							if (attribute != "")
							{
								tableDrag.find('tr').not('.nodrag').removeClass('alt_row');
								tableDrag.find('tr:not(".nodrag"):odd').addClass('alt_row');
							}
							tableDrag.find('tr td.dragHandle a:hidden').show();
							if (bak)
							{
								tableDrag.find('tr td.dragHandle:first a:even').hide();
								tableDrag.find('tr td.dragHandle:last a:odd').hide();
							}
							else
							{
								tableDrag.find('tr td.dragHandle:first a:odd').hide();
								tableDrag.find('tr td.dragHandle:last a:even').hide();
							}						
						}
					}

				});
			}
		}
	});
	
	var i = 0;
	while (i < total_groups)
	{
		if (!$('#upload_container_'+i).html())
		{
			i++;
			continue;
		}
		new AjaxUpload('#upload_button_'+i, i, 'void', {
			action: baseDir + 'image_upload.php',
			name: 'userfile',
			data: {	'awp_random': awp_random, 'id_group' :  $('#id_group_'+i).val()},
		  	// Submit file after selection
  			autoSubmit: true,
			responseType: false,
  			onSubmit: function(file, ext, i, jpg)
  			{
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext)))
				{
           			alert('Error: invalid file extension');
					return false;
		        }
        		$('#image_container_'+i).html('<img src="'+baseDir+'/img/loading.gif" /> <b>Please wait</b>');
  			},
  			onComplete: function(file, ext, response, i)
  			{
  				if (response != "success")
  					alert(response);
        		$('#image_container_'+i).html('<img src="'+baseDir+'img/id_group_'+$('#id_group_'+i).val()+'.'+ext+'" /><br /><br />'+awp_link+': <input type="text" name="group_url_'+$('#id_group_'+i).val()+'"><br /><input type="checkbox" name="delete_image_'+$('#id_group_'+i).val()+'" value="1"> &nbsp;<b>'+awp_delete+'</b>');
  			}
		});
		$('#upload_container_'+i).css('display','inline');
		$('#image_upload_container_'+i).css('display','inline');
		i++;
	}
	
	if (awp_layered_image)
	{
		$('.liu').each(function() {
			var awp_att_id = $(this).attr('id').substring(18);
			var awp_group_id = $(this).attr('group');
			if ($('#upload_container_l'+awp_att_id).html())
			{
				new AjaxUpload('#upload_button_l'+awp_att_id, awp_att_id, 'void', {
					action: baseDir + 'image_upload.php',
					name: 'userfile',
					data: {	'awp_random': awp_random, id_attribute :  awp_att_id, pos: awp_group_id},
					// 	Submit file after selection
					autoSubmit: true,
					responseType: false,
					onSubmit: function(file, ext, awp_att_id, jpg)
					{
						if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext)))
						{
							alert('Error: invalid file extension');
							return false;
						}
						$('#image_container_l'+awp_att_id).html('<img src="'+baseDir+'/img/loading.gif" /> <b>Please wait</b>');
					},
					onComplete: function(file, ext, response, awp_att_id)
					{
						if (response != "success")
							alert(response);
						$('#image_container_l'+awp_att_id).html('<img width="32" height="32" src="'+baseDir+'img/id_attribute_'+awp_att_id+'.'+ext+'" /><input type="checkbox" name="delete_image_l'+awp_att_id+'" value="1"> &nbsp;<b>'+awp_delete+'</b>');
					}
				});
				$('#upload_container_'+awp_att_id).css('display','inline');
				$('#image_upload_container_l'+awp_att_id).css('display','inline');
			}
		});
	}
	$('ul#awp_first-languages li:not(.selected_language)').css('opacity', 0.3);
	$('ul#awp_first-languages li:not(.selected_language)').mouseover(function(){
		$(this).css('opacity', 1);});
	$('ul#awp_first-languages li:not(.selected_language)').mouseout(function(){
		$(this).css('opacity', 0.3);});
	
})

function toggle_desc(id)
{
	if (document.getElementById('description_container_'+id).style.display == "none")
	{
		document.getElementById('description_container_'+id).style.display = "block";
		document.getElementById('awp_description_'+id+'_text').innerHTML = awp_hide+" "+awp_description;
	}
	else
	{
		document.getElementById('description_container_'+id).style.display = "none";
		document.getElementById('awp_description_'+id+'_text').innerHTML = (document.getElementById('awp_description_'+id).innerHTML != ""?awp_edit:awp_enter)+ " " + awp_description;
	}
		
}

function awp_select_lang(il)
{
	var i = 0;
	$('ul#awp_first-languages li:not(.selected_language)').unbind('mouseover');
	$('ul#awp_first-languages li:not(.selected_language)').unbind('mouseout');
	while (document.getElementById("awp_li_lang_"+i))
	{
		var id = document.getElementById("awp_li_lang_"+i).value;
		if (id != il)
		{
			$("#awp_lang_"+id).removeClass("selected_language");
			$("#awp_lang_"+id).css('opacity', 0.3);
		}
		else
		{
			$("#awp_id_lang").val(id);
			awp_update_lang(true);
			$("#awp_lang_"+id).addClass("selected_language");
			$("#awp_lang_"+id).css('opacity', 1);
		}
		i++;
	}
	
	$('ul#awp_first-languages li:not(.selected_language)').mouseover(function(){
		$(this).css('opacity', 1);});
	$('ul#awp_first-languages li:not(.selected_language)').mouseout(function(){
		$(this).css('opacity', 0.3);});
}

function update_image_resize()
{
	$.post(baseDir+"update_resize.php",{resize: (document.getElementById('awp_image_resize').checked==true?1:""), width:document.getElementById('awp_image_resize_width').value});
}

function awp_update_lang(lang_change)
{
	var id = $("#awp_id_lang").val();
	var name = document.wizard_form;
	for(i=0; i<name.elements.length; i++)
	{
		if (name.elements[i].type == "hidden" && name.elements[i].name.substring(0,8) == "id_group")
		{
			var gid = name.elements[i].value;
			if (lang_change)
			{
				$("#awp_description_"+gid).val($("#awp_description_"+gid+"_"+id).val());
			}
			else
			{
			if (typeof tinyMCE != 'undefined' && typeof tinyMCE.get("awp_description_"+gid) != 'undefined')
				$("#awp_description_"+gid+"_"+id).val(tinyMCE.get("awp_description_"+gid).getContent());
			else
					$("#awp_description_"+gid+"_"+id).val($("#awp_description_"+gid).val());
			$("#group_header_"+gid+"_"+id).val($("#group_header_"+gid).val());
			}
		}
	}
}


function awp_toggle(i)
{
	if ($('#awp_ag_'+i).css('display') == 'block')
	{
		$('.awp_ag_display_'+i).fadeOut('slow');
		$('.awp_ag_display_'+i).css('display','none');
	}
	else
		$('.awp_ag_display_'+i).fadeIn('slow');
}

function awp_toggle_on(i)
{
	if ($('#awp_ag_'+i).css('display') != 'block')
		$('.awp_ag_display_'+i).fadeIn('slow');
}

function awp_toggle_all(toggle)
{
	var i = 0;
	while ($('.awp_ag_display_'+i).css('display'))
	{
		if (toggle == 0)
		{
			$('.awp_ag_display_'+i).fadeOut('slow');
			//$('.awp_ag_display_'+i).css('none');
		}
		else
			$('.awp_ag_display_'+i).fadeIn('slow');
		i++;
	}
}

function regIsDigit(fData)
{
    var reg = new RegExp(/^[0-9]+$/g);
    return (reg.test(fData));
}

function awp_copy_validation()
{
	if (!regIsDigit($("#awp_copy_src").val()))
	{
		alert(awp_copy_src);
		return;
	}
	if (!regIsDigit($("#awp_copy_tgt").val()))
	{
		alert(awp_copy_tgt);
		return;
	}
	if ($("#awp_copy_src").val() == $("#awp_copy_tgt").val() && $('#awp_copy_tgt_type').val() == "p")
	{
		alert(awp_copy_same);
		return;
	}
	
	if (awp_psv >= 1.5)
		awp_shops = awp_shops;
	else
		awp_shops = '';
		
	$.ajax({
		type: 'POST',
		url: baseDir + 'copy_combination_json.php',
		async: false,
		cache: false,
		dataType : "json",
		data: { 'awp_random': awp_random, 'action':'validate','id_product_src':$("#awp_copy_src").val(),'id_product_tgt':$("#awp_copy_tgt").val(),'type':$('#awp_copy_tgt_type').val(),'id_lang':awp_id_lang, 'awp_shops':awp_shops},
		success:function(feed) {
			if (feed.invalid_src)
			{
				alert(awp_invalid_src);
				$("#awp_copy_confirmation").html("");
			}
			else if (feed.invalid_tgt)
			{
				alert(awp_invalid_tgt);
				$("#awp_copy_confirmation").html("");
			}
			else
			{
				$("#awp_copy_confirmation").html("<b>"+awp_are_you+" <b style=\"color:blue\">"+(typeof feed.product_src[awp_id_lang] == 'undefined'?feed.product_src:feed.product_src[awp_id_lang])+"</b> "+awp_to+" <b style=\"color:green\">"+(typeof feed.product_tgt[awp_id_lang] == 'undefined'?feed.product_tgt:feed.product_tgt[awp_id_lang])+"</b></b> <input class=\"button\" type=\"button\" value=\""+awp_copy+"\" onclick=\"awp_copy_attributes()\" /> &nbsp; <input class=\"button\" type=\"button\" value=\""+awp_cancel+"\" onclick=\"$('#awp_copy_confirmation').html('');\" /><br /><b style=\"color:red\">* "+awp_will_delete+"!</b>");
			}
		}
	});
}

function awp_copy_attributes()
{
	if (awp_psv >= 1.5)
		awp_shops = awp_shops;
	else
		awp_shops = '';
	$.ajax({
		type: 'POST',
		url: baseDir + 'copy_combination_json.php',
		async: false,
		cache: false,
		dataType : "json",
		data: {'awp_random': awp_random, 'action':'copy','id_product_src':$("#awp_copy_src").val(),'id_product_tgt':$("#awp_copy_tgt").val(),'type':$('#awp_copy_tgt_type').val(),'id_lang':awp_id_lang, 'awp_shops':awp_shops},
		success:function(feed) {
			//alert(feed.toSource());
			if (feed.complete == "1")
			{
				$("#awp_copy_confirmation").html("<b>"+awp_copied+"</b>");
			}
		}
	});
}