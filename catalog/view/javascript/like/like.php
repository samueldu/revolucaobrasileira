
<script>
		
		function like(){
			$.ajax({
				type: 'GET',
				url: 'index.php?route=ajax/ajax/like',
				dataType: 'html',
				data: 'userId=<?=$_SESSION['customer_id']?>tipo=perfil&id=<?=$politicos[0]['id']?>',
				beforeSend: function(){
					$('#add_to_wl').after('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" /></div>');
				},
				complete: function() {
					$('.wait').remove();
				},
				success: function(data) {
					$('#add_to_wl').after('' + data + '');
				}
			});
		}
		
		</script>