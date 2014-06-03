<p>
	A <?= strtolower($build['Product']['name']) ?> design has been sent to you<?= !empty($your_name) ? " by $your_name":""?> for your review.
</p>

<? if(!empty($custom_message)) { ?>
<div style="border: solid #CCC 1px; padding: 5px; background-color: #FFFFEE; width: 400px;">
	<div><b>Sender's comment:</b></div>
	<?= nl2br($custom_message) ?>
</div>
<? } ?>

<a href="<?= Router::url("/product_image/build_view?build_email_id=$build_email_id"); ?>">
	<img src="<?= Router::url("/product_image/build_view/-600x600?build_email_id=$build_email_id"); ?>">
</a>
