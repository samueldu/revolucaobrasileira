/*

Javascrip Functions File for RevBR

*/


// Basic Vars

var windowHeight = $(window).height();
var windowWidth = $(window).width();




// Essentials

$(function(){

	// Adjusts the sidebar height
	//$("#sidebar").height(windowHeight);
	$("#main").width(windowWidth-252);
	$("#main .content .menu-bar").width($(window).width()-250);
	
	$(window).resize(function () {
		$("#main").width($(window).width()-252);
		$("#main .content .menu-bar").width($(window).width()-250);
		
	});
	
	
	// Search
	
	$("#sidebar .search input").focus(function(){
		if($(this).val() != "Busca por conteúdo") {
			
		}
		else {
			$(this).val("");
		}
	});
	
	$("#sidebar .search input").focusout(function(){
		if($(this).val() != "") {
		}
		else {
			$(this).val("Busca por conteúdo");
		}
	});
	
});




// Home Functions

$(function(){
	
	
	// Featured banners
	
	
	
	
	var bannersNum = $("#main .featured-banners .holder .banner").length;
	var current = 0;
	
	if(bannersNum > 1) {
		$("#main .featured-banners .controls").show();
	}
	
	
	$("#main .featured-banners .holder").width(bannersNum*670);
	$('#main .featured-banners .controls .prev').addClass("disabled");
	
	$('#main .featured-banners .controls .next').click(function(){
		if(current < bannersNum-1) {
			current++;
			$("#main .featured-banners .holder").animate({marginLeft: "-"+current*670}, 500);
			
			if(current == bannersNum-1) {
				$(this).addClass("disabled");
			}
			
		}
		
		$('#main .featured-banners .controls .prev').removeClass("disabled");
		
	});
	
	$('#main .featured-banners .controls .prev').click(function(){
		if(current > 0) {
			current--;
			$("#main .featured-banners .holder").animate({marginLeft: "-"+current*670}, 500);
			
			if(current == 0) {
				$(this).addClass("disabled");
			}
			
			$('#main .featured-banners .controls .next').removeClass("disabled");
			
			
		}
	});
	
	
	
	// Trending
	
	$(".trending .subject span").click(function(){
		$(this).parent().find("ul").show();
	});
	
	$(".trending .subject").mouseleave(function(){
		$(".trending .subject ul").hide();
	});
	
	$('.trending .content').masonry({
  		itemSelector: '.item'
	});
	
	
	
	
});




// Politico Functions


$(function(){
	
	// Mansory
	
	$('.politico .wall .container').masonry({
  		itemSelector: '.item'
	});
	
	
	// Textarea 
	
	$(".politico .wall .comments-container textarea").focus(function(){
		$(this).val("");
	});
	
	
});