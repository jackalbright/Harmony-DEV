<div class="specialtyPage form">
<a href="/admin/specialty_pages">All Specialty Pages</a>
<?php echo $form->create('SpecialtyPage');?>
	<fieldset>
 		<legend><?php __('Edit SpecialtyPage');?> | <a href="/admin/specialty_page_sample_images/index/<?= $this->data['SpecialtyPage']['specialty_page_id'] ?>">Edit Sample Gallery</a></legend>
	<div class="right">
	<input type="submit" value="Submit"/>
	</div>
		<table>
	<?php

		echo $form->input('specialty_page_id');
		echo $html->tableCells(array(
			array(
				$form->input('page_title'),
				$form->input('link_name'),
				$form->input('page_url',array('between'=>'http://harmonydesigns.com/specialties/')),
			),
			array(
				$form->input('body_title').
				$form->input('sort_index')."<br/>"."<br/>".
				$form->input('enabled'),

				$form->input('meta_keywords').
				$form->input('meta_desc'),
				$form->input('introduction'),
			),
		));
		?> </table> 

		<table>
		<tr>
		<td>
			<?= $this->element("specialty_pages/subject_tree", array('id'=>1,'subjects'=>$subjects,'subject_children'=>$subject_children)); ?>
		</td>
		<td>
		<?

		$this->data['SpecialtyPageSectionContent'][] = array();
		$i = 0;
		foreach($this->data['SpecialtyPageSectionContent'] as $id =>$section)
		{
			if (!$id) { $id = 0; }
			echo "<div><table border=0 cellpadding=0 cellspacing=0>";
			echo $form->hidden("SpecialtyPageSectionContent.$id.specialty_page_section_content_id");
			echo $form->hidden("SpecialtyPageSectionContent.$id.specialty_page_id",array('value'=>$specialty_page_id));
			echo $html->tableCells(array(
				array(
					$form->input("SpecialtyPageSectionContent.$id.title") . "<br/>" .
					$form->input("SpecialtyPageSectionContent.$id.content")
				)
			));
			echo "</table></div>";
		}
	?>
		</td>
		</tr>
		</table>
	</fieldset>

<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('SpecialtyPage.specialty_page_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('SpecialtyPage.specialty_page_id'))); ?></li>
		<li><?php echo $html->link(__('List SpecialtyPage', true), array('action'=>'index'));?></li>
	</ul>
</div>
