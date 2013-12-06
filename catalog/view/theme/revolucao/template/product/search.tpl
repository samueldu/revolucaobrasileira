<?php echo $header; ?>
<div id="content" class="departamento">
  <div class="middle">
      <h1><?php echo $text_critea; ?></h1>
    <div id="content_search" class="content round">
      <table>
        <tr>
          <td><?php echo $entry_search; ?></td>
          <td><?php if ($keyword) { ?>
            <input type="text" value="<?php echo $keyword; ?>" id="keyword" />
            <?php } else { ?>
            <input type="text" value="<?php echo $text_keyword; ?>" id="keyword" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;" />
            <?php } ?>
            <select id="category_id">
              <option value="0"><?php echo $text_category; ?></option>
              <?php foreach ($categories as $category) { ?>
              <?php if ($category['category_id'] == $category_id) { ?>
              <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td colspan="2"><?php if ($description) { ?>
            <input type="checkbox" name="description" id="description" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="description" id="description" />
            <?php } ?>
            <?php echo $entry_description; ?></td>
        </tr>
		<tr>
          <td colspan="2"><?php if ($model) { ?>
            <input type="checkbox" name="model" id="model" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="model" id="model" />
            <?php } ?>
            <?php echo $entry_model; ?></td>
        </tr>
      </table>
    </div>
    <div style="text-align:right; border-bottom:1px dotted #ccc; padding-bottom:10px; margin-bottom:20px"><a style="margin-right:0" onclick="contentSearch();" class="button"><span><?php echo $button_search; ?></span></a></div>
    <h1 style="padding-bottom:8px"><?php echo $text_search; ?></h1>
    <?php if (isset($products)) { ?>
    <div class="sort round" style="margin-top:5px">
      <div class="div2"><?php echo $text_sort; ?></div>

      <div class="div1">
        <select name="sort" onchange="location = this.value">
          <?php foreach ($sorts as $sorts) { ?>
          <?php if (($sort . '-' . $order) == $sorts['value']) { ?>
          <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </div>
    </div>
    <table class="list">
      <?php for ($i = 0; $i < sizeof($products); $i = $i + 4) { ?>
      <tr>
        <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
        <td width="25%"><?php if (isset($products[$j])) { ?>
          <?php
          print $products[$j]['txt'];
          ?>
          
          <?php } ?></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php } else { ?>
    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-top: 3px; margin-bottom: 15px;"><?php echo $text_empty; ?></div>
    <?php }?>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<script type="text/javascript"><!--
 $('#content_search input').keydown(function(e) {
	
	if (e.keyCode == 13) {
		contentSearch();
	}
});

function contentSearch() {
	url = 'product/search';
	
	var keyword = $('#keyword').attr('value');
	
	if (keyword) {
		url += '?keyword=' + encodeURIComponent(keyword);
	}

	var category_id = $('#category_id').attr('value');
	
	if (category_id) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}
	
	if ($('#description').attr('checked')) {
		url += '&description=1';
	}
	
	if ($('#model').attr('checked')) {
		url += '&model=1';
	}

	window.location = url;
}

//--></script>
<?php echo $footer; ?> 