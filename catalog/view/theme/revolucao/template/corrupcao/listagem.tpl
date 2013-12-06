<?php echo $header; ?>

<?php echo $column_left; ?>

<Script>
function clearText(thefield){
if (thefield.defaultValue==thefield.value)
thefield.value = ""
} 
</script>

<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css" />  

	<div class="escandalos">
			
				<div class="tit-search">
					<h1 class="title">Corrupção no Brasil</h1>

					<!--input type="text"  value="Palavra-chave" onFocus="clearText(this)"/-->
					<div class="subject" style="right:15px">
					<span>Ordenar</span>
						<ul>
                            <li><a href="<?=BASE_URL?>conteudo/corrupcao/lista?ordem=recentes">Mais recentes</a></li>
                            <li><a href="<?=BASE_URL?>conteudo/corrupcao/lista?ordem=antigos">Mais antigos</a></li>
                            <li><a href="<?=BASE_URL?>conteudo/corrupcao/lista?ordem=graves">Mais graves</a></li>
                            <li><a href="<?=BASE_URL?>conteudo/corrupcao/lista?ordem=leves">Mais leves</a></li>
							<?
/*
							foreach($governos as $key=>$value)
							{
							?>
						
							<li><a href="#"><?=$governos[$key]['governo']?></a></li>
							<?
							}
							*/
							?>
						</ul>
					</div>
					
				</div><!-- tit search -->
				<div class="content grid three">  
				<?
								
				foreach($politicos as $key=>$value)
				{
				?>
					<div class="item escandalo-item">
						<h3><a href="conteudo/corrupcao?corrupcao_id=<?=$politicos[$key]['id']?>"><?=$politicos[$key]['titulo']?></a></h3>
						<em><?=$politicos[$key]['data']?></em>
						<div class="photos">
							<!--ul>
								<li><img src="<?=URL_TEMPLATE?>static/images/escandalos-thumb.png"/></li>
								<li><img src="<?=URL_TEMPLATE?>static/images/escandalos-thumb.png"/></li>
								<li><img src="<?=URL_TEMPLATE?>static/images/escandalos-thumb.png"/></li>
								<li><img src="<?=URL_TEMPLATE?>static/images/escandalos-thumb.png"/></li>
								<li><img src="<?=URL_TEMPLATE?>static/images/escandalos-thumb.png"/></li>
								<li><img src="<?=URL_TEMPLATE?>static/images/escandalos-thumb.png"/></li>
							</ul-->
						</div>
						<span><?=stripslashes($politicos[$key]['descricao'])?></span>
						
						<div class="share-holder">
							<div class="see-more">
									<a href="conteudo/corrupcao?corrupcao_id=<?=$politicos[$key]['id']?>">Veja mais</a>
							</div>

							<!--div class="badges">
								<div class="dislikes"><?=$politicos[$key]['like']?></div>
							</div-->

							<!--iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Frevolucaobrasileira.com.br&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font=arial&amp;height=21&amp;appId=143585905741403" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px; margin-left:20px; margin-top:5px;" allowTransparency="true"></iframe-->
							
						</div><!-- share holder -->
					</div><!-- content item, -->
				<?
				}
				?>
				</div><!-- content grid -->
				

			</div><!-- escandalos -->
			

<?php echo $column_right; ?>

<?php echo $footer ?>