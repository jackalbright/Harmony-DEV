<?
if(!empty($product['Product'])) {
	$product = $product['Product'];
}

?>
<label class="inline" for="charmCategories">Select a Category:</label>
<select id="charmCategories" onChange="selectTab(this.value, 'gtab');">
	<option value="CH_0">All Charms</option>
	<? foreach($charm_categories as $charm_category) { ?>
	<option value="<?= $product['code'] ?>_<?= $charm_category['CharmCategory']['charm_category_id']?>"><?= $charm_category['CharmCategory']['category_name'] ?></option>
	<? } ?>
</select>

<?= $this->element("products/sample_gallery_album_charm_category", array('charm_category'=>$charm_category,'charms'=>$charms,'tabbed'=>true,'class'=>"selected_gtab_content gtab_content", "key"=>"0", "id"=>$product['code']."_0_gtab_content")); ?>

<? $i = 0; foreach($charm_categories as $charm_category) { 

$prefix = $product['code']."_".$charm_category['CharmCategory']['charm_category_id'];
#$class = $i++ == 0 ? "selected_gtab_content gtab_content" : "gtab_content";
$class =  "gtab_content";


?>
	<?= $this->element("products/sample_gallery_album_charm_category", array('charm_category'=>$charm_category,'name'=>$charm_category['CharmCategory']['category_name'], 'key'=>$charm_category['CharmCategory']['charm_category_id'], 'charms'=>$charm_category['Charm'],'tabbed'=>true,'class'=>$class, "id"=>$prefix."_gtab_content")); ?>
<? } ?>

