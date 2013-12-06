<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
<div class="comments"><b><?php echo $review['author']; ?></b> | <img src="catalog/view/theme/<?=TEMPLATE?>/image/stars_<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['stars']; ?>" /><br />
  <?php echo $review['date_added']; ?><br />
  <br />
  <?php echo $review['text']; ?></div>
<?php } ?>
<div class="pagination"><?php echo $pagination; ?></div>
<?php } else { ?>
<div class="commentsType"><?php echo $text_no_reviews; ?></div>
<?php } ?>
