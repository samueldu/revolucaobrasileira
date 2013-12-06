  <div class="middle account" >
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error) { ?>
    <div class="warning"><?php echo $error; ?></div>
    <?php } ?>
    <div class="box_login">
      <h3><span><?php echo $text_i_am_new_customer; ?></span></h3>
      <h3 onclick="navegaBox('<?=BASE_URL?>/account/create');"><span><?php echo $text_returning_customer; ?></span></h3>
      
      <div class="box_user">
     
          <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" name="account" id="account">
            <label for="register" style="cursor: pointer; display:none">
              <?php if ($account == 'register') { ?>
              <input type="radio" name="account" value="register" id="register" checked="checked" style="vertical-align: middle;" />
              <?php } else { ?>
              <input type="radio" name="account" value="register" id="register" style="vertical-align: middle;" />
              <?php } ?>
              <b><?php echo $text_register; ?></b></label>
           
            <?php if ($guest_checkout) { ?>
            <label for="guest" style="cursor: pointer;">
              <?php if ($account == 'guest') { ?>
              <input type="radio" name="account" value="guest" id="guest" checked="checked" />
              <?php } else { ?>
              <input type="radio" name="account" value="guest" id="guest" />
              <?php } ?>
              <b><?php echo $text_guest; ?></b></label>
         <?php } ?>
         
            <p class="text_login"><?php echo $text_create_account; ?></p>
            
            <div class="connect">
                <table width="100%">
                	<tr>
                    <td><?php foreach ($modules as $module) { ?>
                <?php echo ${$module['code']}; ?>
                <?php } ?>
                	</td>
                	<td><a href="<?=BASE_URL?>account/twconnect"><img src="catalog/view/theme/revolucao/image/twitterconnect.gif" style="float:right" /></a></td></tr></table>
                <div class="linha"><span>OU</span></div>
            </div>

          </form>
      </div>

          <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" name="login" id="login">
            
            <div class="login_site">
            <p class="text_login"><?php echo $text_i_am_returning_customer; ?></p>
            <input type="text" placeholder="<?php echo $entry_email; ?>" id="email" name="email" style="width:327px; margin-bottom:10px" />
<br />            <input type="password" id="password"  name="password" style="width:230px; margin-right:10px" placeholder="<?php echo $entry_password; ?>" />

            <div class="button_loja"><a onclick="makeLogin()" style="cursor:pointer" ><span><?php echo $button_login; ?></span></a></div>

<br /><br />      <a href="javascript:navegaBox('<?=BASE_URL?>account/forgotten');" class="esquecido"><?php echo $text_forgotten_password; ?></a><br />
            <input type="hidden" name="redirect" value="<?BASE_URL?>conteudo/corrupcao" />
        </div>  </form>
          
          

    </div>
  </div>


<script type="text/javascript">
<!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
//--></script>
