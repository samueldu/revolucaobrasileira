<div class="menu">
	<!--?php echo $category; ?-->
<ul>
    <li style="width:80px" ><a href="bermuda" <? if(substr_count($category_id,"bermuda")) print "class=\"selected\""; ?>>BERMUDA</a></li>
    <li style="width:60px"><a href="blusa" <? if(substr_count($category_id,"blusa")) print "class=\"selected\""; ?>>BLUSA</a></li>
    <li style="width:60px"><a href="calca" <? if(substr_count($category_id,"calca")) print "class=\"selected\""; ?>>CALÇA</a></li>
    <li><a href="camisa" <? if(substr_count($category_id,"camisa")) print "class=\"selected\""; ?>>CAMISA</a></li>
    <li style="width:95px"><a href="casaqueto" <? if(substr_count($category_id,"casaqueto")) print "class=\"selected\""; ?>>CASAQUETO</a></li>
    <li style="width:66px"><a href="colete" <? if(substr_count($category_id,"colete")) print "class=\"selected\""; ?>>COLETE</a></li>
    <li style="width:80px"><a href="corselet" <? if(substr_count($category_id,"corselet")) print "class=\"selected\""; ?>>CORSELET</a></li>
    <li style="width:75px"><a href="jaqueta" <? if(substr_count($category_id,"jaqueta")) print "class=\"selected\""; ?>>JAQUETA</a></li>
    <li style="width:78px"><a href="macacao" <? if(substr_count($category_id,"macacao")) print "class=\"selected\""; ?>>MACACÃO</a></li>
    <li style="width:80px"><a href="mini-vest" <? if(substr_count($category_id,"mini-vest")) print "class=\"selected\""; ?>>MINI VEST</a></li>
    <li><a href="regata" <? if(substr_count($category_id,"regata")) print "class=\"selected\""; ?>>REGATA</a></li>
    <li style="width:50px"><a href="saia" <? if(substr_count($category_id,"saia")) print "class=\"selected\""; ?>>SAIA</a></li>
    <li style="width:65px"><a href="short" <? if(substr_count($category_id,"short")) print "class=\"selected\""; ?>>SHORT</a></li>
    <li><a href="vestido" <? if(substr_count($category_id,"vestido")) print "class=\"selected\""; ?>>VESTIDO</a></li>
</ul>
</div>