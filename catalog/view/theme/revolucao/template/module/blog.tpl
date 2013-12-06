<?php $first = true;?>
<div id="blog">
		<div class="heading">Notícias</div>
			<div id="blBlog">
			<?php
			
			//print_r($posts);
			
			$post = $posts[0]; 
			unset($posts[0])?>
			<div class="media"><?php echo (empty($post['youtube']) && empty($post['images'][0]["thumb"]))?"":empty($post['youtube'])? "<img src='".$post['images'][0]["thumb"]."'>" : $post['youtube'] ?></div>
			<div class="headBlog"><a href="<?php echo $post['href']; ?>"><?php echo $post['subject']; ?></a></div>
			<div class="blog_tagline"><?php echo date('d/m/Y',strtotime($post['date_posted'])); ?></div>
			<div class="blog_content"><?php echo $post['resumo']; ?></div>
			</div>
			
		<div id="mNoticias">
			<span class="headNoti">Mais Notícias</span>
			<?php foreach ($posts as $post){ ?>
			<span class="datNoti"><?php echo date('d/m/Y',strtotime($post["date_posted"]))?><a href="<?php echo $post['href']; ?>"><?php echo $post['subject']; ?></a></span>
			<span class="descNoti"><a href="<?php echo $post['href']; ?>"><?php echo $post['descricao']; ?></a></span>
			<?php } ?>
		</div>
</div>