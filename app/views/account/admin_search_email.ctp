<div class="customer index">
<h2><?php __('Customers');?></h2>

<div class="right_align">
	<form method="POST" action="/admin/account/search_email">
	Search: 

	<select name="data[field]" id="field">
		<option value="firstlast">Full Name</option>
		<option value="lastfirst">Last, First</option>
		<option value="email">Email</option>
		<option value="company">Company</option>
	</select>
	<?= $javascript->codeBlock("Event.observe(window, 'load', function() { \$('field').value = '". $this->data['field'] ."'; });"); ?>
	
	<input type="text" name="data[value]" value="<?= $this->data['value'] ?>"/>
	<input type="submit" value="Search"/>
	<a href="/admin/account">View All</a>
	</form>
</div>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<script>
	function selectEmail(email)
	{
		var item = window.parent.document.getElementById("EmailMessageRecipients");
		if(item.value != "")
		{
			item.value += "\n";
		}
		item.value += email;
		//parent.Shadowbox.close();
	}
</script>
<table cellpadding="0" cellspacing="0" width="100%" border=1>
<tr>
	<th>&nbsp;</th>
	<th><?php echo $paginator->sort('First_Name');?></th>
	<th><?php echo $paginator->sort('Last_Name');?></th>
	<th><?php echo $paginator->sort('eMail_Address');?></th>
	<th><?php echo $paginator->sort('Company');?></th>
	<th><?php echo $paginator->sort('dateAdded');?></th>
</tr>
<?php
$i = 0;
foreach ($customers as $customer):
	$class = null;
?>
	<tr style="background-color: <?= $i++ % 2 ? "#FFF" : "#DDD" ?>;">
		<td align="center">
			<a href="Javascript:void(0)" onClick="selectEmail('<?= $customer['Customer']['eMail_Address'] ?>');"><img src="/images/buttons/Select.gif"/></a>
		</td>
		<td align="center">
			<?php echo $customer['Customer']['First_Name']; ?>
		</td>
		<td align="center">
			<?php echo $customer['Customer']['Last_Name']; ?>
		</td>
		<td align="center">
			<?php echo $customer['Customer']['eMail_Address']; ?>
		</td>
		<td align="center">
			<?php echo $customer['Customer']['Company']; ?>
		</td>
		<td align="center">
			<?php echo $hd->unixToHumanDate($customer['Customer']['dateAdded'],true); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
