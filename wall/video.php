<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/?>
<script type="text/javascript">
								
								$(document).ready(function() {
									$("#sub<?=@$_REQUEST['random']?>").oembed("<?php echo @$_REQUEST['play']?>", 
														{
														embedMethod: "append", 
														maxWidth: 400,
														maxHeight: 350,
														vimeo: { autoplay: true, maxWidth: 400, maxHeight: 350}                 
														});						   
								});
						</script><span id="sub<?=@$_REQUEST['random']?>"></span>