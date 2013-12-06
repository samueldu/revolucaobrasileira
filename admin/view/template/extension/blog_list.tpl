<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("<?=$confirm_delete?>")
	if (answer){
		$('#form').submit();
	}
}
//-->
</script>

<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>


<div class="box">
  <div class="left"></div>
  <div class="right"></div>
<div class="heading">
    <h1 style="background-image: url('view/image/module.png');"><?php echo $heading_title; ?></h1>
  <div class="buttons"><a onclick="location='<?php echo $add; ?>'" class="button"><span><?php echo $button_add; ?></span></a><a onclick="confirmation()" class="button"><span class="button_left button_delete"><?php echo $button_delete; ?></span></a></div>
</div>
</div>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
  <table class="list">
    <thead>
      <tr>
        <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
        <td class="left"><?php echo $column_subject; ?></td>
        <td class="right"><?php echo $column_status; ?></td>
        <td class="right"><?php echo $column_date_posted; ?></td>
        <td class="right"><?php echo $column_action; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php if ($posts) { ?>
      <?php $class = 'odd'; ?>
      <?php foreach ($posts as $post) { ?>
      <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
      <tr class="<?php echo $class; ?>">
        <td style="text-align: center;"><?php if ($post['selected']) { ?>
          <input type="checkbox" name="selected[]" value="<?php echo $post['post_id']; ?>" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="selected[]" value="<?php echo $post['post_id']; ?>" />
          <?php } ?></td>
        <td class="left"><?php echo $post['subject']; ?></td>
        <td class="right"><?php echo $post['status']; ?></td>
        <td class="right"><?php echo $post['date_posted']; ?></td>
        <td class="right"><?php foreach ($post['action'] as $action) { ?>
          [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
          <?php } ?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr class="even">
        <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</form>
<br />
<div class="success"><? echo $footblog;?></div>
<?php echo $footer; ?>