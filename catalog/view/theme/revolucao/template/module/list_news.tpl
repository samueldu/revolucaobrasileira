<?php echo $header; ?>
		<div class="heading"><?php echo $title_type ?></div>
<div class="news">
	<ul class="listNoticias">
		<?php foreach($posts as $post){ ?>
		<li><?php echo date('d/m/Y',strtotime($post["date_posted"]))?><br /><a href="<?php echo $post["href"]; ?>" class="title"><?php echo $post["subject"]?></a><br />
		<span class="description"><a href="<?php echo $post["href"]; ?>"><?php echo $post["descricao"]; ?><a/></span></li>
		<?php } ?>
	</ul>
</div>
	<?php echo $pagination; ?>
<?php echo $footer; ?> 