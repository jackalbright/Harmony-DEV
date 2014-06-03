<? if(!empty($faqs)) { ?>
<? if (empty($title)) { $title = 'Common Questions'; } ?>
<div>
		<h4><?= $title ?></h4>
		<ol>
			<? foreach($faqs as $faq) { ?>
			<?
				if (!empty($faq['Faq'])) { $faq = $faq['Faq']; } ?>
			<li>
			<a href="Javascript:void(0);" onClick="return faq_toggleAnswer('<?= $faq['faq_id'] ?>');"><?= $faq['question'] ?></a>
			<div id="answer_<?= $faq['faq_id'] ?>" class="answer hidden">
					<?= ($faq['answer']); ?>
			</div>
			<? } ?>
		</ol>
</div>
<? } ?>
