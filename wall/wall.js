/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
Copy Rights Reserved by 99points
*/
/*
var delete_com_alert = 'Are you sure you want to delete this comment?';
var delete_post_alert = 'Are you sure you want to delete this post?';
var language_like = 'Up';
var language_unlike = 'Down';
var lang_com_next = 'Next';
var lang_write_comment = 'Write a comment';
*/

var delete_com_alert = 'Quer mesmo deletar esse comentario?';
var delete_post_alert = 'Quer mesmo deletar esse post?';
var language_like = 'Gostar';
var language_unlike = 'Nao gostar';
var lang_com_next = 'Proximo';
var lang_write_comment = 'Escreva um comentario';

$(document).ready(function(){
	
	$('#already').val(0);
	
	$('#ShowStatusBox').click(function() {
		
		$('#container_box').show();
		$('#shareButtons').show();
		$('#Show-Photo-Box').hide();
		$('#Show-Link-Box').hide();
		$('#show_img_upload_div').hide();
		$('.UIComposer_Box').show();
	});
	
	$('#ShowPhotoBox').click(function() {
		
		$('#show_img_upload_div').show();
		$('#shareButtons').hide();
		$('#Show-Link-Box').hide();
	});
	
	$('.friends_area').mouseover(function() {
		
		$(this).find('.delete_p img').css('opacity',1);
	});
	
	$('.friends_area').mouseout(function() {
		
		$(this).find('.delete_p img').css('opacity','0.4');
	});
	
	$('#ShowLinkBox').click(function() {
		//$('#container_box').show();
		$('#show_img_upload_div').hide();
		//$('#Show-Status-Box').hide();
		$('#shareButtons').hide();
		//$('.UIComposer_Box').hide();
		$('#Show-Photo-Box').hide();
		$('#Show-Link-Box').fadeIn();
	});
	
});

function lastPostFunc(page){
	
	if($('#more_hidden').length == 0)return false;
	
	if($('#already').val() == 1)return false;
	else $('#already').val(1);
	
	$('#pagLoader').show();
	
	var next =  $('#more_hidden').val();
	
	var keepID = $('#keepID').val();
	var posted_on = $('#posted_on').val();
	var origem = $('#origem').val();  
	
	if(page=="profile")
    {
		page = "profile_wall";
    }
	else if(page=="debate")
    {
        page = "debate_wall";
    }
    else
    {
		page = "member_wall";
    }
		
	var dataString = "show_more_post="+next+'&x='+keepID+'&p='+posted_on+'&origem='+origem+'&id='+keepID;

	$.ajax({ 
	type: "POST",
	url: page+".php",
	data: dataString,
	cache: false,
	success: function(response){
			$('#bottomMoreButton').remove();
			$('#midbox').append($(response).fadeIn('slow'));
			$('#already').val(0);
            parent.resizeFrame('childframe');
		}
	});
}

$(document).ready(function(){	

	// show collapsed comments
	$('div.approvebox').livequery("click", function(e){
		
		$(this).html('&nbsp;<img src="loader.gif" alt="" />');
		
		var myID = $('#myID').val();
		
		var pid = $(this).parent().attr('id').replace('box-','');	
		
		$.post("ening.php?approve=1&id"+pid+'&myId='+myID, {

		}, function(response){
			
			$(this).html('Approved');
            parent.resizeFrame('childframe');
		});
		
	});	
		
	$('#shareURLbutton').livequery("click", function(){
		
		var keepID = $('#keepID').val();
		var posted_on = $('#posted_on').val();
		var a = $("#watermark").val();
		var tagp = $("#tagged_people").val();
		
		var videoType = $("#videoType").val();
		var youtubeID = $('#youtubeID').html();
		var youtubeID = $('#youtubeID iframe').attr('src');
		
		var title = $('#ftchtitle').html();
		var url = $('#ftchurlz').html();
		var desc = $('#ftchdesc').html();
		var cur_image = $('#cur_image').val();
		var origem = $('#origem').val();  
		
		if(cur_image)cur_image = $('img#'+cur_image).attr('src');
		
		$('#youtubeID').html('');
		
		var pageUsing = $('#pageUsing').val();
		
		if(pageUsing == "profile")
			var file = "profile_wall";
		else
			var file = "member_wall";
			
		if(url != "")
		{
			$('#wrapperfb').show();
			
			var dataString = 'title='+ title + '&x=' + keepID + '&p=' + posted_on  + '&desc=' + desc  + '&cur_image=' + cur_image + '&v=' + a  + '&vtype='+videoType + '&youtube=' + youtubeID + '&url=' + url+'&Tagged='+tagp+'&origem='+origem;
			
			$('#wrapperfb').show();
			
			$.ajax({
				type: "POST",
				url: file+".php",
				data: dataString,
				cache: false,
				success: function(response){

					$('#midbox').prepend($(response).fadeIn('slow'));
					$("#url").val("http://");
					$("#watermark").val('');
					$("#attach_content").fadeOut("");
					$("#Show-Link-Box").fadeOut("");
					$('#shareButtons').show();
					$('#shareURLdiv').hide();
					$('#wrapperfb').hide();
					$("#tagged_people").val('');
                    parent.resizeFrame('childframe');
				 }
			 });
		}
	});	
});	

function loadNextcom(pid,total)
{
	var keepID = $('#keepID').val();
	var currentPage = $('#currentPage').val();
	
	$('#wrapperfb').show();
	
	$.post("collapsed.php?pid="+pid+'&x='+keepID+'&currentPage='+currentPage, {

	}, function(response){
		
		$('#wrapperfb').hide();
		var perPage = $('#perPage').val();
		
		 $('#CommentPosted'+pid).html($(response).fadeIn('slow'));
		 $('#collapsed_'+pid).hide();
		 
		 var loaded = perPage*currentPage;
		 
		 $('#currentPage').val(0);
		 
		 if( loaded >= total )
		 {
			 $('#numofcom'+pid).html(total); 
			 $('#com_paging_'+pid+' .next').html(lang_com_next);
		 }
		 else
			$('#numofcom'+pid).html(perPage*currentPage); 
				 
		 $('#currentPage').val(parseInt(currentPage)+parseInt(1));
         
         parent.resizeFrame('childframe');
				 
	});
}

function LoadWallVid(play,rand,youtube){
	
	$('#linkBox'+rand).html('&nbsp;<img src="loader.gif" alt="" />');
	
	if(youtube == 1)
	{
		var file = "youtube.php";
		$('#youtube'+rand+" iframe").attr('src', play);
		$('#youtube'+rand).fadeIn();
		$('#linkBox'+rand).hide();
		return false;
	}
	else
		var file = "video.php";
	
	$.ajax({
	   type: "GET",
	   data: "random="+rand+'&play=',
	   url: file+".php",
	   success: function(response){
			
			$('#container'+rand).html(response);
			$('#linkBox'+rand).hide();
	   },
	   error: function(response){
		
	   }
	});
}

$(document).ready(function(){	
	
	$('#watermark').bind('keyup', function() { 
			
		var a = $("#watermark").val();
		if(a != "")
		{				
			$('.gbutton').css('opacity', '1');
		}
		else
		{
			$('.gbutton').css('opacity', '.5');	 	
		}
	});
	
	$('#registerPopUp').livequery("click", function(){
		
		popup('popUpDiv');
		$('#popUpDiv div').html('');
	
		$('#popUpDiv div.data').html('Loading...');
		
		$.post("register.php", {
		}, function(response){
			
			$('#popUpDiv div').html(response);
			
		});
	});
	
	$('#updateProfile').livequery("click", function(){
		
		popup('popUpDiv');
		$('#popUpDiv div').html('');
		
		$('#popUpDiv div.data').html('Loading...');
		
		$.post("information.php", {
			}, function(response){
			$('#popUpDiv div').html(response);
		});
	});
	
	
	$('#cancelLogin').livequery("click", function(){
		
		jQuery('#loginDiv').hide(); return false;
	});
	
	$('#openLoggin').livequery("click", function(){
		
		jQuery('#loginDiv').fadeIn();return false;
	});
	
	$('a#upload_img').livequery("click", function(){
		
		$("#show_img_upload_div").fadeIn('');
	});	
	
});	

$(document).ready(function(){	
	
	$('#shareImageButton').livequery("click", function(){
		
		var keepID = $('#keepID').val();
		var posted_on = $('#posted_on').val();
		
		var tagp = $("#tagged_people").val();
		
		var a = $("#watermark").val();
		
		var image_url = $('#ajax_image_url').val();
		
		var video = $('#video').val();
		
		var pageUsing = $('#pageUsing').val();
		
		if(pageUsing == "profile")
			var file = "profile_wall";
		else
			var file = "member_wall";
			
		if(image_url != "")
		{
			$('#wrapperfb').show();
			
			var dataString = "image_url="+image_url+'&x='+keepID+'&p='+posted_on +'&v='+a+'&video='+video+'&Tagged='+tagp;

			$.ajax({
				type: "POST",
				url: file+".php",
				data: dataString,
				cache: false,
				success: function(response){

					$("#tagged_people").val('');
					$('#wrapperfb').hide();
					$('#midbox').prepend($(response).fadeIn('slow'));
					$("#thisimage").val("");
					$('#ajax_image_url').remove();
					$("#showthumb").html("");
					$("#show_img_upload_div").fadeOut("");
					$("#shareImageDiv").fadeOut("");
					$("#watermark").val("");
					$('#shareButtons').show();
				}
			});
		}
	});	
});	

function showimgs( uls )
{
	popup('popUpDiv');
	$('#popUpDiv div').html('');

	$('#popUpDiv div.data').html('<img src="'+uls+'" width="520" alt="Loading..."/>');
}

$(document).ready(function(){	

	// delete event
	$('#attach').bind("click", parse_link);
	
	function parse_link ()
	{
		if(!isValidURL($('#url').val()))
		{
			alert('Please enter a valid url.');
			return false;
		}
		else
		{
			var urlss = $('#url').val();
			
			$('#wrapperfb').show();
			$('#shareURLdiv').hide();
			//$('#attach').hide();
			
			$('#ftchurlz').html($('#url').val());
			///  http://youtu.be/pjyfMCTAqKU
			if (urlss.toLowerCase().indexOf("youtu.be") >= 0 || urlss.toLowerCase().indexOf("youtube.com") >= 0 || urlss.toLowerCase().indexOf("vimeo.com") >= 0)
			{
				var url = escape(urlss);
				// Call API to get a video oEmbed JSON response
				var key = '60570d3049ed11e1ab1c4040d3dc5c07';
				//http://vimeo.com/api/oembed.json?url=http%3A//vimeo.com/7100569
				
				if(urlss.toLowerCase().indexOf("vimeo.com") >= 0)
					$('#videoType').val(2); // vimeo link
				else
					$('#videoType').val(1); // youtube link
					
				var api_url = 'http://api.embed.ly/1/oembed?key=' + key + '&url=' + url + '&callback=?';
				//jQuery JSON call
				$.getJSON( api_url, function(response) {
					//Set Content
					$('#youtubeID').html(response.html);
					$('#ftchtitle').html(response.title);
					
					$('#ftchdesc').html(response.description);
					
					$('#ftchtotalimgs').html(1);
					
					$('#ftchimgz').html(' ');
					
					$('#ftchimgz').append('<img src="'+response.thumbnail_url+'" width="100" id="1">');
					
					$('#ftchimgz img').hide();
					
					//Flip Viewable Content 
					$('#attach_content').fadeIn();
					$('#shareURLdiv').fadeIn();
					//$('#attach').show();
					$('#wrapperfb').hide();
					
					//Show first image
					$('img#1').fadeIn();
					$('#cur_image').val(1);
					$('#cur_image_num').html(1);
					
				});
			}
			else
			{
				$.post("extractor.php?url="+escape($('#url').val()), {}, function(response){
				
				//Set Content
				$('#ftchtitle').html(response.title);
				$('#ftchdesc').html(response.description);
				$('#ftchtotalimgs').html(response.total_images);
				
				$('#ftchimgz').html(' ');
				
				$.each(response.images, function (a, b)
				{
					$('#ftchimgz').append('<img src="'+b.img+'" width="100" id="'+(a+1)+'">');
				});
				$('#ftchimgz img').hide();
				
				//Flip Viewable Content 
				$('#attach_content').fadeIn();
				$('#shareURLdiv').fadeIn();
				//$('#attach').show();
				$('#wrapperfb').hide();
				
				//Show first image
				$('img#1').fadeIn();
				$('#cur_image').val(1);
				$('#cur_image_num').html(1);
				$('#videoType').val(0);
				// next image
				$('#next').unbind('click');
				$('#next').bind("click", function(){
				 
					var total_images = parseInt($('#ftchtotalimgs').html());			 
					if (total_images > 0)
					{
						var index = $('#cur_image').val();
						$('img#'+index).hide();
						if(index < total_images)
						{
							new_index = parseInt(index)+parseInt(1);
						}
						else
						{
							new_index = 1;
						}
						
						$('#cur_image').val(new_index);
						$('#cur_image_num').html(new_index);
						$('img#'+new_index).show();
					}
				});	
				
				// prev image
				$('#prev').unbind('click');
				$('#prev').bind("click", function(){
				 
					var total_images = parseInt($('#ftchtotalimgs').html());				 
					if (total_images > 0)
					{
						var index = $('#cur_image').val();
						$('img#'+index).hide();
						if(index > 1)
						{
							new_index = parseInt(index)-parseInt(1);;
						}
						else
						{
							new_index = total_images;
						}
						
						$('#cur_image').val(new_index);
						$('#cur_image_num').html(new_index);
						$('img#'+new_index).show();
					}
				});	
			});
			}
		}
	};	
});

function isValidURL(url)
{
	var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	
	if(RegExp.test(url)){
		return true;
	}else{
		return false;
	}
}


function login(){
    parent.TINY.box.show({url:'http://www.revolucaobrasileira.com.br/account/login',boxid:'frameless',animate: true, mask:true, maskid:"bluemask", fixed:true,maskopacity:0});
    return false;
}

$(document).ready(function()
{	
	// tag in postings
	$("#watermark").livequery("keyup",function(e) 
	{
		var txtVal= $(this).val(); 
		var pos = txtVal.indexOf("@");
		
		while(pos > -1) {
			var atRate = pos;
			pos = txtVal.indexOf("@", pos+1);
		}
		
		if(atRate> -1)
		{
			var searchU = txtVal.substr(atRate);
			searchU = searchU.replace("@","");
			if(searchU == '')return;
			
			$.post("umtg.php?um=" + searchU, {
				
			}, function(response){
				
				$('#charkey_saver').val(searchU);
				if( response )
				$("#txtarea_tag_user_result_div").html( response ).show();
				else
				$("#txtarea_tag_user_result_div").hide();
			});
		}
		return false;
	});
	
	// tag comments
	$(".commentMark").livequery("keyup",function(e) 
	{
		var txtVal= $(this).val(); 
		
		var pixs = $(this).attr('id').replace('commentMark-', '');
		var pos = txtVal.indexOf("@");
		
		while(pos > -1) {
			var atR = pos;
			pos = txtVal.indexOf("@", pos+1);
		}
		
		if(atR> -1)
		{
			var searchU = txtVal.substr(atR);
			searchU = searchU.replace("@","");
			if(searchU == '')return;
			
			$.post("cmtg.php?um=" + searchU+'&pix='+pixs, {
				
			}, function(response){
				
				$('#Ccharkey_saver-'+pixs).val(searchU);
				if( response )
				$("#cmtgshow"+pixs).html( response ).show();
				else
				$("#cmtgshow"+pixs).hide();
				
			});
		}
	});	
	// uploading image
	$('#thisimage').livequery('change', function(){ 
		
		$("#showthumb").html('');
		$("#showthumb").html('<img src="loader.gif" alt="Uploading...."/>');
		
		$("#ajaxuploadfrm").ajaxForm({
			target: '#showthumb'
		}).submit();
		
		$("#shareImageDiv").fadeIn('');
		$("#shareImageButton").fadeIn('');
		
	});
	// upload profile image
	$('#profilepic').livequery('change', function(){ 
		
		$("#showthumbprofile").html('');
		$("#showthumbprofile").html('<img src="loader.gif" alt="Uploading...."/>');
		
		$("#signUpForm").ajaxForm({
			target: '#showthumbprofile'
		}).submit();
		
	});
});