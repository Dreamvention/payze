<div id="payze-form">
	<?php if ($logged) { ?>
	<div id="payze-cards" style="display: <?php if ($customer_cards) { ?>block<?php } else { ?>none<?php } ?>">
        <div class="radio">
			<label>
				<input type="radio" name="payze_card_existing" value="1" id="input-payze-card-existing" class="input-payze-card-existing" <?php if ($customer_cards) { ?>checked<?php } ?> />	
				<?php echo $entry_card_existing; ?>				
			</label>
		</div>
		<div class="radio">
			<label>
				<input type="radio" name="payze_card_existing" value="0" id="input-payze-card-new" class="input-payze-card-existing" <?php if (!$customer_cards) { ?>checked<?php } ?> />
				<?php echo $entry_card_new; ?>
			</label>
		</div>
    </div>
	<div id="payze-card-existing" style="display: <?php if ($customer_cards) { ?>block<?php } else { ?>none<?php } ?>">                
		<div class="form-group">
            <select name="payze_card" id="input-payze-card" class="form-control">
				<?php foreach ($customer_cards as $customer_card) { ?>
				<option value="<?php echo $customer_card['card_id']; ?>"><?php echo $customer_card['card_brand']; ?> <?php echo $customer_card['card_mask']; ?></option>
				<?php } ?>
			</select>
        </div>
	</div>
	<div id="payze-card-new" style="display: <?php if (!$customer_cards) { ?>block<?php } else { ?>none<?php } ?>">
		<div class="form-group">
            <div class="checkbox">
				<label>
					<input type="checkbox" name="payze_card_save" value="1" checked />
					<?php echo $entry_card_save; ?>
				</label>
			</div>
		</div>
	</div>
    <?php } ?>
	<div class="buttons">
		<div class="pull-left">
			<button type="button" id="payze-button-confirm" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>"><?php echo $button_confirm; ?></button>
		</div>
	</div>
</div>
<script type="text/javascript">

$('#payze-form .input-payze-card-existing').on('change', function() {
	if ($(this).val() == 1) {
        $('#payze-card-existing').show();
        $('#payze-card-new').hide();
    } else {
        $('#payze-card-existing').hide();
        $('#payze-card-new').show();
    }
});

$('#payze-form #payze-button-confirm').on('click', function() {	
	$.ajax({
		type: 'post',
		url: 'index.php?route=extension/payment/payze/confirm',
		data: $('#payze-form input[type="radio"]:checked, #payze-form input[type="checkbox"]:checked, #payze-form select'),
		dataType: 'json',
		beforeSend: function() {
            $('#payze-button-confirm').button('loading');;
        },
        complete: function() {
           $('#payze-button-confirm').button('reset');
        },
		success: function(json) {
			$('#payze-form .alert-dismissible').remove();
				
			if (json['error']) {
				if (json['error']['warning']) {
					$('#payze-form').prepend('<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i><button type="button" class="close data-dismiss="alert">&times;</button> ' + json['error']['warning'] + '</div>');
				}
			}
			
			if (json['redirect']) {
				location = json['redirect'];	
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

</script>