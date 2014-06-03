<script type="text/javascript">
    tinyMCE.init({
        theme : "advanced",
        mode : "textareas",
	plugins: "table",
	preformatted : true,
        convert_urls : false,
	force_p_newlines : false,
	width: '100%',
	editor_deselector : "no_editor",
	setup: function(ed) {
		ed.onChange.add(function(ed, e) {
			syncText();
		});
	}
    });
function syncText()
{
	var content = tinyMCE.activeEditor.getContent({format: 'raw'});
	j('#ContentSnippetContent').html(content);
}
</script> 

<div class="form">
<?= $this->Form->create("ContentSnippet", array('onSubmit'=>"syncText();")); ?>
	<?= $this->Form->input("content_snippet_id"); ?>
	<?= $this->Form->hidden("snippet_code", array('value'=>$code)); ?>
	<?= $this->Form->input("snippet_title", array('lable'=>'Heading (optional)','style'=>'width: 95%; font-size: 18px;')); ?>
	<?= $this->Form->input("content", array('style'=>'width: 95%;')); ?>

<div>
	<?= $this->Js->submit('Save', array('update'=>'#snippet_'.$code,'div'=>false)); ?>
	or 
	<?= $this->Js->link("Cancel", array('admin'=>1,'controller'=>'content_snippets','action'=>'inline_view',$code), array('class'=>'','update'=>'#snippet_'.$code)); ?>
</div>
<?= $this->Form->end(); ?>
</div>
