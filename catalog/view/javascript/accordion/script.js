$(document).ready(function(){
	/* This code is executed after the DOM has been completely loaded */

	/* Changing thedefault easing effect - will affect the slideUp/slideDown methods: */
	$.easing.def = "linear";

	/* Binding a click event handler to the links: */
	$('li.button a').click(function(e){

       // $(this).parent().find('#buttonPerfilDiv').show();
	
		/* Finding the drop down list that corresponds to the current section: */
		var dropDown = $(this).parent().next();

        //$("a").next(".buttonPerfil").css( "display", "block");


		/* Closing all other drop down sections, except the current one */
		/* $('.dropdown').not(dropDown).slideUp('slow'); */
		dropDown.slideToggle('slow');
		
		/* Preventing the default event (which would be to navigate the browser to the link's address) */
		e.preventDefault();
	})
	
});