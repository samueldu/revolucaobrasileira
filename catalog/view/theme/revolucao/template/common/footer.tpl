		<div id="footer" style="float:left">
			<div class="footer_links">

				<?php foreach ($informations as $information) { ?>

                <?
                if($information['title'] != "Urnas inseguras" and $information['title'] != "Ajuda")
                {
                ?>

                <a href="<?php echo str_replace('&', '&amp;', $information['href']); ?>"><?php echo $information['title']; ?></a>
                <?php
				}
				}
				?><a href="information/contact"  style="border:none">Contato</a> 
			</div>
            
            <div class="server_logo"><a href="http://www.piratehost.net" target="_blank"><img src="catalog/view/theme/revolucao/image/piratehost.png" alt="Pirate Host" title="Hospedado por Pirate Host" /></a></div>
		</div>

			<?php
		  foreach ($modules as $module) { ?>
			<?php echo ${$module['code']}; ?>
			<?php } ?>
	
	
	</body>
</html>