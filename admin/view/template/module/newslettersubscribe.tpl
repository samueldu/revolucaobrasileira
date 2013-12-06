<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/module.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><?php echo $entry_position; ?></td>
          <td><select name="newslettersubscribe_position">
              <?php if ($newslettersubscribe_position == 'left') { ?>
              <option value="left" selected="selected"><?php echo $text_left; ?></option>
              <?php } else { ?>
              <option value="left"><?php echo $text_left; ?></option>
              <?php } ?>
              <?php if ($newslettersubscribe_position == 'right') { ?>
              <option value="right" selected="selected"><?php echo $text_right; ?></option>
              <?php } else { ?>
              <option value="right"><?php echo $text_right; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_unsubscribe; ?></td>
          <td><select name="option_unsubscribe">
              <?php if ($option_unsubscribe) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="newslettersubscribe_status">
              <?php if ($newslettersubscribe_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>

        <tr>
          <td><?php echo $entry_mail; ?> </td>
          <td><select name="newslettersubscribe_mail_status">
              <?php if ($newslettersubscribe_mail_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select> </td>
        </tr>
        <tr>
          <td><?php echo $entry_thickbox; ?> </td>
          <td><select name="newslettersubscribe_thickbox">
              <?php if ($newslettersubscribe_thickbox) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select> </td>
        </tr>
        <tr>
          <td><?php echo $entry_registered; ?>
          <span class="help"> When you enable this option open cart registered users also can subscribe or un subscribe using this.
          
          </span>
          </td>
          <td><select name="newslettersubscribe_registered">
              <?php if ($newslettersubscribe_registered) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="newslettersubscribe_sort_order" value="<?php echo $newslettersubscribe_sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
          <td><?php echo($entry_options); ?> </td>
          <td> 
          <?php 
            $tmp_option_list = array('Select','1','2','3','4','5','6');
          ?>
          <select name="newslettersubscribe_option_field" onchange="load_options(this.value)">  
              <?php  
                foreach($tmp_option_list as $key=>$opt) {
                  if($newslettersubscribe_option_field == $key){
                    echo("<option value='".$key."' selected='selected'>".$opt."</option>");
                  }else{
                    echo("<option value='".$key."'>".$opt."</option>");
                  }
                }
              ?>                 
                </select> 
          </td>
        </tr>
        <tfoot>
         <?php  for($l=1;$l<=$newslettersubscribe_option_field;$l++){ 
            $field_var = "newslettersubscribe_option_field".$l;
         ?>
            <tr>
              <td> <?php echo("Option".$l); ?> </td>
              <td> 
              <input type='text' name='newslettersubscribe_option_field<?php echo($l); ?>' value='<?php echo($$field_var); ?>'>
               </td>
            </tr>
          <?php  }  ?>
        </tfoot>
      </table>
    </form>
  <?php echo $text_info; ?>
  </div>
</div>
<?php echo $footer; ?>
<script language="javascript">
function load_options(cnt) {
   var html="";
   for(i=1;i<=cnt;i++) {
     html = html + "<tr> <td> Option"+i+"</td><td> <input type='text' name='newslettersubscribe_option_field"+i+"' value=''></td></tr>";
   }	
  $('.form tfoot').html(html);
}
</script>