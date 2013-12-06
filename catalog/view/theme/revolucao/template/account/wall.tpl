<?php echo $header; ?>

<style>


img { border: 0;}

ul { line-height: 120%; }

h1 { color: #444; font-weight: bold; font-size: 1.7em; line-height: 2.0em; }
h2 { font-size: 1.4em; letter-spacing: -0.04em; line-height: 1.8em; }
h3 {   }
h4 {  font-size: 1.1em; line-height: 1.3em; margin-bottom: 10px; }

/* @group core */
.wrapper { width: 850px; overflow: hidden; margin: 0 auto; background: none; }

header { height: 100px; background-color: #afafaf; }

header #usernav { float: right; line-height: 100px; font-size: 14px; font-weight: bold; color: #555; }
header #usernav a { color: #444; text-shadow: 0px 1px 1px #ddd; }

header #usernav a span img { position: relative; top: 8px; background: #cecece; margin-left: 5px; padding: 3px; border: 1px solid #969696; }

#contentBoxProfile { display: block;  margin: 0 auto;  
  font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif; }

#left { display: block; width: 660px; float: left; overflow: hidden; margin-right: 20px; }
#right { display: block; width: 270px; float: right; overflow: hidden; }

/* @group navigation */
nav { width: auto; background: #eee; height: 45px; border-bottom: 1px solid #dadada; margin-bottom: 30px; }

ul#n { width: 850px; margin: 0 auto; display: block; list-style: none; }
ul#n li { float: left; line-height: 45px; border: 3px solid #eee; border-top: 0px; border-bottom: 0px; }
ul#n li a { display: block; padding: 0 11px; color: #969696; font-size: 15px; font-weight: bold; text-shadow: 0px 1px 1px #fff; }

ul#n li.sel { background: #b4e127; border: 3px solid #c1ff00; border-top: 0px; border-bottom: 0px; }
ul#n li.sel a { color: #fff; text-shadow: 0px 1px 2px #88b618; }

/* @group left */
#userStats { display: block; width: auto; background-color: #f9f9f9; border: 1px solid #ccc; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; padding: 12px; }

#userStats .pic { float: left; display: block; margin-right: 10px; }
#userStats .pic a img { padding: 7px; background: #fff; border: 1px solid #ccc; }

#userStats .data { float: left; display: block; position:  relative; width: 450px; height: 166px; padding: 4px; padding-left: 15px; overflow:  hidden; box-sizing: border-box; -moz-box-sizing: border-box; }
#userStats .data h1 { color: #474747; line-height: 1.6em; text-shadow: 0px 1px 1px #fff; }
#userStats .data h3 { color: #666; line-height: 0.9em; margin-bottom: 5px; }
#userStats .data h4 { font-size: 1.2em; line-height: 1.3em; }

#userStats .data .socialMediaLinks { position: absolute; right: 6px; top: 8px; }
#userStats .data .socialMediaLinks a { background:url(catalog/view/theme/revolucao/image/add1.png) 8px center no-repeat #e9e9e9; border-radius:3px; padding: 3px 8px 3px 22px; border:1px solid #ccc }
#userStats .data .socialMediaLinks a:hover { 
	border-color:#999;
	background-color:#ddd
}
#userStats .data .socialMediaLinks a img { margin-right: 5px; }

#userStats .data .sep { clear: both; margin-top: 20px; width: 100%; height: 1px; border-bottom: 1px solid #ccc; margin-bottom: 0; }
#userStats .data ul.numbers { list-style: none; width: 100%; padding-top: 7px; margin-top: 0; border-top: 1px solid #fff; color: #676767; }
#userStats .data ul.numbers li { width: 33%; float: left; display: block;  height: 50px; text-align:center; border-right: 1px dotted #bbb; text-transform: uppercase; }
#userStats .data ul.numbers li strong { color: #434343; display: block; font-size: 30px; line-height: 1.1em; font-weight: bold; }

/* @group right */
#right .gcontent { display: block; margin-bottom: 20px; }
#right .gcontent .head { background: #589fc6; border: 1px solid #3e82a7; padding-left: 8px;border-radius: 5px 5px 0 0 }
#right .gcontent .head {   background: none repeat scroll 0 0 #589FC6;
    border: 1px solid #3E82A7;
    border-radius: 5px 5px 0 0;
    color: #FFFFFF;
    font-size: 17px;
    padding: 8px;}

#right .gcontent .boxy { border-radius: 0px 0px 5px 5px; border: 1px solid #ccc; border-top: 0px; padding: 10px 8px; background: #f9f9f9; }

#right .gcontent .boxy .badgeCount { margin-bottom: 30px;  }
#right .gcontent .boxy .badgeCount a img { margin-right: 8px; }
#right .gcontent .boxy span { font-size: 1em; display: block; margin-bottom: 7px; }

#right .gcontent .boxy .friendslist { display: block; margin-bottom: 15px; }
#right .gcontent .boxy .friend {     
	border-bottom: 1px solid #CCCCCC;
    float: left;
    height: 40px;
    padding: 5px 0;
    width: 100%;}
#right .gcontent .boxy .friend img { border: 1px solid #ccc; float: left; padding: 2px; background: #fff; margin-right: 4px; }
#right .gcontent .boxy .friend .friendly { position: relative; top: 6px; font-size: 1.1em; }
#right .gcontent .boxy .friend .friendly a {
	display:block
}
#right .gcontent .boxy a:hover {
	color:#589FC6
}
/** @group clearfix **/
.clearfix:after { content: "."; display: block; clear: both; visibility: hidden; line-height: 0; height: 0; }
.clearfix { display: inline-block; }
 
html[xmlns] .clearfix { display: block; }
* html .clearfix { height: 1%; }

.nobrdr { border: 0px !important; }

</style>

    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
       <div class="central">
       <?
       $headers = get_headers('https://graph.facebook.com/'.$name['facebook_id'].'/picture?type=large',1);
    if(isset($headers['Location'])) {
        $url = $headers['Location']; // string
    } else {
        $url = false; // nothing there? .. weird, but okay!
    }
    ?>
    
                                            <?
                                            
                                            $status = "";
                                            
                    if($origem == 4 and $id_wall!=$id)
                    {

                        if($friendship['confirm'] == "1")
                        {
                        $status = "Amigos";
                        }
                        elseif($friendship['confirm'] == "0")
                        {
                        $status = "<a id='link' href=javascript:add(".$id_wall.",".$id.")>Adicionar ".$name['firstname']."</a><div id='adicionado' style='display: none'>Adicionado!</div><BR><BR>";
                        }
                        elseif($friendship['confirm'] == "A")
                               {
                               $status = "Solicitação de amizade enviada";
                               }
                    }

                    $status = utf8_encode($status);

                    //
                    ?>


<div id="content carrinho">
  <div class="middle account">

  <div id="contentBoxProfile" class="clearfix">
        <section id="left">
            <div id="userStats" class="clearfix">
                <div class="pic">
                    <a href="#"><img src="<?=$url?>" width="150" height="150" /></a>
                </div>

                <div class="data">
                    <h1><?php echo $name['firstname']; ?></h1>
                    <!--h3 style="font-size:1.2em"></h3>
                    <h4></h4-->
                    <div class="socialMediaLinks">
                        <!--a href="http://twitter.com/jakerocheleau" rel="me" target="_blank"><img src="<?=HTTP_IMAGE?>data/profile/twitter.png" alt="@jakerocheleau" /></a-->
                        <!--a href="http://gowalla.com/users/JakeRocheleau" rel="me" target="_blank"><img src="<?=HTTP_IMAGE?>data/profile/gowalla.png" /></a-->                        <?=$status?>

                    </div>
                    <div class="sep"></div>
                    <ul class="numbers clearfix">
                        <li>Debates<strong><a style="font-size: 14px;" href="debate/debate/inserir">Inicie um!</a></strong></li>
                        <li class="nobrdr">Comentários<strong >0</strong></li>
                        <!--li class="nobrdr">Days Out<strong>127</strong></li-->
                    </ul>
                </div>
            </div>


        </section>

        <section id="right">

        <?
        if(isset($pendingFriends) and $id == $id_wall and count($pendingFriends) > 0)
        {
        ?>

            <!--div class="gcontent">
                <div class="head"><?=utf8_encode("Solicitações pendentes")?> (<?=count($pendingFriends)?>)</div>
                <div class="boxy">

                    <div class="badgeCount">

                    <?
                    if(count($pendingFriends) ==0)
                    {
                        print utf8_encode("Nenhuma soliticação pendente.");
                    }
                    else
                    {
                        foreach($pendingFriends as $key=>$value)
                        {
                        ?>
                        <?=$pendingFriends[$key]['firstname']." ".$pendingFriends[$key]['lastname']?> <a href="javascript:confirm(<?=$pendingFriends[$key]['toid']?>,<?=$pendingFriends[$key]['fromid']?>)">Confirmar</a> - <a href=>X</a>
                        <?
                        }
                    }
                    ?>

                    </div>


                </div>
            </div-->

            <?
            }
            ?>

                    <?
        if(isset($myPendingFriends) and $id_wall == $_SESSION['customer_id'])
        {
        ?>

            <!--div class="gcontent">
                <div class="head"><?=("Minhas solicitações")?> (<?=count($myPendingFriends)?>)</div>
                <div class="boxy">

                    <div class="badgeCount">

                    <?
                    if(count($myPendingFriends) ==0)
                    {
                        print ("Nenhuma soliticação pendente.");
                    }
                    else
                    {
                        foreach($myPendingFriends as $key=>$value)
                        {
                        ?>
                        <a href="account/wall?id_wall=<?=$myPendingFriends[$key]['customer_id']?>&origem=4&id=<?=$_SESSION['customer_id']?>"><?=$myPendingFriends[$key]['firstname']." ".$myPendingFriends[$key]['lastname']?></a> - <a href=>Cancelar</a>
                        <?
                        }
                    }
                    ?>

                    </div>
                    
                    <span><a href="#">See all</a></span>
                </div>
            </div-->
            
            <?
            }
            ?>
            
            <div class="gcontent">
                <div class="head">Amigos</div>
                <div class="boxy">
                    <!--p></p-->
                    
                    <div class="friendslist clearfix">
                    
                    <?
                    foreach($friends as $key=>$value)
                    {
                    ?>
                    <div class="friend">
                    <a href="account/wall?id_wall=<?=$friends[$key]['customer_id']?>&origem=4&id=<?=$_SESSION['customer_id']?>"><img src="<?=$friends[$key]['avatar']?>" width="30" height="30" alt="<?=$friends[$key]['firstname']?>" /><span class="friendly"><?=$friends[$key]['firstname']?></a></span>
                        </div>
                        
                        <?
                        }
                        ?>
                    </div>
                    
                    <span><a href="#">Ver todos...</a></span>
                </div>
            </div>
        </section>
    </div>
  


<?
wall($id_wall,4);
?>
 
  </div>
</div>

<Script>
function add(meuId,amigoId)
{

	var dataString = "toid="+meuId+'&fromid='+amigoId;   
	
	$.ajax({ 
	type: "POST",
	url: "ajax/ajax/add",
	data: dataString,
	cache: false,
	success: function(response){

         document.getElementById("link").style.display="none";
        document.getElementById("adicionado").style.display="block";
//        alert('Adicionado');
			  
		}
	});
}

    function confirm(meuId,amigoId)
    {

        var dataString = "toid="+meuId+'&fromid='+amigoId;

        $.ajax({
            type: "POST",
            url: "ajax/ajax/confirm",
            data: dataString,
            cache: false,
            success: function(response){

                document.getElementById("link").style.display="none";
                document.getElementById("adicionado"+amigoId).style.display="block";

            }
        });
    }

    </script>

<?php echo $footer; ?> 