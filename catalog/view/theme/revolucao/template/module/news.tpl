<?php echo $header; ?>

<div id="blogInterna">
		<div class="heading">NotÃ­cias</div>
			<div id="blBlogInterna">
			<?php foreach ($posts as $post) {
			$post_id = $post['post_id'];?>
			<div class="headBlog"><?php echo $post['subject']; ?></div>
			<div class="blog_tagline"><?php echo $post['date_posted']." ".$by." ".$post['author']; ?></div>
			<div class="blog_content"><?php echo $post['content']; ?></div>
				<?php foreach ($post['images'] as $image){ ?>
					<?php echo "<img src='".$image["thumb"]."'>"; ?>
				<?php } ?>
			<?php } ?>
			<?php if(isset($post['embed'])){ ?>
			<div class="media"><?php echo $post['embed'] ?></div>
			<?php } 
			
			
			if(isset($posts_relacionados))
			foreach($posts_relacionados as $key=>$value)
			{
				if($post_id == $posts_relacionados[$key]['post_id'])
				unset($posts_relacionados[$key]);
			}
			
			if(isset($posts_relacionados) and count($posts_relacionados)>0)
			{
			?>
			Notícias relacionadas
			
			<?
			foreach($posts_relacionados as $key=>$value)
			{
				if($post_id != $posts_relacionados[$key]['post_id'])
				print "<BR><BR><a href=".$posts_relacionados[$key]['href'].">".$posts_relacionados[$key]['titulo']."</a>";
			}
			}
			?>
			
			
			</div>

<?php echo $footer; ?> 