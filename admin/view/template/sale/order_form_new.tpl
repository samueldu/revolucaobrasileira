<?php echo $header; ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/order.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="fn_submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <div style="display: inline-block; width: 100%;">
      <div class="vtabs"><a tab="#tab_order"><?php echo $tab_order; ?></a><a tab="#tab_shipping"><?php echo $tab_shipping; ?></a><a tab="#tab_payment"><?php echo $tab_payment; ?></a><a tab="#tab_product"><?php echo $tab_product; ?></a></div>
	   <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab_order" class="vtabs_page">
        <table id="new_order" class="form">
          <tr>
            <td><?php echo $entry_customer; ?></td>
            <td>
            	<select id="customer_id" name="customer_id" onchange="getCustomer()">
            		<option value=""></option>
					<?php 
						foreach($customers as $key => $customer)
						{
					?>
					<option value="<?php echo $customer['customer_id']?>"><?php echo $customer['name'];?></option>
					<?php
						}
					?>
            	</select>
				<input type="hidden" id="customer_group_id" name="customer_group_id" value="0" />
				&nbsp;&nbsp;&nbsp;<a onclick="location = '<?php echo $new_customer; ?>';" class="button"><span><?php echo $button_new_customer; ?></span></a>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_email; ?></td>
            <td><input type="text" id="email" name="email" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_telephone; ?></td>
            <td><input type="text" id="telephone" name="telephone" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_fax; ?></td>
            <td><input type="text" id="fax" name="fax" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_store_name; ?></td>
            <td>
            	<select id="store_id" name="store_id" onchange="getStore();">
					<option value="0">Default Store</option>
            		<?php 
						foreach($stores as $key => $store)
						{
					?>
					<option value="<?php echo $store['store_id'];?>"><?php echo $store['name'];?></option>
					<?php
						}
					?>
					
            	</select>
				<input type="hidden" id="currency_id" name="currency_id" value="1" />
				<input type="hidden" id="language_id" name="language_id" value="1" />
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_shipping_method; ?></td>
            <td>
            	<select id="shipping_method_title" name="shipping_method_title">
					<option value=""></option>
            		<?php 
						foreach($shipping_methods as $key => $shipping_method)
						{
					?>
					<option value="<?php echo $shipping_method['title'];?>"><?php echo $shipping_method['title'];?></option>
					<?php
						}
					?>
					
            	</select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_payment_method; ?></td>
            <td>
            	<select id="payment_method_title" name="payment_method_title">
					<option value=""></option>
            		<?php 
					
						foreach($payment_methods as $key => $payment_method)
						{
					?>
					<option value="<?php echo $payment_method['title'];?>"><?php echo $payment_method['title'];?></option>
					<?php
						}
					?>
					
            	</select>
            </td>
          </tr>
		  <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select id="order_status_id" name="order_status_id">
				<option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($order_statuses as $order_statuses) { ?>
                <?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
                <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_append; ?></td>
            <td><input type="checkbox" id="append" name="append" value="1" checked="checked" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_comment; ?></td>
            <td><textarea name="comment" rows="8" style="width: 99%;"></textarea></td>
          </tr>
        </table>
      </div>
      <div id="tab_product" class="vtabs_page">
        <table id="product" class="list">
          <thead>
            <tr>
              <td></td>
              <td class="left"><?php echo $column_product; ?></td>
              <td class="left"><?php echo $column_model; ?></td>
              <td class="right"><?php echo $column_quantity; ?></td>
              <td class="right"><?php echo $column_price; ?></td>
              <td class="right" width="1"><?php echo $column_total; ?></td>
            </tr>
          </thead>
		  <tbody id="totals">
            	<?php foreach ($total_orders as $key => $total_order) { ?>
				<?php if($total_order['key'] != 'tax'){ ?>
            	<tr>
		              <td></td>
		              <td colspan="4" class="right"><?php echo $total_order['title']; ?></td>
					  <td class="right">
					  		<input type="hidden" id="order_key_<?php echo $total_order['key'];?>" name="order_key[]" value="<?php echo $total_order['key'];?>|<?php echo $total_order['prefix'];?>" />
					  		<input type="hidden" id="order_name_<?php echo $total_order['key'];?>" name="total_order_name[]" value="<?php echo $total_order['title'];?>" />
					  		<input type="text" id="order_<?php echo $total_order['key'];?>" name="total_orders[]" value="0.00" style="text-align:right;" <?php echo ($total_order['text_status'] == 1? "onchange='calculateOrderTotals();'" : "readonly='readonly'"); ?> />
					  </td>
            	</tr>
				<?php } ?>
            <?php } ?>
          </tbody>
        </table>
        <table class="list">
          <thead>
            <tr>
              <td class="left" colspan="3"><?php echo $column_add_product; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="left"><?php echo $entry_category; ?></td>
			  <td class="left" colspan="2">
			    <select id="category" style="width: 450px;" onchange="getProducts();">
			      <?php foreach ($categories as $category) { ?>
			      <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
			      <?php } ?>
			    </select>
			  </td>
			</tr>
            <tr>
		      <td class="left"><?php echo $entry_product; ?></td>
			  <td class="left" colspan="2"><select id="products" style="width: 450px;" onchange="getOptions();"></select></td>
			</tr>
			<tr>
			  <td class="left"><?php echo $entry_option; ?></td>
			  <td class="left"><select multiple="multiple" id="option" size="5" style="width: 450px;"></select></td>
			  <td style="vertical-align: middle;"><span class="add" onclick="addProduct();">&nbsp;</span></td>
			</tr>
			<tr>
		      <td class="left"><?php echo $entry_tax; ?></td>
			  <td class="left" colspan="2"><input id="add_tax" name="add_tax" type="text" value="0" size="5"/>%</td>
			</tr>
			<tr>
		      <td class="left"><?php echo $entry_price; ?></td>
			  <td class="left" colspan="2" id="price-column"><input id="price" name="price" type="text" value="0" size="10"/></td>
			</tr>
			<tr>
		      <td class="left"><?php echo $entry_quantity; ?></td>
			  <td class="left" colspan="2">
			  		<input id="add_quantity" name="add_quantity" type="text" value="1" size="5"/>
			  </td>
			</tr>
  		  </tbody>
		</table>
		<p>
			* <?php echo $text_subtract_quantity;?><br />
			<span style="color:red;">
			<?php if($config_stock_checkout == true){ ?>
			* <?php echo $text_stock_checkout_true;?>
			<?php }else{ ?>
			* <?php echo $text_stock_checkout_false;?>
			<?php }?>
			</span>
		</p>
      </div>
      <div id="tab_shipping" class="vtabs_page">
        <table class="form">
          <tr>
            <td><?php echo $entry_firstname; ?></td>
            <td><input type="text" id="shipping_firstname" name="shipping_firstname" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_lastname; ?></td>
            <td><input type="text" id="shipping_lastname" name="shipping_lastname" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_company; ?></td>
            <td><input type="text" id="shipping_company" name="shipping_company" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_address_1; ?></td>
            <td><input type="text" id="shipping_address_1" name="shipping_address_1" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_address_2; ?></td>
            <td><input type="text" id="shipping_address_2" name="shipping_address_2" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_city; ?></td>
            <td><input type="text" id="shipping_city" name="shipping_city" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_postcode; ?></td>
            <td><input type="text" id="shipping_postcode" name="shipping_postcode" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_country; ?></td>
            <td><select name="shipping_country_id" id="shipping_country_id" onchange="getCountryZone('shipping_country_id', $('#shipping_country_id').val(), '', 'shipping_zone', 'shipping_country');">
                <?php foreach ($countries as $country) { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_zone; ?></td>
            <td id="shipping_zone"></td>
          </tr>
        </table>
      </div>
      <div id="tab_payment" class="vtabs_page">
        <table class="form">
          <tr>
            <td><?php echo $entry_firstname; ?></td>
            <td><input type="text" id="payment_firstname" name="payment_firstname" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_lastname; ?></td>
            <td><input type="text" id="payment_lastname" name="payment_lastname" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_company; ?></td>
            <td><input type="text" id="payment_company" name="payment_company" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_address_1; ?></td>
            <td><input type="text" id="payment_address_1" name="payment_address_1" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_address_2; ?></td>
            <td><input type="text" id="payment_address_2" name="payment_address_2" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_city; ?></td>
            <td><input type="text" id="payment_city" name="payment_city" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_postcode; ?></td>
            <td><input type="text" id="payment_postcode" name="payment_postcode" value="" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_country; ?></td>
            <td><select name="payment_country_id" id="payment_country_id" onchange="getCountryZone('payment_country_id', $('#payment_country_id').val(), '', 'payment_zone', 'payment_country');">
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $payment_country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_zone; ?></td>
            <td id="payment_zone"></td>
          </tr>
        </table>
      </div>
	  </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
	$.tabs('.vtabs a');
	
	function fn_submit(){
		if($("#customer_id").val() == "")
		{
			alert('Please select a customer.');
			$("#customer_id").focus();
		}
		else if($("#shipping_method_title").val() == "")
		{
			alert('Please select shipping method.');
			$("#shipping_method_title").focus();
		}
		else if($("#payment_method_title").val() == "")
		{
			alert('Please select payment method.');
			$("#payment_method_title").focus();
		}
		else
		{
			$('#form').submit();	
		}
		
	}
	
	function calculateOrderTotals(){
		var grand_total = 0;
		var order_total_info = null;
		$("input[name^='order_key']").each(function(){
			order_total_info = $(this).val().split('|');
			if(order_total_info[0] != 'total'){
				$("#order_" + order_total_info[0]).val(parseFloat($("#order_" + order_total_info[0]).val()).toFixed(2)); 
				if(order_total_info[1] == '+'){
					grand_total += parseFloat($("#order_" + order_total_info[0]).val());
				}else if(order_total_info[1] == '-'){
					grand_total -= parseFloat($("#order_" + order_total_info[0]).val());
				}
				
			}
		});
		$("#order_total").val(grand_total.toFixed(2));
	}
	
	function removeProduct(product_key){
		$.ajax({
			type: 'GET',
			url: 'index.php?route=sale/order_new/removeProduct&token=<?php echo $token; ?>',
			dataType: 'json',
			data: 'product_key=' + encodeURIComponent(product_key),
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#product').before('<div class="attention"><img src="view/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
			},
			complete: function() {
				$('.attention').remove();
			},
			error: function() {
				alert('failed');
			},
			success: function(data) {
				if (data.error) {
					$('#product').before('<div class="warning">' + data.error + '</div>');
				}
	
				if (data.success) {
					
					$('#order_total').val(data.product_data['new_grand_total']);
					$('#order_sub_total').val(data.product_data['order_total']);
					//$('#totals').before(html);
					$("#product_" + product_key).remove();
	
					$('#tab_product #product').before('<div class="success">' + data.success + '</div>');
					
					calculateOrderTotals();
				}
			}
		});
	}
	function addProduct(){
		options = '';
		$('#option option:selected').each(function(i, opt) {
			options += $(opt).val() + '|';
		});
		
		$.ajax({
			type: 'POST',
			url: 'index.php?route=sale/order_new/addProduct&token=<?php echo $token; ?>',
			dataType: 'json',
			data: 'product_id=' + encodeURIComponent($('#products').val()) + '&option=' + options + '&quantity=' + encodeURIComponent($('input[name=\'add_quantity\']').val()) + '&tax=' + encodeURIComponent($('input[name=\'add_tax\']').val()) + '&currency_id=' + encodeURIComponent($('#currency_id').val()) + '&price=' + encodeURIComponent($('input[name=\'price\']').val())			,
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#product').before('<div class="attention"><img src="view/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
			},
			complete: function() {
				$('.attention').remove();
			},
			error: function() {
				alert('failed');
			},
			success: function(data) {
				if (data.error) {
					$('#product').before('<div class="warning">' + data.error + '</div>');
				}
	
				if (data.success) {
					
					html  = '<tbody id="product_' + data.product_data['key'] + '">';
					html += '<tr>';
					html += '<td class="left" style="width:3px;">';
					html += '<span onclick="removeProduct(' + data.product_data['key'] + ');" class="remove">&nbsp;</span>';
					html += '</td>';
					html += '<td class="left">';
					html += '<a href="' + data.product_data['href'] +'">' + data.product_data['name'] + '</a>';
					for (k=0; k<data.product_data['options'].length; k++) {
						html += '<br/> &nbsp;<small> - ' + data.product_data['options'][k]['name'] + ' ' + data.product_data['options'][k]['value'] + '</small>';
					}
					html += '</td>';
					html += '<td class="left">'  + data.product_data['model'] + '</td>';
					html += '<td class="right">' + data.product_data['quantity'] + '</td>';
					html += '<td class="right">' + data.product_data['formatted_price'] + '</td>';
					html += '<td class="right">' + data.product_data['formatted_total'] + '</td>';
					html += '</tr>';
					html += '</tbody>';
					
					$('#order_total').val(data.product_data['new_grand_total']);
					$('#order_sub_total').val(data.product_data['order_total']);
					$('#totals').before(html);
	
					$('#tab_product #product').slideDown();
	
					$('#tab_product #product').before('<div class="success">' + data.success + '</div>');
					
					calculateOrderTotals();
				}
			}
		});
	}
	
	function getCustomer(){
		if($('#customer_id').val() == "")
			location.href='<?php echo $cancel;?>';
			
		$.ajax({
			type: 'GET',
			url: 'index.php?route=sale/order_new/getCustomer&token=<?php echo $token; ?>',
			dataType: 'json',
			data: 'customer_id=' + $('#customer_id').val(),
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#new_order').before('<div class="attention"><img src="view/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
			},
			complete: function() {
				$('.attention').remove();
			},
			error: function() {
				alert('failed');
			},
			success: function(data) {
				if (data.error) {
					$('#new_order').before('<div class="warning">' + data.error + '</div>');
				}
	
				if (data.success) {
					$('#email').val(data.customer.email);
					$('#telephone').val(data.customer.telephone);
					$('#fax').val(data.customer.fax);
					$('#store_id').val(data.customer.store_id);
					$('#customer_group_id').val(data.customer.customer_group_id);
				
					$('#shipping_firstname').val(data.customer.address.firstname);
					$('#shipping_lastname').val(data.customer.address.lastname);
					$('#shipping_company').val(data.customer.address.company);
					$('#shipping_address_1').val(data.customer.address.address_1);		
					$('#shipping_address_2').val(data.customer.address.address_2);		
					$('#shipping_city').val(data.customer.address.city);		
					$('#shipping_postcode').val(data.customer.address.postcode);		
					$('#shipping_country').val(data.customer.address.country_id);
					getCountryZone('shipping_country_id', data.customer.address.country_id, data.customer.address.zone_id, 'shipping_zone', 'shipping_country');
					
					$('#payment_firstname').val(data.customer.address.firstname);
					$('#payment_lastname').val(data.customer.address.lastname);
					$('#payment_company').val(data.customer.address.company);
					$('#payment_address_1').val(data.customer.address.address_1);		
					$('#payment_address_2').val(data.customer.address.address_2);		
					$('#payment_city').val(data.customer.address.city);		
					$('#payment_postcode').val(data.customer.address.postcode);		
					$('#payment_country').val(data.customer.address.country_id);
					getCountryZone('payment_country_id', data.customer.address.country_id, data.customer.address.zone_id, 'payment_zone', 'payment_country');
					
				}
			}
		});
	}
	
	function getCountryZone(id, country_id, zone_id, type, type_name){
		$('#'+id).val(country_id);
		if(country_id == undefined) country_id = '1';
		if(zone_id == undefined) zone_id = '';
		$('#'+type).load('index.php?route=sale/order_new/zone&token=<?php echo $token; ?>&country_id=' + country_id + '&zone_id=' + zone_id + '&type=' + type + '&type_name=' + type_name);
	}
	
	function getProducts() {
		$('#products option').remove();
	
		$('input[id^="product-price"]').remove();
		$.ajax({
			url: 'index.php?route=sale/order_new/category&token=<?php echo $token; ?>&category_id=' + $('#category').attr('value') + '&currency_id=' + $('#currency_id').val(),
			dataType: 'json',
			beforeSend: function() {
				$('#loading').remove();
				$('#products').after('&nbsp;<img id="loading" src="view/image/loading_1.gif" alt="" />');
			},
			success: function(data) {
				$('#loading').remove();
				$("#price").val('');
				for (i = 0; i < data.length; i++) {
		 			$('#products').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + ' [' + data[i]['model'] + '] - [' + data[i]['price'] + '] </option>');
					
					$('#price-column').append('<input type="hidden" id="product-price-' + data[i]['product_id'] + '" value="' + data[i]['price_no_format'] + '" />');
					
					if(i == 0) {
						$("#price").val(data[i]['price_no_format']);
					}
					
				}
				
				getOptions();
			}
		});
	}
	
	function getOptions() {
		$('#option optgroup').remove();
		$('#option option').remove();
	
		$.ajax({
			url: 'index.php?route=sale/order_new/product&token=<?php echo $token; ?>&product_id=' + $('#products').attr('value') + '&currency_id=' + $('#currency_id').val(),
			dataType: 'json',
			beforeSend: function() {
				$('#loading').remove();
				$('#option').after('&nbsp;<img id="loading" src="view/image/loading_1.gif" alt="" />');
			},
			success: function(data) {
				$('#loading').remove();
				var language_id = $('#language_id').val();
				for (i = 0; i < data.length; i++) {
					$('#option').append('<optgroup id="optgroup_'+i+'" label="' + data[i]['language'][language_id]['name'] + '"></optgroup>');
					for (j = 0; j < data[i]['product_option_value'].length; j++) {
		 				$('#optgroup_'+i).append('<option value="' + data[i]['product_option_value'][j]['product_option_value_id'] + '">' + data[i]['product_option_value'][j]['language'][language_id]['name'] + ' [' + data[i]['product_option_value'][j]['prefix'] + data[i]['product_option_value'][j]['price'] + ']' +'</option>');
					}
				}
				$('#price').val($('#product-price-' + $('#products').attr('value')).val());
			}
		});
	}
	getStore();
	function getStore() {
		$.ajax({
			url: 'index.php?route=sale/order_new/getStore&token=<?php echo $token; ?>&store_id=' + $('#store_id').val(),
			dataType: 'json',
			beforeSend: function() {
				$('#loading').remove();
				$('#products').after('&nbsp;<img id="loading" src="view/image/loading_1.gif" alt="" />');
			},
			success: function(data) {
				$('#loading').remove();
				$('#currency_id').val(data.store.currency_id);
				$('#language_id').val(data.store.language_id);
				getProducts();
			}
		});
	}

//--></script>
<?php echo $footer; ?>