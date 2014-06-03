<h2>Frequently Asked Questions</h2>

<div class="" align="right">
	<a href="/admin/faqs/add">Add Question</a> |
	<a href="/admin/faq_topics/add">Add Topic</a> 
</div>
<div class="clear"></div>

<div id="faqTopics">

<ul id="faqs_0" class="section">
<? foreach($faqs as $faq) { ?>
	<li id="faq_<?= $faq['Faq']['faq_id'] ?>" class="faq" style="padding: 0px;">
		<div class="left handle"><img width="10" src="/images/icons/up-down.png"/></div>
		<p><a href="/admin/faqs/edit/<?= $faq['Faq']['faq_id'] ?>" name="faq_<?= $faq['Faq']['faq_id'] ?>"><?= $faq['Faq']['question'] ?></a></p>
		<div style="padding: 5px 15px;">
			<? nl2br(strip_tags($faq['Faq']['answer'])); ?>
			<?= $faq['Faq']['answer']; ?>
		</div>
	</li>
<? } ?>
</ul>

<div class="clear"></div>

<? foreach($faqTopics as $topic) { ?>
<div id="faqTopic_<?= $topic['FaqTopic']['faq_topic_id'] ?>" class="faqTopics">
	<div class="left handle"><img width="10" src="/images/icons/up-down.png"/></div>
	<h6><a href="/admin/faq_topics/edit/<?= $topic["FaqTopic"]['faq_topic_id'] ?>"><?= $topic['FaqTopic']['topic_name'] ?></a></h6>
	<ul id="faqs_<?= $topic['FaqTopic']['faq_topic_id'] ?>" style="padding-top: 10px;" class="section">

	<? foreach($topic['Faq'] as $faq) { ?>
		<li id="faq_<?= $faq['faq_id'] ?>" class="faq" style="padding: 0px;">
			<div class="left handle"><img width="10" src="/images/icons/up-down.png"/></div>
			<p><a href="/admin/faqs/edit/<?= $faq['faq_id'] ?>" name="faq_<?= $faq['faq_id'] ?>"><?= $faq['question'] ?></a></p>
			<div style="padding: 5px 15px;">
				<?= $faq['answer']; ?>
			</div>
		</li>
	<? } ?>
	</ul>
</div>
<? } ?>

</div>

<script>
	var sections = $$(".section");
</script>

	<?= $ajax->sortable("faqTopics", array("handle"=>"handle",'tag'=>'div','only'=>'faqTopics','url'=>'/admin/faq_topics/resort')); ?>

	<?= $ajax->sortable("faqs_0", array("handle"=>"handle", "dropOnEmpty"=>true, "containment"=>"sections",'url'=>'/admin/faqs/resort')); ?>
	<? foreach($faqTopics as $topic) { ?>
		<?= $ajax->sortable("faqs_".$topic['FaqTopic']['faq_topic_id'], array("handle"=>"handle", "dropOnEmpty"=>true, "containment"=>"sections",'url'=>'/admin/faqs/resort')); ?>
	<? } ?>

<script>
	/*
	Sortable.create('faqs_0', { handle:'handle', dropOnEmpty: true, containment: sections,
		onUpdate:function(sortable) {new Ajax.Request('/admin/faqs/resort', {asynchronous:true, evalScripts:true, parameters:Sortable.serialize('faqs')})}
		});
	<? foreach($faqTopics as $topic) { ?>
	Sortable.create('faqs_<?= $topic['FaqTopic']['faq_topic_id'] ?>', { handle:'handle', dropOnEmpty: true, containment: sections,
		onUpdate:function(sortable) {new Ajax.Request('/admin/faqs/resort', {asynchronous:true, evalScripts:true, parameters:Sortable.serialize('faqs')})}
		});
	<? } ?>
	*/
</script>


