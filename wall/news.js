/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
Copy Rights Reserved by 99points
*/
function taglistComments(uname, ID, pix) 
{
	uname = uname.toUpperCase();
	
	uname = "["+uname+"] ";
	
	var vl= $("#commentMark-"+pix).val();
	
	vl = vl.replace('@'+$('#Ccharkey_saver-'+pix).val(),uname);
	
	$("#commentMark-"+pix).val(vl).focus(); 
	
	var values = $("#tagged_peopleC"+pix).val();
	
	if(values)
		$("#tagged_peopleC"+pix).val(values+",".concat(ID));
	else
		$("#tagged_peopleC"+pix).val(ID);		
	
	$("#cmtgshow"+pix).hide();
	
	return;
}

function taglistPosts(uname, ID) 
{
	uname = uname.toUpperCase();
	
	uname = "["+uname+"] ";
	
	var txtVal= $("#watermark").val(); 
	
	txtVal = txtVal.replace('@'+$('#charkey_saver').val(),uname);
	
	$("#watermark").val(txtVal); 
	
	var values = $("#tagged_people").val();
	
	if(values)
		$("#tagged_people").val(values+",".concat(ID));
	else
		$("#tagged_people").val(ID);
		
	$("#txtarea_tag_user_result_div").hide();
	return;
}
	
$(document).ready(function(){	
	
		$('.commentMark').val(lang_write_comment);	
		$("#tagged_people").val('');
		
		
		$('#shareButtons').click(function(){
			
			var a = $("#watermark").val();
			if(a != "")
			{
				$('#wrapperfb').show();
				var keepID = $('#keepID').val();
				var posted_on = $('#posted_on').val();
				var tagp = $("#tagged_people").val();
				var pageUsing = $('#pageUsing').val();
				var origem = $('#origem').val();  
				
				if(pageUsing == "profile")
                {
					var file = "profile_wall";
                }
                else if(pageUsing == "debate")
                {
                    var file = "debate_wall";
                }
				else
                {
					var file = "member_wall";
                }
				
				var dataString = "value="+a+'&x='+keepID+'&p='+posted_on+'&Tagged='+tagp+'&origem='+origem;
				
				$.ajax({
				type: "POST",
				url: file+".php",
				data: dataString,
				cache: false,
				success: function(response){
						
						$("#tagged_people").val('');
						$('#wrapperfb').hide();
						$('#midbox').prepend($(response).fadeIn('slow'));
						$("#watermark").val("");
					 }
				 });
			}
		});	
 
		//showCommentBox
		$('a.showCommentBox').livequery("click", function(e){
			
			var getpID =  $(this).attr('id').replace('post_id','');	
			
			$("#commentBox-"+getpID).css('display','');
			$("#commentMark-"+getpID).focus();
			$("#commentBox-"+getpID).children("img.CommentImg").show();			
			//$("#commentBox-"+getpID).children("a#SubmitComment").show();		
		});	
		
		// show collapsed comments
		$('.collapsed').livequery("click", function(e){
			
			$('#wrapperfb').show();
			var pid = $(this).attr('id').replace('collapsed_','');	
			
			var keepID = $('#keepID').val();
			
			var dataString = "pid="+pid+'&x='+keepID;

			$.ajax({
				type: "POST",
				url: "collapsed.php",
				data: dataString,
				cache: false,
				success: function(response){

				$('#CommentPosted'+pid).html($(response).fadeIn('slow'));
				$('#collapsed_'+pid).hide();
				$('#wrapperfb').hide();
				$('#com_paging_'+pid).fadeIn();
				}
			});
		});	
		
		$(".commentMark").livequery("keydown", function(e){
										   //
			if (e.keyCode == 13 && e.shiftKey)
			{
			}
			else if ( e.which == 13 ) 
			{
			  var getpID =  $(this).parent().attr('id').replace('record-','');	
			  var comment_text = $("#commentMark-"+getpID).val();
			  
			  if(comment_text == "")
				return false;
				
				var tagp = $("#tagged_peopleC"+getpID).val();
				
				$(this).attr("disabled", "disabled");
				var keepID = $('#keepID').val();
                var answer = $('#answer').val();
				//$('.commentBox').hide();
				if(comment_text != lang_write_comment)
				{

					$.post("add_comment.php?answer="+answer+"&comment_text="+comment_text+"&post_id="+getpID+'&x='+keepID+'&Tagged='+tagp, {
		
					}, function(response){
						
						$('#CommentPosted'+getpID).append($(response).fadeIn('slow'));
						$("#commentMark-"+getpID).attr("disabled", "");
						$("#commentMark-"+getpID).focus();
						$("#tagged_peopleC-"+getpID).val('');
						$("#commentMark-"+getpID).val("");					
					});
				}
			}
		});
		
		//deleteComment
		$('a.c_delete').livequery("click", function(e){
			
			if(confirm(delete_com_alert)==false)

			return false;
	
			e.preventDefault();
			var parent  = $(this).parent();
			var c_id =  $(this).attr('id').replace('CID-','');	
			
			$.ajax({

				type: 'get',

				url: 'delete_comment.php?c_id='+ c_id,

				data: '',

				beforeSend: function(){

				},

				success: function(){

					parent.fadeOut(200,function(){

						$('#record-'+c_id).remove();

					});
				}
			});
		});	
		
		/// hover show remove button
		$('.friends_area').livequery("mouseenter", function(e){
			$(this).children("a.delete").show();	
		});	
		$('.friends_area').livequery("mouseleave", function(e){
			$('a.delete').hide();	
		});	
		
		/// hover show remove button
		
		$('a.delete_p').livequery("click", function(e){

		if(confirm(delete_post_alert)==false)
		return false;
		
		e.preventDefault();

		var parent  = $(this).parent();

		var temp    = parent.attr('id').replace('record-','');

		var main_tr = $('#'+temp).parent();

			$.ajax({

				type: 'get',
				url: 'delete.php?id='+ parent.attr('id').replace('record-',''),
				data: '',
				beforeSend: function(){
				},

				success: function(){

					parent.fadeOut(200,function(){
						
						$('#record-'+temp).parent().remove();
						//main_tr.remove();
					});
				}
			});
		});

		$('textarea').elastic();

		function UseData(){
		   $.Watermark.HideAll();
		   //Do Stuff
		   $.Watermark.ShowAll();
		}
	});			
	/////#####################
	
	function likethis( member_id, post_id, action)
	{
		if(!action)action=1;
		$('#like-panel-'+post_id).html('&nbsp;<img src="load.gif" alt="" />');
		
		$.post("likes.php?member_id="+member_id+"&post_id="+post_id+'&action='+action, {
		}, function(response){
			
			if(response > 0)
			{
				$('#ppl_like_div_'+post_id).show();
				$('#like-stats-'+post_id).html(response);
			}
			else if(response == 0)
			{
				$('#ppl_like_div_'+post_id).hide();
				$('#like-stats-'+post_id).html(response);	
			}
			
			if(action == 2)
			{
				$('#like-panel-'+post_id).html('&nbsp;<a href="javascript: void(0)" id="post_id'+post_id+'" onclick="javascript: likethis('+member_id+','+post_id+', 1);">'+language_like+'</a>');
			}
			else
			{
				$('#like-panel-'+post_id).html('&nbsp;<a href="javascript: void(0)" id="post_id'+post_id+'" class="Unlike" onclick="javascript: likethis('+member_id+','+post_id+', 2);">'+language_unlike+'</a>');
			}
		});
	}

	function showList( post_id )
	{
		popup('popUpDiv');
		$('#popUpDiv div').html('');
		$('#popUpDiv div').html('Loading...');
		
		$.post("likes.php?post_id="+post_id+'&action=3', {
		}, function(response){
			
			$('#popUpDiv div').html(response);
			
		});
	}

////

function Clikethis( member_id, comment_id, action)
{
	if(!action)action=1;
	$('#clike-panel-'+comment_id).html('&nbsp;<img src="load.gif" alt="" />');

	$.post("clikes.php?post_id="+comment_id+'&member_id='+member_id+'&action='+action, {
	 }, function(response){
		
		if(response > 0)
		{
			$('#ppl_clike_div_'+comment_id).show();
			$('#clike-stats-'+comment_id).html(response);
		}
		else if(response == 0)
		{
			$('#ppl_clike_div_'+comment_id).hide();
			$('#clike-stats-'+comment_id).html(response);
		}
		
		$('#clike-stats-'+comment_id).html(response);
		
		if(action == 2)
		{
			$('#clike-panel-'+comment_id).html('&nbsp;<a href="javascript: void(0)" id="comment_id'+comment_id+'" onclick="javascript: Clikethis('+member_id+','+comment_id+', 1);">'+language_like+'</a>');
		}
		else
		{
			$('#clike-panel-'+comment_id).html('&nbsp;<a href="javascript: void(0)" id="comment_id'+comment_id+'" class="Unlike" onclick="javascript: Clikethis('+member_id+','+comment_id+', 2);">'+language_unlike+'</a>');
		}
	});
}

function showCList( post_id )
{
	popup('popUpDiv');
	$('#popUpDiv div').html('');
	$('#popUpDiv div').html('Loading...');
	
	$.post("clikes.php?post_id="+post_id+'&action=3', {
	}, function(response){
		
		$('#popUpDiv div').html(response);
		
	});
}

function SubmitComment(myfield,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13)
	{
		
	}
	else
	return true;
}

function shwImg(src)
{
	popup('popUpDiv');
	$('#popUpDiv div').html('');
	$('#popUpDiv div').html('Loading...');	
	
	$('#popUpDiv div').html('<img src="'+src+'" alt="" />');
}


/////////////////////////////////////////////// OPEN POPUP
function toggle(div_id) {
	var el = document.getElementById(div_id);
	if ( el.style.display == 'none' ) {	el.style.display = 'block';}
	else {el.style.display = 'none';}
}
function blanket_size(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportheight = window.innerHeight;
	} else {
		viewportheight = document.documentElement.clientHeight;
	}
	if ((viewportheight > document.body.parentNode.scrollHeight) && (viewportheight > document.body.parentNode.clientHeight)) {
		blanket_height = viewportheight;
	} else {
		if (document.body.parentNode.clientHeight > document.body.parentNode.scrollHeight) {
			blanket_height = document.body.parentNode.clientHeight;
		} else {
			blanket_height = document.body.parentNode.scrollHeight;
		}
	}
	var blanket = document.getElementById('blanket');
	blanket.style.height = blanket_height + 'px';
	var popUpDiv = document.getElementById(popUpDivVar);
	popUpDiv_height=blanket_height/2-150; 
	//// 150 is half popups height 
	popUpDiv.style.top = getPageScroll2()[1] + (getPageHeight2() / 10);
}
function window_pos(popUpDivVar) {
	
	if (typeof window.innerWidth != 'undefined') {
		viewportwidth = window.innerHeight;
	} else {
		viewportwidth = document.documentElement.clientHeight;
	}
	if ((viewportwidth > document.body.parentNode.scrollWidth) && (viewportwidth > document.body.parentNode.clientWidth)) {
		window_width = viewportwidth;
	} else {
		if (document.body.parentNode.clientWidth > document.body.parentNode.scrollWidth) {
			window_width = document.body.parentNode.clientWidth;
		} else {
			window_width = document.body.parentNode.scrollWidth;
		}
	}
	var popUpDiv = document.getElementById(popUpDivVar);
	window_width=window_width/2-350;
	//150 is half popup's width
	popUpDiv.style.top = getPageScroll2()[1] + (getPageHeight2() / 10)+'px';
	popUpDiv.style.left = window_width + 'px';
	
}
function popup(windowname) {
	//(windowname);
	window_pos(windowname);
	//toggle('blanket');
	toggle(windowname);		
}

 // getPageScroll() by quirksmode.com
  function getPageScroll2() {
	var xScroll, yScroll;
	if (self.pageYOffset) {
	  yScroll = self.pageYOffset;
	  xScroll = self.pageXOffset;
	} else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
	  yScroll = document.documentElement.scrollTop;
	  xScroll = document.documentElement.scrollLeft;
	} else if (document.body) {// all other Explorers
	  yScroll = document.body.scrollTop;
	  xScroll = document.body.scrollLeft;
	}
	return new Array(xScroll,yScroll)
  }

  // Adapted from getPageSize() by quirksmode.com
  function getPageHeight2() {
	var windowHeight
	if (self.innerHeight) {	// all except Explorer
	  windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
	  windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
	  windowHeight = document.body.clientHeight;
	}
	return windowHeight
  }
