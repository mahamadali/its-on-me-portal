$(document).on('change','#has_size',function(){
	
	if($(this).prop('checked')){
		$('.has_sizes_section').show();
	}else{
		$('.has_sizes_section').hide();
	}
});

$(document).on('change','#has_wood_finish_choice',function(){
	if($(this).prop('checked')){
		$('.has_wood_finish_choice_section').show();
	}else{
		$('.has_wood_finish_choice_section').hide();
	}
});

$(document).on('change','#has_suede_mat_color',function(){
	if($(this).prop('checked')){
		$('.has_suede_mat_color_section').show();
	}else{
		$('.has_suede_mat_color_section').hide();
	}
});

$(document).on('change','#has_format',function(){
	if($(this).prop('checked')){
		$('.has_format_section').show();
	}else{
		$('.has_format_section').hide();
	}
});

/*$(document).on('submit','#add_online_store_product',function(e){
		e.preventDefault();
		var wood_finish_choice = $('input[name="wood_finish_choice_id[]"]:checked').length;
        if(wood_finish_choice == 0 && $("#has_wood_finish_choice").prop('checked') == true)
        {
        	 alert('please select any one Wood Finish Choice');
        }

        var suede_mat_color = $('input[name="suede_mat_color_id[]"]:checked').length;
        if(suede_mat_color == 0 && $("#has_suede_mat_color").prop('checked') == true)
        {
        	 alert('please select any one Suede Mat Color');
        }

        var pro_format= $('input[name="pro_format_id[]"]:checked').length;
        if(pro_format == 0 && $("#has_format").prop('checked') == true)
        {
        	 alert('please select any one format choice');
        }

        if(wood_finish_choice != 0 && suede_mat_color != 0 && pro_format != 0)
        {
       		$('#add_online_store_product').submit();
        }
 

})*/