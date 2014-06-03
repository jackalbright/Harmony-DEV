<div class="contentSnippets view">
<h2><?php  __('ContentSnippet');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Content Snippet Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentSnippet['ContentSnippet']['content_snippet_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Snippet Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentSnippet['ContentSnippet']['snippet_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Snippet Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentSnippet['ContentSnippet']['snippet_title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Content'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentSnippet['ContentSnippet']['content']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ContentSnippet', true), array('action'=>'edit', $contentSnippet['ContentSnippet']['content_snippet_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ContentSnippet', true), array('action'=>'delete', $contentSnippet['ContentSnippet']['content_snippet_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contentSnippet['ContentSnippet']['content_snippet_id'])); ?> </li>
		<li><?php echo $html->link(__('List ContentSnippets', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New ContentSnippet', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
