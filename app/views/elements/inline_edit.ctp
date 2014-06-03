<? if($this->Session->read("Auth.Customer.is_admin")) { ?>
<div align="right">
	<?= $this->Js->link("Edit snippet", array('admin'=>1,'controller'=>'content_snippets','action'=>'inline_edit',$code), array('class'=>'','update'=>'#snippet_'.$code)); ?>
</div>
<? } ?>
<div id="snippet_<?= $code ?>">
<?= !empty($snippets[$code]) ? $snippets[$code] : null ?>
</div>
