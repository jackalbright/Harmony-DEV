<h3>Description Tab Boxes</h3>
<?
$pid = !empty($this->data['Product']['product_type_id']) ? $this->data['Product']['product_type_id'] : null;
?>
<div id="boxes" class="" style="width: 800px;">
	<? if(!empty($this->data['ProductDescription'])) { ?>
	<? $i = 0; foreach($this->data['ProductDescription'] as $pd) { ?>
		<?= $this->element("../products/admin_description", array('i'=>$i++)); ?>
	<? } ?>
	<? } ?>
</div>
<?= $this->Html->link("+ Add another box", "javascript:void(0)", array('id'=>'boxes_add')); ?>
<script>
j('#boxes_add').click(function(e) {
	var ix = j('#boxes').find('div.productDescription').size();
	j.post("/admin/products/description/<?= $pid ?>/"+ix, null, function(html) {
		j('#boxes').append(html);
	});
	e.preventDefault();
	return false;
});

// Since we may add a bunch without having proper id's set yet
// we need a mechanism to save sorting - ie via ix field for each.
j('#boxes').sortable({
	handle: 'div.handle',
	cursor: 'move',
	placeholder: 'placeholder',
	tolerance: 'pointer',
	opacity: 0.6,
	start: function(e,ui) {
		j(this).find('.tinyMCE').each(function() {
			tinyMCE.execCommand('mceRemoveControl', false, j(this).attr('id'));
		});
	},
	stop: function(e,ui) {
		j(this).find('.tinyMCE').each(function() {
			tinyMCE.execCommand('mceAddControl', false, j(this).attr('id'));
			j(this).sortable('refresh');
		});
	},
	update: function(event, ui) {
		var items = j(this).sortable('toArray');
		//console.log(items);
		for(var i = 0; i < items.length; i++)
		{
			var item = items[i];
			//console.log(item+"Ix="+i);
			j('#'+item+"Ix").val(i);
		}

		// Now refresh tinyMCE in each.
		tinyMCE.execCommand("mceRepaint");
		console.log("REPAINTED");
	}
});
j('#boxes .delete').click(function() {
	var box = j(this).closest('div.productDescription');
	var boxid = j(box).attr('id').replace(/^ProductDescription/, "");
	if(confirm("Are you sure you want to delete this content box?"))
	{
		j.post("/admin/products/delete_description/"+boxid, null, function() {
			j(box).remove();
		});
	}
});
</script>
<style>
div.productDescription .handle,
div.productDescription .delete
{
	display:none;
}
div.productDescription:hover .handle,
div.productDescription:hover .delete
{
	display: block;
}
div.placeholder
{
	width: 398px;
	height: 348px;
	border: solid brown 1px;
	background-color: yellow;
	float: left;
}
</style>
