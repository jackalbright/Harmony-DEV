	<?
		$customer_id = !empty($_SESSION['Auth']['Customer']['customer_id']) ? $_SESSION['Auth']['Customer']['customer_id'] : null;
		$session_id = session_id();

		# Search for count. 

		$saved_design_count = 0;

	?>

	<? if($saved_design_count > 0) { ?>
	| <a href="/saved_items">My Saved Designs<?= !empty($saved_design_count) ? " ($saved_design_count)" : "" ?></a>
	<? } ?>
