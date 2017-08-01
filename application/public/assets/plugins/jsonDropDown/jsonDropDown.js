(function($){
    "use strict";
	
	$.jsonDropDown = function(options){	
		//Default Settings
		var settings = $.extend({
			url			: '',	//php script url
			csrfToken	: '',	//php csrfToken
			callback	: function() {}			
		}, options);
		
		$(document).on('change', 'select:enabled, [type=radio]:enabled, [type=checkbox]:enabled', function(){		
			if($(this).attr('dropdown_id')!=undefined)
			{
				// get parent element
				var parele = $(this);
								
				// get child dropdown element
				var child = $('[parent_dropdown_id='+ $(this).attr('dropdown_id') +']:enabled');
									
				child.each(function(){
					var curele = $(this);
					
					if(curele.attr('is_relative')==1)
					{
						// data array
						var dataarr = new Array();        
						
						// get all selected value
						parele.find('option:selected').each(function(){
							// data object
							var dataobj = new Object();
							var attrid = $(this).attr('id');
														
							// set property
							if (typeof attrid !== typeof undefined && attrid !== false) 
								dataobj.value = $(this).attr('id');	
							else
								dataobj.value = $(this).val();	
							
							// push to array
							dataarr.push(dataobj);
						});
						                            
						// get generated options
						$.ajax({
							async: false,
							type: "POST",					
							url: settings.url,
							dataType: 'json',
							data: {type : curele.attr('dropdown_type'), selected : JSON.stringify(dataarr), is_dependent : curele.attr('is_dependent'), dropdown_id : curele.attr('dropdown_id'), csrfToken : settings.csrfToken},  
							success: function(options){
								// get place holder
                                var placeholder = curele.attr('placeholder');
                                
                                // remove options
								curele.empty();  
								
								if(curele.attr('multiple') === undefined)
								curele.append($('<option>'+ placeholder +'</option>'));	
								
								// populate options
								$.each(options, function(key, value){
									if(typeof curele.attr('dropdown_type') == typeof undefined || curele.attr('dropdown_type') == 'pick_list')
										curele.append($('<option></option>').attr('value', key).attr('id', value.id).text(value.value).attr('selected', (curele.attr('selected_value')==value.id ? true : false)));
									else
										curele.append($('<option></option>').attr('value', key).text(value).attr('selected', (curele.attr('selected_value')==key ? true : false)));
								});
								
								settings.callback(true);						
							},
							error: function (){
								settings.callback(false);
							},
							beforeSend: function(){},
							complete: function(){}
						});
					}
				});
			}			
		});
		
		// check_dropdown
		$('[dropdown_id]').each(function(){
			// get set selected value
            if(typeof $(this).attr('dropdown_type') == typeof undefined || $(this).attr('dropdown_type') == 'pick_list')
                $(this).attr('selected_value', $(this).find('option:selected').attr('id'));
            else
                $(this).attr('selected_value', $(this).find('option:selected').attr('value'));
		});
        
        // check_dropdown
		$('[dropdown_id]').each(function(){
			// get set selected value
            $(this).change();
		});
		
		return settings;
	}
}(jQuery));