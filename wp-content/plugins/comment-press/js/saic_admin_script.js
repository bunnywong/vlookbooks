jQuery(document).ready(function($){
	//Tabs Navigation Admin
	$(".saic-tab-content").hide(); //Hide all content
	$("#saic-tabs a:first").addClass("nav-tab-active").show(); //Activate first tab
	$(".saic-tab-content:first").show(); //Show first tab content

	//On Click Event
	$("#saic-tabs a").click(function() {
		$("#saic-tabs a").removeClass("nav-tab-active"); //Remove any "active" class
		$(this).addClass("nav-tab-active"); //Add "active" class to selected tab
		$(".saic-tab-content").removeClass("active").hide(); //Remove any "active" class and Hide all tab content
		var activeTab = $(this).attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn().addClass("active"); //Fade in the active content
		return false;
	});

	// Activa ColorPicker en la Página de Opciones
	if(typeof jQuery.fn.wpColorPicker == 'function') {
		$('.saic-colorpicker').wpColorPicker();
	}

	showHideFieldBox_SAIC('input#saic-auto-show-true', '.option-where-add-comments-box');
	$('input[name="saic_options[auto_show]"]').click(function() {
		showHideFieldBox_SAIC('input#saic-auto-show-true', '.option-where-add-comments-box');
	});


	function showHideFieldBox_SAIC(radioItem, box ){
		if( $(radioItem).is(':checked') )
			$(box).fadeIn();
		else
			$(box).fadeOut();
	}

});
