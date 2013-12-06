<?php echo $header; ?>

<?php echo $column_left; ?>

			<link href="<?=URL_TEMPLATE?>static/css/escandalos.css" rel="stylesheet" type="text/css" />
				<div class="inner-content">
					<h1><?=$politicos[0]['titulo']?></h1>
                    <h2 style="color: #004B97; font-size: 20px"><?=$politicos[0]['data']?> - Governo <?=$politicos[0]['governo']?></h2>
                    <div class="escandalos">

					<div class="basic-text">
						<h4>História</h4>
					
						
						<?=stripslashes($politicos[0]['descricao'])?>
					
					</div>
					
					<?if($politicos[0]['desdobramento']!= ""){?>
					<div class="basic-text">
						<h4>Desdobramentos</h4>
						<p><?=$politicos[0]['desdobramento']?> </p>
					</div>
					
					<?
					}
					?>
					
					
					<div class="envolvidos">
						
						<div class="users">
							<ul>
							<?
							foreach($politicos[0]['personagens'] as $key=>$value)
							{
							?>
							
								<li class="active">
									<div class="photo"><img src="<?=$politicos[0]['personagens'][$key]['thumb']?>"/></div>
									<strong><?=$politicos[0]['personagens'][$key]['nome']?> </strong>
									<em><?=$politicos[0]['personagens'][$key]['funcao']?>									
																	
								<?if(isset($politicos[0]['personagens'][$key]['link']))
								{
								print "<A href=".$politicos[0]['personagens'][$key]['link']."><BR><B>Veja o perfil</b></a>";
								}
								?>
								</em>
									
								</li>
							<?
							}
							?>
							</ul>
						</div>
						
						<div class="users-content">                     
						<?
						foreach($politicos[0]['personagens'] as $key=>$value)
						{
						?>
							<div class="text">
								<p><?=stripslashes($politicos[0]['personagens'][$key]['oquefez'])?></p>
								
								<p><?=stripslashes($politicos[0]['personagens'][$key]['qqueaconteceu'])?></p>
								
								<?if(isset($politicos[0]['personagens'][$key]['link']))
								{
								print "<A href=".$politicos[0]['personagens'][$key]['link']."><b>Veja o perfil</b></a>";
								}
								?>
								
							</div>
						<?
						}
						?>

						</div><!-- users content -->
						
					</div><!-- envolvidos -->

                        <?
                        if(isset($politicos[0]['frases']))
                        {
                        ?>
					
					<div class="frases-marcantes" style="background-image:none;">
                        <h3>Frases marcantes</h3>
					
						<?
						foreach($politicos[0]['frases'] as $key=>$value)
						{
						?>						
						<div class="frase">
							<h5><?=$politicos[0]['frases'][$key]['frase']?></h5>
							<em><?=$politicos[0]['frases'][$key]['explicacao']?>.</em>
							<!--div class="badges">
								<div class="likes"><?=$politicos[0]['frases'][$key]['like']?></div>
								<div class="dislikes"><?=$politicos[0]['frases'][$key]['deslike']?></div>
							</div-->
						</div>
						<?
						}
						?>
					</div>

                        <?
                        }
                        ?>

                    <!-- frases marcantes -->
					
					
					<div class="casos-semelhantes">
						
						<h3>Outros casos relevantes</h3>


                        <?
                        foreach($casos_semelhantes as $key=>$value)
                        {
                        ?>

                        <div class="caso">
                            <h5><a href="conteudo/corrupcao?corrupcao_id=<?=$casos_semelhantes[$key]['id']?>"><?=$casos_semelhantes[$key]['titulo']?></a></h5>
                            <strong><?=$casos_semelhantes[$key]['data']?></strong>
                            <span><a href="#"><?=$casos_semelhantes[$key]['descricao']?>...</a></span>
                        </div>
                        <?
                        }
                        ?>

					</div>
					
					
				</div><!-- innercontent -->
				
				
				
			</div><!-- escandalos -->

<?php echo $column_right; ?>

<?php echo $footer ?>