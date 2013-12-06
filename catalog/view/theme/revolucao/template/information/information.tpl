<?php echo $header; ?>

<script type="text/javascript" src="<?=BASE_URL?>catalog/view/javascript/snippet/jquery.snippet.js"></script>
<link rel="stylesheet" type="text/css" href="<?=BASE_URL?>catalog/view/javascript/snippet/jquery.snippet.css" />

<Script>
    $(document).ready(function(){
        $("pre.php").snippet("php");
    });
</Script>



<div id="content carrinho">

  <div class="middle account">
      <h1><?php echo $heading_title; ?></h1>  
      <?php echo $description; ?>

    <!--div class="buttons">
      <table>
        <tr>
          <td align="right"><a onclick="location = '<?php echo str_replace('&', '&amp;', $continue); ?>'" class="button"><span><?php echo $button_continue; ?></span></a></td>
        </tr>
      </table>
    </div-->
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 