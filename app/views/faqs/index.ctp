<? $this->set("page_title", "Frequently Asked Questions"); ?>
<? $this->set("enable_tracking", "faq"); ?>
<div class="faqs index">
<h1 id='title'>Frequently Asked Questions</h1>

<div style="float: right; width: 350px;">
	<h3 class="bold">Submit a Question</h3>
	<div style="border: solid #CCC 1px; padding: 5px;" id="faqRequest">
		<?= $this->element("../faqs/add"); ?>
	</div>
</div>

<? foreach($faqs as $faq) { ?>
	<div class="faq" style="padding: 0px; padding-bottom: 5px;">
		<p class="bold"><a href="Javascript:void(0)" onClick="$('faq_<?= $faq['Faq']['faq_id'] ?>').toggleClassName('hidden');"><?= $faq['Faq']['question'] ?></a></p>
		<div id="faq_<?= $faq['Faq']['faq_id'] ?>" class="hidden" style="padding: 5px 15px;">
			<?= $faq['Faq']['answer']; ?>
		</div>
	</div>
<? } ?>

<? foreach($faq_topics as $faq_topic) { ?>
<? if(!empty($faq_topic['Faq'])) { ?>
	<div style="padding-bottom: 10px;">
	<h3 class="bold"><?= $faq_topic['FaqTopic']['topic_name'] ?></h3>
	<div>
		<? foreach($faq_topic['Faq'] as $faq) { ?>
			<div class="faq" style="padding-top: 5px; padding-left: 10px;">
				<p class="bold"><a href="Javascript:void(0)" onClick="$('faq_<?= $faq['faq_id'] ?>').toggleClassName('hidden');"><?= $faq['question'] ?></a></p>
				<div id="faq_<?= $faq['faq_id'] ?>" class="hidden" style="padding: 5px 15px;">
					<?= $faq['answer']; ?>
				</div>
			</div>
		<? } ?>
	</div>
	</div>
<? } ?>
<? } ?>


</div>
<div class="clear"></div>
